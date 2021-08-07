<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Athlete;

class AthleteAssociatedWithOffice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    public function handle($request, Closure $next)
    {
        $athleteId = $request->route()->parameter('id');

        abort_if(Athlete::findOrFail($athleteId)->office_id != $request->user()->office_id,404);

        return $next($request);
    }
}
