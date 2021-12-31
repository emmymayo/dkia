<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    public function scheduleable(){
        return $this->morphTo();
    }

    public function timetableRecords(){
        return $this->hasMany(TimetableRecord::class);
    }
}
