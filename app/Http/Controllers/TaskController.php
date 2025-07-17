<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Manager\TaskManagerInterface;
use Illuminate\Http\Request;

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

            return inertia("Adminend/Tasks", [
                "tasks"   => $data['tasks'],
                'users'   => $data['users'],
                'filters' => $request->only(['search', 'paginate_size', 'user_id', 'page' => request('page')]),
            ]);

        } catch (\Exception $exception) {
            return handleException('Task fetch failed', $exception);
        }
    }

    public function store(TaskRequest $request)
    {
        try {
            $task = $this->manager->store($request);

            return redirect()->back()->with('success', 'Task created successfully');
        } catch (\Exception $exception) {
            return handleException('Task creation failed', $exception);
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

    public function destroy($id)
    {
        try {
            $task = $this->manager->destroy($id);

            return redirect()->back()->with('success', 'Task deleted successfully');
        } catch (\Exception $exception) {
            return handleException('Task deletion failed', $exception);
        }
    }
}
