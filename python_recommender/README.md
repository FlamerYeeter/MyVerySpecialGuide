# MVSG Python Recommender Service

This folder contains a lightweight FastAPI service that queries Oracle and returns
two separate recommendation lists: content-based and collaborative.

Files:

- `db.py` — Oracle connection helper using `oracledb` (preferred) with fallback to `cx_Oracle`, and helper functions for read/write.
- `recommender_content.py` — TF-IDF content-based recommender.
- `recommender_collab.py` — Item–item collaborative recommender using interactions.
- `app.py` — FastAPI app exposing `/recommend/{user_id}`.
- `requirements.txt` — Python packages.

Quick start (after installing required Python packages). `oracledb` supports a thin mode that often
does not require Oracle Instant Client; for cx_Oracle you still need Instant Client.

Install packages (venv recommended):

```powershell
C:/path/to/venv/Scripts/python.exe -m pip install -r requirements.txt
# or specifically:
C:/path/to/venv/Scripts/python.exe -m pip install oracledb fastapi uvicorn pandas scikit-learn
```

Run the service:

```powershell
python -m pip install -r requirements.txt
uvicorn app:app --reload --port 8001
```

The service will be available at `http://127.0.0.1:8001/recommend/{user_id}`.

Environment variables (optional):

- `ORACLE_HOST` (default: empwrpath.com)
- `ORACLE_PORT` (default: 1521)
- `ORACLE_SERVICE` (default: APXPDB)
- `ORACLE_USER` (default: MVSG)
- `ORACLE_PASSWORD` (default: MICA@PASSWORD123!)

Persistence option:

- `WRITE_RECS=1` — when set, the FastAPI `/recommend/{user_id}` endpoint will attempt to
  persist top recommendations into `MVSG_RECOMMENDATION` (inserts USER_ID, JOB_ID, FIT_SCORE).
  This is optional and errors during persistence are logged but do not cause the request to fail.

Helper scripts:

- `db_test.py` — run this to perform safe, read-only checks against the three tables used by the
  recommender (users, jobs, interactions). Example:

```powershell
C:/path/to/venv/Scripts/python.exe python_recommender/db_test.py
```

Notes:

- The integration test `python_recommender/tests/test_oracle_integration.py` is gated by the
  environment variable `ORACLE_TEST=1` and will only run when `oracledb`/`cx_Oracle` is available.
- I intentionally avoided modifying any PHP files in `public/db`.

Notes:

- This service intentionally does not persist recommendations back to Oracle. If
  you want persistence, I can add an optional `persist=true` flag that writes
  top recommendations into `MVSG_RECOMMENDATION`.
