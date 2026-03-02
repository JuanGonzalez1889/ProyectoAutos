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

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
            'notify_emails' => 'nullable|string|max:1000',
        ]);

        $additionalRecipients = collect(explode(',', $validated['notify_emails'] ?? ''))
            ->map(fn ($email) => trim($email))
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->values()
            ->all();

        try {
            $this->formEmailNotificationService->notifyInstitutionalContactWithRecipients(
                $validated['name'],
                $validated['email'],
                $validated['message'],
                $request->ip(),
                $request->headers->get('referer'),
                $additionalRecipients
            );
        } catch (\Throwable $exception) {
            Log::warning('No se pudo enviar email de contacto institucional', [
                'email' => $validated['email'],
                'error' => $exception->getMessage(),
            ]);
        }

        return back()->with('success', '¡Gracias! Tu mensaje fue enviado correctamente.');
    }
}
