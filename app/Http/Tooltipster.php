<?php

namespace App\Http;

use Illuminate\Database\Eloquent\Collection;

class Tooltipster
{
    public function create(Collection $collection)
    {
        $collection->pull(0);
        $tooltipster = "ďalší:<ul>";
        foreach($collection as $entity)
        {
            $tooltipster .= "<li>{$entity->name}</li>";
        }
        $tooltipster .= "</ul>";
        return $tooltipster;
    }
}