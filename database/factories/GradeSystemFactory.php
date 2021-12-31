<?php

namespace Database\Factories;

use App\Models\GradeSystem;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradeSystemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GradeSystem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'grade' => $this->faker->randomElement(['A','B']),
            'remark' => $this->faker->randomElement(["Pass","Fail"]),
            'from' => $this->faker->randomNumber(2),
            'to' => $this->faker->randomNumber(2),
        ];
    }
}
