import os
import pytest

try:
    import cx_Oracle  # may be missing in test env
    CX_AVAILABLE = True
except Exception:
    CX_AVAILABLE = False

SKIP_REASON = "Set ORACLE_TEST=1 and install cx_Oracle + Oracle Instant Client to run integration tests"


@pytest.mark.skipif(os.environ.get("ORACLE_TEST") != "1" or not CX_AVAILABLE, reason=SKIP_REASON)
def test_fetch_tables_and_recommend_endpoint():
    """Integration test that uses the real Oracle DB via python_recommender.db.

    This will only run when ORACLE_TEST=1 and cx_Oracle is available. It
    performs a small fetch and calls the FastAPI endpoint to exercise the
    end-to-end path.
    """
    # import here so skip happens before attempting cx_Oracle usage in db.py
    from db import fetch_table

    # fetch small samples from each table used by the app
    users = fetch_table("SELECT * FROM MVSG_USER_GUARDIAN WHERE ROWNUM <= 5")
    jobs = fetch_table("SELECT * FROM MVSG_JOB_LISTINGS WHERE ROWNUM <= 5")
    interactions = fetch_table("SELECT * FROM MVSG_RECOMMENDATION WHERE ROWNUM <= 20")

    assert users is not None
    assert jobs is not None

    # call FastAPI endpoint
    from fastapi.testclient import TestClient
    from app import app

    client = TestClient(app)
    resp = client.get("/recommend/1")
    assert resp.status_code == 200
    data = resp.json()
    assert "content_based" in data and "collaborative" in data
