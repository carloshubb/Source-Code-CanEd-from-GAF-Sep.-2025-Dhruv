@php
    $defaultLang = getDefaultLanguage(1);


    $homePageSettings = App\Models\HomePageSetting::with([
        'homePageSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }
    ])->first();


    $categories = [];

    if(isset($_GET['categorySlug']) && $_GET['categorySlug'] !=""){
        $categories = App\Models\ArticleCategory::with([
            'ArticleCategoryDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
            },
            'ArticleCategoryImage:id,path'
        ])->where('type', $_GET['categorySlug'])->whereNull('parent_id')->get();
    }



    $articles = [];

    $getCategoryDetail = null;
    if(isset($_GET['subCategoryId'])){
        $getCategoryDetail = App\Models\ArticleCategory::with([
            'ArticleCategoryDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
            }
        ])->where('id', $_GET['subCategoryId'])->first();
    }

    if(isset($_GET['subCategoryId']) || isset($_GET['allCategory'])){
        $articles = App\Models\Article::with([
            'articleDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'ArticleImage',
            'createdByUser',
            'updatedByUser',
            'createdByCustomer',
            'school.customer.registrationPackage' 
        ])
        ->addSelect([
            'name_order' => App\Models\ArticleDetail::where('language_id', $defaultLang->id)
                ->whereColumn('article_id', 'articles.id')
                ->limit(1)
                ->select('name'),
        ]);

        if (isset($_GET['subCategoryId'])) {

            $getCategoriesId= [];
            $getCategoriesId = App\Models\ArticleCategory::where('parent_id', $_GET['subCategoryId'])->pluck('id')->toArray();

            array_push($getCategoriesId, $_GET['subCategoryId']);


            $articles->whereIn('article_category', $getCategoriesId);
        }
        if (isset($_GET['sub_category'])) {
            $articles->orWhere('article_category', $_GET['sub_category']);
        }


        $articles = $articles->addSelect([
            'package_type' => \DB::raw('IF(
                articles.customer_id IS NULL, 
                "free", 
                (SELECT IFNULL(rp.package_type, "Default Package Type") 
                 FROM customers c 
                 JOIN registration_packages rp ON c.registration_package_id = rp.id 
                 WHERE c.id = articles.customer_id)
            ) as package_type')
        ]);

        $articles = $articles->orderByRaw("FIELD(package_type, 'featured', 'premium', 'free') ASC");
        $articles = $articles->orderBy('name_order', 'asc')->paginate(12);
        
        

        //dd($articles);
    }


    $packageLabels = [
        'free' => 'More Articles',
        'featured' => 'Featured Articles',
        'premium' => 'Premium Articles',
    ];


    $quoteTranslations = getStaticTranslation('post_article_modal');
    $articlePageSetting = getStaticTranslation('article_page_setting');

    $lang_abbreviation = getDefaultLanguage(1)['abbreviation'];
    $logged_in_user_type = isset($data['logged_in_user_type']) ? $data['logged_in_user_type'] : '';
    $slug = isset(Auth::guard('customers')->user()->slug) ? Auth::guard('customers')->user()->slug : '';
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user() : '';
    $is_package_amount_paid = isset($loggedInCustomer->package_price) ? $loggedInCustomer->package_price : '0';
    $isLoggedIn = Auth::guard('customers')->check();
    $articleAccess='false';
    if($isLoggedIn){
        // count($loggedInCustomer->events);
        if(count($loggedInCustomer->articles) < $loggedInCustomer->registrationPackage->articles){
            $articleAccess='true';
            
        }
        
    }
    // dd($loggedInCustomer->registrationPackage->articles)
@endphp



@if (!isset($_GET['categorySlug']) && !isset($_GET['subCategoryId']) && !isset($_GET['allCategory']))


