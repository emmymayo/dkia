<?php

namespace Database\Factories;

use App\Models\TimetableTimeslot;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimetableTimeslotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TimetableTimeslot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $from = $this->faker->time();
        return [
            'from' => $from,
            'to' => \Carbon\Carbon::parse($from)->addMinutes(30)->format('H:i:s'),
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence()
        ];
    }
}
