<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCompanyRequest extends FormRequest
{
    // Erlaubt die Nutzung dieses Requests.
    public function authorize(): bool
    {
        return true;
    }

    // Legt die Validierungsregeln für das Erstellen einer Firma fest.
    public function rules(): array
    {
        return [
            'cmpny_name' => ['required', 'string', 'max:255'],
            'cmpny_description' => ['nullable', 'string'],
            'website' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^(https?:\/\/www\.|www\.)[a-z0-9-]+(\.[a-z0-9-]+)+(\/.*)?$/i',
            ],
            'cmpny_location' => ['nullable', 'string', 'max:255'],
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'provider');
                }),
            ],
        ];
    }

    // Legt eigene Fehlermeldungen für die Validierung fest.
    public function messages(): array
    {
        return [
            'website.regex' => 'Die URL muss mit https://www., http://www. oder www. beginnen und eine gültige Top-Level-Domain enthalten.',
            'user_id.required' => 'Bitte wähle einen Provider für diese Firma aus.',
            'user_id.exists' => 'Der ausgewählte User ist kein gültiger Provider.',
        ];
    }
}
