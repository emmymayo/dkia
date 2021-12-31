<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CbtAnswer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function cbtQuestion(){
        return $this->belongsTo(CbtQuestion::class);
    }

    public function isCorrect(){
        return (bool)$this->correct;
    }
}
