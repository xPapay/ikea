<?php

namespace App;

use Carbon\Carbon;

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
}
