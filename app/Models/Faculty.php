<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{   
    protected $fillable = [
        'name',
        'designation',
        'department',
        'faculty_id',
        'email',
        'phone',
        'bio',
        'profile_picture',
        'initial'
    ];


    /** @use HasFactory<\Database\Factories\FacultyFactory> */
    use HasFactory;
}
