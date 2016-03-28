<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'path',
        'type',
    ];

    public function documentable()
    {
        return $this->morphTo();
    }
}