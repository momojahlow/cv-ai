<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurriculumProfileRequest extends FormRequest
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
            'civility' => 'required|string',
            'title' => 'required|string|min:2|max:255',
            'date_of_birth' => 'required|date|before:today',
            'phone' => 'required|string|min:10|max:20',
            'address' => 'nullable|string|min:2|max:255',
            'nationality' => 'nullable|string|min:2|max:255',
            'study_level' => 'required|string|min:2|max:255',
            'country' => 'nullable|string|min:2|max:255',
            'family_status' => 'nullable|string|min:2|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ];
    }

    /**
     * Custom messages for validation errors in French.
     */
    public function messages(): array
    {
        return [
            'civility.required' => 'La civilité est requise.',
            'civility.string' => 'La civilité doit être une chaîne de caractères.',

            'title.required' => 'Le titre est obligatoire.',
            'title.string' => 'Le titre doit être une chaîne de caractères.',
            'title.min' => 'Le titre doit contenir au moins :min caractères.',
            'title.max' => 'Le titre ne peut pas dépasser :max caractères.',

            'date_of_birth.required' => 'La date de naissance est obligatoire.',
            'date_of_birth.date' => 'La date de naissance doit être une date valide.',
            'date_of_birth.before' => 'La date de naissance doit être avant aujourd’hui.',

            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'phone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'phone.min' => 'Le numéro de téléphone doit contenir au moins :min caractères.',
            'phone.max' => 'Le numéro de téléphone ne peut pas dépasser :max caractères.',

            'address.string' => 'L’adresse doit être une chaîne de caractères.',
            'address.min' => 'L’adresse doit contenir au moins :min caractères.',
            'address.max' => 'L’adresse ne peut pas dépasser :max caractères.',

            'nationality.string' => 'La nationalité doit être une chaîne de caractères.',
            'nationality.min' => 'La nationalité doit contenir au moins :min caractères.',
            'nationality.max' => 'La nationalité ne peut pas dépasser :max caractères.',

            'study_level.required' => 'Le niveau d’études est obligatoire.',
            'study_level.string' => 'Le niveau d’études doit être une chaîne de caractères.',
            'study_level.min' => 'Le niveau d’études doit contenir au moins :min caractères.',
            'study_level.max' => 'Le niveau d’études ne peut pas dépasser :max caractères.',

            'country.string' => 'Le pays doit être une chaîne de caractères.',
            'country.min' => 'Le pays doit contenir au moins :min caractères.',
            'country.max' => 'Le pays ne peut pas dépasser :max caractères.',

            'family_status.string' => 'Le statut familial doit être une chaîne de caractères.',
            'family_status.min' => 'Le statut familial doit contenir au moins :min caractères.',
            'family_status.max' => 'Le statut familial ne peut pas dépasser :max caractères.',

            'avatar.image' => 'L’avatar doit être une image valide.',
            'avatar.mimes' => 'L’avatar doit être au format : :values.',
            'avatar.max' => 'L’avatar ne doit pas dépasser :max Ko.',
        ];
    }
}
