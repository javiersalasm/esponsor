<?php

namespace App\Services;

use App\Models\CreatorProfile;
use App\Models\Support;

class SupportService
{
    /**
     * Procesa un nuevo apoyo económico para un creador.
     */
    public function processSupport(CreatorProfile $profile, array $data): Support
    {
        // NOTA PARA EL FUTURO:
        // Aquí es donde Soportify se comunicaría con la API de MercadoPago o Stripe.
        // También aquí calcularías la comisión (ej: $data['amount'] * 0.05).

        // Por ahora, solo registramos el apoyo en la base de datos
        return $profile->supports()->create($data);
    }
}