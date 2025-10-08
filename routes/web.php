<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/registeradminapprove', function () {
    return view('ds_register_adminapprove');
});

Route::get('/registereducation', function () {
    return view('ds_register_education');
});

Route::get('/registerpersonalinfo', function () {
    return view('ds_register_personalinfo');
});

Route::get('/registerjobpreference1', function () {
    return view('ds_register_job-preference-1');
})->name('registerjobpreference1');

Route::get('/registerjobpreference2', function () {
    return view('ds_register_job-preference-2');
})->name('registerjobpreference2');

Route::get('/registerskills1', function () {
    return view('ds_register_skills-1');
})->name('registerskills1');

Route::get('/registerskills2', function () {
    return view('ds_register_skills-2');
})->name('registerskills2');

Route::get('/registersupportneed', function () {
    return view('ds_register_supportneed');
})->name('registersupportneed');

Route::get('/registerworkplace', function () {
    return view('ds_register_workplace');
})->name('registerworkplace');


// Job application routes
Route::get('/job-application', function () {
    return view('job-application-1');
})->name('job.application.1');

Route::get('/job-application-step2', function () {
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

Route::get('/job-matches', function () {
    return view('job-matches');
})->name('job.matches');

Route::get('/my-job-applications', function () {
    return view('my-job-applications');
})->name('my.job.applications');

Route::get('/job-details', function () {
    return view('job-details');
})->name('job.details');