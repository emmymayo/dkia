<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimetableTimeslot;
use App\Models\TimetableRecord;
use Illuminate\Support\Facades\DB;

class TimetableTimeslotController extends Controller
{
    public function index(){
        //call api function if it expects json
        if(request()->expectsJson()){
            return $this->getTimetableTimeslots();
        }
        
        return view('pages.timetables.timeslots.index');
    }

    public function getTimetableTimeslots(){

        //check if pagination input is supplied then give paginated result
        $timeslots = request()->input('page')==null
                                    ? TimetableTimeslot::query()
                                      ->latest()
                                      ->get()

                                    : TimetableTimeslot::query()
                                      ->latest()
                                      ->paginate(15);
                                
        return response()->json($timeslots,200);

    }

    public function getTimeslotsByTimetable($timetable_id){
        $timeslots = TimetableTimeslot::query()
                                ->whereIn('id',
                                    function($query) use($timetable_id){
                                            $query->select('timetable_timeslot_id')
                                                ->from('timetable_records')
                                                ->where('timetable_id',$timetable_id)
                                                ->get();
                                                
                                        })
                                    ->orderBy('from','asc')
                                    ->get();

        return response()->json($timeslots);
    }

    public function show($id){
        $timeslot = TimetableTimeslot::find($id);
        if(request()->expectsJson()){
            return response()->json($timeslot);
        }
        
    }

    public function store(Request $request) 
    {
        $data = $request->validate([
            'name' => 'nullable|string',
            'from' => 'required',
            'to' => 'required',
            'description' => 'nullable|string'
        ]);

        $timeslot = new TimetableTimeslot();
        isset($data['name'])? $timeslot->name = $data['name']:'';
        isset($data['description'])? $timeslot->description = $data['description']:'';
        $timeslot->from = $data['from'];
        $timeslot->to = $data['to'];
       
        if($timeslot->save())
        {
            return response()->json(['message' => 'success'],201);
        } 
        return  response()->json(['message' => 'failed']);

    }

    public function update(Request $request, $id) 
    {
        $timeslot = TimetableTimeslot::find($id);
        $data = $request->validate([
            'name' => 'nullable|string',
            'from' => 'nullable',
            'to' => 'nullable',
            'description' => 'nullable|string'
        ]);
          
        isset($data['name'])? $timeslot->name = $data['name']:'';
        isset($data['description'])? $timeslot->description = $data['description']:'';
        isset($data['from'])? $timeslot->from = $data['from']:'';
        isset($data['to'])? $timeslot->to = $data['to']:'';
       
        
        
        if($timeslot->save())
        {
            return response()->json(['message' => 'success'],201);
        } 
        return  response()->json(['message' => 'failed']);
        
    }

    public function destroy($id) 
    {
        $timeslot = TimetableTimeslot::find($id);
        if($timeslot->delete())
        {
            return response()->json(['message' => 'success'],201);
        } 
        return  response()->json(['message' => 'failed']);
        
    }
}
