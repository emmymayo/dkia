<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $with = ['role'];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    protected static function booted(){
        static::addGlobalScope('notExpired', function(Builder $builder){
            $builder->where('expires_at','>', now());
        });
    }

    public function getExpiresAtAttribute($value){
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
}
