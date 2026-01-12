@extends('front.layouts.app')
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-end gap-3 h-14">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">Search results for “{{ isset($_GET['search']) ? $_GET['search'] : '' }}”
                </h1>
            </div>

            <form action="{{ url('/' . getDefaultLanguage(1)['abbreviation'] . '/career-search') }}">
                <div class="relative md:-mb-4 flex items-center border-collapse border-l-0 border border-gray-300 rounded">
                    <input name="search" type="search" placeholder="Search career"
                        value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}"
                        class=" focus:outline-none focus:ring-primary rounded bg-white  px-3 py-1 border-y-0 border-gray-300 rounded-l border-l-4 border-l-primary">
                    <input name="search_type" type="hidden" value="career"
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

        @php
            $hotCareers = $careers->where('hot', '1')->all();
            $allCareers = $careers->where('hot', '!=', '1')->all();
        @endphp

        @if (count($hotCareers) > 0 || count($allCareers) > 0)
            @isset($hotCareers)
                <div class="mt-16 md:mt-10">
                    <div
                        class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                        <h2 class="can-edu-h2 mb-0 normal-case text-white"> Hot careers </h2>
                    </div>
                    <div class="space-y-4">
                        @foreach ($hotCareers as $career)
                            <div class="grid grid-cols-1 p-4 border rounded-md card_bg" id="main_section_{{ $career->id }}">
                                <div class="grid grid-cols-12">
                                    <div class="col-span-4 md:col-span-2 font-extrabold">
                                        <p>Title</p>
                                    </div>
                                    <div class="col-span-7 md:col-span-9 font-extrabold text-gray-700">
                                        <p>{{ isset($career->careerDetail[0]) ? $career->careerDetail[0]->class_name : '' }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-12 mt-3">
                                    <div class="col-span-4 md:col-span-2 font-extrabold">
                                        <p>Definition</p>
                                    </div>
                                    <div class="col-span-7 md:col-span-9 text-gray-700 line-clamp-3">
                                        <p>{!! isset($career->careerDetail[0]) ? $career->careerDetail[0]->class_definition : '' !!}</p>
                                    </div>
                                </div>
                                {{-- <div class="grid grid-cols-12 mt-3">
                                    <div class="col-span-4 md:col-span-2 font-extrabold">
                                        <p>Hierarchical structure</p>
                                    </div>
                                    <div class="col-span-7 md:col-span-9 text-gray-700 line-clamp-3">
                                        <p>{{ isset($career->careerDetail[0]) ? $career->careerDetail[0]->h_structure : '' }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-12 mt-3">
                                    <div class="col-span-4 md:col-span-2 font-extrabold">
                                        <p>Level</p>
                                    </div>
                                    <div class="col-span-7 md:col-span-9 text-gray-700">
                                        <p>{{ isset($career->careerDetail[0]) ? $career->careerDetail[0]->level : '' }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-12 mt-3">
                                    <div class="col-span-4 md:col-span-2 font-extrabold">
                                        <p>Code</p>
                                    </div>
                                    <div class="col-span-7 md:col-span-9 text-gray-700">
                                        <p>{{ isset($career->careerDetail[0]) ? $career->careerDetail[0]->code : '' }}</p>
                                    </div>
                                </div> --}}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endisset

            @isset($allCareers)
                <div class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                    <h2 class="can-edu-h2 mb-0 normal-case text-white"> All careers </h2>
                </div>
                <div class="space-y-4">
                    @foreach ($allCareers as $career)
                        <div class="grid grid-cols-1 p-4 border rounded-md card_bg" id="main_section_{{ $career->id }}">
                            <div class="grid grid-cols-12">
                                <div class="col-span-4 md:col-span-2 font-extrabold">
                                    <p>Title</p>
                                </div>
                                <div class="col-span-7 md:col-span-9 font-extrabold text-gray-700">
                                    <p>{{ isset($career->careerDetail[0]) ? $career->careerDetail[0]->class_name : '' }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-extrabold">
                                    <p>Definition</p>
                                </div>
                                <div class="col-span-7 md:col-span-9 text-gray-700 line-clamp-3">
                                    <p>{!! isset($career->careerDetail[0]) ? $career->careerDetail[0]->class_definition : '' !!}</p>
                                </div>
                            </div>
                            {{-- <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-extrabold">
                                    <p>Hierarchical structure</p>
                                </div>
                                <div class="col-span-7 md:col-span-9 text-gray-700 line-clamp-3">
                                    <p>{{ isset($career->careerDetail[0]) ? $career->careerDetail[0]->h_structure : '' }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-extrabold">
                                    <p>Level</p>
                                </div>
                                <div class="col-span-7 md:col-span-9 text-gray-700">
                                    <p>{{ isset($career->careerDetail[0]) ? $career->careerDetail[0]->level : '' }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-extrabold">
                                    <p>Code</p>
                                </div>
                                <div class="col-span-7 md:col-span-9 text-gray-700">
                                    <p>{{ isset($career->careerDetail[0]) ? $career->careerDetail[0]->code : '' }}</p>
                                </div>
                            </div> --}}
                        </div>
                    @endforeach
                </div>
            @endisset

        @else
            <div class="text-center text-black text-lg mt-10">
                {{-- <p>Sorry, your search yielded no results.</p>
                <p>Please double-check your spelling and try different variations of your keywords or key phrases.</p> --}}
                <p>{{ getStaticTranslation('general')['search_yield_error_text'] ?? '' }}</p>
            </div>
        @endif
        {!! $careers->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
    </div>
@endsection
