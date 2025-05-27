<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Faculty_Controller;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/faculty_list', [Faculty_Controller::class, 'index'])->name('faculty_list');

Route::get('/faculty_list/{id}', function ($id) {
   
    return view('Faculty.faculty_details',["id"=>$id]);
});
