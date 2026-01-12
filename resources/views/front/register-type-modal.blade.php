@php
    $defaultLang = getDefaultLanguage(1);
    $registerModalTranslations = getStaticTranslation('register_modal_fields_page');
@endphp
@extends('front.layouts.app')
@section('content')

<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="flex flex-col md:flex-row w-full items-end gap-3 md:h-14">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                {{ $registerModalTranslations['you_are_registering_as_title'] ?? '' }}
            </h1>
        </div>
    </div>
    <div class="mt-10 space-y-4">
        <register-type-modal 
            register_modal_translation="{{ $registerModalTranslations }}" >
        </register-type-modal>
    </div>
</div>

@endsection