<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use App\Models\Faculty;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTimes = [
                    '08:00',
                    '09:30',
                    '11:00',
                    '12:30',
                    '14:00',
                    '15:30',
                    ];

        $start = $this->faker->randomElement($startTimes);
        $startCarbon = \Carbon\Carbon::createFromFormat('H:i', $start);
        $end = $startCarbon->addMinutes(80)->format('H:i');
        return [
            'section_number' => $this->faker->numberBetween(1, 20), // Random section number between 1 and 10
            'course_code' => Course::inRandomOrder()->first()->course_code, // Unique course code
            'faculty_id' => Faculty::inRandomOrder()->first()->id,
            'day' => $this->faker->randomElement([
                                                ['Monday', 'Wednesday'],
                                                ['Sunday', 'Tuesday'],
                                                ['Saturday', 'Thursday'],
                                            ]),
            'start_time' => $start,
            'end_time' => $end,
            'room' =>fake()->unique()->numerify('Room-####')
        ];
    }
}
