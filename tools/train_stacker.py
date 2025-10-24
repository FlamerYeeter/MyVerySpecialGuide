#!/usr/bin/env python3
"""
Train a simple scikit-learn logistic regression stacker on score columns.
Writes model to --out-model (pickle) and metrics (precision/recall/f1/accuracy) to --metrics JSON.
"""
import argparse
import json
import pickle
import sys
from pathlib import Path

import numpy as np
import pandas as pd
from sklearn.linear_model import LogisticRegression
from sklearn.model_selection import StratifiedKFold
from sklearn.metrics import precision_score, recall_score, f1_score, accuracy_score


def read_scores(path, score_cols):
    df = pd.read_csv(path)
    # ensure columns exist
    missing = [c for c in score_cols if c not in df.columns]
    if missing:
        raise ValueError(f"Missing expected columns: {missing}")
    X = df[score_cols].fillna(0).values
    y = df['label'].astype(int).values
    return X, y


def cross_validate_and_train(X, y, C=1.0, folds=5, seed=42):
    skf = StratifiedKFold(n_splits=folds, shuffle=True, random_state=seed)
    preds = np.zeros_like(y)
    val_scores = []
    for train_idx, val_idx in skf.split(X, y):
        Xtr, Xval = X[train_idx], X[val_idx]
        ytr, yval = y[train_idx], y[val_idx]
        clf = LogisticRegression(C=C, solver='liblinear', max_iter=1000)
        clf.fit(Xtr, ytr)
        p = clf.predict_proba(Xval)[:, 1]
        preds[val_idx] = (p >= 0.5).astype(int)
    return preds


def main():
    p = argparse.ArgumentParser()
    p.add_argument('--scores', required=True)
    p.add_argument('--score-cols', default='content_score,user_cf_score,item_cf_score,hybrid_score')
    p.add_argument('--out-model', default='tools/stacker_model.pkl')
    p.add_argument('--metrics', default='tools/stacker_metrics.json')
    p.add_argument('--folds', type=int, default=5)
    p.add_argument('--seed', type=int, default=42)
    args = p.parse_args()

    score_cols = [c.strip() for c in args.score_cols.split(',')]
    X, y = read_scores(args.scores, score_cols)

    # simple normalization per column
    mins = X.min(axis=0)
    maxs = X.max(axis=0)
    rng = maxs - mins
    rng[rng == 0] = 1.0
    Xn = (X - mins) / rng

    # cross-validate to estimate performance
    preds = cross_validate_and_train(Xn, y, folds=args.folds, seed=args.seed)
    prec = precision_score(y, preds, zero_division=0)
    rec = recall_score(y, preds, zero_division=0)
    f1 = f1_score(y, preds, zero_division=0)
    acc = accuracy_score(y, preds)

    # train final model on full data
    clf = LogisticRegression(C=1.0, solver='liblinear', max_iter=1000)
    clf.fit(Xn, y)

    out_model_path = Path(args.out_model)
    out_model_path.parent.mkdir(parents=True, exist_ok=True)
    with open(out_model_path, 'wb') as f:
        pickle.dump({'model': clf, 'score_cols': score_cols, 'mins': mins.tolist(), 'maxs': maxs.tolist()}, f)

    metrics = {
        'precision': float(prec),
        'recall': float(rec),
        'f1': float(f1),
        'accuracy': float(acc),
        'n_samples': int(len(y)),
        'score_cols': score_cols,
    }
    with open(args.metrics, 'w') as f:
        json.dump(metrics, f, indent=2)

    print('Trained stacker model and saved to', out_model_path)
    print('Metrics:', metrics)


if __name__ == '__main__':
    main()
