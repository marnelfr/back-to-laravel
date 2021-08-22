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
        if (auth()->user()->username !== 'marnel') {
//            abort(Response::HTTP_FORBIDDEN);
            return redirect('/')->with('warning', 'You are not authorized to access the admin panel');
        }

        return $next($request);
    }
}
