<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = [
        'item_name',
        'type',
        'unit',
        'stocks',
        'issuance',
        'disposed',
        'remaining_stocks',
        'expiration_date'
    ];

    public function addStocks(){
        return $this->hasMany(AddStock::class, 'inventory_id');
    }

    public function issuance(){
        return $this->hasMany(Issuance::class, 'inventory_id');
    }

    public function dispose(){
        return $this->hasMany(Dispose::class, 'inventory_id');
    }
}

