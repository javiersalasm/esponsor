<?php
namespace App\Http\Controllers;

use App\Models\CreatorLink;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCreatorLinkRequest;
use App\Services\CreatorLinkService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreatorLinkController extends Controller
{
    use AuthorizesRequests; // Necesario para usar $this->authorize()

    public function __construct(protected CreatorLinkService $linkService) {}

    public function store(StoreCreatorLinkRequest $request)
    {
        // 1. Los datos ya vienen validados gracias a StoreCreatorLinkRequest
        $validatedData = $request->validated();

        // 2. Delegamos la creación al servicio
        $this->linkService->createLinkForUser(auth()->user(), $validatedData);

        return back()->with('success', 'Link agregado a Soportify.');
    }

    public function update(Request $request, CreatorLink $link)
    {
        // Usamos la misma policy de borrar para asegurar que es el dueño
        $this->authorize('delete', $link);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:255',
        ]);

        $link->update($validated);

        return back()->with('success', 'Link actualizado correctamente.');
    }

    public function destroy(CreatorLink $link)
    {
        // 1. Validamos permisos usando la Policy
        $this->authorize('delete', $link); 

        // 2. Delegamos la eliminación al servicio
        $this->linkService->deleteLink($link);

        return back()->with('success', 'Link eliminado.');
    }
}