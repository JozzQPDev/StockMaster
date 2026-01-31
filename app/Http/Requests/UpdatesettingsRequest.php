<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatesettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function authorize(): bool
    {
        return true; // Asegúrate de que esté en true si no manejas permisos específicos todavía
    }

    public function rules(): array
    {
        return [
            'store_name'             => 'required|string|max:255',
            'store_ruc'              => 'required|string|max:20',
            'store_address'          => 'nullable|string|max:500',
            'store_phone'            => 'nullable|string|max:20',
            'store_email'            => 'required|email',
            'puntos_factor_ganancia' => 'required|numeric|min:0',
            'puntos_equivalencia'    => 'required|numeric|min:0',
            'puntos_minimo_canje'    => 'required|integer|min:0',
        ];
    }
}
