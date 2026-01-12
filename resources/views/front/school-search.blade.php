@extends('front.layouts.app')
@php
    $defaultLang = getDefaultLanguage(1);
    $SchoolSearchButtonsTranslations = getStaticTranslation('school_search_buttons');
@endphp
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">Schools - search results for {{ request('search') ?? '' }}</h1>
            </div>
        </div>
        @php
        function formatUrl($url) {
            return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
        }

        @endphp
        @php
            $filteredSchools = $schools->where('package_type', 'featured')->all();
        @endphp

        @if (count($filteredSchools) > 0)
            <div class="mt-10 ">
                @foreach ($filteredSchools as $key => $school)
                @if ($loop->first)
                        <div
                            class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                            <h2 class="can-edu-h2 mb-0 text-white normal-case">
                                {{ $school->package_type == 'free' ? 'Canadian schools' : ucfirst($school->package_type) . ' schools' }}
                            </h2>
                        </div>
                    @endif
                    <div class="rounded-lg cards_wrapper bg-gradient-to-r from-pink-300 via-red-300 to-yellow-300 p-0.5 mb-4">
                      <div class="card_bg rounded-lg shadow-md p-4"
                        id="main_section_{{ $school->id }}">
                        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                            <div class="w-96 h-96 border bg-gray-200 border-gray-300 flex-shrink-0 mx-auto">
                               
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
                                <div
                                    class="text-black mb-4 md:text-base lg:text-lg line-clamp-3 text_justify text-justify">
                                    {!! $school->schoolDetail[0]->description ?? '' !!}
                                </div>
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
            $filteredSchools = $schools->where('package_type', 'premium')->all();
        @endphp

        @if (count($filteredSchools) > 0)
            <div class="mt-10 ">
                @foreach ($filteredSchools as $key => $school)
                    @if ($loop->first)
                        <div
                            class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                            <h2 class="can-edu-h2 mb-0 text-white normal-case">
                                {{ $school->package_type == 'free' ? 'Canadian schools' : ucfirst($school->package_type) . ' schools' }}
                            </h2>
                        </div>
                    @endif
                    <div class="rounded-lg cards_wrapper bg-gradient-to-r from-pink-300 via-red-300 to-yellow-300 p-0.5 mb-4">
                      <div class="card_bg rounded-lg shadow-md p-4"
                        id="main_section_{{ $school->id }}">
                        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                            <div class="w-80 h-80 border border-gray-300 bg-gray-200 flex-shrink-0 mx-auto">
                                <a aria-label="Candian Education"
                                    href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id . '/' . createSlug($school->name_order)) }}"
                                    target="_blank">
                                    <img src="{{ asset(thumbnailImage($school->image)) }}"
                                        class="h-full w-full object-contain" alt="">
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
                                <div
                                    class="text-black mb-4 md:text-base lg:text-lg line-clamp-3 text_justify text-justify">
                                    {!! $school->schoolDetail[0]->description ?? '' !!}
                                </div>
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
            $filteredSchools = $schools->whereNotIn('package_type', ['featured', 'premium'])->all();
        @endphp

        @if (count($filteredSchools) > 0)
            <div class="mt-10 ">
                @foreach ($filteredSchools as $key => $school)
                @if ($loop->first)
                        <div
                            class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                            <h2 class="can-edu-h2 mb-0 text-white normal-case">Canadian schools</h2>
                        </div>
                    @endif
                    <div class="rounded-lg shadow-md card_bg border border-gray-300 px-4 py-4 md:py-2 mt-4"
                        id="main_section_{{ $school->id }}">
                        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                            <div class="w-72 h-72 border border-gray-300 bg-gray-200 flex-shrink-0 mx-auto">
                                <a aria-label="Candian Education"
                                    href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id . '/' . createSlug($school->name_order)) }}"
                                    target="_blank">
                                    {{-- <img src="{{ asset(thumbnailImage($school->image)) }}"
                                        class="h-full w-full object-contain" alt=""> --}}
                                        @php
                                            $image = $school->image;

                                            // If it's already a valid URL (e.g., starts with http), use it directly
                                            if (filter_var($image, FILTER_VALIDATE_URL)) {
                                                $imgSrc = $image;
                                            } else {
                                                $imgSrc = asset(thumbnailImage($image)); // for uploaded local images
                                            }
                                        @endphp

                                        <img src="{{ $imgSrc }}" class="h-full w-full object-contain" alt="">
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
                                <div
                                    class="text-black mb-4 md:text-base lg:text-lg line-clamp-3 text_justify text-justify">
                                    {!! $school->schoolDetail[0]->description ?? '' !!}
                                </div>
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
              
                <div class="mt-8">
                    {!! $schools->withQueryString()->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
                </div>
            </div>
            @else
            <div class="text-center text-black text-lg mt-10">
                
                <p>{{ getStaticTranslation('general')['search_yield_error_text'] ?? '' }}</p>
            </div>
            @endif
    </div>
@endsection
