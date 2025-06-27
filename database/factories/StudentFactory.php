<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use App\Models\Section;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
{
    $courses = Course::inRandomOrder()->take(3)->get();
    $courseSectionMap = [];

    foreach ($courses as $course) {
        $sections = Section::where('course_code', $course->course_code)->pluck('section_number');

        if ($sections->isNotEmpty()) {
            $courseSectionMap[$course->course_code] = $sections->random();
        }
    }

    return [
        'name' => fake()->name(),
        'department' => fake()->randomElement(['CSE', 'MNS', 'ECE', 'EEE', 'BBA']),
        'student_id' => fake()->unique()->numerify('S#####'),
        'email' => fake()->unique()->safeEmail(),
        'phone' => fake()->optional()->phoneNumber(),
        'profile_picture' => fake()->optional()->imageUrl(640, 480, 'people'),
        'courses' => json_encode($courseSectionMap),
    ];
}
}
