#!/usr/bin/env python3
"""Generate recommendations per user by fetching user profiles from Firestore.

This script wraps the existing generate() function in generate_recommendations.py.
It will attempt to use google-cloud-firestore when a --service-account is provided
or when application default credentials are available. If Firestore isn't available,
it falls back to reading `tools/test_users.json`.

Output: prints a JSON map uid -> [recommendations] to stdout by default.
"""
import argparse
import json
import os
import sys
import tempfile
import logging

BASE = os.path.dirname(__file__)
sys.path.insert(0, BASE)

try:
    from generate_recommendations import generate
except Exception as e:
    print('Failed to import generate() from generate_recommendations.py:', e, file=sys.stderr)
    raise

logger = logging.getLogger('gen_reco_fs')
logging.basicConfig(level=logging.INFO, format='%(asctime)s [%(levelname)s] %(message)s')

def fetch_users_from_firestore(service_account_path=None, collection='users'):
    try:
        from google.cloud import firestore
    except Exception as e:
        logger.warning('google-cloud-firestore not installed: %s', e)
        return None

    opts = {}
    if service_account_path:
        os.environ['GOOGLE_APPLICATION_CREDENTIALS'] = service_account_path

    try:
        client = firestore.Client()
    except Exception as e:
        logger.warning('Failed to create Firestore client: %s', e)
        return None

    users = []
    try:
        coll = client.collection(collection)
        docs = coll.stream()
        for d in docs:
            data = d.to_dict()
            # attach uid
            users.append({'uid': d.id, 'profile': data})
        logger.info('Fetched %d user profiles from Firestore collection "%s"', len(users), collection)
        return users
    except Exception as e:
        logger.exception('Failed to read Firestore collection: %s', e)
        return None

def read_local_users(path):
    try:
        with open(path, 'r', encoding='utf-8') as f:
            raw = json.load(f)
        # normalize to list of {uid, profile}
        out = []
        if isinstance(raw, dict):
            for k, v in raw.items():
                out.append({'uid': k, 'profile': v})
        elif isinstance(raw, list):
            for item in raw:
                if isinstance(item, dict) and ('uid' in item or 'profile' in item):
                    out.append({'uid': item.get('uid'), 'profile': item.get('profile', item)})
                else:
                    out.append({'uid': None, 'profile': item})
        else:
            logger.error('Unsupported users.json format')
            return []
        logger.info('Loaded %d user profiles from %s', len(out), path)
        return out
    except Exception as e:
        logger.exception('Failed to read local users file: %s', e)
        return []

def main():
    p = argparse.ArgumentParser(description='Generate per-user recommendations using Firestore profiles (or local fallback)')
    p.add_argument('--service-account', help='Path to GCP service account JSON for Firestore access')
    p.add_argument('--collection', default='users', help='Firestore collection name')
    p.add_argument('--input', default='public/postings.csv', help='Path to postings CSV')
    p.add_argument('--output', default=None, help='Path to write per-user JSON (default stdout)')
    p.add_argument('--local-users', default=os.path.join(BASE, 'test_users.json'), help='Fallback local users JSON')
    p.add_argument('--alpha', type=float, default=0.6, help='Hybrid blend alpha (content weight)')
    p.add_argument('--neighbors', type=int, default=5, help='Number of neighbors for collaborative aggregation')
    p.add_argument('--top', type=int, default=10, help='Top N recommendations per user')
    args = p.parse_args()

    users = None
    if args.service_account:
        users = fetch_users_from_firestore(args.service_account, args.collection)
    else:
        # Try to fetch with default ADC if possible
        users = fetch_users_from_firestore(None, args.collection)

    if users is None or len(users) == 0:
        logger.info('Falling back to local users file: %s', args.local_users)
        users = read_local_users(args.local_users)

    if not users:
        logger.error('No user profiles available. Aborting.')
        return 2

    # write temp users JSON in the same format expected by generate() (list/dict)
    tmp = tempfile.NamedTemporaryFile(delete=False, suffix='.json', prefix='mvsg_users_', mode='w', encoding='utf-8')
    try:
        # generate() accepts a path to users JSON; it expects list/dict - we'll provide list
        json.dump([{'uid': u.get('uid'), 'profile': u.get('profile')} for u in users], tmp, ensure_ascii=False)
        tmp.flush(); tmp.close()

        # call generate() with print_per_user behavior by passing users_json
        output_path = args.output
        rc = generate(args.input, output_path, max_features=5000, print_per_user=True, users_json=tmp.name, top_n=args.top, alpha=args.alpha, neighbors=args.neighbors)
        return int(rc or 0)
    finally:
        try:
            os.unlink(tmp.name)
        except Exception:
            pass

if __name__ == '__main__':
    sys.exit(main())
