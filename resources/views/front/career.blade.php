@php
    $defaultLang = getDefaultLanguage(1);
    $careers = App\Models\Career::with([
    'careerDetail' => function ($q) use ($defaultLang) {
    $q = $q->where('language_id', $defaultLang->id);
    },
    ])
        ->where('hot', 0)
        ->addSelect([
            'name_order' => App\Models\CareerDetail::where('language_id', $defaultLang->id)
                ->whereColumn('career_id', 'careers.id')
                ->limit(1)
                ->select('class_name'),
        ])
        ->orderBy('name_order')
        ->paginate(5, ['*'], 'careers_page');
    $hotCareers = App\Models\Career::with([
    'careerDetail' => function ($q) use ($defaultLang) {
    $q = $q->where('language_id', $defaultLang->id);
    },
    ])
        ->where('hot', 1)
        ->addSelect([
            'name_order' => App\Models\CareerDetail::where('language_id', $defaultLang->id)
                ->whereColumn('career_id', 'careers.id')
                ->limit(1)
                ->select('class_name'),
        ])
        ->orderBy('name_order')
        ->paginate(5, ['*'], 'hot_careers_page');

    $careerSetting = App\Models\CareerSetting::with([
    'careerSettingDetail' => function ($q) use ($defaultLang) {
    $q = $q->where('language_id', $defaultLang->id);
    },
    ])->first();

    $articles = App\Models\Article::with([
    'articleDetail' => function ($q) use ($defaultLang) {
    $q = $q->where('language_id', $defaultLang->id);
    },
    'ArticleImage',
    'createdByUser',
    'updatedByUser',
    ])
        ->addSelect([
            'name_order' => App\Models\ArticleDetail::where('language_id', $defaultLang->id)
                ->whereColumn('article_id', 'articles.id')
                ->limit(1)
                ->select('name'),
        ])
        ->whereHas('school.customer.registrationPackage', function($q) {
            $q->where('package_type','featured');
        })
        ->limit(5)
        ->orderBy('name_order')
        ->get();

        $premiumArticles = [];
        if(count($articles) < 5){
            $limit = 5 - count($articles);

            $premiumArticles = App\Models\Article::with([
            'articleDetail' => function ($q) use ($defaultLang) {
            $q = $q->where('language_id', $defaultLang->id);
            },
            'ArticleImage',
            'createdByUser',
            'updatedByUser',
            ])
                ->addSelect([
                    'name_order' => App\Models\ArticleDetail::where('language_id', $defaultLang->id)
                        ->whereColumn('article_id', 'articles.id')
                        ->limit(1)
                        ->select('name'),
                ])
                ->whereHas('school.customer.registrationPackage', function($q) {
                    $q->where('package_type','premium');
                })
                ->limit($limit)
                ->orderBy('name_order')
                ->get();
        }

        $totalArtical = count($articles) + count($premiumArticles);
        $freeArticales = [];
        if($totalArtical < 5){
            $limit = 5 - $totalArtical;

            $freeArticales = App\Models\Article::with([
            'articleDetail' => function ($q) use ($defaultLang) {
            $q = $q->where('language_id', $defaultLang->id);
            },
            'ArticleImage',
            'createdByUser',
            'updatedByUser',
            ])
                ->addSelect([
                    'name_order' => App\Models\ArticleDetail::where('language_id', $defaultLang->id)
                        ->whereColumn('article_id', 'articles.id')
                        ->limit(1)
                        ->select('name'),
                ])
                ->whereNull('school_id')
                ->limit($limit)
                ->orderBy('name_order')
                ->get();
        }

    $careerTranslations = getStaticTranslation('career_page');
    $isLoggedIn = Auth::guard('customers')->check();
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
    $school_id = isset(Auth::guard('customers')->user()->school->id)
        ? Auth::guard('customers')->user()->school->id
        : '';
