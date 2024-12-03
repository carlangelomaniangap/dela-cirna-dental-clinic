<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'calendars';

    protected $fillable = [
        'user_id',
        'appointmentdate',
        'appointmenttime',
        'concern',
        'name',
        'gender',
        'birthday',
        'age',
        'address',
        'phone',
        'email',
        'medicalhistory',
        'emergencycontactname',
        'emergencycontactrelation',
        'emergencycontactphone',
        'relationname',
        'relation',
        'approved',
    ];

    public static $approvedStatuses = ['Pending', 'Completed', 'Cancelled'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

