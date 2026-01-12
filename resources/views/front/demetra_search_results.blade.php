@extends('front.layouts.app')
@php
$defaultLang = getDefaultLanguage(1);
$activityTypes = \App\Models\Activity::getTypes();
@endphp
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">
                    Demetra search results
                </h1>
            </div>
        </div>

        <div class="mt-10">
            @if (
                count($gpaSchools) === 0 &&
                count($sportSchools) === 0 &&
                count($csSchools) === 0 &&
                count($caSchools) === 0 &&
                collect($activityResults)->flatten(1)->count() === 0
            )
                <div class="text-left my-10 text-lg text-black">
                    {{ getStaticTranslation('general')['search_yield_error_text'] ?? '' }}
                </div>
            @endif
            <div class="mt-10 ">
                @if (count($gpaSchools) > 0)
                    <div
                        class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                        <h2 class="can-edu-h2 mb-0 text-white">
                            Based on your gpa
                        </h2>
                    </div>
                    @foreach ($gpaSchools as $key => $school)
                        <div class="bg-white rounded-lg shadow-md px-4 py-4 md:py-2 mt-4"
                            id="main_section_{{ $school->id }}">
                            <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                                <div class="w-72 md:w-32 h-72 md:h-32 mx-auto rounded-lg border bg-gray-200 flex-shrink-0 px-2">
                                    <img src="{{ asset(thumbnailImage($school->image)) }}"
                                        class="h-full w-full object-contain" alt="">
                                </div>
                                <div class="md:p-4 flex-1">
                                    <h2 class="text-xl md:text-xl lg:text-2xl text-black mb-2">
                                        {{ isset($school->schoolDetail[0]->school_name) ? $school->schoolDetail[0]->school_name : '' }}
                                    </h2>
                                    <div class="text-black mb-4 md:text-base lg:text-lg line-clamp-3">
                                        {!! isset($school->schoolDetail[0]->description) ? $school->schoolDetail[0]->description : '' !!}
                                    </div>
                                    <div class="flex flex-row md:flex-row gap-3">
                                        <div>
                                            <a aria-label="Candian Education"
                                                href="{{ url('/' . $defaultLang['abbreviation'] . '/master-application?school_id=' . $school->id.'/'. createSlug($school->schoolDetail[0]->school_name)) }}">
                                                <button aria-label="Candian Education" class="can-edu-btn-fill"> Apply
                                                    now
                                                </button>
                                            </a>
                                        </div>
                                        <div>
                                            <a aria-label="Candian Education"
                                                href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id) }}"
                                                target="_blank">
                                                <button aria-label="Candian Education" class="can-edu-btn-no-fill"> View
                                                    profile
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                @if (count($sportSchools) > 0)
                    <div
                        class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                        <h2 class="can-edu-h2 mb-0 text-white">
                            Based on your sports
                        </h2>
                    </div>
                    @foreach ($sportSchools as $key => $school)
                        <div class="bg-white rounded-lg shadow-md px-4 py-4 md:py-2 mt-4"
                            id="main_section_{{ $school->id }}">
                            <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                                <div class="w-72 md:w-32 h-72 md:h-32 mx-auto rounded-lg border bg-gray-200 flex-shrink-0 px-2">
                                    <img src="{{ asset(thumbnailImage($school->image)) }}"
                                        class="h-full w-full object-contain" alt="">
                                </div>
                                <div class="md:p-4 flex-1">
                                    <h2 class="text-xl md:text-xl lg:text-2xl text-black mb-2">
                                        {{ isset($school->schoolDetail[0]->school_name) ? $school->schoolDetail[0]->school_name : '' }}
                                    </h2>
                                    <div class="text-black mb-4 md:text-base lg:text-lg line-clamp-3">
                                        {!! isset($school->schoolDetail[0]->description) ? $school->schoolDetail[0]->description : '' !!}
                                    </div>
                                    <div class="flex flex-row md:flex-row gap-3">
                                        <div>
                                            <a aria-label="Candian Education"
                                                href="{{ url('/' . $defaultLang['abbreviation'] . '/master-application?school_id=' . $school->id) }}">
                                                <button aria-label="Candian Education" class="can-edu-btn-fill"> Apply
                                                    now
                                                </button>
                                            </a>
                                        </div>
                                        <div>
                                            <a aria-label="Candian Education"
                                                href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id.'/'. createSlug($school->schoolDetail[0]->school_name)) }}"
                                                target="_blank">
                                                <button aria-label="Candian Education" class="can-edu-btn-no-fill"> View
                                                    profile
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                @if (count($csSchools) > 0)
                    <div
                        class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                        <h2 class="can-edu-h2 mb-0 text-white">
                            Based on your community service
                        </h2>
                    </div>
                    @foreach ($csSchools as $key => $school)
                        <div class="bg-white rounded-lg shadow-md px-4 py-4 md:py-2 mt-4"
                            id="main_section_{{ $school->id }}">
                            <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                                <div class="w-72 md:w-32 h-72 md:h-32 mx-auto rounded-lg border bg-gray-200 flex-shrink-0 px-2">
                                    <img src="{{ asset(thumbnailImage($school->image)) }}"
                                        class="h-full w-full object-contain" alt="">
                                </div>
                                <div class="md:p-4 flex-1">
                                    <h2 class="text-xl md:text-xl lg:text-2xl text-black mb-2">
                                        {{ isset($school->schoolDetail[0]->school_name) ? $school->schoolDetail[0]->school_name : '' }}
                                    </h2>
                                    <div class="text-black mb-4 md:text-base lg:text-lg line-clamp-3">
                                        {!! isset($school->schoolDetail[0]->description) ? $school->schoolDetail[0]->description : '' !!}
                                    </div>
                                    <div class="flex flex-row md:flex-row gap-3">
                                        <div>
                                            <a aria-label="Candian Education"
                                                href="{{ url('/' . $defaultLang['abbreviation'] . '/master-application?school_id=' . $school->id) }}">
                                                <button aria-label="Candian Education" class="can-edu-btn-fill"> Apply
                                                    now
                                                </button>
                                            </a>
                                        </div>
                                        <div>
                                            <a aria-label="Candian Education"
                                                href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id.'/'. createSlug($school->schoolDetail[0]->school_name)) }}"
                                                target="_blank">
                                                <button aria-label="Candian Education" class="can-edu-btn-no-fill"> View
                                                    profile
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                @if (count($caSchools) > 0)
                    <div
                        class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                        <h2 class="can-edu-h2 mb-0 text-white">
                            Based on your conditional acceptance
                        </h2>
                    </div>
                    @foreach ($caSchools as $key => $school)
                        <div class="bg-white rounded-lg shadow-md px-4 py-4 md:py-2 mt-4"
                            id="main_section_{{ $school->id }}">
                            <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                                <div class="w-72 md:w-32 h-72 md:h-32 mx-auto rounded-lg border bg-gray-200 flex-shrink-0 px-2">
                                    <img src="{{ asset(thumbnailImage($school->image)) }}"
                                        class="h-full w-full object-contain" alt="">
                                </div>
                                <div class="md:p-4 flex-1">
                                    <h2 class="text-xl md:text-xl lg:text-2xl text-black mb-2">
                                        {{ isset($school->schoolDetail[0]->school_name) ? $school->schoolDetail[0]->school_name : '' }}
                                    </h2>
                                    <div class="text-black mb-4 md:text-base lg:text-lg line-clamp-3">
                                        {!! isset($school->schoolDetail[0]->description) ? $school->schoolDetail[0]->description : '' !!}
                                    </div>
                                    <div class="flex flex-row md:flex-row gap-3">
                                        <div>
                                            <a aria-label="Candian Education"
                                                href="{{ url('/' . $defaultLang['abbreviation'] . '/master-application?school_id=' . $school->id) }}">
                                                <button aria-label="Candian Education" class="can-edu-btn-fill"> Apply
                                                    now
                                                </button>
                                            </a>
                                        </div>
                                        <div>
                                            <a aria-label="Candian Education"
                                                href="{{ url('/' . $defaultLang['abbreviation'] . '/school/' . $school->id.'/'. createSlug($school->schoolDetail[0]->school_name)) }}"
                                                target="_blank">
                                                <button aria-label="Candian Education" class="can-edu-btn-no-fill"> View
                                                    profile
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                @foreach($activityResults as $type => $schools)
                @if(count($schools) > 0)
                    <div class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                        <h2 class="can-edu-h2 mb-0 text-white">
                            Based on your {{ $activityTypes[$type] ?? str_replace('_', ' ', $type) }}
                        </h2>
                    </div>
                    
                    @foreach($schools as $school)
                        <div class="bg-white rounded-lg shadow-md px-4 py-4 md:py-2 mt-4" id="main_section_{{ $school->id }}">
                            <!-- Same school display format as other sections -->
                            <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                                <div class="w-72 md:w-32 h-72 md:h-32 mx-auto rounded-lg border bg-gray-200 flex-shrink-0 px-2">
                                    <img src="{{ asset(thumbnailImage($school->image)) }}" class="h-full w-full object-contain" alt="">
                                </div>
                                <div class="md:p-4 flex-1">
                                    <h2 class="text-xl md:text-xl lg:text-2xl text-black mb-2">
                                        {{ $school->schoolDetail[0]->school_name ?? '' }}
                                    </h2>
                                    <div class="text-black mb-4 md:text-base lg:text-lg line-clamp-3">
                                        {!! $school->schoolDetail[0]->description ?? '' !!}
                                    </div>
                                    <div class="flex flex-row md:flex-row gap-3">
                                        <div>
                                            <a aria-label="Candian Education" href="{{ url('/'.$defaultLang['abbreviation'].'/master-application?school_id='.$school->id.'/'.createSlug($school->schoolDetail[0]->school_name ?? '')) }}">
                                                <button aria-label="Candian Education" class="can-edu-btn-fill">Apply now</button>
                                            </a>
                                        </div>
                                        <div>
                                            <a aria-label="Candian Education" href="{{ url('/'.$defaultLang['abbreviation'].'/school/'.$school->id.'/'.createSlug($school->schoolDetail[0]->school_name ?? '')) }}" target="_blank">
                                                <button aria-label="Candian Education" class="can-edu-btn-no-fill">View profile</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endforeach
            </div>

        </div>
    </div>
@endsection
