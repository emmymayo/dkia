<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GradeSystem;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class GradeSystemController extends Controller
{
    public function index(){
        
        if(request()->expectsJson())
        {
            return $this->getGradeSystems();
        }
        return view('pages.exams.grade-system.index');
    }

    protected function getGradeSystems(){
        $grade_systems = GradeSystem::all()
                            ->when(request()->has('page'), function($query){
                                $query->paginate(15);
                            });

        return response()->json($grade_systems);
    }

    public function show($id){
        $grade_system = GradeSystem::find($id);
        if(request()->expectsJson()){
            return response()->json($grade_system);
        }
        return;
    }

    public function store(Request $request){
        Gate::authorize('admin-only');
        //validate inputs
        $data = $request->validate([
            'grade' => 'required|string|unique:grade_systems,grade',
            'remark' => 'required|string',
            'from' => 'required|numeric',
            'to' => 'required|numeric|gt:from'
        ]);
        //create and persist model
        $grade_system = new GradeSystem();
        $grade_system->grade = $data['grade'];
        $grade_system->remark = $data['remark'];
        $grade_system->from = $data['from'];
        $grade_system->to = $data['to'];
        $saved = $grade_system->save();
         if(request()->expectsJson()){
            return $saved ? response()->json(["message"=>"success","data"=>$grade_system],201)
                          : response()->json(["message"=>"fail"]);
         }

         return;     

    }
    public function update(Request $request, $id){
        Gate::authorize('admin-only');
        //validate inputs
        $data = $request->validate([
            'grade' => 'nullable|string',
            'remark' => 'nullable|string',
            'from' => 'nullable|numeric',
            'to' => 'nullable|numeric|gt:from'
        ]);
        //create and persist model
        $grade_system = GradeSystem::find($id);
        isset($data['grade'])? $grade_system->grade = $data['grade']:null;
        isset($data['remark'])? $grade_system->remark = $data['remark']:null;
        isset($data['from'])? $grade_system->from = $data['from']:null;
        isset($data['to'])? $grade_system->to = $data['to']:null;
       
        $saved = $grade_system->save();
         if(request()->expectsJson()){
            return $saved ? response()->json(["message"=>"success","data"=>$grade_system],201)
                          : response()->json(["message"=>"fail"]);
         }

         return;
            

    }

    public function destroy($id){
        Gate::authorize('admin-only');
        //find and delete grade system
        $grade_system = GradeSystem::find($id);
        $deleted = $grade_system->delete();
        if(request()->expectsJson()){
            return $deleted ? response()->json(["message"=>"success","data"=>$grade_system],201)
                          : response()->json(["message"=>"fail"]);
         }
         return ; 
    }
    
}
