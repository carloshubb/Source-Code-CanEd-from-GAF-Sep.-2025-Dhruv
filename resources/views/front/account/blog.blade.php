@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
    @endphp
    <blog school_id="{{ $data['school'] }}" logged_in_customer="{{$loggedInCustomer}}"></blog>
@endsection
