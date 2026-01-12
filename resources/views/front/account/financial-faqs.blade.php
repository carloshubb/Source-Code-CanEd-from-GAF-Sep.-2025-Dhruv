@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer= isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
    @endphp
    <faq-component logged_in_customer="{{$loggedInCustomer}}" faq_type="financial"></faq-component>
 @endsection
