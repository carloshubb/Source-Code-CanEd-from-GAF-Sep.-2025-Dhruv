@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $defaultLang = getDefaultLanguage(1);
        $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
        $slug = isset(Auth::guard('customers')->user()->slug) ? Auth::guard('customers')->user()->slug : '';
    @endphp
    <virtual-tour-edit lang="{{ $lang }}" slug="{{ $slug }}" school_id="{{ $data['school'] }}" virtual_tour_id="{{ $virtualTour }}" logged_in_customer="{{ $loggedInCustomer }}">
    </virtual-tour-edit>
@endsection
