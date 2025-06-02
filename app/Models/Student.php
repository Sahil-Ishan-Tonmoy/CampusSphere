<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

     
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'age',
        'department',
        'student_id',
        'phone',
        'profile_picture',
        'courses', // Assuming courses is a JSON field
    ];
}
