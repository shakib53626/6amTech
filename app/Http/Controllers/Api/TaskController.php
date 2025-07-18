<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Manager\TaskManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    protected $manager;

    public function __construct(TaskManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->manager->index($request);

            $data = new TaskCollection($data['tasks']);

            return Helper::sendResponse($data, "Task data fetch successfully");

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return Helper::sendError('Something went wrong');
        }
    }

    public function store(TaskRequest $request)
    {
        try {
            $task = $this->manager->store($request);

            $task = new TaskResource($task);
            return Helper::sendResponse($task, 'Task Created Successfully');

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return Helper::sendError('Something went wrong');
        }
    }

    public function update(TaskRequest $request, $id)
    {
        try {
            $task = $this->manager->update($id, $request);

            $task = new TaskResource($task);

            return Helper::sendResponse($task, 'Task Updated Successfully');

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return Helper::sendError('Something went wrong');
        }
    }

    public function destroy($id)
    {
        try {
            $task = $this->manager->destroy($id);

            $task = new TaskResource($task);

            return Helper::sendResponse($task, 'Task Deleted Successfully');

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return Helper::sendError('Something went wrong');
        }
    }
}
