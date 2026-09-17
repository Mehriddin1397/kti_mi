<?php

namespace App\Policies;

use App\Models\ProjectTask;
use App\Models\User;
use App\Support\Roles;

class ProjectTaskPolicy
{
    /**
     * Can this user upload a document for this task?
     */
    public function upload(User $user, ProjectTask $task): bool
    {
        if ($user->hasRole(Roles::ADMIN)) {
            return true;
        }

        if ($task->stage->project->user_id !== $user->id) {
            return false;
        }

        // Stages must be completed in order: no uploads for a stage until
        // every earlier stage of the project is fully approved.
        return $task->stage->isUnlocked();
    }

    /**
     * Can this user approve/reject this task's latest document?
     */
    public function review(User $user, ProjectTask $task): bool
    {
        if ($user->hasRole(Roles::ADMIN)) {
            return true;
        }

        if ($task->responsible_user_id) {
            return $task->responsible_user_id === $user->id;
        }

        // No staff assigned: the applicant reviews/approves their own task.
        return $task->stage->project->user_id === $user->id;
    }
}
