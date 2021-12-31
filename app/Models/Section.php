<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mark;

class Section extends Model
{
    use HasFactory;

    public $with = ['classes'];
    protected $fillable = ['name','classes_id'];

    public function classes(){
        return $this->belongsTo(Classes::class);
    }

    public function marks(){
        return $this->hasMany(Mark::class);
    }

    public function examRecords(){
        return $this->hasMany(ExamRecord::class);
    }

    public function timetable(){
        return $this->morphOne(Timetable::class,'scheduleable');
    }
}
