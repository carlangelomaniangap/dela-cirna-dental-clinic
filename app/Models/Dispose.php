<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispose extends Model
{
    use HasFactory;

    protected $fillable = ['inventory_id', 'addstock_id', 'reason', 'expiration_date', 'disposequantity'];

    public function inventory(){
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function addStocks(){
        return $this->belongsTo(AddStock::class, 'inventory_id');
    }
}