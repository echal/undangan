<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApprovalMiddleware
{
    /**
     * Hanya user dengan status 'approved' yang boleh akses.
     * Admin selalu diloloskan (tidak perlu approval).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Admin tidak terkena restriction approval
        if ($user->isAdmin()) {
            return $next($request);
        }

        if ($user->isRejected()) {
            return redirect()->route('account.rejected');
        }

        if ($user->isPending()) {
            return redirect()->route('account.pending');
        }

        return $next($request);
    }
}
