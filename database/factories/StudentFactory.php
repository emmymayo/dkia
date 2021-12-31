<?php

namespace Database\Factories;

use App\Models\Lga;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lga = Lga::firstWhere('id','>',0);
        return [
            'user_id' => User::factory(),
            'gender' => $this->faker->randomElement(['Male','Female']),
            'dob' => $this->faker->date(),
            'state_id' => $lga->state_id,
            'lga_id' => $lga->id,
        ];
    }
}
