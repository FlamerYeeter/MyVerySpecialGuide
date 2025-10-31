#!/usr/bin/env python3
"""
Load a saved stacker model (pickle) and apply to public/recommendations.json.
Writes public/recommendations_stacker_rescored.json with 'stacker_score' field.
"""
import json
import pickle
from pathlib import Path

import numpy as np
import pandas as pd


def main():
    import argparse
    p = argparse.ArgumentParser()
    p.add_argument('--model', default='tools/stacker_model.pkl')
    p.add_argument('--input', default='public/recommendations.json')
    p.add_argument('--output', default='public/recommendations_stacker_rescored.json')
    args = p.parse_args()

    model_path = Path(args.model)
    reco_in = Path(args.input)
    reco_out = Path(args.output)

    with open(model_path, 'rb') as f:
        payload = pickle.load(f)
    clf = payload['model']
    score_cols = payload['score_cols']
    mins = np.array(payload['mins'], dtype=float)
    maxs = np.array(payload['maxs'], dtype=float)
    rng = maxs - mins
    rng[rng == 0] = 1.0

    with open(reco_in, 'r', encoding='utf-8') as f:
        recos = json.load(f)

    # Support both list and mapping (uid -> list) inputs
    target_list = None
    if isinstance(recos, list):
        target_list = recos
    elif isinstance(recos, dict):
        # find the first value that is a list of items
        for k, v in recos.items():
            if isinstance(v, list):
                target_list = v
                break
        if target_list is None:
            raise RuntimeError('No list of recommendations found in input JSON')

    # Build a DataFrame from target_list where possible
    rows = []
    for item in target_list:
        row = {c: item.get(c, 0.0) for c in score_cols}
        rows.append(row)
    df = pd.DataFrame(rows)

    # normalize
    X = df[score_cols].fillna(0).values.astype(float)
    Xn = (X - mins) / rng
    probs = clf.predict_proba(Xn)[:, 1]

    # write back to the target_list mapping
    for i, item in enumerate(target_list):
        item['stacker_score'] = float(probs[i])

    # If original was dict, ensure we place modified list back
    if isinstance(recos, dict):
        # we updated target_list in-place so recos already reflects changes
        pass

    reco_out.parent.mkdir(parents=True, exist_ok=True)
    with open(reco_out, 'w', encoding='utf-8') as f:
        json.dump(recos, f, indent=2)

    print('Wrote', reco_out)

if __name__ == '__main__':
    main()
