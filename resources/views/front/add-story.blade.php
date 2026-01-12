@php
    $defaultLang = getDefaultLanguage(1);
    $isLoggedIn = Auth::guard('customers')->check();
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user() : '';
    $school_id = isset(Auth::guard('customers')->user()->school->id) ? Auth::guard('customers')->user()->school->id : '';
    $lang = $defaultLang['abbreviation'];
    $lang_id = $defaultLang['id'];
    $storiesModalTranslations = getStaticTranslation('story_create_page');
    $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
    $indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';
    $successMessage = getStaticTranslation('toaster_messages')['story_add_success_message'] ?? '';
@endphp
@extends('front.layouts.app')
@section('content')

<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
    <div class="flex flex-col md:flex-row w-full items-end gap-3 md:h-14">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                {{ $storiesModalTranslations['story_page_title'] ?? '' }}
            </h1>
        </div>
    </div>

    <div class="mt-10 space-y-4">
        <add-story-form 
            indicate_required_field="{{ $indicateRequiredField }}" 
            lang_id="{{ $lang_id }}" 
            stories_modal_translation="{{ $storiesModalTranslations }}" 
            position="{{ $position }}" 
            class="mb-6 md:mb-0" 
            lang="{{ $lang }}" 
            school_id="{{ $school_id }}" 
            is_logged_id="{{ $isLoggedIn }}" 
            logged_in_customer="{{ $loggedInCustomer }}"
            success_message="{{ $successMessage }}">
        </add-story-form>
    </div>
</div>

@endsection