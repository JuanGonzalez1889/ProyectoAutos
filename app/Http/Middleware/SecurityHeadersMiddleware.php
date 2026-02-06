<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // HTTP Strict Transport Security (HSTS)
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        
        // Content Security Policy
        $response->headers->set('Content-Security-Policy', 
            "default-src 'self'; "
            . "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://unpkg.com https://www.google.com https://www.gstatic.com; "
            . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
            . "font-src 'self' https://fonts.gstatic.com; "
            . "img-src 'self' data: https: blob:; "
            . "connect-src 'self' https://api.stripe.com https://api.mercadopago.com; "
            . "frame-src 'self' https://js.stripe.com https://www.google.com;"
        );
        
        // Prevenir clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        
        // Prevenir XSS
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Prevenir MIME sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Permissions Policy (antes Feature-Policy)
        $response->headers->set('Permissions-Policy', 
            'geolocation=(), microphone=(), camera=(), payment=(self "https://js.stripe.com" "https://sdk.mercadopago.com")'
        );

        return $response;
    }
}
