<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id') ?? $this->route('user') ?? null;
        return [
            'rut' => ['sometimes','string', Rule::unique('users','rut')->ignore($userId)],
            'nombre' => 'sometimes|string',
            'apellido' => 'sometimes|string',
            'email' => ['sometimes','email', Rule::unique('users','email')->ignore($userId)],
            'password' => 'nullable|min:6',
        ];
    }
}
