<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\Helpers\SchoolSetting;
use App\Models\StudentSectionSession;

class PromotionController extends Controller
{
    public function index(){
        return view('pages.promotions.index');
    }

    public function promoteStudent(Request $request){
        $request->validate([
            'student_id' => 'required',
            'next_section' => 'required'
        ]);
        $next_session_id = SchoolSetting::getNextSchoolSessionId();
        $promotion = StudentSectionSession::updateOrCreate(
            ['student_id'=> $request->input('student_id'), 
            'session_id' => $next_session_id ],
            ['section_id' => $request->input('next_section')]
        );
        $promotion_record_count = StudentSectionSession::where([
                            'student_id' => $request->input('student_id'),
                            'session_id' => $next_session_id,
                            'section_id' => $request->input('next_section'),
                    ])->count();
        if(!$promotion_record_count>0){
           
            return response()->json(['message'=>'failed'],201);
        }

        return response()->json(['message'=>'success'],201);
    }
}
