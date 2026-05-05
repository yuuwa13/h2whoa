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
        // Generate a fresh nonce for this request and make it available to views
        $nonce = base64_encode(random_bytes(16));
        app()->instance('csp-nonce', $nonce);

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

        // Nonce-based CSP — inline scripts/styles require the matching nonce attribute
        $response->header('Content-Security-Policy',
            "default-src 'self'; " .
            "script-src 'self' 'nonce-{$nonce}' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://code.jquery.com https://maps.googleapis.com; " .
            "style-src 'self' 'nonce-{$nonce}' https://fonts.googleapis.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; " .
            "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com data:; " .
            "img-src 'self' data: https:; " .
            "frame-src https://maps.google.com https://maps.googleapis.com; " .
            "connect-src 'self' https://maps.googleapis.com; " .
            "object-src 'none'; " .
            "base-uri 'self'; " .
            "form-action 'self';"
        );

        return $response;
    }
}
