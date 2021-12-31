<?php

namespace App\Http\Controllers;

use App\Models\CbtAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CbtAnswerController extends Controller
{
    public function index()
    {
        
        if(request()->expectsJson()){
            $cbt_answers = $this->getCbtAnswers();
            return response()->json($cbt_answers);
        }
        return ;
    }

    public function show($id)
    {
        $cbt_answer = CbtAnswer::find($id);
        if(request()->expectsJson()){
            return response()->json($cbt_answer);
        }
        return;
    }

    public function store(Request $request){
        //Authorize user
        Gate::authorize('admin-and-teacher-only');
        $data = $request->validate([
            'cbt_question_id' => 'required|exists:cbt_questions,id',
            'value' => 'required',
            'correct'=> 'nullable|boolean',
        ]);
        $cbt_answer = CbtAnswer::create($data);
        if($request->expectsJson()){
            return response()->json([
                'message' => 'success',
                'data' => $cbt_answer
            ],201);
        }
        return;
    }

    public function update(Request $request, $id){
        //Authorize user
        Gate::authorize('admin-and-teacher-only');
        $data = $request->validate([
            // 'cbt_question_id' => 'nullable|exists:cbt_questions,id',
            'value' => 'nullable',
            'correct'=> 'nullable|boolean',
        ]);
        $cbt_answer = CbtAnswer::find($id);
        $cbt_answer->update($data);
        if($request->expectsJson()){
            return response()->json([
                'message' => 'success'
            ],201);
        }
        return;
    }

    public function destroy($id){
        //Authorize user
        Gate::authorize('admin-and-teacher-only');
        CbtAnswer::destroy($id);
        if(request()->expectsJson()){
            return response()->json(['message' => 'success']);
        }
    }


    private function getCbtAnswers(){
        //Get Eloquemt Query builder after applying filters and ordering
        $cbt_answer_query = CbtAnswer::query()
                    ->when(request()->has('cbt_question_id'),
                        function($query){
                            $query->where('cbt_question_id',request()->input('cbt_question_id'));
                        }
                    )->when(request()->has('correct'),
                        function($query){
                            $query->where('correct',request()->input('correct'));
                        }
                    )->when(request()->has('order'), 
                        function($query){
                            $query->orderBy(request()->input('order'),request()->input('direction','desc'));
                        }
                    )->when(!request()->has('order'), 
                        function($query){
                            $query->latest();
                        }
                    );
    
        //Whenever url query contains page then paginate, else return the collection
        $cbt_answers = request()->has('page') ? $cbt_answer_query->paginate() : $cbt_answer_query->get();
        return $cbt_answers;
    }

}
