<?php
namespace App\Http\Controllers;

use App\Models\CreatorProfile;
use Inertia\Inertia;

class PublicProfileController extends Controller
{
    public function show(string $slug)
    {
        $profile = CreatorProfile::where('slug', $slug)
            ->where('is_onboarded', true)
            ->with('links')
            ->withSum('supports', 'amount')
            ->firstOrFail();

        return inertia('PublicProfile', [
            'profile' => $profile,
            'is_owner' => auth()->user()?->profile->id === $profile->id,
        ]);
    }
}