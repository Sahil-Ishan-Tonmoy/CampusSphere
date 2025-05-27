<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'course_code',
        'description',
        'credit',
        'co-ordinator_id', // Note: Laravel convention prefers underscores, i.e., co_ordinator_id
    ];

    // Define the relationship with Faculty
    public function coordinator()
    {
        return $this->belongsTo(Faculty::class, 'co-ordinator_id', 'id');
    }
}
