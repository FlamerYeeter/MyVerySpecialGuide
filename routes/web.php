<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecommenderDebugController;
// Oracle registration server-backed endpoints will be added below (draft/submit handlers)
use App\Http\Controllers\SavedJobController;
use App\Http\Controllers\JobApplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;

Route::get('/', function () {
    return view('home');
})->name('home');

// Recommender debug route: optional userId. Visit /recommender/debug or /recommender/debug/{userId}
Route::get('/recommender/debug/{userId?}', [RecommenderDebugController::class, 'debug'])->name('recommender.debug');

/*
Route::get('/', function () {
    return view('job_application_2');
})->name('job_application_2');
*/

Route::get('/register', function () {
    return view('ds_register_1');
})->name('register');


/*
Route::get('/applyassessment', function () {
    return view('apply-assessment');
})->name('applyassessment');
*/

// Navigation buttons page (used by login/back links)
Route::get('/navigationbuttons', function () {
    return view('navigation-buttons');
})->name('navigationbuttons');

// Endpoint for client-side logs (lightweight, accepts JSON {level, message, meta})
Route::post('/client-log', function (\Illuminate\Http\Request $req) {
    $data = $req->json()->all();
    $level = $data['level'] ?? 'info';
    $message = $data['message'] ?? '<no message>'; 
    $meta = $data['meta'] ?? [];
    try {
        switch (strtolower($level)) {
            case 'debug': logger()->debug($message, $meta); break;
            case 'warning': logger()->warning($message, $meta); break;
            case 'error': logger()->error($message, $meta); break;
            default: logger()->info($message, $meta); break;
        }
    } catch (\Throwable $e) {
            return view('home');
    }

        // Recommender debug route (calls local Python recommender service)
    return response()->json(['ok' => true]);
});
// Quick debug route to call the Oracle-backed recommender (no login required).
Route::get('/debug/oracle-recs', [\App\Http\Controllers\RecommendationController::class, 'oracleRecommendations']);
// Debug route to list job postings directly from Oracle (bounded)
Route::get('/debug/job-postings', [\App\Http\Controllers\RecommendationController::class, 'oracleJobPostings']);

// Navigation targets used by navigation-buttons view
Route::get('/why-this-job-1', function (\Illuminate\Http\Request $request) {
    // Require authenticated Laravel session; do not accept uid overrides.
    if (!\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('login');
    }
    $laravelId = (string)\Illuminate\Support\Facades\Auth::id();
    // keep the old $uid usage for view/debugging (local numeric id)
    $uid = $laravelId;
    $safeUid = preg_replace('/[^A-Za-z0-9_\-]/', '_', $laravelId ?: 'anonymous');

    // Load approvals (local fallback)
    $approvalsPath = storage_path('app/guardian_job_approvals.json');
    $approvals = [];
    if (file_exists($approvalsPath)) {
        $raw = @file_get_contents($approvalsPath);
        $approvals = $raw ? (json_decode($raw, true) ?: []) : [];
    }

    $approvedIds = [];
    if (is_array($approvals)) {
        foreach ($approvals as $jobId => $meta) {
            if (is_array($meta) && isset($meta['status']) && strtolower($meta['status']) === 'approved') {
                $approvedIds[] = (string)$jobId;
            }
        }
    }

    // Load per-user recommendation cache if present (prefer this and return early)
    $recoPath = storage_path('app/reco_user_' . $safeUid . '.json');
    $reco = null;
    if (file_exists($recoPath)) {
        $raw = @file_get_contents($recoPath);
        $decoded = $raw ? (json_decode($raw, true) ?: null) : null;
        if (is_array($decoded)) {
            // Accept either a uid-keyed map or a direct array of recommendations
            $recs = null;
            if (array_key_exists($uid, $decoded) && is_array($decoded[$uid])) {
                $recs = $decoded[$uid];
            } else {
                $recs = $decoded;
            }

            if (is_array($recs) && count($recs) > 0) {
                // Map server recommendation shape into the 'approvedJobs' structure expected by this template
                $mapped = [];
                foreach ($recs as $r) {
                    if (!is_array($r)) continue;
                    $assoc = [];
                    $assoc['title'] = $r['Title'] ?? $r['title'] ?? $r['job_title'] ?? '';
                    $assoc['job_title'] = $assoc['title'];
                    $assoc['company'] = $r['Company'] ?? $r['company'] ?? '';
                    // normalize skills field(s)
                    $skills = $r['matching_skills'] ?? $r['skills'] ?? $r['skill_tags'] ?? [];
                    if (is_string($skills)) $skills = array_filter(array_map('trim', preg_split('/[,;\n]+/', $skills)));
                    if (!is_array($skills)) $skills = [];
                    $assoc['skills'] = array_values(array_unique(array_filter(array_map(function($s){ return is_scalar($s) ? (string)$s : ''; }, $skills))));

                    $mapped[] = [
                        'job_id' => $r['job_id'] ?? ($r['id'] ?? null),
                        'assoc' => $assoc,
                        'match_score' => $r['hybrid_score'] ?? $r['match_score'] ?? $r['score'] ?? null,
                        'job_description' => $r['job_description'] ?? $r['JobDescription'] ?? ''
                    ];
                }

                if (!empty($mapped)) {
                    // Return the view immediately using per-user recommendations so the template
                    // can focus only on rendering skills and not on loading files itself.
                    return view('why-this-job-1', ['approvedJobs' => $mapped, 'uid' => $uid]);
                }
            }
        }
    }

    // Try to load Firestore profile for authoritative matching skills
    $fsProfile = null;
    try {
        // Prefer a firebase_uid persisted on the local user record; fall back to session
        $fsUid = null;
        try {
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user && !empty($user->firebase_uid)) {
                $fsUid = (string)$user->firebase_uid;
                logger()->info('why-this-job: using firebase_uid from user model', ['hint' => substr($fsUid, 0, 6) . '...']);
            }
        } catch (\Throwable $__e) {
            // ignore
        }

        if (!$fsUid) {
            $fsUid = session('firebase_uid', null);
            if ($fsUid) {
                logger()->info('why-this-job: using firebase_uid from session', ['hint' => substr($fsUid, 0, 6) . '...']);
            }
        }

        if ($fsUid) {
            $fs = app(\App\Http\Controllers\GuardianJobController::class)->fetchUserProfileFromFirestore($fsUid);
            if (is_array($fs)) $fsProfile = $fs;
        } else {
            logger()->info('why-this-job: no firebase_uid available; skipping Firestore profile fetch', ['laravel_id' => $laravelId]);
        }
    } catch (\Throwable $e) {
        logger()->warning('why-this-job: Firestore profile fetch failed: ' . $e->getMessage());
        $fsProfile = null;
    }

    // Debug: log the fetched profile shape (redact sensitive fields if needed)
    try {
        if (is_array($fsProfile)) {
            logger()->info('why-this-job: fetched Firestore profile', ['uid' => $uid, 'profile_keys' => array_keys($fsProfile)]);
        } else {
            logger()->info('why-this-job: no Firestore profile found for uid', ['uid' => $uid]);
        }
    } catch (\Throwable $__e) {}

    $jobs = [];
    try {
        $parser = new \App\Services\JobCsvParser();
        // a small list of common skill tokens to surface when the reco doesn't include explicit skills
        $COMMON_SKILLS = ['communication','teamwork','organization','cleaning','customer service','problem solving','excel','microsoft','management','leadership','sales','cooking','following instructions','working with others','organization','revit','data','analysis','programming','teaching','caregiving'];

        foreach ($approvedIds as $jobId) {
            $assoc = $parser->findJobById($jobId);
            // attempt to find the job in reco output (if it's an array of objects)
            $foundReco = null;
            if (is_array($reco)) {
                // reco may be a list of job objects or map; try both
                if (array_keys($reco) !== range(0, count($reco) - 1)) {
                    // associative map: job_id => obj
                    if (isset($reco[$jobId])) $foundReco = $reco[$jobId];
                } else {
                    foreach ($reco as $r) {
                        if (is_array($r) && (isset($r['job_id']) && strval($r['job_id']) === strval($jobId))) {
                            $foundReco = $r;
                            break;
                        }
                    }
                }
            }

            // Primary: pull skills from Firestore profile (if available)
            $matchingSkills = [];
            if (is_array($fsProfile)) {
                // Primary candidate: a top-level explicit matching_skills array
                if (!empty($fsProfile['matching_skills']) && is_array($fsProfile['matching_skills'])) {
                    $matchingSkills = $fsProfile['matching_skills'];
                }

                // Next: a 'skills' map is common in your dataset. It may contain fields
                // like skills_page1/skills_page2 which are JSON-encoded arrays stored as strings.
                if (empty($matchingSkills) && !empty($fsProfile['skills']) && is_array($fsProfile['skills'])) {
                    $skillsNode = $fsProfile['skills'];
                    $s = [];
                    // If skills_page1/2 exist as strings, decode them
                    try {
                        if (!empty($skillsNode['skills_page1']) && is_string($skillsNode['skills_page1'])) {
                            $decoded = json_decode($skillsNode['skills_page1'], true);
                            if (is_array($decoded)) $s = array_merge($s, $decoded);
                        }
                    } catch (\Throwable $__e) {}
                    try {
                        if (!empty($skillsNode['skills_page2']) && is_string($skillsNode['skills_page2'])) {
                            $decoded = json_decode($skillsNode['skills_page2'], true);
                            if (is_array($decoded)) $s = array_merge($s, $decoded);
                        }
                    } catch (\Throwable $__e) {}

                    // If the skills node itself is a simple list like ['skill1','skill2'] normalize that too
                    $isIndexedList = array_values($skillsNode) === $skillsNode;
                    if ($isIndexedList) {
                        foreach ($skillsNode as $v) {
                            if (is_scalar($v)) $s[] = (string)$v;
                        }
                    }

                    if (!empty($s) && is_array($s)) {
                        $matchingSkills = $s;
                    }
                }

                // Also accept top-level skills_page1 / skills_page2 fields (some profiles store them at root)
                if (empty($matchingSkills) && (!empty($fsProfile['skills_page1']) || !empty($fsProfile['skills_page2']))) {
                    $s = [];
                    try { if (!empty($fsProfile['skills_page1']) && is_string($fsProfile['skills_page1'])) $s = array_merge($s, json_decode($fsProfile['skills_page1'], true) ?: []); } catch (\Throwable $__e) {}
                    try { if (!empty($fsProfile['skills_page2']) && is_string($fsProfile['skills_page2'])) $s = array_merge($s, json_decode($fsProfile['skills_page2'], true) ?: []); } catch (\Throwable $__e) {}
                    if (!empty($s) && is_array($s)) $matchingSkills = $s;
                }

                // Normalize any found skills into a clean array of strings
                if (!empty($matchingSkills) && is_array($matchingSkills)) {
                    $normalized = [];
                    foreach ($matchingSkills as $item) {
                        if (is_scalar($item)) {
                            $val = trim((string)$item);
                            if ($val !== '') $normalized[] = $val;
                        } elseif (is_array($item)) {
                            // if nested map, try to extract plausible string values
                            foreach ($item as $sub) {
                                if (is_scalar($sub)) {
                                    $val = trim((string)$sub);
                                    if ($val !== '') $normalized[] = $val;
                                }
                            }
                        }
                    }
                    $matchingSkills = array_values(array_unique($normalized));
                }
            }

            // Secondary: fallback to reco cache keys (if profile didn't provide skills)
            if (empty($matchingSkills) && is_array($foundReco)) {
                $skillKeys = ['matching_skills', 'skills', 'keywords', 'tags', 'match_skills', 'matching_skills_v2'];
                foreach ($skillKeys as $k) {
                    if (!empty($foundReco[$k]) && is_array($foundReco[$k])) {
                        $matchingSkills = $foundReco[$k];
                        break;
                    }
                    if (!empty($foundReco[$k]) && is_string($foundReco[$k])) {
                        $parts = array_filter(array_map('trim', explode(',', $foundReco[$k])));
                        if (!empty($parts)) {
                            $matchingSkills = array_values($parts);
                            break;
                        }
                    }
                }
            }

            // Final fallback: scan job description for common skill tokens
            if (empty($matchingSkills) && is_array($assoc)) {
                $desc = strtolower($assoc['job_description'] ?? ($assoc['description'] ?? ''));
                $found = [];
                foreach ($COMMON_SKILLS as $token) {
                    if (stripos($desc, $token) !== false) $found[] = ucwords($token);
                }
                $matchingSkills = array_slice(array_unique($found), 0, 6);
            }

            $jobs[] = [
                'job_id' => $jobId,
                'assoc' => $assoc,
                'matching_skills' => $matchingSkills,
                'match_score' => is_array($foundReco) && isset($foundReco['match_score']) ? $foundReco['match_score'] : null,
                'approval' => $approvals[$jobId] ?? null,
            ];
        }
    } catch (\Throwable $e) {
        logger()->warning('why-this-job route assembly failed: ' . $e->getMessage());
    }

    return view('why-this-job-1', ['approvedJobs' => $jobs, 'uid' => $uid]);
})->name('why.this.job.1');

