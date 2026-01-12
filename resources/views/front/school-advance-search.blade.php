@extends('front.layouts.app')
@php
    $defaultLang = getDefaultLanguage(1);
@endphp
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">
                    {{ isset($advanceSearchTranslations['page_title']) ? $advanceSearchTranslations['page_title'] : '' }}
                </h1>
                <!-- <div class="my-2 text-gray-600">
                                                    <p>This is the "Advanced search" description text.</p>
                                                </div> -->
            </div>
        </div>
         {{-- <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3"> --}}
            <div class="pt-1 border-primary w-full">
                <p>
                    {{ isset($advanceSearchTranslations['page_sub_title']) ? $advanceSearchTranslations['page_sub_title'] : '' }}
                </p>
                <!-- <div class="my-2 text-gray-600">
                                                    <p>This is the "Advanced search" description text.</p>
                                                </div> -->
            </div>
        {{-- </div> --}}
        <form method="GET"
            action="{{ route('web.advance.school.search.results', ['lang' => $defaultLang['abbreviation']]) }}">
            <div class="mt-10 bg-white px-6 py-6 border shadow rounded-md w-full">
                <div class="grid sm:grid-cols-1 lg:grid-cols-2 md:grid-cols-2 gap-4">
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['degree_level_input_label']) ? $advanceSearchTranslations['degree_level_input_label'] : '' }}</label>
                        <select name="degree_id" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            @foreach ($degrees as $degree)
                                <option value="{{ $degree->id }}">
                                    {{ $degree->name_order ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['field_of_study_input_label']) ? $advanceSearchTranslations['field_of_study_input_label'] : '' }}</label>
                        <select name="" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            @if ($programs->count() > 0)
                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}">
                                    {{ $program->name_order ?? '' }}
                                </option>
                            @endforeach
                            @else
                            <div class="text-center text-black text-lg mt-10">
                                {{-- <p>Sorry, your search yielded no results.</p>
                                <p>Please double-check your spelling and try different variations of your keywords or key phrases.</p> --}}
                                <p>{{ getStaticTranslation('general')['search_yield_error_text'] ?? '' }}</p>
                            </div>
                        @endif

                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['planing_input_label']) ? $advanceSearchTranslations['planing_input_label'] : '' }}</label>
                        <select name="" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="all">
                                All; I am not sure
                            </option>
                            <option value="fall">
                                Fall
                            </option>
                            <option value="winter">
                                Winter
                            </option>
                            <option value="summar">
                                Summer
                            </option>
                        </select>
                    </div>
                  
                        <div class="select-div">
                            <div class="w-full">
                                <label for=""
                                    class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['where_want_to_study_input_label']) ? $advanceSearchTranslations['where_want_to_study_input_label'] : '' }}</label>
                                <select  name="province[]" 
                                    class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none rounded border-gray-300 multiselect-dropdown {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}"
                                    multiple="multiple">
                                    @php
                                        $options = ['Alberta', 'British Columbia', 'Manitoba', 'New Brunswick', 'Newfoundland and Labrador', 'Nova Scotia', 'Ontario', 'Prince Edward Island', 'Quebec', 'Saskatchewan', 'Northwest Territories', 'Nunavut', 'Yukon'];
                                        sort($options);
                                    @endphp
                                    <option value="">All</option>
                                    @foreach ($options as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                  
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['online_offline_input_label']) ? $advanceSearchTranslations['online_offline_input_label'] : '' }}</label>
                        <select name="online_or_distance_education" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="text-base lg:text-lg flex items-center justify-between">{{ isset($advanceSearchTranslations['i_want_to_become_input_label']) ? $advanceSearchTranslations['i_want_to_become_input_label'] : '' }}
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5 fill-gray-500 ml-3 cursor-pointer peer relative right-0">
                                    <path fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 01-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 01-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 01-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584zM12 18a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="relative tooltip -bottom-4 right-0 group-hover:flex hidden peer-hover:flex">
                                    <div role="tooltip"
                                        class="absolute tooltiptext_icon right-0 -top-2 z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-primary text-gray-600 rounded w-60 md:w-96 px-4">
                                        <p class="text-white leading-none text-justify text-sm lg:text-base">
                                            {{ isset($advanceSearchTranslations['i_want_to_become_input_balloon']) ? $advanceSearchTranslations['i_want_to_become_input_balloon'] : '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <input type="text" placeholder="{{ isset($advanceSearchTranslations['i_want_to_become_placehoder_text']) ? $advanceSearchTranslations['i_want_to_become_placehoder_text'] : '' }}"

                            class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded  text-base lg:text-lg border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['school_type_input_label']) ? $advanceSearchTranslations['school_type_input_label'] : '' }}</label>
                        <select name="school_type" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="all">All</option>
                            @foreach ($schoolTypes as $schoolType)
                                <option value="{{ $schoolType->id }}">
                                    {{ $schoolType->name_order ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['min_cgpa_input_label']) ? $advanceSearchTranslations['min_cgpa_input_label'] : '' }}</label>
                        <select name="" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="50">
                                Equivalent to 50%
                            </option>
                            <option value="60">
                                Equivalent to 60%
                            </option>
                            <option value="70">
                                Equivalent to 70%
                            </option>
                            <option value="80">
                                Equivalent to 80%
                            </option>
                            <option value="90">
                                Equivalent to 90%
                            </option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['conditional_admission_input_label']) ? $advanceSearchTranslations['conditional_admission_input_label'] : '' }}</label>
                        <select name="conditional_admission" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['program_type_graduation_input_label']) ? $advanceSearchTranslations['program_type_graduation_input_label'] : '' }}</label>
                        <select name="program_type_greduates" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="all">All</option>
                            <option value="thesis">Thesis </option>
                            <option value="non_thesis">Non Thesis </option>
                            <option value="co_op">Co-op</option>
                            <option value="internship">Internship</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['program_type_undergraduation_input_label']) ? $advanceSearchTranslations['program_type_undergraduation_input_label'] : '' }}</label>
                        <select name="program_type_undergreduates" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="all">
                                All
                            </option>
                            <option value="co_op">
                                Co-op
                            </option>
                            <option value="honours">
                                Honours
                            </option>
                            <option value="interdisciplinary">
                                Interdisciplinary
                            </option>
                            <option value="major">
                                Major
                            </option>
                            <option value="minor">
                                Minor
                            </option>
                            <option value="spcialization">
                                Spacialization
                            </option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['im_interested_in_input_label']) ? $advanceSearchTranslations['im_interested_in_input_label'] : '' }}</label>
                        <select name="study_method" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="full_time">
                                Full-time
                            </option>
                            <option value="part_time">
                                Part-time
                            </option>
                            <option value="continue">
                                Continuing education
                            </option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['delivery_mode_input_label']) ? $advanceSearchTranslations['delivery_mode_input_label'] : '' }}</label>
                        <select name="delivery_mode" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="all">
                                All
                            </option>
                            <option value="day">
                                Day
                            </option>
                            <option value="evening">
                                Evening
                            </option>
                            <option value="day_and_evening">
                                Day and Evening
                            </option>

                            <option value="weekends">
                                Weekends
                            </option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['housing_accomodation_input_label']) ? $advanceSearchTranslations['housing_accomodation_input_label'] : '' }}</label>
                        <select name="accomodation" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="private">
                                Private
                            </option>
                            <option value="school_managed">
                                School managed
                            </option>
                            <option value="school_owned">
                                School owned
                            </option>
                            <option value="share_accomodation">
                                Shared accommodation
                            </option>
                            <option value="nearby">
                                Nearby
                            </option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="" class=" text-base lg:text-lg flex items-center justify-between">
                            <span>{{ isset($advanceSearchTranslations['work_study_program_input_label']) ? $advanceSearchTranslations['work_study_program_input_label'] : '' }}</span>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5 fill-gray-500 ml-3 cursor-pointer peer">
                                    <path fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 01-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 01-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 01-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584zM12 18a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="relative tooltip -bottom-4 group-hover:flex hidden peer-hover:flex">
                                    <div role="tooltip"
                                        class="absolute tooltiptext_icon right-0 -top-2 z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-primary text-gray-600 rounded w-60 md:w-96 px-4">
                                        <p class="text-white leading-none text-justify text-sm lg:text-base">
                                            {{ isset($advanceSearchTranslations['work_study_program_input_balloon']) ? $advanceSearchTranslations['work_study_program_input_balloon'] : '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <select name="work_on_campus" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['work_during_holidays_input_label']) ? $advanceSearchTranslations['work_during_holidays_input_label'] : '' }}</label>
                        <select name="work_during_holidays" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="all">
                                All
                            </option>
                            <option value="summar">
                                Summer
                            </option>
                            <option value="winter">
                                Winter
                            </option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="" class=" text-base lg:text-lg flex items-center justify-between">
                            <span>{{ isset($advanceSearchTranslations['internship_input_label']) ? $advanceSearchTranslations['internship_input_label'] : '' }}</span>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5 fill-gray-500 ml-3 cursor-pointer peer">
                                    <path fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 01-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 01-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 01-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584zM12 18a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="relative tooltip -bottom-4 group-hover:flex hidden peer-hover:flex">
                                    <div role="tooltip"
                                        class="absolute tooltiptext_icon right-0 -top-2 z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-primary text-gray-600 rounded w-60 md:w-96 px-4">
                                        <p class="text-white leading-none text-justify text-sm lg:text-base">
                                            {{ isset($advanceSearchTranslations['internship_input_balloon']) ? $advanceSearchTranslations['internship_input_balloon'] : '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <select name="internship" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="" class=" text-base lg:text-lg flex items-center justify-between">
                            <span>{{ isset($advanceSearchTranslations['coeducation_input_label']) ? $advanceSearchTranslations['coeducation_input_label'] : '' }}</span>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5 fill-gray-500 ml-3 cursor-pointer peer">
                                    <path fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 01-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 01-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 01-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584zM12 18a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="relative tooltip -bottom-4 group-hover:flex hidden peer-hover:flex">
                                    <div role="tooltip"
                                        class="absolute tooltiptext_icon right-0 -top-2 z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-primary text-gray-600 rounded w-60 md:w-96 px-4">
                                        <p class="text-white leading-none text-justify text-sm lg:text-base">
                                            {{ isset($advanceSearchTranslations['coeducation_input_balloon']) ? $advanceSearchTranslations['coeducation_input_balloon'] : '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <select name="co_op_education" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="yes">Yes </option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="" class=" text-base lg:text-lg flex items-center justify-between">
                            <span>{{ isset($advanceSearchTranslations['job_placement_input_label']) ? $advanceSearchTranslations['job_placement_input_label'] : '' }}</span>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5 fill-gray-500 ml-3 cursor-pointer peer">
                                    <path fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 01-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 01-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 01-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584zM12 18a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="relative tooltip -bottom-4 group-hover:flex hidden peer-hover:flex">
                                    <div role="tooltip"
                                        class="absolute tooltiptext_icon right-0 -top-2 z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-primary text-gray-600 rounded w-60 md:w-96 px-4">
                                        <p class="text-white leading-none text-justify text-sm lg:text-base">
                                            {{ isset($advanceSearchTranslations['job_placement_input_balloon']) ? $advanceSearchTranslations['job_placement_input_balloon'] : '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <select name="job_placement" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['financial_aid_program_domastic_input_label']) ? $advanceSearchTranslations['financial_aid_program_domastic_input_label'] : '' }}</label>
                        <select name="financial_aid_programs_for_domastic_students[]" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 multiselect-dropdown {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}"
                            multiple="multiple">
                            <option selected value="all">
                                All
                            </option>
                            <option value="grants">
                                Bursaries/Grants
                            </option>
                            <option value="scholarships">
                                Scholarships
                            </option>
                            <option value="student_loans">
                                Student loans
                            </option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['financial_aid_programs_for_province_students']) ? $advanceSearchTranslations['financial_aid_programs_for_province_students'] : ' ' }}</label>
                        <select name="financial_aid_programs_for_province_students[]" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 multiselect-dropdown {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}"
                            multiple="multiple">
                            <option selected value="all">
                                All
                            </option>
                            <option value="grants">
                                Bursaries / Grants
                            </option>
                            <option value="scholarships">
                                Scholarships
                            </option>
                            <option value="student_loans">
                                Student loans
                            </option>
                        </select>
                    </div>

                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['financial_aid_program_international_input_label']) ? $advanceSearchTranslations['financial_aid_program_international_input_label'] : '' }}</label>
                        <select name="financial_aid_programs_for_international_students[]" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 multiselect-dropdown {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}"
                            multiple="multiple">
                            <option selected value="all">All</option>
                            <option value="grants">Bursaries/Grants</option>
                            <option value="scholarships">Scholarships</option>
                            <option value="student_loans_co_signer">Student loans with co-signer</option>
                            <option value="student_loans_without_co_signer">Student loans without co-signer</option>

                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['teaching_language_input_label']) ? $advanceSearchTranslations['teaching_language_input_label'] : '' }}</label>
                        <select name="lang[]" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 multiselect-dropdown {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}"
                            multiple="multiple">
                            <option value="">All</option>
                            @foreach ($langs as $lang)
                                <option value="{{ $lang['code'] }}"  {{ $lang['code'] == 'en' ? 'selected' : '' }}>{{ $lang['name'] }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['research_dissertation_input_label']) ? $advanceSearchTranslations['research_dissertation_input_label'] : '' }}</label>
                        <select name="research_and_dissertaion" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['exchange_programs_input_label']) ? $advanceSearchTranslations['exchange_programs_input_label'] : '' }}</label>
                        <select name="exchange_program" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>

                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['degree_modifier_input_label']) ? $advanceSearchTranslations['degree_modifier_input_label'] : '' }}</label>
                        <select name="degree_modifier" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="all">
                                All
                            </option>
                            <option value="apprenticeship">
                                Apprenticeship
                            </option>
                            <option value="co_op">
                                Co-op
                            </option>
                            <option value="distance">
                                Distance
                            </option>
                            <option value="honor">
                                Honor
                            </option>
                            <option value="online">
                                Online
                            </option>
                            <option value="university_transfer">
                                University transfer
                            </option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['day_care_for_students_kids_input_label']) ? $advanceSearchTranslations['day_care_for_students_kids_input_label'] : '' }}</label>
                        <select name="daycare_for_students_with_kids" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="school_owned">Yes, school-owned</option>
                            <option value="school_managed">Yes, school-managed</option>
                            <option value="yes_private_neighbor">
                                Yes, private, neighbouring
                            </option>
                        </select>
                    </div>

                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['elementry_school_for_students_kids_input_label']) ? $advanceSearchTranslations['elementry_school_for_students_kids_input_label'] : '' }}</label>
                        <select name="elementary_school_for_students_with_kids" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="school_owned">Yes, school-owned</option>
                            <option value="school_managed">Yes, school-managed</option>
                            <option value="private_neighbor">Yes, private, neighbouring</option>
                            <option value="public_neighbor">Yes, public, neighbouring</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="" class=" text-base lg:text-lg flex items-center justify-between">
                            <span>{{ isset($advanceSearchTranslations['immigration_office_on_campus_input_label']) ? $advanceSearchTranslations['immigration_office_on_campus_input_label'] : '' }}</span>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5 fill-gray-500 ml-3 cursor-pointer peer">
                                    <path fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 01-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 01-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 01-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584zM12 18a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="relative tooltip -bottom-4 group-hover:flex hidden peer-hover:flex">
                                    <div role="tooltip"
                                        class="absolute tooltiptext_icon right-0 -top-2 z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-primary text-gray-600 rounded w-60 md:w-96 px-4">
                                        <p class="text-white leading-none text-justify text-sm lg:text-base">
                                            {{ isset($advanceSearchTranslations['immigration_office_on_campus_input_balloon']) ? $advanceSearchTranslations['immigration_office_on_campus_input_balloon'] : '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <select name="immigration_office_on_campus" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>

                    <div class="w-full">
                        <label for="" class=" text-base lg:text-lg flex items-center justify-between">
                            <span>{{ isset($advanceSearchTranslations['career_planing_input_label']) ? $advanceSearchTranslations['career_planing_input_label'] : '' }}
                            </span>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5 fill-gray-500 ml-3 cursor-pointer peer">
                                    <path fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 01-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 01-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 01-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584zM12 18a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="relative tooltip -bottom-4 group-hover:flex hidden peer-hover:flex">
                                    <div role="tooltip"
                                        class="absolute tooltiptext_icon right-0 -top-2 z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-primary text-gray-600 rounded w-60 md:w-96 px-4">
                                        <p class="text-white leading-none text-justify text-sm lg:text-base">
                                            {{ isset($advanceSearchTranslations['career_planing_input_balloon']) ? $advanceSearchTranslations['career_planing_input_balloon'] : '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <select name="career_planing" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="" class=" text-base lg:text-lg flex items-center justify-between">
                            <span>{{ isset($advanceSearchTranslations['pathway_programs_input_label']) ? $advanceSearchTranslations['pathway_programs_input_label'] : '' }}</span>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5 fill-gray-500 ml-3 cursor-pointer peer">
                                    <path fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 01-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 01-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 01-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584zM12 18a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="relative tooltip -bottom-4 group-hover:flex hidden peer-hover:flex">
                                    <div role="tooltip"
                                        class="absolute tooltiptext_icon right-0 -top-1 z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-primary text-gray-600 rounded w-60 md:w-96 px-4">
                                        <p class="text-white leading-none text-justify text-sm lg:text-base">
                                            {{ isset($advanceSearchTranslations['pathway_programs_input_balloon']) ? $advanceSearchTranslations['pathway_programs_input_balloon'] : '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <select name="pathway_programs" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="all">All</option>
                            <option value="graduates">Yes, graduate </option>
                            <option value="undergraduates">Yes, undergraduate</option>
                        </select>
                    </div>

                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['employeement_rates_input_label']) ? $advanceSearchTranslations['employeement_rates_input_label'] : '' }}</label>
                        <select name="employeement_rates" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="90">Above 90%</option>
                            <option value="80">Above 80%</option>
                            <option value="70">Above 70%</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['class_size_undergraduate_input_label']) ? $advanceSearchTranslations['class_size_undergraduate_input_label'] : '' }}</label>
                        <select name="class_size_undergraduate" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="10">Under 10 </option>
                            <option value="20">Under 20</option>
                            <option value="30">Under 30</option>
                        </select>
                    </div>

                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['class_size_graduate_input_label']) ? $advanceSearchTranslations['class_size_graduate_input_label'] : '' }}</label>
                        <select name="class_size_masters" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="10">Under 10 </option>
                            <option value="20">Under 20</option>
                            <option value="30">Under 30</option>
                        </select>
                    </div>
                    {{-- <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['class_size_master_input_label']) ? $advanceSearchTranslations['class_size_master_input_label'] : '' }}</label>
                        <select name="service_and_guidance_new_students" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div> --}}

                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['service_and_guidance_to_new_students_input_label']) ? $advanceSearchTranslations['service_and_guidance_to_new_students_input_label'] : '' }}</label>
                        <select name="service_and_guidance_to_new_arrivals_in_canada" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['how_many_years_before_im_eligible_to_apply_for_pr_input_label']) ? $advanceSearchTranslations['how_many_years_before_im_eligible_to_apply_for_pr_input_label'] : '' }}?</label>
                        <select name="years_before_elegible_for_pr" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">From the date you enrol in your full-time studies</option>
                            <option value="">All</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['work_while_study_off_campus_input_label']) ? $advanceSearchTranslations['work_while_study_off_campus_input_label'] : '' }}</label>
                        <select name="work_off_campus" id=""
                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary mb-2 focus:outline-none px-4 py-2 rounded border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">All</option>
                            <option value="yes">yes</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for=""
                            class="block text-base lg:text-lg">{{ isset($advanceSearchTranslations['city_input_label']) ? $advanceSearchTranslations['city_input_label'] : '' }}</label>
                        <input type="text" name="city" placeholder=""
                            class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded  text-base lg:text-lg border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">

                    </div>

                </div>


                <div class="my-6 text-center">
                    <button
                        class="can-edu-btn-fill whitespace-nowrap">{{ isset($advanceSearchTranslations['search_button_text']) ? $advanceSearchTranslations['search_button_text'] : '' }}</button>
                </div>

            </div>
        </form>


    </div>
@endsection
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/virtual-select@latest/dist/virtual-select.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('/dist/virtual-select.min.css')}}">
    
    
    @endsection
    @section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/virtual-select@latest/dist/virtual-select.min.js"></script> --}}
    
    <script src="{{ asset('/dist/virtual-select.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
      $(document).ready(function() {
            // Initialize VirtualSelect after jQuery and VirtualSelect JS are loaded
            VirtualSelect.init({ ele: '.multiselect-dropdown' });
        });
    </script>
@endsection
<style>
   .select-div{
    position: relative !important;
   }
   .multiselect-dropdown{
    padding: 0px !important;
    margin: 0px !important;
   }
   .vscomp-wrapper {
    color: #333;
    display: inline-flex;
    flex-wrap: wrap;
    font-size: 16px !important; /* Default font size */
    font-family: sans-serif;
    position: relative;
    text-align: left;
    width: 100%;
}

/* Apply font-size 18px for screens 767px or smaller */
@media (max-width: 767px) {
    .vscomp-wrapper {
        font-size: 18px !important;
    }
}

.vscomp-ele {
    display: inline-block;
    max-width: 100% !important;
    width: 100%;
}
.vscomp-wrapper:focus .vscomp-toggle-button {
    box-shadow: none !important;
}
</style>