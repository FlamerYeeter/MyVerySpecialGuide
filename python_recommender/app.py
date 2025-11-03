from fastapi import FastAPI, HTTPException, Query
from typing import Any, Optional
import os

from .db import fetch_table, write_recommendations
from .recommender_content import content_based_recommendation
from .recommender_collab import collaborative_item_based

app = FastAPI(title="MVSG Recommender")


@app.get("/recommend/{user_id}")
def recommend(
    user_id: int,
    top_n: int = 10,
    hybrid_alpha: float = Query(0.0, ge=0.0, le=1.0),
    fallback: str = Query("cbf"),
    multi_seed: bool = Query(True),
    multi_seed_n: int = Query(30, ge=1),
    multi_seed_k: int = Query(5, ge=1),
    context: Optional[str] = Query(None),
    random_state: Optional[int] = Query(None, description="Optional random seed for deterministic multi-user seeding"),
) -> Any:
    """Return two separate lists: content_based and collaborative recommendations.

    If the environment variable WRITE_RECS is set to '1', the service will
    attempt to persist the returned recommendations into the
    MVSG_RECOMMENDATION table (read-only by default).
    """
    try:
        # Use schema-qualified names (owner.table) so Oracle resolves the correct tables
        users = fetch_table("SELECT * FROM MVSG.USER_GUARDIAN")
        jobs = fetch_table("SELECT * FROM MVSG.JOB_LISTINGS")
        interactions = fetch_table("SELECT * FROM MVSG.RECOMMENDATION")
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"DB fetch failed: {e}")

    # content-based (context-aware)
    cbf = content_based_recommendation(user_id, users, jobs, top_n=top_n, context_text=context)

    # collaborative: allow in-memory multi-user seeding to handle cold-start sparsity
    cf, cf_meta = collaborative_item_based(
        user_id,
        jobs,
        interactions,
        users_df=users,
        top_n=top_n,
        seed_with_cbf=True,
        cbf_top_k=multi_seed_k,
        multi_user_seed=multi_seed,
        multi_seed_sample_n=multi_seed_n,
        multi_seed_top_k=multi_seed_k,
        multi_seed_score=0.5,
        context_text=context,
        random_state=random_state,
    )

    # build hybrid ranking (if hybrid_alpha > 0 and both cbf/cf exist)
    hybrid = []
    try:
        if hybrid_alpha and 0.0 < hybrid_alpha <= 1.0:
            # create lookup maps
            cbf_map = {int(r.get("ID")): float(r.get("cbf_score", 0)) for r in (cbf or [])}
            cf_map = {int(r.get("ID")): float(r.get("cf_score", 0)) for r in (cf or [])}
            ids = set(list(cbf_map.keys()) + list(cf_map.keys()))
            rows = []
            for jid in ids:
                cscore = cf_map.get(jid, 0.0)
                ubscore = cbf_map.get(jid, 0.0)
                merged = hybrid_alpha * cscore + (1.0 - hybrid_alpha) * ubscore
                rows.append({"ID": jid, "hybrid_score": merged, "cbf_score": ubscore, "cf_score": cscore})
            # enrich with job metadata from jobs DF
            if rows:
                jdf = jobs.copy()
                jdf = jdf.set_index("ID")
                out = []
                for r in sorted(rows, key=lambda x: x["hybrid_score"], reverse=True)[:top_n]:
                    meta = {}
                    try:
                        meta_row = jdf.loc[int(r["ID"])]
                        meta = meta_row.to_dict()
                    except Exception:
                        pass
                    meta.update({"hybrid_score": r["hybrid_score"], "cbf_score": r["cbf_score"], "cf_score": r["cf_score"]})
                    out.append(meta)
                hybrid = out
    except Exception:
        hybrid = []

    # Optionally persist recommendations back to Oracle for auditing/caching
    try:
        if os.environ.get("WRITE_RECS", "0") == "1":
            # write content-based recommendations (if any)
            if cbf:
                write_recommendations(user_id, cbf, score_field="cbf_score")
            # write collaborative recommendations (if any)
            if cf:
                write_recommendations(user_id, cf, score_field="cf_score")
    except Exception:
        # don't fail the request if persistence fails; log quietly
        import traceback

        traceback.print_exc()

    # Build a meta block for debug/telemetry
    meta = {
        "cbf_len": len(cbf) if cbf else 0,
        "cf_meta": cf_meta if isinstance(cf_meta, dict) else {},
    }

    return {
        "content_based": cbf,
        "collaborative": cf,
        "hybrid": hybrid,
        "meta": meta,
    }
