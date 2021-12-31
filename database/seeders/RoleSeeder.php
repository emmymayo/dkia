<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'super', 'admin','teacher','student','accountant','librarian','parent','support'
        ];
        DB::table('roles')->delete();
        foreach ($roles as $key => $role) {
           Role::factory()->create(['name' => $role]);
        }
    }
}
