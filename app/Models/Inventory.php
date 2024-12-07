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
        'item_type',
        'total_quantity',
        'available_quantity',
        'expiration_date',
        'quantity_used',
        'last_updated',
    ];
}

