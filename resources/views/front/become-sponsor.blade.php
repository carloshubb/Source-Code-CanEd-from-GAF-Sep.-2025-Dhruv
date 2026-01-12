@php
    $defaultLang = getDefaultLanguage(1);
    $loggedInCustomer = Auth::guard('customers')->user() ?? '';
    $school_id = $loggedInCustomer->school->id ?? '';
    $sponsorPageTranslations = getStaticTranslation('become_sponsor_page');
    $indicateRequiredField = getStaticTranslation('general')['indicate_required_field_text'] ?? '';
    $successMessage = getStaticTranslation('toaster_messages')['sponsorship_add_success_message'] ?? '';
@endphp
@extends('front.layouts.app')
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="flex flex-col md:flex-row w-full items-end gap-3 md:h-14">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">
                    {{ $sponsorPageTranslations['page_title'] ?? '' }}</h1>
            </div>

        </div>
        <div class="can-edu-p mt-2"><div class=""><div class=""><p>{{$sponsorPageTranslations['bullet_points'] ?? ''}}</p></div></div></div>

        <div class="mt-5 space-y-4">
            <add-sponsor-form indicate_required_field="{{ $indicateRequiredField }}"
                sponsor_page_translation="{{ $sponsorPageTranslations }}" class="mb-6 md:mb-0" lang="{{ $defaultLang }}"
                school_id="{{ $school_id }}" logged_in_customer="{{ $loggedInCustomer }}" success_message="{{ $successMessage }}">
            </add-sponsor-form>
        </div>

    </div>
@endsection
