<?php

namespace App\Http\Controllers;

use App\Models\ExamRecord;
use Illuminate\Http\Request;
use App\Models\Mark;
use App\Models\Exam;
use App\Models\Setting;
use App\Models\Attendance;
use App\Support\Helpers\Exam as ExamHelper;
use App\Support\Helpers\SchoolSetting;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\StudentSectionSession;
use App\Services\Pin\Validator as PinValidator;

class ExamReportCheckerController extends Controller
{
    public function index(){
        return view('pages.exams.report.checker.index',[
            'exams' => Exam::all()
        ]);
    }

    public function studentIndex(){
        $exams = Exam::all();
        $student_id = User::find(Auth::id())->student->id;
        $exam_locked = ExamHelper::isExamLocked();
        return view('pages.exams.report.checker.student-index',[
            'exams' => $exams,
            'exam_locked' => $exam_locked,
            'student_id' => $student_id
        ]);
    }


    public function check(Request $request){
        $exam_locked = ExamHelper::isExamLocked();
        $user = User::find(Auth::id());
        $require_pin = ($exam_locked AND !$user->isAdmin());
        $request->validate([
            'exam_id' => 'required',
            'student_id' => 'required',
            'pin' => $require_pin?'required' :'nullable'
        ]);
        $exam_id = $request->input('exam_id');
        $student_id = $request->input('student_id');
            
        //do whatever checks and authorization if published, pin valid etc
        $exam = Exam::find($exam_id);
        //if exam isnt published it is not available
        if(!$exam->isPublished()){
            return view('pages.exams.report.checker.unavailable');
        }
        
        //get behavioural Analysis Record;
        $record = ExamRecord::where('exam_id',$exam_id)->where('student_id',$student_id)->first();
        if($record == null){
            return view('pages.exams.report.checker.unavailable');
        }
        //validate pin if user is not admin and exam is locked
        if(!($user->isAdmin()) AND $exam_locked){
            $pin_validator = new PinValidator();
            $is_validated = $pin_validator->validateAndUse($request->input('pin'),$student_id,$exam_id);
            if(!$is_validated){
                return back()->with('action-fail','Invalid Token.');
            }
        }
        //if school using attendance system load from ATT SYS else Load from record;
        if(ExamHelper::isUsingAttendanceSystem()){
            $morning_count = Attendance::where([
                                'exam_id' => $exam_id,
                                'student_id' => $student_id,
                                ])->sum('morning');
            $afternoon_count = Attendance::where([
                                'exam_id' => $exam_id,
                                'student_id' => $student_id,
                                ])->sum('afternoon');
            $student_attendance = $morning_count + $afternoon_count;
        }
        else{
            $student_attendance = $record->attendance;
        }
        $marks = Mark::where('exam_id',$exam_id)
                        ->where('student_id',$student_id)
                        ->where('section_id', $record->section_id)
                        ->get();
        
        $settings = Setting::all();
        //generate student avaerage score
        $student_average = Mark::query()
                                ->selectRaw('avg(cass1+cass2+cass3+cass4+tass) as average')
                                ->where('exam_id',$exam_id)
                                ->where('student_id',$student_id)
                                ->where('section_id', $record->section_id)
                                 ->first();
        //get no in section/class from session in exam model
        // $current_session = SchoolSetting::getSchoolSetting('current.session');
        $no_in_class = StudentSectionSession::query()
                            ->where('session_id',$exam->session->id)
                            ->where('section_id', $record->section_id)
                            ->count();
       

        return view('pages.exams.report.checker.viewer',[
            'marks'=>$marks,
            'record'=>$record,
            'exam' =>$exam,
            'attendance' => $student_attendance,
            'student_average' => $student_average->average,
            'no_in_class' => $no_in_class
            ]);
    }

   
}
