<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogWebhookRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (str_contains($request->path(), 'mercadopago/webhook')) {
            Log::info('MP_DEBUG_MIDDLEWARE_WEBHOOK', [
                'method' => $request->method(),
                'path' => $request->path(),
                'headers' => $request->headers->all(),
                'body' => $request->all(),
                'raw' => $request->getContent(),
                'ip' => $request->ip(),
            ]);
        }
        return $next($request);
    }
}
