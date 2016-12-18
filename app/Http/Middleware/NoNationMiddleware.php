<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class NoNationMiddleware
{
    /**
     * Check if the user has created a nation. If not, redirect them to the create nation page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::guest() && Auth::user()->hasNation)
            return $next($request);
        else
            return redirect('nation/create');
    }
}
