<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Faculty_Controller;
use App\Http\Controllers\Course_Controller;
use App\Http\Controllers\User_Controller;
use App\Http\Controllers\InviteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/faculty', [Faculty_Controller::class, 'index'])->name('faculty.index');

Route::get('/faculty/{id}', [Faculty_Controller::class, 'show'])->name('faculty.show');

Route::get('/course', [Course_Controller::class, 'index'])->name('course.index');

Route::get('/course/{course_code}', [Course_Controller::class, 'show'])->name('course.show');

Route::get('/course/{course_code}/schedule', [Course_Controller::class, 'schedule'])->name('course.schedule');

Route::post('/generate-invite', [InviteController::class, 'generate'])->name('invite.generate');
Route::get('/i/{inviteCode}', [InviteController::class, 'redirect'])->name('invite.redirect');
