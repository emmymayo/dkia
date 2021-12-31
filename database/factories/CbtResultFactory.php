<?php

namespace Database\Factories;

use App\Models\Cbt;
use App\Models\CbtQuestion;
use App\Models\CbtResult;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class CbtResultFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CbtResult::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cbt_id' => Cbt::factory(),
            'cbt_question_id' => CbtQuestion::factory(),
            'section_id' => Section::factory(),
            'student_id' => Student::factory()
        ];
    }
}
