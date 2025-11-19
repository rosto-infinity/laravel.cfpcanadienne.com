<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartenaireRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $rules = [
            'nom' => ['required', 'string', 'max:255'],
            'siteweb' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];

        // Pour la création, le logo est requis
        if ($this->isMethod('post')) {
            $rules['logo'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'];
        } else {
            // Pour la mise à jour, le logo est optionnel
            $rules['logo'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom du partenaire est obligatoire.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'logo.required' => 'Le logo est obligatoire.',
            'logo.image' => 'Le fichier doit être une image.',
            'logo.mimes' => 'Le logo doit être au format : jpeg, png, jpg, gif, svg ou webp.',
            'logo.max' => 'Le logo ne peut pas dépasser 2 Mo.',
            'siteweb.url' => 'L\'URL du site web n\'est pas valide.',
            'siteweb.max' => 'L\'URL ne peut pas dépasser 255 caractères.',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères.',
        ];
    }
}