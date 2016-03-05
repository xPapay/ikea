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
            return $query->whereNull('accomplish_date');
        if ($status == 'finished')
            return $query->whereNotNull('accomplish_date');
        if ($status == 'all')
            return $query;
        throw new Exception('Undefined Status');
    }


}
