#!/usr/bin/env python3
"""
Quick test runner for the recommender modules.

1) Tests content-based and collaborative recommenders with small mock DataFrames.
2) Verifies whether `db.fetch_table` would try to open an Oracle connection by
   monkeypatching `db.get_connection` and calling `db.fetch_table`.

Run this from the repository root (it will use relative imports):
    python python_recommender/test_run_recommenders.py

This script is intentionally dependency-light for the unit tests (pandas + sklearn)
and will not attempt to contact a real Oracle DB unless you remove the monkeypatch.
"""
import os
import sys
import pandas as pd
import traceback

# Ensure the local `python_recommender` package path is available so imports work
# when running this script from the repository root.
sys.path.insert(0, os.path.join(os.getcwd(), "python_recommender"))

from recommender_content import content_based_recommendation
from recommender_collab import collaborative_item_based


def make_mock_data():
    users = pd.DataFrame([
        {
            "ID": 1,
            "SKILLS": "python sql pandas",
            "WORK_EXPERIENCE": "3 years data analysis",
            "PREFERRED_ENVIRONMENT": "remote",
        },
        {
            "ID": 2,
            "SKILLS": "java spring sql",
            "WORK_EXPERIENCE": "5 years backend",
        },
    ])

    jobs = pd.DataFrame([
        {"ID": 101, "TITLE": "Data Analyst", "DESCRIPTION": "Work with data, python, pandas", "REQUIRED_SKILLS": "python,pandas,sql", "COMPANY_NAME":"Acme", "INDUSTRY":"Tech"},
        {"ID": 102, "TITLE": "Backend Developer", "DESCRIPTION": "Java, Spring Boot", "REQUIRED_SKILLS": "java,spring", "COMPANY_NAME":"Beta", "INDUSTRY":"Tech"},
        {"ID": 103, "TITLE": "Business Analyst", "DESCRIPTION": "SQL, reporting", "REQUIRED_SKILLS": "sql,excel", "COMPANY_NAME":"Gamma", "INDUSTRY":"Finance"},
    ])

    interactions = pd.DataFrame([
        {"USER_ID": 1, "JOB_ID": 101, "FIT_SCORE": 1.0},
        {"USER_ID": 2, "JOB_ID": 102, "FIT_SCORE": 1.0},
        {"USER_ID": 1, "JOB_ID": 103, "FIT_SCORE": 0.2},
    ])

    return users, jobs, interactions


def test_content_based():
    users, jobs, _ = make_mock_data()
    print("\n=== Content-based recommender test ===")
    res = content_based_recommendation(1, users, jobs, top_n=3)
    print(f"Returned {len(res)} items")
    for r in res:
        print(f"ID={r.get('ID')} TITLE={r.get('TITLE')} cbf_score={r.get('cbf_score'):.4f}")


def test_collaborative():
    users, jobs, interactions = make_mock_data()
    print("\n=== Collaborative recommender test ===")
    res = collaborative_item_based(1, jobs, interactions, top_n=3)
    print(f"Returned {len(res)} items")
    for r in res:
        print(f"ID={r.get('ID')} TITLE={r.get('TITLE')} cf_score={r.get('cf_score')}")


def test_db_call_detection():
    """Monkeypatch db.get_connection to detect whether fetch_table tries to open a DB.

    We do NOT connect to Oracle here. Instead we replace get_connection with a
    function that signals it was invoked and then raises a sentinel exception.
    """
    print("\n=== DB fetch_table call detection ===")
    try:
        # If cx_Oracle isn't installed in this environment (likely), importing db
        # fails at the top-level import. Inject a fake cx_Oracle into sys.modules
        # so that `import db` succeeds and we can detect connect attempts.
        import types

        fake_cx = types.SimpleNamespace()

        def fake_makedsn(host, port, service_name=None):
            return f"{host}:{port}/{service_name}"

        def fake_connect(*args, **kwargs):
            # signal that connect was attempted
            raise RuntimeError("FAKE_CX_ORACLE_CONNECT_CALLED")

        fake_cx.makedsn = fake_makedsn
        fake_cx.connect = fake_connect

        # install temporary fake module
        prev = sys.modules.get("cx_Oracle")
        sys.modules["cx_Oracle"] = fake_cx

        try:
            import db

            try:
                _ = db.fetch_table("SELECT 1 FROM DUAL")
            except Exception as e:
                if str(e).find("FAKE_CX_ORACLE_CONNECT_CALLED") >= 0:
                    print("db.fetch_table attempted to open an Oracle connection (detected via fake cx_Oracle).")
                else:
                    print("db.fetch_table raised an unexpected exception:", repr(e))
        finally:
            # restore cx_Oracle to its previous state
            if prev is not None:
                sys.modules["cx_Oracle"] = prev
            else:
                del sys.modules["cx_Oracle"]

    except Exception:
        print("Error when attempting DB-call detection:")
        traceback.print_exc()


if __name__ == "__main__":
    # run tests
    test_content_based()
    test_collaborative()
    test_db_call_detection()
