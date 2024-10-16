<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model
{
    protected $table = 'inventoryhistories';

    protected $fillable = ['inventory_id', 'quantity', 'action'];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}

