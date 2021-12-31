<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function users(){
        return $this->hasMany(User::class);
    }

    public function notices(){
        return $this->hasMany(Notice::class);
    }

    public function admins(){
        return $this->hasManyThrough(Admin::class,User::class);
    }

    public function teachers(){
        return $this->hasManyThrough(Teacher::class,User::class);
    }

    public function students(){
        return $this->hasManyThrough(Student::class,User::class);
    }

    protected static function booted(){
        static::addGlobalScope('specialRoles', function(Builder $builder){
            $builder->whereNotIn('name', config('settings.roles.exception'));
        });
    }
}
