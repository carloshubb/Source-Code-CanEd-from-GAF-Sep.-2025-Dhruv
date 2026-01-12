@php
$defaultLang = getDefaultLanguage(1);
    $authorizationUrl = 'https://accounts.zoho.com/oauth/v2/auth';
    $redirectUri = env('APP_URL') . '/zoho/integration';
    $scopes = 'ZohoMeeting.manageOrg.READ ZohoMeeting.webinar.UPDATE ZohoMeeting.webinar.READ ZohoMeeting.webinar.CREATE ZohoMeeting.webinar.DELETE';
    // Redirect the user to Zoho's authorization URL
    $authUrl = "$authorizationUrl?prompt=consent&access_type=offline&client_id=$clientid&redirect_uri=$redirectUri&response_type=code&scope=$scopes";
@endphp
@extends('front.layouts.app')
@section('content')
    <div class="bg-white container mx-auto">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 py-2 border-primary mt-6 w-full">
                <h1 class="can-edu-h1">Webinars</h1>
            </div>
        </div>
        <div class="my-10">
            <div class="flex flex-wrap" id="tabs-id">
                <div class="w-full flex  flex-col md:flex-row items-start">
                    <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 md:flex-col md:w-56 mr-4">
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/'.$defaultLang['abbreviation'].'/school/' . $school."/".$school_slug) }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-primary bg-white">
                                My School
                            </a>
                        </li>
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/'.$defaultLang['abbreviation'].'/ambassador/student-chat') }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal  text-primary bg-white">
                                Inbox
                            </a>
                        </li>
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/'.$defaultLang['abbreviation'].'/ambassador/webinars') }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-white bg-primary">
                                Webinars
                            </a>
                        </li>
                        {{-- <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/'.$defaultLang['abbreviation'].'/ambassador/webinar-settings') }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-primary bg-white">
                                Webinar settings
                            </a>
                        </li> --}}
                    </ul>
                    <div class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full">
                        <webinar-edit lang="{{ $defaultLang['abbreviation'] }}" zoho_auth_url="{{ $authUrl }}" school_id="{{ $data['school'] }}"
                            ambassador_id="{{ $ambassador }}" webinar_id="{{$webinar}}">
                        </webinar-edit>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
