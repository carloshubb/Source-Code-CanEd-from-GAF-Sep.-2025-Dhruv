@extends('front.layouts.account')
@section('account-content')
    @php
        $isLoggedIn = Auth::guard('customers')->check();
        $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user() : '';
        $userType = $loggedInCustomer ? $loggedInCustomer->user_type : '';
        $lang = getDefaultLanguage(1)['abbreviation'];
        $slug = isset(Auth::guard('customers')->user()->slug) ? Auth::guard('customers')->user()->slug : '';
        $eventsAccess='false';
    if($isLoggedIn){
        // dd($loggedInCustomer->registrationPackage->events);
        // count($loggedInCustomer->events);
        if(count($loggedInCustomer->ambassadors) < $loggedInCustomer->registrationPackage->ambassadors){
            $eventsAccess='true';
            
        }
        // dd($loggedInCustomer->registrationPackage->ambassadors);
        // dd(count($loggedInCustomer->ambassadors));
    }    @endphp
    <school-ambassador-create-component ambassador_access="{{ $eventsAccess }}" lang="{{ $lang }}" slug="{{ $slug }}" school_id="{{ $data['school'] }}"
        logged_in_customer="{{ $loggedInCustomer->id }}" logged_in_customer_whole_data="{{ $loggedInCustomer }}" user_type="{{ $userType }}"></school-ambassador-component>
    @endsection
