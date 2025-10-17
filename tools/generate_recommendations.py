import argparse
import json
import os
import re
import sys
import numpy as np
import pandas as pd
import logging
import traceback

# Try to import sklearn/nltk; give clear error if missing
try:
    from sklearn.feature_extraction.text import TfidfVectorizer
    from sklearn.metrics.pairwise import cosine_similarity
    from sklearn.decomposition import TruncatedSVD
except Exception as e:
    print("Missing sklearn. Install with: pip install scikit-learn")
    raise

try:
    import nltk
    from nltk.corpus import stopwords
except Exception:
    print("Missing nltk. Install with: pip install nltk")
    raise

# ensure stopwords
try:
    stopwords.words('english')
except LookupError:
    nltk.download('stopwords')

# configure logging for this module: write to tools/reco.log and to console
_LOG_PATH = os.path.join(os.path.dirname(__file__), 'reco.log')
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s [%(levelname)s] %(message)s',
    handlers=[
        logging.FileHandler(_LOG_PATH, encoding='utf-8'),
        logging.StreamHandler(sys.stdout)
    ]
)
logger = logging.getLogger(__name__)

def preprocess_text(text):
    if not isinstance(text, str):
        return ""
    t = text.lower()
    t = re.sub(r'\W', ' ', t)
    t = re.sub(r'\s+', ' ', t).strip()
    sw = set(stopwords.words('english'))
    return ' '.join([w for w in t.split() if w and w not in sw])

