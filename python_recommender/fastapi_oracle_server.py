import os
import traceback
from typing import Optional
from fastapi import FastAPI, HTTPException
from fastapi.responses import JSONResponse
import pandas as pd

app = FastAPI(title="Recommender Oracle Test API")

# Configuration via environment variables
ORACLE_USER = os.environ.get('ORACLE_USER')
ORACLE_PASS = os.environ.get('ORACLE_PASS')
ORACLE_DSN = os.environ.get('ORACLE_DSN')  # e.g. host:port/service_name or full TNS
ORACLE_CLIENT_LIB_DIR = os.environ.get('ORACLE_CLIENT_LIB_DIR')  # optional path to Instant Client
ORACLE_JOBS_SQL = os.environ.get('ORACLE_JOBS_SQL')
ORACLE_USERS_SQL = os.environ.get('ORACLE_USERS_SQL')

# Import lazy (so server can start even if driver missing; endpoints will return helpful errors)
_oracledb = None
_cx_oracle = None
_conn = None
_driver_name = None

# Try modern 'oracledb' first, fall back to 'cx_Oracle' if present
try:
    import oracledb as _oracledb
    _driver_name = 'oracledb'
except Exception:
    try:
        import cx_Oracle as _cx_oracle
        _driver_name = 'cx_Oracle'
    except Exception:
        _oracledb = None
        _cx_oracle = None
        _driver_name = None

# Import recommender functions from the python_recommender package
try:
    from recommender_collab import collaborative_item_based
    from recommender_content import content_based_recommendation
except Exception:
    # allow import errors to bubble later when endpoint is used
    collaborative_item_based = None
    content_based_recommendation = None


def get_oracle_connection():
    global _oracledb, _conn
    if _conn:
        return _conn
    if _driver_name is None:
        raise RuntimeError('No Oracle driver available. Install python-oracledb or cx_Oracle and ensure Instant Client is available if required.')

    if not (ORACLE_USER and ORACLE_PASS and ORACLE_DSN):
        raise RuntimeError('ORACLE_USER, ORACLE_PASS and ORACLE_DSN environment variables must be set to connect to Oracle')

    try:
        if _driver_name == 'oracledb':
            # Attempt to init client if requested (optional)
            if ORACLE_CLIENT_LIB_DIR:
                try:
                    _oracledb.init_oracle_client(lib_dir=ORACLE_CLIENT_LIB_DIR)
                except Exception:
                    pass
            _conn = _oracledb.connect(user=ORACLE_USER, password=ORACLE_PASS, dsn=ORACLE_DSN)
        else:
            # cx_Oracle connection
            _conn = _cx_oracle.connect(ORACLE_USER, ORACLE_PASS, ORACLE_DSN)
        return _conn
    except Exception as e:
        raise RuntimeError(f'Failed to connect to Oracle ({_driver_name}): {e}')


def fetch_df_from_sql(sql: str):
    conn = get_oracle_connection()
    try:
        cur = conn.cursor()
        cur.execute(sql)
        cols = [d[0] for d in cur.description]
        rows = cur.fetchall()
        df = pd.DataFrame(rows, columns=cols)
        cur.close()
        return df
    except Exception as e:
        raise


DEFAULT_JOBS_SQLS = [
    "SELECT ID, TITLE, DESCRIPTION, REQUIRED_SKILLS, COMPANY_NAME, INDUSTRY FROM JOB_POSTINGS",
    "SELECT ID, TITLE, DESCRIPTION, REQUIRED_SKILLS, COMPANY_NAME, INDUSTRY FROM POSTINGS",
    "SELECT ID, TITLE, DESCRIPTION, REQUIRED_SKILLS, COMPANY_NAME, INDUSTRY FROM JOBS",
]

DEFAULT_USERS_SQLS = [
    "SELECT ID, SKILLS, WORK_EXPERIENCE, PREFERRED_ENVIRONMENT, JOB_PREFERENCE, CERTIFICATE FROM USERS",
    "SELECT ID, SKILLS, WORK_EXPERIENCE, PREFERRED_ENVIRONMENT, JOB_PREFERENCE, CERTIFICATE FROM USER_PROFILE",
    "SELECT ID, SKILLS, WORK_EXPERIENCE, PREFERRED_ENVIRONMENT, JOB_PREFERENCE, CERTIFICATE FROM RESUMES",
]


def load_jobs_df():
    # if explicit SQL provided, try it first
    if ORACLE_JOBS_SQL:
        try:
            return fetch_df_from_sql(ORACLE_JOBS_SQL)
        except Exception as e:
            raise RuntimeError(f'ORACLE_JOBS_SQL failed: {e}')

    last_err = None
    for s in DEFAULT_JOBS_SQLS:
        try:
            return fetch_df_from_sql(s)
        except Exception as e:
            last_err = e
    raise RuntimeError(f'No jobs table found or all queries failed. Last error: {last_err}')


def load_users_df():
    if ORACLE_USERS_SQL:
        try:
            return fetch_df_from_sql(ORACLE_USERS_SQL)
        except Exception as e:
            raise RuntimeError(f'ORACLE_USERS_SQL failed: {e}')

    last_err = None
    for s in DEFAULT_USERS_SQLS:
        try:
            return fetch_df_from_sql(s)
        except Exception as e:
            last_err = e
    raise RuntimeError(f'No users table found or all queries failed. Last error: {last_err}')


@app.get('/health')
def health():
    return {'ok': True, 'oracle_driver_installed': _oracledb is not None}


@app.get('/recs/{uid}')
def get_recommendations(uid: str, top_n: Optional[int] = 10, seed_with_cbf: Optional[bool] = True):
    """Fetch user and job data from Oracle, run the recommender, and return results.

    Environment variables expected:
    - ORACLE_USER, ORACLE_PASS, ORACLE_DSN
    - ORACLE_CLIENT_LIB_DIR (optional)
    - ORACLE_JOBS_SQL (optional) to override default job query
    - ORACLE_USERS_SQL (optional) to override default user query
    """
    # ensure recommender functions available
    if collaborative_item_based is None:
        raise HTTPException(status_code=500, detail='Recommender modules not importable. Ensure python_recommender package is on PYTHONPATH and dependencies installed.')

    try:
        jobs_df = load_jobs_df()
    except Exception as e:
        return JSONResponse(status_code=500, content={'error': 'jobs_load_failed', 'detail': str(e), 'trace': traceback.format_exc()})

    try:
        users_df = load_users_df()
    except Exception as e:
        # Users table optional: recommender will try to seed from CBF using users_df. If users_df unavailable, still attempt CF with empty interactions
        users_df = pd.DataFrame()

    # Normalize column names for recommender expectations
    jobs_df.columns = [c.upper() for c in jobs_df.columns]
    users_df.columns = [c.upper() for c in users_df.columns]

    # run collaborative recommender (it will seed with CBF if interactions empty and seed_with_cbf True)
    try:
        recs, meta = collaborative_item_based(uid, jobs_df, interactions_df=pd.DataFrame(columns=["USER_ID", "JOB_ID", "FIT_SCORE"]), users_df=users_df if not users_df.empty else None, top_n=top_n, seed_with_cbf=seed_with_cbf)
    except Exception as e:
        return JSONResponse(status_code=500, content={'error': 'recommender_failed', 'detail': str(e), 'trace': traceback.format_exc()})

    return JSONResponse({'uid': uid, 'count': len(recs), 'recs': recs, 'meta': meta})