// Route to show a single job's "Why this job" details (auth-protected)
Route::get('/why-this-job-2', function (Request $request) {
    if (!\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('login');
    }
    $laravelId = (string)\Illuminate\Support\Facades\Auth::id();
    $uid = $laravelId;

    $jobId = $request->query('job_id') ?? $request->query('id') ?? null;
    $jobForView = null;

    try {
        // Try per-user reco first (map shapes similar to why-this-job-1)
        $safeUid = preg_replace('/[^A-Za-z0-9_\-]/', '_', $laravelId ?: 'anonymous');
        $recoPath = storage_path('app/reco_user_' . $safeUid . '.json');
        if ($jobId && file_exists($recoPath)) {
            $raw = @file_get_contents($recoPath);
            $decoded = $raw ? (json_decode($raw, true) ?: null) : null;
            $recs = null;
            if (is_array($decoded)) {
                if (array_key_exists($laravelId, $decoded) && is_array($decoded[$laravelId])) {
                    $recs = $decoded[$laravelId];
                } else {
                    $recs = $decoded;
                }
            }
            if (is_array($recs)) {
                // search for job by job_id key or id field
                foreach ($recs as $r) {
                    if (!is_array($r)) continue;
                    // canonical id from explicit fields
                    $candId = isset($r['job_id']) ? (string)$r['job_id'] : (isset($r['id']) ? (string)$r['id'] : null);
                    // deterministic fallback hash (match job-matches / guardian behavior)
                    $titleF = trim((string)($r['title'] ?? $r['Title'] ?? $r['job_title'] ?? $r['job_description'] ?? ''));
                    $companyF = trim((string)($r['company'] ?? $r['Company'] ?? $r['company_name'] ?? ''));
                    $locF = trim((string)($r['location'] ?? ''));
                    $hashFallback = md5(($titleF ?: substr((string)($r['job_description'] ?? ''),0,200)) . '|' . $companyF . '|' . $locF);
                    if (($candId !== null && strval($candId) === strval($jobId)) || strval($hashFallback) === strval($jobId)) {
                        $assoc = [];
                        $assoc['title'] = $r['Title'] ?? $r['title'] ?? $r['job_title'] ?? '';
                        $assoc['company'] = $r['Company'] ?? $r['company'] ?? '';
                        $skills = $r['matching_skills'] ?? $r['skills'] ?? $r['skill_tags'] ?? [];
                        if (is_string($skills)) $skills = array_filter(array_map('trim', preg_split('/[,;\n]+/', $skills)));
                        if (!is_array($skills)) $skills = [];
                        $assoc['skills'] = array_values(array_unique(array_filter($skills)));

                        $jobForView = [
                            'job_id' => $candId,
                            'assoc' => $assoc,
                            'match_score' => $r['hybrid_score'] ?? $r['match_score'] ?? $r['score'] ?? null,
                            'job_description' => $r['job_description'] ?? $r['JobDescription'] ?? ''
                        ];
                        break;
                    }
                }
            }
        }

        // Fallback: if not found in per-user reco, use JobCsvParser to locate by id
        if (!$jobForView && $jobId) {
            $parser = new \App\Services\JobCsvParser();
            $assoc = $parser->findJobById($jobId);
            if (is_array($assoc) && !empty($assoc)) {
                // try to extract skills tokens if present
                $skills = [];
                if (!empty($assoc['skills_desc']) && is_string($assoc['skills_desc'])) {
                    $skills = array_filter(array_map('trim', preg_split('/[,;\n]+/', $assoc['skills_desc'])));
                }
                $jobForView = [
                    'job_id' => $jobId,
                    'assoc' => [
                        'title' => $assoc['title'] ?? $assoc['job_title'] ?? $assoc['Title'] ?? '',
                        'company' => $assoc['company'] ?? $assoc['company_name'] ?? $assoc['Company'] ?? '',
                        'skills' => array_values(array_unique($skills)),
                    ],
                    'match_score' => null,
                    'job_description' => $assoc['job_description'] ?? $assoc['description'] ?? ''
                ];
            }
        }
    } catch (\Throwable $e) {
        logger()->warning('why-this-job-2: failed to assemble job view: ' . $e->getMessage());
    }

    // Compute a server-side human-readable explanation for why this job matches the user
    try {
        $whySentence = null;
        // attempt to resolve firebase uid for profile lookup
        $fsUid = null;
        try {
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user && !empty($user->firebase_uid)) {
                $fsUid = (string)$user->firebase_uid;
            }
        } catch (\Throwable $__e) {}
        if (!$fsUid) {
            $sess = session('firebase_uid', null);
            if ($sess) $fsUid = (string)$sess;
        }

        $profileSkills = [];
        if ($fsUid) {
            try {
                $fs = app(\App\Http\Controllers\GuardianJobController::class)->fetchUserProfileFromFirestore($fsUid);
                if (is_array($fs)) {
                    // extract skills similarly to why-this-job-1 logic
                    if (!empty($fs['matching_skills']) && is_array($fs['matching_skills'])) {
                        $profileSkills = $fs['matching_skills'];
                    }
                    if (empty($profileSkills) && !empty($fs['skills']) && is_array($fs['skills'])) {
                        $snode = $fs['skills'];
                        $s = [];
                        try { if (!empty($snode['skills_page1']) && is_string($snode['skills_page1'])) $s = array_merge($s, json_decode($snode['skills_page1'], true) ?: []); } catch(\Throwable $__e) {}
                        try { if (!empty($snode['skills_page2']) && is_string($snode['skills_page2'])) $s = array_merge($s, json_decode($snode['skills_page2'], true) ?: []); } catch(\Throwable $__e) {}
                        $isIndexed = array_values($snode) === $snode;
                        if ($isIndexed) {
                            foreach ($snode as $v) if (is_scalar($v)) $s[] = (string)$v;
                        }
                        if (!empty($s)) $profileSkills = $s;
                    }
                    if (empty($profileSkills) && (!empty($fs['skills_page1']) || !empty($fs['skills_page2']))) {
                        $s = [];
                        try { if (!empty($fs['skills_page1']) && is_string($fs['skills_page1'])) $s = array_merge($s, json_decode($fs['skills_page1'], true) ?: []); } catch(\Throwable $__e) {}
                        try { if (!empty($fs['skills_page2']) && is_string($fs['skills_page2'])) $s = array_merge($s, json_decode($fs['skills_page2'], true) ?: []); } catch(\Throwable $__e) {}
                        if (!empty($s)) $profileSkills = $s;
                    }
                }
            } catch (\Throwable $__e) {
                logger()->debug('why-this-job-2: profile fetch failed: ' . $__e->getMessage());
            }
        }

        // Normalize skills to lowercase strings
        $normalizedProfileSkills = [];
        if (is_array($profileSkills)) {
            foreach ($profileSkills as $ps) {
                if (is_scalar($ps)) {
                    $v = trim((string)$ps);
                    if ($v !== '') $normalizedProfileSkills[] = strtolower($v);
                }
            }
        }
        $normalizedProfileSkills = array_values(array_unique($normalizedProfileSkills));

        // Job skills from jobForView
        $jobSkills = [];
        if (is_array($jobForView) && isset($jobForView['assoc']) && is_array($jobForView['assoc'])) {
            $js = $jobForView['assoc']['skills'] ?? [];
            if (is_string($js)) $js = array_filter(array_map('trim', preg_split('/[,;\n]+/', $js)));
            if (is_array($js)) {
                foreach ($js as $s) if (is_scalar($s)) $jobSkills[] = strtolower(trim((string)$s));
            }
        }

        // compute intersection and order: prefer jobSkills order as closer
        $matched = [];
        foreach ($jobSkills as $ks) {
            if (in_array($ks, $normalizedProfileSkills)) $matched[] = $ks;
        }

        if (!empty($matched)) {
            // human-friendly formatting
            $displayList = array_map(function($s){ return ucfirst($s); }, array_slice($matched, 0, 5));
            if (count($displayList) === 1) {
                $whySentence = 'This job matches because your profile includes the skill "' . $displayList[0] . '", which is required by this role.';
            } else {
                $last = array_pop($displayList);
                $whySentence = 'This job matches because your profile includes ' . implode(', ', $displayList) . ' and ' . $last . ', which closely match this job\'s required skills.';
            }
            // annotate which is closest (first matched in jobSkills)
            $closest = ucfirst($matched[0]);
            $whySentence .= ' The strongest match is "' . $closest . '".';
        } elseif (!empty($normalizedProfileSkills) && !empty($jobSkills)) {
            // no exact matches but both sides exist: show a looser sentence
            $whySentence = 'This job was recommended because it requires skills related to your profile (e.g., ' . ucfirst($jobSkills[0]) . '), even if we did not find an exact skill overlap.';
        } elseif (!empty($jobSkills)) {
            $whySentence = 'This job requires skills such as ' . ucfirst($jobSkills[0]) . (!empty($jobSkills[1]) ? ', ' . ucfirst($jobSkills[1]) : '') . '. It was recommended by our algorithm based on similar profiles.';
        } else {
            $whySentence = 'This job was recommended based on your profile and our matching algorithm.';
        }

        if (is_array($jobForView)) $jobForView['why_sentence'] = $whySentence;
    } catch (\Throwable $__e) {
        logger()->debug('why-this-job-2: why sentence assembly failed: ' . $__e->getMessage());
    }

    return view('why-this-job-2', ['uid' => $uid, 'job' => $jobForView]);
})->name('why.this.job.2');

