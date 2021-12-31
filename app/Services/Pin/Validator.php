<?php

namespace App\Services\Pin;
use App\Models\Pin;

class Validator{


    public function validateAndUse($token, $student_id,$exam_id){
        //try to fetch pin 
        $pin = Pin::where('token',$token)
                    ->where('exam_id',$exam_id)
                    ->where('units_left','>',0)->first();
        if($pin == null){return false;}
        //verify if pin has been used by the same student
        if($pin->isUsed() AND $pin->usedBy() != $student_id){
            return false;
        }
        //use pin see App\Models\Pin->use()
        if($pin->use($student_id)){return true;}
        else{return false;}
    }

    
}