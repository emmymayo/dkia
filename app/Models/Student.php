<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\State;
use App\Models\Lga;
use App\Models\User;
use App\Models\Mark;
use Illuminate\Database\Eloquent\Builder;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    public $with = ['user:id,name,email,avatar,status','state','lga'] ;
    protected $fillable = [
        'admin_no',
        'year_admitted',
        'graduated',
        'gender',
        'dob',
        'state_id',
        'lga_id',
        'address',
        'phone1',
        'phone2',
    ];

    protected static function booted()
    {
        static::addGlobalScope('soft-deletes', function (Builder $builder) {
            $builder->whereNotIn('user_id', function($query){
                $query->select('id')
                    ->from('users')
                    ->where('deleted_at','<>','null');
            });
        });
    }

    public function user(){
        return $this->belongsto(User::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function lga(){
        return $this->belongsTo(Lga::class);
    }

    public function marks(){
        return $this->hasMany(Mark::class);
    }

    public function examRecords(){
        return $this->hasMany(ExamRecord::class);
    }

    public function mySection(){
        $section = Section::whereIn('id',\App\Support\Helpers\Exam::getStudentCurrentSection($this->id));
        return $section;
    }
    
}
