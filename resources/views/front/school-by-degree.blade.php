@extends('front.layouts.app')
@php
    $defaultLang = getDefaultLanguage(1);
    $search = request('search') ?? null;

    // Filter schools based on search query
    $filteredSchools = $schools;
if ($search) {
    $filteredSchools = $schools->filter(function ($school) use ($search) {
        return stripos($school->name_order, $search) !== false;
    });
}

    // Categorize filtered schools by package type
    $featuredSchools = $filteredSchools->where('package_type', 'featured')->all();
    $premiumSchools = $filteredSchools->where('package_type', 'premium')->all();
    $freeSchools = $filteredSchools->whereNotIn('package_type', ['featured', 'premium'])->all();
    if (!function_exists('formatUrl')) {
        function formatUrl($url) {
            return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
        }
    }
        $SchoolSearchButtonsTranslations = getStaticTranslation('school_search_buttons');
@endphp
@section('content')
@php
    $defaultLang = getDefaultLanguage(1);
    $search = request()->get('search', null); // ensure always defined
@endphp
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full justify-between md:justify-center items-end gap-3 mb-8">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">
                    Schools - {{ isset($degree->degreeDetail[0]->name) ? $degree->degreeDetail[0]->name : '' }}
                </h1>
            </div>
            {{-- <form method="GET"> --}}
                <form method="GET" action="{{ url()->current() }}">
                <div class="relative md:-mb-4 flex items-center border-collapse border-l-0 border border-gray-300 rounded">
                    <input name="search" type="search" placeholder="Search for {{ isset($degree->degreeDetail[0]->name) ? $degree->degreeDetail[0]->name : 'schools' }}"
                        class="focus:outline-none focus:ring-primary rounded bg-white  px-3 py-2 border-y-0 border-gray-300 rounded-l border-l-4 border-l-primary" value="{{ $search }}" />
    
                    <button type="submit" class="bg-gray-100 p-1.5 h-full rounded-r absolute right-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        @if (!empty($degree->image))
            <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
                <img class="w-full h-full object-contain mx-auto"
                    src="{{ asset(largeImage($degree->image)) }}" alt="mango">
            </div>
        @endif

        @isset($degree->degreeDetail[0])
            <div class="can-edu-p mt-2">
                <div class="">
                    @php
                        $page_detail = $degree->degreeDetail[0]->description;
                    @endphp
                    @include('front.pages.widgets.render-widget-with-detail', [
                        'page_detail' => $page_detail,
                    ])
                </div>
            </div>
        @endisset

        @php
            // $filteredSchools = $schools->where('package_type', 'featured')->all();
            $filteredSchools = $featuredSchools;
        @endphp
        @if (count($filteredSchools) > 0)
            <div class="mt-10 ">
                @foreach ($filteredSchools as $key => $school)
                @if ($loop->first)
                        <div
                            class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                            <h2 class="can-edu-h2 mb-0 normal-case text-white">
                                {{ $school->package_type == 'free' ? 'Canadian schools' : ucfirst($school->package_type) . ' schools' }}
                            </h2>
                        </div>
                    @endif
                    <div class="rounded-lg cards_wrapper bg-gradient-to-r from-pink-300 via-red-300 to-yellow-300 p-0.5 mb-4">
                    <div class="card_bg rounded-lg shadow-md p-4"
                        id="main_section_{{ $school->id }}">
                        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                            <div class="w-96 h-96 rounded border bg-white flex-shrink-0 px-2 mx-auto">
                                <a aria-label="Candian Education"
                                    href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id . '/' . createSlug($school->name_order)) }}"
                                    target="_blank">

                                    @php
                                        // Extract the YouTube video ID from the URL
                                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $school->youtube_link, $matches);
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
                                        {{-- Show Image If No Video Available --}}
                                        <img src="{{ asset(thumbnailImage($school->image)) }}" 
                                            class="h-full w-full object-contain" 
                                            alt="School Image">
                                    @endif

                                </a>

                            </div>
                            <div class="md:p-4 flex-1">
                                <a aria-label="Candian Education"
                                    href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id . '/' . createSlug($school->name_order)) }}"
                                    target="_blank">
                                    <h2 class="text-xl md:text-xl lg:text-2xl text-black mb-2">
                                        {{ isset($school->name_order) ? $school->name_order : '' }}
                                    </h2>
                                </a>
                                <div class="text-black mb-4 md:text-base lg:text-lg line-clamp-3">{!! $school->schoolDetail[0]->description ?? '' !!}</div>
                                <div class="flex flex-row gap-3">
                                    <div>
                                        <a aria-label="Candian Education"
                                            href="{{ url('/' . $defaultLang['abbreviation'] . '/master-application?school_id=' . $school->id) }}">
                                            <button aria-label="Candian Education" class="can-edu-btn-fill">
                                                {{ $SchoolSearchButtonsTranslations['apply_now'] ?? 'Apply Nowasd' }}
                                            </button>
                                            
                                        </a>
                                    </div>
                                    <div>
                                        <a aria-label="Candian Education"
                                            href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id . '/' . createSlug($school->name_order)) }}"
                                            target="_blank">
                                            <button aria-label="Candian Education" class="can-edu-btn-no-fill">
                                                {{ $SchoolSearchButtonsTranslations['view_profile'] ?? 'Viewasd' }} 
                                                {{ $school->name_order ?? '' }} 
                                                {{ $SchoolSearchButtonsTranslations['view_profile_button_2'] ?? 'profileasd' }}
                                            </button>
                                            
                                        </a>
                                    </div>
                                    <div>
                                        <a aria-label="Candian Education" href="{{ formatUrl($school->website_url) }}"
                                            target="_blank">
                                            <button aria-label="Candian Education" class="can-edu-btn-no-fill">
                                                {{ $SchoolSearchButtonsTranslations['visit_website'] ?? 'Visit' }}  
                                                {{ $school->name_order ?? '' }}  
                                                {{ $SchoolSearchButtonsTranslations['visit_website_button_2'] ?? 'website' }}
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    </div>
                @endforeach

            </div>
        @endif
        @php
            // $filteredSchools = $schools->where('package_type', 'premium')->all();
            $filteredSchools = $premiumSchools;
        @endphp
        @if (count($filteredSchools) > 0)
            <div class="mt-10 ">
                @foreach ($filteredSchools as $key => $school)
                @if ($loop->first)
                        <div
                            class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                            <h2 class="can-edu-h2 mb-0 normal-case text-white">
                                {{ $school->package_type == 'free' ? 'Canadian schools' : ucfirst($school->package_type) . ' schools' }}
                            </h2>
                        </div>
                    @endif
                    <div class="rounded-lg cards_wrapper bg-gradient-to-r from-pink-300 via-red-300 to-yellow-300 p-0.5 mb-4">
                    <div class="card_bg rounded-lg shadow-md p-4"
                        id="main_section_{{ $school->id }}">
                        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                            <div class="w-80 h-80 rounded border bg-white flex-shrink-0 px-2 mx-auto">
                                <a aria-label="Candian Education"
                                    href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id . '/' . createSlug($school->name_order)) }}"
                                    target="_blank">
                                    <img src="{{ asset(thumbnailImage($school->image)) }}"
                                        class="h-full w-full object-contain" alt="" />
                                </a>
                            </div>
                            <div class="md:p-4 flex-1">
                                <a aria-label="Candian Education"
                                    href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id . '/' . createSlug($school->name_order)) }}"
                                    target="_blank">
                                    <h2 class="text-xl md:text-xl lg:text-2xl text-black mb-2">
                                        {{ isset($school->name_order) ? $school->name_order : '' }}
                                    </h2>
                                </a>
                                <div class="text-black mb-4 md:text-base lg:text-lg line-clamp-3">{!! $school->schoolDetail[0]->description ?? '' !!}</div>
                                <div class="flex flex-row gap-3">
                                    <div>
                                        <a aria-label="Candian Education"
                                            href="{{ url('/' . $defaultLang['abbreviation'] . '/master-application?school_id=' . $school->id) }}">
                                            <button aria-label="Candian Education" class="can-edu-btn-fill">
                                                {{ $SchoolSearchButtonsTranslations['apply_now'] ?? 'Apply Nowasd' }}
                                            </button>
                                        </a>
                                    </div>
                                    <div>
                                        <a aria-label="Candian Education"
                                            href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id . '/' . createSlug($school->name_order)) }}"
                                            target="_blank">
                                            <button aria-label="Candian Education" class="can-edu-btn-no-fill">
                                                {{ $SchoolSearchButtonsTranslations['view_profile'] ?? 'Viewasd' }} 
                                                {{ $school->name_order ?? '' }} 
                                                {{ $SchoolSearchButtonsTranslations['view_profile_button_2'] ?? 'profileasd' }}
                                            </button>
                                        </a>
                                    </div>
                                    <div>
                                        <a aria-label="Candian Education" href="{{ formatUrl($school->website_url) }}"
                                            target="_blank">
                                            <button aria-label="Candian Education" class="can-edu-btn-no-fill">
                                                {{ $SchoolSearchButtonsTranslations['visit_website'] ?? 'Visitasd' }}  
                                                {{ $school->name_order ?? '' }}  
                                                {{ $SchoolSearchButtonsTranslations['visit_website_button_2'] ?? 'websiteasd' }}
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    </div>
                @endforeach

            </div>
        @endif
        @php
            // $filteredSchools = $schools->whereNotIn('package_type', ['featured', 'premium'])->all();
            $filteredSchools = $freeSchools;

        @endphp
        @if (count($filteredSchools) > 0)
            <div class="mt-10 ">
                @foreach ($filteredSchools as $key => $school)
                @if ($loop->first)
                        <div
                            class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                            <h2 class="can-edu-h2 mb-0 normal-case text-white">Canadian schools</h2>
                        </div>
                    @endif
                    <div class="card_bg border border-gray-300 rounded-lg shadow-md p-4 mt-4"
                        id="main_section_{{ $school->id }}">
                        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                            <div class="w-72 h-72 rounded border bg-white flex-shrink-0 px-2 mx-auto">
                                <a aria-label="Candian Education"
                                    href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id . '/' . createSlug($school->name_order)) }}"
                                    target="_blank">
                                    <img src="{{ $school->getFinalImage() }}" class="h-full w-full object-contain" alt="">
                                </a>
                            </div>
                            <div class="md:p-4 flex-1">
                                <a aria-label="Candian Education"
                                    href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id . '/' . createSlug($school->name_order)) }}"
                                    target="_blank">
                                    <h2 class="text-xl md:text-xl lg:text-2xl text-black mb-2">
                                        {{ isset($school->name_order) ? $school->name_order : '' }}
                                    </h2>
                                </a>
                                <div class="text-black mb-4 md:text-base lg:text-lg line-clamp-3">{!! $school->schoolDetail[0]->description ?? '' !!}</div>
                                <div class="flex flex-row gap-3">
                                    {{-- <div>
                                        <a aria-label="Candian Education"
                                            href="{{ url('/' . $defaultLang['abbreviation'] . '/master-application?school_id=' . $school->id) }}">
                                            <button aria-label="Candian Education" class="can-edu-btn-fill"> Apply now
                                            </button>
                                        </a>
                                    </div> --}}
                                    <div>
                                        <a aria-label="Candian Education"
                                            href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id . '/' . createSlug($school->name_order)) }}"
                                            target="_blank">
                                            <button aria-label="Candian Education" class="can-edu-btn-no-fill">
                                                {{ $SchoolSearchButtonsTranslations['view_profile'] ?? 'Viewasd' }} 
                                                {{ $school->name_order ?? '' }} 
                                                {{ $SchoolSearchButtonsTranslations['view_profile_button_2'] ?? 'profileasd' }}
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if ($search && empty($featuredSchools) && empty($premiumSchools) && empty($freeSchools))
    <div class="text-center text-black text-lg mt-10">
        <p>{{ getStaticTranslation('general')['search_yield_error_text'] ?? '' }}</p>
    </div>
@endif
        <div class="mt-4">
            {!! $schools->withQueryString()->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
        </div>
    @endsection
