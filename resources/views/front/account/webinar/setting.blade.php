@extends('front.layouts.account')
@section('account-content')
        <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full">
            <div class="mt-4 flex justify-between items-center gap-2 p-2">
                <p class="px-4 can-edu-h1">Webinar Setting</p>
            </div>
            <div class="mt-6 w-full md:w-8/12 ml-4">
                <h3>Generate an API token</h3>
                <p>In order to use Livestorm’s REST API, you need to generate an API token. To do so, navigate to the
                    'Account
                    Settings' > 'Integrations' page and scroll down to the bottom of the page. Click on the 'Public API'
                    card and
                    you'll
                    be able to generate your own API tokens:</p>
                <img src="{{ asset('token.gif') }}" />
            </div>
        </div>
    {{-- <webinar-setting lang="{{ getDefaultLanguage(1)['abbreviation'] }}" home_page_url="{{ $homePageUrl }}"
        redirect_url="{{ $redirectUrl }}" logged_in_customer="{{ $loggedInCustomer }}"></webinar-setting> --}}
    </div>
@endsection
