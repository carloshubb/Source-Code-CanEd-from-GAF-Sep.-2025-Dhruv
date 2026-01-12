@extends('front.layouts.account')
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full relative">
        <h1 class="px-4 pt-4 can-school-h1">Our businesses</h1>
        <div class="p-4">
            @if (count($businesses) > 0)
            <div class="absolute right-3 top-4">      
                <a href="{{ url(app()->getLocale().'/businesses') }}" class="flex-grow mx-2 ">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                        Explore businesses
                    </button>
                </a>
                {{-- <a href="{{ url(app()->getLocale().'/register-business') }}" class="flex-grow mx-2 ">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                        Create your own businesses
                    </button>
                </a> --}}
            </div>
                @foreach ($businesses as $business)
                    <div class="mt-4 card_bg border border-gray-300 rounded-lg shadow-md px-4 py-4 md:py-2 relative">
                        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                            <div class="w-48 h-48 rounded-lg border bg-gray-200 flex-shrink-0 px-2 mx-auto">
                                <img src="{{ asset(thumbnailImage($business->image)) }}" class="h-full w-full object-contain" alt="">
                            </div>
                            <div class="md:p-4 flex-1">
                            <div>
                                <p class="text-xl lg:text-2xl font-FuturaMdCnBT">
                                    {{ isset($business->businessDetail[0]->business_name) ? $business->businessDetail[0]->business_name : '' }}
                                </p>
                                <div class="mt-1 text-gray-500 can-edu-card-p line-clamp-3">
                                    {!! isset($business->businessDetail[0]) ? $business->businessDetail[0]->description : '' !!}
                                </div>
                                @php
                                    $slug = isset($business->slug) ? $business->slug : '';
                                    $url = '#';
                                    if (isset($business->businessDetail[0])) {
                                        $url = url('/'.getDefaultLanguage(1)['abbreviation'].'/business/' . $business->id . '/' . $slug);
                                    }
                                @endphp
                                <div class="mt-4 flex justify-start gap-2">
                                    <a href="{{ $url }}"><button class="can-edu-btn-fill">View</button></a>
                                </div>
                                <remove-fav-icon
                                 record_id="{{ $business->id }}" model="business"
                                   />
                            </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
            <div class="md:col-span-8 col-span-12 w-full">
                {{-- <div class="border border-blue-700 rounded-md p-5"> --}}
                    {{-- <div class="border border-primary rounded p-4"> --}}
                        <p>You do not have any Favorite businesses yet</p>
                    {{-- </div> --}}
                {{-- </div> --}}
                <a href="{{ url(app()->getLocale().'/businesses') }}" class="text-center absolute top-4 right-3">
                    <button class="can-edu-btn-fill">Explore Businesses</button>
                </a>
            </div>
            @endif
        </div>
    </div>
@endsection
