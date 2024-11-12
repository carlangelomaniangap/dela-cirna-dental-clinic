<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'dentalclinic_id',
        'image',
        'treatment',
        'description',
    ];

    public function dentalclinic(){
        return $this->belongsTo(DentalClinic::class, 'dentalclinic_id');
    }
}

