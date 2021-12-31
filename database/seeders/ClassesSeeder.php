<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Classes;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
            'Nursery 1', 'Primary 1', 'Primary 2', 'JSS 1', 'SS 1',
        ];
        DB::table('classes')->delete();
        foreach($classes as $each_class){
            Classes::factory()->create([
                'name' => $each_class
            ]);
        }
    }
}
