<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 class Comment extends Model{

    protected $fillable = [
        'id','user_id', 'post_id','photo'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }

}