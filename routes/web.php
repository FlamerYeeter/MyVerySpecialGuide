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
});

Route::get('/registeradminapprove', function () {
    return view('ds_register_adminapprove');
});

Route::get('/registerpersonalinfo', function () {
    return view('ds_register_personalinfo');
});

Route::get('/registerguardianinfo', function () {
    return view('ds_register_guardianinfo');
});

Route::get('/registereducation', function () {
    return view('ds_register_education');
});

Route::get('/registerschoolworkinfo', function () {
    return view('ds_register_school_workinfo');
});

Route::get('/registerworkexpinfo', function () {
    return view('ds_register_workexpinfo');
});

Route::get('/registersupportneed', function () {
    return view('ds_register_supportneed');
});

Route::get('/registerworkplace', function () {
    return view('ds_register_workplace');
});

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



