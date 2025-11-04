# python_recommender/fastapi_server.py
from fastapi import FastAPI, HTTPException
from fastapi.responses import JSONResponse
import uvicorn
import pandas as pd
import os
from typing import Optional

# import your recommender functions
from recommender_content import content_based_recommendation
from recommender_collab import collaborative_item_based

app = FastAPI(title="Recommender Test API")

# Adjust these paths to where your job / user CSVs live
BASE = os.path.abspath(os.path.join(os.path.dirname(__file__), '..'))
JOBS_CSV = os.path.join(BASE, 'public', 'postings.csv')
USERS_CSV = os.path.join(BASE, 'public', 'resume_job_matching_dataset.csv')

# Lazy load dataframes
_jobs_df = None
_users_df = None

def load_jobs():
    global _jobs_df
    if _jobs_df is None:
        try:
            _jobs_df = pd.read_csv(JOBS_CSV)
        except Exception:
            # fallback: empty DataFrame with expected columns
            _jobs_df = pd.DataFrame(columns=["ID", "TITLE", "DESCRIPTION", "REQUIRED_SKILLS", "COMPANY_NAME", "INDUSTRY"])
    return _jobs_df

def load_users():
    global _users_df
    if _users_df is None:
        try:
            _users_df = pd.read_csv(USERS_CSV)
        except Exception:
            _users_df = pd.DataFrame(columns=["ID", "SKILLS", "WORK_EXPERIENCE", "PREFERRED_ENVIRONMENT", "JOB_PREFERENCE", "CERTIFICATE"])
    return _users_df

@app.get("/recs/{uid}")
def get_recs(uid: str, top_n: Optional[int] = 10):
    jobs_df = load_jobs()
    users_df = load_users()
    # interactions_df empty so collaborative function will try to seed from CBF
    interactions_df = pd.DataFrame(columns=["USER_ID", "JOB_ID", "FIT_SCORE"])
    try:
        recs, meta = collaborative_item_based(uid, jobs_df, interactions_df, users_df=users_df, top_n=top_n, seed_with_cbf=True)
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))
    return JSONResponse({"uid": uid, "count": len(recs), "recs": recs, "meta": meta})

if __name__ == "__main__":
    uvicorn.run("python_recommender.fastapi_server:app", host="127.0.0.1", port=8001, reload=True)