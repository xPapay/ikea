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


}
