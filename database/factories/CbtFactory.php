<?php

namespace Database\Factories;

use App\Models\Cbt;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class CbtFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cbt::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'exam_id' => Exam::factory(),
            'subject_id' => Subject::factory(),
            'name' => $this->faker->sentence(),
            'duration' => 30, 
            'type' => 1,
            'published' => true

        ];
    }
}
