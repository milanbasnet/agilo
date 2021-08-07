<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use LaravelLocalization;


class InRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $inRole = false;
        if (!is_null($request->user())) {
            LaravelLocalization ::setLocale($request->user()->language_code);
            
            $inRole = in_array($request->user()->role->name, $roles);
        }

        if (!$inRole) {
            abort(404);
        }
        return $next($request);
    }
}
