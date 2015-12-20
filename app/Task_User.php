<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task_User extends Model
{
    protected $table = 'task_user';

    public function task()
    {
        return $this->belongsTo('App\Task');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
