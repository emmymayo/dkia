<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class EClass extends Model
{
    use HasFactory;
    protected $with = ['section'];

    protected $guarded = ['id'];

    public function section(){
        return $this->belongsTo(Section::class);
    }

    // public function setPasswordAttribute($value){
    //     return Crypt::encrypt($value);
    // }

    // public function getPasswordAttribute($value){
    //     return Crypt::decrypt($value);
    // }
}
