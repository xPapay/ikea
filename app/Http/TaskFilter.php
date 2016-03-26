<?php
namespace App\Http;

use App\Tag;
use App\Task;
use App\User;
use Symfony\Component\HttpFoundation\Request;

class TaskFilter
{
    private $filters = [];
    private $query;
    private $selectableOptions = [];
    private $isSubmitted = false;
    private $isNextPage = false;

    public function __construct(Request $request, $initial_query)
    {
        $this->isSubmitted = $request->has('filter');
        $this->isNextPage = $request->has('page');

        $this->query = $initial_query;

        $this->filters['keyword'] = $request->get('keyword', '');
        $this->filters['deadline_from'] = $request->get('deadline_from', '');
        $this->filters['deadline_to'] = $request->get('deadline_to', '');
        $this->filters['status'] = $request->get('status', 'unfinished');
        $this->filters['orderersList'] = $request->get('orderersList', null);
        $this->filters['tagsList'] = $request->get('tagsList', null);

        $this->selectableOptions = [
            'users' => User::lists('name', 'id'),
            'tags' => Tag::lists('name', 'id'),
            'status' => [
                'unfinished' => 'nedokončené',
                'finished' => 'dokončené',
                'to_confirmation' => 'na schválenie',
                'all' => 'všetky'
            ]
        ];
    }

    public function addFilterQuery()
    {
        $this->query = $this->query->withStatus($this->filters['status']);

        if ($this->isSubmitted) {
            $this->query = $this->query->filter($this->filters);
        }


        return $this->query;
    }

    public function getSelectableOptions()
    {
        return $this->selectableOptions;
    }

    public function setSelectableOption(array $options)
    {
        $this->selectableOptions [] = $options;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function getPaginator()
    {

    }
}