// Guardian review routes: pending list and detailed mode
Route::get('/guardian-review/pending', function () {
    return view('guardianreview-pending-review');
})->name('guardianreview.pending');

// Guardian instruction & review list pages
Route::get('/guardian-review/instructions', function () {
    return view('guardianreview-instructions');
})->name('guardianreview.instructions');

Route::get('/guardian-review/approved', function () {
    return view('guardianreview-approved-job');
})->name('guardianreview.approved');

Route::get('/guardian-review/flagged', function () {
    return view('guardianreview-flagged-job');
})->name('guardianreview.flagged');

Route::get('/user-review', function () {
    return view('guardianreview-mode');
})->name('user.review');

// Backward-compatible redirect for older links that still use /guardian-review
Route::get('/guardian-review', function () {
    return redirect()->route('guardianreview.pending');
})->name('guardian.review');

// Application review API endpoints (shared user/guardian module)
use App\Http\Controllers\GuardianReviewController;
use App\Http\Controllers\GuardianJobController;
Route::get('/api/applications', [GuardianReviewController::class, 'list'])->name('api.applications.list')->middleware('auth');
Route::post('/api/applications/{docId}/approve', [GuardianReviewController::class, 'approve'])->name('api.applications.approve')->middleware('auth');
Route::post('/api/applications/{docId}/flag', [GuardianReviewController::class, 'flag'])->name('api.applications.flag')->middleware('auth');

Route::get('/career-goals-progress', function () {
    return view('career-goals-progress');
})->name('career.goals.progress');

