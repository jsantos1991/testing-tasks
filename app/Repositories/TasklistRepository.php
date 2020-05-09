<?php


namespace App\Repositories;


use App\Tasklist;
use Illuminate\Support\Collection;

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

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function delete(int $id)
    {
        return $this->model->delete($id);
    }

    public function save(Tasklist $tasklist): bool
    {
        return $tasklist->save();
    }
}
