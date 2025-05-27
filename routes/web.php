<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/faculty_list', function () {
    $faculties =[
        ["Name"=>"Sahil Ishan Tonmoy", "Designation"=>"Lecturer", "Department"=>"CSE", "id"=>22301612]
        ,["Name"=>"Mashrafi Zaman", "Designation"=>"Professor", "Department"=>"Mathematics", "id"=>22301614]
    ];
    $faculties = collect($faculties);
    return view('Faculty.faculty_list',["faculties"=>$faculties]);
});

Route::get('/faculty_list/{id}', function ($id) {
   
    return view('Faculty.faculty_details',["id"=>$id]);
});
