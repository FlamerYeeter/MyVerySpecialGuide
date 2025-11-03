import pandas as pd
from python_recommender.recommender_collab import _multi_user_seed


def make_jobs(n=50):
    rows = []
    for i in range(n):
        jid = 1000 + i
        rows.append({"ID": jid, "TITLE": f"Job {i}", "DESCRIPTION": f"This is job {i} description"})
    return pd.DataFrame(rows)


def make_users(n=50):
    return pd.DataFrame({"ID": list(range(1, n + 1)), "SKILLS": ["python developer"] * n})


def test_multi_user_seed_deterministic():
    users = make_users(50)
    jobs = make_jobs(50)

    df1 = _multi_user_seed(users, jobs, sample_n=10, top_k=5, score=0.5, context_text=None, random_state=123)
    df2 = _multi_user_seed(users, jobs, sample_n=10, top_k=5, score=0.5, context_text=None, random_state=123)

    # sort for stable comparison
    s1 = df1.sort_values(["USER_ID", "JOB_ID"]).reset_index(drop=True)
    s2 = df2.sort_values(["USER_ID", "JOB_ID"]).reset_index(drop=True)

    assert s1.equals(s2), "Multi-user seed should be deterministic with the same random_state"
