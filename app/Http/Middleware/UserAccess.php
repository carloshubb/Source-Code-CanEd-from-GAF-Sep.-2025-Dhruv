<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserAccess
{
    public function handle($request, Closure $next)
    {
        $current_params = \Route::current()->parameters();
        // dd($current_params['lang']);
        // if ((isset($current_params['lang']) && $current_params['lang'] != 'admin') && (isset($current_params['slug']) && $current_params['slug'] != 'admin')) {
          
            
        // }
        $defaultLang = getDefaultLanguage(1);
        if (Auth::guard('customers')->check()) {
               
            $CurrentRouteName = \Request::route()->getName();
            if (!Auth::guard('customers')->user()->is_package_amount_paid && ($CurrentRouteName == 'web.account.article.create' || $CurrentRouteName == 'web.account.event.create' || $CurrentRouteName == 'web.event.create' || $CurrentRouteName == 'web.account.school.ambassador.create' || $CurrentRouteName == 'web.account.virtual.tour.create' || $CurrentRouteName == 'web.account.open.house.create')) {
                return redirect(route('web.payment.index',['lang' => $defaultLang['abbreviation']]));
            }
            return $next($request);
        } else {
            if (url()->current() != env('APP_URL') && !isset($current_params['slug']) && !isset($current_params['lang'])) {
                return redirect()->route('front.page', ['lang' => $defaultLang['abbreviation'], 'slug' => '']);
            }
        }
       return $next($request);
    }
}
