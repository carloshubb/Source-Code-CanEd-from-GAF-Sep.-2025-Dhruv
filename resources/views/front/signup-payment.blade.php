@extends('front.layouts.app')
@section('content')
    @if (Session::has('status') && Session::has('message'))
        <div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-center shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="mt-4 text-center">
                                <p class="text-lg text-center text-black">{!! session('message') !!}</p>
                            </div>
                        </div>
                        <div class="bg-white px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 justify-center">
                            <a href=""
                                class="inline-flex w-full justify-center rounded bg-red-500 px-3 py-2 font-FuturaMdCnBT text-lg font-medium text-white hover:text-white hover:shadow-lg shadow-sm hover:bg-red-400 sm:ml-3 sm:w-24">Close</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="relative md:py-16 py-8">
        @php
        $defaultLang = getDefaultLanguage(1);
        $user = auth()
            ->guard('customers')
            ->user();

if ($user && $user->relationLoaded('registrationPackage') === false) {
    $user->loadMissing('registrationPackage');
}

            $proxiMatchTranslations = getStaticTranslation('payment_profile');
            $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
            // dd($user);
        @endphp
        <create-profile-payment payment_profile_translations="{{ $proxiMatchTranslations }}" position="{{$position}}"
            user="{{ $user }}"></create-profile-payment>
    </div>
@endsection
