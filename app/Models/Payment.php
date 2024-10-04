<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'paymenthistories';

    protected $fillable = ['payment_id', 'payment',];

    public function patient(){
        return $this->belongsTo(User::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function paymentInfo(){
        return $this->belongsTo(PaymentInfo::class);
    }
}

