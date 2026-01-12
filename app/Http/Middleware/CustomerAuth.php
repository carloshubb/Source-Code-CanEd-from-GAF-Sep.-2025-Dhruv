<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CustomerAuth
{
    public function handle($request, Closure $next)
    {
        // dd([
        //     'guard_check' => Auth::guard('customers')->check(),
        //     'session_id' => session()->getId(),
        //     'user' => Auth::guard('customers')->user(),
        // ]);

        if (!Auth::guard('customers')->check()) {
            return redirect()->route('front.page', ['lang' => getDefaultLanguage(1)['abbreviation'], 'slug' => '']);
        }
        return $next($request);
    }
}
