<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CbtResult extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['cbtQuestion'];

    public function cbt(){
        return $this->belongsTo(Cbt::class);
    }

    public function cbtQuestion(){
        return $this->belongsTo(CbtQuestion::class);
    }


}
