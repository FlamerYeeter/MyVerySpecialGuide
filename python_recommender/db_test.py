"""Small helper to test Oracle connectivity and show lightweight table counts.

This script performs read-only checks against the three tables used by the
recommender service: MVSG_USER_GUARDIAN, MVSG_JOB_LISTINGS, MVSG_RECOMMENDATION.

It intentionally prints results and catches exceptions instead of raising so
you can debug environment and credential issues safely.

Usage (PowerShell):
    C:/xampp/htdocs/MyVerySpecialGuide/.venv/Scripts/python.exe python_recommender/db_test.py
"""
import traceback
from db import fetch_table


def sample_count(query):
    try:
        df = fetch_table(query)
        if df is None:
            return None
        return len(df)
    except Exception as e:
        print(f"Error fetching '{query}': {e}")
        traceback.print_exc()
        return None


def main():
    print("Running DB connectivity checks (read-only)...")
    queries = [
        ("users", "SELECT * FROM MVSG_USER_GUARDIAN WHERE ROWNUM <= 5"),
        ("jobs", "SELECT * FROM MVSG_JOB_LISTINGS WHERE ROWNUM <= 5"),
        ("interactions", "SELECT * FROM MVSG_RECOMMENDATION WHERE ROWNUM <= 10"),
    ]

    for name, q in queries:
        print(f"\nQuerying {name}: {q}")
        cnt = sample_count(q)
        print(f"Result rows: {cnt}")


if __name__ == "__main__":
    main()
