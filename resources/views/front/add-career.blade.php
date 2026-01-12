@php
    $defaultLang = getDefaultLanguage(1);
    $isLoggedIn = Auth::guard('customers')->check();
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user() : '';
    $school_id = isset(Auth::guard('customers')->user()->school->id) ? Auth::guard('customers')->user()->school->id : '';
    $lang = $defaultLang['abbreviation'];
    $lang_id = $defaultLang['id'];
    $careerModalTranslations = getStaticTranslation('career_create_page');
    $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
    $indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';
@endphp
@extends('front.layouts.app')
@section('content')

<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
    <div class="flex flex-col md:flex-row w-full items-end gap-3 md:h-14">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                {{ $careerModalTranslations['career_page_title'] ?? '' }}
            </h1>
        </div>
    </div>

    <div class="mt-10 space-y-4">
        <add-career-form 
            indicate_required_field="{{ $indicateRequiredField }}" 
            lang_id="{{ $lang_id }}" 
            career_modal_translation="{{ $careerModalTranslations }}" 
            position="{{ $position }}" 
            class="mb-6 md:mb-0" 
            lang="{{ $lang }}" 
            school_id="{{ $school_id }}" 
            is_logged_id="{{ $isLoggedIn }}" 
            logged_in_customer="{{ $loggedInCustomer }}">
        </add-career-form>
    </div>
</div>

@endsection