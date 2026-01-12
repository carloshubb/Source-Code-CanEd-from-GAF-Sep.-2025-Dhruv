<?php
$articles = App\Models\Article::with([
    'articleDetail' => function ($q) use ($defaultLang) {
        $q->where('language_id', $defaultLang->id);
    },
    'ArticleImage',
    'createdByUser',
    'updatedByUser',
])
    ->addSelect([
        'name_order' => App\Models\ArticleDetail::where('language_id', $defaultLang->id)->select('name')
            ->whereColumn('article_id', 'articles.id')
            ->limit(1),
    ])
    ->orderBy('name_order')
    ->limit(8)
    ->get();

?>
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div>
        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 pb-2 border-primary w-full flex items-center justify-between">
                <h1 class="can-edu-h1">
                    {{ isset($page->pageDetail) && count($page->pageDetail) > 0 ? $page->pageDetail[0]->name : '' }}
                </h1>
            </div>

        </div>
        @if (!empty($page->image))
            <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
                <img class="w-full h-full object-contain mx-auto"
                    src="{{ asset(largeImage($page->image)) }}" alt="">
            </div>
        @endif
        @isset($page->pageDetail[0])
        <div class="mt-4 text-justify">
            <div class="">
                @php
                    $page_detail = $page->pageDetail[0]->description;
                @endphp
                @include('front.pages.widgets.render-widget-with-detail', [
                    'page_detail' => $page_detail,
                ])
            </div>
        </div>
        @endisset


        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-4">
                <div class="border-b-4 pb-2 border-primary mt-6">
                    <h2 class="can-edu-h2">
                        {{ isset(getStaticTranslation('general')['help_full_articles_text']) ? getStaticTranslation('general')['help_full_articles_text'] : 'More Articles' }}
                    </h2>
                </div>
                @foreach ($articles as $article)
                    @php
                        $url = '#';
                        if (isset($article->articleDetail[0])) {
                            $url = url('/'.getDefaultLanguage(1)['abbreviation'].'/article/' . $article->id . '/' . $article->articleDetail[0]->slug);
                        }
                    @endphp
                    <a href="{{ $url }}">
                        <div class="mt-4">
                            <div class="border p-3 border-gray-300 rounded flex gap-2 md:gap-4 xl:gap-4">
                                <div class="flex-initial flex items-start ">
                                    <div class="rounded-full w-24 h-24 border bg-gray-50 overflow-hidden">
                                        @if ($article->ArticleImage)
                                            <img class="w-full h-full mx-auto object-contain rounded-full"
                                                src="{{ asset($article->ArticleImage->thumbnail_image) }}" alt="">
                                        @endif
                                    </div>
                                </div>
                                <div class="w-full text-gray-700 flex-auto">
                                    <p class="text-xl leading-6 can-edu-card-h mb-1">
                                        {{ isset($article->articleDetail[0]) ? $article->articleDetail[0]->name : '' }}
                                    </p>
                                    <div class="can-edu-card-p line-clamp-2 text-justify">
                                        {!! isset($article->articleDetail[0]) ? $article->articleDetail[0]->short_description : '' !!}
                                    </div>
                                    <p class="mt-1 text-base lg:text-lg font-FuturaMdCnBT line-clamp-1">
                                        By:
                                        @if ($article->school)
                                            {{ $article->school->schoolDetail[0]->school_name }}
                                        @elseif ($article->createdByUser)
                                            {{ $article->createdByUser->name }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach



            </div>
        </div>
    </div>

</div>
