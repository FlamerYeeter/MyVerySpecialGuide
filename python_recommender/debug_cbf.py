"""Run and save content-based recommendations for a single user for inspection."""
import json
import sys

from .db import fetch_table
from .recommender_content import content_based_recommendation


def run(user_id=7, top_n=10):
    users = fetch_table("SELECT * FROM MVSG.USER_GUARDIAN")
    jobs = fetch_table("SELECT * FROM MVSG.JOB_LISTINGS")
    cbf = content_based_recommendation(user_id, users, jobs, top_n=top_n)
    out = {"cbf_len": len(cbf) if cbf else 0, "sample": cbf[:10]}
    with open("debug_cbf_output.json", "w", encoding="utf-8") as fh:
        json.dump(out, fh, indent=2)
    print("Wrote debug_cbf_output.json")


if __name__ == "__main__":
    uid = 7
    if len(sys.argv) > 1:
        try:
            uid = int(sys.argv[1])
        except Exception:
            pass
    run(user_id=uid)
