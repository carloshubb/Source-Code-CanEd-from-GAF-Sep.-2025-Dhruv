@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user() : '';
        $lang = getDefaultLanguage(1)['abbreveation'];
    @endphp
    <school-ambassador-component lang="{{ $lang }}" school_id="{{ $data['school'] }}"
        logged_in_customer="{{ $loggedInCustomer->id }}" logged_in_customer_data="{{ $loggedInCustomer }}"></school-ambassador-component>
@endsection
