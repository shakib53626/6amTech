<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Manager\TaskManagerInterface;

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

            return inertia("Frontend/Tasks", [
                "tasks"   => $data['tasks'],
                'users'   => $data['users'],
                'filters' => $request->only(['search', 'paginate_size', 'user_id', 'page' => request('page')]),
            ]);

        } catch (\Exception $exception) {
            return handleException('Task fetch failed', $exception);
        }
    }

    public function update(TaskRequest $request, $id)
    {
        try {
            $task = $this->manager->update($id, $request);

            return redirect()->back()->with('success', 'Task updated successfully');
        } catch (\Exception $exception) {
            return handleException('Task update failed', $exception);
        }
    }


}
