<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model
{
    protected $table = 'notification_user';
    protected $primaryKey = ['notification_id', 'user_id'];

    protected $fillable = ['delayed'];

	public function notification()
	{
		return $this->belongsTo('App\Notification');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

}
