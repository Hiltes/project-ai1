<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureTotpIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Jeśli TOTP aktywne, ale niepotwierdzone w sesji
        if ($user && $user->totp_enabled && !$request->session()->get('totp_verified')) {
            return redirect()->route('totp.confirm');
        }

        return $next($request);
    }
}
