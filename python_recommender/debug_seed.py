"""Run the seeding helper directly and save its output for inspection."""
import json
import sys

from .db import fetch_table
from .recommender_collab import _seed_interactions_from_cbf


def run(user_id=7):
    users = fetch_table("SELECT * FROM MVSG.USER_GUARDIAN")
    jobs = fetch_table("SELECT * FROM MVSG.JOB_LISTINGS")
    seed = _seed_interactions_from_cbf(user_id, users, jobs, top_k=10)
    out = {"seed_rows": len(seed), "sample": seed.head(20).to_dict(orient="records")}
    with open("debug_seed_output.json", "w", encoding="utf-8") as fh:
        json.dump(out, fh, indent=2)
    print("Wrote debug_seed_output.json")


if __name__ == "__main__":
    uid = 7
    if len(sys.argv) > 1:
        try:
            uid = int(sys.argv[1])
        except Exception:
            pass
    run(uid)
