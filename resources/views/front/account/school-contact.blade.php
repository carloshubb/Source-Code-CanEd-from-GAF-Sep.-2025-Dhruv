@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $customerLanguage = \App\Models\CustomerLanguage::where('customer_id', $loggedInCustomer)->get();
        $languagesWithNames = [];

        foreach ($customerLanguage as $customerLang) {
            $language = \App\Models\Language::where('abbreviation', $customerLang->language_code)->first();

            if ($language) {
                $parms['language_code'] = $customerLang->language_code;
                $parms['language_name'] = $language->name;
                $languagesWithNames[] = $parms;
            }
    } 
    @endphp
    <school-contact school_id="{{ $data['school'] }}" logged_in_customer="{{ $loggedInCustomer }}" languages_with_names="{{ json_encode($languagesWithNames) }}"></school-contact>
@endsection
