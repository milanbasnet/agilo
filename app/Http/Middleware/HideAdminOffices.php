<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AdminOffice;
class HideAdminOffices
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (AdminOffice::all()->contains('office_id', $request->offices)) {
            abort(404);
        }

        return $next($request);
    }
}
