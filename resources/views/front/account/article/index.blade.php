@extends('front.layouts.account')
@php
$defaultLang = getDefaultLanguage(1);
$loggedInCustomer = Auth::guard('customers')->user();
$userType = optional($loggedInCustomer)->user_type;
@endphp
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full">
        <div class="p-4">
        <div class="mb-4 flex justify-between items-center gap-2 p-2">

            @if($userType === 'student')
                <h2 class="can-school-h2 text-primary">My articles & videos</h2>
            @elseif($userType === 'school')
                    <h2 class="can-school-h2 text-primary">Our articles & videos</h2>
            @elseif($userType === 'business')
                <h2 class="can-school-h2 text-primary">Our articles & videos</h2>
            @endif
            <a href="{{ route('web.account.article.create', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white">
                    Create new
                </button>
            </a>
        </div>
        @if (count($articles) > 0)
        <div class="ring-1 ring-gray-300 sm:mx-0 sm:rounded-lg overflow-auto">
            <table class="min-w-full divide-y divide-gray-300 overflow-auto m-0">
                <thead>
                    <tr class="divide-x divide-gray-200">
                        <th scope="col" class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6"> Image </th>
                        <th scope="col" class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6"> Title </th>
                        <th scope="col" class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6"> Short description </th>
                        <th scope="col" class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-3 pr-4 sm:pr-6 text-center text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white lg:table-cell"> Action </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($articles as $article)
                    <tr class="bg-white divide-x divide-gray-200 hover:bg-gray-50">
                        <td>
                            <?php $image = isset($article->ArticleImage->thumbnail_image) ? $article->ArticleImage->thumbnail_image : ''; ?>
                            <img class="w-10 h-10 rounded-full mx-auto" src="{{ asset($image) }}" alt="">
                        </td>
                        <td class="relative py-4 pl-4 pr-3 text-base sm:pl-6 font-medium text-gray-900">
                            {{ isset($article->articleDetail[0]->name) ? $article->articleDetail[0]->name : '' }}
                        </td>
                        <td class="relative py-4 pl-4 pr-3 sm:pl-6"> 
                            {{ isset($article->articleDetail[0]->short_description) ? strip_tags($article->articleDetail[0]->short_description) : '' }}
                        </td>
                        <td class="relative py-3.5 px-3 text-center text-sm font-medium whitespace-nowrap space-x-2">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('web.view.article', ['id' => $article->id,'lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}" 
                                    class="can-edu-btn-fill rounded-full">
                                     View
                                 </a>
                                <a href="{{ route('web.account.article.edit', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug, 'article' => $article->id]) }}" class="can-edu-btn-fill rounded-full">
                                    Edit
                                </a>
                                <article-delete lang="{{ $defaultLang['abbreviation'] }}"
                                    article_id="{{ $article->id }}"></article-delete>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
            <br />
            {!! $articles->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
        @else
            <div class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full bg-[url(/assets/error-bg-image.png)]">
                <div>
                    <img class="mx-auto" src="{{ asset('assets/404.png') }}" alt="">
                </div>
                <div class="space-y-4 flex justify-center items-center flex-col my-10 mx-auto">
                    <h1 class="text-[#014790] text-4xl md:text-5xl xl:text-6xl font-FuturaMdCnBT text-center">Oops</h1>
                    <p class="text-center text-base md:text-lg lg:text-2xl">We are sorry,We are sorry, <br/> but there is no content here yet</p>
                    <div class="pt-4 pb-2">
                        <a href="" class="can-edu-btn-fill rounded-full px-12">BACK TO HOME</a>
                    </div>
                    <p class="text-base md:text-lg lg:text-xl text-gray-500 text-center">Articles not found</p>
                </div>
            </div>
        @endif
        </div>
    </div>
@endsection