// Minimal login page route (user_login.blade.php exists in views)
Route::get('/login', function () {
    return view('user_login');
})->name('login');

// Minimal login page route (user_login.blade.php exists in views)
Route::get('/forgotpassword', function () {
    return view('ds_forgot_password');
})->name('forgotpassword');

// Minimal login page route (company_login.blade.php exists in views)
Route::get('/company.login', function () {
    return view('company-login');
})->name('company.login');

// Logout route used by header sign-out forms
Route::post('/logout', function (Request $request) {
    try {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    } catch (\Throwable $e) {
        logger()->warning('Logout route error: ' . $e->getMessage());
    }
    return redirect()->route('home');
})->name('logout');

// Handle login POST - attempt authentication and redirect to job matches
Route::post('/login', function (Request $request) {
    $credentials = $request->only(['email', 'password']);
    // capture optional redirect early so Oracle branch can respect it
    $redirect = $request->input('redirect');
    // Emergency: try Oracle DB (public/db/oracledb.php) for guardian accounts.
    // Do not edit public/db/oracledb.php — we require it and call getOracleConnection().
    try {
        $oracleFile = public_path('db/oracledb.php');
        if (file_exists($oracleFile)) {
            // load the helper that provides getOracleConnection()
            require_once $oracleFile;
            if (function_exists('getOracleConnection')) {
                try {
                    $conn = getOracleConnection();
                    // lookup guardian by email (case-insensitive) and fetch stored password
                    $sql = 'SELECT EMAIL, PASSWORD, FIRST_NAME, LAST_NAME FROM USER_GUARDIAN WHERE LOWER(EMAIL) = :email';
                    $stid = oci_parse($conn, $sql);
                    $emailLower = strtolower($credentials['email'] ?? '');
                    oci_bind_by_name($stid, ':email', $emailLower);
                    oci_execute($stid);
                    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
                    if ($row) {
                        $stored = isset($row['PASSWORD']) ? $row['PASSWORD'] : (isset($row['password']) ? $row['password'] : null);
                        // direct comparison (emergency): compare plaintext password from form to stored value
                        if (!empty($stored) && isset($credentials['password']) && strval($credentials['password']) === strval($stored)) {
                            // ensure a local User exists and log them in
                            $email = $row['EMAIL'] ?? $credentials['email'];
                            try {
                                $user = User::where('email', $email)->first();
                                if (!$user) {
                                    $user = User::create([
                                        'name' => trim(($row['FIRST_NAME'] ?? '') . ' ' . ($row['LAST_NAME'] ?? '')) ?: explode('@', $email)[0],
                                        'email' => $email,
                                        // random local password; authentication will rely on Oracle for this emergency flow
                                        'password' => bcrypt(bin2hex(random_bytes(8))),
                                    ]);
                                }
                                Auth::login($user);
                                $request->session()->regenerate();
                                logger()->info('Login: authenticated via Oracle USER_GUARDIAN', ['email' => $email]);
                                // Emergency behavior: always land on navigation-buttons after Oracle auth
                                return redirect()->route('navigation_buttons');
                            } catch (\Throwable $__e) {
                                logger()->warning('Oracle login: failed to create/login local user: ' . $__e->getMessage());
                            }
                        }
                    }
                } catch (\Throwable $__e) {
                    logger()->warning('Oracle lookup failed: ' . $__e->getMessage());
                }
            }
        }
    } catch (\Throwable $__e) {
        logger()->warning('Oracle auth integration failed: ' . $__e->getMessage());
    }
    // optional redirect (full URL) to return to after successful login
    // Use Auth facade if available
    try {
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            logger()->info('Login: local Auth succeeded', ['email' => $credentials['email'] ?? null, 'redirect' => $redirect]);

            // If the requested redirect is the navigation-buttons page, require that
            // the user's account has completed verification (either email_verified_at
            // or an application-level 'approved' flag). If not verified, send them
            // to the verification page first and preserve the original redirect.
            try {
                $user = Auth::user();
                $isVerified = false;
                if ($user) {
                    if (!empty($user->email_verified_at) || !empty($user->approved)) {
                        $isVerified = true;
                    }
                }
            } catch (\Throwable $__e) {
                $isVerified = false;
            }

            if (!empty($redirect) && stripos($redirect, '/navigation-buttons') !== false && !$isVerified) {
                logger()->info('Login: user requires verification before navigation-buttons', ['user_id' => $user ? $user->id : null]);
                return redirect()->to(route('registerverifycode') . '?redirect=' . urlencode($redirect));
            }

            // allow only internal redirects: either a path (starts with '/') or same-host URL
            if (!empty($redirect)) {
                $host = parse_url($redirect, PHP_URL_HOST);
                $currentHost = request()->getHost();
                if ($host === null || $host === $currentHost) {
                    logger()->info('Login: performing redirect to requested target', ['target' => $redirect]);
                    return redirect()->to($redirect);
                }
                logger()->warning('Login: blocked external redirect target', ['target' => $redirect, 'currentHost' => $currentHost]);
            }

            // If the authenticated user is an admin, send them to the admin approval area.
            try {
                $user = Auth::user();
                if ($user && !empty($user->role) && $user->role === 'admin') {
                    return redirect()->route('admin.approval');
                }
            } catch (\Throwable $__e) {
                // ignore and fall back to job matches
            }

            return redirect()->route('navigation_buttons');
        }
    } catch (\Throwable $e) {
        // If Auth is not configured, just redirect for now (placeholder)
        // Log the exception to laravel log
        logger()->error('Login error: ' . $e->getMessage());
    }
    // First try Oracle-backed auth (if configured) before falling back to Firebase.
    try {
        $oracleController = app(\App\Http\Controllers\OracleAuthController::class);
        $oracleResp = $oracleController->loginGuardian($request);
        if ($oracleResp instanceof \Illuminate\Http\JsonResponse) {
            $odata = $oracleResp->getData(true);
            if (!empty($odata['ok'])) { 
                logger()->info('Login: Oracle guardian login succeeded', ['email' => $credentials['email'] ?? null]); 
                return redirect()->route('job.matches'); 
            } 
        }
    } catch (\Throwable $__e) {
        // Log and continue to Firebase/local fallbacks
        logger()->warning('Oracle login attempt failed: ' . $__e->getMessage());
    }

    // If local auth failed, and Firebase API key is present, try Firebase REST auth (email/password)
    $firebaseKey = env('FIREBASE_API_KEY');
    // current host used to validate redirect targets
    $currentHost = request()->getHost();
    if ($firebaseKey && !empty($credentials['email']) && !empty($credentials['password'])) {
        try {
            $resp = Http::asForm()->post("https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key={$firebaseKey}", [
                'email' => $credentials['email'],
                'password' => $credentials['password'],
                'returnSecureToken' => true,
            ]);
            if ($resp->successful()) {
                $data = $resp->json();
                $email = $data['email'] ?? $credentials['email'];
                $firebaseUid = $data['localId'] ?? null;
                // find or create local user
                $user = User::where('email', $email)->first();
                if (!$user) {
                    $user = User::create([
                        'name' => explode('@', $email)[0],
                        'email' => $email,
                        // random password (won't be used for firebase-authenticated users)
                        'password' => bcrypt(bin2hex(random_bytes(8))),
                    ]);
                }
                // log the user in via Laravel
                Auth::login($user);
                // Persist the Firebase UID in session so server-side pages can fetch Firestore docs
                try {
                    if (!empty($firebaseUid)) {
                        session(['firebase_uid' => $firebaseUid]);
                        logger()->info('Login: saved firebase_uid to session', ['firebase_uid_hint' => substr($firebaseUid, 0, 6) . '...']);
                        // Also persist to the users table if not already set (so server-side processes
                        // that rely on Auth::user()->firebase_uid can work outside of a single request)
                        try {
                            if (empty($user->firebase_uid) || $user->firebase_uid !== $firebaseUid) {
                                $user->firebase_uid = $firebaseUid;
                                $user->save();
                                logger()->info('Login: persisted firebase_uid to user record', ['user_id' => $user->id, 'firebase_uid_hint' => substr($firebaseUid, 0, 6) . '...']);
                            }
                            // Check Firestore admin assignments and grant local admin flags if present
                            try {
                                $fsAdmin = app(\App\Services\FirestoreAdminService::class);
                                if (!empty($firebaseUid) && $fsAdmin->isAdmin($firebaseUid)) {
                                    // Simplified: only set the role locally. Approval flags not required.
                                    $user->role = 'admin';
                                    $user->save();
                                    logger()->info('Login: granted admin role from Firestore assignment', ['user_id' => $user->id, 'uid_hint' => substr($firebaseUid, 0, 6) . '...']);
                                }
                            } catch (\Throwable $__fs_e) {
                                logger()->warning('Login: Firestore admin check failed: ' . $__fs_e->getMessage());
                            }
                        } catch (\Throwable $__save_e) {
                            logger()->warning('Login: failed to persist firebase_uid to user record: ' . $__save_e->getMessage());
                        }
                    }
                } catch (\Throwable $__e) {
                    // ignore session write failures
                }
                $request->session()->regenerate();
                logger()->info('Login: firebase-auth succeeded and local user logged in', ['email' => $email, 'redirect' => $redirect]);

                // Same verification gate as above: require verification before allowing
                // redirect to the navigation-buttons page.
                try {
                    $user = Auth::user();
                    $isVerified = false;
                    if ($user) {
                        if (!empty($user->email_verified_at) || !empty($user->approved)) {
                            $isVerified = true;
                        }
                    }
                } catch (\Throwable $__e) {
                    $isVerified = false;
                }

                if (!empty($redirect) && stripos($redirect, '/navigation-buttons') !== false && !$isVerified) {
                    logger()->info('Login: user requires verification before navigation-buttons', ['user_id' => $user ? $user->id : null]);
                    return redirect()->to(route('registerverifycode') . '?redirect=' . urlencode($redirect));
                }

                if (!empty($redirect)) {
                    $host = parse_url($redirect, PHP_URL_HOST);
                    $currentHost = request()->getHost();
                    if ($host === null || $host === $currentHost) {
                        logger()->info('Login: performing redirect to requested target', ['target' => $redirect]);
                        return redirect()->to($redirect);
                    }
                    logger()->warning('Login: blocked external redirect target', ['target' => $redirect, 'currentHost' => $currentHost]);
                }

                // If the authenticated user is an admin, send them to the admin approval area.
                try {
                    $user = Auth::user();
                    if ($user && !empty($user->role) && $user->role === 'admin') {
                        return redirect()->route('admin.approval');
                    }
                } catch (\Throwable $__e) {
                    // ignore and fall back to job matches
                }

                return redirect()->route('navigation_buttons');
            } else {
                logger()->warning('Firebase login failed: ' . $resp->body());
            }
        } catch (\Throwable $__e) {
            logger()->warning('Firebase login attempt failed: ' . $__e->getMessage());
        }
    }

    // Firebase REST login removed - Oracle login is used instead.
    // Emergency local fallback: when running in local environment, allow quick login
    // by creating or finding a local user and redirecting to navigation-buttons.
    if (app()->environment('local') && !empty($credentials['email'])) {
        try {
            $email = (string) $credentials['email'];
            $user = User::where('email', $email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => explode('@', $email)[0],
                    'email' => $email,
                    'password' => bcrypt(bin2hex(random_bytes(8))),
                ]);
            }
            Auth::login($user);
            $request->session()->regenerate();
            logger()->warning('Emergency local fallback login used for ' . $email);
            return redirect()->route('navigation_buttons');
        } catch (\Throwable $e) {
            logger()->warning('Emergency local fallback failed: ' . $e->getMessage());
        }
    }

    return back()->withErrors(['email' => 'Login failed. Please check your credentials.'])->withInput();
})->name('login.post');

