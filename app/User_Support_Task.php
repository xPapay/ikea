<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Support_Task extends Model
{
    protected $table = 'user_support_task';

    public function task()
    {
    	return $this->belongsTo('App\Task');
    }
}
