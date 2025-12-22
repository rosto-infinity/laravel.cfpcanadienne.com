<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http; // Import crucial

class ReCaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 1. Utilisez Http (minuscule après le H)
        // 2. Utilisez post() avec asForm() pour respecter le protocole Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.site_key'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ])->json();

        // Vérification sécurisée du JSON
        // if (!$response->json('success')) {
        //     $fail('La vérification anti-robot a échoué. Veuillez réessayer.');
        // }
    }
}
