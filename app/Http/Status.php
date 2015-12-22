<?php
namespace App\Http;


class Status
{
    protected $selectedStatus;

    protected $availableStatuses = [
        'unfinished' => 'nedokončené',
        'finished' => 'dokončené',
        'all' => 'všetky'
    ];

    protected $unselectedStatuses;

    public function __construct($status)
    {
        $this->selectedStatus[$status] = $this->availableStatuses[$status];
        $this->unselectedStatuses = $this->createListOfUnselected();
    }


    public function getSelectedKey()
    {
        return array_keys($this->selectedStatus)[0];
    }

    public function getSelectedValue()
    {
        return array_values($this->selectedStatus)[0];
    }

    public function getStatusMenu()
    {
        return $this->unselectedStatuses;
    }

    private function createListOfUnselected()
    {
        return array_filter($this->availableStatuses, function($status) {
            return !in_array($status, $this->selectedStatus);
        });
    }

}
