@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer= isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $logged_in_user_type = isset($data['logged_in_user_type']) ? $data['logged_in_user_type'] : '';
        $is_package_amount_paid = isset($loggedInCustomer->package_price) ? $loggedInCustomer->package_price : '0';
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
    <school-program school_id="{{ $data['school'] }}" logged_in_customer="{{$loggedInCustomer}}"  logged_in_user_type="{{ $logged_in_user_type }}"
    is_package_amount_paid="{{ $is_package_amount_paid }}" languages_with_names="{{ json_encode($languagesWithNames) }}"></school-program>
 @endsection
