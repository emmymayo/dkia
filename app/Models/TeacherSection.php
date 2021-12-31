<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSection extends Model
{
    use HasFactory;

    protected $table = 'teacher_sections';
    protected $with = ['section'];

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }
}
