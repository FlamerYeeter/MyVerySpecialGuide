<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirestoreAdminService;
use App\Services\JobCsvParser;

class SavedJobController extends Controller
{
    protected $firestore;
    protected $csvParser;

    public function __construct(FirestoreAdminService $firestore, JobCsvParser $csvParser)
    {
        $this->firestore = $firestore;
        $this->csvParser = $csvParser;
    }

    // Show saved jobs
    public function index(Request $request)
    {
        $savedIds = [];
        // Prefer Laravel-authenticated user's firebase_uid when available
        $firebaseUid = null;
        try {
            if (auth()->check() && !empty(auth()->user()->firebase_uid)) {
                $firebaseUid = auth()->user()->firebase_uid;
            }
        } catch (\Throwable $e) { /* ignore */ }

        if ($firebaseUid) {
            $savedIds = $this->firestore->getSavedJobs($firebaseUid);
        }

        // Fallback to session-stored saved jobs when no firebase uid or Firestore empty
        if (empty($savedIds)) {
            $savedIds = session('saved_jobs', []);
        }

        // Resolve job metadata for each saved id (use JobCsvParser)
        $savedJobs = [];
        foreach ((array)$savedIds as $jid) {
            // normalize p-prefixed ids (client uses p{index}) to allow CSV lookup
            $lookup = $jid;
            if (is_string($lookup) && preg_match('/^p(\d+)$/i', $lookup, $m)) {
                $lookup = intval($m[1]);
            }
            try {
                $job = $this->csvParser->findJobById($lookup);
                if ($job) {
                    $savedJobs[] = $job;
                } else {
                    // keep minimal placeholder if CSV lookup fails
                    $savedJobs[] = ['job_id' => $jid, 'title' => 'Saved job', 'company' => '', 'location' => '', 'description' => ''];
                }
            } catch (\Throwable $e) {
                $savedJobs[] = ['job_id' => $jid, 'title' => 'Saved job', 'company' => '', 'location' => '', 'description' => ''];
            }
        }

        return view('saved-jobs', ['savedJobs' => $savedJobs]);
    }

    // Save a job (POST)
    public function store(Request $request)
    {
        $jobId = $request->input('job_id');
        if (!$jobId) return redirect()->route('my.job.applications');

        // Update session fallback
        $savedJobs = session('saved_jobs', []);
        if (!in_array($jobId, $savedJobs)) {
            $savedJobs[] = $jobId;
            session(['saved_jobs' => $savedJobs]);
        }

        // If user has firebase uid, persist to Firestore
        try {
            if (auth()->check() && !empty(auth()->user()->firebase_uid)) {
                $uid = auth()->user()->firebase_uid;
                $remote = $this->firestore->getSavedJobs($uid) ?: [];
                if (!in_array($jobId, $remote)) {
                    $remote[] = $jobId;
                    $this->firestore->setSavedJobs($uid, $remote);
                }
            }
        } catch (\Throwable $e) {
            logger()->warning('SavedJobController: failed to persist saved job to Firestore: ' . $e->getMessage());
        }

        return redirect()->route('my.job.applications');
    }

    // Convenience: save a job via GET (useful for anchor fallback). Adds job to session and
    // persists to Firestore when possible, then redirects to the saved jobs page.
    public function add($jobId)
    {
        if (!$jobId) return redirect()->route('my.job.applications');
        $savedJobs = session('saved_jobs', []);
        if (!in_array($jobId, $savedJobs)) {
            $savedJobs[] = $jobId;
            session(['saved_jobs' => $savedJobs]);
        }
        try {
            if (auth()->check() && !empty(auth()->user()->firebase_uid)) {
                $uid = auth()->user()->firebase_uid;
                $remote = $this->firestore->getSavedJobs($uid) ?: [];
                if (!in_array($jobId, $remote)) {
                    $remote[] = $jobId;
                    $this->firestore->setSavedJobs($uid, $remote);
                }
            }
        } catch (\Throwable $e) { logger()->warning('SavedJobController:add persistence failed: ' . $e->getMessage()); }
        return redirect()->route('my.job.applications');
    }

    // Remove a saved job
    public function destroy(Request $request)
    {
        $jobId = $request->input('job_id');
        if ($jobId) {
            $savedJobs = session('saved_jobs', []);
            $savedJobs = array_values(array_diff($savedJobs, [$jobId]));
            session(['saved_jobs' => $savedJobs]);
            try {
                if (auth()->check() && !empty(auth()->user()->firebase_uid)) {
                    $uid = auth()->user()->firebase_uid;
                    $remote = $this->firestore->getSavedJobs($uid) ?: [];
                    $remote = array_values(array_diff($remote, [$jobId]));
                    $this->firestore->setSavedJobs($uid, $remote);
                }
            } catch (\Throwable $e) { logger()->warning('SavedJobController: destroy firestore failed: ' . $e->getMessage()); }
        }
        return redirect()->route('my.job.applications');
    }
}
