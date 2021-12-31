<?php

namespace Database\Factories;

use App\Models\CbtAnswer;
use App\Models\CbtQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class CbtAnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CbtAnswer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cbt_question_id' => CbtQuestion::factory(),
            'value' => $this->faker->word(),
            'correct' => false
        ];
    }
}
