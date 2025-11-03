"""Inspect the pivot and intermediate values used by collaborative_item_based."""
import sys
import json

from .db import fetch_table
from .recommender_collab import _seed_interactions_from_cbf


def run(user_id=7):
    users = fetch_table("SELECT * FROM MVSG.USER_GUARDIAN")
    jobs = fetch_table("SELECT * FROM MVSG.JOB_LISTINGS")
    seed = _seed_interactions_from_cbf(user_id, users, jobs, top_k=10)
    out = {}
    out['seed_dtypes'] = seed.dtypes.apply(lambda x: str(x)).to_dict()
    out['seed_sample'] = seed.head(10).to_dict(orient='records')

    interactions = seed.rename(columns={c: c.upper() for c in seed.columns})
    score_col = 'FIT_SCORE' if 'FIT_SCORE' in interactions.columns else interactions.columns[-1]
    out['score_col'] = score_col
    pivot = interactions.pivot_table(index='USER_ID', columns='JOB_ID', values=score_col, fill_value=0)
    out['pivot_shape'] = getattr(pivot, 'shape', None)
    try:
        pivot.index = pivot.index.astype(int)
        pivot.columns = pivot.columns.astype(int)
    except Exception:
        pass
    out['pivot_index'] = list(pivot.index)
    uid = int(user_id)
    out['user_id_cast'] = uid
    out['user_in_pivot'] = uid in pivot.index
    if uid in pivot.index:
        user_jobs = pivot.loc[uid]
        out['user_jobs_dtype'] = str(user_jobs.dtype)
        out['user_jobs_sample'] = user_jobs.head(20).to_dict()
        interacted = user_jobs[user_jobs > 0].index
        out['interacted_count'] = len(interacted)
        out['interacted_sample'] = list(interacted)[:20]
    else:
        out['user_jobs'] = None

    with open('debug_collab_inspect_output.json', 'w', encoding='utf-8') as fh:
        json.dump(out, fh, indent=2)
    print('Wrote debug_collab_inspect_output.json')


if __name__ == '__main__':
    uid = 7
    if len(sys.argv) > 1:
        try:
            uid = int(sys.argv[1])
        except Exception:
            pass
    run(uid)
