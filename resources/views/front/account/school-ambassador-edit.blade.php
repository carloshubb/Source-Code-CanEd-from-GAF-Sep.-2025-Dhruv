@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer= isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user() : '';
        $userType = $loggedInCustomer ? $loggedInCustomer->user_type : '';

        $lang = getDefaultLanguage(1)['abbreviation'];
        $slug = isset(Auth::guard('customers')->user()->slug) ? Auth::guard('customers')->user()->slug : '';
    @endphp
    <school-ambassador-create-component lang="{{ $lang }}" slug="{{ $slug }}" ambassador_id="{{ $ambassador }}" school_id="{{ $data['school'] }}" logged_in_customer="{{$loggedInCustomer->id}}" user_type="{{ $userType }}"></school-ambassador-component>
 @endsection
