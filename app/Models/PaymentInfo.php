<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentInfo extends Model
{
    protected $table = 'paymentinfos';

    protected $fillable = ['users_id', 'name','concern', 'amount', 'balance', 'date'];

    public function patient(){
        return $this->belongsTo(User::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class, 'users_id');
    }

    // Define the relationship with the Payment model
    public function payments(){
        return $this->hasMany(Payment::class, 'payment_id'); // Make sure the foreign key is correct
    }
}

