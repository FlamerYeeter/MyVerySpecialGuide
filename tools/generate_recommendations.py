import argparse
import json
import os
import re
import sys
import numpy as np
import pandas as pd

from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

# Optional: download NLTK stopwords if you want to use them (kept simple here)
try:
    import nltk
    from nltk.corpus import stopwords
    try:
        stopwords.words('english')
    except LookupError:
        nltk.download('stopwords')
    STOPWORDS = set(stopwords.words('english'))
except Exception:
    STOPWORDS = set()

def preprocess_text(text):
    if not isinstance(text, str):
        return ""
    text = text.lower()
    text = re.sub(r'[^a-z0-9\s]', ' ', text)
    text = re.sub(r'\s+', ' ', text).strip()
    if STOPWORDS:
        text = " ".join([w for w in text.split() if w not in STOPWORDS])
    return text

def generate(input_csv, output_json, max_features=5000):
    if not os.path.exists(input_csv):
        print(f"ERROR: Input CSV not found: {input_csv}", file=sys.stderr)
        return 1

    df = pd.read_csv(input_csv)
    # ensure columns
    for c in ['job_description', 'resume']:
        if c not in df.columns:
            df[c] = ""

    df['clean_job_description'] = df['job_description'].apply(preprocess_text)
    df['clean_resume'] = df['resume'].apply(preprocess_text)

    # Fit TF-IDF on combined corpus to have a shared vocabulary
    vectorizer = TfidfVectorizer(max_features=max_features)
    combined = pd.concat([df['clean_job_description'], df['clean_resume']], ignore_index=True)
    vectorizer.fit(combined)

    job_tfidf = vectorizer.transform(df['clean_job_description'])
    resume_tfidf = vectorizer.transform(df['clean_resume'])

    # Row-wise similarity (job <-> resume for same row)
    row_sims = []
    for i in range(df.shape[0]):
        vj = job_tfidf[i]
        vr = resume_tfidf[i]
        if vj.nnz == 0 or vr.nnz == 0:
            row_sims.append(0.0)
        else:
            row_sims.append(float(cosine_similarity(vj, vr)[0, 0]))

    # Cross resume -> all jobs similarities (for best job per resume)
    if job_tfidf.shape[0] > 0:
        resume_vs_jobs = cosine_similarity(resume_tfidf, job_tfidf)
        best_idxs = np.argmax(resume_vs_jobs, axis=1)
        best_scores = resume_vs_jobs[np.arange(resume_vs_jobs.shape[0]), best_idxs]
    else:
        best_idxs = np.array([-1]*df.shape[0])
        best_scores = np.zeros(df.shape[0])

    df['computed_similarity'] = row_sims
    df['best_job_for_resume'] = best_idxs
    df['best_job_score'] = best_scores.tolist()

    # normalize computed_similarity to 0-5 scale for easy display
    arr = np.array(df['computed_similarity'].tolist())
    if arr.max() > arr.min():
        norm = (arr - arr.min()) / (arr.max() - arr.min())
    else:
        norm = np.zeros_like(arr)
    df['computed_score'] = (norm * 5.0).round(3)

    # build output
    out = []
    for i, r in df.iterrows():
        obj = {
            "id": int(i),
            "job_description": str(r.get('job_description', '')),
            "resume": str(r.get('resume', '')),
            "match_score": float(r.get('match_score')) if 'match_score' in r and not pd.isna(r.get('match_score')) else None,
            "computed_similarity": float(r.get('computed_similarity', 0.0)),
            "computed_score": float(r.get('computed_score', 0.0)),
            "best_job_for_resume": int(r.get('best_job_for_resume', -1)),
            "best_job_score": float(r.get('best_job_score', 0.0)),
        }
        for extra in ['industry', 'fit_level', 'growth_potential', 'work_environment']:
            if extra in df.columns:
                obj[extra] = r.get(extra, '')
        out.append(obj)

    os.makedirs(os.path.dirname(output_json), exist_ok=True)
    with open(output_json, 'w', encoding='utf-8') as f:
        json.dump(out, f, ensure_ascii=False, indent=2)

    print(f"Wrote recommendations to {output_json}")
    return 0

if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="Generate recommendations.json from CSV")
    parser.add_argument('--input', default='public/resume_job_matching_dataset.csv', help='path to input CSV')
    parser.add_argument('--output', default='public/recommendations.json', help='path to output JSON')
    parser.add_argument('--max-features', type=int, default=5000, help='max TF-IDF features')
    args = parser.parse_args()
    sys.exit(generate(args.input, args.output, args.max_features))
