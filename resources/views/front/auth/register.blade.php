<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
    @php
        $defaultLang = getDefaultLanguage(1);
        $schoolRequestSetting = App\Models\SchoolRequestSetting::with([
            'schoolRequestSettingDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ])->first();
        $type = 'school';
        if (!isset($_GET['type']) || empty($_GET['type'])) {
            echo '<script>
                window.history.back();
            </script>';
        } else {
            $type = $_GET['type'];
        }
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
        reg_page_settings='{{ $regPageSettings }}' school_request_setting="{{ $schoolRequestSetting }}"></register-page>
</div>
