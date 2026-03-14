<?php
namespace App\Http\Controllers;

use App\Models\CreatorProfile;
use App\Http\Requests\StoreSupportRequest;
use App\Services\SupportService;

class SupportController extends Controller
{
    // Inyectamos el servicio
    public function __construct(protected SupportService $supportService) {}

    public function store(StoreSupportRequest $request, string $slug)
    {
        // Buscamos el perfil del creador
        $profile = CreatorProfile::where('slug', $slug)->firstOrFail();

        // El servicio se encarga de toda la lógica de crear el apoyo.
        $this->supportService->processSupport($profile, $request->validated());

        return back()->with('success', '¡Gracias por tu apoyo a este creador!');
    }
}