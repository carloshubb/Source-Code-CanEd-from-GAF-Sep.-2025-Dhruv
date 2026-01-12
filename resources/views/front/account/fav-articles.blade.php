@extends('front.layouts.account')
@php
    $defaultLang = getDefaultLanguage(1);
    $loggedInCustomer = Auth::guard('customers')->user();
    $userType = optional($loggedInCustomer)->user_type;
@endphp
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full relative">
        <h1 class="px-4 pt-4 can-school-h1">Favorite articles & videos</h1>
        <div class="p-4">
       
            @if (count($articles) > 0)
                <div class="text-center flex justify-between items-center absolute right-3 top-4">
                    {{-- <a href="{{ url(app()->getLocale().'/articles') }}" class="flex-grow mx-2">
                        <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                            Explore Articles
                        </button>
                    </a> --}}
                    @if($userType !== 'business')
                        <a href="{{ url(app()->getLocale().'/articles') }}" class="">
                            <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-fit">
                                Explore Articles
                            </button>
                        </a>
                    @endif
                    <a href="{{ route('web.account.article.create', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}" class="flex-grow mx-2">
                        <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-fit">
                            Add your own article
                        </button>
                    </a>
                </div>

                {{-- Separate Articles by Type --}}
                @php
                    $userArticles = $articles->where('customer_id', Auth::guard('customers')->user()->id);
                    $favArticles = $articles->whereNotIn('id', $userArticles->pluck('id'));
                @endphp

                {{-- User Created Articles --}}
                @if ($userArticles->count() > 0)
                <div class="mt-6 space-y-4">
                    @foreach ($userArticles as $article)
                    <div class="mt-4 card_bg border border-gray-300 rounded-lg shadow-md px-4 py-4 md:py-2 relative">
                        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                            <div class="w-48 h-48 rounded-lg border bg-gray-200 flex-shrink-0 px-2 mx-auto">
                                <img class="h-full w-full object-contain" src="{{ isset($article->ArticleImage) && isset($article->ArticleImage->thumbnail_image) ? asset($article->ArticleImage->thumbnail_image) : asset('default_image.jpg') }}" alt="">
                            </div>
                            <div class="md:p-4 flex-1">
                                <div>
                                    <p class="text-xl lg:text-2xl font-FuturaMdCnBT">
                                        {{ $article->articleDetail[0]->name ?? '' }}
                                    </p>
                                    <div class="mt-1 text-gray-500 can-edu-card-p line-clamp-5">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Favorite Articles --}}
                @if ($favArticles->count() > 0)
                    <h2 class="text-2xl font-bold mt-6 mb-3">Favorite articles & vidoes</h2>
                    @foreach ($favArticles as $article)
                        <div class="grid grid-cols-12 md:grid-cols-12 lg:grid-cols-12 gap-4 p-4 mt-2 border rounded-md shadow relative">
                            <div class="md:col-span-4 col-span-12">
                                <img class="max-h-60 mx-auto" src="{{ asset($article->ArticleImage->thumbnail_image) }}" alt="">
                            </div>
                            <div class="md:col-span-8 col-span-12">
                                <div>
                                    <p class="text-xl lg:text-2xl font-FuturaMdCnBT">
                                        {{ $article->articleDetail[0]->name ?? '' }}
                                    </p>
                                    <div class="mt-1 text-gray-500 can-edu-card-p line-clamp-5">
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
                                    record_id="{{ $article->id }}" model="article"
                                      />
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            @else
                <div class="md:col-span-8 col-span-12 w-full">
                    <div class="border border-blue-700 rounded-md p-5">
                        <div class="border border-primary rounded p-4">
                            <p>You do not have any Favorite articles or videos yet. </p>
                            <p>
                                Visit our “Articles and videos” page; it has tons of helpful content prepared and submitted by Proxima Study, schools, and fellow students.
                            </p>
                        </div>
                    </div>
                    <div class="mt-8 text-center flex justify-between items-center">
                        @if($userType !== 'business')
                            <a href="{{ url(app()->getLocale().'/articles') }}" class="flex-grow mx-2">
                                <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                                    Explore Articles
                                </button>
                            </a>
                        @endif
                        <a href="{{ route('web.account.article.create', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}" class="flex-grow mx-2">
                            <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                                Add your own article
                            </button>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
