<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patientlist extends Model
{
    protected $table = 'patientlists';

    protected $fillable = ['dentalclinic_id', 'users_id', 'name', 'gender', 'birthday', 'age', 'phone', 'address', 'email'];
    
    
    public function dentalclinic(){
        return $this->belongsTo(DentalClinic::class, 'dentalclinic_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function records(){
        return $this->hasMany(Record::class, 'patientlist_id');
    }

    public function notes(){
        return $this->hasOne(Note::class, 'patientlist_id');
    }

    public function calendars(){
        return $this->hasOne(Calendar::class, 'patientlist_id');
    }

}

