import pandas as pd
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.feature_extraction.text import TfidfVectorizer


def _safe_text(row, fields):
    parts = []
    for f in fields:
        v = row.get(f, "")
        if pd.isna(v):
            v = ""
        parts.append(str(v))
    return " ".join(parts)


def content_based_recommendation(user_id, users_df, jobs_df, top_n=10, context_text: str = None):
    """
    Simple TF-IDF content-based recommender.

    - users_df: DataFrame containing user profiles (expects column 'ID')
    - jobs_df: DataFrame containing jobs (expects 'ID', 'TITLE', 'DESCRIPTION', 'REQUIRED_SKILLS')
    Returns top_n job records with an added 'cbf_score' float.
    """
    if users_df is None or users_df.empty:
        return []

    user_rows = users_df[users_df["ID"] == user_id]
    if user_rows.empty:
        return []

    user = user_rows.iloc[0]

    # build user text from some likely fields (safe-guarding missing columns)
    user_text = _safe_text(user, [
        "SKILLS",
        "WORK_EXPERIENCE",
        "PREFERRED_ENVIRONMENT",
        "JOB_PREFERENCE",
        "CERTIFICATE",
    ])
    # append optional context text (free-form) to bias recommendations
    if context_text:
        try:
            user_text = f"{user_text} {str(context_text)}"
        except Exception:
            pass

    # job text
    def job_text(row):
        return _safe_text(row, ["TITLE", "DESCRIPTION", "REQUIRED_SKILLS", "COMPANY_NAME", "INDUSTRY"])

    jobs_copy = jobs_df.copy()
    jobs_copy["_text"] = jobs_copy.apply(job_text, axis=1)

    if jobs_copy["_text"].isnull().all():
        return []

    tfidf = TfidfVectorizer(stop_words="english")
    job_matrix = tfidf.fit_transform(jobs_copy["_text"].fillna(""))
    user_vec = tfidf.transform([user_text])

    scores = cosine_similarity(user_vec, job_matrix).flatten()

    jobs_copy["cbf_score"] = scores
    ranked = jobs_copy.sort_values("cbf_score", ascending=False).head(top_n)

    # drop helper column
    ranked = ranked.drop(columns=["_text"], errors="ignore")

    return ranked.to_dict(orient="records")
