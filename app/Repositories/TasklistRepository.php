<?php


namespace App\Repositories;


use App\Tasklist;

class TasklistRepository
{
    /**
     * @var Tasklist
     */
    private $model;

    public function __construct(Tasklist $model)
    {
        $this->model = $model;
    }

    public function all()
    {

    }

    public function find()
    {

    }

    public function delete()
    {

    }

    public function save(Tasklist $tasklist)
    {

    }
}
