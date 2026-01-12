<div class="container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
    <?php
    $defaultLang = getDefaultLanguage(1);
    $loginPageSettings = App\Models\LoginPageSetting::with([
        'loginPageSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
    ])->first();
    if (Auth::guard('customers')->check() || Auth::guard('school_ambassadors')->check()) {
        echo '<script> window.location.href = "/"; </script>';
    }
    $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
    $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
    $lang_id = isset($defaultLang->id) ? $defaultLang->id : '';
    
    $returnUrl = isset($_GET['url']) ? $_GET['url'] : '';
    ?>

    <login-page return_url="{{ $returnUrl }}" lang_id="{{ $lang_id }}" lang="{{ $lang }}"
        position="{{ $position }}" error="{{ session('message') ? session('message') : '' }}"
        slug="{{ getPageSlug('register_template') }}" register_school_slug="{{ getPageSlug('school_request_template') }}" register_business_slug="{{ getPageSlug('register_business_template') }}" login_page_settings='{{ $loginPageSettings }}'></login-page>

    {{-- @if (session('message'))
        <div class="text-red-600">
            {{ session('message') }}
        </div>
    @endif --}}
</div>
