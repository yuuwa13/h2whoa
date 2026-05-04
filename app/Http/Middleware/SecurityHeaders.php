<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Clickjacking protection - prevents iframe embedding
        $response->header('X-Frame-Options', 'DENY');

        // MIME type sniffing protection - prevents browser from guessing content type
        $response->header('X-Content-Type-Options', 'nosniff');

        // XSS protection - enables browser's XSS filter
        $response->header('X-XSS-Protection', '1; mode=block');

        // Referrer policy - controls how much referrer information is shared
        $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions policy - restricts browser features
        $response->header('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // HSTS - enforces HTTPS connections (only set in production)
        if (app()->environment('production')) {
            $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // Basic CSP - Content Security Policy
        $response->header('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self' data:; connect-src 'self'");

        return $response;
    }
}
