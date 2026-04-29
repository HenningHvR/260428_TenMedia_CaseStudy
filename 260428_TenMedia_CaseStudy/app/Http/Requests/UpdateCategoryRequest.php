<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    // Prüft, ob der aktuelle User diese Anfrage ausführen darf.
    public function authorize(): bool
    {
        return true;
    }

    // Gibt die Validierungsregeln für das Anlegen einer Category zurück.
    // @return array<string, ValidationRule|array<mixed>|string>
    public function rules(): array
    {
        return [
            'ctgry_name' => ['required', 'string', 'max:255'],
            'ctgry_description' => ['nullable', 'string'],
        ];
    }
}
