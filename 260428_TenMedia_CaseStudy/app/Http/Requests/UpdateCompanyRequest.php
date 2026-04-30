<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    // Erlaubt die Nutzung dieses Requests.
    public function authorize(): bool
    {
        return true;
    }

    // Legt die Validierungsregeln für das Bearbeiten einer Company fest.
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
        ];
    }

    // Fehlermeldung für fehlerhafte URL-Eingabe
    public function messages(): array
    {
        return [
            'website.regex' => 'Die URL muss mit https://www., http://www. oder www. beginnen und eine gültige Top-Level-Domain enthalten.',
        ];
    }
}
