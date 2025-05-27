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

    // Define the relationship with Course
    public function courses()
    {
        return $this->hasMany(Course::class, 'co-ordinator_id', 'id');
    }

    // Define the relationship with Section
    public function sections()
    {
        return $this->hasMany(Section::class, 'faculty_id', 'id');
    }
    

}
