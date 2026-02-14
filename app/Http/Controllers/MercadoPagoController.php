<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException; 



class MercadoPagoController extends Controller
{
    public function checkout(Request $request)
    {
        try {
            $accessToken = env('MERCADOPAGO_ACCESS_TOKEN');
            // Usar email real del usuario autenticado o del request
            $payerEmail = Auth::check() ? Auth::user()->email : ($request->input('email') ?? '');
            \Log::info('MP_DEBUG_ACCESS_TOKEN', ['access_token' => $accessToken]);
            \Log::info('MP_DEBUG_PAYER_EMAIL', ['payer_email' => $payerEmail]);
            // Log de todas las variables de entorno
            \Log::info('MP_DEBUG_ENV', [
                'MERCADOPAGO_ACCESS_TOKEN' => env('MERCADOPAGO_ACCESS_TOKEN'),
                'MERCADOPAGO_PUBLIC_KEY' => env('MERCADOPAGO_PUBLIC_KEY'),
                'APP_ENV' => env('APP_ENV'),
                'APP_DEBUG' => env('APP_DEBUG'),
                'APP_URL' => env('APP_URL'),
                'DB_DATABASE' => env('DB_DATABASE'),
                'DB_USERNAME' => env('DB_USERNAME'),
                'DB_HOST' => env('DB_HOST'),
            ]);
            \MercadoPago\MercadoPagoConfig::setAccessToken($accessToken);
            // Importante para Windows/Localhost
            if (method_exists(\MercadoPago\MercadoPagoConfig::class, 'setRuntimeEnvironment')) {
                \MercadoPago\MercadoPagoConfig::setRuntimeEnvironment(\MercadoPago\MercadoPagoConfig::LOCAL);
            }

            $client = new \MercadoPago\Client\Preference\PreferenceClient();
            $preference = $client->create([
                "items" => [
                    [
                        "title" => "Suscripción Auto Web Pro",
                        "quantity" => 1,
                        "unit_price" => 100.0,
                        "currency_id" => "ARS"
                    ]
                ],
                // Forzar email de test para evitar bloqueo de PolicyAgent
                "payer" => [
                    "email" => $payerEmail
                ],
                "back_urls" => [
                    "success" => route('subscriptions.success'),
                    "failure" => route('subscriptions.index'),
                ],
                "auto_return" => "approved",
            ]);

            // Redirigir siempre al sandbox_init_point para pruebas
            if (isset($preference->sandbox_init_point)) {
                return redirect($preference->sandbox_init_point);
            } else {
                // Fallback por si no existe (raro en sandbox)
                return redirect($preference->init_point);
            }
        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            // Esto te va a mostrar el JSON real del error en el log
            $apiResponse = $e->getApiResponse();
            $content = $apiResponse ? json_encode($apiResponse->getContent()) : 'No content';

            \Log::error("DETALLE REAL DE MP: " . $content);
            return "Error de Mercado Pago: " . $content;
        } catch (\Exception $e) {
            \Log::error("Error General: " . $e->getMessage());
            return "Error: " . $e->getMessage();
        }
    }
}
