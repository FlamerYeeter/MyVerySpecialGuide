#!/usr/bin/env python3
"""
Apply ensemble weights (from public/best_weights.json or tools/best_weights.json)
to an input recommendations JSON file and write the result to output path.

Expected input formats:
- Mapping: { "<uid>": [ {job...}, ... ] }
- List: [ {job...}, ... ]

For each recommendation entry, this script will look for score columns
such as content_score, user_cf_score, item_cf_score, hybrid_score, match_score
and normalize them using mins/maxs stored in the best_weights file.
It will add an "ensemble_score" field to each recommendation.

Usage: python tools/apply_weights_to_file.py --input <in.json> --output <out.json>
"""
import argparse
import json
from pathlib import Path
import sys

def load_best_weights():
    candidates = [Path('public/best_weights.json'), Path('tools/best_weights.json')]
    for p in candidates:
        if p.exists():
            try:
                return json.loads(p.read_text())
            except Exception:
                continue
    return None

def normalize(val, lo, hi):
    try:
        v = float(val)
    except Exception:
        return 0.0
    if hi is None or lo is None:
        return v
    if hi == lo:
        return 0.0
    return (v - lo) / (hi - lo)

def apply_weights_to_list(rows, best):
    cols = best.get('score_columns', [])
    weights = best.get('best', {}).get('weights', {})
    mins = best.get('mins', {})
    maxs = best.get('maxs', {})
    for r in rows:
        total = 0.0
        for col in cols:
            raw = None
            if isinstance(r, dict):
                raw = r.get(col, None)
                if raw is None:
                    # fallback: drop _score suffix
                    fallback = col.replace('_score','')
                    raw = r.get(fallback, r.get('match_score', 0))
            try:
                lo = float(mins.get(col, 0)) if col in mins else None
            except Exception:
                lo = None
            try:
                hi = float(maxs.get(col, 1)) if col in maxs else None
            except Exception:
                hi = None
            norm = normalize(raw if raw is not None else 0.0, lo, hi)
            w = float(weights.get(col, 0.0)) if weights else 0.0
            total += norm * w
        # write ensemble_score
        if isinstance(r, dict):
            r['ensemble_score'] = total
    return rows

def main():
    p = argparse.ArgumentParser()
    p.add_argument('--input', required=True)
    p.add_argument('--output', required=True)
    args = p.parse_args()

    inp = Path(args.input)
    outp = Path(args.output)
    if not inp.exists():
        print('Input file not found:', inp, file=sys.stderr)
        sys.exit(2)

    best = load_best_weights()
    if not best:
        print('No best_weights.json found (public/ or tools/). Aborting.', file=sys.stderr)
        sys.exit(3)

    data = None
    try:
        data = json.loads(inp.read_text())
    except Exception as e:
        print('Failed to parse input JSON:', e, file=sys.stderr)
        sys.exit(4)

    out = None
    if isinstance(data, dict):
        # mapping of uid -> list or single list
        out = {}
        for k, v in data.items():
            if isinstance(v, list):
                out[k] = apply_weights_to_list(v, best)
            else:
                out[k] = v
    elif isinstance(data, list):
        out = apply_weights_to_list(data, best)
    else:
        print('Unexpected JSON structure in input file', file=sys.stderr)
        sys.exit(5)

    try:
        outp.parent.mkdir(parents=True, exist_ok=True)
        outp.write_text(json.dumps(out, ensure_ascii=False, indent=2))
    except Exception as e:
        print('Failed to write output:', e, file=sys.stderr)
        sys.exit(6)

if __name__ == '__main__':
    main()
