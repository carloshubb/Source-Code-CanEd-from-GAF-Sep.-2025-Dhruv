@extends('front.layouts.account')
@section('account-content')
    @php
        $isLoggedIn = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->only(['id', 'user_type']) : '';
        // dd($data);
    @endphp
    <school-setting school_id="{{ $data['school'] }}" is_logged_id="{{ $isLoggedIn['id'] }}" is_logged_user_type="{{ $isLoggedIn['user_type'] }}"
        customer_langs="{{ $customerLangs }}"></school-setting>
@endsection

