@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $defaultLang = getDefaultLanguage(1);
        $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
    @endphp
    <business-edit school_id="{{ $data['school'] }}" business_id="{{ $business }}" logged_in_customer="{{ $loggedInCustomer }}">
    </business-edit>
@endsection
