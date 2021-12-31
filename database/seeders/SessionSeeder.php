<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Session;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //From 2019 to 2039
        for($i=2019;$i<=2039;$i++){
            $year = $i;
           Session::factory()->create([
               'start' => $year,
               'end' => $year+1
           ]);
        }
    }
}
