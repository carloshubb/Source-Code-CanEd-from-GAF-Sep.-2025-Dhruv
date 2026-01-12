@extends('front.layouts.app')
@section('content')
    <?php
    $defaultLang = getDefaultLanguage(1);
        $user = auth()
            ->guard('customers')
            ->user()
            ->loadMissing('registrationPackage');
        $proxiMatchTranslations = getStaticTranslation('payment_profile');
        $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
    ?>
    <div class="bg-white container mx-auto">
        <div class="mt-10">
            <div class="border-b-4 pb-2 border-primary w-full flex items-center justify-between">
                <h1 class="can-edu-h1">
                    Proximatch request payment
                </h1>
            </div>

            <div class="mt-6">
                <proxima-payment payment_to_be_done="{{$paymentToBeDone}}" payment_profile_translations="{{ $proxiMatchTranslations }}" position="{{$position}}"
                user="{{ $user }}"></proxima-payment>
            </div>

        </div>

    </div>
@endsection
