<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_send_support_to_a_creator(): void
    {
        // 1. ARRANGE
        $user = User::factory()->create();
        $profile = $user->profile;

        // 2. ACT
        $response = $this->post(route('creator.support', $profile->slug), [
            'supporter_name' => 'Fan numero uno',
            'message' => 'Buenos links',
            'amount' => 50,
        ]);

        // 3. ASSERT
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success', '¡Gracias por tu apoyo a este creador!');

        $this->assertDatabaseHas('supports', [
            'creator_profile_id' => $profile->id,
            'supporter_name' => 'Fan numero uno',
            'amount' => 50,
        ]);
    }

    public function test_support_amount_cannot_exceed_maximum_limit(): void
    {
        // 1. ARRANGE
        $user = User::factory()->create();
        $profile = $user->profile;

        // 2. ACT (Intentamos enviar 500, el límite es 100)
        $response = $this->post(route('creator.support', $profile->slug), [
            'supporter_name' => 'Usuario troll',
            'message' => 'god',
            'amount' => 500,
        ]);

        // 3. ASSERT
        $response->assertSessionHasErrors('amount');

        $this->assertDatabaseMissing('supports', [
            'supporter_name' => 'Usuario troll',
        ]);
    }
}