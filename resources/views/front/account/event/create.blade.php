@extends('front.layouts.account')
@section('account-content')
    @php
        // $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
        $loggedInCustomer = Auth::guard('customers')->user();
        $isLoggedIn = Auth::guard('customers')->check();
        $defaultLang = getDefaultLanguage(1); 
        $logged_in_user_type_create = isset($data['logged_in_user_type']) ? $data['logged_in_user_type'] : '';
        $is_package_amount_paid_create = isset($loggedInCustomer->package_price) ? $loggedInCustomer->package_price : '0';
        $lang = isset($defaultLang->abbreviation) ? $defaultLang->abbreviation : 'en';
        $slug = isset(Auth::guard('customers')->user()->slug) ? Auth::guard('customers')->user()->slug : '';
        $eventsAccess='false';
        if($isLoggedIn){
            // dd($loggedInCustomer->registrationPackage->events);
            // count($loggedInCustomer->events);
            if(count($loggedInCustomer->events) < $loggedInCustomer->registrationPackage->events){
                $eventsAccess='true';
                
            }

        }
        // dd($logged_in_user_type_create,
        // $data,
        // $is_package_amount_paid_create , 
        // $loggedInCustomer
        // )
        // dd($loggedInCustomer);
    @endphp
    <event-create
                    school_id="{{ $data['school'] }}"
                    slug="{{ $slug }}"
                    {{-- logged_in_customer="{{ $loggedInCustomer }}" --}}
                    :logged_in_customer="{{ json_encode($loggedInCustomer) }}"
                    logged_in_user_type_create="{{ $logged_in_user_type_create }}"
                    is_package_amount_paid_create="{{ $is_package_amount_paid_create }}"
                    lang="{{$lang}}"
            events_access="{{ $eventsAccess }}">
                    
                </event-create>
@endsection
