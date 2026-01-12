@extends('front.layouts.account')
@php
    $defaultLang = getDefaultLanguage(1);
@endphp
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full relative">
        <h1 class="px-4 pt-4 can-school-h1">Favorite articles & videos</h1>
        <div class="p-4">
            @if (count($favArticlesQuery) > 0)
                <div class="absolute top-4 right-3">
                    <a href="{{ url(app()->getLocale().'/articles') }}" class="flex-grow mx-2">
                        <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                            Explore Articles
                        </button>
                    </a>
                </div>
                
                {{-- <h2 class="text-2xl font-bold mt-6 mb-3">Favorite Articles & Videos</h2> --}}
                <div class="space-y-4 mt-4">
                @foreach ($favArticlesQuery as $article)
                <div class="mt-4 card_bg border border-gray-300 rounded-lg shadow-md px-4 py-4 md:py-2 relative">
                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                        <div class="w-48 h-48 rounded-lg border bg-gray-200 flex-shrink-0 px-2 mx-auto">
                            <img class="h-full w-full object-contain" src="{{ asset($article->ArticleImage->thumbnail_image) }}" alt="">
                        </div>
                        <div class="md:p-4 flex-1">
                            <div>
                                <p class="text-xl lg:text-2xl font-FuturaMdCnBT">
                                    {{ $article->articleDetail[0]->name ?? '' }}
                                </p>
                                <div class="mt-1 text-gray-500 can-edu-card-p line-clamp-3">
                                    {!! $article->articleDetail[0]->short_description ?? '' !!}
                                </div>
                                @php
                                    $url = isset($article->articleDetail[0]) 
                                        ? url('/'.getDefaultLanguage(1)['abbreviation'].'/article/' . $article->id . '/' . $article->articleDetail[0]->slug) 
                                        : '#';
                                @endphp
                                <div class="mt-4 flex justify-end gap-2">
                                    <a href="{{ $url }}"><button class="can-edu-btn-fill">View</button></a>
                                </div>
                                <remove-fav-icon
                                 {{-- tooltiptext="{{ $favToolTip }}" --}}
                                  record_id="{{ $article->id }}" model="article"
                                    />
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                </div>
            @else
                <div class="md:col-span-8 col-span-12 w-full mt-4">
                    <p>You do not have any favorite articles or videos yet.</p>
                    <p>
                        Visit our "Articles and Videos" page; it has tons of helpful content prepared and submitted by Proxima Study, schools, and fellow students.
                    </p>
                    <div class="absolute top-4 right-3">
                        <a href="{{ url(app()->getLocale().'/articles') }}" class="flex-grow mx-2">
                            <button class="can-edu-btn-fill">Explore articles</button>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
