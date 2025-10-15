# Recommendations API (FastAPI)

This small FastAPI app exposes an endpoint to run the Python generator and return status or results.

Requirements
- Python 3.8+ (3.10 recommended)
- Install the requirements (create a venv optional):

Windows PowerShell:

```powershell
python -m venv .venv
.\.venv\Scripts\Activate.ps1
pip install -r tools\requirements-reco.txt
```

Run the API (development):

```powershell
uvicorn tools.reco_api:app --host 127.0.0.1 --port 8888 --reload
```

Endpoints
- POST /generate  - JSON: { input?, output?, max_features?, wait? }
- GET  /status/{job_id}
- GET  /recommendations  - returns the generated JSON
- GET  /health

Notes
- The API runs the generator by importing the `generate` function from `tools/generate_recommendations.py`. If import fails, /generate will return 500 with the import error.
- For production use, run Uvicorn behind a process manager and secure the endpoint (auth/middleware) — don't expose directly to the Internet without protection.
