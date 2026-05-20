<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'phone'    => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex'    => 'El teléfono debe tener exactamente 10 dígitos numéricos.',
            'phone.required' => 'El número de teléfono es obligatorio.',
        ];
    }
}
