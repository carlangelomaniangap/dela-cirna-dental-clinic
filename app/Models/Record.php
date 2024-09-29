<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table = 'records';

    protected $fillable = ['file', 'patientlist_id'];

    public function patientlist(){
        return $this->belongsTo(Patientlist::class, 'patientlist_id');
    }

}

