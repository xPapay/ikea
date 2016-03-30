<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'path',
        'type',
        'name'
    ];

    public function documentable()
    {
        return $this->morphTo();
    }
}