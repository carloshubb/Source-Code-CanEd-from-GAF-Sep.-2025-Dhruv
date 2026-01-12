@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $defaultLang = getDefaultLanguage(1);
        $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
        $slug = isset(Auth::guard('customers')->user()->slug) ? Auth::guard('customers')->user()->slug : '';
    @endphp
    <video-edit school_id="{{ $data['school'] }}" lang="{{ $defaultLang['abbreviation'] }}" slug="{{ $slug }}" video_id="{{ $video }}" logged_in_customer="{{ $loggedInCustomer }}">
    </video-edit>
@endsection
