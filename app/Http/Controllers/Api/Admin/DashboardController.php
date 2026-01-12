<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Traits\StatusResponser;

class DashboardController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $defaultLang = getDefaultLanguage();

        $data['business_profiles'] = Customer::where('user_type', 'business')->where('deactive_account', '0')->count();

        $data['featured_schools'] = Customer::where('user_type', 'school')->where('deactive_account', '0')->where('is_package_amount_paid', 1)->where('package_expiry_date', '>=', date('Y-m-d'))->whereHas('registrationPackage', function ($q) {
            $q->where('registration_packages.package_type', 'featured');
        })->count();

        $data['schools'] = Customer::where('user_type', 'school')->where('deactive_account', '0')->count();
        $data['users'] = Customer::where('deactive_account', '0')->where('user_type', 'student')->count();

        $data['featured_schools_list'] = Customer::where('user_type', 'school')->where('is_package_amount_paid', 1)->where('package_expiry_date', '>=', date('Y-m-d'))->whereHas('registrationPackage', function ($q) {
                $q->where('registration_packages.package_type', 'featured');
            })
            ->whereHas('school')
            ->with([
                'school.schoolDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_code', $defaultLang->abbreviation);
                },
            ])
            ->latest()->limit(10)->get();


        $data['business_profiles_list'] = Customer::where('user_type', 'business')
            ->whereHas('registrationPackage', function ($q) {
                $q->where('registration_packages.package_type', 'featured');
            })
            ->whereHas('business')
            ->with([
                'business.businessDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                },
            ])
            ->latest()->limit(10)->get();

        return $this->successResponse($data, 'Data get successfully.');
    }
}
