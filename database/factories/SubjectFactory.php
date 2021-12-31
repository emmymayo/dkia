<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subjects = [
            'Mathematics', 'English Studies', 'Basic Science', 'Civic Education', 'Computer Studies'
        ];
        $subject = $this->faker->randomElement($subjects);
        return [
            'name' => $subject,
            'short_name' => substr($subject, 0,3),
        ];
    }
}
