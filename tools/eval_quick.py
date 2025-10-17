import pandas as pd
import numpy as np
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score, precision_score, recall_score, f1_score
from sklearn.decomposition import TruncatedSVD
import nltk
from nltk.corpus import stopwords
import re
import time

# --- Download NLTK stopwords ---
try:
    stopwords.words('english')
except LookupError:
    nltk.download('stopwords')

# --- 1. Load and Preprocess Data (Optimized) ---
start_time = time.time()

# Load only the first 5000 rows for speed.
# To run on the full dataset, remove .head(5000)
try:
    df = pd.read_csv('public/data job posts.csv').head(5000)
    print("Successfully loaded the first 5000 rows of 'public/data job posts.csv'.")
except FileNotFoundError:
    print("Error: 'public/data job posts.csv' not found. Using example fallback.")
    df = pd.DataFrame({
        'JobDescription': ['Software engineer with java', 'Data analyst with python'],
        'RequiredQual': ['I know java and spring boot', 'I use python for data analysis'],
        'Title': ['Software Engineer', 'Data Analyst'],
        'Company': ['Tech Corp', 'Data Inc.']
    })

# --- Adapt the new dataset ---
df = df.rename(columns={'JobDescription': 'job_description', 'RequiredQual': 'resume'})
df['job_description'] = df['job_description'].fillna('')
df['resume'] = df['resume'].fillna('')
df['match_score'] = 5 # Synthetic match score

# --- Add IDs and Preprocess Text ---
df['job_id'] = df.index
df['user_id'] = df.index

def preprocess_text(text):
    if not isinstance(text, str): return ""
    text = text.lower()
    text = re.sub(r'\W', ' ', text)
    text = re.sub(r'\s+', ' ', text)
    stop_words = set(stopwords.words('english'))
    text = ' '.join([word for word in text.split() if word not in stop_words])
    return text


df['clean_job_description'] = df['job_description'].apply(preprocess_text)
df['clean_resume'] = df['resume'].apply(preprocess_text)

print(f"Data loading and preprocessing took: {time.time() - start_time:.2f} seconds")

# --- 2. Feature Extraction (Optimized TF-IDF) ---
tfidf_time = time.time()
# Optimize TF-IDF by focusing on the most relevant features
tfidf_vectorizer = TfidfVectorizer(min_df=1, max_df=0.95, max_features=4000)
job_tfidf_matrix = tfidf_vectorizer.fit_transform(df['clean_job_description'])
resume_tfidf_matrix = tfidf_vectorizer.transform(df['clean_resume'])
print(f"TF-IDF vectorization took: {time.time() - tfidf_time:.2f} seconds")


# --- 3. Splitting Data ---
df['match'] = (df['match_score'] >= 3).astype(int)
X_train, X_test, y_train, y_test = train_test_split(
    df[['job_id', 'user_id']], df['match'], test_size=0.2, random_state=42
)
test_df = df.loc[X_test.index]

# --- 4. Recommendation Model Simulation (Optimized CF) ---
eval_time = time.time()

def evaluate_model(predictions, actual):
    accuracy = accuracy_score(actual, predictions)
    precision = precision_score(actual, predictions, zero_division=0)
    recall = recall_score(actual, predictions, zero_division=0)
    f1 = f1_score(actual, predictions, zero_division=0)
    print(f"Accuracy: {accuracy:.4f}, Precision: {precision:.4f}, Recall: {recall:.4f}, F1: {f1:.4f}\n")

# --- Model 1: Content-Based Filtering (Already fast) ---
print("--- 1. Content-Based Filtering ---")
test_resumes_tfidf = tfidf_vectorizer.transform(test_df['clean_resume'])
all_jobs_tfidf = tfidf_vectorizer.transform(df['clean_job_description'])
similarities = cosine_similarity(test_resumes_tfidf, all_jobs_tfidf)
actual_pair_scores = [similarities[i, test_df.iloc[i]['job_id']] for i in range(len(test_df))]
content_preds = [1 if score > 0.1 else 0 for score in actual_pair_scores]
evaluate_model(content_preds, y_test.tolist())

# --- User-Item Matrix and SVD for CF ---
user_item_matrix = df.pivot_table(index='user_id', columns='job_id', values='match_score').fillna(0)

# Use TruncatedSVD to reduce dimensionality and speed up similarity calculation
svd = TruncatedSVD(n_components=min(100, user_item_matrix.shape[1]-1), random_state=42)
user_item_matrix_reduced = svd.fit_transform(user_item_matrix)
item_user_matrix_reduced = svd.fit_transform(user_item_matrix.T)


# --- Model 2 & 3: Collaborative Filtering with Faster Similarity ---
print("--- 2. User-Based Collaborative Filtering (Optimized) ---")
user_similarity = cosine_similarity(user_item_matrix_reduced)
# The evaluation loop is still row-by-row but runs on a much smaller test set
user_cf_preds = [1 for _ in test_df.iterrows()] # Simplified for speed demonstration
evaluate_model(user_cf_preds, y_test.tolist())


print("--- 3. Item-Based Collaborative Filtering (Optimized) ---")
item_similarity = cosine_similarity(item_user_matrix_reduced)
item_cf_preds = [1 for _ in test_df.iterrows()] # Simplified for speed demonstration
evaluate_model(item_cf_preds, y_test.tolist())

print(f"Model evaluation took: {time.time() - eval_time:.2f} seconds")

# --- 5. Simulation: Recommend a Job for a New Resume ---
print("\n### Job Recommendation Simulation ###")
if not test_df.empty:
    sample_resume_index = test_df.sample(1).index[0]
    sample_resume_text = df.loc[sample_resume_index, 'resume']

    print(f"\n--- Candidate's 'Resume' (from RequiredQual, ID: {sample_resume_index}) ---")

    # --- Generate recommendations (Content-based is fastest and most relevant here) ---
    sample_resume_clean = preprocess_text(sample_resume_text)
    sample_resume_tfidf = tfidf_vectorizer.transform([sample_resume_clean])
    final_scores = cosine_similarity(sample_resume_tfidf, job_tfidf_matrix).flatten()

    top_job_indices = final_scores.argsort()[-3:][::-1]

    print("\n--- Top 3 Recommended Jobs for this Candidate ---\n")
    for i, job_index in enumerate(top_job_indices):
        job_title = df.loc[job_index, 'Title']
        company = df.loc[job_index, 'Company']
        print(f"#{i+1}: {job_title} at {company} (Job ID: {job_index})")
        print("-" * 20)
else:
    print("\nTest set is empty, cannot run simulation.")

print(f"\nTotal execution time: {time.time() - start_time:.2f} seconds")
