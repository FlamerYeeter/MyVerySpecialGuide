import pandas as pd
import numpy as np
from sklearn.metrics.pairwise import cosine_similarity


def _seed_interactions_from_cbf(user_id, users_df, jobs_df, top_k=5, score=0.5):
    """Return a small DataFrame of synthetic interactions (USER_ID, JOB_ID, FIT_SCORE)
    created from content-based recommendations for the given user.

    This is a best-effort helper used when the target user has no real
    interactions. It keeps the collaborative pipeline working without
    persisting anything to the DB.
    """
    try:
        # import here to avoid circular imports at module import time
        from .recommender_content import content_based_recommendation
    except Exception:
        return pd.DataFrame(columns=["USER_ID", "JOB_ID", "FIT_SCORE"])

    cbf = content_based_recommendation(user_id, users_df, jobs_df, top_n=top_k)
    # debug: report cbf length when seeding
    try:
        print(f"_seed_interactions_from_cbf: cbf_len={len(cbf) if cbf else 0}")
    except Exception:
        pass
    if not cbf:
        return pd.DataFrame(columns=["USER_ID", "JOB_ID", "FIT_SCORE"])

    rows = []
    for r in cbf:
        job_id = r.get("ID") if isinstance(r, dict) else None
        try:
            job_id = int(job_id)
        except Exception:
            continue
        rows.append({"USER_ID": int(user_id), "JOB_ID": job_id, "FIT_SCORE": float(score)})

    return pd.DataFrame(rows)


def _multi_user_seed(users_df, jobs_df, sample_n=30, top_k=5, score=0.5, context_text=None, random_state: int = None):
    """Build a synthetic interactions DataFrame by running CBF for many users.

    Returns a DataFrame with columns USER_ID, JOB_ID, FIT_SCORE.
    """
    try:
        from .recommender_content import content_based_recommendation
    except Exception:
        return pd.DataFrame(columns=["USER_ID", "JOB_ID", "FIT_SCORE"])

    if users_df is None or users_df.empty:
        return pd.DataFrame(columns=["USER_ID", "JOB_ID", "FIT_SCORE"])

    # sample users (deterministic slice if sample_n >= len(users_df))
    if sample_n is None or sample_n <= 0:
        sample_n = min(50, len(users_df))
    if sample_n >= len(users_df):
        sample = users_df
    else:
        # allow passing an int random_state for reproducible sampling
        sample = users_df.sample(n=sample_n, random_state=random_state)

    rows = []
    for uid in sample["ID"].tolist():
        try:
            cbf = content_based_recommendation(uid, users_df, jobs_df, top_n=top_k, context_text=context_text)
        except Exception:
            cbf = []
        if not cbf:
            continue
        for r in cbf:
            jid = r.get("ID") if isinstance(r, dict) else None
            try:
                jid = int(jid)
            except Exception:
                continue
            rows.append({"USER_ID": int(uid), "JOB_ID": jid, "FIT_SCORE": float(score)})

    if not rows:
        return pd.DataFrame(columns=["USER_ID", "JOB_ID", "FIT_SCORE"])
    return pd.DataFrame(rows)


