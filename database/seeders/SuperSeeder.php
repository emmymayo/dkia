<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'email' => 'super-user@sms.com',
            'password' => '$2y$10$HHBGm8.Mvsmgf2HTWcmrI.nt2KVh05cIjkiTTNC6l65gWfm.Rw.Ae', //TheSmsSuper
            'role_id' => DB::table('roles')->select('*')->where('name','super')->first()->id 
        ]);
    }
}
