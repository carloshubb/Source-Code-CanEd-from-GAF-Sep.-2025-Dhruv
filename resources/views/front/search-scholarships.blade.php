@extends('front.layouts.app')
@php
$defaultLang = getDefaultLanguage(1);

                            function formatUrl($url) {
                                return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
                            }
                        
                            $scholarshipTranslations = getStaticTranslation('scholarships');
@endphp
@section('content')
    <?php $scholarshipModalTranslations = getStaticTranslation('scholarship_modal'); ?>
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

        <div
            class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full justify-between md:justify-center items-end gap-3">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">Scholarships - Advanced search results
                </h1>
            </div>
            <div
                class="md:-mb-4 flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
                <scholarship-advanced-search
                    scholarship_advance_search_translation="{{ $scholarshipModalTranslations }}"></scholarship-advanced-search>
                <form action="{{ route('web.search', ['lang' => $defaultLang['abbreviation']]) }}" method="GET">
                    <div class="relative flex items-center border-collapse border-l-0 border border-gray-300 rounded">
                        <input name="search" type="search" placeholder="Search scholarships"
                            value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}"
                            class=" focus:outline-none focus:ring-primary rounded bg-white  px-3 py-1 border-y-0 border-gray-300 rounded-l border-l-4 border-l-primary">
                        <input name="search_type" type="hidden" value="scholarship"
                            class=" focus:outline-none focus:ring-none bg-white  px-3 py-1 rounded-l">
                        <button type="submit" class="bg-gray-100 p-1.5 rounded-r absolute right-0 h-full">
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


        <div class="mt-10 space-y-4">
            @if ($scholarships->count() > 0)
            @foreach ($scholarships as $scholarship)
                <div class="grid grid-cols-1 p-4 border rounded card_bg" id="main_section_{{ $scholarship->id }}">
                    <div class="flex justify-end items-center">
                        {{-- <button id="{{ $scholarship->id }}"
                            class="section_{{ $scholarship->id }} delete cursor-pointer border border-primary rounded-full w-7 h-7 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 text-primary">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button> --}}
                    </div>
                    <div class="grid grid-cols-12">
                        <div class="col-span-3 font-extrabold">
                            <p>Name</p>
                        </div>
                        
                        <div class="col-span-8 font-extrabold text-black">
                            <p>{{ isset($scholarship->schoolScholarshipDetail[0]->name) ? $scholarship->schoolScholarshipDetail[0]->name : '' }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-12 mt-3">
                        <div class="col-span-3 font-extrabold">
                            <p>School</p>
                        </div>
                        
                        <div class="col-span-8 text-black">
                            <p>{{ isset($scholarship->school->schoolDetail[0]->school_name) ? $scholarship->school->schoolDetail[0]->school_name : '' }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-12 mt-3">
                        <div class="col-span-3 font-extrabold">
                            <p>Summary</p>
                        </div>
                        
                        <div class="col-span-8 text-black line-clamp-3">
                            <p>{!! isset($scholarship->schoolScholarshipDetail[0]->summary)
                                ? $scholarship->schoolScholarshipDetail[0]->summary
                                : '' !!}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-12 mt-3">
                        <div class="col-span-3 font-extrabold">
                            <p>Province</p>
                        </div>
                        
                        <div class="col-span-8 text-black">
                            <p>{{ isset($scholarship->province) ? $scholarship->province : '' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-12 mt-3">
                        <div class="col-span-3 font-extrabold">
                            <p>Deadline</p>
                        </div>
                        
                        <div class="col-span-8 text-black">
                            <p>
                                {{-- {{ isset($scholarship->deadline_date) ? date('F d, Y', strtotime($scholarship->deadline_date)) : '' }} --}}
                                {{ !empty($scholarship->deadline_date) && strtotime($scholarship->deadline_date) 
                                    ? date('F d, Y', strtotime($scholarship->deadline_date)) 
                                    : 'Not available' }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-12 mt-3">
                        <div class="col-span-3 font-extrabold">
                            <p>Duration</p>
                        </div>
                        
                        <div class="col-span-8 text-black">
                            <p>{{ isset($scholarship->duration) ? $scholarship->duration : '' }}</p>
                        </div>
                    </div>

                    <div class="flex justify-center md:justify-end items-center mt-4">
                        <div class="flex items-center gap-2">
                         
                            <a href="{{ formatUrl($scholarship->more_info_link) }}" target="_blank">
                                <button class="can-edu-btn-fill whitespace-nowrap">
                                    {{ isset($scholarshipTranslations['apply_now_button_text']) ? $scholarshipTranslations['apply_now_button_text'] : '' }}
                                </button>
                            </a>
                            <a href="{{ route('web.view.scholarship.detail', ['lang' => $defaultLang['abbreviation'], 'id' => $scholarship->id]) }}"
                                target="_blank">
                                <button class="can-edu-btn-fill whitespace-nowrap">
                                    {{ isset($scholarshipTranslations['learn_more_button_text']) ? $scholarshipTranslations['learn_more_button_text'] : '' }}
                                </button>
                            </a>
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
            {!! $scholarships->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
        </div>

    </div>
@endsection
