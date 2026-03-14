<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCreatorProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // middleware auth
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        // Se obtiene el ID del perfil actual del usuario autenticado para ignorarlo en la validación de unicidad
        //  del slug. Esto permite que el creador mantenga su slug actual sin que se considere un conflicto al actualizar su perfil.
        $profileId = $this->user()->profile->id;

        return [
            'public_name' => 'required|string|max:255',
            'slug'        => [
                'required', 
                'string', 
                'max:255', 
                'alpha_dash', 
                Rule::unique('creator_profiles', 'slug')->ignore($profileId)
            ],
            'bio'         => 'nullable|string|max:500',
            'avatar'      => 'nullable|image|max:2048',
            'goal_title'  => 'nullable|string|max:255',
            'goal_amount' => 'nullable|integer|min:1|max:1000',
        ];
    }
}
