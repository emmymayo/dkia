<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teachers')->delete();
        Teacher::factory()->for(User::factory()->create([
                                'role_id' => Role::firstWhere('name','teacher')->id,
                                'email' => 'teacher@sms.com'
                            ]))->create();
    }
}
