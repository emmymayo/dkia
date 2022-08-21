<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\State;

class Lga extends Model
{
    use HasFactory;

    const DEFAULT_LGA = 281; //Abuja municipal
    
    public $with = ['state:id,name'];

    public function state(){
        return $this->belongsTo(State::class);
    }
}
