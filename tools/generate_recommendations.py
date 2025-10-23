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

# configure logging for this module: prefer console (stderr). Try file-based logging if writable.
_LOG_PATH = os.path.join(os.path.dirname(__file__), 'reco.log')
handlers = [logging.StreamHandler(sys.stderr)]
try:
    fh = logging.FileHandler(_LOG_PATH, encoding='utf-8')
    handlers.insert(0, fh)
except Exception:
    # unable to create file handler (permissions); continue with stderr only
    pass

logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s [%(levelname)s] %(message)s',
    handlers=handlers
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

def generate(input_csv, output_json=None, max_features=5000, print_per_user=False, users_json=None, top_n=10, alpha=0.6, neighbors=5):
    logger.info("generate() called with input=%s output=%s max_features=%s", input_csv, output_json, max_features)
    # If the provided path doesn't exist, try a few common filenames used in this project
    COMMON_INPUTS = [
        input_csv,
        'public/postings.csv',
        'postings.csv',
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

    # Normalize common header variants to expected internal column names
    # Build a mapping of lowercase column name -> original column name
    cols_map = {c.lower(): c for c in df.columns}
    def pick(*names):
        for n in names:
            if n and n.lower() in cols_map:
                return cols_map[n.lower()]
        return None

    # map into standard columns used downstream
    # Title
    title_col = pick('Title', 'title', 'job_title')
    if title_col:
        df['Title'] = df[title_col].fillna('').astype(str)
    elif 'Title' not in df.columns:
        df['Title'] = ''

    # Company
    comp_col = pick('Company', 'company', 'company_name', 'employer')
    if comp_col:
        df['Company'] = df[comp_col].fillna('').astype(str)
    elif 'Company' not in df.columns:
        df['Company'] = ''

    # job_description
    jd_col = pick('job_description', 'description', 'job description', 'jobdesc', 'job_desc')
    if jd_col:
        df['job_description'] = df[jd_col].fillna('').astype(str)
    elif 'job_description' not in df.columns:
        df['job_description'] = ''

    # skills_desc
    skills_col = pick('skills_desc', 'skills', 'required_skills', 'skillset')
    if skills_col:
        df['skills_desc'] = df[skills_col].fillna('').astype(str)
    elif 'skills_desc' not in df.columns:
        df['skills_desc'] = ''

    # location
    loc_col = pick('location', 'work_location', 'city')
    if loc_col:
        df['Location'] = df[loc_col].fillna('').astype(str)
    elif 'Location' not in df.columns:
        df['Location'] = ''

    # resume/requirements (used earlier as 'resume' field)
    res_col = pick('resume', 'RequiredQual', 'requirements', 'requirements_text')
    if res_col:
        df['resume'] = df[res_col].fillna('').astype(str)
    elif 'resume' not in df.columns:
        df['resume'] = ''

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

    # build a combined text corpus from multiple posting fields to ensure TF-IDF has content
    # give higher weight to Title and skills fields by repeating them in the corpus
    combined_fields = []
    for f in ['description', 'job_description', 'Title', 'Company', 'skills_desc', 'posting_domain', 'formatted_experience_level']:
        if f in df.columns:
            combined_fields.append(df[f].fillna('').astype(str))
    if combined_fields:
        # Start with first field then append others; repeat Title and skills_desc to boost their importance
        df['text_corpus'] = combined_fields[0]
        for part_name, part in zip(['description','job_description','Title','Company','skills_desc','posting_domain','formatted_experience_level'], combined_fields[1:]):
            df['text_corpus'] = df['text_corpus'] + ' ' + part
        # boost Title and skills if available
        if 'Title' in df.columns:
            df['text_corpus'] = df['text_corpus'] + ' ' + df['Title'].fillna('').astype(str) + ' ' + df['Title'].fillna('').astype(str)
        if 'skills_desc' in df.columns:
            df['text_corpus'] = df['text_corpus'] + ' ' + df['skills_desc'].fillna('').astype(str)
    else:
        df['text_corpus'] = (df['job_description'].fillna('') + ' ' + df['resume'].fillna('')).astype(str)

    # preprocessing for TF-IDF
    df['clean_job_description'] = df['text_corpus'].apply(preprocess_text)
    df['clean_resume'] = df['resume'].apply(preprocess_text)

    # TF-IDF vectorization (focused features)
    # Use a small min_df so the script works with small datasets
    tfidf = TfidfVectorizer(min_df=1, max_df=0.95, max_features=min(max_features, 4000))
    try:
        logger.info("Fitting TF-IDF (max_features=%s)", min(max_features, 4000))
        job_tfidf = tfidf.fit_transform(df['clean_job_description'])
        resume_tfidf = tfidf.transform(df['clean_resume'])
    except Exception as e:
        logger.warning("TF-IDF word-based fit failed: %s — attempting robust fallback", e)
        try:
            # Try combining fields and a smaller feature set
            combined = (df['clean_job_description'] + ' ' + df['clean_resume']).tolist()
            tfidf = TfidfVectorizer(min_df=1, max_df=0.99, max_features=min(2000, max_features))
            tfidf.fit(combined)
            job_tfidf = tfidf.transform(df['clean_job_description'])
            resume_tfidf = tfidf.transform(df['clean_resume'])
        except Exception as e2:
            logger.warning("Combined TF-IDF fallback failed: %s — trying char n-gram fallback", e2)
            try:
                # final fallback: character n-grams (robust to short/non-word tokens)
                tfidf_char = TfidfVectorizer(analyzer='char_wb', ngram_range=(3,5), max_features=min(2000, max_features))
                # fit on combined content
                combined = (df['clean_job_description'] + ' ' + df['clean_resume']).tolist()
                tfidf_char.fit(combined)
                job_tfidf = tfidf_char.transform(df['clean_job_description'])
                resume_tfidf = tfidf_char.transform(df['clean_resume'])
            except Exception:
                logger.exception("All TF-IDF fallbacks failed")
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

    # if print_per_user mode, compute TF-IDF for job texts and score per provided user profile(s)
    if print_per_user and users_json:
        # build job corpus text
        job_texts = [(i, ' '.join([str(r.get('job_description','')), str(r.get('Title','')), str(r.get('Company','')), str(r.get('skills_desc',''))])) for i, r in enumerate(recommendations)]
        ids, corpus = zip(*job_texts)

        # Preprocess corpus to avoid empty-vocabulary errors (stopword-only docs)
        cleaned_corpus = [preprocess_text(s) for s in corpus]

        # Try word-based TF-IDF first, then char n-gram fallback, then zero-matrix fallback
        job_matrix = None
        vect = None
        try:
            vect = TfidfVectorizer(min_df=1, max_df=0.95, max_features=min(max_features, 8000))
            logger.info("Fitting TF-IDF on %s job texts (word-based)", len(corpus))
            job_matrix = vect.fit_transform(cleaned_corpus)
        except Exception as e:
            logger.warning("Word TF-IDF on job texts failed: %s; trying char n-gram fallback", e)
            try:
                vect = TfidfVectorizer(analyzer='char_wb', ngram_range=(3,5), max_features=min(2000, max_features))
                logger.info("Fitting char n-gram TF-IDF on %s job texts", len(corpus))
                job_matrix = vect.fit_transform(cleaned_corpus)
            except Exception as e2:
                logger.warning("Char n-gram TF-IDF failed: %s; falling back to zero matrix", e2)
                from scipy.sparse import csr_matrix
                job_matrix = csr_matrix((len(corpus), 0))

        # load users JSON (path or stdin)
        if users_json == '-' or users_json is None:
            users = json.load(sys.stdin)
        else:
            with open(users_json, 'r', encoding='utf-8') as uf:
                users = json.load(uf)

        # users should be a list of user objects or a dict of uid->profile
        user_list = []
        if isinstance(users, dict):
            for uid, profile in users.items():
                user_list.append({'uid': uid, 'profile': profile})
        elif isinstance(users, list):
            for p in users:
                if isinstance(p, dict) and ('uid' in p or 'profile' in p):
                    user_list.append({'uid': p.get('uid', None), 'profile': p.get('profile', p)})
                else:
                    user_list.append({'uid': None, 'profile': p})
        else:
            logger.error('Unsupported users JSON format')
            return 2

        out = {}

        # Build user texts for all users first (so we can compute user-user similarities)
        user_texts_list = []
        for u in user_list:
            uid = u.get('uid') or 'anonymous'
            prof = u.get('profile') or {}
            text_parts = []
            try:
                jp1 = prof.get('jobPreferences', {}).get('jobpref1')
                jp2 = prof.get('jobPreferences', {}).get('jobpref2')
                if jp1:
                    try:
                        arr = json.loads(jp1) if isinstance(jp1, str) else jp1
                        text_parts.extend(arr if isinstance(arr, list) else [arr])
                    except Exception:
                        text_parts.append(str(jp1))
                if jp2:
                    try:
                        arr = json.loads(jp2) if isinstance(jp2, str) else jp2
                        text_parts.extend(arr if isinstance(arr, list) else [arr])
                    except Exception:
                        text_parts.append(str(jp2))
                sk1 = prof.get('skills', {}).get('skills_page1')
                sk2 = prof.get('skills', {}).get('skills_page2')
                for sk in (sk1, sk2):
                    if sk:
                        try:
                            arr = json.loads(sk) if isinstance(sk, str) else sk
                            text_parts.extend(arr if isinstance(arr, list) else [arr])
                        except Exception:
                            text_parts.append(str(sk))
                workplace = prof.get('workplace', {}).get('workplace_choice')
                if workplace:
                    text_parts.append(workplace)
            except Exception:
                logger.exception('Failed to build user text during initial pass for uid=%s', uid)
            user_text = ' '.join([str(x) for x in text_parts if x])
            user_texts_list.append((uid, user_text))

        # Vectorize user texts in the same TF-IDF space as jobs (if available)
        user_vecs = None
        if job_matrix is None or (hasattr(job_matrix, 'shape') and job_matrix.shape[1] == 0):
            # No features: create zero vectors
            user_vecs = np.zeros((len(user_texts_list), 0))
        else:
            cleaned_user_texts = [preprocess_text(t) for (_uid, t) in user_texts_list]
            try:
                user_vecs = vect.transform(cleaned_user_texts)
            except Exception as e:
                logger.warning('Failed to transform user texts with vect: %s', e)
                # try fallback with a fresh vectorizer fit on combined user+job texts
                try:
                    fallback_vect = TfidfVectorizer(min_df=1, max_df=0.95, max_features=min(max_features, 8000))
                    combined_fit = cleaned_corpus + cleaned_user_texts
                    fallback_vect.fit(combined_fit)
                    user_vecs = fallback_vect.transform(cleaned_user_texts)
                except Exception:
                    logger.exception('Failed to vectorize user texts; using zero user vectors')
                    from scipy.sparse import csr_matrix
                    user_vecs = csr_matrix((len(user_texts_list), 0))

        # Precompute per-user content similarity to jobs (content_scores_map: uid -> job score array)
        content_scores_map = {}
        if job_matrix is None or (hasattr(job_matrix, 'shape') and job_matrix.shape[1] == 0):
            # zero matrix: all zeros
            for i, (uid, _) in enumerate(user_texts_list):
                content_scores_map[uid] = np.zeros(len(corpus), dtype=float)
        else:
            # compute cosine similarity of each user_vec to job_matrix
            try:
                sims_matrix = cosine_similarity(user_vecs, job_matrix)
                for i, (uid, _) in enumerate(user_texts_list):
                    content_scores_map[uid] = sims_matrix[i].astype(float)
            except Exception:
                logger.exception('Failed to compute user->job similarity matrix; defaulting to zeros')
                for i, (uid, _) in enumerate(user_texts_list):
                    content_scores_map[uid] = np.zeros(len(corpus), dtype=float)

        # Compute user-user similarity (collaborative) using user_vecs
        user_similarity = None
        if job_matrix is None or (hasattr(job_matrix, 'shape') and job_matrix.shape[1] == 0) or (hasattr(user_vecs, 'shape') and user_vecs.shape[1] == 0):
            user_similarity = np.zeros((len(user_texts_list), len(user_texts_list)))
        else:
                # --- Revised collaborative/hybrid pipeline aligned to test script ---
                try:
                    from sklearn.preprocessing import MinMaxScaler
                except Exception:
                    logger.info('MinMaxScaler unavailable; attempting import from sklearn.preprocessing')
                    from sklearn.preprocessing import MinMaxScaler

                # sims_matrix: user x jobs (content similarities computed earlier via cosine_similarity(user_vecs, job_matrix))
                try:
                    sims_matrix = cosine_similarity(user_vecs, job_matrix)
                except Exception:
                    logger.exception('Failed to compute sims_matrix; falling back to zeros')
                    sims_matrix = np.zeros((len(user_texts_list), len(corpus)))

                # Simulated user-item interactions: pick top-k jobs per user (neighbors)
                # This avoids brittle global thresholds which can produce empty interaction rows.
                k = max(1, int(neighbors))
                user_item_matrix = np.zeros_like(sims_matrix, dtype=float)
                try:
                    for ui in range(sims_matrix.shape[0]):
                        if k >= sims_matrix.shape[1]:
                            # mark all as interacted when k >= num_jobs
                            user_item_matrix[ui, :] = (sims_matrix[ui, :] > 0).astype(float)
                        else:
                            topk = np.argsort(sims_matrix[ui])[-k:]
                            user_item_matrix[ui, topk] = 1.0
                except Exception:
                    logger.exception('Failed to build top-k user_item_matrix; falling back to threshold=0.1')
                    CONTENT_THRESHOLD = 0.1
                    user_item_matrix = (sims_matrix > CONTENT_THRESHOLD).astype(float)

                # User-user and item-item similarities for CF
                try:
                    user_similarity = cosine_similarity(user_item_matrix)
                except Exception:
                    logger.exception('Failed to compute user_similarity; using zeros')
                    user_similarity = np.zeros((len(user_texts_list), len(user_texts_list)))
                try:
                    item_similarity = cosine_similarity(user_item_matrix.T)
                except Exception:
                    logger.exception('Failed to compute item_similarity; using zeros')
                    item_similarity = np.zeros((len(corpus), len(corpus)))

                # user-based CF scores: (user_similarity dot user_item_matrix) normalized
                # shape: (num_users, num_jobs)
                with np.errstate(divide='ignore', invalid='ignore'):
                    denom_u = np.sum(np.abs(user_similarity), axis=1, keepdims=True) + 1e-8
                    user_cf_scores = (user_similarity.dot(user_item_matrix)) / denom_u

                    # item-based CF: user_item_matrix dot item_similarity
                    denom_i = np.sum(np.abs(item_similarity), axis=1, keepdims=True).T + 1e-8
                    item_cf_scores = (user_item_matrix.dot(item_similarity)) / denom_i

                # Normalize each component to 0-1 using MinMaxScaler (fit on rows)
                # Normalize each user's score vector (row-wise) to 0-1 to avoid column-wise degeneracy
                def row_minmax(mat):
                    mat = np.array(mat, dtype=float)
                    if mat.size == 0:
                        return mat
                    mn = np.nanmin(mat, axis=1, keepdims=True)
                    mx = np.nanmax(mat, axis=1, keepdims=True)
                    rng = mx - mn
                    rng[rng == 0] = 1.0
                    return ((mat - mn) / rng)

                try:
                    content_norm = row_minmax(sims_matrix)
                    user_cf_norm = row_minmax(user_cf_scores)
                    item_cf_norm = row_minmax(item_cf_scores)
                except Exception:
                    logger.exception('Row-wise normalization failed; falling back to zeros')
                    content_norm = np.zeros_like(sims_matrix, dtype=float)
                    user_cf_norm = np.zeros_like(user_cf_scores, dtype=float)
                    item_cf_norm = np.zeros_like(item_cf_scores, dtype=float)

                # Combine into hybrid: weights aligned with test script
                W_CONTENT = 0.5
                W_USER = 0.25
                W_ITEM = 0.25
                hybrid_matrix = (W_CONTENT * content_norm) + (W_USER * user_cf_norm) + (W_ITEM * item_cf_norm)

                # Helper: infer user level from profile text (simple keyword match)
                def infer_user_level_from_text(t):
                    if not isinstance(t, str): return 'Associate'
                    s = t.lower()
                    if any(k in s for k in ['senior', 'manager', 'lead', 'sr.']): return 'Mid-Senior level'
                    if any(k in s for k in ['junior', 'jr.', 'entry', 'intern', 'graduate']): return 'Entry level'
                    return 'Associate'

                # Job levels vector (from original dataframe if present)
                job_levels = []
                for i, r in enumerate(recommendations):
                    jl = ''
                    try:
                        jl = df.iloc[i].get('formatted_experience_level', '')
                    except Exception:
                        jl = ''
                    job_levels.append(jl)
                job_levels = np.array(job_levels)

                # Apply per-user context boost and emit top-N
                CONTEXT_BOOST = 0.2
                for ui, (uid, _utext) in enumerate(user_texts_list):
                    prof = user_list[ui].get('profile') or {}
                    # build a small free-text from profile to infer level
                    ptext = ' '.join([str(x) for x in [
                        prof.get('jobPreferences', {}).get('jobpref1', ''),
                        prof.get('jobPreferences', {}).get('jobpref2', ''),
                        prof.get('skills', {}).get('skills_page1', ''),
                        prof.get('skills', {}).get('skills_page2', ''),
                        prof.get('workplace', {}).get('workplace_choice', ''),
                        prof.get('educationInfo', '')
                    ] if x])
                    user_level = infer_user_level_from_text(ptext)

                    # base hybrid scores for this user (row ui)
                    user_hybrid = hybrid_matrix[ui].astype(float).copy()

                    # apply context boost where job_levels == user_level
                    try:
                        mask = (job_levels.astype(str) == str(user_level))
                        if mask.any():
                            user_hybrid = user_hybrid + (mask.astype(float) * CONTEXT_BOOST)
                    except Exception:
                        pass

                    # Re-normalize per-user hybrid to 0-1
                    mn = float(np.nanmin(user_hybrid))
                    mx = float(np.nanmax(user_hybrid))
                    if mx - mn > 1e-12:
                        user_hybrid_norm = (user_hybrid - mn) / (mx - mn)
                    else:
                        user_hybrid_norm = np.zeros_like(user_hybrid)

                    # Prepare output: top_n indices
                    top_idx = np.argsort(user_hybrid_norm)[-top_n:][::-1]
                    recs_for_user = []
                    for j in top_idx:
                        job_idx = ids[j]
                        rec_item = recommendations[job_idx]
                        rec_item_out = rec_item.copy()
                        # populate normalized scores (0-1)
                        rec_item_out['content_score'] = float(content_norm[ui, j])
                        rec_item_out['user_cf_score'] = float(user_cf_norm[ui, j])
                        rec_item_out['item_cf_score'] = float(item_cf_norm[ui, j])
                        rec_item_out['hybrid_score'] = float(user_hybrid_norm[j])
                        recs_for_user.append(rec_item_out)
                    out[uid] = recs_for_user

        # print or write per-user JSON
        out_json = json.dumps(out, ensure_ascii=False, indent=2)
        if output_json:
            try:
                with open(output_json, 'w', encoding='utf-8') as wf:
                    wf.write(out_json)
                logger.info('Wrote per-user recommendations to %s', output_json)
                return 0
            except Exception as e:
                logger.exception('Failed to write per-user output to %s: %s', output_json, e)
                # fall back to printing
        print(out_json)
        return 0

    # write JSON (fallback behavior)
    if output_json:
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
    parser.add_argument('--input', default='public/postings.csv', help='path to input CSV')
    parser.add_argument('--output', default=None, help='path to output JSON (omit for print-per-user)')
    parser.add_argument('--max-features', type=int, default=5000, help='max TF-IDF features')
    parser.add_argument('--print-per-user', action='store_true', help='print top recommendations per user to stdout (requires --users)')
    parser.add_argument('--users', default=None, help="path to users JSON or '-' to read stdin")
    parser.add_argument('--alpha', type=float, default=0.6, help='blend factor: alpha*content + (1-alpha)*collaborative')
    parser.add_argument('--neighbors', type=int, default=5, help='number of nearest neighbors to use for collaborative aggregation')
    parser.add_argument('--top', type=int, default=10, help='top N recommendations per user')
    args = parser.parse_args()
    sys.exit(generate(args.input, args.output, args.max_features, args.print_per_user, args.users, args.top, args.alpha, args.neighbors))
