<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workspace;

// php artisan make:policy WorkspacePolicy --model=Workspace

class WorkspacePolicy
{
    public function delete(User $user, Workspace $workspace)
    {
        return $workspace->created_by === $user->id;
    }
}
