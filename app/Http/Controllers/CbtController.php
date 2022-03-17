<?php

namespace App\Http\Controllers;

use App\Models\Cbt;
use App\Models\CbtResult;
use App\Models\CbtSection;
use App\Support\Helpers\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class CbtController extends Controller
{
    public function index(){
        
        if(request()->expectsJson()){
            $cbts = $this->getCbts();
            return response()->json($cbts);
        }
        return view('pages.cbts.index');
    }

    public function show($id){
        $cbt = Cbt::find($id);
        
        if(request()->expectsJson()){
            return response()->json($cbt);
        }
        return;
    }

    public function store(Request $request){
        //Authorize user
        Gate::authorize('admin-and-teacher-only');
        $data = $request->validate([
            'name' => 'required|string|max:250',
            'exam_id' => 'required|exists:exams,id',
            'subject_id' => 'required|exists:subjects,id',
            'duration' => 'required|numeric|max:300',
            'type'=> 'nullable|integer'
        ]);
        $cbt = Cbt::create($data);
        if($request->expectsJson()){
            return response()->json([
                'message' => 'success',
                'data' => $cbt
            ],201);
        }
        return;
    }

    public function update(Request $request, $id){
        //Authorize user
        Gate::authorize('admin-and-teacher-only');
        $data = $request->validate([
            'name' => 'nullable|string|max:250',
            'exam_id' => 'nullable|exists:exams,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'duration' => 'nullable|numeric|max:300',
            'type'=> 'nullable|integer',
            'published' => 'nullable|boolean',
        ]);
        $data = array_filter($data, fn ($value) => $value!==null ); //Remove null elements
       
        $cbt = Cbt::find($id);
        $cbt->update($data);
        if($request->expectsJson()){
            return response()->json([
                'message' => 'success'
            ],201);
        }
        return;
    }

    public function reset($id){
        // Delete every cbt results so all student can restart test
        CbtResult::where('cbt_id',$id)->delete();
        if(request()->expectsJson()){
            return response()->json([
                'message' => 'success'
            ],201);
        }
        return;
    }

    public function destroy($id){
        //Authorize user
        Gate::authorize('admin-only');
        //Delete Associated Questions
        $cbt = Cbt::find($id);
        $cbt->delete();
        if(request()->expectsJson()){
            return response()->json(['message' => 'success']);
        }
    }

    private function getCbts(){
        //validate search just incase
        request()->validate(['search'=> 'nullable|string']);

        //Get Eloquemt Query builder after applying filters and ordering
        $cbt_query = Cbt::query()
                    ->when(request()->has('active_exam') && request('active_exam')==true,
                        function($query){
                            $query->where('exam_id', SchoolSetting::getSchoolSetting('active.exam'));
                        }
                    )->when(request()->has('exam_id'),
                        function($query){
                            $query->where('exam_id',request()->input('exam_id'));
                        }
                    )->when(request()->has('subject_id'),
                        function($query){
                            $query->where('subject_id',request()->input('subject_id'));
                        }
                    )->when(request()->has('section_id'),
                        function($query){
                            $query->whereIn('id',CbtSection::where('section_id',request()->input('section_id'))->get('cbt_id')->pluck('cbt_id'));
                        }
                    )->when(request()->has('search'),
                        function($query){
                            $query->where('name','LIKE',"%".request()->input('search')."%");
                        }
                    )->when(request()->has('type'),
                        function($query){
                            $query->where('type',request()->input('type'));
                        }
                    )->when(request()->has('published'),
                        function($query){
                            $query->where('published',request()->input('published'));
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
        $cbts = request()->has('page') ? $cbt_query->paginate() : $cbt_query->get();
        return $cbts;
    }
}
