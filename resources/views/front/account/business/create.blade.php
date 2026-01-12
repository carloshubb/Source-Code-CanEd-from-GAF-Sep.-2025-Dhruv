@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $defaultLang = getDefaultLanguage(1);
        $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
    @endphp
    <business-create school_id="{{ $data['school'] }}" logged_in_customer="{{ $loggedInCustomer }}"></business-create>
@endsection
