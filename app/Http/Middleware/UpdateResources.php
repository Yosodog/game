<?php

namespace App\Http\Middleware;

use App\Helpers\UpdateResources as UpdateResourcesHelper;
use App\Models\Nation\Building;
use App\Models\Nation\Cities;
use App\Models\Properties;
use Auth;
use Closure;

class UpdateResources
{
    public function handle($request, Closure $next)
    {
        // Check if the user has a nation or not. If not, just go to the next thing
        if (Auth::guest() || ! Auth::user()->hasNation)
            return $next($request);

        $update = new UpdateResourcesHelper();
        $update->handle(Auth::user());
        $request = $update->updateSession($request);

        return $next($request);
    }
}