// Client-side Firebase sign-in helper: accepts a Firebase ID token (idToken) and
// verifies it with the Identity Toolkit API. If valid, create or find a local
// user, log them in, persist firebase_uid to session and the users table.
// /session/firebase-signin removed: registration and sign-in no longer rely on Firebase.

// Debug helper removed: we no longer expose a Firebase-session debug endpoint.

// Development helper: return the server-resolved recommendation cache path and a small summary
// Usage: while signed-in (or in local env) visit /debug/reco-cache to see which per-user cache
// file the server would read for recommendations and a few details (mtime, size, first job_ids)
Route::get('/debug/reco-cache', function (Request $request) {
    try {
        // only allow access when signed-in or in local environment for safety
        if (!app()->environment('local') && !Auth::check()) {
            return response()->json(['ok' => false, 'error' => 'unauthorized - sign in required or run in local env'], 403);
        }

        $resolvedUid = null;
        try {
            if (Auth::check()) {
                $u = Auth::user();
                if (!empty($u->firebase_uid)) $resolvedUid = (string)$u->firebase_uid;
            }
        } catch (\Throwable $__e) {}

        // fallback to session-stored firebase uid
        if (!$resolvedUid) {
            $sess = session('firebase_uid', null);
            if ($sess) $resolvedUid = (string)$sess;
        }

        if (!$resolvedUid) {
            return response()->json(['ok' => false, 'error' => 'no firebase uid resolved (sign in required)'], 400);
        }

        $safeUid = preg_replace('/[^A-Za-z0-9_\-]/', '_', $resolvedUid ?: 'anonymous');
        $cachePath = storage_path('app/reco_user_' . $safeUid . '.json');
        $exists = file_exists($cachePath);
        $mtime = $exists ? @filemtime($cachePath) : null;
        $size = $exists ? @filesize($cachePath) : null;
        $firstIds = [];
        if ($exists) {
            $raw = @file_get_contents($cachePath);
            $json = $raw ? json_decode($raw, true) : null;
            if (is_array($json)) {
                // If JSON is a per-uid map, grab the user's array
                if (array_key_exists($resolvedUid, $json) && is_array($json[$resolvedUid])) {
                    $arr = $json[$resolvedUid];
                } else {
                    $arr = $json;
                }
                // arr may be list of objects or map: extract job_id values
                if (is_array($arr)) {
                    $count = 0;
                    foreach ($arr as $item) {
                        if ($count >= 10) break;
                        if (is_array($item) && isset($item['job_id'])) {
                            $firstIds[] = $item['job_id'];
                            $count++;
                        } elseif (is_scalar($item)) {
                            // if it's a list of job ids already
                            $firstIds[] = $item;
                            $count++;
                        }
                    }
                }
            }
        }

        return response()->json([
            'ok' => true,
            'resolved_uid' => $resolvedUid,
            'safe_uid' => $safeUid,
            'cache_path' => $cachePath,
            'exists' => $exists,
            'mtime' => $mtime,
            'size' => $size,
            'first_job_ids' => $firstIds,
        ]);
    } catch (\Throwable $e) {
        return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
    }
})->name('debug.reco_cache');

