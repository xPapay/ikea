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
    private $request;

    public function __construct(Request $request, $initial_query)
    {
        $this->request = $request;
        $this->isSubmitted = $request->has('filter');
        $this->isNextPage = $request->has('page');

        $this->query = $initial_query;

        $request->session()->put('filters.keyword', $request->get('keyword', $request->session()->get('filters.keyword', '')));
        $request->session()->put('filters.deadline_from', $request->get('deadline_from', $request->session()->get('filters.deadline_from', '')));
        $request->session()->put('filters.deadline_to', $request->get('deadline_to', $request->session()->get('filters.deadline_to', '')));
        $request->session()->put('filters.status', $request->get('status', $request->session()->get('filters.status', 'unfinished')));
        $this->setOrdererList();

        $this->setTagsList();

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

    private function setOrdererList()
    {
        if ($this->isSubmitted) {
            $this->request->session()->put('filters.orderersList', $this->request->get('orderersList', null));
        }
        $this->request->session()->put('filters.orderersList', $this->request->session()->get('filters.orderersList', null));
    }

    private function setTagsList()
    {
        if ($this->isSubmitted) {
            $this->request->session()->put('filters.tagsList', $this->request->get('tagsList', null));
        }
        $this->request->session()->put('filters.tagsList', $this->request->session()->get('filters.tagsList', null));
    }

    public function addFilterQuery()
    {
        //dd($this->request->session()->get('filters'));
        $this->query = $this->query->withStatus($this->request->session()->get('filters.status'));
        $this->query = $this->query->filter($this->request->session()->get('filters'));


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
        return $this->request->session()->get('filters');
    }

    public function getPaginator()
    {

    }
}
