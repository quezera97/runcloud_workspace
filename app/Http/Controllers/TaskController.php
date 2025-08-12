<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function store(Request $request)
    {
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
            throw $th;
        }
    }

    public function update(Request $request, Task $task)
    {
        $task->completed = $request->completed;

        if ($task->completed) {
            $task->completed_at = now();
        } else {
            $task->completed_at = null;
        }

        $task->save();

        return redirect()->back()->with('success', 'Task updated successfully.');
    }
}
