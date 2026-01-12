@extends('front.layouts.app')
@php
$defaultLang = getDefaultLanguage(1);
$businessTranslations = getStaticTranslation('businesses');
@endphp
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        @php
    function formatUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
    }
@endphp

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full justify-between md:justify-center items-end gap-3">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">{{$businessCategory->businessCategoryDetail[0]->name ?? 'Businesses'}}</h1>
            </div>
            <div
                class="flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
            <div class="relative md:-mb-4 flex items-center border border-gray-300 rounded">
                <a href="{{ url('/' . $defaultLang['abbreviation'] . '/register-business') }}" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5">{{ $businessTranslations['register_business_button_text'] ?? '' }}</a>
            </div>
            <form action="{{ route('web.search', ['lang' => $defaultLang['abbreviation']]) }}" method="GET">
                <div class="relative md:-mb-4 flex items-center border-collapse border-l-0 border border-gray-300 rounded">
                    <input name="search" type="search"
                     {{-- placeholder="Search {{$businessCategory->businessCategoryDetail[0]->name ?? 'Businesses'}}" --}}
                     placeholder=" {{ $businessTranslations['register_business_search_placeholder_text'] ?? '' }}"
                        value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}"
                        class="focus:outline-none focus:ring-primary rounded bg-white  px-3 py-2 border-y-0 border-gray-300 rounded-l border-l-4 border-l-primary">
                    <input name="search_type" type="hidden" value="business"
                        class=" focus:outline-none focus:ring-none bg-white  px-3 py-1 rounded-l">
                    <button type="submit" class="bg-gray-100 p-1.5 h-full rounded-r absolute right-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        </div>


        <div class="mt-16 md:mt-10 mb-6 md:mb-10">
            @php
                $featuredBusinesses = $businesses->where('package_type', 'featured');
            @endphp
            @foreach ($featuredBusinesses as $business)
                @if ($loop->first)
                    <div
                        class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                        <h2 class="normal-case can-edu-h2 mb-0 text-white">
                            Featured businesses</h2>
                    </div>
                @endif
                <?php $slug = isset($business->businessDetail[0]->slug) ? $business->businessDetail[0]->slug : ''; ?>
                <div class="rounded-lg cards_wrapper bg-gradient-to-r from-pink-300 via-red-300 to-yellow-300 p-0.5 mb-4">
                <div class=" rounded-lg card_bg shadow-md px-4 py-4 md:py-2">
                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                        {{-- <div class="w-96 h-96 rounded border bg-white flex-shrink-0 px-2 mx-auto">
                            <img src="{{ asset(thumbnailImage($business->image)) }}" class="h-full w-full object-contain"
                                alt="">
                        </div> --}}
                        <div class="w-96 h-96 rounded border bg-white flex-shrink-0 px-2 mx-auto">
                            @php
                                // Extract YouTube Video ID
                                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $business->youtube_url, $matches);
                                $youtubeId = $matches[1] ?? null;
                            @endphp
                        
                            @if ($business->package_type == 'featured' && $youtubeId)
                                <iframe 
                                    class="h-full w-full"
                                    src="https://www.youtube.com/embed/{{ $youtubeId }}" 
                                    frameborder="0" 
                                    allowfullscreen>
                                </iframe>
                            @else
                                @php
                                    $imgSrc1 = filter_var(trim($business->logo), FILTER_VALIDATE_URL) ? trim($business->logo) : asset(thumbnailImage($business->logo));
                                @endphp
                                <img src="{{ $imgSrc1 }}" class="h-full w-full object-contain" alt="">
                            @endif
                        </div>
                        <div class="md:p-4 flex-1">
                            <h2 class="text-xl md:text-xl lg:text-2xl text-black mb-2">
                                {{ isset($business->businessDetail[0]->business_name) ? $business->businessDetail[0]->business_name : '' }}
                            </h2>
                            <div class="text-black mb-4 md:text-base lg:text-lg line-clamp-3">
                                {!! isset($business->businessDetail[0]->description) ? $business->businessDetail[0]->description : '' !!}
                            </div>
                            <div class="flex flex-row gap-3">
                                <div>
                                    <a aria-label="Candian Education"
                                        href="{{ url('/' . $defaultLang['abbreviation'] . '/business/' . $business->id . '/' . $slug) }}">
                                        <button aria-label="Candian Education" class="can-edu-btn-fill"> Read more about {{$business->businessDetail[0]->business_name ?? ''}} </button>
                                    </a>
                                </div>
                                <div>
                                    <a aria-label="Candian Education" href="{{ formatUrl($business->website_url) }}" target="_blank">
                                        <button aria-label="Candian Education" class="can-edu-btn-no-fill"> Visit {{$business->businessDetail[0]->business_name ?? ''}}
                                            website </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            @endforeach
        </div>

        <div class="mt-16 md:mt-10 mb-6 md:mb-10">
            @php
                $premiumBusinesses = $businesses->where('package_type', 'premium');
            @endphp
            @foreach ($premiumBusinesses as $business)
                @if ($loop->first)
                    <div
                        class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                        <h2 class="normal-case can-edu-h2 mb-0 text-white">
                            Premium businesses</h2>
                    </div>
                @endif
                <?php $slug = isset($business->businessDetail[0]->slug) ? $business->businessDetail[0]->slug : ''; ?>
                <div class="rounded-lg cards_wrapper bg-gradient-to-r from-pink-300 via-red-300 to-yellow-300 p-0.5 mb-4">
                <div class=" rounded-lg card_bg shadow-md px-4 py-4 md:py-2">
                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                        <div class="w-80 h-80 rounded border bg-white flex-shrink-0 px-2 mx-auto">
                            @php
                                $imgSrc1 = filter_var(trim($business->logo), FILTER_VALIDATE_URL) ? trim($business->logo) : asset(thumbnailImage($business->logo));
                            @endphp
                            <img src="{{ $imgSrc1 }}" class="h-full w-full object-contain"
                                alt="">
                        </div>
                        <div class="md:p-4 flex-1">
                            <h2 class="text-xl md:text-xl lg:text-2xl text-black mb-2">
                                {{ isset($business->businessDetail[0]->business_name) ? $business->businessDetail[0]->business_name : '' }}
                            </h2>
                            <div class="text-black mb-4 md:text-base lg:text-lg line-clamp-3">
                                {!! isset($business->businessDetail[0]->description) ? $business->businessDetail[0]->description : '' !!}
                            </div>
                            <div class="flex flex-row gap-3">
                                <div>
                                    <a aria-label="Candian Education"
                                        href="{{ url('/' . $defaultLang['abbreviation'] . '/business/' . $business->id . '/' . $slug) }}">
                                        <button aria-label="Candian Education" class="can-edu-btn-fill"> Read more about {{$business->businessDetail[0]->business_name ?? ''}} </button>
                                    </a>
                                </div>
                                <div>
                                    <a aria-label="Candian Education" href="{{ formatUrl($business->website_url) }}" target="_blank">
                                        <button aria-label="Candian Education" class="can-edu-btn-no-fill"> Visit {{$business->businessDetail[0]->business_name ?? ''}}
                                            website </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            @endforeach
        </div>

        <div class="mt-16 md:mt-10">
            @php
                $freeBusinesses = $businesses->where('package_type', 'free');
            @endphp
            @foreach ($freeBusinesses as $business)
                @if ($loop->first)
                    <div
                        class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                        <h2 class="normal-case can-edu-h2 mb-0 text-white">
                            Free businesses</h2>
                    </div>
                @endif
                <?php $slug = isset($business->businessDetail[0]->slug) ? $business->businessDetail[0]->slug : ''; ?>
                <div class="mt-4 card_bg border border-gray-300 rounded-lg shadow-md px-4 py-4 md:py-2">
                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                        <div class="w-72 h-72 rounded border bg-white flex-shrink-0 px-2 mx-auto">
                            @php
                                $imgSrc1 = filter_var(trim($business->logo), FILTER_VALIDATE_URL) ? trim($business->logo) : asset(thumbnailImage($business->logo));
                            @endphp
                            <img src="{{ $imgSrc1  }}" class="h-full w-full object-contain"
                                alt="">
                        </div>
                        <div class="md:p-4 flex-1">
                            <h2 class="text-xl md:text-xl lg:text-2xl text-black mb-2">
                                {{ isset($business->businessDetail[0]->business_name) ? $business->businessDetail[0]->business_name : '' }}
                            </h2>
                            <div class="text-black mb-4 md:text-base lg:text-lg line-clamp-3">
                                {!! isset($business->businessDetail[0]->description) ? $business->businessDetail[0]->description : '' !!}
                            </div>
                            <div class="flex flex-row gap-3">
                                <div>
                                    <a aria-label="Candian Education"
                                        href="{{ url('/' . $defaultLang['abbreviation'] . '/business/' . $business->id . '/' . $slug) }}">
                                        <button aria-label="Candian Education" class="can-edu-btn-fill"> Read more about {{$business->businessDetail[0]->business_name ?? ''}} </button>
                                    </a>
                                </div>
                                <div>
                                    <a aria-label="Candian Education" href="{{ formatUrl($business->website_url) }}" target="_blank">
                                        <button aria-label="Candian Education" class="can-edu-btn-no-fill"> Visit {{$business->businessDetail[0]->business_name ?? ''}}
                                            website </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {!! $businesses->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
        </div>
    </div>
@endsection