<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
    <div class="mx-auto container px-2">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">{{ isset($articlePageSetting['article_heading_text']) ? $articlePageSetting['article_heading_text'] : '' }}</h1>
        </div>
        <div class="can-edu-p mt-2">
            <p>{{ isset($articlePageSetting['article_description_text']) ? $articlePageSetting['article_description_text'] : '' }}</p>
        </div>
        <div class="mt-14">
        <div class="mx-auto grid max-w-2xl grid-cols-2 md:grid-cols-3 2xl:gap-8 gap-4 lg:mx-0 lg:max-w-none lg:grid-cols-4">
                    <article
                        class="flex flex-col items-start justify-between"
                    >
                        <div class="relative w-full">
                            <img
                                src="{{!empty($homePageSettings->homePageSettingDetail) && count($homePageSettings->homePageSettingDetail) > 0 ? $homePageSettings->homePageSettingDetail[0]->recent_article_image : ''}}"
                                alt=""
                                class="rounded-full bg-gray-100 object-cover h-32 md:h-48 lg:h-52 xl:h-64 w-32 md:w-48 lg:w-52 xl:w-64 mx-auto"
                            />
                        </div>
                        <div class="max-w-xl w-full">
                            <div class="group relative py-2 px-2 text-center">
                                <h3
                                    class="card_heading line-clamp-1 group-hover:text-gray-600"
                                >
                                    <a href="{{ url(app()->getLocale().'/articles?categorySlug=article') }}">
                                        {{ !empty($homePageSettings->homePageSettingDetail) && count($homePageSettings->homePageSettingDetail) > 0 ? $homePageSettings->homePageSettingDetail[0]->article_card_title : '' }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </article>
                    <article
                        class="flex flex-col items-start justify-between"
                    >
                        <div class="relative w-full">
                            <img
                                src="{{!empty($homePageSettings->homePageSettingDetail) && count($homePageSettings->homePageSettingDetail) > 0 ? $homePageSettings->homePageSettingDetail[0]->recent_video_image : ''}}"
                                alt=""
                                class="rounded-full bg-gray-100 object-cover h-32 md:h-48 lg:h-52 xl:h-64 w-32 md:w-48 lg:w-52 xl:w-64 mx-auto"
                            />
                        </div>
                        <div class="max-w-xl w-full">
                            <div class="group relative py-2 px-2 text-center">
                                <h3
                                    class="card_heading line-clamp-1 group-hover:text-gray-600"
                                >
                                    <a
                                        href="{{ url(app()->getLocale().'/articles?categorySlug=video') }}"
                                    >
                                        {{!empty($homePageSettings->homePageSettingDetail) && count($homePageSettings->homePageSettingDetail) > 0 ? $homePageSettings->homePageSettingDetail[0]->video_card_title : '' }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
        <div class="flex justify-center items-center container mx-auto mt-4">
            <a class="can-edu-btn-fill whitespace-nowrap" href="{{ url(app()->getLocale().'/articles?allCategory=1') }}">
                {{ isset($articlePageSetting['show_all_button_text']) ? $articlePageSetting['show_all_button_text'] : '' }}
            </a>
        </div>
    </div>
@endif

@if (isset($_GET['categorySlug']))
    @if (!empty($categories) && count($categories) > 0)
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="mx-auto container px-2">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">{{ isset($articlePageSetting['article_topic_text']) ? $articlePageSetting['article_topic_text'] : '' }}</h1>
            </div>
            <div class="mt-14">
                <div class="mx-auto mt-4 grid max-w-2xl grid-cols-2 md:grid-cols-3 2xl:gap-8 gap-4 lg:mx-0 lg:max-w-none lg:grid-cols-4">
                    @foreach ($categories as $category)
                    <article class="flex flex-col items-start justify-between">
                        <div class="relative w-full">
                            
                            <img
                                src="/{{ isset($category->ArticleCategoryImage) ? $category->ArticleCategoryImage->path : "" }}"
                                alt=""
                                class="rounded-full bg-gray-100 object-cover h-32 md:h-48 lg:h-52 xl:h-64 w-32 md:w-48 lg:w-52 xl:w-64 mx-auto"
                            />
                        </div>
                        <div class="max-w-xl w-full">
                            <div class="group relative py-2 px-2 text-center">
                                <h3
                                    class="card_heading line-clamp-1 group-hover:text-gray-600"
                                >
                                    <a href="{{ url(app()->getLocale().'/articles?subCategoryId='.$category->id.'') }}">
                                        {{ $category->ArticleCategoryDetail[0]->name }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </article>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
    @else
    @endif
@endif

@if (isset($_GET['subCategoryId']) || isset($_GET['allCategory']))
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full justify-between md:justify-center items-end gap-3 mb-8">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">
                    @if (isset($_GET['allCategory']))
                        All articles
                    @elseif (isset($_GET['subCategoryId']))
                        {{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : '' }} - {{ $getCategoryDetail->ArticleCategoryDetail[0]->name }}
                    @else
                        {{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : '' }}    
                    @endif
                </h1>
            </div>
            <div
                class="flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
                <add-article article_access="{{ $articleAccess }}" lang="{{ $lang_abbreviation }}" slug="{{ $slug }}" logged_in_user_type="{{ $logged_in_user_type }}"
                    is_package_amount_paid="{{ $is_package_amount_paid }}" suggested_article_translations="{{ $quoteTranslations }}" is_logged_id="{{ $isLoggedIn }}">
                    {{-- @php
                    dd($is_package_amount_paid)
                @endphp --}}
                </add-article>
                <form action="{{ route('web.search', ['lang' => $defaultLang['abbreviation']]) }}" method="GET">
                    <div
                        class="relative md:-mb-4 flex items-center border-collapse border border-gray-300 rounded {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-0' : 'border-l-0' }}">
                        <input name="search" type="search" placeholder="Search articles"
                            value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}"
                            class=" focus:outline-none focus:ring-primary rounded bg-white  px-3 border-y-0 border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-4 rounded-r border-r-primary' : 'border-l-4 rounded-l border-l-primary' }} ">
                        <input name="search_type" type="hidden" value="articles"
                            class=" focus:outline-none focus:ring-none bg-white  px-3 py-1 rounded-l">
                        <input name="category" type="hidden"
                            value="{{ isset($_GET['category']) ? $_GET['category'] : '' }}"
                            class=" focus:outline-none focus:ring-none bg-white  px-3 py-1 rounded-l">
                        <button type="submit" class="bg-gray-100 p-1.5 py-2 rounded-r absolute right-0 h-full">
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
        @if (!empty($page->image))
            <div class="mt-8 bg-white h-60 md:h-80 2xl:h-96 border w-full sm:w-2/3 mx-auto rounded mb-5">
                <img class="w-full h-full object-contain mx-auto" src="{{ asset(largeImage($page->image)) }}"
                    alt="">
            </div>
        @endif
        @isset($page->pageDetail[0])
            <div class="can-edu-p mt-4">
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
        <div class="mt-16 md:mt-10 space-y-4">
            @php
                $displayedPackageTypes = [];
            @endphp
            @foreach ($articles as $article)
            @if (!in_array($article->package_type, $displayedPackageTypes))
                    @php
                        $displayedPackageTypes[] = $article->package_type;
                    @endphp
                    <div class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                        <h2 class="normal-case can-edu-h2 mb-0 text-white">
                            {{ $packageLabels[$article->package_type] ?? $article->package_type }}
                        </h2>
                    </div>
                @endif
                @if ($article->package_type == 'featured')
                    <div class="rounded-lg cards_wrapper bg-gradient-to-r from-pink-300 via-red-300 to-yellow-300 p-0.5 mb-4">
                @elseif ($article->package_type == 'premium')
                    <div class="rounded-lg cards_wrapper bg-gradient-to-r from-pink-300 via-red-300 to-yellow-300 p-0.5 mb-4">
                @elseif ($article->package_type == 'free')
                    <div class="bg-gradient-to-r cards_wrapper from-gray-300 via-gray-300 to-gray-300 p-0.5 rounded">
                @else
                    <div class="bg-gradient-to-r cards_wrapper from-gray-300 via-gray-300 to-gray-300 p-0.5 rounded">
                @endif
                    <div class="grid grid-cols-12 p-4 gap-4 card_bg">
                        <div class="col-span-12 md:col-span-4">
                            <div class="relative w-full mx-auto">
                                @if ($article->ArticleImage)
                                    <img class="rounded-full bg-gray-100 object-cover h-32 md:h-48 lg:h-52 xl:h-64 w-32 md:w-48 lg:w-52 xl:w-64 mx-auto" src="{{ asset($article->ArticleImage->thumbnail_image) }}"
                                        alt="">
                                @endif
                            </div>
                        </div>
                        <div class="col-span-12 md:col-span-8">
                            <div class="can-edu-card-h1">
                                {{ isset($article->articleDetail[0]) ? $article->articleDetail[0]->name : '' }}
                            </div>
                            <div class="mt-2 text-gray-500">
                                <div class="text-ellipsis overflow-hidden can-edu-p line-clamp-3">
                                    {!! isset($article->articleDetail[0]) ? $article->articleDetail[0]->short_description : '' !!}
                                </div>
                                <p class="mt-2 text-base text-gray-900">
                                    By:
                                    @if ($article->school)
                                        {{ $article->school->schoolDetail[0]->school_name }}
                                    @elseif ($article->createdByCustomer)
                                        {{ $article->createdByCustomer->first_name }}
                                    @elseif ($article->createdByUser)
                                        @if ($article->name_title)
                                            {{ $article->name_title }}<br>
                                            {{ $article->organization }}<br>
                                            {{ $article->website }}
                                        @else
                                            {{ $article->createdByUser->name }}
                                        @endif
                                    @endif
                                </p>
                            </div>
                            <div class="mt-4 md:mt-2 text-right can-edu-p">
                                @php
                                    $url = '#';
                                    if (isset($article->articleDetail[0])) {
                                        $url = url(
                                            '/' .
                                                $defaultLang['abbreviation'] .
                                                '/article/' .
                                                $article->id .
                                                '/' .
                                                $article->articleDetail[0]->slug,
                                        );
                                    }
                                @endphp
                                <a href="{{ $url }}" class="can-edu-btn-fill whitespace-nowrap">Continue
                                    reading</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <br />
        {!! $articles->withQueryString()->onEachSide(1)->links('custom_pagination') !!}

    </div>    
@endif


<br /> <br /> <br />
