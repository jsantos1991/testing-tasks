<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use App\Tasklist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * @var TaskRepository $taskRepository
     */
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function all(Tasklist $tasklist)
    {
        return $this->taskRepository->whereTasklistId($tasklist->id);
    }

    public function create(Request $request)
    {
        $tasklist = new Tasklist();
        $tasklist->name = $request->get('name');
        return $this->taskRepository->save($tasklist);
    }

    public function show($id)
    {
        return $this->taskRepository->find($id);
    }

    public function update(Request $request, $id)
    {
        $tasklist = $this->taskRepository->find($id);

        if ($tasklist) {
            $tasklist->name = $request->get('name');
            return $this->taskRepository->save($tasklist);
        }

        return new Response(false, 404);
    }

    public function delete($id)
    {
        $tasklist = $this->taskRepository->find($id);

        if ($tasklist) {
            return $this->taskRepository->delete($id);
        }

        return new Response(false, 404);
    }
}
