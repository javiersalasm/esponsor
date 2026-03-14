<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupportRequest extends FormRequest
{
    public function authorize()
    {
        // Retorna true porque cualquiera (incluso sin login) puede enviar apoyo
        return true; 
    }

    public function rules()
    {
        return [
            'supporter_name' => 'required|string|max:255',
            'message'        => 'required|string',
            'amount'         => 'required|numeric|min:1|max:100', 
        ];
    }
}