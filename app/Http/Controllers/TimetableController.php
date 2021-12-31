<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timetable;
use Illuminate\Database\Eloquent\Builder;

class TimetableController extends Controller
{
    public function index(){
        //call api function if it expects json
        if(request()->expectsJson()){
            return $this->getTimetables();
        }
        
        return view('pages.timetables.index');
    }

    public function getTimetables(){
        $data = request()->validate([
                'type' => ['nullable','string'],
                'section_id'=> ['nullable'],
                'exam_id'=> ['nullable'],
        ]);

        $timetables = request()->input('page')==null
                                    ?Timetable::query()
                                    ->with(['scheduleable'])
                                    ->when(!empty($data['type']), 
                                        function(Builder $query) use($data)
                                        {
                                            return $query->where('scheduleable_type',$data['type']);
                                        })
                                    ->when(!empty($data['exam_id']), 
                                        function(Builder $query) use($data)
                                        {
                                            return $query->where([
                                                'scheduleable_type'=>'exams',
                                                'scheduleable_id'=> $data['exam_id']
                                                ]);
                                        })
                                    ->when(!empty($data['section_id']), 
                                        function(Builder $query) use($data)
                                        {
                                            return $query->where([
                                                'scheduleable_type'=>'sections',
                                                'scheduleable_id'=> $data['section_id']
                                                ]);
                                        })
                                    ->latest()
                                    ->when(request()->has('page'), 
                                            function(Builder $query){
                                                $query->paginate(30);
                                            }
                                    )->get()

                                        : Timetable::query()
                                        ->with(['scheduleable'])
                                        ->when(!empty($data['type']), 
                                            function(Builder $query) use($data)
                                            {
                                                return $query->where('scheduleable_type',$data['type']);
                                            })
                                        ->when(!empty($data['exam_id']), 
                                            function(Builder $query) use($data)
                                            {
                                                return $query->where([
                                                    'scheduleable_type'=>'exams',
                                                    'scheduleable_id'=> $data['exam_id']
                                                    ]);
                                            })
                                        ->when(!empty($data['section_id']), 
                                            function(Builder $query) use($data)
                                            {
                                                return $query->where([
                                                    'scheduleable_type'=>'sections',
                                                    'scheduleable_id'=> $data['section_id']
                                                    ]);
                                            })->latest()
                                            ->paginate(30);
                                
        return response()->json($timetables,200);

    }

    public function show(Timetable $timetable){
        if(request()->expectsJson()){
            return $this->getTimetable($timetable);
        }
        
    }

    public function getTimetable(Timetable $timetable){
        $timetable = [
            'data' => $timetable
        ];
        return response()->json($timetable);
    }

    public function store(Request $request) 
    {
        $data = $request->validate([
            'name' => 'required|string',
            'type' => 'in:sections,exams',
            'id' => 'required'
        ]);

        $timetable = new Timetable();
        $timetable->name = $data['name'];
        $timetable->scheduleable_type = $data['type'];
        $timetable->scheduleable_id = $data['id'];
        if($timetable->save())
        {
            return response()->json(['message' => 'success'],201);
        } 
        return  response()->json(['message' => 'failed']);

    }

    public function update(Request $request, Timetable $timetable) 
    {
        $data = $request->validate([
            'name' => 'nullable|string',
            'type' => 'nullable|in:sections,exams',
            'id' => 'required_if:type,sections,exams'
        ]);

        
        isset($data['name'])? $timetable->name = $data['name']:'';
        isset($data['type'])? $timetable->scheduleable_type = $data['type']:'';
        isset($data['id'])? $timetable->scheduleable_id = $data['id']:'';
        if($timetable->update())
        {
            return response()->json(['message' => 'success'],201);
        } 
        return  response()->json(['message' => 'failed']);
        
    }

    public function destroy(Timetable $timetable) 
    {
       
        if($timetable->delete())
        {
            return response()->json(['message' => 'success'],201);
        } 
        return  response()->json(['message' => 'failed']);
        
    }
}
