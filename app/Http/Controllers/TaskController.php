<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Workspace;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request)
    {
        $request->validate([
            'workspace_id' => 'required|exists:workspaces,id',
            'title' => 'required|string|max:255',
            'deadline' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            Task::create([
                'workspace_id' => $request->workspace_id,
                'title' => $request->title,
                'deadline' => $request->deadline,
                'completed' => false,
                'completed_at' => null,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Task created successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create task.');
        }
    }

    public function update(Request $request, Task $task)
    {
        try {
            DB::beginTransaction();

            $task->completed = $request->completed;

            if ($task->completed) {
                $task->completed_at = now();
            } else {
                $task->completed_at = null;
            }

            $task->save();

            DB::commit();

            return redirect()->back()->with('success', 'Task updated successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to update task.');
        }
    }

    public function delete(Request $request, Task $task)
    {
        try {
            DB::beginTransaction();

            $task->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Task deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete task.');
        }
    }
}
