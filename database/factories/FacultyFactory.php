<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faculty>
 */
class FacultyFactory extends Factory
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
                'faculty_id' => fake()->unique()->numerify('FAC-######'),
                'initial' => fake()->unique()->lexify('???'),
                'email' => fake()->unique()->safeEmail(),
                'designation' => $this->faker->randomElement(['Professor', 'Senior Lecturer', 'Assistant Professor', 'Lecturer']),
                'department' => $this->faker->randomElement(['CSE', 'MNS', 'ECE', 'EEE', 'BBA']),
                'phone' => $this->faker->phoneNumber(),
                'bio' => $this->faker->paragraph(),
                'profile_picture' => $this->faker->imageUrl(640, 480, 'people'),
        
        ];
    }
}
