<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()?->username !== 'marnel') {
//            abort(Response::HTTP_FORBIDDEN);
            return redirect('/login');
        } elseif (request()->routeIs('login')) {
            return redirect()->route('dashboard')->with('success', 'Welcome back ' . auth()->user()->username);
        }

        return $next($request);
    }
}
