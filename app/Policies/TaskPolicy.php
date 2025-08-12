<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;
use App\Models\Workspace;

// php artisan make:policy TaskPolicy --model=Task

class TaskPolicy
{
    public function update(User $user, Task $task)
    {
        return $task->created_by === $user->id;
    }

    public function delete(User $user, Task $task)
    {
        return $task->created_by === $user->id;
    }
}
