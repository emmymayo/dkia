<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Student\StudentCSVDataImporter;
use App\Models\User;
use App\Models\Role;
use App\Models\Student;
use App\Models\State;
use App\Models\Lga;
use App\Models\Section;
use App\Models\StudentSectionSession;
use App\Support\Helpers\SchoolSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentSectionCSVImportController extends Controller
{
    public function index(Request $request, Section $section)
    {
        return view('pages.sections.import-students', [
            'section' => $section,
            'template_url' => Storage::url('csv/student-template.csv')
        ]);
    }

    /* 
        Requires name, email, gender respectively
        create a template for ease
    */

    public function import(Request $request, Section $section)
    {
        $request->validate([
            'students_csv'  => ['required','file', 'max:1024', 'mimes:csv,txt'],
            // 'section_id'    => ['required', 'exists:sections,id']
        ]);
        $data = StudentCSVDataImporter::import($request->file('students_csv'));
        
        try{
    
           $result = DB::transaction( function() use($data, $request, $section)  {
                $skipped = [];
                $successful = [];
                foreach ($data as $key => $studentData) {
                    if (User::where('email', $studentData['email'])->count() > 0) {
                        $skipped[] = $studentData;
                        continue; 
                    }

                    $role = Role::where('name','student')->first();
                    
                    $user = new User([
                        'name' => $studentData['name'],
                        'email' => $studentData['email'],
                        'password' => Hash::make(config('settings.import.student.default-password')),
                        'role_id' => $role->id
                    ]);
                    $user->save();

                    $user->student()->save(new Student([
                        'dob' => now(), //use today
                        'gender' => $studentData['gender'],
                        'state_id' => State::DEFAULT_STATE, //set FCT if empty
                        'lga_id' => Lga::DEFAULT_LGA,  // set Municipal Area Council if empty
                    ]));
            
                    $student_section_session = StudentSectionSession::create([
                        'student_id' => $user->student->id,
                        'section_id' => $section->id,
                        'session_id' => SchoolSetting::getSchoolSetting('current.session'),
                    ]);
                    $successful[] = $studentData;
                }
                return ['skipped' => $skipped, 'successful' => $successful];
    
            },3);
    
        }catch (Exception $e){
            // set error;
            // if email is not uniques it will crash
            return back()->with('error', 'Something went wrong. Ensure emails are unique');
        }
        return back()->with(['skipped' => $result['skipped'], 'successful' => $result['successful']]);
    }
}
