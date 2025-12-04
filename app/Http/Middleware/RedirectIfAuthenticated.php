<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                /** @var User $user */
                $user = Auth::guard($guard)->user();
                
                // Redirect berdasarkan role setelah login
                if ($user->isAdmin()) {
                    return redirect()->route('dashboard.admin');
                }
                
                if ($user->isGuru()) {
                    return redirect()->route('dashboard.guru');
                }
                
                // Default fallback
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
