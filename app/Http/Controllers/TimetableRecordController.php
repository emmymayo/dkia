<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimetableRecord;

class TimetableRecordController extends Controller
{
    public function index(){
       //call api function if it expects json
       if(request()->expectsJson()){
            return $this->getTimetableRecords();
       }
    
    return view('pages.timetables.records.index');
    }

    public function getTimetableRecords(){

        /*
         *  Timetable records can be filtered by
         *   Timetable or timeslot or both
         */
        $records = request()->input('page')!=null
                                  ? TimetableRecord::query()
                                    ->when(
                                        request()->input('timetable_id')!= null,
                                        function($query){
                                            $query->where(
                                                          'timetable_id',
                                                          request()->input('timetable_id')
                                            );
                                        }
                                    )
                                    ->when(
                                        request()->input('timeslot_id')!= null,
                                        function($query){
                                            $query->where(
                                                          'timetable_timeslot_id',
                                                          request()->input('timeslot_id')
                                            );
                                        }
                                    )
                                    ->when(
                                        request()->input('day')!= null,
                                        function($query){
                                            $query->where(
                                                          'day',
                                                          request()->input('day')
                                            );
                                        }
                                    )
                                    ->when(
                                        request()->input('order')!= null,
                                        function($query){
                                            $query->orderBy(request()->input('order'),request()->input('direction'),'desc');
                                        }
                                    )
                                    ->when(
                                        request()->input('order')== null,
                                        function($query){
                                            $query->latest();
                                        }
                                    )
                                    ->paginate(30)
                                 : TimetableRecord::query()
                                 ->when(
                                     request()->input('timetable_id')!= null,
                                     function($query){
                                         $query->where(
                                                       'timetable_id',
                                                       request()->input('timetable_id')
                                         );
                                     }
                                 )
                                 ->when(
                                     request()->input('timeslot_id')!= null,
                                     function($query){
                                         $query->where(
                                                       'timetable_timeslot_id',
                                                       request()->input('timeslot_id')
                                         );
                                     }
                                 )
                                 ->when(
                                     request()->input('day')!= null,
                                     function($query){
                                         $query->where(
                                                       'day',
                                                       request()->input('day')
                                         );
                                     }
                                 )
                                 ->when(
                                     request()->input('order')!= null,
                                     function($query){
                                         $query->orderBy(request()->input('order'),request()->input('direction'),'desc');
                                     }
                                 )
                                 ->when(
                                     request()->input('order')== null,
                                     function($query){
                                         $query->latest();
                                     }
                                 )
                                 ->get();
                                
        return response()->json($records,200);
    }

    public function show($id){
        $record = TimetableRecord::find($id);
        if(request()->expectsJson()){
            return response()->json($record);
        }
        
    }

    public function store(Request $request) 
    {
        $data = $request->validate([
            'timetable_id' => ['required','exists:\App\Models\Timetable,id'],
            'timeslot_id' => ['required','exists:\App\Models\TimetableTimeslot,id'],
            'day' => 'required|string',
            'entry' => 'nullable|string'
        ]);

        $record = new TimetableRecord();
        $record->timetable_id = $data['timetable_id'];
        $record->timetable_timeslot_id = $data['timeslot_id'];
        $record->day = $data['day'];
        isset($data['entry'])?$record->entry = $data['entry']:'';
        
       
        if($record->save())
        {
            return response()->json(['message' => 'success'],201);
        } 
        return  response()->json(['message' => 'failed']);

    }

    public function update(Request $request, $id) 
    {
        $data = $request->validate([
            'timetable_id' => ['nullable','exists:\App\Models\Timetable,id'],
            'timeslot_id' => ['nullable','exists:\App\Models\TimetableTimeslot,id'],
            'day' => 'nullable|string',
            'entry' => 'nullable|string'
        ]);

        $record = TimetableRecord::find($id);
        isset($data['timetable_id'])?$record->timetable_id = $data['timetable_id']:'';
        isset($data['timeslot_id'])?$record->timetable_timeslot_id = $data['timeslot_id']:'';
        isset($data['day'])?$record->day = $data['day']:'';
        isset($data['entry'])?$record->entry = $data['entry']:'';
        
       
        if($record->save())
        {
            return response()->json(['message' => 'success'],201);
        } 
        return  response()->json(['message' => 'failed']);

    }

    public function destroy($id) 
    {
        $record = TimetableRecord::find($id);
        if($record->delete())
        {
            return response()->json(['message' => 'success'],201);
        } 
        return  response()->json(['message' => 'failed']);
        
    }
}
