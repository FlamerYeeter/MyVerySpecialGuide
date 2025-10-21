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

// Navigation targets used by navigation-buttons view
Route::get('/why-this-job-1', function () {
    return view('why-this-job-1');
})->name('why.this.job.1');

// Guardian review routes: pending list and detailed mode
Route::get('/guardian-review/pending', function () {
    return view('guardianreview-pending-review');
})->name('guardianreview.pending');

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

Route::get('/registerpersonalinfo', function () {
    return view('ds_register_personalinfo');
})->name('registerpersonalinfo');

Route::get('/registerguardianinfo', function () {
    return view('ds_register_guardianinfo');
})->name('registerguardianinfo');

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

Route::get('/registerskills2', function () {
    return view('ds_register_skills-2');
})->name('registerskills2');

Route::get('/registerjobpreference1', function () {
    return view('ds_register_job-preference-1');
})->name('registerjobpreference1');

Route::get('/registerjobpreference2', function () {
    return view('ds_register_job-preference-2');
})->name('registerjobpreference2');

Route::get('/job-application-1', function () {
    return view('job-application-1');
})->name('job.application.1');

Route::post('/job-application-1', [JobApplicationController::class, 'submit'])->name('job.application.1.submit');

Route::get('/job-application-2', function () {
    return view('job-application-2');
})->name('job.application.2');

Route::get('/job-application-review1', function () {
    return view('job-application-review1');
})->name('job.application.review1');

Route::get('/job-application-review2', function () {
    return view('job-application-review2');
})->name('job.application.review2');

Route::get('/job-application-submit', function () {
    return view('job-application-submit');
})->name('job.application.submit');

// Server-side submit endpoint (AJAX-friendly). Uses service account to write to Firestore.
Route::post('/job-application-submit', [JobApplicationController::class, 'submit'])->middleware('auth')->name('job.application.submit.post');

Route::get('/job-details', function () {
    return view('job-details');
})->name('job.details');

Route::get('/job-matches', function () {
    return view('job-matches');
})->name('job.matches');

// API for guardian to approve/flag jobs (stored locally in storage/app/guardian_job_approvals.json)
Route::get('/api/guardian/jobs', [GuardianJobController::class, 'list'])->name('api.guardian.jobs')->middleware('auth');
Route::post('/api/guardian/jobs/{jobId}/approve', [GuardianJobController::class, 'approve'])->name('api.guardian.jobs.approve')->middleware('auth');
Route::post('/api/guardian/jobs/{jobId}/flag', [GuardianJobController::class, 'flag'])->name('api.guardian.jobs.flag')->middleware('auth');

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
    return view('data-privacy');
})->name('dataprivacy');