// Debug preview of per-user recommendation JSON (local OR signed-in only)
Route::get('/debug/reco-preview', function (Request $request) {
    try {
        // Restrict access: allow local environment, otherwise require admin
        if (!app()->environment('local')) {
            if (!\Illuminate\Support\Facades\Auth::check()) {
                return response()->json(['ok' => false, 'error' => 'unauthorized - sign in required'], 403);
            }
            $u = \Illuminate\Support\Facades\Auth::user();
            $isAdmin = false;
            try {
                if (!empty($u->role) && $u->role === 'admin') $isAdmin = true;
                else {
                    // try Firestore admin assignment as fallback
                    $fsAdmin = app(\App\Services\FirestoreAdminService::class);
                    if (!empty($u->firebase_uid) && $fsAdmin->isAdmin($u->firebase_uid)) $isAdmin = true;
                }
            } catch (\Throwable $__e) {
                // ignore and treat as non-admin
            }
            if (!$isAdmin) return response()->json(['ok' => false, 'error' => 'forbidden - admin only'], 403);
        }

        $provided = $request->query('uid') ?: $request->query('safe_uid') ?: null;
        $resolvedUid = null;
        if ($provided) {
            // accept raw firebase uid (untrusted) or already-safe uid
            $resolvedUid = (string)$provided;
        } else {
            try {
                if (\Illuminate\Support\Facades\Auth::check()) {
                    $u = \Illuminate\Support\Facades\Auth::user();
                    if (!empty($u->firebase_uid)) $resolvedUid = (string)$u->firebase_uid;
                }
            } catch (\Throwable $__e) {}
            if (!$resolvedUid) {
                $sess = session('firebase_uid', null);
                if ($sess) $resolvedUid = (string)$sess;
            }
        }

        if (!$resolvedUid) return response()->json(['ok' => false, 'error' => 'no uid provided or resolved (sign in required)'], 400);

        $safeUid = preg_replace('/[^A-Za-z0-9_\-]/', '_', $resolvedUid ?: 'anonymous');
        $cachePath = storage_path('app/reco_user_' . $safeUid . '.json');
        if (!file_exists($cachePath)) return response()->json(['ok' => false, 'error' => 'cache not found', 'cache_path' => $cachePath], 404);

        $raw = @file_get_contents($cachePath);
        $decoded = $raw ? json_decode($raw, true) : null;
        return response()->json(['ok' => true, 'resolved_uid' => $resolvedUid, 'safe_uid' => $safeUid, 'cache_path' => $cachePath, 'data' => $decoded]);
    } catch (\Throwable $e) {
        return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
    }
})->name('debug.reco_preview');

Route::get('/registeradminapprove', function () {
    return view('ds_register_adminapprove');
})->name('registeradminapprove');

// Admin registration page (uses admin/admin-register-page1.blade.php)
Route::get('/admin/register', function () {
    return view('admin.admin-register-page1');
})->name('admin.register');

// Admin login page (separate from the regular /login view)
Route::get('/admin/login', function () {
    return view('admin.admin-login');
})->name('admin.login');

// Admin registration submit endpoint (client should create Firebase account first and then POST the firebaseUid here)
use App\Http\Controllers\AdminRegistrationController;
Route::post('/admin/register/submit', [AdminRegistrationController::class, 'submit'])->name('admin.register.submit');

// Admin area routes (protected). Use the middleware class directly to avoid Kernel edits.
Route::middleware(['auth', \App\Http\Middleware\EnsureUserIsAdmin::class])->prefix('admin')->group(function () {
    Route::get('/approval', function () { return view('admin.admin-approval'); })->name('admin.approval');
    Route::get('/newadmin', function () { return view('admin.admin-approval-newadmin'); })->name('admin.newadmin');
    Route::get('/company', function () { return view('admin.admin-approval-company'); })->name('admin.company');
    Route::get('/expert', function () { return view('admin.admin-approval-expert'); })->name('admin.expert');
    Route::get('/jobpostings', function () { return view('admin.admin-approval-jobpostings'); })->name('admin.jobpostings');
    Route::get('/adminview', function () { return view('admin.admin-approval-adminview'); })->name('admin.adminview');
    // Admin assignment management (Firestore-backed)
    Route::get('/admins', [\App\Http\Controllers\AdminAssignmentController::class, 'index'])->name('admin.admins');
    Route::post('/admins', [\App\Http\Controllers\AdminAssignmentController::class, 'store'])->name('admin.admins.store');
    Route::delete('/admins/{uid}', [\App\Http\Controllers\AdminAssignmentController::class, 'destroy'])->name('admin.admins.destroy');
    // Approvals API
    Route::get('/api/pending-approvals', [\App\Http\Controllers\AdminApprovalController::class, 'pending'])->name('admin.api.pending');
    Route::post('/api/approve/{id}', [\App\Http\Controllers\AdminApprovalController::class, 'approve'])->name('admin.api.approve');
    Route::post('/api/reject/{id}', [\App\Http\Controllers\AdminApprovalController::class, 'reject'])->name('admin.api.reject');

    // Server-side admin user review: fetch Firestore user doc and render the review page
    // Usage: /admin/user-review/{uid}
    Route::get('/user-review/{uid}', function (Request $request, $uid) {
        try {
            // Use GuardianJobController helper to fetch and convert Firestore document
            $controller = app(\App\Http\Controllers\GuardianJobController::class);
            $profile = $controller->fetchUserProfileFromFirestore($uid);
            // Pass the profile array to the review view; the blade will expose it to the client
            return view('ds_register_review-2', ['serverProfile' => $profile, 'serverProfileUid' => $uid]);
        } catch (\Throwable $e) {
            logger()->warning('admin.user-review route failed: ' . $e->getMessage());
            return redirect()->route('admin.approval')->with('error', 'Failed to fetch user profile');
        }
    })->name('admin.user.review');

    // Development helper: unprotected test route that renders the same review page using
    // server-side Firestore fetch. This exists to make local debugging easier; it is NOT
    // intended for production use. Remove or protect this route in production.
    Route::get('/test-user-review/{uid}', function (Request $request, $uid) {
        try {
            $controller = app(\App\Http\Controllers\GuardianJobController::class);
            $profile = $controller->fetchUserProfileFromFirestore($uid);
            return view('ds_register_review-2', ['serverProfile' => $profile, 'serverProfileUid' => $uid]);
        } catch (\Throwable $e) {
            logger()->warning('admin.test-user-review route failed: ' . $e->getMessage());
            return response('failed to fetch profile', 500);
        }
    })->name('admin.test.user.review');
});


Route::get('/registereducation', function () {
    return view('ds_register_education');
})->name('registereducation');

Route::get('/registerworkinfo', function () {
    return view('ds_register_workinfo');
})->name('registerworkinfo');

Route::get('/registerschoolworkinfo', function () {
    // Skip the old combined page and continue to the work-experience step.
    return redirect()->route('registerworkexpinfo');
})->name('registerschoolworkinfo');

Route::get('/registerworkexpinfo', function () {
    return view('ds_register_workexpinfo');
})->name('registerworkexpinfo');

Route::get('/registersupportneed', function () {
    return view('ds_register_supportneed');
})->name('registersupportneed');

Route::get('/registerworkplace', function () {
    return view('ds_register_workplace');
})->name('registerworkplace');

Route::get('/registerskills1', function () {
    return view('ds_register_skills-1');
})->name('registerskills1');


Route::get('/registerjobpreference1', function () {
    return view('ds_register_job-preference-1');
})->name('registerjobpreference1');

// Compatibility redirect: forward old /registerjobpreference2 requests to the consolidated review page
Route::get('/registerjobpreference2', function () {
    return redirect()->route('registerreview1');
})->name('registerjobpreference2');

Route::get('/job-application-1', function () {
    return view('job-application-1');
})->name('job.application.1');

Route::post('/job-application-1', [JobApplicationController::class, 'submit'])->name('job.application.1.submit');

Route::get('/job-application-2', function () {
    return view('job-application-2');
})->name('job.application.2');

use App\Services\JobCsvParser;

