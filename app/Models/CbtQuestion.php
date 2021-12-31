<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CbtQuestion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['answers'];

    public const TYPE_MULTICHOICE = 1;
    public const TYPE_FREEFORM = 2;

    public function cbt(){
        return $this->belongsTo(Cbt::class);
    }

    public function answers(){
        return $this->hasMany(CbtAnswer::class);
    }

   
    public function isCorrectAnswer($answer_id){
        if($this->isBonus() || $this->hasNoCorrectAnswer()){
            // all or null Answers are correct when 
            // its a bonus or no answer was provided or no answer was flagged correct
            return true;
        }

        $answers = $this->answers;
        foreach($answers as $answer){
            if($answer->isCorrect() && $answer->id == $answer_id){
                return true;
            }
        }
    }

    public function isBonus(){
        return (bool)$this->bonus;
    }

    public function hasNoCorrectAnswer(){
        $answers = $this->answers;
        if($answers->count()==0){
            return true;
        }
        foreach($answers as $answer){
            if($answer->isCorrect()){
                return false; //then it has a correct answer
            }
        }
        return true;
    }
}
