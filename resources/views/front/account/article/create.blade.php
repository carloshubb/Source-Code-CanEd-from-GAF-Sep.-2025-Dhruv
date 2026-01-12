@extends('front.layouts.account')
@section('account-content')
    @php
        // $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $isLoggedIn = Auth::guard('customers')->check();
        $loggedInCustomer = Auth::guard('customers')->user();
        $defaultLang = getDefaultLanguage(1); 
        $logged_in_user_type_create = isset($data['logged_in_user_type']) ? $data['logged_in_user_type'] : '';
        $slug = isset(Auth::guard('customers')->user()->slug) ? Auth::guard('customers')->user()->slug : '';
        $is_package_amount_paid_create = isset($loggedInCustomer->package_price) ? $loggedInCustomer->package_price : '0';
        $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
        $eventsAccess='false';
    if($isLoggedIn){
        // dd($loggedInCustomer->registrationPackage->events);
        // count($loggedInCustomer->events);
        if(count($loggedInCustomer->articles) < $loggedInCustomer->registrationPackage->articles){
            $eventsAccess='true';
            
        }
    }
    @endphp
    <article-create
                    school_id="{{ $data['school'] }}"
                    slug="{{ $slug }}"
                    logged_in_customer="{{ $loggedInCustomer }}"
                    logged_in_user_type_create="{{ $logged_in_user_type_create }}"
                    is_package_amount_paid_create="{{ $is_package_amount_paid_create }}"
                    article_access="{{ $eventsAccess }}">

                </article-create>
@endsection
