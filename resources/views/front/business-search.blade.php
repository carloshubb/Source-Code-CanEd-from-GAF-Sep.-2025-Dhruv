@extends('front.layouts.app')
@php
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user() : '';

@endphp
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">Search results for {{ request('search') }}</h1>
            </div>
        </div>

        <div class="mt-10 space-y-4">
            @if (count($businesses) > 0)
                <?php
                $packageType = '';
                ?>
                @php
                    if (!function_exists('formatUrl')) {
                        function formatUrl($url)
                        {
                            return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
                        }
                    }
                    //   dd($businesses);
                @endphp
                @foreach ($businesses as $key => $business)
                    <?php $slug = isset($business->slug) ? $business->slug : ''; ?>
                    @if ($business->package_type != $packageType)
                        <div
                            class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                            <h2 class="can-edu-h2 mb-0 normal-case text-white">
                                {{ ucfirst($business->package_type) . ' businesses' }}</h2>
                        </div>
                    @endif
                    <?php
                    $packageType = $business->package_type;
                    
                    ?>
                    @if ($business->package_type == 'featured')
                        <div
                            class="rounded-lg cards_wrapper bg-gradient-to-r from-pink-300 via-red-300 to-yellow-300 p-0.5 mb-4">
                        @elseif ($business->package_type == 'premium')
                            <div
                                class="rounded-lg cards_wrapper bg-gradient-to-r from-pink-300 via-red-300 to-yellow-300 p-0.5 mb-4">
                            @elseif ($business->package_type == 'free')
                                <div
                                    class="bg-gradient-to-r cards_wrapper from-gray-300 via-gray-300 to-gray-300 p-0.5 rounded">
                                @else
                                    <div
                                        class="bg-gradient-to-r cards_wrapper from-gray-300 via-gray-300 to-gray-300 p-0.5 rounded">
                    @endif
                    <div class="card_bg border border-gray-300 rounded-lg shadow-md px-4 py-4 md:py-2"
                        id="main_section_{{ $business->business_id }}">
                        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                            {{-- <div class="w-72 h-72 border border-gray-300 bg-gray-200 flex-shrink-0 mx-auto">
                                <img src="{{ asset(thumbnailImage($business->image)) }}"
                                    class="h-full w-full object-contain" alt="">
                            </div> --}}
                            {{-- <div class="w-72 h-72 border border-gray-300 bg-gray-200 flex-shrink-0 mx-auto">
                                @if (!empty($business->youtube_url))
                                    @php
                                        // Extract the YouTube video ID from the URL
                                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $business->youtube_url, $matches);
                                        $youtubeId = $matches[1] ?? null;
                                    @endphp
                                    
                                    @if ($youtubeId)
                                        <iframe 
                                            class="h-full w-full"
                                            src="https://www.youtube.com/embed/{{ $youtubeId }}" 
                                            frameborder="0" 
                                            allowfullscreen>
                                        </iframe>
                                    @else
                                        <p class="text-center text-gray-500 text-sm">Invalid YouTube URL</p>
                                    @endif
                                @else
                                    <p class="text-center text-gray-500 text-sm">No video available</p>
                                @endif
                            </div> --}}
                            @if ($business->package_type == 'featured')
                                <div class="w-96 h-96 border border-gray-300 bg-gray-200 flex-shrink-0 mx-auto">
                                @elseif ($business->package_type == 'premium')
                                    <div class="w-80 h-80 border border-gray-300 bg-gray-200 flex-shrink-0 mx-auto">
                                    @elseif ($business->package_type == 'free')
                                        <div class="w-72 h-72 border border-gray-300 bg-gray-200 flex-shrink-0 mx-auto">
                                        @else
                                            <div class="w-72 h-72 border border-gray-300 bg-gray-200 flex-shrink-0 mx-auto">
                            @endif
                            @php
                                $youtubeId = null;
                                if (!empty($business->youtube_url)) {
                                    // Extract the YouTube video ID from the URL
                                    preg_match(
                                        '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i',
                                        $business->youtube_url,
                                        $matches,
                                    );
                                    $youtubeId = $matches[1] ?? null;
                                }
                            @endphp

                            @if ($business->package_type == 'featured' && $youtubeId)
                                <iframe class="h-full w-full" src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                    frameborder="0" allowfullscreen>
                                </iframe>
                            @else
                                {{-- <img src="{{ asset(thumbnailImage($business->image)) }}"
                                    class="h-full w-full object-contain" alt="Business Image"> --}}

                                @php
                                    $imgSrc = filter_var(trim($business->logo), FILTER_VALIDATE_URL) ? trim($business->logo) : asset(trim($business->logo));
                                @endphp
                                <img src="{{ $imgSrc }}" class="h-full w-full object-contain" alt="">
                            @endif
                        </div>



                        <div class="md:p-4 flex-1">
                            <h2 class="text-xl md:text-xl lg:text-2xl text-black mb-2">
                                {{ isset($business->business_name) ? $business->business_name : '' }}
                            </h2>
                            <div class="text-black mb-4 md:text-base lg:text-lg line-clamp-3">
                                {!! isset($business->description) ? $business->description : '' !!}
                            </div>
                            <div class="flex flex-row gap-3">
                                <div>
                                    <?php $slug = isset($business->businessDetail[0]->slug) ? $business->businessDetail[0]->slug : ''; ?>
                                    <a aria-label="Candian Education"
                                        href="{{ url('/' . getDefaultLanguage(1)['abbreviation'] . '/business/' . $business->business_id . '/' . $slug) }}">
                                        <button aria-label="Candian Education" class="can-edu-btn-fill"> View
                                            {{ $business->business_name ?? '' }}
                                            profile </button>
                                    </a>
                                </div>
                                @if ($business->package_type == 'featured' || $business->package_type == 'premium')
                                    <div>

                                        <a aria-label="Candian Education" href="{{ formatUrl($business->website_url) }}"
                                            target="_blank">
                                            <button aria-label="Candian Education" class="can-edu-btn-no-fill"> Visit
                                                {{ strtolower($business->business_name ?? '') }}
                                                website </button>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
        </div>
    </div>
    @endforeach
@else
    <div class="text-center text-black text-lg mt-10">
        {{-- <p>Sorry, your search yielded no results.</p>
                    <p>Please double-check your spelling and try different variations of your keywords or key phrases.</p> --}}
        <p>{{ getStaticTranslation('general')['search_yield_error_text'] ?? '' }}</p>
    </div>
    @endif

    </div>
    <br />
    {!! $businesses->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
    </div>
@endsection
