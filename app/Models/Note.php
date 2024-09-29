<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';

    protected $fillable = ['note', 'patientlist_id'];

    public function patientlist(){
        return $this->belongsTo(Patientlist::class, 'patientlist_id');
    }

}

