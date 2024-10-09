<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentInfo extends Model
{
    protected $table = 'paymentinfos';

    protected $fillable = ['dentalclinic_id', 'users_id', 'patientname','description', 'amount', 'balance', 'date'];

    public function dentalclinic(){
        return $this->belongsTo(DentalClinic::class, 'dentalclinic_id');
    }

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

