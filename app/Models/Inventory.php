<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';

    protected $fillable = ['dentalclinic_id', 'item_name', 'quantity'];

    public function dentalclinic(){
        return $this->belongsTo(DentalClinic::class, 'dentalclinic_id');
    }
}

