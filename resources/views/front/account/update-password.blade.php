@extends('front.layouts.account')
@section('account-content')
    @php
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
    @endphp
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full p-2">
        <update-password school_id="{{ $data['school'] }}" logged_in_customer="{{ $loggedInCustomer }}"></update-password>
    </div>
@endsection