Route::get('/job-application-review1', function () {
    $job = null;
    try {
        $parser = new JobCsvParser();
        $jobId = request('job_id');
        $assoc = $parser->findJobById($jobId);
        if (is_array($assoc)) {
            // normalize some common keys for the view (fallbacks)
            $job = [
                'title' => $assoc['title'] ?? ($assoc['job_title'] ?? ($assoc['position'] ?? 'Unknown Job')),
                'company' => $assoc['company'] ?? ($assoc['companyname'] ?? $assoc['employer'] ?? ''),
                'location' => $assoc['location'] ?? ($assoc['address'] ?? ($assoc['city'] ?? '')),
                'type' => $assoc['type'] ?? ($assoc['jobtype'] ?? ($assoc['employment_type'] ?? '')),
                'job_description' => $assoc['job_description'] ?? ($assoc['description'] ?? ($assoc['job description'] ?? '')),
            ];
        }
    } catch (\Throwable $e) {
        logger()->error('job-application-review1 route: parser exception: ' . $e->getMessage());
    }
    // If parser returned no assoc, previously we showed a debug page automatically.
    // That makes the route behave like an error for end users. Change behavior:
    // - If ?debug=1 is present, show the debug diagnostic page.
    // - Otherwise always render the review view (job may be null and the view handles that).
    $force = request()->boolean('force_view');
    $showDebug = request()->boolean('debug');
    if ($showDebug && (empty($assoc) || $assoc === null)) {
        // collect diagnostic info
        $csvPath = public_path('postings.csv');
        $jsonPath = public_path('recommendations.json');
        $approvalsPath = storage_path('app/guardian_job_approvals.json');
        $files = [
            'postings_exists' => file_exists($csvPath),
            'postings_size' => @filesize($csvPath) ?: 0,
            'postings_mtime' => @filemtime($csvPath) ?: null,
            'reco_exists' => file_exists($jsonPath),
            'reco_size' => @filesize($jsonPath) ?: 0,
            'reco_mtime' => @filemtime($jsonPath) ?: null,
            'approvals_exists' => file_exists($approvalsPath),
        ];

        // tail the laravel log (last 200 lines)
        $logPath = storage_path('logs/laravel.log');
        $logTail = [];
        if (file_exists($logPath)) {
            $lines = @file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
            $logTail = array_slice($lines, -200);
        }

        return view('debug.job-load-debug', [
            'jobId' => $jobId,
            'files' => $files,
            'assoc' => $assoc,
            'logTail' => $logTail,
        ]);
    }

    return view('job-application-review1', ['job' => $job]);
})->name('job.application.review1');

Route::get('/job-application-review2', function () {
    return view('job-application-review2');
})->name('job.application.review2');

Route::get('/job-application-submit', function () {
    return view('job-application-submit');
})->name('job.application.submit');

// Server-side submit endpoint (AJAX-friendly). Uses service account to write to Firestore.
// NOTE: this route no longer requires Laravel session middleware so clients that
// supply a Firebase ID token (Authorization: Bearer <idToken>) can submit too.
Route::post('/job-application-submit', [JobApplicationController::class, 'submit'])->name('job.application.submit.post');

Route::get('/job-details', function () {
    return view('job-details');
})->name('job.details');

Route::get('/job-matches', function () {
    // Attempt to resolve a firebase UID (from authenticated user or session) and
    // load the per-user recommendation cache `storage/app/reco_user_<safeUid>.json`.
    $resolvedUid = null;
    try {
        if (\Illuminate\Support\Facades\Auth::check()) {
            $u = \Illuminate\Support\Facades\Auth::user();
            if (!empty($u->firebase_uid)) $resolvedUid = (string)$u->firebase_uid;
        }
    } catch (\Throwable $__e) {
        // ignore
    }

    // fallback to session-stored firebase uid
    if (!$resolvedUid) {
        $sess = session('firebase_uid', null);
        if ($sess) $resolvedUid = (string)$sess;
    }

    $recommendations = [];
    if ($resolvedUid) {
        $safeUid = preg_replace('/[^A-Za-z0-9_\-]/', '_', $resolvedUid ?: 'anonymous');
        $cachePath = storage_path('app/reco_user_' . $safeUid . '.json');
        if (file_exists($cachePath)) {
            $raw = @file_get_contents($cachePath);
            $decoded = $raw ? json_decode($raw, true) : null;
            if (is_array($decoded)) {
                // If file contains a mapping keyed by uid, prefer that, else treat as direct array
                if (isset($decoded[$resolvedUid]) && is_array($decoded[$resolvedUid])) {
                    $recommendations = $decoded[$resolvedUid];
                } elseif (isset($decoded[$safeUid]) && is_array($decoded[$safeUid])) {
                    $recommendations = $decoded[$safeUid];
                } else {
                    $recommendations = $decoded;
                }
            }
        }
    }

    return view('job-matches', ['recommendations' => $recommendations]);
})->name('job.matches');

// API for guardian to approve/flag jobs (stored locally in storage/app/guardian_job_approvals.json)
// NOTE: these endpoints accept either a Laravel session (auth middleware) OR a Firebase ID token
// in the request (Authorization: Bearer <idToken> or JSON body {idToken}). We don't enforce
// Laravel session here to allow client-side Firebase-auth flows to call them directly.
Route::get('/api/guardian/jobs', [GuardianJobController::class, 'list'])->name('api.guardian.jobs');
Route::post('/api/guardian/jobs/{jobId}/approve', [GuardianJobController::class, 'approve'])->name('api.guardian.jobs.approve');
Route::post('/api/guardian/jobs/{jobId}/flag', [GuardianJobController::class, 'flag'])->name('api.guardian.jobs.flag');

// Recommendations API: hybrid generator endpoint
use App\Http\Controllers\RecommendationController;
Route::post('/api/recommendations/user', [RecommendationController::class, 'userRecommendations']);
Route::post('/api/recommendations/all', [RecommendationController::class, 'generateAll']);

// (Firebase token endpoint removed - registration/login now Oracle-backed)

Route::get('/my-job-applications', [SavedJobController::class, 'index'])->name('my.job.applications');
Route::post('/my-job-applications', [SavedJobController::class, 'store'])->name('my.job.applications');
// Convenience GET route that saves a job and redirects to the saved-jobs page.
// This is useful for simple anchor-based saves from the job-listing UI.
Route::get('/my-job-applications/add/{jobId}', [SavedJobController::class, 'add'])->name('my.job.applications.add');
Route::post('/my-job-applications/remove', [SavedJobController::class, 'destroy'])->name('my.job.applications.remove');

// Additional registration routes
Route::get('/register2', function () {
    return view('ds_register_2');
})->name('register2');

Route::get('/registerverifycode', function () {
    return view('ds_register_verifycode');
})->name('registerverifycode');

Route::get('/registerfinalstep', function () {
    return view('ds_register_finalstep');
})->name('registerfinalstep');

Route::post('/register/draft', function (\Illuminate\Http\Request $request) {
    try {
        $payload = $request->json()->all() ?: $request->all();
        if (!is_array($payload)) $payload = (array)$payload;
        $step = isset($payload['step']) ? (string)$payload['step'] : null;
        $data = $payload['data'] ?? $payload;
        if (!is_array($data)) $data = (array)$data;

        $draft = session('register_draft', []);
        if ($step) {
            $draft[$step] = array_merge(is_array($draft[$step] ?? []) ? $draft[$step] : [], $data);
        } else {
            $draft = array_merge($draft, $data);
        }
        session(['register_draft' => $draft]);
        return response()->json(['ok' => true, 'draft_keys' => array_keys($draft)]);
    } catch (\Throwable $e) {
        logger()->warning('register.draft failed: ' . $e->getMessage());
        return response()->json(['ok' => false, 'error' => 'exception', 'message' => $e->getMessage()], 500);
    }
});

// Server-backed registration draft endpoints (store per-step data in session)
Route::post('/register/draft', function (\Illuminate\Http\Request $request) {
    try {
        $payload = $request->json()->all() ?: $request->all();
        if (!is_array($payload)) $payload = (array)$payload;
        $step = isset($payload['step']) ? (string)$payload['step'] : null;
        $data = $payload['data'] ?? $payload;
        if (!is_array($data)) $data = (array)$data;

        $draft = session('register_draft', []);
        if ($step) {
            $draft[$step] = array_merge(is_array($draft[$step] ?? []) ? $draft[$step] : [], $data);
        } else {
            $draft = array_merge($draft, $data);
        }
        session(['register_draft' => $draft]);
        return response()->json(['ok' => true, 'draft_keys' => array_keys($draft)]);
    } catch (\Throwable $e) {
        logger()->warning('register.draft failed: ' . $e->getMessage());
        return response()->json(['ok' => false, 'error' => 'exception', 'message' => $e->getMessage()], 500);
    }
});

Route::get('/register/draft', function (\Illuminate\Http\Request $request) {
    try {
        $draft = session('register_draft', []);
        return response()->json(['ok' => true, 'draft' => $draft]);
    } catch (\Throwable $e) {
        return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
    }
});

