<?php

namespace Database\Factories;

use App\Models\Cbt;
use App\Models\CbtSection;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

class CbtSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CbtSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cbt_id' => Cbt::factory(),
            'section_id' =>Section::factory()
        ];
    }
}
