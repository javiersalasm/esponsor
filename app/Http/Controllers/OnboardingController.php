<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCreatorProfileRequest;
use App\Services\CreatorProfileService;
use Inertia\Inertia;

class OnboardingController extends Controller
{
    // Inyección del servicio
    public function __construct(protected CreatorProfileService $profileService) {}

    public function show() {
        $profile = auth()->user()->profile;

        // Si ya completó el onboarding, redirigir al dashboard
        if ($profile && $profile->is_onboarded) {
            return redirect()->route('dashboard');
        }

        return inertia('Onboarding', [
            'profile' => $profile
        ]);
    }

    public function update(UpdateCreatorProfileRequest $request) {
        $profile = auth()->user()->profile;

        $this->profileService->updateProfile(
            $profile,
            $request->validated(),
            $request->file('avatar')
        );

        $profile->update([
            'is_onboarded' => true
        ]);

        return redirect()->route('dashboard');
        
    }

}