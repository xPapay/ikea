<?php
namespace App\Http;


class TaskStatus extends Status
{
    protected $availableStatuses = [
        'unfinished' => 'nedokončené',
        'finished' => 'dokončené',
        'all' => 'všetky'
    ];


    public function __construct($status)
    {
        parent::__construct($status);
    }

}
