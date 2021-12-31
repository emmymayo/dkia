<?php

namespace Database\Factories;

use App\Models\Lga;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

class LgaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lga::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'state_id' => State::factory(),
            'name' => $this->faker->name()
        ];
    }
}
