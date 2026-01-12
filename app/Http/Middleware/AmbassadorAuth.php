<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AmbassadorAuth
{

    public function handle($request, Closure $next)
    {
        // dd(Auth::guard('school_ambassadors')->user());

        if (Auth::guard('school_ambassadors')->check()) {
            return $next($request);
        }else{
            return redirect()->route('front.page',['lang' => getDefaultLanguage(1)['abbreviation'],'slug'=>'']);
        }
        return $next($request);
    }
}
