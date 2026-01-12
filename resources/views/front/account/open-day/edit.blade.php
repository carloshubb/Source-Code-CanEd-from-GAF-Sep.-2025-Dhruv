@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $defaultLang = getDefaultLanguage(1); 
        $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
        $slug = isset(Auth::guard('customers')->user()->slug) ? Auth::guard('customers')->user()->slug : '';
        $indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';
    @endphp
    <open-day-edit lang="{{ $lang }}" slug="{{ $slug }}" school_id="{{ $data['school'] }}" open_day_id="{{ $openDay }}" logged_in_customer="{{ $loggedInCustomer }}" indicate_required_field="{{ $indicateRequiredField }}">
    </open-day-edit>
@endsection
