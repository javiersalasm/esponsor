<?php

namespace App\Services;

use App\Models\CreatorProfile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class CreatorProfileService
{
    /**
     * Actualiza el perfil y maneja la lógica del avatar.
     */
    public function updateProfile(CreatorProfile $profile, array $data, ?UploadedFile $avatar = null): void
    {
        // Si viene una imagen nueva, procesamos el archivo
        if ($avatar) {
            // 1. Borramos la anterior si existía
            if ($profile->avatar_url) {
                Storage::disk('public')->delete($profile->avatar_url);
            }
            // 2. Guardamos la nueva y añadimos la ruta al array de datos
            $data['avatar_url'] = $avatar->store('avatars', 'public');
        }

        // Limpiamos el array para que no intente guardar el objeto del archivo en la BD
        unset($data['avatar']);

        // Actualizamos la base de datos
        $profile->update($data);
    }
}