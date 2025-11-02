import os
import cx_Oracle
import pandas as pd


def get_connection():
    """
    Establish an Oracle connection using environment variables with sensible defaults.
    Defaults are taken from the repository's `public/db/oracledb.php` but we DO NOT
    read/modify that file — these are just safe defaults.
    """
    host = os.environ.get("ORACLE_HOST", "103.38.251.55")
    port = int(os.environ.get("ORACLE_PORT", 1521))
    service = os.environ.get("ORACLE_SERVICE", "APXPDB")
    user = os.environ.get("ORACLE_USER", "MVSG")
    password = os.environ.get("ORACLE_PASSWORD", "MICA@PASSWORD123!")

    dsn = cx_Oracle.makedsn(host, port, service_name=service)
    conn = cx_Oracle.connect(user=user, password=password, dsn=dsn)
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
