import pandas as pd
from sklearn.metrics.pairwise import cosine_similarity


def collaborative_item_based(user_id, jobs_df, interactions_df, top_n=10):
    """
    Item-item collaborative filtering based on a interactions table.

    - interactions_df: expects columns USER_ID, JOB_ID, FIT_SCORE (or other numeric)
    - jobs_df: expects column ID
    """
    if interactions_df is None or interactions_df.empty:
        return []

    # normalize column names to expected ones (case-insensitive)
    interactions = interactions_df.rename(columns={c: c.upper() for c in interactions_df.columns})
    # ensure required columns exist
    if not {"USER_ID", "JOB_ID"}.issubset(set(interactions.columns)):
        return []

    score_col = "FIT_SCORE" if "FIT_SCORE" in interactions.columns else interactions.columns[-1]

    pivot = interactions.pivot_table(index="USER_ID", columns="JOB_ID", values=score_col, fill_value=0)

    if user_id not in pivot.index:
        return []

    # job-job similarity
    sim = cosine_similarity(pivot.T)
    sim_df = pd.DataFrame(sim, index=pivot.columns, columns=pivot.columns)

    user_jobs = pivot.loc[user_id]
    interacted = user_jobs[user_jobs > 0].index

    if len(interacted) == 0:
        return []

    # mean similarity to interacted jobs
    scores = sim_df[interacted].mean(axis=1).drop(index=interacted, errors="ignore")
    top_jobs = scores.sort_values(ascending=False).head(top_n)

    result = jobs_df[jobs_df["ID"].isin(top_jobs.index)].copy()
    result["cf_score"] = result["ID"].map(top_jobs)
    return result.sort_values("cf_score", ascending=False).to_dict(orient="records")
