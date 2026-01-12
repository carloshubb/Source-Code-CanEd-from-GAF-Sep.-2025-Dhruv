@extends('front.layouts.app')
@section('content')
    <div class="relative bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        @php
            $defaultLang = getDefaultLanguage(1);
            $user = auth()
                ->guard('customers')
                ->user()
                ->loadMissing('registrationPackage');
            // $lang = getDefaultLanguage(true);
            // $url = langBasedURL($lang, route('user.account-settings.index'));
            $registerationPackage = App\Models\RegistrationPackage::with([
                'registrationPackageDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                },
                'registrationPackageFeature' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                },
            ])->where('type', $user->user_type)->get();

            $cards = App\Models\CustomerPaymentMethod::where('customer_id', $user->id)->get();
            $proxiMatchTranslations = getStaticTranslation('payment_profile');
            $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
        @endphp
        <update-plan payment_profile_translations="{{ $proxiMatchTranslations }}" card="{{ $cards }}"
            position="{{ $position }}" registeration_package="{{ $registerationPackage }}"
            user="{{ $user }}" user_type="{{ $user->user_type }}"></update-plan>
    </div>
@endsection
