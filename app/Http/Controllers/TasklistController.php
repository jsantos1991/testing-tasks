<?php

namespace App\Http\Controllers;

use App\Repositories\TasklistRepository;
use App\Tasklist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TasklistController extends Controller
{
    /**
     * @var TasklistRepository $tasklistRepository
     */
    protected $tasklistRepository;

    public function __construct(TasklistRepository $tasklistRepository)
    {
        $this->tasklistRepository = $tasklistRepository;
    }

    public function all()
    {
        return $this->tasklistRepository->all();
    }

    public function create(Request $request)
    {
        $tasklist = new Tasklist();
        $tasklist->name = $request->get('name');
        return $this->tasklistRepository->save($tasklist);
    }

    public function show($id)
    {
        return $this->tasklistRepository->find($id);
    }

    public function update(Request $request, $id)
    {
        $tasklist = $this->tasklistRepository->find($id);

        if ($tasklist) {
            $tasklist->name = $request->get('name');
            return $this->tasklistRepository->save($tasklist);
        }

        return new Response(false, 404);
    }

    public function delete($id)
    {
        $tasklist = $this->tasklistRepository->find($id);

        if ($tasklist) {
            return $this->tasklistRepository->delete($id);
        }

        return new Response(false, 404);
    }

    public function tasks(Tasklist $tasklist)
    {
        return $tasklist->tasks;
    }
}
