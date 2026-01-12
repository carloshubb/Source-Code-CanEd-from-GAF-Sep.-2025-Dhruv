@extends('front.layouts.app')
@php
$defaultLang = getDefaultLanguage(1);
@endphp
@section('content')
    <div class="bg-white container mx-auto">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 py-2 border-primary mt-6 w-full">
                <h1 class="can-edu-h1">Webinar settings</h1>
            </div>
        </div>

        <div class="my-10">
            <div class="flex flex-wrap" id="tabs-id">
                <div class="w-full flex  flex-col md:flex-row items-start">
                    <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 md:flex-col md:w-56 mr-4">
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school . '/' . $school_slug) }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-primary bg-white">
                                My School
                            </a>
                        </li>
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/' . $defaultLang['abbreviation'] . '/ambassador/student-chat') }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal  text-primary bg-white">
                                Inbox
                            </a>
                        </li>
                        {{-- <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/' . $defaultLang['abbreviation'] . '/ambassador/webinars') }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-primary bg-white">
                                Webinars
                            </a>
                        </li> --}}
                        <li class="-mb-px mr-2 flex-auto text-center">
                            @if (auth()->guard('school_ambassadors')->user()->live_strom_token)
                                <a href="{{ url('/' . $defaultLang['abbreviation'] . '/ambassador/webinars') }}"
                                    class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-primary bg-white">
                                    Webinars
                                </a>
                            @else
                                <a href="#"
                                    class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-gray-400 bg-gray-200 cursor-not-allowed"
                                    onclick="return false;">
                                    Webinars (Disabled)
                                </a>
                            @endif
                        </li>
                        
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/' . $defaultLang['abbreviation'] . '/ambassador/webinar-settings') }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-white bg-primary">
                                Webinar settings
                            </a>
                        </li>
                    </ul>
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                        <div class="px-4 py-5 flex-auto">
                            <div class="block" id="tab-inbox">
                                <h3>Generate an API token</h3>
                                <p>In order to use Livestorm's REST API, you need to generate an API token. To do so,
                                    navigate to the
                                    'Account
                                    Settings' > 'Integrations' page by following <a
                                        href="https://app.livestorm.co/#/settings">Link</a> and scroll down to the bottom of
                                    the page. Click on the
                                    'Public API'
                                    card and
                                    you'll
                                    be able to generate your own API tokens:</p>
                                <img src="{{ asset('token.gif') }}" />
                                <p>Once token thing is done you will be a user on livestorm and you will get an email for
                                    verification once you verify with livestorm platform you are good to go and create your
                                    webinars</p>
                            </div>
                        </div>
                        @if (session('success'))
                            <div class="p-5">
                                <p>{{ session('success') }}</p>
                            </div>
                        @endif
                        <form class="p-5" action="{{ url('update-livestrom-token') }}" method="POST">
                            @csrf
                            <div class="relative">
                                <p>Please copy the token and paste in following input</p>
                                <input type="text" name="token"
                                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    placeholder="Livestrom token *" required
                                    value="{{ auth()->guard('school_ambassadors')->user()->live_strom_token }}" />
                            </div>

                            <button type="submit" class="mt-4 can-edu-btn-fill" :class="loading ? 'bg-opacity-20' : ''">
                                Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
