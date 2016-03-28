<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Documentable
{
    protected $fillable = [
        'content'
    ];

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function task()
    {
        return $this->belongsToMany('App\Task');
    }
}
