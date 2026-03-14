<?php
namespace App\Http\Controllers;

use App\Http\Requests\UpdateCreatorProfileRequest;
use App\Services\CreatorProfileService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CreatorProfileController extends Controller
{
    // Inyectamos el servicio mágicamente gracias a Laravel
    public function __construct(protected CreatorProfileService $profileService) {}

    public function edit() 
    {
        $profile = auth()->user()->profile()->with(['links', 'supports'])->first();
        
        return Inertia::render('Dashboard/Dashboard', compact('profile'));
    }

    public function update(UpdateCreatorProfileRequest $request)
    {
        $profile = auth()->user()->profile;

        $this->profileService->updateProfile(
            $profile, 
            $request->validated(), 
            $request->file('avatar')
        );

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}