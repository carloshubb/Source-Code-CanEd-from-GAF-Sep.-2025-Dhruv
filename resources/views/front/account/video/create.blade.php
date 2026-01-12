@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $is_package_amount_paid = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->package_price : '';
        $logged_in_user_type = isset($data['logged_in_user_type']) ? $data['logged_in_user_type'] : '';
        $defaultLang = getDefaultLanguage(1); 
        $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
        $slug = isset(Auth::guard('customers')->user()->slug) ? Auth::guard('customers')->user()->slug : '';
        $videoCreateTranslations = getStaticTranslation('videoCreate');
    @endphp
    <video-create school_id="{{ $data['school'] }}" slug="{{ $slug }}" lang="{{ $defaultLang['abbreviation'] }}" logged_in_customer="{{ $loggedInCustomer }}" logged_in_user_type="{{ $logged_in_user_type }}"
    is_package_amount_paid="{{ $is_package_amount_paid }}" :video_create_translation='@json($videoCreateTranslations)'></video-create>
@endsection
