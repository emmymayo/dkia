<?php

namespace Database\Factories;

use App\Models\Classes;
use App\Models\ClassType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Classes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $classes = [
            'Nursery 1', 'Nursery 2', 'Primary 1', 'Primary 2', 'JSS 1', 'JSS 2', 'SS 1', 'SS 2'
        ];
        return [
            'name' => $this->faker->randomElement($classes),
            'class_type_id' => ClassType::all()->pluck('id')->random(1)[0], //pick a random class type
        ];
    }
}
