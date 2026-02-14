<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $csp = "default-src 'self' glossiest-unfasciate-felisha.ngrok-free.dev http://localhost:5174 http://[::1]:5174 http://127.0.0.1:5174; "
            . "script-src 'self' 'unsafe-inline' 'unsafe-eval' glossiest-unfasciate-felisha.ngrok-free.dev http://localhost:5174 http://[::1]:5174 http://127.0.0.1:5174 https://cdn.tailwindcss.com https://unpkg.com https://www.google.com https://www.gstatic.com; "
            . "script-src-elem 'self' 'unsafe-inline' 'unsafe-eval' glossiest-unfasciate-felisha.ngrok-free.dev http://localhost:5174 http://[::1]:5174 http://127.0.0.1:5174 https://cdn.tailwindcss.com https://unpkg.com https://www.google.com https://www.gstatic.com; "
            . "style-src 'self' 'unsafe-inline' glossiest-unfasciate-felisha.ngrok-free.dev http://localhost:5174 http://[::1]:5174 http://127.0.0.1:5174 https://fonts.googleapis.com; "
            . "style-src-elem 'self' 'unsafe-inline' glossiest-unfasciate-felisha.ngrok-free.dev http://localhost:5174 http://[::1]:5174 http://127.0.0.1:5174 https://fonts.googleapis.com; "
            . "font-src 'self' https://fonts.gstatic.com; "
            . "img-src 'self' data: https: blob: glossiest-unfasciate-felisha.ngrok-free.dev; "
            . "connect-src 'self' glossiest-unfasciate-felisha.ngrok-free.dev http://localhost:5174 http://[::1]:5174 http://127.0.0.1:5174 https://api.stripe.com https://api.mercadopago.com; "
            . "frame-src 'self' https://js.stripe.com https://www.google.com;";
        $response->headers->set('Content-Security-Policy', $csp);
        return $response;
    }
}
