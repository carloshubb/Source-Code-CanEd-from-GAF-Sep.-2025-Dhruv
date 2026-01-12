@php
    $isLoggedIn = Auth::guard('customers')->check();

    $defaultLang = getDefaultLanguage(1);
    $schoolRequestSetting = App\Models\SchoolRequestSetting::with([
        'schoolRequestSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
    ])->first();

    $isLoginModalSetting = App\Models\IsLoginModalSetting::with([
        'isLoginModalSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
    ])->first();
    $registeredSchoolCounts = 0;
    $customerLangs = null;
    if (isset(Auth::guard('customers')->user()->id)) {
        $registeredSchoolCounts = App\Models\School::withTrashed()
            ->whereCustomerId(Auth::guard('customers')->user()->id)
            ->count();
        $customerLangs = App\Models\CustomerLanguage::whereCustomerId(Auth::guard('customers')->user()->id)->get();
    }
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
    $registerationPackage = App\Models\RegistrationPackage::with([
        'registrationPackageDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
    ])->get();

    $degrees = App\Models\Degree::with([
        'degreeDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
    ])
        ->orderBy('order')
        ->get();
    $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
    $indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';
    $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
    $alreadyHaveSchoolSettings = getStaticTranslation('already_have_school_modal');
    $successMessage = getStaticTranslation('toaster_messages')['register_success_message'] ?? '';
    $schoolSuccessMessage = getStaticTranslation('toaster_messages')['register_school_success_message'] ?? '';

@endphp
@if (isset($data['logged_in_user_type']) && $data['logged_in_user_type'] == 'school')
    <school-request-page already_have_school_modal_translations="{{ $alreadyHaveSchoolSettings }}"
        lang="{{ $lang }}" indicate_required_field="{{ $indicateRequiredField }}" position="{{ $position }}"
        register_school_count="{{ $registeredSchoolCounts }}"
        is_login_modal_setting="{{ $isLoginModalSetting }}" is_logged_id="{{ $isLoggedIn }}"
        school_request_setting="{{ $schoolRequestSetting }}" login_slug="{{ getPageSlug('login_template') }}"
        logged_in_customer="{{ $loggedInCustomer }}" register_slug="{{ getPageSlug('register_template') }}"
        customer_languages="{{ $customerLangs }}" registeration_package="{{ $registerationPackage }}"
        degrees="{{ $degrees }}" slug="{{ auth()->guard('customers')->user()->slug }}"
        success_message="{{ $schoolSuccessMessage }}"
        >
    </school-request-page>
@elseif (isset($data['logged_in_user_type']))
    <div class="bg-white mx-auto container mt-5" >
        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <p class="text-primary">Only schools can register here</p>
        </div>
    </div>
@else
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        @php
            $defaultLang = getDefaultLanguage(1);
            $type = 'school';
            $regPageSettings = App\Models\RegPageSetting::with([
                'regPageSettingDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                },
            ])->first();
            if (Auth::guard('customers')->check() || Auth::guard('school_ambassadors')->check()) {
                echo '<script>
                    window.location.href = '/';
                </script>';
            }
            $registerationPackage = App\Models\RegistrationPackage::with([
                'registrationPackageDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                },
                'registrationPackageFeature' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                },
            ])
                ->where('type', $type)
                ->get();
            $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
            $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
        @endphp
        <register-page package_category="{{ $type }}" lang="{{ $lang }}" position="{{ $position }}"
            registeration_package="{{ $registerationPackage }}" slug="{{ getPageSlug('login_template') }}"
            reg_page_settings='{{ $regPageSettings }}' school_request_setting="{{ $schoolRequestSetting }}" success_message="{{ $successMessage }}"></register-page>
    </div>
@endif
