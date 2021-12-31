<?php

namespace App\Http\Controllers;

use App\Models\Cbt;
use App\Models\CbtResult;
use App\Models\CbtSection;
use App\Models\Mark;
use App\Support\Helpers\Exam as ExamHelper;
use App\Support\Helpers\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class StudentCbtController extends Controller
{
    public function index(){
        Gate::authorize('student-only');
        if(request()->expectsJson()){
            $cbts = $this->getStudentCbts();
            return response()->json($cbts);
        }
        return view('pages.student-cbts.index');
    }

    public function updateResult(Request $request){
        //Authorize user
        Gate::authorize('student-only');
        $data = $request->validate([
            
            'cbt_id' => 'required|exists:cbts,id',
            'cbt_question_id' => 'required|exists:cbt_questions,id',
            'answer' => 'nullable',
            'seconds_left'=> 'nullable|integer',
        ]);
        $auth_student_id = auth()->user()->student->id;
        $student_current_section = ExamHelper::getStudentCurrentSection($auth_student_id);
        $result = CbtResult::firstOrNew([
            'student_id' => $auth_student_id,
            'section_id' => $student_current_section->id,
            'cbt_id' => $data['cbt_id'],
            'cbt_question_id' => $data['cbt_question_id']
        ]);
         $result->answer = isset($data['answer']) ? $data['answer'] : null ;
         $result->seconds_left = isset($data['seconds_left']) ? $data['seconds_left'] : null ;
        $result->save();


        
        if($request->expectsJson()){
            return response()->json([
                'message' => 'success'
            ],Response::HTTP_ACCEPTED);
        }
        return;
    }

    // get authenticated student user Cbts
    private function getStudentCbts(){ 

        $active_exam_id = SchoolSetting::getSchoolSetting('active.exam');
        $auth_student_id = auth()->user()->student->id;
        $student_current_section = ExamHelper::getStudentCurrentSection($auth_student_id);

         $registered_subjects = Mark::where([
            'exam_id' => SchoolSetting::getSchoolSetting('active.exam'),
            'section_id' => $student_current_section->id,
            'student_id' => $auth_student_id
        ])->get('subject_id');
        $cbt_query = Cbt::query()
                    // filter by active exam
                    ->where('exam_id',$active_exam_id)
                    // Filter by student's current section
                    ->whereIn('id',CbtSection::where('section_id',$student_current_section->id)->get()->pluck('cbt_id'))
                    // filter by registered subjects
                    ->whereIn('subject_id',$registered_subjects->pluck('subject_id'))
                    ->where('published',true)
                    ->when(request()->has('order'), 
                        function($query){
                            $query->orderBy(request()->input('order'),request()->input('direction','desc'));
                        }
                    )->when(!request()->has('order'), 
                        function($query){
                            $query->latest();
                        }
                    );

            //Whenever url query contains page then paginate, else return the collection
            $cbts = request()->has('page') ? $cbt_query->paginate() : $cbt_query->get();
            return $cbts;
    }
}
