<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Faculty_Controller;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/faculty', [Faculty_Controller::class, 'index'])->name('faculty.index');

Route::get('/faculty/{id}', [Faculty_Controller::class, 'show'])->name('faculty.show');
