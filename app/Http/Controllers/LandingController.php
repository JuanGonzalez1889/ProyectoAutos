<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
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

        // Aquí puedes agregar lógica para guardar el email en la base de datos
        // o enviarlo a un servicio de email marketing

        return back()->with('success', '¡Gracias por suscribirte!');
    }
}
