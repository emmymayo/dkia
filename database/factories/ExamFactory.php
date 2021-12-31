<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exam::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $years = [2019,2020,2021];
        $year = $this->faker->randomElement($years);
        $terms = [1,2,3];
        $term = $this->faker->randomElement($terms);
        $name = $term.' Term '.$year.'/'.($year+1).' Session Examination' ;
        return [
            'name' => $name,
            'term' => $term,
            'session_id' => Session::whereIn('start',$years)->get()->pluck('id')->random(1)[0],
            'published' => false,
        ];
    }
}
