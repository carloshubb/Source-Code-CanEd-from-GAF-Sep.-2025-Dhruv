@php
    $isLoggedIn = Auth::guard('customers')->check();
    $defaultLang = getDefaultLanguage(1);
    $registerBusinessSetting = App\Models\RegisterBusiness::with([
        'registerBusinessDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
    ])->first();
    $regPageSettings = App\Models\RegPageSetting::with([
        'regPageSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
    ])->first();
    $pageSettings = App\Models\Page::with([
        'PageDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
    ])->where('template', 'register_business_template')->first();

    $isLoginModalSetting = App\Models\IsLoginModalSetting::with([
        'isLoginModalSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
    ])->first();
    $registerationPackage = App\Models\RegistrationPackage::with([
        'registrationPackageDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
        'registrationPackageFeature' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
    ])
    ->where('type', 'business')
    ->get();
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
    $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
    $indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';
    $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
    $lang_id = isset($defaultLang->id) ? $defaultLang->id : 'en';
    $businesCategories = App\Models\BusinessCategory::with([
        'businessCategoryDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
        'BusinessCategoryImage',
    ])
        ->addSelect([
            'name_order' => App\Models\BusinessCategoryDetail::whereColumn('business_category_id', 'business_categories.id')
                ->where('language_id', $defaultLang->id)
                ->limit(1)
                ->select('name'),
        ])
        ->orderBy('name_order')
        ->get();
        $successMessage = getStaticTranslation('toaster_messages')['register_business_success_message'] ?? '';

@endphp

<register-business-page lang_id="{{ $lang_id }}" lang="{{ $lang }}"
    indicate_required_field="{{ $indicateRequiredField }}" position="{{ $position }}"
    login_slug="{{ getPageSlug('login_template') }}" register_slug="{{ getPageSlug('register_template') }}"
    registeration_package="{{ $registerationPackage }}" is_login_modal_setting="{{ $isLoginModalSetting }}"
    is_logged_id="{{ $isLoggedIn }}" logged_in_customer="{{ $loggedInCustomer }}"
    register_bussiness_setting="{{ $registerBusinessSetting }}" reg_page_settings='{{ $regPageSettings }}'
    business_categories="{{ $businesCategories }}" page_settings_detail="{{ $pageSettings }}"
    success_message="{{ $successMessage }}"
    >
</register-business-page>
{{-- 
@if (isset($data['logged_in_user_type']) && $data['logged_in_user_type'] == 'business')
    <register-business-page lang_id="{{ $lang_id }}" lang="{{ $lang }}"
        indicate_required_field="{{ $indicateRequiredField }}" position="{{ $position }}"
        login_slug="{{ getPageSlug('login_template') }}" register_slug="{{ getPageSlug('register_template') }}"
        registeration_package="{{ $registerationPackage }}" is_login_modal_setting="{{ $isLoginModalSetting }}"
        is_logged_id="{{ $isLoggedIn }}" logged_in_customer="{{ $loggedInCustomer }}"
        register_bussiness_setting="{{ $registerBusinessSetting }}"
        business_categories="{{ $businesCategories }}"></register-business-page>
@else
    <register-business-page lang_id="{{ $lang_id }}" lang="{{ $lang }}"
        indicate_required_field="{{ $indicateRequiredField }}" position="{{ $position }}"
        login_slug="{{ getPageSlug('login_template') }}" register_slug="{{ getPageSlug('register_template') }}"
        registeration_package="{{ $registerationPackage }}" is_login_modal_setting="{{ $isLoginModalSetting }}"
        is_logged_id="{{ $isLoggedIn }}" logged_in_customer="{{ $loggedInCustomer }}"
        register_bussiness_setting="{{ $registerBusinessSetting }}"
        business_categories="{{ $businesCategories }}"></register-business-page>
    <transition name="slide">
        <div
            id="defaultModal"
            tabindex="-1"
            aria-hidden="true"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
        >
            <div
                class="relative w-full rounded-2xl shadow-2xl border-4 border-primary/30 h-full max-w-2xl md:h-auto"
                ref="elementToDetectClick"
            >
                <!-- Modal content -->
                <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                    <div class="absolute inset-0 p-10 bg-opacity-50 flex justify-center items-center">
                        <div class="bg-white py-6 px-10 rounded shadow-lg text-center">
                            <p class="text-center can-edu-p ">Only Business profiles can register here</p>
                            <button
                                type="button"
                                class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4"
                                data-modal-hide="defaultModal"
                                onclick="window.history.back()"
                            >
                                Back
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
@endif --}}
