@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
    @endphp
    <close-account logged_in_customer="{{ $loggedInCustomer }}"></close-account>
@endsection
