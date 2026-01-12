@extends('front.layouts.app')
@section('content')
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                {{ isset($programTranslations['program_search_page_title']) ? $programTranslations['program_search_page_title'] : '' }} {{request('search') ?? ''}}
            </h1>
        </div>
    </div>

    <div class="mt-10 space-y-10">
        @if(count($programs) > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 space-y-2 md:space-y-0 gap-2">
            @foreach($programs as $program)
                @isset($program->programDetail[0]->name)
                    <div
                        class="flex items-center p-2 text-base md:text-base lg:text-lg border border-yellow-300 rounded-lg bg-yellow-50">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="flex-shrink-0 inline w-6 h-6 mr-3 text-primary">
                                <path fill-rule="evenodd"
                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="text-black hover:underline hover:underline-offset-2"><a
                                href="{{ url('/' . getDefaultLanguage(1)['abbreviation'] . '/program/' . $program->id) }}">{{ isset($program->programDetail[0]) ? $program->programDetail[0]->name : '' }}</a>
                        </div>
                    </div>
                @endisset
            @endforeach
        </div>
        @else
        <div class="text-center text-black text-lg mt-10">
            {{-- <p>Sorry, your search yielded no results.</p>
            <p>Please double-check your spelling and try different variations of your keywords or key phrases.</p> --}}
            <p>{{ getStaticTranslation('general')['search_yield_error_text'] ?? '' }}</p>
        </div>
        @endif
    </div>
    <br />
</div>
@endsection
