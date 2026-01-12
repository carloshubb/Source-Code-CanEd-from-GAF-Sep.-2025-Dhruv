<?php

namespace App\Providers;

use App\Models\CookieSetting;
use App\Models\Customer;
use App\Models\FooterSetting;
use App\Models\FooterSettingMenu;
use App\Models\Language;
use App\Models\Menu;
use App\Models\Setting;
use App\Models\StaticTranslation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('*', function ($view) {
            
            $lang = null;
            $webLanguage = Session::get('webLanguage');
            if (isset($webLanguage) && !empty($webLanguage)) {
                $lang = Language::where('id', $webLanguage)->first();
            } else {
                $lang = Language::whereIsDefault(1)->first();
            }
            if(!$lang){
                $lang = Language::firstOrFail();
            }

            $footerSettings = FooterSetting::with([
                'footerSettingDetail' => function ($q) use ($lang) {
                    $q = $q->where('language_id', $lang->id);
                },'menu_1','menu_1.menuDetail','menu_2','menu_2.menuDetail','menu_3','menu_3.menuDetail'
            ])->first();
            

            $school = '';
            $loggedInUserType = null;
            if (isset(Auth::guard('customers')->user()->id)) {
                $customer = Customer::whereId(Auth::guard('customers')->user()->id)->first();
                if (isset($customer->school) && $customer->school != null) {
                    $school = $customer->school->id;
                }
                $loggedInUserType = Auth::guard('customers')->user()->user_type;
            }
            $cookieSettings = CookieSetting::with([
                'cookieSettingDetail' => function ($q) use ($lang) {
                    $q = $q->where('language_id', $lang->id);
                },
            ])->first();
            
            $suportEmail = Setting::where('type','support_email')->value('value');

            $homePageBanner = Setting::where('key','home_page_banner')->value('value');
            $networkBanner = Setting::where('key','network_banner')->value('value');
            


            $mainLogo = Setting::where('key','main_logo')->value('value');
            $staticLogo = Setting::where('key','static_logo')->value('value');
            $schoolDefaultTab = Setting::where('key','school_default_tab')->value('value');
            $defaultLang = getDefaultLanguage(1);
            $defaultLangCode = isset($defaultLang['abbreviation']) ? $defaultLang['abbreviation'] : '';
            $cookie = Cookie::get('cookies_allow');
            $data = [
                'footerSettings' => $footerSettings,
                'school'=>$school,
                'cookie_allowed' => $cookie,
                'cookieSettings'=> $cookieSettings,
                'support_email' => $suportEmail,
                'home_page_banner' => $homePageBanner,
                'network_banner' => $networkBanner,
                'default_lang' => $defaultLangCode,
                'main_logo' => $mainLogo,
                'static_logo' => $staticLogo,
                'school_default_tab' => $schoolDefaultTab,
                'logged_in_user_type' => $loggedInUserType
            ];

            $view->with('data', $data);
            
        });
    }
}
