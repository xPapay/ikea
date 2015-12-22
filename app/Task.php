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

    public function setDeadlineAttribute($date)
    {
        $this->attributes['deadline'] = Carbon::createFromFormat('d. m. Y', $date);
    }

    public function getDeadlineAttribute($date)
    {
        return Carbon::parse($date)->format('d. m. Y H:i');
    }

    public function setAccomplishDateAttribute($date)
    {
        $this->attributes['accomplish_date'] = Carbon::createFromFormat('d. m. Y', $date);
    }

    public function getAccomplishDateAttribute($date)
    {
        if ($date == null)
            return null;
        return Carbon::parse($date)->format('d. m. Y H:i');
    }

    public function scopeWithStatus($query, $status)
    {
        if ($status == 'unfinished')
            return $query->whereNull('accomplish_date')->get();
        if ($status == 'finished')
            return $query->whereNotNull('accomplish_date')->get();
        if ($status == 'all')
            return $query->get();
        throw new Exception('Undefined Status');
    }
}
