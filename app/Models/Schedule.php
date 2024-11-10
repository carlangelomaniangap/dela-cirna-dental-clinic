<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'startweek',
        'endweek',
        'startmorningtime',
        'endmorningtime',
        'startafternoontime',
        'endafternoontime',
        'closedday'
    ];
}