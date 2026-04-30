<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobPostingRequest extends FormRequest
{
    // Erlaubt die Nutzung dieses Requests.
    public function authorize(): bool
    {
        return true;
    }

    // Legt die Validierungsregeln für das Bearbeiten eines JobPostings fest.
    public function rules(): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'jp_description' => ['nullable', 'string'],
            'jp_location' => ['nullable', 'string', 'max:255'],
            'experience_level' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['nullable', 'string', 'max:255'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
