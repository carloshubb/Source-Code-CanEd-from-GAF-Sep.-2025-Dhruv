@php
    $defaultLang = getDefaultLanguage(1);
    $masterApplicationSetting = App\Models\MasterApplicationSetting::with([
        'masterApplicationSettingDetail' => function ($q) use ($defaultLang) {
            $q = $q->where('language_id', $defaultLang->id);
        },
    ])->first();
    $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
    $indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';
    $masterApplicationModalTranslations = getStaticTranslation('master_application_pop_up_page');
    $successMessage = getStaticTranslation('toaster_messages')['master_application_submit_success_message'] ?? '';
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
    $CountryStatus = App\Models\Country::with([
    'countryDetail' => function ($q) use ($defaultLang) {
        $q->where('language_id', $defaultLang->id);
    },
])->get();
@endphp
<div class="  lg:py-14  md:py-10  py-8">
    @php
        $login_url = url('/' . $defaultLang['abbreviation'] . '/' . getPageSlug('login_template'));
        $login_text = isset(getGeneralTranslation()['login_menu_text']) ? getGeneralTranslation()['login_menu_text'] : 'Login';
        $register_url = url('/' . $defaultLang['abbreviation'] . '/' . getPageSlug('register_template') . '?type=student');
    @endphp
    <master-application hide_master_application_school_name="1"
lang="{{ $defaultLang->abbreviation }}"
    success_message="{{ $successMessage }}"
        school_id="{{ isset($_GET['school_id']) ? $_GET['school_id'] : '' }}"
        indicate_required_field="{{ $indicateRequiredField }}" position="{{ $position }}" container="0"
        master_application_setting="{{ $masterApplicationSetting }}"
        master_application_modal_translation="{{ $masterApplicationModalTranslations }}" 
        logged_in_customer="{{ $loggedInCustomer }}" 
        user_type="{{ $data['logged_in_user_type'] ?? null }}" login_text="{{$login_text}}" login_url="{{$login_url}}" register_url="{{$register_url}}" show_form_warning="1" :country_status='@json($CountryStatus)'></master-application>
</div>
