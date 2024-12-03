<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notification extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'data', 'notifiable_id', 'notifiable_type', 'read_at'];

    /**
     * Boot method to generate UUIDs when creating a new notification.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically set UUID for new notifications
        static::creating(function ($notification) {
            $notification->id = (string) Str::uuid(); // Generate a UUID for the ID
        });
    }
}