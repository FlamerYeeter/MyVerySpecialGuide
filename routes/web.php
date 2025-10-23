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
Route::get('/why-this-job-1', function () {
    return view('why-this-job-1');
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

Route::get('/registeradminapprove', function () {
    return view('ds_register_adminapprove');
})->name('registeradminapprove');


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