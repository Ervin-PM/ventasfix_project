<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clientId = $this->route('id') ?? $this->route('client') ?? null;
        return [
            'rut_empresa' => ['sometimes','string', Rule::unique('clients','rut_empresa')->ignore($clientId)],
            'rubro' => 'sometimes|string',
            'razon_social' => 'sometimes|string',
            'telefono' => 'sometimes|string',
            'direccion' => 'sometimes|string',
            'contacto_nombre' => 'sometimes|string',
            'contacto_email' => 'sometimes|email',
        ];
    }
}
