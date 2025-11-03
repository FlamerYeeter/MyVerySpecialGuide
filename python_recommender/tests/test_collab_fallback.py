import pandas as pd
from python_recommender.recommender_collab import collaborative_item_based


def make_jobs():
    return pd.DataFrame([
        {"ID": 1, "TITLE": "Python Dev", "DESCRIPTION": "Work with Python"},
        {"ID": 2, "TITLE": "Frontend Dev", "DESCRIPTION": "React and CSS"},
        {"ID": 3, "TITLE": "Data Engineer", "DESCRIPTION": "ETL and Big Data"},
    ])


def make_users():
    return pd.DataFrame([{"ID": 1, "SKILLS": "python data"}])


def test_collab_fallback_to_cbf():
    users = make_users()
    jobs = make_jobs()
    interactions = pd.DataFrame(columns=["USER_ID", "JOB_ID", "FIT_SCORE"])

    results, meta = collaborative_item_based(1, jobs, interactions, users_df=users, top_n=3, seed_with_cbf=True, cbf_top_k=2, multi_user_seed=False)

    # fallback should have been used when pure CF couldn't produce candidates
    assert isinstance(meta, dict)
    assert meta.get("fallback_used") is True
    assert isinstance(results, list)
    assert len(results) > 0
    # fallback maps cbf_score to cf_score for compatibility
    assert "cf_score" in results[0]
