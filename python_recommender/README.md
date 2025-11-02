# MVSG Python Recommender Service

This folder contains a lightweight FastAPI service that queries Oracle and returns
two separate recommendation lists: content-based and collaborative.

Files:

- `db.py` — Oracle connection helper using `cx_Oracle` and `pandas.read_sql`.
- `recommender_content.py` — TF-IDF content-based recommender.
- `recommender_collab.py` — Item–item collaborative recommender using interactions.
- `app.py` — FastAPI app exposing `/recommend/{user_id}`.
- `requirements.txt` — Python packages.

Quick start (after installing Oracle Instant Client and Python packages):

```powershell
python -m pip install -r requirements.txt
uvicorn app:app --reload --port 8001
```

The service will be available at `http://127.0.0.1:8001/recommend/{user_id}`.

Environment variables (optional):

- `ORACLE_HOST` (default: 103.38.251.55)
- `ORACLE_PORT` (default: 1521)
- `ORACLE_SERVICE` (default: APXPDB)
- `ORACLE_USER` (default: MVSG)
- `ORACLE_PASSWORD` (default: MICA@PASSWORD123!)

Notes:

- This service intentionally does not persist recommendations back to Oracle. If
  you want persistence, I can add an optional `persist=true` flag that writes
  top recommendations into `MVSG_RECOMMENDATION`.
