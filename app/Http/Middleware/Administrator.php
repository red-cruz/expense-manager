<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class Administrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::with('role')->find(Auth::id());
        if ($user->role->name !== "Admin") {
            $user = User::find(Auth::id())->data();
            return Inertia::render('Dashboard', [
              'user' => $user,
            ]);
        }
        return $next($request);
    }
}
