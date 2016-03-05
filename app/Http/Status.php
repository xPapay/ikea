<?php
namespace App\Http;


abstract class Status
{
    protected $selectedStatus;

    protected $availableStatuses = [];

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

    public function getStatusMenu($path)
    {
        $menu = array();
        array_walk($this->unselectedStatuses, function($value, $key) use ($path, &$menu) {
            $menu[$path . $key] = $value;
        });
        return $menu;
    }

    protected function createListOfUnselected()
    {
        return array_filter($this->availableStatuses, function($status) {
            return !in_array($status, $this->selectedStatus);
        });
    }

}
