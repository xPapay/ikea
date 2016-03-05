<?php
namespace App\Http;


class IssueStatus extends Status
{
    protected $availableStatuses = [
        'unfinished' => 'nevyriešené',
        'finished' => 'vyriešené',
        'followup_wait' =>'čakajúce na followup',
        'all' => 'všetky'
    ];


    public function __construct($status)
    {
        parent::__construct($status);
    }

}