// Final submit: aggregate session draft and request payload, then call OracleAuthController::registerGuardian
Route::post('/register/submit', function (\Illuminate\Http\Request $request) {
    try {
        $draft = session('register_draft', []);
        $payload = $request->json()->all() ?: $request->all();
        if (!is_array($payload)) $payload = (array)$payload;
        $merged = array_merge(is_array($draft) ? $draft : [], $payload ?: []);

        $data = [
            'first_name' => $merged['first_name'] ?? $merged['fname'] ?? ($merged['personalInfo']['first'] ?? null),
            'last_name' => $merged['last_name'] ?? $merged['lname'] ?? ($merged['personalInfo']['last'] ?? null),
            'email' => $merged['email'] ?? ($merged['personalInfo']['email'] ?? ($merged['emailFromServer'] ?? null)),
            'password' => $merged['password'] ?? $merged['pwd'] ?? null,
            'contact_number' => $merged['contact_number'] ?? $merged['contactNumber'] ?? ($merged['personalInfo']['contact_number'] ?? null),
            'role' => $merged['role'] ?? 'guardian',
        ];

        if (empty($data['email'])) {
            return response()->json(['ok' => false, 'error' => 'email_required'], 400);
        }
        if (empty($data['password'])) {
            $data['password'] = bin2hex(random_bytes(8));
        }

        $internalReq = new \Illuminate\Http\Request();
        $internalReq->replace($data);
        $controller = app(\App\Http\Controllers\OracleAuthController::class);
        $resp = $controller->registerGuardian($internalReq);

        if ($resp instanceof \Illuminate\Http\JsonResponse) {
            $j = $resp->getData(true);
            if (!empty($j['ok'])) {
                session()->forget('register_draft');
                try { session()->regenerate(); } catch (\Throwable $__e) {}
                return response()->json(['ok' => true, 'uid' => $j['uid'] ?? null, 'id' => $j['id'] ?? null]);
            }
            return response()->json($j, $resp->getStatusCode());
        }

        session()->forget('register_draft');
        try { session()->regenerate(); } catch (\Throwable $__e) {}
        return response()->json(['ok' => true]);
    } catch (\Throwable $e) {
        logger()->error('register.submit exception: ' . $e->getMessage());
        return response()->json(['ok' => false, 'error' => 'exception', 'message' => $e->getMessage()], 500);
    }
});



// Oracle-backed auth endpoints (login only).
use App\Http\Controllers\OracleAuthController;
// Note: registration via Oracle is handled exclusively through the
// server-backed /register/submit endpoint which aggregates session draft
// data and delegates to OracleAuthController::registerGuardian.
// We intentionally do not expose a separate /oracle/guardian/register POST
// route to avoid duplicate registration entry points.
Route::post('/oracle/guardian/login', [OracleAuthController::class, 'loginGuardian']);

Route::get('/saved', function () {
    return view('saved-jobs');
})->name('saved');

Route::get('/assessment', function () {
    return view('career-goals-progress');
})->name('assessment');

Route::get('/whythisjob', function () {
    return view('why-this-job-1');
})->name('whythisjob');


// Review pages
Route::get('/registerreview1', function () {
    return view('ds_register_review-1');
})->name('registerreview1');

Route::get('/registerreview2', function () {
    // Render the review page without server-side Firestore/Firebase lookups.
    // Front-end remains responsible for collecting review data. If the
    // registration front-end has previously saved draft data in session (via
    // /register/draft) the client can fetch it using /register/draft.
    return view('ds_register_review-2');
})->name('registerreview2');

// Server-side helper API used by review pages when client cannot read Firestore directly.
// This endpoint no longer calls Firestore or relies on Firebase; instead it
// returns the current registration draft stored in the session (if any).
Route::get('/api/server-profile', function (Request $request) {
    try {
        // Return the registration draft stored in session. Front-end pages
        // should call /register/draft to save per-step data and can use this
        // endpoint to retrieve the draft for pre-filling review forms.
        $draft = session('register_draft', []);
        if (empty($draft)) {
            return response()->json(['ok' => false, 'error' => 'profile_not_available'], 404);
        }
        return response()->json(['ok' => true, 'profile' => $draft]);
    } catch (\Throwable $e) {
        logger()->warning('api.server-profile failed: ' . $e->getMessage());
        return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
    }
})->name('api.server_profile');

Route::get('/registerreview3', function () {
    return view('ds_register_review-3');
})->name('registerreview3');

Route::get('/registerreview4', function () {
    return view('ds_register_review-4');
})->name('registerreview4');

Route::get('/registerreview5', function () {
    return view('ds_register_review-5');
})->name('registerreview5');

// New pages: About MVSG, About Down Syndrome, and User Role selection
Route::get('/about-us', function () {
    return view('about-us');
})->name('about.us');

Route::get('/about-ds', function () {
    return view('about-ds');
})->name('about.ds');

Route::get('/user-role', function () {
    return view('user_role');
})->name('user.role');

// Alias routes (common variants) so navbar or external links that use different URIs/names still resolve
Route::get('/about', function () {
    return view('about-us');
})->name('about');

Route::get('/about-mvsg', function () {
    return view('about-us');
})->name('about.mvsg');

Route::get('/aboutmvsg', function () {
    return view('about-us');
})->name('aboutmvsg');

Route::get('/about-down-syndrome', function () {
    return view('about-ds');
})->name('about.down-syndrome');

Route::get('/aboutdownsyndrome', function () {
    return view('about-ds');
})->name('aboutdownsyndrome');

Route::get('/dataprivacy', function () {
    return view('ds_data-privacy');
})->name('dataprivacy');

// Temporary route to test whether web requests can write to laravel.log.
// Visit /__log_test in your browser (or via curl/Invoke-WebRequest) and
// then check storage/logs/laravel.log for the test entry.
Route::get('/__log_test', function () {
    logger()->info('web log test: route /__log_test was visited', ['ip' => request()->ip()]);
    return response('log-written');
});

// Temporary route to check APP_KEY visibility to the web process.
Route::get('/__key_check', function () {
    $envKey = env('APP_KEY');
    $cfgKey = config('app.key');
    logger()->info('__key_check', [
        'env_present' => $envKey !== null,
        'env_len' => $envKey ? strlen($envKey) : 0,
        'cfg_present' => $cfgKey !== null,
        'cfg_len' => $cfgKey ? strlen($cfgKey) : 0,
        'app_env' => env('APP_ENV'),
    ]);
    return response('key-checked');
});

// Dev-only: quick Oracle lookup/login test (LOCAL environment only)
// POST JSON { email, password } -> { ok, found, match, email }
Route::post('/__oracle-test-login', function (Request $request) {
    if (!app()->environment('local')) {
        return response()->json(['ok' => false, 'error' => 'forbidden - local only'], 403);
    }
    $email = strtolower((string) ($request->input('email') ?? ''));
    $password = $request->input('password');
    if ($email === '') return response()->json(['ok' => false, 'error' => 'missing email'], 400);

    $oracleFile = public_path('db/oracledb.php');
    if (!file_exists($oracleFile)) {
        return response()->json(['ok' => false, 'error' => 'oracledb.php not found'], 500);
    }
    require_once $oracleFile;
    if (!function_exists('getOracleConnection')) {
        return response()->json(['ok' => false, 'error' => 'getOracleConnection not available'], 500);
    }

    try {
        $conn = getOracleConnection();
        $sql = 'SELECT EMAIL, PASSWORD FROM USER_GUARDIAN WHERE LOWER(EMAIL) = :email';
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':email', $email);
        oci_execute($stid);
        $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
        if (!$row) {
            return response()->json(['ok' => true, 'found' => false, 'match' => false]);
        }
        $stored = $row['PASSWORD'] ?? ($row['password'] ?? null);
        $match = false;
        if ($stored !== null && $password !== null) {
            $match = strval($password) === strval($stored);
        }
        return response()->json(['ok' => true, 'found' => true, 'match' => $match, 'email' => ($row['EMAIL'] ?? null)]);
    } catch (\Throwable $e) {
        logger()->warning('oracle-test-login failed: ' . $e->getMessage());
        return response()->json(['ok' => false, 'error' => 'exception', 'message' => $e->getMessage()], 500);
    }
})->name('debug.oracle_test');