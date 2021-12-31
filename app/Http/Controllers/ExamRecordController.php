<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamRecord;
use App\Support\Helpers\SchoolSetting;
use App\Support\Helpers\Exam;

class ExamRecordController extends Controller
{
    public function index(){
        return view('pages.exams.report.record');
    }

    public function getExamRecord($student_id,$section_id){
        $exam_id = SchoolSetting::getSchoolSetting('active.exam');
        $record = ExamRecord::firstWhere([
            'exam_id' => $exam_id,
            'student_id' => $student_id,
            'section_id' => $section_id
        ]);
        if($record!=null){
            return response()->json($record,200);
        }
        $record = new ExamRecord();
        $record->exam_id = $exam_id;
        $record->student_id = $student_id;
        $record->section_id = $section_id;
        $record->skills = Exam::defaultSkills();
        $record->save();
        

        return response()->json($record,200);
    }

    public function update(Request $request, $student_id,$section_id){
        
        $request->validate([
            'attendance' => 'nullable',
            'comment1' => 'nullable',
            'comment2' => 'nullable',
            'skills' => 'nullable|array',

        ]);
        $exam_id = SchoolSetting::getSchoolSetting('active.exam');
        $record = ExamRecord::firstWhere([
            'exam_id' => $exam_id,
            'student_id' => $student_id,
            'section_id' => $section_id
        ]);
        $request->input('comment1')!=null?$record->comment1 = $request->input('comment1')
                                         :null;
        $request->input('comment2')!=null?$record->comment2 = $request->input('comment2')
                                         :null;
        $request->input('attendance')!=null?$record->attendance = (int)$request->input('attendance')
                                         :null;
        $request->input('skills')!=null?$record->skills = $request->input('skills')
                                         :null;
       if($record->save()) {
           return response()->json(['message'=>'success'],201);
       }
       return response()->json(['message'=>'failed']);

    }
}
