<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimetableTimeslot extends Model
{
    use HasFactory;

    public function timetableRecords(){
        return $this->hasMany(TimetableRecord::class);
    }

    // public function getFromAttribute($value){
    //     return strtotime($value);
    // }

    // public function getToAttribute($value){
    //     return strtotime($value);
    // }
}
