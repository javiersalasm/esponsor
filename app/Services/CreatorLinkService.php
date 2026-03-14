<?php

namespace App\Services;

use App\Models\CreatorLink;
use App\Models\User;

class CreatorLinkService
{
    public function createLinkForUser(User $user, array $data): CreatorLink
    {
        return $user->profile->links()->create($data);
    }

    public function deleteLink(CreatorLink $link): void
    {
        $link->delete();
    }
}