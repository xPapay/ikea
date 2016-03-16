<?php
namespace App\Http;


class TaskStatus extends Status
{
    protected $availableStatuses = [
        'unfinished' => 'nedokončené',
        'finished' => 'dokončené',
        'to_confirmation' => 'na schválenie',
        'all' => 'všetky'
    ];


    public function __construct($status)
    {
        parent::__construct($status);
    }

}
