@extends('front.layouts.account')
@section('account-content')
    @php
        // $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $loggedInCustomer = Auth::guard('customers')->user();

        $is_package_amount_paid_create = isset($loggedInCustomer->package_price) ? $loggedInCustomer->package_price : '0';

    //     $loggedInCustomerPackage = isset(Auth::guard('customers')->user()->id) && Auth::guard('customers')->user()->user_type === 'school' 
    // ? Auth::guard('customers')->user()->registration_package_id 
    // : '';
    $loggedInCustomerPackage = isset(Auth::guard('customers')->user()->id) && Auth::guard('customers')->user()->user_type === 'school' 
    && Auth::guard('customers')->user()->registration_package_id == 1 
    ? Auth::guard('customers')->user()->registration_package_id : Auth::guard('customers')->user()->registration_package_id
     ;


        $defaultLang = getDefaultLanguage(1);
        $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
        $slug = isset(Auth::guard('customers')->user()->slug) ? Auth::guard('customers')->user()->slug : '';

        @endphp

        {{-- @php
            dd(    $loggedInCustomer,$loggedInCustomerPackage)
        @endphp --}}
    <virtual-tour-create lang="{{ $lang }}" slug="{{ $slug }}" school_id="{{ $data['school'] }}" is_package_amount_paid_create="{{ $is_package_amount_paid_create }}"
        logged_in_customer="{{ $loggedInCustomer }}" logged_in_customer_package="{{ $loggedInCustomerPackage }}"></virtual-tour-create>
@endsection
