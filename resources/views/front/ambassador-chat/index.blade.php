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
                <div class="w-full flex flex-col md:flex-row  items-start">
                    <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 md:flex-col md:w-56 mr-4">
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/'.$defaultLang['abbreviation'].'/school/'.$school.'/'.$school_slug) }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-primary bg-white">
                                My School
                            </a>
                        </li>
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/'.$defaultLang['abbreviation'].'/ambassador/student-chat') }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal  text-white bg-primary">
                                Inbox
                            </a>
                        </li>
                        {{-- <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/'.$defaultLang['abbreviation'].'/ambassador/webinars') }}"
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
                            <a href="{{ url('/'.$defaultLang['abbreviation'].'/ambassador/webinar-settings') }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-primary bg-white">
                                Webinar settings
                            </a>
                        </li>
                    </ul>
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                        <div class="px-4 py-5 flex-auto">
                            <div class="block" id="tab-inbox">
                                @foreach ($conversations as $converstion)
                                {{-- @php
                                    dd($conversations);
                                @endphp --}}
                                    <a href="{{ url('/'.$defaultLang['abbreviation'].'/ambassador/student/' . $converstion->customer->id . '/student-chat') }}">
                                                                            {{-- @php
                                        dd(url('/'.$defaultLang['abbreviation'].'/ambassador/student/' . $converstion->customer->id . '/chat'));
                                    @endphp --}}
                                        <div class="space-y-4">
                                            <div
                                                class="relative border border-gray-200 px-4 py-2 rounded shadow bg-white flex justify-between items-center">

                                                <div class="flex items-center">
                                                    <img class="object-cover w-12 h-12 rounded-full"
                                                        src="{{ asset(isset($converstion->customer->image) ? $converstion->customer->image : '') }}"
                                                        alt="" />

                                                    <div class="ml-3 overflow-hidden">
                                                        <p class="font-medium text-gray-900 text-sm"><span
                                                                class="font-semibold">{{ isset($converstion->customer->first_name) ? $converstion->customer->first_name : '' }},
                                                            </span>
                                                        </p>
                                                        <p class="max-w-xs text-sm text-gray-500 truncate">
                                                            {{ isset($converstion->customer_last_messages[0]->content) ? $converstion->customer_last_messages[0]->content : '' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="flex items-center">
                                                    {{-- <img class="object-cover w-12 h-12"
                                                        src="{{ isset($converstion->school_ambassador->school->image) ? $converstion->school_ambassador->school->image : '' }}"
                                                        alt="" /> --}}

                                                    <div class="ml-4 mobile:ml-10 flex flex-col mobile:flex-row items-center">
                                                        <span
                                                        class="bg-red-600 text-white w-4 h-4 flex items-center justify-center mr-3 text-sm rounded-full">{{ count($converstion->unAmbassadorSeenmessages) > 0 ? count($converstion->unAmbassadorSeenmessages) : 0 }}</span>
                                                        <p class="max-w-xs text-sm text-gray-500 truncate">
                                                            {{ isset($converstion->customer_last_messages[0]->created_at) ? $converstion->customer_last_messages[0]->created_at->diffForHumans() : '' }}

                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
