<?php

namespace App\Policies;

use App\Models\CreatorLink;
use App\Models\User;

class CreatorLinkPolicy
{

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CreatorLink $creatorLink): bool
    {
        return $user->profile->id === $creatorLink->creator_profile_id;
    }

}
