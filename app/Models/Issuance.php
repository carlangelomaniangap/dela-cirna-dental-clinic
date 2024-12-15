<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issuance extends Model
{
    use HasFactory;

    protected $fillable = ['inventory_id', 'users_id', 'expiration_date', 'distribute_to', 'issuance'];

    public function inventory(){
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'users_id');
    }
}