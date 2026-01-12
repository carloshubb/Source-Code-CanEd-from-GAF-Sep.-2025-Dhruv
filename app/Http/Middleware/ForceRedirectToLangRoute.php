<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ForceRedirectToLangRoute
{
    public function handle($request, Closure $next)
    {
        dd(1);
        
        return $next($request);
    }
}
