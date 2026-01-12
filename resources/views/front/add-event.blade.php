@php
    $defaultLang = getDefaultLanguage(1);
    $isLoggedIn = Auth::guard('customers')->check();
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user() : '';
    $school_id = isset(Auth::guard('customers')->user()->school->id) ? Auth::guard('customers')->user()->school->id : '';
    $lang = $defaultLang['abbreviation'];
    $lang_id = $defaultLang['id'];
    $eventModalTranslations = getStaticTranslation('event_create_page');
    $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
    $indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';
    $successMessage = getStaticTranslation('toaster_messages')['event_add_success_message'] ?? '';
    $eventsAccess='false';
    if($isLoggedIn){
        // dd($loggedInCustomer->registrationPackage->events);
        // count($loggedInCustomer->events);
        if(count($loggedInCustomer->events) < $loggedInCustomer->registrationPackage->events){
            $eventsAccess='true';
            
        }

    }
@endphp
@extends('front.layouts.app')
@section('content')
{{-- <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
    @if(isset($loggedInCustomer->package_price) && $loggedInCustomer->package_price > '0')
    <div class="flex flex-col md:flex-row w-full items-end gap-3 md:h-14">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                {{ isset($eventModalTranslations['page_title']) ? $eventModalTranslations['page_title'] : '' }}</h1>
        </div>
        
    </div>

    <div class="mt-10 space-y-4">
        <add-event-form indicate_required_field="{{$indicateRequiredField}}" lang_id="{{$lang_id}}" event_modal_translation="{{$eventModalTranslations}}" position="{{$position}}" class="mb-6 md:mb-0" lang="{{ $lang }}" school_id="{{ $school_id }}" is_logged_id="{{ $isLoggedIn }}"
            logged_in_customer="{{ $loggedInCustomer }}"></add-event-form>

    </div>
    @else
    <div class="flex flex-col md:flex-row w-full items-end gap-3 md:h-14">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                This feature is available exclusively to our Sponsors, as well as to our Premium and Featured schools and businesses
            </h1>
        </div>
        
    </div>
    @endif

</div> --}}
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
    <div class="flex flex-col md:flex-row w-full items-end gap-3 md:h-14">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                {{ $eventModalTranslations['page_title'] ?? '' }}
            </h1>
        </div>
    </div>

    <div class="mt-10 space-y-4">
        <add-event-form 
            indicate_required_field="{{ $indicateRequiredField }}" 
            lang_id="{{ $lang_id }}" 
            event_modal_translation="{{ $eventModalTranslations }}" 
            position="{{ $position }}" 
            class="mb-6 md:mb-0" 
            lang="{{ $lang }}" 
            school_id="{{ $school_id }}" 
            is_logged_id="{{ $isLoggedIn }}" 
            logged_in_customer="{{ $loggedInCustomer }}"
            success_message="{{ $successMessage }}"
            events_access="{{ $eventsAccess }}">
            
        </add-event-form>
    </div>
</div>

@endsection
