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

        // CSP — Content Security Policy (IMPROVED: removed unsafe-eval, documented unsafe-inline for future nonce migration)
        // FUTURE: Implement nonce-based CSP by:
        // 1. Add nonce="{{ csp_nonce() }}" to all inline <script>/<style> tags in Blade templates
        // 2. Update SecurityHeaders to generate and validate CSP nonce
        // 3. Replace unsafe-inline with: 'nonce-{{ csp_nonce() }}'
        // Current approach maintains security while awaiting template refactoring
        $response->header('Content-Security-Policy',
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://code.jquery.com https://maps.googleapis.com; " .
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; " .
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
