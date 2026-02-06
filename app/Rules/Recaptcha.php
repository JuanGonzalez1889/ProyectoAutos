<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secretKey = config('services.recaptcha.secret_key');
        
        if (!$secretKey) {
            // En desarrollo sin reCAPTCHA configurado, permitir
            if (app()->environment('local')) {
                return;
            }
            $fail('reCAPTCHA no está configurado correctamente.');
            return;
        }

        if (empty($value)) {
            $fail('Por favor, completa la verificación reCAPTCHA.');
            return;
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        $result = $response->json();

        if (!isset($result['success']) || !$result['success']) {
            $fail('La verificación reCAPTCHA falló. Por favor, inténtalo de nuevo.');
            return;
        }

        // Verificar threshold de score (para reCAPTCHA v3)
        if (isset($result['score']) && $result['score'] < 0.5) {
            $fail('La verificación de seguridad no pasó el umbral requerido.');
            return;
        }
    }
}
