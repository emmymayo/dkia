<?php

namespace Database\Factories;

use App\Models\TimetableRecord;

use Illuminate\Database\Eloquent\Factories\Factory;

class TimetableRecordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TimetableRecord::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'timetable_id' => \App\Models\Timetable::factory(),
            'timetable_timeslot_id' => \App\Models\TimetableTimeslot::factory(),
            'day' => $this->faker->dayOfWeek(),
            'entry' => $this->faker->word()
        ];
    }
}
