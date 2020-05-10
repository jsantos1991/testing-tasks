<?php


namespace App\Repositories;


use App\Task;
use Illuminate\Support\Collection;

class TaskRepository
{
    /**
     * @var Task
     */
    private $model;

    public function __construct(Task $model)
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
        $model = $this->find($id);

        return $model->delete($id);
    }

    public function save(Task $task): bool
    {
        return $task->save();
    }

    public function whereTasklistId($id)
    {
        return $this->model
            ->where('tasklist_id', $id)
            ->get();
    }
}
