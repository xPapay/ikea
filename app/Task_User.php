<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


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

    public function getAccomplishDateAttribute($date)
    {
        if ($date == null)
            return null;
        return Carbon::parse($date)->format('d. m. Y');
    }

    public function scopeWithStatus($query, $status)
    {
        if ($status == 'unfinished')
            return $query->where('confirmed', 0);
        if ($status == 'finished')
            return $query->where('confirmed', 1);
        if ($status == 'to_confirmation')
            return $query->whereNotNull('accomplish_date')->where('confirmed', 0);
        if ($status == 'all')
            return $query;
        throw new Exception('Undefined Status');
    }

    public function scopeUnfinished($query, $count)
    {
        return $query->where('confirmed', 0)->take($count);
    }
}
