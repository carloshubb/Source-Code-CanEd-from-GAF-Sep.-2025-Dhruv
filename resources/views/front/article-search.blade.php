@extends('front.layouts.app')
@php
$defaultLang = getDefaultLanguage(1);
@endphp
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full justify-between md:justify-center items-end gap-3">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">Articles - search results for {{request('search') ?? ''}}</h1>
            </div>
        <div
        class="flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
            <form action="{{ route('web.search', ['lang' => $defaultLang['abbreviation']]) }}" method="GET">
                <div class="relative md:-mb-3.5 flex items-center border-collapse border-l-0 border border-gray-300 rounded">
                    <input name="search" type="search" placeholder="Search articles"
                        value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}"
                        class="focus:outline-none focus:ring-primary rounded bg-white  px-3 py-1 border-y-0 border-gray-300 rounded-l border-l-4 border-l-primary">
                    <input name="search_type" type="hidden" value="articles"
                        class="focus:outline-none focus:ring-none bg-white  px-3 py-1 rounded-l">
                    <input name="category" type="hidden" value="{{ isset($_GET['category']) ? $_GET['category'] : '' }}"
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
        <div class="mt-8 md:mt-10 w-full space-y-4">
            @if ($articles->count() > 0)
            @foreach ($articles as $article)
                <div class=" cards_wrapper" id="main_section_{{ $article->id }}">
                    <div class="border border-gray-300 rounded card_bg w-full relative">
                        <div class="grid grid-cols-12 pt-8 md:pt-4 p-4 gap-4">
                            <div class="col-span-12 md:col-span-4">
                                <div class="h-48 md:h-60 bg-gray-50 border">
                                    @if ($article->ArticleImage)
                                        <img class="mx-auto h-full w-full object-contain"
                                            src="{{ asset($article->ArticleImage->thumbnail_image) }}" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="col-span-12 md:col-span-8">
                                <div class="flex justify-between items-center">
                                    <div class="can-edu-card-h1 text-primary">
                                        {{ isset($article->articleDetail[0]) ? $article->articleDetail[0]->name : '' }}
                                    </div>
                                    {{-- <button id="{{ $article->id }}"
                                        class="section_{{ $article->id }} delete cursor-pointer border absolute top-0.5 right-4 md:relative border-primary rounded-full w-7 h-7 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-6 h-6 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button> --}}
                                </div>
                                <div class="mt-2 text-gray-500">
                                    <div class="text-ellipsis... overflow-hidden can-edu-p line-clamp-5">
                                        {!! isset($article->articleDetail[0]) ? $article->articleDetail[0]->short_description : '' !!}
                                    </div>
                                    <p class="mt-2 font-bold text-gray-900">
                                        By: 
                                        {{ isset($article->school->schoolDetail[0]->school_name) ? $article->school->schoolDetail[0]->school_name : $article->createdByUser->name }}
                                    </p>
                                </div>
                                <div class="mt-2 text-right can-edu-p">
                                    @php
                                        $url = '#';
                                        if (isset($article->articleDetail[0])) {
                                            $url = url('/' . $defaultLang['abbreviation'] . '/article/' . $article->id . '/' . $article->articleDetail[0]->slug);
                                        }
                                    @endphp
                                    <a href="{{ $url }}" target="_blank"
                                        class="can-edu-btn-fill whitespace-nowrap">Continue
                                        reading</a>
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
            <br />
            {!! $articles->withQueryString()->onEachSide(1)->links('custom_pagination') !!}

        </div>
    @endsection
