<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use App\Support\Helpers\Exam as ExamHelper;
use Illuminate\Validation\ValidationException;

class Mark extends Model
{
    use HasFactory;

    public $with = ['student','subject','exam','section'];
    public $entries = ['cass1','cass2','cass3','cass4','tass'];
    
    protected $hidden ;

    public function __construct()
    {
        //show only cass listed in config ND HIDE OTHERS
        $this->hidden =  collect($this->entries)->filter(function($value){
                            if (!in_array($value,config('settings.cass'))){
                                return $value;
                            }
                        })->toArray();
        
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function exam(){
        return $this->belongsTo(Exam::class);
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function totalScore(){
        $total = $this->cass1 + $this->cass2 + 
                 $this->cass3 + $this->cass4 + 
                 $this->tass ;
        return $total ;
    }

    public function subjectStat(){
        $stat = DB::table('marks')
                ->selectRaw('
                        MIN(cass1+cass2+cass3+cass4+tass) AS mini, 
                        MAX(cass1+cass2+cass3+cass4+tass) AS maxi, 
                        AVG(cass1+cass2+cass3+cass4+tass) AS average  
                        ')
                ->where('exam_id',$this->exam_id)
                ->where('subject_id',$this->subject_id)
                ->first();

        return $stat ;
    }

    public function subjectPosition(){
        $rank = DB::select('SELECT student_id, 
                 RANK() OVER(ORDER BY (cass1+cass2+cass3+cass4+tass) DESC) position
                 from marks 
                 where exam_id = ? and subject_id = ? GROUP BY student_id',[$this->exam_id,$this->subject_id]);
                //->where('exam_id',$this->exam_id)
                //->where('subject_id',$this->subject_id)
                //->where('student_id',$this->student_id)
               // ->get();
       $rank = collect($rank)->where('student_id',$this->student_id)->first();
        $position = ExamHelper::getFormattedPosition($rank->position);

        return $position ;
    }

   public function getCass1Attribute($value){
       return $value+0;
   }
   public function getCass2Attribute($value){
       return $value+0;
   }
   public function getCass3Attribute($value){
       return $value+0;
   }
   public function getCass4Attribute($value){
       return $value+0;
   }
   public function getTassAttribute($value){
       return $value+0;
   }
   public function setCass1Attribute($value){
       if($value > static::maxCassValue('cass1')){
           throw ValidationException::withMessages(['cass1' => 'value exceeds maximum expected value']);
       }
       $this->attributes['cass1'] = $value;
   }
   public function setCass2Attribute($value){
        if($value > static::maxCassValue('cass2')){
            throw ValidationException::withMessages(['cass2' => 'value exceeds maximum expected value']);
        }
        $this->attributes['cass2'] = $value;
   }
   public function setCass3Attribute($value){
        if($value > static::maxCassValue('cass3')){
            throw ValidationException::withMessages(['cass3' => 'value exceeds maximum expected value']);
        }
        $this->attributes['cass3'] = $value;
   }
   public function setCass4Attribute($value){
        if($value > static::maxCassValue('cass4')){
            throw ValidationException::withMessages(['cass4' => 'value exceeds maximum expected value']);
        }
        $this->attributes['cass4'] = $value;
   }
   public function setTassAttribute($value){
        if($value > static::maxCassValue('tass')){
            throw ValidationException::withMessages(['tass' => 'value exceeds maximum expected value']);
        }
        $this->attributes['tass'] = $value;
   }

   public static function maxCassValue(string $value = 'cass1'){
        $max_value = null;
        switch ($value) {
            case 'cass1':
                $max_value = config('settings.cass1.max');
                break;
            case 'cass2':
                $max_value = config('settings.cass2.max');
                break;
            case 'cass3':
                $max_value = config('settings.cass3.max');
                break;
            case 'cass4':
                $max_value = config('settings.cass4.max');
                break;
            case 'tass':
                $max_value = config('settings.tass.max');
                break;
            
            default:
                break;
        }

        return $max_value;
    
   }
}
