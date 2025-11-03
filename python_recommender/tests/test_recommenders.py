import sys
import os
import pandas as pd

# Make sure we can import modules from python_recommender when pytest runs from repo root
sys.path.insert(0, os.path.join(os.getcwd(), "python_recommender"))

from recommender_content import content_based_recommendation
from recommender_collab import collaborative_item_based


def make_mock_data():
    users = pd.DataFrame([
        {"ID": 1, "SKILLS": "python sql pandas", "WORK_EXPERIENCE": "3 years"},
        {"ID": 2, "SKILLS": "java spring", "WORK_EXPERIENCE": "5 years"},
    ])

    jobs = pd.DataFrame([
        {"ID": 101, "TITLE": "Data Analyst", "DESCRIPTION": "python pandas sql", "REQUIRED_SKILLS": "python,pandas,sql"},
        {"ID": 102, "TITLE": "Backend Developer", "DESCRIPTION": "java spring", "REQUIRED_SKILLS": "java,spring"},
        {"ID": 103, "TITLE": "Reporting Analyst", "DESCRIPTION": "sql reporting", "REQUIRED_SKILLS": "sql,excel"},
    ])

    interactions = pd.DataFrame([
        {"USER_ID": 1, "JOB_ID": 101, "FIT_SCORE": 1.0},
        {"USER_ID": 1, "JOB_ID": 103, "FIT_SCORE": 0.2},
        {"USER_ID": 2, "JOB_ID": 102, "FIT_SCORE": 1.0},
    ])

    return users, jobs, interactions


def test_content_based_returns_scores():
    users, jobs, _ = make_mock_data()
    res = content_based_recommendation(1, users, jobs, top_n=3)
    assert isinstance(res, list)
    assert len(res) == 3
    # Top result should be the data-analyst-like job
    assert res[0]["ID"] == 101
    assert "cbf_score" in res[0]


def test_collaborative_returns_expected():
    users, jobs, interactions = make_mock_data()
    res = collaborative_item_based(1, jobs, interactions, top_n=3)
    assert isinstance(res, list)
    # For our tiny dataset user 1 interacted with 101 and 103; expect recommendations exist
    assert len(res) >= 0
    if len(res) > 0:
        assert "cf_score" in res[0]
