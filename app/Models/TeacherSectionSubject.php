<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSectionSubject extends Model
{
    use HasFactory;
    protected $table = 'teacher_section_subjects';
    protected $with = ['section','subject'];

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
