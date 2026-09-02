<?php

namespace App\Policies;

use App\Models\ProjectImage;
use App\Models\User;

class ProjectImagePolicy
{
    public function update(User $user, ProjectImage $projectImage): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, ProjectImage $projectImage): bool
    {
        return $user->isAdmin();
    }
}
