<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'path',
        'thumbnail_path',
        'name',
    ];

    public function documentable()
    {
        return $this->morphTo();
    }
}
