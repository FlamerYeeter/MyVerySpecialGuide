import asyncio
import os
import pathlib
import sys
import uuid
import json
from typing import Optional

from fastapi import FastAPI, HTTPException
from fastapi.responses import JSONResponse
from pydantic import BaseModel

# Ensure the tools directory is importable so we can import generate_recommendations.py
BASE_DIR = pathlib.Path(__file__).resolve().parent
if str(BASE_DIR) not in sys.path:
    sys.path.insert(0, str(BASE_DIR))

try:
    from generate_recommendations import generate
except Exception as e:
    # Keep import errors visible but allow the app to start for debugging
    generate = None
    _import_error = e
else:
    _import_error = None

app = FastAPI(title="Mvsg Recommendations API")

class GenRequest(BaseModel):
    input: Optional[str] = None
    output: Optional[str] = None
    max_features: int = 5000
    wait: bool = False  # if true, wait for completion and return result
    per_user: bool = False
    users: Optional[str] = None

# simple in-memory job registry (sufficient for small/temporary use)
_jobs = {}

def _tail_log(path: str, lines: int = 200):
    try:
        if not os.path.exists(path):
            return []
        with open(path, 'rb') as f:
            f.seek(0, os.SEEK_END)
            size = f.tell()
            block = 1024
            data = b''
            while size > 0 and lines > 0:
                seek = max(0, size - block)
                f.seek(seek)
                chunk = f.read(min(block, size))
                data = chunk + data
                size = seek
                if data.count(b'\n') > lines:
                    break
            text = data.decode('utf-8', errors='replace')
            return text.strip().split('\n')[-lines:]
    except Exception:
        return []

async def _run_job(job_id: str, input_path: str, output_path: str, max_features: int):
    _jobs[job_id] = {"status": "running"}
    try:
        # call the generate() function in a thread to avoid blocking the event loop
        # note: generate() signature: generate(input_csv, output_json=None, max_features=5000, print_per_user=False, users_json=None, top_n=10, alpha=0.6, neighbors=5)
        rc = await asyncio.to_thread(generate, input_path, output_path, max_features)
        _jobs[job_id]["status"] = "finished"
        _jobs[job_id]["rc"] = int(rc or 0)
        _jobs[job_id]["output"] = output_path
        # attach recent logs if available
        log_path = os.path.join(BASE_DIR, 'reco.log')
        _jobs[job_id]['logs'] = _tail_log(log_path, lines=200)
    except Exception as e:
        _jobs[job_id]["status"] = "error"
        _jobs[job_id]["error"] = str(e)
        log_path = os.path.join(BASE_DIR, 'reco.log')
        _jobs[job_id]['logs'] = _tail_log(log_path, lines=200)

@app.on_event("startup")
async def startup_event():
    if _import_error:
        # If the generator failed to import, log a warning into the default job registry
        _jobs["__import_error__"] = {"status": "error", "error": str(_import_error)}

@app.post("/generate")
async def generate_route(req: GenRequest):
    """
    Trigger generation of recommendations.json.
    POST JSON: { input?: str, output?: str, max_features?: int, wait?: bool }

    If wait=true the request will block until completion (or failure).
    """
    if generate is None:
        raise HTTPException(status_code=500, detail=f"Generator not importable: {_import_error}")

    input_path = req.input or str((BASE_DIR.parent / '..' / 'public' / 'resume_job_matching_dataset.csv').resolve())
    output_path = req.output or str((BASE_DIR.parent / '..' / 'public' / 'recommendations.json').resolve())
    # normalize
    input_path = os.path.normpath(input_path)
    output_path = os.path.normpath(output_path)

    job_id = str(uuid.uuid4())
    # if per_user requested and users path provided, call generate directly in a thread with users and write per-user output
    if req.per_user:
        users_path = req.users
        if not users_path:
            raise HTTPException(status_code=400, detail='per_user generation requires `users` path')
        # use output as target per-user JSON
        out_path = output_path or str((BASE_DIR.parent / '..' / 'tools' / 'reco_per_user.json').resolve())
        task = asyncio.create_task(asyncio.to_thread(generate, input_path, out_path, int(req.max_features), True, users_path))
    else:
        # start background job for global generation
        task = asyncio.create_task(_run_job(job_id, input_path, output_path, int(req.max_features)))

    if req.wait:
        await task
        return _jobs.get(job_id, {"status": "unknown"})

    return {"job_id": job_id, "status": "started", "input": input_path, "output": output_path}

@app.get("/status/{job_id}")
async def status(job_id: str):
    j = _jobs.get(job_id)
    if not j:
        raise HTTPException(status_code=404, detail="Job not found")
    return j

@app.get("/recommendations")
async def get_recommendations():
    path = (BASE_DIR.parent / '..' / 'public' / 'recommendations.json').resolve()
    if not path.exists():
        raise HTTPException(status_code=404, detail="recommendations.json not found")
    with open(path, 'r', encoding='utf-8') as f:
        data = json.load(f)
    return JSONResponse(content=data)


@app.get("/")
async def root():
    """
    Root index — provide a small JSON summary and links.
    If `public/recommendations.json` exists, point clients to the `/recommendations` endpoint.
    """
    rec_path = (BASE_DIR.parent / '..' / 'public' / 'recommendations.json').resolve()
    if rec_path.exists():
        return {
            "ok": True,
            "message": "Recommendations available",
            "recommendations": "/recommendations",
            "health": True,
            "generator_imported": (generate is not None),
        }
    return {
        "ok": True,
        "message": "Mvsg Recommendations API (no recommendations.json found)",
        "health": True,
        "generator_imported": (generate is not None),
    }

@app.get("/health")
async def health():
    return {"ok": True, "generator_imported": (generate is not None)}
