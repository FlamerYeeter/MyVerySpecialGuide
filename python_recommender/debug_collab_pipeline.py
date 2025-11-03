"""Run the internal item-item pipeline steps and save intermediate outputs."""
import json
import sys

from .db import fetch_table
from .recommender_collab import _seed_interactions_from_cbf
from sklearn.metrics.pairwise import cosine_similarity
import pandas as pd


def run(user_id=7, top_n=10):
    users = fetch_table("SELECT * FROM MVSG.USER_GUARDIAN")
    jobs = fetch_table("SELECT * FROM MVSG.JOB_LISTINGS")
    seed = _seed_interactions_from_cbf(user_id, users, jobs, top_k=10)

    interactions = seed.rename(columns={c: c.upper() for c in seed.columns})
    score_col = 'FIT_SCORE' if 'FIT_SCORE' in interactions.columns else interactions.columns[-1]
    pivot = interactions.pivot_table(index='USER_ID', columns='JOB_ID', values=score_col, fill_value=0)
    try:
        pivot.index = pivot.index.astype(int)
        pivot.columns = pivot.columns.astype(int)
    except Exception:
        pass

    sim = cosine_similarity(pivot.T)
    sim_df = pd.DataFrame(sim, index=pivot.columns, columns=pivot.columns)

    user_jobs = pivot.loc[int(user_id)]
    interacted = user_jobs[user_jobs > 0].index

    scores = sim_df[interacted].mean(axis=1).drop(index=interacted, errors='ignore')
    top_jobs = scores.sort_values(ascending=False).head(top_n)

    out = {
        'sim_shape': sim.shape,
        'sim_df_head': sim_df.iloc[:5, :5].values.tolist(),
        'interacted': list(interacted),
        'top_jobs_index': list(top_jobs.index),
        'top_jobs_scores': top_jobs.head(20).to_dict(),
    }

    # which job rows match
    matched = jobs[jobs['ID'].isin(top_jobs.index)].head(20).to_dict(orient='records')
    out['matched_count'] = len(matched)
    out['matched_sample'] = matched

    with open('debug_collab_pipeline_output.json', 'w', encoding='utf-8') as fh:
        json.dump(out, fh, indent=2)
    print('Wrote debug_collab_pipeline_output.json')


if __name__ == '__main__':
    uid = 7
    if len(sys.argv) > 1:
        try:
            uid = int(sys.argv[1])
        except Exception:
            pass
    run(uid)
