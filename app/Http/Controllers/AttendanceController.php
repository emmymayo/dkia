<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Attendance;
use App\Support\Helpers\SchoolSetting;
use App\Http\Resources\AttendanceEventResource;
class AttendanceController extends Controller
{
    
    public function rollCallIndex(){
        return view('pages.attendance.roll-call');
    }
    public function rollViewIndex(){
        return view('pages.attendance.roll-view');
    }
    public function studentViewIndex(){
        $user = User::find(Auth::id());
        $student=null;
        if($user->isStudent()){
            $student = $user->student;
        }
        return view('pages.attendance.student-attendance',['student' => $student]);
    }

    public function getStudentRoll(Request $request, $student_id, $section_id){

        $request->validate([
            'exam_id' => 'required',
            'date' => 'required'
        ]);

        $roll = Attendance::firstOrCreate([
            'exam_id' => $request->input('exam_id'),
            'student_id' => $student_id,
            'section_id' => $section_id,
            'date' => $request->input('date')
        ]);

        return response()->json($roll,200);
    }

    public function updateStudentRoll(Request $request, $student_id, $section_id){

        $request->validate([
            'exam_id' => 'required',
            'date' => 'required',
            'morning' => 'required',
            'afternoon' => 'required'
        ]);

        $roll = Attendance::firstWhere([
            'exam_id' => $request->input('exam_id'),
            'student_id' => $student_id,
            'section_id' => $section_id,
            'date' => $request->input('date')
            ]);
        // return failed message if cant find student roll
        if($roll->count()<1){
            return response()->json(['message' => 'failed']);
        }
        $roll->morning = $request->input('morning');
        $roll->afternoon = $request->input('afternoon');
        $roll->remark = $request->input('remark');
        if($roll->save()){
            return response()->json(['message' => 'success'],201);
        }

    }
    public function studentEvents($student_id){
        $exam_id = SchoolSetting::getSchoolSetting('active.exam');
        $attendances = Attendance::where(['exam_id'=>$exam_id,'student_id' => $student_id])->get();
        return AttendanceEventResource::collection($attendances);
        
    }
}
