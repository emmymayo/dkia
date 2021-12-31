<?php

namespace App\Http\Controllers;

use App\Models\Cbt;
use App\Models\CbtResult;
use App\Models\Mark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Support\Helpers\Exam as ExamHelper;
use Symfony\Component\HttpFoundation\Response;

class StudentCbtResultController extends Controller
{
    public function index(){
        Gate::authorize('student-only');
        $data = request()->validate([
            'cbt_id' => 'nullable|exists:cbts,id',
            'cbt_question_id' => 'nullable|exists:cbt_questions,id',
        ]);
        $auth_student_id = auth()->user()->student->id;
        $student_current_section = ExamHelper::getStudentCurrentSection($auth_student_id);
        $cbt_query = CbtResult::query()
                                ->where('student_id',$auth_student_id)
                                ->where('section_id', $student_current_section->id)
                                ->when(isset($data['cbt_id']), fn($query)=>$query->where('cbt_id',$data['cbt_id']))
                                ->when(isset($data['cbt_question_id']), fn($query)=>$query->where('cbt_question_id',$data['cbt_question_id']));
                                
        $cbt_results = request()->has('page')? $cbt_query->paginate : $cbt_query->get();
        
        if(request()->expectsJson()){
            return response()->json($cbt_results);
        };
        return;

    }

    public function update(Request $request){
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
         isset($data['answer']) ? $result->answer = $data['answer'] : null ;
        isset($data['seconds_left']) ? $result->seconds_left = $data['seconds_left'] : null ;
        $result->save();

        
        if($request->expectsJson()){
            return response()->json([
                'message' => 'success'
            ],Response::HTTP_ACCEPTED);
        }
        return;
    }
    public function calculateResult(Request $request){
        $data = $request->validate([
            'cbt_id' => 'required|exists:cbts,id',
        ]);

        $auth_student_id = auth()->user()->student->id;
        $student_current_section = ExamHelper::getStudentCurrentSection($auth_student_id);
        $results = CbtResult::query()
            ->where('cbt_id',$data['cbt_id'])
            ->where('student_id',$auth_student_id)
            ->where('section_id',$student_current_section->id)
            ->get();
        $score = 0;
        $total = 0;
        foreach ($results as $result) {
            $total += $result->cbtQuestion->marks;
            if($result->cbtQuestion->isCorrectAnswer($result->answer)){
                
               $score += $result->cbtQuestion->marks; 
            }
        }
        // Save to CASS if it isnt a mock
        $this->saveScore($score, $data['cbt_id'], $auth_student_id, $student_current_section->id);

        return response()->json([
            'score'=>$score,
            'total'=>$total,
            ]);
        
    }

    private function saveScore($score, $cbt_id, $student_id, $section_id){
        $cbt = Cbt::find($cbt_id);

        if($cbt->isMock()){
            return;
        }

        $mark = Mark::firstWhere([
            'exam_id' => $cbt->exam_id,
            'subject_id' => $cbt->subject_id,
            'student_id' => $student_id,
            'section_id' => $section_id
        ]);

        // fill score in cass column based on cbt type
        switch ($cbt->type) {
            case Cbt::TYPE_CASS1 :
                $mark->cass1 = $score;
                break;
            case Cbt::TYPE_CASS2 :
                $mark->cass2 = $score;
                break;
            case Cbt::TYPE_CASS3 :
                $mark->cass3 = $score;
                break;
            case Cbt::TYPE_CASS4 :
                $mark->cass4 = $score;
                break;
            case Cbt::TYPE_TASS :
                $mark->tass = $score;
                break;
            
            default:
                break;
        }
        $mark->save();

    }

}
