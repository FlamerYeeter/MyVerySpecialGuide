<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SavedJobController;
use App\Http\Controllers\FirebaseTokenController;
use App\Http\Controllers\JobApplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;

Route::get('/', function () {
    return view('home');
})->name('home');

/*
Route::get('/', function () {
    return view('job_application_2');
})->name('job_application_2');
*/

Route::get('/register', function () {
    return view('ds_register_1');
})->name('register');

// Navigation buttons page (used by login/back links)
Route::get('/navigation-buttons', function () {
    return view('navigation-buttons');
})->name('navigation_buttons');

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
        logger()->error('client-log endpoint failed: ' . $e->getMessage());
    }
    return response()->json(['ok' => true]);
});

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

    // Load per-user recommendation cache if present (used as fallback only)
    $recoPath = storage_path('app/reco_user_' . $safeUid . '.json');
    $reco = null;
    if (file_exists($recoPath)) {
        $raw = @file_get_contents($recoPath);
        $reco = $raw ? (json_decode($raw, true) ?: null) : null;
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
    // optional redirect (full URL) to return to after successful login
    $redirect = $request->input('redirect');
    // Use Auth facade if available
    try {
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            logger()->info('Login: local Auth succeeded', ['email' => $credentials['email'] ?? null, 'redirect' => $redirect]);
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
            return redirect()->route('job.matches');
        }
    } catch (\Throwable $e) {
        // If Auth is not configured, just redirect for now (placeholder)
        // Log the exception to laravel log
        logger()->error('Login error: ' . $e->getMessage());
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
                if (!empty($redirect)) {
                    $host = parse_url($redirect, PHP_URL_HOST);
                    $currentHost = request()->getHost();
                    if ($host === null || $host === $currentHost) {
                        logger()->info('Login: performing redirect to requested target', ['target' => $redirect]);
                        return redirect()->to($redirect);
                    }
                    logger()->warning('Login: blocked external redirect target', ['target' => $redirect, 'currentHost' => $currentHost]);
                }
                return redirect()->route('job.matches');
            } else {
                logger()->warning('Firebase login failed: ' . $resp->body());
            }
        } catch (\Throwable $e) {
            logger()->error('Firebase auth error: ' . $e->getMessage());
        }
    }

    return back()->withErrors(['email' => 'Login failed. Please check your credentials.'])->withInput();
})->name('login.post');

// Client-side Firebase sign-in helper: accepts a Firebase ID token (idToken) and
// verifies it with the Identity Toolkit API. If valid, create or find a local
// user, log them in, persist firebase_uid to session and the users table.
Route::post('/session/firebase-signin', function (Request $request) {
    $idToken = $request->json('idToken') ?: $request->input('idToken');
    if (empty($idToken)) {
        return response()->json(['ok' => false, 'error' => 'missing_idToken'], 400);
    }
    $apiKey = env('FIREBASE_API_KEY');
    if (empty($apiKey)) {
        logger()->warning('firebase-signin: FIREBASE_API_KEY missing');
        return response()->json(['ok' => false, 'error' => 'server_misconfigured'], 500);
    }

    try {
        $resp = Http::post("https://identitytoolkit.googleapis.com/v1/accounts:lookup?key={$apiKey}", [
            'idToken' => $idToken,
        ]);
        if (!$resp->successful()) {
            logger()->warning('firebase-signin: accounts:lookup failed', ['status' => $resp->status(), 'body' => $resp->body()]);
            return response()->json(['ok' => false, 'error' => 'invalid_idToken'], 401);
        }
        $data = $resp->json();
        if (empty($data['users']) || !is_array($data['users'])) {
            return response()->json(['ok' => false, 'error' => 'invalid_idToken_no_user'], 401);
        }
        $u = $data['users'][0];
        $firebaseUid = $u['localId'] ?? null;
        $email = $u['email'] ?? null;

        if (empty($firebaseUid) || empty($email)) {
            return response()->json(['ok' => false, 'error' => 'invalid_user_payload'], 400);
        }

        // find or create local user by email
        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = User::create([
                'name' => explode('@', $email)[0],
                'email' => $email,
                'password' => bcrypt(bin2hex(random_bytes(8))),
            ]);
        }

        // log the user in and persist firebase UID
        Auth::login($user);
        session(['firebase_uid' => $firebaseUid]);
        try {
            if (empty($user->firebase_uid) || $user->firebase_uid !== $firebaseUid) {
                $user->firebase_uid = $firebaseUid;
                $user->save();
                logger()->info('firebase-signin: persisted firebase_uid to user', ['user_id' => $user->id, 'hint' => substr($firebaseUid, 0, 6) . '...']);
            }
        } catch (\Throwable $e) {
            logger()->warning('firebase-signin: failed to persist firebase_uid: ' . $e->getMessage());
        }

        // Check Firestore admin assignments and grant local admin flags if present
        try {
            $fsAdmin = app(\App\Services\FirestoreAdminService::class);
            if (!empty($firebaseUid) && $fsAdmin->isAdmin($firebaseUid)) {
                // Simplified: only set the role locally. Approval flags are not required.
                $user->role = 'admin';
                $user->save();
                logger()->info('firebase-signin: granted admin role from Firestore assignment', ['user_id' => $user->id, 'uid_hint' => substr($firebaseUid, 0, 6) . '...']);
            }
        } catch (\Throwable $__fs_e) {
            logger()->warning('firebase-signin: Firestore admin check failed: ' . $__fs_e->getMessage());
        }

        $request->session()->regenerate();
        return response()->json(['ok' => true, 'firebase_uid' => $firebaseUid]);
    } catch (\Throwable $e) {
        logger()->error('firebase-signin: exception: ' . $e->getMessage());
        return response()->json(['ok' => false, 'error' => 'exception'], 500);
    }
})->name('session.firebase_signin');

// Debug helper (development only): return current session and user firebase_uid
// Use this to verify the client successfully synced the firebase UID into the session.
Route::get('/debug/firebase-session', function (Request $request) {
    try {
        $sess = session('firebase_uid', null);
        $user = Auth::user();
        $modelUid = $user && !empty($user->firebase_uid) ? $user->firebase_uid : null;
        return response()->json(['ok' => true, 'session_firebase_uid' => $sess, 'user_firebase_uid' => $modelUid]);
    } catch (\Throwable $e) {
        return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
    }
})->name('debug.firebase_session');

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

Route::get('/registerschoolworkinfo', function () {
    return view('ds_register_school_workinfo');
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
    return view('job-matches');
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

// Endpoint to issue Firebase custom token for current Laravel user
Route::get('/firebase-token', [FirebaseTokenController::class, 'token'])->middleware('auth')->name('firebase.token');

Route::get('/my-job-applications', [SavedJobController::class, 'index'])->name('my.job.applications');
Route::post('/my-job-applications', [SavedJobController::class, 'store'])->name('my.job.applications');
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

// Review pages
Route::get('/registerreview1', function () {
    return view('ds_register_review-1');
})->name('registerreview1');

Route::get('/registerreview2', function () {
    return view('ds_register_review-2');
})->name('registerreview2');

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