def collaborative_item_based(user_id, jobs_df, interactions_df, users_df=None, top_n=10, seed_with_cbf=True, cbf_top_k=5, multi_user_seed=False, multi_seed_sample_n=30, multi_seed_top_k=5, multi_seed_score=0.5, context_text=None, random_state: int = None):
    """
    Item-item collaborative filtering based on a interactions table.

    - interactions_df: expects columns USER_ID, JOB_ID, FIT_SCORE (or other numeric)
    - jobs_df: expects column ID
    """
    meta = {
        "multi_seed_used": False,
        "synthetic_rows": 0,
        "real_interactions": 0,
        "cf_candidate_count": 0,
        "fallback_used": False,
    }

    if interactions_df is None or interactions_df.empty:
        # No interactions at all; attempt to seed
        if multi_user_seed and users_df is not None:
            interactions_df = _multi_user_seed(users_df, jobs_df, sample_n=multi_seed_sample_n, top_k=multi_seed_top_k, score=multi_seed_score, context_text=context_text, random_state=random_state)
            meta["multi_seed_used"] = True
        elif seed_with_cbf and users_df is not None:
            interactions_df = _seed_interactions_from_cbf(user_id, users_df, jobs_df, top_k=cbf_top_k)
        else:
            return [], meta

    # normalize column names to expected ones (case-insensitive)
    interactions = interactions_df.rename(columns={c: c.upper() for c in interactions_df.columns})
    # ensure required columns exist
    if not {"USER_ID", "JOB_ID"}.issubset(set(interactions.columns)):
        return []

    score_col = "FIT_SCORE" if "FIT_SCORE" in interactions.columns else interactions.columns[-1]

    try:
        meta["real_interactions"] = 0 if interactions_df is None else int(interactions_df.shape[0])
    except Exception:
        pass

    pivot = interactions.pivot_table(index="USER_ID", columns="JOB_ID", values=score_col, fill_value=0)

    # Ensure pivot index/columns are integer-like when possible so membership
    # checks (user_id in pivot.index) behave consistently across DB dtypes.
    try:
        pivot.index = pivot.index.astype(int)
    except Exception:
        pass
    try:
        pivot.columns = pivot.columns.astype(int)
    except Exception:
        pass
    # normalize user_id type for membership tests
    try:
        user_id = int(user_id)
    except Exception:
        pass

    # If the user doesn't appear in the interaction pivot, try a fallback:
    # 1) convert to binary interactions (implicit)
    # 2) seed from CBF if available
    if user_id not in pivot.index:
        # attempt binary fallback
        if (pivot.values > 0).sum() > 0:
            pivot = (pivot > 0).astype(float)
        # re-check
        if user_id not in pivot.index:
            # seed from CBF if requested and users_df provided
            if seed_with_cbf and users_df is not None:
                synth = _seed_interactions_from_cbf(user_id, users_df, jobs_df, top_k=cbf_top_k)
                if not synth.empty:
                    interactions = pd.concat([interactions, synth], ignore_index=True)
                    pivot = interactions.pivot_table(index="USER_ID", columns="JOB_ID", values=score_col, fill_value=0)
            if user_id not in pivot.index:
                return [], meta

    # job-job similarity
    sim = cosine_similarity(pivot.T)
    sim_df = pd.DataFrame(sim, index=pivot.columns, columns=pivot.columns)

    user_jobs = pivot.loc[user_id]
    interacted = user_jobs[user_jobs > 0].index

    if len(interacted) == 0:
        return [], meta

    # mean similarity to interacted jobs
    scores = sim_df[interacted].mean(axis=1).drop(index=interacted, errors="ignore")
    top_jobs = scores.sort_values(ascending=False).head(top_n)

    meta["cf_candidate_count"] = int(top_jobs.shape[0])

    # If there are no candidate items (e.g. we only have seed rows for this
    # single user), fall back to content-based results so cold users still
    # receive useful recommendations.
    if top_jobs.empty:
        try:
            from .recommender_content import content_based_recommendation

            cbf = content_based_recommendation(user_id, users_df, jobs_df, top_n=top_n, context_text=context_text)
            if cbf:
                # map cbf scores to cf_score for compatibility
                for r in cbf:
                    r["cf_score"] = r.get("cbf_score", 0)
                meta["fallback_used"] = True
                return cbf, meta
        except Exception:
            pass
        return [], meta

    result = jobs_df[jobs_df["ID"].isin(top_jobs.index)].copy()
    result["cf_score"] = result["ID"].map(top_jobs)
    out = result.sort_values("cf_score", ascending=False).to_dict(orient="records")
    try:
        meta["synthetic_rows"] = 0 if interactions_df is None else int(interactions_df.shape[0])
    except Exception:
        pass
    return out, meta
