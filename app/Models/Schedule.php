<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'dentalclinic_id',
        'startweek',
        'endweek',
        'startmorningtime',
        'endmorningtime',
        'startafternoontime',
        'endafternoontime',
        'closedday'
    ];

    public function dentalclinic(){
        return $this->belongsTo(DentalClinic::class, 'dentalclinic_id');
    }
}