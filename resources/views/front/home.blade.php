@php
    $defaultLang = getDefaultLanguage(1);
    $homePageSettings = App\Models\HomePageSetting::with([
        'homePageSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
        'banner1',
        'banner1.BannerDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
        'banner1.Image1',
        'banner1.Image2',
        'banner2',
        'banner2.BannerDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
        'banner2.Image1',
        'banner2.Image2',
    
        'banner3',
        'banner3.BannerDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
        'banner3.Image1',
        'banner3.Image2',
    ])->first();
    
    $degrees = App\Models\Degree::with([
        'degreeDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
        'degreeImage',
    ])
        ->orderBy('order')
        ->get();
    
    $articles = App\Models\Article::with([
        'articleDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
        'ArticleImage',
        'createdByUser',
        'updatedByUser',
    ])
        ->addSelect([
            'name_order' => App\Models\ArticleDetail::where('language_id', $defaultLang->id)->whereColumn('article_id', 'articles.id')
                ->limit(1)
                ->select('name'),
        ])
        ->limit(8)
        ->orderBy('name_order')
        ->get();
    
    $sectionArticles1 = [];
    $sectionArticleCategories1 = [];
    if (isset($homePageSettings->article_section_1_category_id)) {
        $sectionArticleCategories1 = App\Models\ArticleCategory::with([
            'ArticleCategoryDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'ArticleCategoryImage',
        ])
            ->where('parent_id', $homePageSettings->article_section_1_category_id)
            ->addSelect([
                'name_order' => App\Models\ArticleCategoryDetail::whereColumn('article_category_id', 'article_categories.id')
                    ->limit(1)
                    ->select('name'),
            ])
            ->limit(8)
            ->orderBy('name_order')
            ->get();
        $sectionArticles1 = App\Models\Article::with([
            'articleDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'ArticleImage',
            'createdByUser',
            'updatedByUser',
        ])
            ->where('article_category', $homePageSettings->article_section_1_category_id)
            ->addSelect([
                'name_order' => App\Models\ArticleDetail::where('language_id', $defaultLang->id)->whereColumn('article_id', 'articles.id')
                    ->limit(1)
                    ->select('name'),
            ])
            ->limit(8)
            ->orderBy('name_order')
            ->get();
    }
    $sectionArticles2 = [];
    $sectionArticleCategories2 = [];
    if (isset($homePageSettings->article_section_2_category_id)) {
        $sectionArticleCategories2 = App\Models\ArticleCategory::with([
            'ArticleCategoryDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'ArticleCategoryImage',
        ])
            ->where('parent_id', $homePageSettings->article_section_2_category_id)
            ->addSelect([
                'name_order' => App\Models\ArticleCategoryDetail::whereColumn('article_category_id', 'article_categories.id')
                    ->limit(1)
                    ->select('name'),
            ])
            ->limit(8)
            ->orderBy('name_order')
            ->get();
        $sectionArticles2 = App\Models\Article::with([
            'articleDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'ArticleImage',
            'createdByUser',
            'updatedByUser',
        ])
            ->where('article_category', $homePageSettings->article_section_2_category_id)
            ->addSelect([
                'name_order' => App\Models\ArticleDetail::where('language_id', $defaultLang->id)->whereColumn('article_id', 'articles.id')
                    ->limit(1)
                    ->select('name'),
            ])
            ->limit(8)
            ->orderBy('name_order')
            ->get();
    }
    
    $sectionArticles3 = [];
    $sectionArticleCategories3 = [];
    
    if (isset($homePageSettings->article_section_2_category_id)) {
        $sectionArticleCategories3 = App\Models\ArticleCategory::with([
            'ArticleCategoryDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'ArticleCategoryImage',
        ])
            ->where('parent_id', $homePageSettings->article_section_3_category_id)
            ->addSelect([
                'name_order' => App\Models\ArticleCategoryDetail::whereColumn('article_category_id', 'article_categories.id')
                    ->limit(1)
                    ->select('name'),
            ])
            ->limit(8)
            ->orderBy('name_order')
            ->get();
        $sectionArticles3 = App\Models\Article::with([
            'articleDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
            'ArticleImage',
            'createdByUser',
            'updatedByUser',
        ])
            ->where('article_category', $homePageSettings->article_section_3_category_id)
            ->addSelect([
                'name_order' => App\Models\ArticleDetail::where('language_id', $defaultLang->id)->whereColumn('article_id', 'articles.id')
                    ->limit(1)
                    ->select('name'),
            ])
            ->limit(8)
            ->orderBy('name_order')
            ->get();
    }
    
    $schools = App\Models\School::with([
        'schoolDetail' => function ($q) use ($defaultLang) {
            $q->where('language_code', $defaultLang->abbreviation);
        },
        'customer',
        'customer.registrationPackage',
    ])
        ->where('deactive_account', 0)
        ->whereHas('customer', function ($query) {
            $query->whereHas('registrationPackage', function ($q) {
                $q->where('package_type', 'featured');
            });
        })
        ->addSelect([
            'name_order' => App\Models\SchoolDetail::whereColumn('school_id', 'schools.id')
                ->limit(1)
                ->select('school_name'),
        ])
        ->orderBy('name_order')
        ->limit(8)
        ->get();


    $businesses = App\Models\Business::with([
            'businessDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        $businesses = $businesses->where('deactive_account', 0);

        $businesses = $businesses->addSelect([
            'name_order' => App\Models\BusinessDetail::where('language_id', $defaultLang->id)
                ->whereColumn('business_id', 'businesses.id')
                ->limit(1)
                ->select('business_name'),
        ])
        ->whereHas('customer', function ($query) {
            $query->whereHas('registrationPackage', function ($q) {
                $q->where('package_type', 'featured');
            });
        });
        $businesses = $businesses
            ->where('deactive_account', 0)
            ->orderBy('name_order')->inRandomOrder()->take(8)->get();

    $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
@endphp
<div class="backdrop-blur-sm bg-black bg-cover bg-center flex items-center justify-center h-96 md:h-[500px] w-full"
    style="background-image: url({{asset(largeImage($data['home_page_banner']))}})">
    <div class="container mx-auto px-4 lg:w-3/5 w-full">
        <form method="GET" action="{{ route('web.search', ['lang' => $defaultLang['abbreviation']]) }}">
            <div
                class="bg-white bg-opacity-60 rounded p-2 flex flex-col sm:flex-col md:flex-row lg:flex-row justify-between items-start divide-y">
                <div class="w-full md:w-2/3 flex items-center">
                    <input type="search" name="search"
                        class="w-full py-2.5 px-3 rounded-l lg:text-lg focus:outline-none focus:ring-primary border border-gray-300"
                        placeholder="{{ isset(getGeneralTranslation()['advance_search_input_text']) ? getGeneralTranslation()['advance_search_input_text'] : 'Search ...' }}" />
                    <button class="bg-white border border-l-0 p-2 text-gray-500 md:hidden ">
                        <img class="w-9 h-7 object-contain" src="{{ asset('./images/searchicon.png')}}" alt="search icon">
                    </button>
                </div>
                <div class="w-full md:w-1/3  border border-gray-300">
                    <select id="search_type" name="search_type"
                        class="w-full pt-2.5 pb-[11px] px-3 lg:text-lg border-none focus:outline-none focus:ring-primary"
                        style="max-width: 100%;">
                        <option value="school">{{ isset(getGeneralTranslation()['advance_search_school_item_text']) ? getGeneralTranslation()['advance_search_school_item_text'] : 'Search ...' }}</option>
                        <option value="business">{{ isset(getGeneralTranslation()['advance_search_business_item_text']) ? getGeneralTranslation()['advance_search_business_item_text'] : 'Search ...' }}</option>
                        <option value="programs">{{ isset(getGeneralTranslation()['advance_search_program_item_text']) ? getGeneralTranslation()['advance_search_program_item_text'] : 'Search ...' }}</option>
                        <option value="articles">{{ isset(getGeneralTranslation()['advance_search_article_item_text']) ? getGeneralTranslation()['advance_search_article_item_text'] : 'Search ...' }}</option>
                        <option value="scholarship">{{ isset(getGeneralTranslation()['advance_search_scholarship_item_text']) ? getGeneralTranslation()['advance_search_scholarship_item_text'] : 'Search ...' }}</option>
                    </select>
                </div>
                <button class="bg-white p-2 lg:p-2.5 rounded-r md:pb-[9px] lg:pb-[11px] px-4 text-gray-500 border border-gray-300 hidden md:block">
                    <img class="w-9 h-7 object-contain" src="{{ asset('./images/searchicon.png')}}" alt="search icon">
                </button>
            </div>
            <div class="flex justify-center mt-4">
                <div class="bg-white rounded p-2 bg-opacity-40">
                    <a href="{{ route('web.school.advance.search', ['lang' => $defaultLang['abbreviation']]) }}">
                        <button class="can-edu-btn-fill">
                        {{ isset(getGeneralTranslation()['advance_search_button_text']) ? getGeneralTranslation()['advance_search_button_text'] : 'Advanced Search' }}
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<school-category-section lang="{{ $defaultLang['abbreviation'] }}"
    degrees='{{ $degrees }}'></school-category-section>
<div class="bg-white">
    <school-category-section-mobile lang="{{ $defaultLang['abbreviation'] }}" degrees='{{ $degrees }}'></school-category-section-mobile>
    <proxima-study-section lang="{{ $defaultLang['abbreviation'] }}" home_page_settings='{{ $homePageSettings }}'></proxima-study-section>
    <div class="container mx-auto mt-14">
        <feetured-school-section lang="{{ $defaultLang['abbreviation'] }}" schools='{{ $schools }}' home_page_settings='{{ $homePageSettings }}'>
        </feetured-school-section>
        <feetured-business-section lang="{{ $defaultLang['abbreviation'] }}" businesses='{{ $businesses }}' home_page_settings='{{ $homePageSettings }}'>
        </feetured-business-section>
        <financial-help lang="{{ $defaultLang['abbreviation'] }}" article_categories="{{ $sectionArticleCategories1 }}" articles="{{ $sectionArticles1 }}"
            home_page_settings='{{ $homePageSettings }}'>
        </financial-help>
        <banner-one-section lang="{{ $defaultLang['abbreviation'] }}" position="{{ $position }}"
            home_page_settings='{{ $homePageSettings }}'></banner-one-section>
        <work-while-study lang="{{ $defaultLang['abbreviation'] }}" article_categories="{{ $sectionArticleCategories2 }}" articles="{{ $sectionArticles2 }}"
            home_page_settings='{{ $homePageSettings }}'>
        </work-while-study>
        <banner-two-section lang="{{ $defaultLang['abbreviation'] }}" position="{{ $position }}"
            home_page_settings='{{ $homePageSettings }}'></banner-two-section>
        <proxima-study-section-two lang="{{ $defaultLang['abbreviation'] }}" article_categories="{{ $sectionArticleCategories3 }}"
            articles="{{ $sectionArticles3 }}" home_page_settings='{{ $homePageSettings }}'>
        </proxima-study-section-two>
        <recent-article-section lang="{{ $defaultLang['abbreviation'] }}" articles="{{ $articles }}" home_page_settings='{{ $homePageSettings }}'>
        </recent-article-section>
        <banner-three-section lang="{{ $defaultLang['abbreviation'] }}" position="{{ $position }}"
            home_page_settings='{{ $homePageSettings }}'></banner-three-section>
    </div>
</div>
