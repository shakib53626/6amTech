<?php

namespace App\Manager\Eloquent;


use App\Models\Task;
use App\Models\User;
use App\Manager\TaskManagerInterface;

class TaskManager implements TaskManagerInterface
{
    public function index($request)
    {
        $paginateSize = $request->input('paginate_size') ?? 50;

        $users = User::all();
        $query = Task::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('status', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('category', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        $query->orderBy('created_at', 'desc')->with('user')->paginate($paginateSize);

        return [
            'tasks' => $query,
            'users' => $users,
        ];
    }

    public function store($request){

        $task = new Task();
        $task->title       = $request->title;
        $task->description = $request->description;
        $task->completed   = $request->completed;
        $task->due_date    = $request->due_date;
        $task->priority    = $request->priority;
        $task->status      = $request->status;
        $task->category    = $request->category;
        $task->user_id     = $request->user_id;
        $task->save();

        return $task;

    }

    public function update($id, $request)
    {
        $task = Task::findOrFail($id);
        $task->title       = $request->title;
        $task->description = $request->description;
        $task->completed   = $request->completed;
        $task->due_date    = $request->due_date;
        $task->priority    = $request->priority;
        $task->status      = $request->status;
        $task->category    = $request->category;
        $task->user_id     = $request->user_id;
        $task->save();

        return $task;

    }

    public function destroy($id){

        $task = Task::findOrFail( $id);

        $task->delete();

        return $task;
    }

}
