"""Directly exercise collaborative_item_based with a synthetic interactions DF
and print internal diagnostics so we can see why it returns empty.
"""
import json
import sys
import traceback

from .db import fetch_table
from .recommender_collab import collaborative_item_based, _seed_interactions_from_cbf


def run(user_id=7, top_n=10):
    users = fetch_table("SELECT * FROM MVSG.USER_GUARDIAN")
    jobs = fetch_table("SELECT * FROM MVSG.JOB_LISTINGS")
    interactions = fetch_table("SELECT * FROM MVSG.RECOMMENDATION")

    print('interactions.shape=', getattr(interactions, 'shape', None))
    seed = _seed_interactions_from_cbf(user_id, users, jobs, top_k=10)
    print('seed rows=', len(seed))

    # use seed explicitly
    interactions2 = seed.copy()
    cf = collaborative_item_based(user_id, jobs, interactions2, users_df=users, top_n=top_n)
    print('cf len with explicit seed =', len(cf) if cf is not None else None)
    with open('debug_collab_direct_output.json', 'w', encoding='utf-8') as fh:
        json.dump({'cf_len': len(cf) if cf is not None else None}, fh)
    print('Wrote debug_collab_direct_output.json')


if __name__ == '__main__':
    uid = 7
    if len(sys.argv) > 1:
        try:
            uid = int(sys.argv[1])
        except Exception:
            pass
    run(uid)
