<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\Helpers\SchoolSetting;
use App\Models\Exam;
use App\Models\Mark;

class ExamRegistrationController extends Controller
{
    
    public function index(){
        return view('pages.exams.registration.index');
    }

    public function register($student_id, $section_id){
        //Check if User can register course

        return view('pages.exams.registration.register',[
            'student_id' => $student_id,
            'section_id' => $section_id,
            'exam' => Exam::find(
                                SchoolSetting::getSchoolSetting('active.exam')
                            ),
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'subject_id' => 'required',
            'student_id' => 'required',
            'section_id' => 'required',
        ]);
        $exam_id = SchoolSetting::getSchoolSetting('active.exam');

        if(Mark::where([
            'exam_id'=>$exam_id,
            'student_id'=>$request->input('student_id'),
            'section_id'=>$request->input('section_id'),
            'subject_id'=>$request->input('subject_id'),
            ])->count()>0)
        {
            $mark = Mark::where([
                    'exam_id'=>$exam_id,
                    'student_id'=>$request->input('student_id'),
                    'section_id'=>$request->input('section_id'),
                    'subject_id'=>$request->input('subject_id'),
                    ])->first();
            $is_deleted = $mark->delete();
            if($is_deleted){return response()->json(['message'=>'success','action'=>'Subject removed'], 201);}
            return response()->json(['message'=>'fail'], 200);
            

        }
        $mark = new Mark();
        $mark->exam_id = $exam_id;
        $mark->student_id = $request->input('student_id');
        $mark->section_id = $request->input('section_id');
        $mark->subject_id = $request->input('subject_id');
        $is_saved = $mark->save();
        if($is_saved){return response()->json(['message'=>'success','action'=>'Subject added'], 201);}
            return response()->json(['message'=>'fail'], 200);

    }
}
