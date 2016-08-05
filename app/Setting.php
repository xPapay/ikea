<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
    	'notify_task_assigned',
    	'notify_task_edited',
    	'notify_task_accomplished',
    	'notify_task_accepted',
    	'notify_task_rejected',
    	'notify_comment_added',
    	'no_interruption_from',
    	'no_interruption_to'
    ];
}
