<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pin extends Model
{
    use HasFactory;
    protected $table = "exam_pins";
    public $with = ['exam'] ;
    private $default_units = 100;

    public function exam(){
        return $this->belongsTo(Exam::class);
    }

    public function generate($exam_id){
        $token = Str::random(12);
        if($this->where('token',$token)->count()>0){
            $this->generate($exam_id);
        }
        $this->exam_id = $exam_id;
        $this->units_left = $this->default_units;
        $this->token = $token;
        if(!$this->save()){
            //failes to save
            return null;
        }
        return $this;
        
    }

    public function revoke(){
        $this->units_left = 0;
        return $this->save();
    }

    public function reset(){
        $this->units_left = $this->default_units;
        $this->student_id = null;
        return $this->save();
    }

    public function isUsed(){
        if($this->student_id != null || $this->student_id != ''){
            return true;
        }
        return false;
    }

    public function usedBy(){
        if($this->student_id != null || $this->student_id != ''){
            return $this->student_id;
        }
        return null;
    }

    public function use($student_id){
        if($this->units_left<1){return false;}
        //if it hasnt been used then bind to the student
        if(!$this->isUsed()){
            $this->student_id = $student_id;
        }
        $this->units_left -= 1;
        return $this->save();
    }

    
}
