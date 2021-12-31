<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cbt extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    const TYPE_MOCK = 1;
    const TYPE_CASS1 = 2;
    const TYPE_CASS2 = 3;
    const TYPE_CASS3 = 4;
    const TYPE_CASS4 = 5;
    const TYPE_TASS = 6;

    protected $with = ['exam','subject'];
    
    public function exam(){
        return $this->belongsTo(Exam::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function questions(){
        return $this->hasMany(CbtQuestion::class);
    }

    public function isPublished() 
    {
        return (bool)$this->published;
    }

    public function isMock(){
        return (bool) ($this->type == static::TYPE_MOCK);
    }
    
}
