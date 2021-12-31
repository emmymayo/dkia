<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['exam_id','student_id','section_id','date'];
    public function student(){
        return $this->belongsTo(Student::class);
    }

   

    public function exam(){
        return $this->belongsTo(Exam::class);
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }
}
