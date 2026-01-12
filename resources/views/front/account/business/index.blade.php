@extends('front.layouts.account')
@php
$defaultLang = getDefaultLanguage(1);
@endphp
@section('account-content')
    <div class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full p-4">

        <div class=" flex justify-between items-center gap-2 p-2">
            <h1 class="can-school-h1">Businesses</h1>
        </div>
        @if (count($businesses) > 0)
            @foreach ($businesses as $business)
                <div class="grid grid-cols-12 md:grid-cols-12 lg:grid-cols-12 gap-4 p-4 mt-2 border rounded-md shadow">
                    <div class="md:col-span-4 col-span-12">
                        <div class="h-44 border bg-gray-50">
                            <img class="object-cover w-full h-full mx-auto" src="{{ asset(thumbnailImage($business->image)) }}"
                                alt="">
                        </div>
                        <!-- <p class="p-2 mt-2"
                                    style="text-align: center;background: {{ isset($business->status) && $business->status == 'pending' ? 'yellow' : 'green' }}"
                                    > -->
                        {{-- <div class="can-edu-btn-fill rounded-none mt-1">
                            {{ isset($business->status) ? $business->status : '' }}
                        </div> --}}
                    </div>
                    <div class="md:col-span-8 col-span-12">
                        <div class="w-full">
                            <div class="h-44  flex items-center">
                                <div>
                                    <p>
                                        <span class="text-lg font-FuturaMdCnBT">
                                            Name :
                                        </span>
                                        <span class="text-base">
                                            {{ isset($business->businessDetail[0]->business_name) ? $business->businessDetail[0]->business_name : '' }}
                                        </span>
                                    </p>
                                    <p>
                                        <span class="text-lg font-FuturaMdCnBT">
                                            Contact name :
                                        </span>
                                        <span class="text-base">
                                            {{ isset($business->contact_name) ? $business->contact_name : '' }}
                                        </span>
                                    </p>
                                    <p>
                                        <span class="text-lg font-FuturaMdCnBT">
                                            Email :
                                        </span>
                                        <span class="text-base">
                                            {{ isset($business->email) ? $business->email : '' }}
                                        </span>
                                    </p>
                                    <p>
                                        <span class="text-lg font-FuturaMdCnBT">
                                            Phone:
                                        </span>
                                        <span class="text-base">
                                            {{ isset($business->phone) ? $business->phone : '' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="mt-1 flex justify-end gap-2">
                                <a
                                    href="{{ route('web.account.business.edit', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug, 'business' => $business->id]) }}">
                                    <button class="can-edu-btn-fill">Edit</button>
                                </a>
                                <business-delete lang="{{ $defaultLang['abbreviation'] }}"
                                    business_id="{{ $business->id }}"></business-delete>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <br />
            {!! $businesses->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
        @else
        <div class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full bg-[url(/assets/error-bg-image.png)]">
            <div>
                <img class="mx-auto" src="{{ asset('assets/404.png') }}" alt="">
            </div>
            <div class="space-y-4 flex justify-center items-center flex-col my-10 mx-auto">
                <h1 class="text-[#014790] text-4xl md:text-5xl xl:text-6xl font-FuturaMdCnBT text-center">Oops</h1>
                <p class="text-center text-base md:text-lg lg:text-2xl">We are sorry,We are sorry, <br/> but there is no content here yet</p>
                {{-- <div class="pt-4 pb-2">
                    <a href="{{ route('web.account.business.create',['lang' => $defaultLang['abbreviation']]) }}">
                        <button class="can-edu-btn-fill">Explore
                            business </button>
                    </a>
                </div> --}}
                <p class="text-base md:text-lg lg:text-xl text-gray-500 text-center">You do not have any Business yet</p>
            </div>
          </div>
        @endif
    </div>
@endsection
