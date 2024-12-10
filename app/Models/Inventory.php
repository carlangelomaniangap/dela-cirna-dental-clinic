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
        return $this->hasMany(AddStock::class);
    }
}

