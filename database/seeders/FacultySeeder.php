<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faculty;

class FacultySeeder extends Seeder
{
    
    public function run(): void
    {
        Faculty::factory()
            ->count(30) 
            ->create();
    }
}
