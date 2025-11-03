from fastapi import FastAPI, HTTPException
from typing import Any
import os

from .db import fetch_table, write_recommendations
from .recommender_content import content_based_recommendation
from .recommender_collab import collaborative_item_based

app = FastAPI(title="MVSG Recommender")


@app.get("/recommend/{user_id}")
def recommend(user_id: int, top_n: int = 10) -> Any:
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

    cbf = content_based_recommendation(user_id, users, jobs, top_n=top_n)
    cf = collaborative_item_based(user_id, jobs, interactions, top_n=top_n)

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

    return {
        "content_based": cbf,
        "collaborative": cf,
    }
