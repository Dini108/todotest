<?php

namespace App\Http\Controllers;

use App\Task;
use App\Http\Requests\ToggleTaskCompleteRequest;
use http\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Http\Requests\SaveTaskRequest;
use App\Http\Requests\DeleteTaskRequest;

class TodoController extends Controller
{
    public function store(SaveTaskRequest $request): TaskResource
    {
        $todo = new Task();
        $todo->description = $request->description;
        $todo->completed = 0;
        $todo->save();

        return new TaskResource($todo);
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $todos = Task::all()->sortBy('desc');

        return TaskResource::collection($todos);
    }

    /**
     * @param Task $todo
     * @param DeleteTaskRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     * @throws \Exception
     */
    public function destroy(Task $todo, DeleteTaskRequest $request)
    {
        try {
            if ($todo->delete()) {
                $todos = Task::all()->sortBy('desc');

                return TaskResource::collection($todos);
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 401);
        }
    }

    /**
     * @param ToggleTaskCompleteRequest $request
     * @param Task $todo
     * @return TaskResource
     */
    public function update(ToggleTaskCompleteRequest $request, Task $todo): TaskResource
    {
        // We need to toggle the completed_at
        $todo->description = $request->description;
        $todo->save();

        return new TaskResource($todo);
    }

    /**
     * @param ToggleTaskCompleteRequest $request
     * @param Task $todo
     * @return TaskResource
     */
    public function setTaskCompletion(ToggleTaskCompleteRequest $request, Task $todo): TaskResource
    {
        // We need to toggle the completed_at
        $todo->completed = $todo->completed ? false : true;
        $todo->save();

        return new TaskResource($todo);
    }

    /**
     * @param $value
     * @return AnonymousResourceCollection
     */
    public function sortTasks($value): AnonymousResourceCollection
    {
        $todos = Task::all()->where('completed', '=', $value);

        return TaskResource::collection($todos);
    }

}
