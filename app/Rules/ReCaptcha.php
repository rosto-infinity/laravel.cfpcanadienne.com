<?php

declare(strict_types=1);

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
        if (app()->environment('testing')) {
            return;
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.site_key'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ])->json();

        if (!($response['success'] ?? false)) {
            $fail('La vérification anti-robot a échoué. Veuillez réessayer.');
        }
    }
}
