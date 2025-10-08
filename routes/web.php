<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/', function () {
    return view('job_application_2');
})->name('job_application_2');

Route::get('/register', function () {
    return view('ds_register_1');
});
