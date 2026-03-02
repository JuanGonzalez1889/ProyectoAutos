<?php

namespace App\Http\Controllers;

use App\Services\FormEmailNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{
    public function __construct(
        private readonly FormEmailNotificationService $formEmailNotificationService
    ) {
    }

    /**
     * Mostrar la página principal institucional
     */
    public function home()
    {
        return view('landing.home');
    }

    /**
     * Mostrar la página de precios
     */
    public function precios()
    {
        return view('landing.precios');
    }

    /**
     * Mostrar la página de próximamente
     */
    public function proximamente()
    {
        return view('landing.proximamente');
    }

    /**
     * Mostrar la página Nosotros
     */
    public function nosotros()
    {
        return view('landing.nosotros');
    }

    /**
     * Procesar el formulario de contacto/newsletter
     */
    public function submitNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $this->formEmailNotificationService->notifyNewsletterSubscription(
                $request->string('email')->toString(),
                $request->ip(),
                $request->headers->get('referer')
            );
        } catch (\Throwable $exception) {
            Log::warning('No se pudo enviar email de newsletter', [
                'email' => $request->string('email')->toString(),
                'error' => $exception->getMessage(),
            ]);
        }

        return back()->with('success', '¡Gracias por suscribirte!');
    }
}
