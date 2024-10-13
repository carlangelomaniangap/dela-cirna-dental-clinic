<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DentalClinic extends Model
{
    use HasFactory;

    protected $table = 'dentalclinics';

    protected $fillable = ['logo', 'dentalclinicname'];

    // Define the relationship to users
    public function users()
    {
        return $this->hasMany(User::class, 'dentalclinic_id');
    }
}

