<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    /**
     * 
     * Payment Service Options
     */
    public const PAYMENT_PAYSTACK = 1;
    public const PAYMENT_FLUTTER = 2;

    /**
     * 
     * Payment Status Options
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCCESSING = 'proccessing';
    public const STATUS_SUCCESSFUL = 'successful';
    public const STATUS_FAILED = 'failed';

    /**
     * 
     * Generate Payment Refrence
     */

    public static function ref(){
        return md5(uniqid());
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
