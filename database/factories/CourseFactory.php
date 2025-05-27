<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\Faculty;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_name' => $this->faker->unique()->sentence(3),
            'course_code' => $this->faker->unique()
                                ->bothify($this->faker->randomElement(['CSE', 'MNS', 'ECE', 'EEE', 'BBA']) . '-' . $this->faker->numberBetween(100, 500)),
            'description' => $this->faker->paragraph(),
            'credit' =>3,
            'co-ordinator_id' => Faculty::inRandomOrder()->first()->id,
            'department' => $this->faker->randomElement(['CSE', 'MNS', 'ECE', 'EEE', 'BBA']),


        ];
    }
}
