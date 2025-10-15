@echo off
REM Convenience wrapper to run the Python recommendation generator on Windows (PowerShell friendly)
SETLOCAL
SET PY=python
IF "%~1"=="" (
  "%PY%" "%~dp0\generate_recommendations.py" --input "public/resume_job_matching_dataset.csv" --output "public/recommendations.json"
) ELSE (
  "%PY%" "%~dp0\generate_recommendations.py" --input "%~1" --output "%~2"
)
ENDLOCAL
