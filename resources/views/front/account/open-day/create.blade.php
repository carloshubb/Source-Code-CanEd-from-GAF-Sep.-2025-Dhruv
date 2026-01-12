@extends('front.layouts.account')
@section('account-content')
    @php
$defaultLang = getDefaultLanguage(1);

        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $loggedInCustomerData = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user() : '';
        $defaultLang = getDefaultLanguage(1);
        $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
        $customerLanguage = \App\Models\CustomerLanguage::where('customer_id', $loggedInCustomer)->get();
        $languagesWithNames = [];
        $indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';
        $schoolRequestTemplate = url('/' . $defaultLang['abbreviation'] . '/membership-package');

        foreach ($customerLanguage as $customerLang) {
            $language = \App\Models\Language::where('abbreviation', $customerLang->language_code)->first();

            if ($language) {
                $parms['language_code'] = $customerLang->language_code;
                $parms['language_name'] = $language->name;
                $languagesWithNames[] = $parms;
            }

        }
        $successMessage = getStaticTranslation('toaster_messages')['open_day_add_success_message'] ?? '';
        $slug = isset(Auth::guard('customers')->user()->slug) ? Auth::guard('customers')->user()->slug : '';
    @endphp
    <open-day-create lang="{{ $lang }}" slug="{{ $slug }}" school_id="{{ $data['school'] }}" logged_in_customer="{{ $loggedInCustomer }}" logged_in_customer_data="{{ $loggedInCustomerData }}" languages_with_names="{{ json_encode($languagesWithNames) }}" indicate_required_field="{{ $indicateRequiredField }}"
    success_message="{{ $successMessage }}" school_request_template="{{ $schoolRequestTemplate }}"

    ></open-day-create>
@endsection
