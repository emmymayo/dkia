<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeacherSectionSubject;

class TeacherSectionSubjectController extends Controller
{
    public function getTeacherSectionSubjects($teacher_id,$section_id){

        $subjects = TeacherSectionSubject::where([
                                        'teacher_id' => $teacher_id,
                                        'section_id' => $section_id
                                     ])->get();
        return response()->json($subjects,200);
    }

    public function toggleTeacherSectionSubject(Request $request, $teacher_id,$section_id){
        $request->validate([
            'subject_id' => 'required'
        ]);

        $subject_count = TeacherSectionSubject::where([
                                        'teacher_id'=>$teacher_id,
                                        'section_id'=>$section_id,
                                        'subject_id'=>$request->input('subject_id')
                                        ])->count();
        if($subject_count>0){
            $teacher_section_subject = TeacherSectionSubject::where([
                'teacher_id'=>$teacher_id,
                'section_id'=>$section_id,
                'subject_id'=>$request->input('subject_id')
                ])->delete();
            return response()->json(['message'=>'success'],201);    
        }
        $teacher_section_subject = new TeacherSectionSubject();
        $teacher_section_subject->teacher_id = $teacher_id;
        $teacher_section_subject->section_id = $section_id;
        $teacher_section_subject->subject_id = $request->input('subject_id');
        
        if($teacher_section_subject->save()){
            return response()->json(['message'=>'success'],201);
        }
        return response()->json(['message'=>'failed'],201);
    }
}
