<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 class Like extends Model{

    protected $fillable = [
        'id','user_id', 'post_id'
    ];

    public function post(){
        return $this->belongsTo(Post::class);
    }

}