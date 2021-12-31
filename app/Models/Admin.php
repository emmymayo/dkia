<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use HasFactory, SoftDeletes;

    public $with = ['user:id,name,email,avatar,status'] ;
    protected $fillable = [
        'position',
        'contact',
        'phone',
    ];

    public function user(){
        return $this->belongsto(User::class);
    }
    
}
