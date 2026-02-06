<?php

namespace App\Http\Controllers;

use App\Services\StripeService;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function __construct(
        private StripeService $stripeService,
        private MercadoPagoService $mercadoPagoService
    ) {}

    /**
     * Handle Stripe webhook
     */
    public function stripe(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');

        try {
            if (!config('services.stripe.webhook_secret')) {
                Log::warning('Stripe webhook secret not configured');
                return response()->json(['error' => 'Webhook secret not configured'], 500);
            }

            if (!$signature) {
                Log::warning('Stripe webhook missing signature header');
                return response()->json(['error' => 'Missing signature'], 401);
            }

            $this->stripeService->handleWebhook($payload, $signature);
            
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Stripe webhook failed', ['error' => $e->getMessage()]);
            
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Handle MercadoPago webhook
     */
    public function mercadopago(Request $request)
    {
        try {
            if (!$this->mercadoPagoService->verifyWebhookSignature($request)) {
                Log::warning('MercadoPago webhook invalid signature');
                return response()->json(['error' => 'Invalid signature'], 401);
            }

            $this->mercadoPagoService->handleWebhook($request->all());
            
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('MercadoPago webhook failed', ['error' => $e->getMessage()]);
            
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
