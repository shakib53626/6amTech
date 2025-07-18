<?php

namespace App\Http\Controllers\Api;

require_once app_path('Swagger/Definitions/Task.php');

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Manager\TaskManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Task Management API",
 *     description="This is the API documentation for the Task Management System using JWT",
 *     @OA\Contact(
 *         email="you@example.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Localhost API Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     in="header"
 * )
 */
class TaskController extends Controller
{
    protected $manager;

    public function __construct(TaskManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     tags={"Tasks"},
     *     summary="Get all tasks",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="msg", type="string", example="Task list fetched successfully"),
     *             @OA\Property(
     *                 property="result",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Task")
     *             )
     *         )
     *     )
     * )
     */
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

/**
 * @OA\Post(
 *     path="/api/tasks",
 *     tags={"Tasks"},
 *     summary="Create a new task",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title", "completed", "due_date", "priority", "status", "user_id"},
 *             @OA\Property(property="title", type="string", example="New Task"),
 *             @OA\Property(property="description", type="string", example="Details here"),
 *             @OA\Property(property="completed", type="string", example="Incomplete"),
 *             @OA\Property(property="due_date", type="string", format="date", example="2025-07-25"),
 *             @OA\Property(property="priority", type="string", example="High"),
 *             @OA\Property(property="status", type="string", example="Active"),
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="category", type="string", example="Work")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Task created successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Task")
 *     )
 * )
 */
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

/**
 * @OA\Put(
 *     path="/api/tasks/{id}",
 *     tags={"Tasks"},
 *     summary="Update an existing task",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Updated Task Title"),
 *             @OA\Property(property="description", type="string", example="Updated task description"),
 *             @OA\Property(property="completed", type="string", example="Complete"),
 *             @OA\Property(property="due_date", type="string", format="date", example="2025-07-25"),
 *             @OA\Property(property="priority", type="string", example="High"),
 *             @OA\Property(property="status", type="string", example="In Progress"),
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="category", type="string", example="Work")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Task updated successfully"
 *     )
 * )
 */
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

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     tags={"Tasks"},
     *     summary="Delete a task",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task deleted successfully"
     *     )
     * )
     */
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
