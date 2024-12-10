<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddStock extends Model
{
    use HasFactory;

    protected $fillable = ['inventory_id', 'receiver_name', 'expiration_date', 'quantity'];

    public function inventory(){
        return $this->belongsTo(Inventory::class);
    }
}