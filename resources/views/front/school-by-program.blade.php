@extends('front.layouts.app')
@php
    $defaultLang = getDefaultLanguage(1);
@endphp
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">
                    {{ isset($programTranslations['program_school_page_title']) ? $programTranslations['program_school_page_title'] : '' }}
                </h1>
            </div>
        </div>
        <div class="mt-4">
            <div class="pb-2 w-full">
                <p>
                    {!! optional($program->programDetail->first())->description !!}
                </p>
            </div>
        </div>
        @php
            $filteredSchools = $schools->where('package_type', 'featured')->all();
        @endphp
        @if (count($filteredSchools) > 0)
            <div class="mt-10 ">
                @foreach ($schools as $key => $school)
                    @if ($loop->first)
                        <div
                            class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                            <h2 class="can-edu-h2 mb-0 text-white normal-case">
                                {{ $school->package_type == 'free' ? 'Canadian schools' : ucfirst($school->package_type) . ' schools' }}
                            </h2>
                        </div>
                    @endif
                    <div class="card_bg border border-gray-300 rounded-lg shadow-md p-4 mt-4"
                        id="main_section_{{ $school->id }}">
                        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                            <div class="w-72 h-72 border border-gray-300 bg-gray-200 flex-shrink-0 mx-auto">
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
                                <div class="text-black mb-4 md:text-base lg:text-lg line-clamp-3">
                                    {!! $school->schoolDetail[0]->description ?? '' !!}
                                </div>
                                <div class="flex flex-row gap-3">
                                    <div>
                                        <a aria-label="Candian Education"
                                            href="{{ url('/' . $defaultLang['abbreviation'] . '/master-application?school_id=' . $school->id) }}">
                                            <button aria-label="Candian Education" class="can-edu-btn-fill"> Apply now
                                            </button>
                                        </a>
                                    </div>
                                    <div>
                                        <a aria-label="Candian Education"
                                            href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id . '/' . createSlug($school->name_order)) }}"
                                            target="_blank">
                                            <button aria-label="Candian Education" class="can-edu-btn-no-fill"> View
                                                {{ $school->name_order ?? '' }} profile
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
        @php
            $filteredSchools = $schools->where('package_type', 'premium')->all();
        @endphp
        @if (count($filteredSchools) > 0)
            <div class="mt-10 ">
                @foreach ($schools as $key => $school)
                    @if ($loop->first)
                        <div
                            class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                            <h2 class="can-edu-h2 mb-0 text-white normal-case">
                                {{ $school->package_type == 'free' ? 'Canadian schools' : ucfirst($school->package_type) . ' schools' }}
                            </h2>
                        </div>
                    @endif
                    <div class="card_bg border border-gray-300 rounded-lg shadow-md p-4 mt-4"
                        id="main_section_{{ $school->id }}">
                        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                            <div class="w-72 h-72 border border-gray-300 bg-gray-200 flex-shrink-0 mx-auto">
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
                                <div class="text-black mb-4 md:text-base lg:text-lg line-clamp-3">
                                    {!! $school->schoolDetail[0]->description ?? '' !!}
                                </div>
                                <div class="flex flex-row gap-3">
                                    <div>
                                        <a aria-label="Candian Education"
                                            href="{{ url('/' . $defaultLang['abbreviation'] . '/master-application?school_id=' . $school->id) }}">
                                            <button aria-label="Candian Education" class="can-edu-btn-fill"> Apply now
                                            </button>
                                        </a>
                                    </div>
                                    <div>
                                        <a aria-label="Candian Education"
                                            href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id . '/' . createSlug($school->name_order)) }}"
                                            target="_blank">
                                            <button aria-label="Candian Education" class="can-edu-btn-no-fill"> View
                                                {{ $school->name_order ?? '' }} profile
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
        @php
            $filteredSchools = $schools->whereNotIn('package_type', ['featured', 'premium'])->all();
        @endphp
        @if (count($filteredSchools) > 0)
            <div class="mt-10 ">
                @foreach ($schools as $key => $school)
                    @if ($loop->first)
                        <div
                            class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                            <h2 class="can-edu-h2 mb-0 text-white normal-case">Canadian schools</h2>
                        </div>
                    @endif
                    <?php
                    $packageType = $school->package_type;
                    
                    ?>
                    <div class="card_bg border border-gray-300 rounded-lg shadow-md p-4 mt-4"
                        id="main_section_{{ $school->id }}">
                        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                            <div class="w-72 h-72 border border-gray-300 bg-gray-200 flex-shrink-0 mx-auto">
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
                                <div class="text-black mb-4 md:text-base lg:text-lg line-clamp-3">
                                    {!! $school->schoolDetail[0]->description ?? '' !!}
                                </div>
                                <div class="flex flex-row gap-3">
                                    <div>
                                        <a aria-label="Candian Education"
                                            href="{{ url('/' . $defaultLang['abbreviation'] . '/master-application?school_id=' . $school->id) }}">
                                            <button aria-label="Candian Education" class="can-edu-btn-fill"> Apply now
                                            </button>
                                        </a>
                                    </div>
                                    <div>
                                        <a aria-label="Candian Education"
                                            href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id . '/' . createSlug($school->name_order)) }}"
                                            target="_blank">
                                            <button aria-label="Candian Education" class="can-edu-btn-no-fill"> View
                                                {{ $school->name_order ?? '' }} profile
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
        <div class="mt-4">
            {!! $schools->withQueryString()->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
        </div>
    </div>
@endsection
