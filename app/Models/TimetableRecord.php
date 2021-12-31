<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimetableRecord extends Model
{
    use HasFactory;

    protected $with = ['timetable','timetableTimeslot'];

    public function timetable(){
        return $this->belongsTo(Timetable::class);
    }

    public function timetableTimeslot(){
        return $this->belongsTo(TimetableTimeslot::class);
    }
}
