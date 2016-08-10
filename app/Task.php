<?php

namespace App;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Executable
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'name',
        'description',
        'deadline'
    ];

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

    public function scopeWithKeyword($query, $keyword)
    {
        return $query->where('name', 'like', '%' . $keyword . '%');
    }

    public function scopeDeadlineFrom($query, $deadlineFrom)
    {
        return $query->where('deadline', '>=', $deadlineFrom);
    }

    public function scopeDeadlineTo($query, $deadlineTo)
    {
        return $query->where('deadline', '<=', $deadlineTo);
    }

    public function scopeWithTags($query, $tags)
    {
        return $query->whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('id', $tags);
        });
    }

    public function scopeWithOrderers($query, $orderers)
    {
        return $query->whereHas('orderer', function ($query) use ($orderers) {
            $query->whereIn('id', $orderers);
        });
    }

    public function scopeFilter($query, $filters)
    {
        if ($filters['keyword'] != '') {
            $query = $query->withKeyword($filters['keyword']);
        }

        if ($filters['deadline_from'] != '') {
            $query = $query->deadlineFrom(Carbon::createFromFormat('d. m. Y', $filters['deadline_from']));
        }

        if ($filters['deadline_to'] != '') {
            $query = $query->deadlineTo(Carbon::createFromFormat('d. m. Y', $filters['deadline_to']));
        }

        if ($filters['tagsList'] != null) {
            $query = $query->withTags($filters['tagsList']);
        }

        if ($filters['orderersList'] != null) {
            $query = $query->withOrderers($filters['orderersList']);
        }

        return $query;
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

}
