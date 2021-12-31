<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\State;

class Lga extends Model
{
    use HasFactory;

    public $with = ['state:id,name'];

    public function state(){
        return $this->belongsTo(State::class);
    }
}
