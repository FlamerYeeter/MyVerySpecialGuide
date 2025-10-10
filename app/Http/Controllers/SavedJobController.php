<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavedJobController extends Controller
{
    // Show saved jobs
    public function index()
    {
        $savedJobs = session('saved_jobs', []);
        return view('my-job-applications', ['savedJobs' => $savedJobs]);
    }

    // Save a job
    public function store(Request $request)
    {
        $jobId = $request->input('job_id');
        $savedJobs = session('saved_jobs', []);
        if (!in_array($jobId, $savedJobs)) {
            $savedJobs[] = $jobId;
            session(['saved_jobs' => $savedJobs]);
        }
        return redirect()->route('my.job.applications');
    }

    // Remove a saved job
    public function destroy(Request $request)
    {
        $jobId = $request->input('job_id');
        $savedJobs = session('saved_jobs', []);
        $savedJobs = array_diff($savedJobs, [$jobId]);
        session(['saved_jobs' => $savedJobs]);
        return redirect()->route('my.job.applications');
    }
}
