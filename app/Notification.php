<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'user_id',
        'task_id',
    ];

    public function task()
    {
        return $this->belongsTo('App\Task')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /** Get all users who will be notified **/
    public function involved_users()
    {
        return $this->belongsToMany('App\User', 'notification_user', 'notification_id', 'user_id');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d. m. Y H:i:s');
    }

    public function scopeLatestTen($query)
    {
        return $query->orderBy('created_at', 'desc')->take(10);
    }

}
