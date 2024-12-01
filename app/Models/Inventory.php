<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';

    protected $fillable = ['item_name', 'quantity'];


    public function histories()
    {
        return $this->hasMany(InventoryHistory::class);
    }
}

