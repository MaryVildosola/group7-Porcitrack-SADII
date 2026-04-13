<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user() || $request->user()->role !== $role) {
            
            // Polite redirection fallback based on actual role
            if ($request->user()) {
                if ($request->user()->role === 'admin') {
                    return redirect('/admin/dashboard');
                } elseif ($request->user()->role === 'farm_worker') {
                    return redirect('/worker/dashboard');
                }
            }
            
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
