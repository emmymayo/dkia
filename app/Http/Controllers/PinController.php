<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pin;
use App\Models\Exam;
use App\Support\Helpers\SchoolSetting;
use App\Support\Helpers\Exam as ExamHelper;

class PinController extends Controller
{

    public function generateIndex(){
        $this->authorize('viewAny', Pin::class);
        $exams = Exam::all();
        $active_exam_id = SchoolSetting::getSchoolSetting('active.exam');
        return view('pages.pins.generate-index',[
            'exams' => $exams,
            'active_exam_id' => $active_exam_id
        ]);
    }

    public function manage(){
        $this->authorize('viewAny', Pin::class);
        return view('pages.pins.manage');
    }
    public function getExamPins(Request $request,$exam_id){
        $pins = Pin::where('exam_id',$exam_id)->latest()->paginate(50);
        return response()->json($pins,200);
    }

    public function usedBy(Pin $pin){
        if($pin->isUsed()){
            return response()->json($pin->usedBy(),200); 
        }
        return response()->json(null,200);
    }

    public function generatePin(Request $request){
        
        $request->validate([
            'exam_id' => 'required',
            'quantity' => 'required|integer|max:100'
        ]);
        
        $pins = array();
        for($i=0;$i<$request->input('quantity');$i++){
            $pin = (new Pin)->generate($request->input('exam_id'));
            array_push($pins,$pin);
        }
        $pins = collect($pins);
        return view('pages.pins.generate',[
            'pins' => $pins
        ]);

    }

    public function revokePin(Pin $pin){
        if($pin->revoke()){
            return response()->json(['message' =>'success'],201);
        }
        return response()->json(['message' =>'failed'],201);
    }

    public function resetPin(Pin $pin){
        if($pin->reset()){
            return response()->json(['message' =>'success'],201);
        }
        return response()->json(['message' =>'failed'],201);
    }

    
    public function removePin(Pin $pin){
        if($pin->delete()){
            return response()->json(['message' =>'success'],201);
        }
        return response()->json(['message' =>'failed'],201);
    }

    


}
