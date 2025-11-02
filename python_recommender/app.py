from fastapi import FastAPI, HTTPException
from typing import Any
from db import fetch_table
from recommender_content import content_based_recommendation
from recommender_collab import collaborative_item_based

app = FastAPI(title="MVSG Recommender")


@app.get("/recommend/{user_id}")
def recommend(user_id: int, top_n: int = 10) -> Any:
    """Return two separate lists: content_based and collaborative recommendations."""
    try:
        users = fetch_table("SELECT * FROM MVSG_USER_GUARDIAN")
        jobs = fetch_table("SELECT * FROM MVSG_JOB_LISTINGS")
        interactions = fetch_table("SELECT * FROM MVSG_RECOMMENDATION")
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"DB fetch failed: {e}")

    cbf = content_based_recommendation(user_id, users, jobs, top_n=top_n)
    cf = collaborative_item_based(user_id, jobs, interactions, top_n=top_n)

    return {
        "content_based": cbf,
        "collaborative": cf,
    }
