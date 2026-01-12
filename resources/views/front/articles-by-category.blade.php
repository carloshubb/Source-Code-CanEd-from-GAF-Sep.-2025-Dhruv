@extends('front.layouts.app')
@php
$defaultLang = getDefaultLanguage(1);
@endphp
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-end gap-3 h-14">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">Articles by category</h1>
            </div>
        </div>
        <div class="mt-4 space-y-4">
            @foreach ($articlesByCategories as $articlesByCategory)
                <div class="">
                    <div class="py-2">
                        <div class="mx-auto container px-2">
                            <div class="mx-auto lg:mx-0">
                                <h2 class="heading2 mb-2">
                                    <a
                                        href='{{ url('/' . $defaultLang['abbreviation'] . '/articles?category=' . $articlesByCategory->id) }}'>
                                        {{ isset($articlesByCategory->ArticleCategoryDetail[0]->name)
                                            ? $articlesByCategory->ArticleCategoryDetail[0]->name
                                            : '' }}
                                    </a>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white">
                        <?php
                        $articles = App\Models\Article::with([
                            'articleDetail' => function ($q) use ($defaultLang) {
                                $q = $q->where('language_id', $defaultLang->id);
                            },
                            'ArticleImage',
                            'createdByUser',
                            'updatedByUser',
                        ]);
                        if (isset($articlesByCategory->id)) {
                            $articles->where('article_category', $articlesByCategory->id);
                        }
                        $articles = $articles->addSelect([
                            'name_order' => App\Models\ArticleDetail::where('language_id', $defaultLang->id)
                                ->whereColumn('article_id', 'articles.id')
                                ->limit(1)
                                ->select('name'),
                        ]);
                        
                        $articles = $articles->orderBy('name_order')->get();
                        ?>
                        <div class="mx-auto container px-2">
                            <div
                                class="mx-auto mt-4 grid max-w-2xl grid-cols-2 md:grid-cols-3 2xl:gap-8 gap-4 lg:mx-0 lg:max-w-none lg:grid-cols-4">
                                @foreach ($articlesByCategory->articles as $article)
                                    <article class="flex flex-col items-start justify-between">
                                        <div class="relative w-full">
                                            <img src="/{{ isset($article->ArticleImage->thumbnail_image) ? $article->ArticleImage->thumbnail_image : '' }}"
                                                alt=""
                                                class="rounded-full bg-gray-100 object-cover h-32 md:h-48 lg:h-52 xl:h-64 w-32 md:w-48 lg:w-52 xl:w-64 mx-auto" />
                                        </div>
                                        <div class="w-full max-w-xl">
                                            <div class="group relative py-2 px-2 text-center">
                                                <h3 class="card_heading line-clamp-1 group-hover:text-gray-600">
                                                    <a
                                                        href="{{ url('/' . $defaultLang['abbreviation'] . '/article/' . $article->id . '/' . (isset($article->ArticleDetail[0]->slug) ? $article->ArticleDetail[0]->slug : '')) }}">
                                                        {{ isset($article->ArticleDetail[0]->name) ? $article->ArticleDetail[0]->name : '' }}
                                                    </a>
                                                </h3>
                                                <div class="line-clamp-2 can-edu-card-p leading-5">
                                                    {!! isset($article->ArticleDetail[0]->short_description) ? $article->ArticleDetail[0]->short_description : '' !!}
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
