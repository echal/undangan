<?php

namespace App\Http\Middleware;

use App\Models\SystemSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Path prefixes (relatif, tanpa leading slash) yang tidak kena maintenance redirect.
     * Mencakup: halaman maintenance itu sendiri, status pages, semua auth route, admin panel,
     * account status pages, dan Laravel health check.
     */
    private const EXCLUDED_PREFIXES = [
        'maintenance',
        'status',
        'login',
        'logout',
        'register',
        'forgot-password',
        'reset-password',
        'password',
        'verify-email',
        'email/verification-notification',
        'confirm-password',
        'admin',
        'account',
        'up',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // $request->path() mengembalikan path relatif tanpa leading slash
        // misal: "invitation/my-wedding" bukan "/undangan/public/invitation/my-wedding"
        $path = ltrim($request->path(), '/');

        // Bypass route-route yang dikecualikan
        foreach (self::EXCLUDED_PREFIXES as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix . '/')) {
                return $next($request);
            }
        }

        // Admin bypass: Auth::user() bisa null di public route, guard dulu
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        // Cek maintenance mode via SystemSetting
        if (SystemSetting::current()->isInMaintenance()) {
            return redirect()->route('maintenance');
        }

        return $next($request);
    }
}
