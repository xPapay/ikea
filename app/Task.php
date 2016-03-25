<?php

namespace App;

use Carbon\Carbon;
use Exception;

class Task extends Executable
{
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

    public function scopeFilter($query, $filters)
    {
        if ($filters['keyword'] != '')
        {
            $query = $query->withKeyword($filters['keyword']);
        }

        if ($filters['deadline_from'] != '')
        {
            $query = $query->deadlineFrom(Carbon::createFromFormat('d. m. Y', $filters['deadline_from']));
        }

        if ($filters['deadline_to'] != '')
        {
            $query = $query->deadlineTo(Carbon::createFromFormat('d. m. Y', $filters['deadline_to']));
        }

        return $query;
    }


}
