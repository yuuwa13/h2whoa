<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdminMfa
{
    /**
     * If the admin authenticated via the guard but MFA is somehow still pending,
     * redirect them back to the MFA page. Defense-in-depth layer.
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->get('mfa_pending')) {
            return redirect()->route('admin.mfa');
        }

        return $next($request);
    }
}
