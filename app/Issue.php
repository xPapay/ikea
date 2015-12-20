<?php

namespace App;


class Issue extends Executable
{
    protected $fillable = [
        'name',
        'description',
        'solution',
        'deadline',
        'followup_date',
        'followup_by',
        'costs'
    ];

    //get user who follow up...

}
