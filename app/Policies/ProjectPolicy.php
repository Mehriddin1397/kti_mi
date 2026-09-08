<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use App\Support\Roles;

class ProjectPolicy
{
    public function view(User $user, Project $project): bool
    {
        if ($user->hasRole(Roles::ADMIN)) {
            return true;
        }

        if ($project->user_id === $user->id) {
            return true;
        }

        if ($user->hasRole(Roles::MASUL_XODIM)) {
            return $project->tasks()->where('responsible_user_id', $user->id)->exists();
        }

        return false;
    }
}
