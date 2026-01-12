@extends('front.layouts.app')
@php
$defaultLang = getDefaultLanguage(1);
$ambassador = Auth::guard('school_ambassadors')->user();
dd($ambassador);
@endphp
@section('content')
    <div class="bg-white container mx-auto">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 py-2 border-primary mt-6 w-full">
                <h1 class="can-edu-h1">Webinars</h1>
            </div>
        </div>
        <div class="my-10">
            <div class="flex flex-wrap" id="tabs-id">
                <div class="w-full flex flex-col md:flex-row  items-start">
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
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/' . $defaultLang['abbreviation'] . '/ambassador/webinars') }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-white bg-primary">
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
                    <div class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full">

                        <div class="mt-4 items-center flex justify-between gap-2 p-2">
                            <p class=" px-4 can-edu-h1">Webinar</p>
                            <div>
                        
                                    
                                    <a class="ml-2"
                                    href="{{ route('web.account.webinar.create', ['lang' => $defaultLang['abbreviation']]) }}">
                                    <button
                                        class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white">
                                        Create new
                                    </button>
                                </a> 
                            </div>
                        </div>
                        @if (count($webinars) > 0)
                            @foreach ($webinars as $webinar)
                                <div
                                    class="grid grid-cols-12 md:grid-cols-12 lg:grid-cols-12 gap-4 p-4 mt-2 border rounded-md shadow">
                                    <div class="md:col-span-4 col-span-12">
                                        <div class="h-44 border bg-gray-50">
                                            <img class="object-cover w-full h-full"
                                                src="{{ asset(isset($webinar->image) ? $webinar->image : '') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="md:col-span-8 col-span-12">

                                        <div>
                                            <p>
                                                <span class="text-lg font-FuturaMdCnBT"> Title : </span>
                                                {{ isset($webinar->title) ? $webinar->title : '' }}
                                            </p>
                                            <p>
                                                <span class="text-lg font-FuturaMdCnBT"> Start Date : </span>
                                                {{ isset($webinar->start_date) ? date('F d, Y', strtotime($webinar->start_date)) : '' }}
                                            </p>
                                            <p>
                                                <span class="text-lg font-FuturaMdCnBT"> Timezone : </span>
                                                {{ isset($webinar->timezone) ? $webinar->timezone : '' }}
                                            </p>


                                            <div class="mt-4 flex justify-end gap-2">

                                                <a
                                                href="{{ route('web.account.webinar.edit', ['lang' => $defaultLang['abbreviation'],'webinar' =>$webinar->id ]) }}">
                                                <button class="can-edu-btn-fill">Edit</button>
                                            </a>
                                              


                                               
                                                <webinar-delete lang="{{ $defaultLang['abbreviation'] }}"
                                                    webinar="{{ $webinar->id }}"></webinar-delete>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <br />
                            {!! $webinars->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
                        @else
                        <div class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full bg-[url(/assets/error-bg-image.png)]">
                            <div>
                                <img class="mx-auto" src="{{ asset('assets/404.png') }}" alt="">
                            </div>
                            <div class="space-y-4 flex justify-center items-center flex-col my-10 mx-auto">
                                <h1 class="text-[#014790] text-4xl md:text-5xl xl:text-6xl font-FuturaMdCnBT text-center">Oops</h1>
                                <p class="text-center text-base md:text-lg lg:text-2xl">We are sorry,We are sorry, <br/> but there is no content here yet</p>
                                <div class="pt-4 pb-2">
                                    <a
                                     href="{{ route('web.account.webinar.create', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                      <button class="can-edu-btn-fill">Explore
                                        webinar </button>
                                    </a>
                                </div>
                                <p class="text-base md:text-lg lg:text-xl text-gray-500 text-center">You do not have any Webinar yet</p>
                            </div>
                          </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endsection