def generate(input_csv, output_json, max_features=5000):
    logger.info("generate() called with input=%s output=%s max_features=%s", input_csv, output_json, max_features)
    # If the provided path doesn't exist, try a few common filenames used in this project
    COMMON_INPUTS = [
        input_csv,
        'public/data job posts.csv',
        'public/resume_job_matching_dataset.csv',
        'resume_job_matching_dataset.csv',
        'data job posts.csv',
    ]
    resolved = None
    for p in COMMON_INPUTS:
        if p and os.path.exists(p):
            resolved = p
            break
    if resolved is None:
        logger.error("Input CSV not found. Searched: %s", COMMON_INPUTS)
        return 1
    if resolved != input_csv:
        logger.info("Note: using discovered CSV: %s", resolved)
    input_csv = resolved

    df = pd.read_csv(input_csv)
    # ensure columns
    for c in ['job_description', 'resume']:
        if c not in df.columns:
            df[c] = ""

    # load CSV (first 5000 rows for speed)
    if os.path.exists(input_csv):
        try:
            df = pd.read_csv(input_csv).head(5000)
            logger.info("Loaded CSV rows: %s from %s", len(df), input_csv)
        except Exception as e:
            logger.exception("Failed to read CSV, creating empty fallback dataframe: %s", e)
            df = pd.DataFrame()
    else:
        logger.warning("CSV not found at %s, creating example dataset.", input_csv)
        df = pd.DataFrame({
            'JobDescription': ['Software engineer with java', 'Data analyst with python'],
            'RequiredQual': ['I know java and spring boot', 'I use python for data analysis'],
            'Title': ['Software Engineer', 'Data Analyst'],
            'Company': ['Tech Corp', 'Data Inc.']
        })

    # normalize expected column names
    cols = {c.strip(): c for c in df.columns}
    def col(name, fallback=None):
        return cols.get(name, fallback)

    # rename to expected internal names
    if 'JobDescription' in df.columns:
        df = df.rename(columns={'JobDescription': 'job_description'})
    elif 'Job Description' in df.columns:
        df = df.rename(columns={'Job Description': 'job_description'})

    if 'RequiredQual' in df.columns:
        df = df.rename(columns={'RequiredQual': 'resume'})
    elif 'Required Qual' in df.columns:
        df = df.rename(columns={'Required Qual': 'resume'})
    elif 'JobRequirment' in df.columns:
        df = df.rename(columns={'JobRequirment': 'resume'})

    # ensure keys exist
    for k in ['job_description', 'resume', 'Title', 'Company', 'Location', 'AnnouncementCode', 'IT']:
        if k not in df.columns:
            df[k] = ''

    # fill na
    df['job_description'] = df['job_description'].fillna('').astype(str)
    df['resume'] = df['resume'].fillna('').astype(str)
    df['Title'] = df['Title'].fillna('').astype(str)
    df['Company'] = df['Company'].fillna('').astype(str)
    df['Location'] = df['Location'].fillna('').astype(str)
    df['AnnouncementCode'] = df['AnnouncementCode'].fillna('').astype(str)
    df['IT'] = df['IT'].fillna(0)

    # synthetic match_score when missing
    if 'match_score' not in df.columns:
        df['match_score'] = df['IT'].replace('', 0).fillna(0).astype(float)
        # if IT empty, set default 5 (as in your example) — keep small values otherwise
        if df['match_score'].sum() == 0:
            df['match_score'] = 5.0

    # preprocessing for TF-IDF
    df['clean_job_description'] = df['job_description'].apply(preprocess_text)
    df['clean_resume'] = df['resume'].apply(preprocess_text)

    # TF-IDF vectorization (focused features)
    # Use a small min_df so the script works with small datasets
    tfidf = TfidfVectorizer(min_df=1, max_df=0.95, max_features=min(max_features, 4000))
    try:
        logger.info("Fitting TF-IDF (max_features=%s)", min(max_features, 4000))
        job_tfidf = tfidf.fit_transform(df['clean_job_description'])
        resume_tfidf = tfidf.transform(df['clean_resume'])
    except ValueError:
        # fallback: too small corpus, fit on combined text
        logger.warning("TF-IDF ValueError (small corpus), falling back to combined fit")
        try:
            combined = (df['clean_job_description'] + ' ' + df['clean_resume']).tolist()
            tfidf = TfidfVectorizer(max_features=2000)
            tfidf.fit(combined)
            job_tfidf = tfidf.transform(df['clean_job_description'])
            resume_tfidf = tfidf.transform(df['clean_resume'])
        except Exception:
            logger.exception("Fallback TF-IDF fit failed")
            # fallback to zero matrices
            from scipy.sparse import csr_matrix
            job_tfidf = csr_matrix((len(df), 0))
            resume_tfidf = csr_matrix((len(df), 0))

    # compute per-row similarity (diag: resume vs own job_description)
    # if resume/description vectors are zero, similarity will be 0
    sims = []
    if job_tfidf.shape[0] == resume_tfidf.shape[0] and job_tfidf.shape[0] > 0:
        # cosine similarity row-wise
        all_sims = cosine_similarity(resume_tfidf, job_tfidf)
        # diagonal (same index) as a baseline computed_score
        for i in range(all_sims.shape[0]):
            sims.append(float(all_sims[i, i]))
    else:
        sims = [0.0] * len(df)
    logger.info("Computed sims for %s rows (sample: %s)", len(sims), sims[:5])

    # also compute for each resume the max similarity to any job (useful)
    max_sims = []
    if resume_tfidf.shape[0] > 0 and job_tfidf.shape[0] > 0:
        max_sims = list(np.max(cosine_similarity(resume_tfidf, job_tfidf), axis=1))
    else:
        max_sims = [0.0] * len(df)
    logger.info("Computed max_sims sample: %s", (max_sims[:5] if len(max_sims) else []))

    # simple inference helpers (same as described)
    def infer_fit(text):
        t = text.lower()
        for k in ['excellent', 'perfect', 'highly suitable', 'strong match', 'ideal', 'highly qualified']:
            if k in t: return 'Excellent Fit'
        for k in ['good fit', 'good', 'suitable', 'appropriate', 'fit']:
            if k in t: return 'Good Fit'
        return ''

    def infer_growth(text):
        t = text.lower()
        for k in ['promotion', 'career growth', 'growth', 'advance', 'development', 'opportunity', 'career advancement', 'leadership']:
            if k in t: return 'High Potential'
        for k in ['entry level', 'entry-level', 'trainee', 'starter', 'mid-level']:
            if k in t: return 'Medium Potential'
        return ''

    def infer_env(text):
        t = text.lower()
        for k in ['quiet', 'calm', 'low noise', 'private', 'peaceful', 'indoor quiet']:
            if k in t: return 'Quiet'
        for k in ['busy', 'fast-paced', 'high energy', 'crowd', 'bustling', 'active environment']:
            if k in t: return 'Busy'
        return ''

    # build recommendations output
    recommendations = []
    for idx, row in df.reset_index().iterrows():
        text_for_inf = ' '.join([str(row.get('job_description','')), str(row.get('resume','')), str(row.get('Title','')), str(row.get('Company',''))])
        rec = {
            'job_id': int(idx),
            'Title': row.get('Title',''),
            'Company': row.get('Company',''),
            'job_description': row.get('job_description',''),
            'resume': row.get('resume',''),
            'match_score': float(row.get('match_score', 0)),
            'computed_score': float(sims[idx]) if idx < len(sims) else float(max_sims[idx]) if idx < len(max_sims) else 0.0,
            'computed_max_score': float(max_sims[idx]) if idx < len(max_sims) else 0.0,
            'industry': row.get('Company',''),
            'fit_level': infer_fit(text_for_inf),
            'growth_potential': infer_growth(text_for_inf),
            'work_environment': infer_env(text_for_inf) or row.get('Location',''),
            'location': row.get('Location',''),
            'announcement_code': row.get('AnnouncementCode','')
        }
        recommendations.append(rec)

    # write JSON
    try:
        with open(output_json, 'w', encoding='utf-8') as f:
            json.dump(recommendations, f, ensure_ascii=False, indent=2)
        logger.info("Wrote %s recommendations to %s", len(recommendations), output_json)
    except Exception as e:
        logger.exception("Failed to write recommendations.json: %s", e)
        raise

    return 0

if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="Generate recommendations.json from CSV")
    parser.add_argument('--input', default='public/resume_job_matching_dataset.csv', help='path to input CSV')
    parser.add_argument('--output', default='public/recommendations.json', help='path to output JSON')
    parser.add_argument('--max-features', type=int, default=5000, help='max TF-IDF features')
    args = parser.parse_args()
    sys.exit(generate(args.input, args.output, args.max_features))
