<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class TurnstileRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secretKey = config('services.turnstile.secret');

        // Si la clave secreta está vacía, no realizamos validación (Fail Open para desarrollo local/deshabilitado)
        if (empty($secretKey)) {
            return;
        }

        try {
            $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret'   => $secretKey,
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);

            if (!$response->successful() || !$response->json('success')) {
                $fail('La verificación de seguridad ha fallado. Por favor, inténtalo de nuevo.');
            }
        } catch (\Exception $e) {
            // Fail Open: Si hay un error de comunicación con Cloudflare (caída del servicio o red),
            // permitimos el flujo de la app para no bloquear el buscador a los usuarios legítimos.
        }
    }
}
