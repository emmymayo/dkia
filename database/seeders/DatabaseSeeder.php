<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            SessionSeeder::class,
            StateSeeder::class,
            LgaSeeder::class,
            ClassTypeSeeder::class,
            // ClassesSeeder::class,
            // SectionSeeder::class,
            // ExamSeeder::class,
            SettingSeeder::class,
            SuperSeeder::class,
            AdminSeeder::class,
            // TeacherSeeder::class,
            // StudentSeeder::class
        ]);
    }
}
