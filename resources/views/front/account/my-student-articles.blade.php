@extends('front.layouts.account')
@php
    $defaultLang = getDefaultLanguage(1);
@endphp
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full">
        <h1 class="px-4 pt-4 can-school-h1">My articles & videos</h1>
        <div class="p-4">
            @if ($articlesWithSchoolId->count() > 0)
                <div class="mt-8 text-center flex justify-between items-center">
                    <a href="{{ route('web.account.article.create', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}" class="flex-grow mx-2">
                        <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                            Create your own article
                        </button>
                    </a>
                </div>

                {{-- <h2 class="text-2xl font-bold mt-6 mb-3">My Articles & Videos</h2> --}}
                @foreach ($articlesWithSchoolId as $article)
                    <div class="grid grid-cols-12 md:grid-cols-12 lg:grid-cols-12 gap-4 p-4 mt-2 border rounded-md shadow">
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
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="md:col-span-8 col-span-12 w-full">
                    <div class="border border-blue-700 rounded-md p-5">
                        <div class="border border-primary rounded p-4">
                            <p>You have not created any articles or videos yet.</p>
                            <p>
                                Start contributing by adding your own articles and sharing knowledge with others!
                            </p>
                        </div>
                    </div>
                    <div class="mt-8 text-center flex justify-between items-center">
                        <a href="{{ route('web.account.article.create', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}" class="flex-grow mx-2">
                            <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                                Create your own article
                            </button>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
