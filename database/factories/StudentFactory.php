<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => fake()->name(),
            'department' => fake()->randomElement(['CSE', 'MNS', 'ECE', 'EEE', 'BBA']),
            'student_id' => fake()->unique()->numerify('S#####'),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'profile_picture' => fake()->optional()->imageUrl(640, 480, 'people'),
            'courses' => json_encode(fake()->words(3)), // Example of courses as a JSON array
        ];
    }
}
