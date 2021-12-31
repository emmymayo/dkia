<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark;
use App\Models\Subject;
use App\Support\Helpers\SchoolSetting;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\StudentSectionSession;

class StudentSubjectController extends Controller
{
    public function studentRegisteredSubjects(){
        $exam_id = SchoolSetting::getSchoolSetting('active.exam');
        $student_id= null;
        $user = User::find(Auth::id());
        if($user->isStudent()){
            $student_id = $user->student->id;
        }

        

        $subjects = Subject::whereIn('id', function($query) use($student_id,$exam_id){
                        $query->select('subject_id')->from('marks')
                                ->where('exam_id',$exam_id)
                                ->where('student_id',$student_id)
                                ->get();
                    })->get();
        

       return view('pages.students.registered-subjects',[
           'subjects' => $subjects
       ]);
    }

    public function studentRegistration(){
        $user = User::find(Auth::id());
        $session = SchoolSetting::getSchoolSetting('current.session');
        if($user->isStudent()){
            $student = $user->student;
            $sss = StudentSectionSession::firstWhere(['student_id'=>$student->id,'session_id'=>$session]);
            $student_section = $sss->section_id;
        }
        return view('pages.students.register-subjects',[
            'student' =>$student,
            'student_section' => $student_section
        ]);
    }

    public function registeredSubjectsJson($student_id){
        $exam_id = SchoolSetting::getSchoolSetting('active.exam');
        $subjects = Subject::whereIn('id', function($query) use($student_id,$exam_id){
            $query->select('subject_id')->from('marks')
                    ->where('exam_id',$exam_id)
                    ->where('student_id',$student_id)
                    ->get();
        })->get();
        return response()->json($subjects,200);
    }
}
