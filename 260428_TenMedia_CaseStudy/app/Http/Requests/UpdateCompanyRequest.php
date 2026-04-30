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
            'website' => ['nullable', 'string', 'max:255'],
            'cmpny_location' => ['nullable', 'string', 'max:255'],
        ];
    }
}
