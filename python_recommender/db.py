import os
import pandas as pd

# Prefer the newer 'oracledb' package (thin mode possible) but fall back to cx_Oracle
try:
    import oracledb as oracle_driver  # type: ignore
except Exception:
    try:
        import cx_Oracle as oracle_driver  # type: ignore
    except Exception:
        oracle_driver = None


def _build_dsn(host: str, port: int, service: str):
    """Create a DSN string compatible with the available driver.

    - If the driver exposes makedsn, use it (cx_Oracle / oracledb compatibility).
    - Else fall back to simple host:port/service_name string (works with oracledb thin).
    """
    if oracle_driver is None:
        return f"{host}:{port}/{service}"

    makedsn = getattr(oracle_driver, "makedsn", None)
    if callable(makedsn):
        try:
            # both cx_Oracle.makedsn and oracledb.makedsn accept service_name kw
            return makedsn(host, port, service_name=service)
        except TypeError:
            return makedsn(host, port, service)

    # fallback
    return f"{host}:{port}/{service}"


def get_connection():
    """Establish an Oracle connection using environment variables with sensible defaults.

    Defaults are taken from the repository's `public/db/oracledb.php` but we DO NOT
    read/modify that file — these are just safe defaults.
    """
    host = os.environ.get("ORACLE_HOST", "103.38.251.55")
    port = int(os.environ.get("ORACLE_PORT", 1521))
    service = os.environ.get("ORACLE_SERVICE", "APXPDB")
    user = os.environ.get("ORACLE_USER", "MVSG")
    password = os.environ.get("ORACLE_PASSWORD", "MICA@PASSWORD123!")

    dsn = _build_dsn(host, port, service)

    if oracle_driver is None:
        raise RuntimeError("No Oracle driver available. Install 'oracledb' or 'cx_Oracle'.")

    # oracledb in thin mode accepts a host:port/service string as dsn; cx_Oracle prefers makedsn output
    conn = oracle_driver.connect(user=user, password=password, dsn=dsn)
    return conn


def fetch_table(query):
    """Run a query and return a pandas DataFrame."""
    conn = get_connection()
    try:
        df = pd.read_sql(query, conn)
    finally:
        try:
            conn.close()
        except Exception:
            pass

    return df


def write_recommendations(user_id, recs, score_field=None):
    """Persist recommendation rows into MVSG_RECOMMENDATION.

    - user_id: integer user identifier
    - recs: iterable of dict-like objects containing at least job ID and score
    - score_field: optional key name to pull the score from each rec (e.g. 'cbf_score' or 'cf_score')

    This function will attempt to insert rows (USER_ID, JOB_ID, FIT_SCORE).
    It is intentionally forgiving: on any error it raises an exception, but
    callers may choose to ignore failures.
    """
    if oracle_driver is None:
        raise RuntimeError("No Oracle driver available. Install 'oracledb' or 'cx_Oracle'.")

    rows = []
    for r in recs:
        # support both uppercase/lowercase keys
        job_id = r.get("ID") if isinstance(r, dict) else None
        if job_id is None:
            # try variations
            job_id = r.get("Id") if isinstance(r, dict) else job_id
        try:
            job_id = int(job_id)
        except Exception:
            continue

        score = 0.0
        if score_field and isinstance(r, dict):
            score = float(r.get(score_field, 0.0) or 0.0)
        else:
            # fallback to known fields
            for k in ("cbf_score", "cf_score", "FIT_SCORE"):
                if isinstance(r, dict) and k in r:
                    try:
                        score = float(r.get(k) or 0.0)
                        break
                    except Exception:
                        score = 0.0

        rows.append((int(user_id), job_id, float(score)))

    if not rows:
        return 0

    conn = get_connection()
    try:
        cursor = conn.cursor()
        # Use parameterized query to avoid injection and let the DB handle types
        sql = "INSERT INTO MVSG_RECOMMENDATION (USER_ID, JOB_ID, FIT_SCORE) VALUES (:1, :2, :3)"
        cursor.executemany(sql, rows)
        conn.commit()
        return cursor.rowcount
    finally:
        try:
            cursor.close()
        except Exception:
            pass
        try:
            conn.close()
        except Exception:
            pass
