#!/usr/bin/env python3
"""
Simple weight optimizer for ensemble scores.
Reads a CSV with columns: job_id,label,<score_columns...>
Performs randomized search over weight vectors (sum=1) and finds the best F1 and threshold on the validation file.
Saves best result to JSON (weights, threshold, metrics).

Usage:
  python tools/optimize_weights.py --scores tools/validation_scores.csv --out tools/best_weights.json --trials 2000 --seed 42
"""
import csv
import json
import math
import random
import sys
import argparse
from collections import defaultdict


def read_scores(path):
    with open(path, 'r', newline='', encoding='utf-8') as f:
        reader = csv.DictReader(f)
        rows = [r for r in reader]
    return rows


def to_float(v):
    try:
        return float(v)
    except Exception:
        return None


def normalize_columns(rows, cols):
    mins = {c: float('inf') for c in cols}
    maxs = {c: float('-inf') for c in cols}
    vals = {c: [] for c in cols}
    for r in rows:
        for c in cols:
            v = to_float(r.get(c, ''))
            if v is None:
                v = 0.0
            vals[c].append(v)
            if v < mins[c]: mins[c] = v
            if v > maxs[c]: maxs[c] = v
    normed = []
    for i in range(len(rows)):
        out = {}
        for c in cols:
            v = vals[c][i]
            lo = mins[c]
            hi = maxs[c]
            if hi > lo:
                out[c] = (v - lo) / (hi - lo)
            else:
                out[c] = 0.0
        normed.append(out)
    return normed, mins, maxs


def compute_f1_from_labels(y_true, y_pred):
    tp = sum(1 for a,b in zip(y_true,y_pred) if a==1 and b==1)
    fp = sum(1 for a,b in zip(y_true,y_pred) if a==0 and b==1)
    fn = sum(1 for a,b in zip(y_true,y_pred) if a==1 and b==0)
    prec = tp / (tp + fp) if (tp + fp) > 0 else 0.0
    rec = tp / (tp + fn) if (tp + fn) > 0 else 0.0
    f1 = (2 * prec * rec / (prec + rec)) if (prec + rec) > 0 else 0.0
    return {
        'tp': tp, 'fp': fp, 'fn': fn,
        'precision': prec, 'recall': rec, 'f1': f1
    }


def sweep_thresholds(scores, y_true):
    # scores: list of floats, y_true: list of 0/1
    best = {'f1': -1.0}
    unique_scores = sorted(set(scores))
    # try thresholds slightly below each unique score and also 0 and 1
    cand_thresholds = [0.0] + [(s - 1e-6) for s in unique_scores] + [1.0]
    for t in cand_thresholds:
        y_pred = [1 if s >= t else 0 for s in scores]
        m = compute_f1_from_labels(y_true, y_pred)
        if m['f1'] > best['f1']:
            best = {'threshold': t, 'metrics': m, 'f1': m['f1']}
    return best


def random_dirichlet_weights(k):
    # sample k positive numbers and normalize
    x = [random.random() ** 2 for _ in range(k)]
    s = sum(x)
    if s == 0:
        return [1.0/k] * k
    return [xi/s for xi in x]


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument('--scores', default='tools/validation_scores.csv')
    parser.add_argument('--out', default='tools/best_weights.json')
    parser.add_argument('--trials', type=int, default=2000)
    parser.add_argument('--seed', type=int, default=42)
    args = parser.parse_args()

    random.seed(args.seed)

    rows = read_scores(args.scores)
    if not rows:
        print('No rows found in', args.scores)
        sys.exit(1)

    # identify score columns (exclude job_id,label)
    header = rows[0].keys()
    score_cols = [c for c in header if c not in ('job_id','label')]
    if not score_cols:
        print('No score columns found. Expected columns like content_score,user_cf_score,...')
        sys.exit(1)

    # parse labels and raw scores
    y_true = []
    for r in rows:
        l = r.get('label','0')
        y_true.append(1 if str(l).strip() in ('1','true','True','yes','Yes') else 0)

    # normalize score columns
    normed_list, mins, maxs = normalize_columns(rows, score_cols)
    # build per-row vector of scores
    X = [[normed_list[i][c] for c in score_cols] for i in range(len(rows))]

    best_overall = {'f1': -1.0}
    best_details = None

    for trial in range(args.trials):
        weights = random_dirichlet_weights(len(score_cols))
        # compute weighted score per row
        scores = []
        for xi in X:
            s = sum(w * x for w,x in zip(weights, xi))
            scores.append(s)
        # find best threshold for these scores
        best = sweep_thresholds(scores, y_true)
        if best['f1'] > best_overall['f1']:
            best_overall = best
            best_details = {
                'weights': dict(zip(score_cols, [round(w,4) for w in weights])),
                'threshold': best['threshold'],
                'metrics': best['metrics'],
                'f1': best['f1']
            }
    if best_details is None:
        print('No improvement found')
        sys.exit(1)

    out = {
        'best': best_details,
        'score_columns': score_cols,
        'mins': mins,
        'maxs': maxs,
        'trials': args.trials,
        'seed': args.seed
    }
    with open(args.out, 'w', encoding='utf-8') as f:
        json.dump(out, f, indent=2)

    print('Best F1: {:.4f}'.format(best_details['f1']))
    print('Weights:')
    for k,v in best_details['weights'].items():
        print('  {}: {}'.format(k, v))
    print('Threshold: {}'.format(best_details['threshold']))
    print('Metrics: precision={:.4f}, recall={:.4f}, tp={}, fp={}, fn={}'.format(
        best_details['metrics']['precision'], best_details['metrics']['recall'],
        best_details['metrics']['tp'], best_details['metrics']['fp'], best_details['metrics']['fn']
    ))
    print('\nSaved best config to', args.out)
    # Also write a copy into public/ so the PHP app can read it easily
    try:
        import shutil, os
        public_path = os.path.join(os.path.dirname(os.path.dirname(__file__)), 'public', 'best_weights.json')
        # ensure directory exists
        os.makedirs(os.path.dirname(public_path), exist_ok=True)
        shutil.copyfile(args.out, public_path)
        print('Also copied best config to', public_path)
    except Exception as e:
        print('Could not copy best config to public/:', e)
if __name__ == '__main__':
    main()
