"""
DEPRECATED: apply_weights_to_recommendations.py removed. Use PHP RecommendationService for scoring.
"""
import sys
print('DEPRECATED: apply_weights_to_recommendations.py removed')
sys.exit(0)
#!/usr/bin/env python3
"""
Apply ensemble weights from public/best_weights.json to public/recommendations.json and write public/recommendations_rescored.json

This script expects public/best_weights.json produced by the optimizer, which includes:
  - best.weights: mapping from score column names to normalized weights
  - mins/maxs: min/max values used for normalization when optimizing

It will normalize the corresponding fields from each recommendation using mins/maxs and compute an `ensemble_score`.
"""
import json
import os
import sys

ROOT = os.path.dirname(os.path.dirname(__file__))
PUBLIC = os.path.join(ROOT, 'public')
BEST = os.path.join(PUBLIC, 'best_weights.json')
RECO = os.path.join(PUBLIC, 'recommendations.json')
OUT = os.path.join(PUBLIC, 'recommendations_rescored.json')

if not os.path.exists(BEST):
    print('best_weights.json not found at', BEST)
    sys.exit(1)
if not os.path.exists(RECO):
    print('recommendations.json not found at', RECO)
    sys.exit(1)

with open(BEST, 'r', encoding='utf-8') as f:
    best = json.load(f)

score_cols = best.get('score_columns') or list(best.get('best', {}).get('weights', {}).keys())
weights = best.get('best', {}).get('weights', {})
mins = best.get('mins', {})
maxs = best.get('maxs', {})

with open(RECO, 'r', encoding='utf-8') as f:
    recs = json.load(f)

out = []
for r in recs:
    # compute normalized score for each column
    total = 0.0
    for c in score_cols:
        raw = None
        # try a few possible keys
        for key in [c, c.replace('_score',''), 'content_score', 'computed_score', 'match_score']:
            if key in r:
                try:
                    raw = float(r[key])
                    break
                except Exception:
                    continue
        if raw is None:
            raw = 0.0
        lo = mins.get(c, 0.0)
        hi = maxs.get(c, 1.0)
        norm = (raw - lo) / (hi - lo) if hi > lo else 0.0
        w = float(weights.get(c, 0.0))
        total += norm * w
    r['ensemble_score'] = total
    out.append(r)

# write rescored
with open(OUT, 'w', encoding='utf-8') as f:
    json.dump(out, f, indent=2)

print('Wrote rescored recommendations to', OUT)
