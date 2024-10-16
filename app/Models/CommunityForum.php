<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class communityforum extends Model
{
    protected $table = 'communityforums';

    protected $fillable = ['topic', 'image_path', 'user_id'];

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}