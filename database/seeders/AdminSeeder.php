<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->truncate();

        Admin::factory()
                ->for(
                    User::factory()
                            ->create([
                                'role_id' => Role::firstWhere('name','admin')->id,
                                'email' => 'admin@sms.com'
                                ])
                )->create();
    }
}
