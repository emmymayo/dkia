<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    public $table = 'classes';
    public $with = ['classType'];
    protected $fillable = ['name','class_type_id'];

    public function classType(){
        return $this->belongsTo(ClassType::class);
    }

    public function sections(){
        return $this->hasMany(Section::class);
    }
}
