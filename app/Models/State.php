<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lga;

class State extends Model
{
    use HasFactory;

    public function lgas(){
        return $this->hasMany(Lga::class);
    }
}
