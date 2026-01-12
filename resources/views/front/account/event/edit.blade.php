@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = Auth::guard('customers')->user();
        $defaultLang = getDefaultLanguage(1); 
        $logged_in_user_type_create = isset($data['logged_in_user_type']) ? $data['logged_in_user_type'] : '';
        $is_package_amount_paid_create = isset($loggedInCustomer->package_price) ? $loggedInCustomer->package_price : '0';
        $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
        $slug = isset(Auth::guard('customers')->user()->slug) ? Auth::guard('customers')->user()->slug : '';
    @endphp
    <event-edit school_id="{{ $data['school'] }}" slug="{{ $slug }}" event_id="{{ $event }}" :logged_in_customer="{{ json_encode($loggedInCustomer) }}"
    logged_in_user_type_create="{{ $logged_in_user_type_create }}"
    is_package_amount_paid_create="{{ $is_package_amount_paid_create }}" repost="{{ $repost }}">
    </event-edit>
@endsection
