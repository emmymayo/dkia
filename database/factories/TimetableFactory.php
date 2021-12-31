<?php

namespace Database\Factories;

use App\Models\Timetable;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimetableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Timetable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        $scheduleable_type = $this->faker->randomElement(['sections','exams']);
        $scheduleable_id = $scheduleable_type=='sections'?\App\Models\Section::firstWhere('id','>',0)
                                                         :\App\Models\Exam::firstWhere('id','>',0);
        return [
            'name' => $this->faker->name(),
            'scheduleable_type' => $scheduleable_type,
            'scheduleable_id' => $scheduleable_id,
            
            
        ];
    }
}
