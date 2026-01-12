@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $defaultLang = getDefaultLanguage(1);
        $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
        $slug = isset(Auth::guard('customers')->user()->slug) ? Auth::guard('customers')->user()->slug : '';
    @endphp
    <article-edit school_id="{{ $data['school'] }}" slug="{{ $slug }}" article_id="{{ $article }}" logged_in_customer="{{ $loggedInCustomer }}">
    </article-edit>
@endsection
