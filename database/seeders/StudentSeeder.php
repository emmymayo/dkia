<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Section;
use App\Models\Session;
use App\Models\Student;
use App\Models\StudentSectionSession;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    use WithFaker;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->delete();
        //get number of students to seed from config file settings.php
        $count = config('settings.seed.students');
        //pick from first 3 sessions
        $sessions = Session::whereIn('id',[1,2,3])->get()->pluck('id');
        $sections = Section::where('id','>',0)->pluck('id');

        //Create specific student 
        $student = Student::factory()->for(User::factory()->create([
            'email' => 'student@sms.com',
            'role_id' => Role::firstWhere('name','student')->id
        ]))->create();
            //Assign each Student to section
        StudentSectionSession::create([
            'student_id' => $student->id,
            'session_id' => collect($sessions)->random(1)[0], //randomize, pick one and get first index
            'section_id' => collect($sections)->random(1)[0],

        ]);
        for($i=0;$i<$count;$i++){
            $student = Student::factory()->for(User::factory()->create([
                'role_id' => Role::firstWhere('name','student')->id
            ]))->create();
                //Assign each Student to section
            StudentSectionSession::create([
                'student_id' => $student->id,
                'session_id' => collect($sessions)->random(1)[0], //randomize, pick one and get first index
                'section_id' => collect($sections)->random(1)[0],

            ]);
        }
    }
}
