<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('job-application-review2');
})->name('job-application-review2');
