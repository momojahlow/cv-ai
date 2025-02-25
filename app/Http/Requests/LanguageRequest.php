<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:25',
            'level' => 'required|string|min:2|max:25',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de la langue est obligatoire.',
            'name.string' => 'Le nom de la langue doit être une chaîne de caractères.',
            'name.min' => 'Le nom de la langue doit contenir au moins :min caractères.',
            'name.max' => 'Le nom de la langue ne peut pas dépasser :max caractères.',

            'level.required' => 'Le niveau de la langue est obligatoire.',
            'level.string' => 'Le niveau de la langue doit être une chaîne de caractères.',
            'level.min' => 'Le niveau de la langue doit contenir au moins :min caractères.',
            'level.max' => 'Le niveau de la langue ne peut pas dépasser :max caractères.',
        ];
    }
}
