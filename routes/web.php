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

Route::get('/registerjobpreference1', function () {
    return view('ds_register_job-preference-1');
});

Route::get('/registerjobpreference2', function () {
    return view('ds_register_job-preference-2');
});

Route::get('/registerskills1', function () {
    return view('ds_register_skills-1');
});

Route::get('/registerskills2', function () {
    return view('ds_register_skills-2');
});