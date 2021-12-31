<?php

namespace App\Http\Controllers;

use App\Events\MeetingCreated;
use App\Events\MeetingDeleted;
use App\Events\MeetingUpdated;
use App\Models\EClass;
use App\Services\EClass\Zoom\Meeting\Meeting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;

class EClassController extends Controller
{
    public function index(){
        
        if(request()->expectsJson()){
            return $this->getEClasses();
        }

        return view('pages.eclasses.index');
    }

    private function getEClasses(){
        $e_classes = EClass::query()
                            ->when(request()->has('section_id'),
                                function($query){
                                    $query->where('section_id', request()->input('section_id'));
                                }
                            )
                            ->latest()
                            ->paginate(15);
        return response()->json($e_classes);
    }

    public function show($id){

        $e_class = EClass::find($id);
        if(request()->expectsJson()){
            return response()->json($e_class);
        }

        return;
    }
    /**
     *  Retrieves Meeting to get updated start url
     * 
     */

    public function retrieve($id){
        Gate::authorize('admin-and-teacher-only');
        $e_class = EClass::find($id);
        try {
            $meeting = new Meeting();
            $response = $meeting->get($e_class->zoom_meeting_id);
            $e_class->start_url = $response['start_url'];
            $e_class->save();
            if(request()->expectsJson()){
                return response()->json($e_class);
            }
            
        } catch (\Throwable $th) {
            if(request()->expectsJson()){
                return response()->json([
                    'message' => $th->getMessage()
                ],500);
            }

            
        }
    }

    public function store(Request $request){
        Gate::authorize('admin-and-teacher-only');
        $data = $request->validate([
            'topic' => 'required|string|max:200',
            'duration' => ['required', 'numeric', 'max:'.config('settings.e-class.max-class-duration'),],
            'start_time' => ['required', ],
            'password' => ['required', Password::min(8)],
            'section_id' => ['required','exists:sections,id'] 
        ]);
        //set meeting type to scheduled 2
        $data['type'] = 2;
         
        $meeting = new Meeting();

        try {
            
            $response = $meeting->create($data);
            
            MeetingCreated::dispatch($response,$data['section_id']);
            if($request->expectsJson())
            return response()->json([
                'message' => 'success',
                'data' => $response
            ],201);
        } catch (\Throwable $th) {
            if(request()->expectsJson()){
                return response()->json([
                    'message' => $th->getMessage()
                ],500);
            }

        }
        
    }

    public function update(Request $request, $id){
        Gate::authorize('admin-and-teacher-only');
        $data = $request->validate([
            'topic' => 'nullable|string|max:200',
            'duration' => ['nullable', 'numeric', 'max:'.config('settings.e-class.max-class-duration'),],
            'start_time' => ['nullable', ],
            'password' => ['nullable', Password::min(8)],
            'section_id' => ['nullable','exists:sections,id']
        ]);
        
        $e_class = EClass::find($id);
        $meeting = new Meeting();
        try {
            $response = $meeting->update($e_class->zoom_meeting_id,$data);
            MeetingUpdated::dispatch($data,$id);
            if($request->expectsJson())
            return response()->json([
                'message' => 'success',
                'data' => $response
            ],201);
        } catch (\Throwable $th) {
            if(request()->expectsJson()){
                return response()->json([
                    'message' => $th->getMessage()
                ],500);
            }

        }
        
    }


    public function destroy($id){
        Gate::authorize('admin-and-teacher-only');
        $e_class = EClass::find($id);
        try {
            $meeting = new Meeting();
            $response = $meeting->delete($e_class->zoom_meeting_id);
            MeetingDeleted::dispatch($e_class);
            if(request()->expectsJson()){
                return response()->json(['message' => 'success']);
            }
        } catch (\Throwable $th) {
            if(request()->expectsJson()){
                return response()->json(['message' => $th->getMessage(),500]);
            }
        }
    }
}
