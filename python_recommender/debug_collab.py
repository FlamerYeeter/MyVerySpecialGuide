"""Diagnostic runner for the collaborative recommender.

Run this with the project's venv Python to reproduce why collaborative
recommendations for a given user may be empty. It prints shapes, dtypes,
and whether synthetic seeding was used.
"""
import json
import sys
import traceback

from .db import fetch_table
from .recommender_collab import collaborative_item_based, _seed_interactions_from_cbf


def pretty(df, n=3):
    try:
        return df.head(n).to_dict(orient="records")
    except Exception:
        return str(type(df))


def run(user_id=7, top_n=10):
    try:
        users = fetch_table("SELECT * FROM MVSG.USER_GUARDIAN")
        jobs = fetch_table("SELECT * FROM MVSG.JOB_LISTINGS")
        interactions = fetch_table("SELECT * FROM MVSG.RECOMMENDATION")
    except Exception as e:
        print(f"DB fetch failed: {e}")
        traceback.print_exc()
        sys.exit(2)

    print("users.shape=", getattr(users, "shape", None))
    print("jobs.shape=", getattr(jobs, "shape", None))
    print("interactions.shape=", getattr(interactions, "shape", None))
    print("users.dtypes:\n", getattr(users, "dtypes", "<no dtypes>"))
    print("interactions.columns:", list(interactions.columns))

    # run collaborative recommender
    print('\nRunning collaborative_item_based...')
    cf = collaborative_item_based(user_id, jobs, interactions, users_df=users, top_n=top_n)
    print('collaborative result len=', len(cf) if cf is not None else None)

    # show synthetic seed if any
    try:
        seed = _seed_interactions_from_cbf(user_id, users, jobs, top_k=5)
        print('synthetic seed rows=', len(seed))
        if len(seed) > 0:
            print('synthetic seed sample:', pretty(seed, n=10))
    except Exception as e:
        print('seed generation failed:', e)

    out = {"users_shape": getattr(users, "shape", None), "jobs_shape": getattr(jobs, "shape", None), "interactions_shape": getattr(interactions, "shape", None), "cf_len": len(cf) if cf is not None else None}
    with open("debug_collab_output.json", "w", encoding="utf-8") as fh:
        json.dump(out, fh, indent=2)

    print('\nWrote debug_collab_output.json')


if __name__ == "__main__":
    uid = 7
    if len(sys.argv) > 1:
        try:
            uid = int(sys.argv[1])
        except Exception:
            pass
    run(user_id=uid)