@endphp
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full justify-between md:justify-center items-end gap-3 mb-6">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                {{ isset($careerSetting->careerSettingDetail[0]) ? $careerSetting->careerSettingDetail[0]->page_title : '' }}
            </h1>
          
        </div>
        <div class="md:-mb-4 flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
            {{-- <a href="{{ route('web.career.create', ['lang' => app()->getLocale()]) }}" class="can-edu-btn-fill" style="cursor: pointer">
                Add Career
            </a> --}}
            <add-career career_modal_translation="{{ $careerTranslations }}"
            position="{{ $defaultLang->position ?? 'rtl' }}" lang="{{ $defaultLang['abbreviation'] }}"
            school_id="{{ $school_id }}" is_logged_id="{{ $isLoggedIn }}"
            logged_in_customer="{{ $loggedInCustomer }}" logged_in_user_type="{{ $data['logged_in_user_type'] }}"></add-career>
        </div>
        <div
        class="flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
        <form action="{{ url('/' . $defaultLang['abbreviation'] . '/career-search') }}">
            <div
                class="relative md:-mb-4 flex items-center border-collapse border border-gray-300 rounded {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-0' : 'border-l-0' }}">
                <input type="search" name="search"
                    placeholder="{{ isset($careerSetting->careerSettingDetail[0]) ? $careerSetting->careerSettingDetail[0]->search_input_placeholder : '' }}"
                    class=" focus:outline-none focus:ring-primary rounded bg-white  px-3 border-y-0 border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-4 rounded-r border-r-primary' : 'border-l-4 rounded-l border-l-primary' }} ">
                <button type="submit" class="bg-gray-100 p-1.5 rounded-r h-full absolute right-0">
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
        <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
            <img class="w-full h-full object-contain mx-auto"
                src="{{ asset(largeImage($page->image)) }}" alt="demetra">
        </div>
    @endif

    @isset($careerSetting->careerSettingDetail[0])
        <div class="can-edu-p">
            <div class="">
                @php
                    // $page_detail = $careerSetting->careerSettingDetail[0]->description;
                    $page_detail = $page->pageDetail[0]->description;
                @endphp
                @include('front.pages.widgets.render-widget-with-detail', [
                    'page_detail' => $page_detail,
                ])
            </div>
        </div>
    @endisset
    
    <div class="mt-16 md:mt-10">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 space-y-4 order-2 md:order-1">
                <div
                    class="py-2 px-3 bg-primary text-white text-center rounded text-xl font-FuturaMdCnBT border border-primary">
                    {{ isset($careerSetting->careerSettingDetail[0]) ? $careerSetting->careerSettingDetail[0]->article_title : '' }}
                </div>
                @foreach($articles as $article)
                    @php
                        $url = '#';
                        if (isset($article->articleDetail[0])) {
                            $url = url('/' . $defaultLang['abbreviation'] . '/article/' . $article->id . '/' . $article->articleDetail[0]->slug);
                        }
                    @endphp
                    <a href="{{ $url }}">
                        <div class="mt-4">
                            <div class="border p-3 md:p-1.5 lg:p-3 border-gray-300 rounded flex gap-2 md:gap-4 xl:gap-4">
                                <div class="flex-initial flex items-start ">
                                    <div class="rounded-full w-24 h-24 border bg-gray-50 overflow-hidden">
                                        @if ($article->ArticleImage)
                                            <img class="w-full h-full mx-auto object-contain rounded-full"
                                                src="{{ asset($article->ArticleImage->thumbnail_image) }}" alt="">
                                        @endif
                                    </div>
                                </div>
                                <div class="w-full text-black flex-auto">
                                    <p class="text-xl leading-6 can-edu-card-h mb-1 line-clamp-2">
                                        {{ isset($article->articleDetail[0]) ? $article->articleDetail[0]->name : '' }}
                                    </p>
                                    <div class="can-edu-card-p line-clamp-2 text_justify">
                                        {!! isset($article->articleDetail[0]) ? $article->articleDetail[0]->short_description : '' !!}
                                    </div>
                                    <p class="mt-1 text-base lg:text-lg font-FuturaMdCnBT line-clamp-1">
                                        By:
                                        {{-- {{ isset($article->school->schoolDetail[0]->school_name) ? $article->school->schoolDetail[0]->school_name : $article->createdByUser->name }} --}}
                                        {{ $article->school->schoolDetail[0]->school_name ?? $article->createdByUser->name ?? 'N/A' }}

                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach

                @foreach($premiumArticles as $article)
                    @php
                        $url = '#';
                        if (isset($article->articleDetail[0])) {
                            $url = url('/' . $defaultLang['abbreviation'] . '/article/' . $article->id . '/' . $article->articleDetail[0]->slug);
                        }
                    @endphp
                    <a href="{{ $url }}">
                        <div class="mt-4">
                            <div class="border p-3 md:p-1.5 lg:p-3 border-gray-300 rounded flex gap-2 md:gap-4 xl:gap-4">
                                <div class="flex-initial flex items-start ">
                                    <div class="rounded-full w-24 h-24 border bg-gray-50 overflow-hidden">
                                        @if ($article->ArticleImage)
                                            <img class="w-full h-full mx-auto object-contain rounded-full"
                                                src="{{ asset($article->ArticleImage->thumbnail_image) }}" alt="">
                                        @endif
                                    </div>
                                </div>
                                <div class="w-full text-black flex-auto">
                                    <p class="text-xl leading-6 can-edu-card-h mb-1 line-clamp-2">
                                        {{ isset($article->articleDetail[0]) ? $article->articleDetail[0]->name : '' }}
                                    </p>
                                    <div class="can-edu-card-p line-clamp-2 text_justify">
                                        {!! isset($article->articleDetail[0]) ? $article->articleDetail[0]->short_description : '' !!}
                                    </div>
                                    <p class="mt-1 text-base lg:text-lg font-FuturaMdCnBT line-clamp-1">
                                        By:
                                        {{-- {{ isset($article->school->schoolDetail[0]->school_name) ? $article->school->schoolDetail[0]->school_name : $article->createdByUser->name }} --}}
                                        {{ $article->school->schoolDetail[0]->school_name ?? $article->createdByUser->name ?? 'N/A' }}

                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach

                @foreach($freeArticales as $article)
                    @php
                        $url = '#';
                        if (isset($article->articleDetail[0])) {
                            $url = url('/' . $defaultLang['abbreviation'] . '/article/' . $article->id . '/' . $article->articleDetail[0]->slug);
                        }
                    @endphp
                    <a href="{{ $url }}">
                        <div class="mt-4">
                            <div class="border p-3 md:p-1.5 lg:p-3 border-gray-300 rounded flex gap-2 md:gap-4 xl:gap-4">
                                <div class="flex-initial flex items-start ">
                                    <div class="rounded-full w-24 h-24 border bg-gray-50 overflow-hidden">
                                        @if ($article->ArticleImage)
                                            <img class="w-full h-full mx-auto object-contain rounded-full"
                                                src="{{ asset($article->ArticleImage->thumbnail_image) }}" alt="">
                                        @endif
                                    </div>
                                </div>
                                <div class="w-full text-black flex-auto">
                                    <p class="text-xl leading-6 can-edu-card-h mb-1 line-clamp-2">
                                        {{ isset($article->articleDetail[0]) ? $article->articleDetail[0]->name : '' }}
                                    </p>
                                    <div class="can-edu-card-p line-clamp-2 text_justify">
                                        {!! isset($article->articleDetail[0]) ? $article->articleDetail[0]->short_description : '' !!}
                                    </div>
                                    <p class="mt-1 text-base lg:text-lg font-FuturaMdCnBT line-clamp-1">
                                        By:
                                        {{-- {{ isset($article->school->schoolDetail[0]->school_name) ? $article->school->schoolDetail[0]->school_name : $article->createdByUser->name }} --}}
                                        {{ $article->school->schoolDetail[0]->school_name ?? $article->createdByUser->name ?? 'N/A' }}

                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="col-span-12 sm:col-span-12 md:col-span-8 lg:col-span-8 md:px-4 order-1 md:order-2">
                <div
                    class="flex flex-col sm:flex-col md:flex-row lg:flex-row justify-center items-center gap-2 md:gap-0 rounded w-full bg-gray-100">
                    @php
                        $activeTabId = 1;
                    @endphp
                    @if (isset($_GET['type']) && $_GET['type'] == 'all')
                        @php
                            $activeTabId = 1;
                        @endphp
                    @elseif (isset($_GET['type']) && $_GET['type'] == 'hot')
                    @php
                        $activeTabId = 2;
                    @endphp
                    @endif
                    <button onclick="showTab(1, 'career')"
                        class="py-2 px-3 w-full whitespace-nowrap bg_white text-gray-800 font-medium text-lg lg:text-xl 2xl:text-2xl font-FuturaMdCnBT rounded-none active:border-t-4 active:border-t-primary active:border-b-0 active:bg-gray-100 border border-gray-300 border-t-4 border-t-primary border-b-0 bg-gray-100" id="career-tab-1">{{ isset($careerSetting->careerSettingDetail[0]) ? $careerSetting->careerSettingDetail[0]->tab_2_title : '' }}</button>

                    <button onclick="showTab(2, 'career')"
                        class="py-2 px-3 w-full whitespace-nowrap bg_white text-gray-800 font-medium text-lg lg:text-xl 2xl:text-2xl font-FuturaMdCnBT rounded-none active:border-t-4 active:border-t-primary active:border-b-0 active:bg-gray-100 border border-gray-300" id="career-tab-2">{{ isset($careerSetting->careerSettingDetail[0]) ? $careerSetting->careerSettingDetail[0]->tab_3_title : '' }}</button>

                    <button onclick="showTab(3, 'career')"
                        class="py-2 px-3 w-full whitespace-nowrap bg_white text-gray-800 font-medium text-lg lg:text-xl 2xl:text-2xl font-FuturaMdCnBT rounded-none active:border-t-4 active:border-t-primary active:border-b-0 active:bg-gray-100 border border-gray-300" id="career-tab-3">{{ isset($careerSetting->careerSettingDetail[0]) ? $careerSetting->careerSettingDetail[0]->tab_1_title : '' }}</button>
                </div>
                <div id="tab-content-3" class="can-edu-p mt-6 hidden">
                    {{-- <p>{{ isset($careerSetting->careerSettingDetail[0]) ? $careerSetting->careerSettingDetail[0]->title : '' }}
                    </p> --}}
                    {!! isset($careerSetting->careerSettingDetail[0]) ? $careerSetting->careerSettingDetail[0]->description : '' !!}
                </div>

                <div id="tab-content-1" class="mt-4 {{isset($activeTabId) && $activeTabId == 1 ? 'block' : 'hidden'}}">
                    <div class="divide-y divide-solid divide-gray-300">
                      @foreach ($careers as $career)
                        <div class="cards_color">
                            <div class="border border-gray-300 rounded card_bg w-full my-4">
                                <div class="grid grid-cols-1 p-4 border-b pb-6">
                                    <div class="grid grid-cols-12">
                                        <div class="col-span-3 font-semibold">
                                        <p>{{ isset($careerTranslations['title_label_text']) ? $careerTranslations['title_label_text'] : '' }}
                                        </p>
                                    </div>
                                    <div class="col-span-8 font-semibold text-black">
                                        <p>{{ isset($career->careerDetail[0]) ? $career->careerDetail[0]->class_name : '' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-12 mt-3">
                                    <div class="col-span-3 font-semibold">
                                        <p>{{ isset($careerTranslations['definition_label_text']) ? $careerTranslations['definition_label_text'] : '' }}
                                        </p>
                                    </div>
                                    <div class="col-span-8 text-black text_justify text-justify md:text-lg">
                                        {!! isset($career->careerDetail[0]) ? $career->careerDetail[0]->class_definition : '' !!}
                                    </div>
                                </div>
                                {{-- <div class="grid grid-cols-12 mt-3">
                                    <div class="col-span-4 md:col-span-3 font-semibold">
                                        <p>{{ isset($careerTranslations['h_structure_label_text']) ? $careerTranslations['h_structure_label_text'] : '' }}
                                        </p>
                                    </div>
                                    <div class="col-span-7 md:col-span-8 text-black">
                                        <p>{{ isset($career->careerDetail[0]) ? $career->careerDetail[0]->h_structure : '' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-12 mt-3">
                                    <div class="col-span-3 font-semibold">
                                        <p>{{ isset($careerTranslations['level_label_text']) ? $careerTranslations['level_label_text'] : '' }}
                                        </p>
                                    </div>
                                    <div class="col-span-8 text-black">
                                        <p>{{ isset($career->careerDetail[0]) ? $career->careerDetail[0]->level : '' }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-12 mt-3">
                                    <div class="col-span-3 font-semibold">
                                        <p>{{ isset($careerTranslations['code_label_text']) ? $careerTranslations['code_label_text'] : '' }}
                                        </p>
                                    </div>
                                    <div class="col-span-8 text-black">
                                        <p>{{ isset($career->careerDetail[0]) ? $career->careerDetail[0]->code : '' }}</p>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>
                    <div class="mt-4">
                        {!! $careers->withQueryString()->onEachSide(1)->links('custom_pagination', ['paginator' => $careers, 'paginationKey' => 'careers_page', 'type' => 'all']) !!}
                    </div>
                </div>

                <div id="tab-content-2" class="mt-4 {{isset($activeTabId) && $activeTabId == 2 ? 'block' : 'hidden'}}">
                  <div class="divide-y divide-solid divide-gray-300">
                    @foreach ($hotCareers as $hotCareer)
                    <div class="cards_color">
                         <div class="border border-gray-300 rounded card_bg w-full my-4">
                            <div class="grid grid-cols-1 p-4 border-b pb-6">
                            <div class="grid grid-cols-12">
                                <div class="col-span-3 font-semibold">
                                    <p>{{ isset($careerTranslations['title_label_text']) ? $careerTranslations['title_label_text'] : '' }}
                                    </p>
                                </div>
                                <div class="col-span-8 font-semibold text-black">
                                    <p>{{ isset($hotCareer->careerDetail[0]) ? $hotCareer->careerDetail[0]->class_name : '' }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-3 font-semibold">
                                    <p>{{ isset($careerTranslations['definition_label_text']) ? $careerTranslations['definition_label_text'] : '' }}
                                    </p>
                                </div>
                                <div class="col-span-8 text-black text_justify text-justify md:text-lg">
                                    <p>
                                        {!! isset($hotCareer->careerDetail[0]) ? $hotCareer->careerDetail[0]->class_definition : '' !!}
                                    </p>
                                </div>
                            </div>
                            {{-- <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-3 font-semibold">
                                    <p>{{ isset($careerTranslations['h_structure_label_text']) ? $careerTranslations['h_structure_label_text'] : '' }}
                                    </p>
                                </div>
                                <div class="col-span-7 md:col-span-8 text-black">
                                    <p>{{ isset($hotCareer->careerDetail[0]) ? $hotCareer->careerDetail[0]->h_structure : '' }}
                                    </p>
                                </div>
                            </div> --}}
                            {{-- <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-3 font-semibold">
                                    <p>{{ isset($careerTranslations['level_label_text']) ? $careerTranslations['level_label_text'] : '' }}
                                    </p>
                                </div>
                                <div class="col-span-8 text-black">
                                    <p>{{ isset($hotCareer->careerDetail[0]) ? $hotCareer->careerDetail[0]->level : '' }}
                                    </p>
                                </div>
                            </div> --}}
                            {{-- <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-3 font-semibold">
                                    <p>{{ isset($careerTranslations['code_label_text']) ? $careerTranslations['code_label_text'] : '' }}
                                    </p>
                                </div>
                                <div class="col-span-8 text-black">
                                    <p>{{ isset($hotCareer->careerDetail[0]) ? $hotCareer->careerDetail[0]->code : '' }}
                                    </p>
                                </div>
                            </div> --}}
                        </div>
                        </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {!! $hotCareers->withQueryString()->onEachSide(1)->links('custom_pagination', ['paginator' => $hotCareers, 'paginationKey' => 'hot_careers_page', 'type' => 'hot']) !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
