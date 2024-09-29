<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentInfo extends Model
{
    protected $table = 'paymentinfos';

    protected $fillable = ['users_id', 'patientname','description', 'amount', 'balance', 'date'];

    public function patient(){
        return $this->belongsTo(User::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class, 'users_id');
    }
}

