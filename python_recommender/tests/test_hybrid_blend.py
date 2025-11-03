import pandas as pd
from python_recommender.recommender_content import content_based_recommendation
from python_recommender.recommender_collab import collaborative_item_based


def make_jobs():
    return pd.DataFrame([
        {"ID": 10, "TITLE": "Backend Python", "DESCRIPTION": "Python APIs"},
        {"ID": 11, "TITLE": "Remote Developer", "DESCRIPTION": "Remote work"},
        {"ID": 12, "TITLE": "Data Scientist", "DESCRIPTION": "ML and Python"},
    ])


def make_users():
    return pd.DataFrame([
        {"ID": 1, "SKILLS": "python remote"},
        {"ID": 2, "SKILLS": "data ml python"},
        {"ID": 3, "SKILLS": "frontend react"},
    ])


def test_hybrid_merge_produces_scores():
    users = make_users()
    jobs = make_jobs()

    cbf = content_based_recommendation(1, users, jobs, top_n=3, context_text="remote")
    cf, meta = collaborative_item_based(1, jobs, interactions_df=pd.DataFrame(columns=["USER_ID", "JOB_ID", "FIT_SCORE"]), users_df=users, top_n=3, multi_user_seed=True, multi_seed_sample_n=2, multi_seed_top_k=2, random_state=42)

    # Build maps similar to app blending logic
    cbf_map = {int(r.get("ID")): float(r.get("cbf_score", 0)) for r in (cbf or [])}
    cf_map = {int(r.get("ID")): float(r.get("cf_score", 0)) for r in (cf or [])}

    ids = set(list(cbf_map.keys()) + list(cf_map.keys()))
    merged = []
    alpha = 0.6
    for jid in ids:
        cscore = cf_map.get(jid, 0.0)
        ubscore = cbf_map.get(jid, 0.0)
        merged_score = alpha * cscore + (1.0 - alpha) * ubscore
        merged.append((jid, merged_score))

    assert len(merged) > 0
    # ensure scores are numeric
    for _, s in merged:
        assert isinstance(s, float)
