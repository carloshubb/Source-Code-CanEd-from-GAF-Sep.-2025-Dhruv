@extends('front.layouts.app')
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-8">
                <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
                    <div class="border-b-4 pb-2 border-primary w-full flex items-center justify-between">
                        <h1 class="can-edu-h1">
                            {{ isset($article->articleDetail) && count($article->articleDetail) > 0 ? $article->articleDetail[0]->name : '' }}
                        </h1>
                        <?php
                        $favToolTip = isset(getStaticTranslation('general')['add_to_favorites_text']) ? getStaticTranslation('general')['add_to_favorites_text'] : '';
                        ?>
                        <fav-icon tooltiptext="{{ $favToolTip }}" record_id="{{ $article->id }}" model="article"
                            is_favourit="{{ $favorite }}" />
                    </div>
                </div>
                <div class="mt-4 bg-white h-60 md:h-80 xl:h-96  border rounded">
                    <img class="w-full h-full object-contain mx-auto"
                        src="{{ asset(isset($article->ArticleImage->large_image) > 0 ? $article->ArticleImage->large_image : '') }}"
                        alt="">
                </div>
                <div class="text-black mt-4 text_justify">
                    <p class="text-ellipsis... overflow-hidden can-edu-p">
                        {!! isset($article->articleDetail) && count($article->articleDetail) > 0
                            ? $article->articleDetail[0]->short_description
                            : '' !!}
                    </p>
                    <div class="can-edu-p">
                        <p class="">
                            {!! isset($article->articleDetail) && count($article->articleDetail) > 0
                                ? $article->articleDetail[0]->description
                                : '' !!}
                        </p>
                    </div>
                    <div class="flex justify-end mt-4">
                        @if (isset($article->original_source) && !empty($article->original_source) && $article->original_source != "")
                        @php
                        $sourceURL = filter_var($article->original_source, FILTER_VALIDATE_URL) 
                                     ? $article->original_source 
                                     : 'https://' . ltrim($article->original_source, '/');
                    @endphp
                            <a class="can-edu-btn-fill" href="{{ $sourceURL }}" target="_blank">
                                Read article on original source
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-4 mb-5">
                <div class="border-b-4 pt-1 border-primary">
                    <h2 class="can-edu-h2">
                        {{ isset(getStaticTranslation('general')['more_articles_text']) ? getStaticTranslation('general')['more_articles_text'] : 'More articles' }}
                    </h2>
                </div>
                <div class="mt-4 space-y-4">
                    {{-- @foreach ($articles as $article)
                        @php
                            $url = '#';
                            if (isset($article->articleDetail[0])) {
                                $url = url('/' . getDefaultLanguage(1)['abbreviation'] . '/article/' . $article->id . '/' . $article->articleDetail[0]->slug);
                            }
                        @endphp
                        <div class="">
                            <a href="{{ $url }}">
                                <div class="border p-3 border-gray-300 rounded grid grid-cols-12 gap-4">
                                    <div
                                        class="col-span-4 h-24 sm:col-span-4 md:col-span-4 lg:col-span-4 flex items-center border bg-gray-50">
                                        <img class="w-full h-full mx-auto object-contain"
                                            src="{{ asset($article->ArticleImage->thumbnail_image) }}" alt="">
                                    </div>
                                    <div class="w-full text-gray-700 col-span-8 sm:col-span-8 md:col-span-8 lg:col-span-8">
                                        <div class="can-edu-card-h mb-1 line-clamp-1 md:line-clamp-none">
                                            {{ isset($article->articleDetail[0]) ? $article->articleDetail[0]->name : '' }}
                                        </div>
                                        <div class="can-edu-card-p line-clamp-3 text-justify">
                                            {!! isset($article->articleDetail[0]) ? $article->articleDetail[0]->short_description : '' !!}
                                        </div>
                                        <p class="mt-1 font-semibold text-sm lg:text-base">
                                            By:
                                            {{ isset($article->school->schoolDetail[0]->school_name) ? $article->school->schoolDetail[0]->school_name : $article->createdByUser->name }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach --}}
                    @foreach ($featuredArticles as $moreArticle)
                        @if ($moreArticle->id !== $article->id)
                            @php
                                $url = '#';
                                if (isset($moreArticle->articleDetail[0])) {
                                    $url = url(
                                        '/' .
                                            getDefaultLanguage(1)['abbreviation'] .
                                            '/article/' .
                                            $moreArticle->id .
                                            '/' .
                                            $moreArticle->articleDetail[0]->slug,
                                    );
                                }
                            @endphp
                            <div class="">
                                <a href="{{ $url }}">
                                    <div class="border p-3 border-gray-300 rounded flex gap-2 md:gap-4 lg:gap-2 xl:gap-4">
                                        <div class="flex-initial flex items-start ">
                                            <div class="rounded-full w-24 h-24 border bg-gray-50 overflow-hidden">
                                              <img class="w-full h-full mx-auto object-contain rounded-full"
                                                src="{{ asset($moreArticle->ArticleImage?->thumbnail_image) }}"
                                                alt="">
                                            </div>
                                        </div>
                                        <div
                                            class="w-full text-black flex-auto">
                                            <div class="text-xl leading-6 can-edu-card-h mb-1 line-clamp-1 md:line-clamp-none">
                                                {{ isset($moreArticle->articleDetail[0]) ? $moreArticle->articleDetail[0]->name : '' }}
                                            </div>
                                            <div class="can-edu-card-p line-clamp-2 text-justify">
                                                {!! isset($moreArticle->articleDetail[0]) ? $moreArticle->articleDetail[0]->short_description : '' !!}
                                            </div>
                                            <p class="mt-1 text-base lg:text-lg font-FuturaMdCnBT line-clamp-1">
                                                By:
                                                {{-- {{ isset($moreArticle->school->schoolDetail[0]->school_name) ? $moreArticle->school->schoolDetail[0]->school_name : $moreArticle->createdByUser->name }} --}}
                                                {{ isset($moreArticle->school->schoolDetail[0]) 
                                                    ? $moreArticle->school->schoolDetail[0]->school_name 
                                                    : optional($moreArticle->createdByUser)->name 
                                                }}
                                                
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach

                    @foreach ($premiumArticles as $moreArticle)
                        @if ($moreArticle->id !== $article->id)
                            @php
                                $url = '#';
                                if (isset($moreArticle->articleDetail[0])) {
                                    $url = url(
                                        '/' .
                                            getDefaultLanguage(1)['abbreviation'] .
                                            '/article/' .
                                            $moreArticle->id .
                                            '/' .
                                            $moreArticle->articleDetail[0]->slug,
                                    );
                                }
                            @endphp
                            <div class="">
                                <a href="{{ $url }}">
                                    <div class="border p-3 border-gray-300 rounded flex gap-2 md:gap-4 lg:gap-2 xl:gap-4">
                                        <div class="flex-initial flex items-start ">
                                            <div class="rounded-full w-24 h-24 border bg-gray-50 overflow-hidden">
                                              <img class="w-full h-full mx-auto object-contain rounded-full"
                                                src="{{ asset($moreArticle->ArticleImage?->thumbnail_image) }}"
                                                alt="">
                                            </div>
                                        </div>
                                        <div
                                            class="w-full text-black flex-auto">
                                            <div class="text-xl leading-6 can-edu-card-h mb-1 line-clamp-1 md:line-clamp-none">
                                                {{ isset($moreArticle->articleDetail[0]) ? $moreArticle->articleDetail[0]->name : '' }}
                                            </div>
                                            <div class="can-edu-card-p line-clamp-2 text-justify">
                                                {!! isset($moreArticle->articleDetail[0]) ? $moreArticle->articleDetail[0]->short_description : '' !!}
                                            </div>
                                            <p class="mt-1 text-base lg:text-lg font-FuturaMdCnBT line-clamp-1">
                                                By:
                                                {{-- {{ isset($moreArticle->school->schoolDetail[0]->school_name) ? $moreArticle->school->schoolDetail[0]->school_name : $moreArticle->createdByUser->name }} --}}
                                                {{ isset($moreArticle->school->schoolDetail[0]) 
                                                    ? $moreArticle->school->schoolDetail[0]->school_name 
                                                    : optional($moreArticle->createdByUser)->name 
                                                }}
                                                
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach

                    @foreach ($freeArticles as $moreArticle)
                        @if ($moreArticle->id !== $article->id)
                            @php
                                $url = '#';
                                if (isset($moreArticle->articleDetail[0])) {
                                    $url = url(
                                        '/' .
                                            getDefaultLanguage(1)['abbreviation'] .
                                            '/article/' .
                                            $moreArticle->id .
                                            '/' .
                                            $moreArticle->articleDetail[0]->slug,
                                    );
                                }
                            @endphp
                            <div class="">
                                <a href="{{ $url }}">
                                    <div class="border p-3 border-gray-300 rounded flex gap-2 md:gap-4 lg:gap-2 xl:gap-4">
                                        <div class="flex-initial flex items-start ">
                                            <div class="rounded-full w-24 h-24 border bg-gray-50 overflow-hidden">
                                              <img class="w-full h-full mx-auto object-contain rounded-full"
                                                src="{{ asset($moreArticle->ArticleImage?->thumbnail_image) }}"
                                                alt="">
                                            </div>
                                        </div>
                                        <div
                                            class="w-full text-black flex-auto">
                                            <div class="text-xl leading-6 can-edu-card-h mb-1 line-clamp-1 md:line-clamp-none">
                                                {{ isset($moreArticle->articleDetail[0]) ? $moreArticle->articleDetail[0]->name : '' }}
                                            </div>
                                            <div class="can-edu-card-p line-clamp-2 text-justify">
                                                {!! isset($moreArticle->articleDetail[0]) ? $moreArticle->articleDetail[0]->short_description : '' !!}
                                            </div>
                                            <p class="mt-1 text-base lg:text-lg font-FuturaMdCnBT line-clamp-1">
                                                By:
                                                {{-- {{ isset($moreArticle->school->schoolDetail[0]->school_name) ? $moreArticle->school->schoolDetail[0]->school_name : $moreArticle->createdByUser->name }} --}}
                                                {{ isset($moreArticle->school->schoolDetail[0]) 
                                                    ? $moreArticle->school->schoolDetail[0]->school_name 
                                                    : optional($moreArticle->createdByUser)->name 
                                                }}
                                                
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach


                </div>
            </div>
        </div>

    </div>
@endsection
