@extends('front.layouts.app')
@php
$defaultLang = getDefaultLanguage(1);
@endphp
@section('content')
    <div class="bg-white container mx-auto">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 py-2 border-primary mt-6 w-full">
                <h1 class="can-edu-h1">Chat with students</h1>
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
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal  text-white bg-primary">
                                Inbox
                            </a>
                        </li>
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/' . $defaultLang['abbreviation'] . '/ambassador/webinars') }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-primary bg-white">
                                Webinars
                            </a>
                        </li>
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/' . $defaultLang['abbreviation'] . '/ambassador/webinar-settings') }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-primary bg-white">
                                Webinar settings
                            </a>
                        </li>
                    </ul>
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                        <div class="px-4 py-5 flex-auto">
                            {{-- @php
                                dd($customer_id);
                            @endphp --}}
                            <student-chat customer_id="{{ $customer_id }}" customer_object="{{ $customerObject }}"
                                ambassador_id="{{ $ambassador }}" ambassador_object="{{ $ambassadorObject }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="bg-white container mx-auto">

    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
        <div class="border-b-4 py-2 border-primary mt-6 w-full">
            <p class="text-3xl font-bold text-primary font-FuturaBdCnBT">Chat system</p>
        </div>
    </div>
      
   </div> --}}
@endsection
