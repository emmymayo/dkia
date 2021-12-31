<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeacherSection;

class TeacherSectionController extends Controller
{
    public function getTeacherSections($teacher_id){

        $sections = TeacherSection::where('teacher_id',$teacher_id)->get();
        return response()->json($sections,200);
    }

    public function toggleTeacherSection(Request $request, $teacher_id){
        $request->validate([
            'section_id' => 'required'
        ]);

        $section_count = TeacherSection::where([
                                        'teacher_id'=>$teacher_id,
                                        'section_id'=>$request->input('section_id')
                                        ])->count();
        if($section_count>0){
            $teacher_section = TeacherSection::where([
                'teacher_id'=>$teacher_id,
                'section_id'=>$request->input('section_id')
                ])->delete();
            return response()->json(['message'=>'success'],201);    
        }
        $teacher_section = new TeacherSection();
        $teacher_section->teacher_id = $teacher_id;
        $teacher_section->section_id = $request->input('section_id');
        
        if($teacher_section->save()){
            return response()->json(['message'=>'success'],201);
        }
        return response()->json(['message'=>'failed'],201);
    }
}
