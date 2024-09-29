<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'new_comments';

    protected $fillable = [
        'comment',
    ];

    public $timestamps = true;
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function communityForum(){
        return $this->belongsTo(CommunityForum::class, 'communityforum_id');
    }

}

