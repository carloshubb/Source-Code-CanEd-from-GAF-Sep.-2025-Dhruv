@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $customer = Auth::guard('customers')->user() !== null ? Auth::guard('customers')->user() : '';
    @endphp
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full p-2">
        <student-profile customer="{{$customer}}" school_id="{{ $data['school'] }}" logged_in_customer="{{ $loggedInCustomer }}"></student-profile>
    </div>
@endsection
