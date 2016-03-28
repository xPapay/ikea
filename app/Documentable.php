<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class Documentable extends Model
{
    public function photos()
    {
        return $this->morphMany('App\Photo', 'documentable');
    }

    public function files()
    {
        return $this->morphMany('App\File', 'documentable');
    }
}
