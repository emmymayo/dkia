<?php

namespace App\Http\Controllers;

use App\Models\CbtQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CbtQuestionController extends Controller
{
    public function index()
    {
        
        if(request()->expectsJson()){
            $cbt_questions = $this->getCbtQuestions();
            return response()->json($cbt_questions);
        }
        return view('pages.cbts.questions.index');
    }

    public function show($id)
    {
        $cbt_question = CbtQuestion::find($id);
        if(request()->expectsJson()){
            return response()->json($cbt_question);
        }
        return;
    }

    public function store(Request $request){
        //Authorize user
        Gate::authorize('admin-and-teacher-only');
        $data = $request->validate([
            'question' => 'required|string',
            'cbt_id' => 'required|exists:cbts,id',
            'instruction' => 'nullable',
            'marks' => 'required|numeric|max:100',
            'type'=> 'nullable|integer',
            'bonus'=> 'nullable|boolean'
        ]);
        $cbt_question = CbtQuestion::create($data);
        if($request->expectsJson()){
            return response()->json([
                'message' => 'success',
                'data' => $cbt_question
            ],201);
        }
        return;
    }

    public function update(Request $request, $id){
        //Authorize user
        Gate::authorize('admin-and-teacher-only');
        $data = $request->validate([
            'question' => 'nullable|string',
            //'cbt_id' => 'nullable|exists:cbts,id',
            'instruction' => 'nullable',
            'marks' => 'nullable|numeric|max:100',
            'type'=> 'nullable|integer',
            'bonus'=> 'nullable|boolean'
        ]);
        $cbt_question = CbtQuestion::find($id);
        $cbt_question->update($data);
        if($request->expectsJson()){
            return response()->json([
                'message' => 'success'
            ],201);
        }
        return;
    }

    public function uploadImage(Request $request, $id)
    {
            Gate::authorize('admin-and-teacher-only');
            $request->validate([
                'image' => 'bail|required|file|image|max:200|mimes:jpg,png'
            ]);
            $cbt_question = CbtQuestion::find($id);
            if($request->file('image')){
                $extension = $request->file('image')->extension();
                $filename = $cbt_question->id.".".$extension;
                $path = $request->file('image')->storeAs('images/cbt',$filename,'public');
                $cbt_question->image = $path;
                $cbt_question->save();
                if($request->expectsJson()){
                    response()->json(['message' => 'success','path'=>$path],201);
                }
                return $path;
            }
            return response()->json(['message' => 'fail']);
        
        
    }

    public function destroy($id){
        //Authorize user
        Gate::authorize('admin-and-teacher-only');
        CbtQuestion::destroy($id);
        if(request()->expectsJson()){
            return response()->json(['message' => 'success']);
        }
    }


    
    private function getCbtQuestions(){
        //Get Eloquemt Query builder after applying filters and ordering
        $cbt_question_query = CbtQuestion::query()
                    ->when(request()->has('cbt_id'),
                        function($query){
                            $query->where('cbt_id',request()->input('cbt_id'));
                        }
                    )->when(request()->has('type'),
                        function($query){
                            $query->where('type',request()->input('type'));
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
        $cbt_questions = request()->has('page') ? $cbt_question_query->paginate() : $cbt_question_query->get();
        return $cbt_questions;
    }
}
