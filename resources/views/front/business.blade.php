<?php
$defaultLang = getDefaultLanguage(1);
$businessTranslations = getStaticTranslation('businesses');
$businesCategories = App\Models\BusinessCategory::with([
    'businessCategoryDetail' => function ($q) use ($defaultLang) {
        $q->where('language_id', $defaultLang->id);
    },
    'BusinessCategoryImage',
])
    ->addSelect([
        'name_order' => App\Models\BusinessCategoryDetail::whereColumn('business_category_id', 'business_categories.id')
            ->where('language_id', $defaultLang->id)
            ->limit(1)
            ->select('name'),
    ])
    ->orderBy('name_order');
if (request('search')) {
    $businesCategories = $businesCategories->whereHas('businessCategoryDetail', function ($q) use ($defaultLang) {
        $q->where('language_id', $defaultLang->id)->where('name', 'Like', '%' . request('search') . '%');
    });
}
$businesCategories = $businesCategories->get();
?>
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full justify-between md:justify-center items-end gap-3 mb-8">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">{{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : '' }}
            </h1>
        </div>
        <div
          class="flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
        <div class="relative md:-mb-4 flex items-center border border-gray-300 rounded">
            <a href="{{ url('/' . $defaultLang['abbreviation'] . '/register-business') }}" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5">{{ $businessTranslations['register_business_button_text'] ?? '' }}</a>
        </div>
        <form action="{{ route('web.search', ['lang' => $defaultLang['abbreviation'], 'search_type' => 'business']) }}" method="GET">
            <div class="relative md:-mb-4 flex items-center border-collapse border-l-0 border border-gray-300 rounded">
                <input name="search" type="search"
                 {{-- placeholder="Search {{$businessCategory->businessCategoryDetail[0]->name ?? 'Businesses'}}" --}}
                 placeholder=" {{ $businessTranslations['register_business_search_placeholder_text'] ?? '' }}"
                    value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}"
                    class="focus:outline-none focus:ring-primary rounded bg-white  px-3 py-2 border-y-0 border-gray-300 rounded-l border-l-4 border-l-primary">
                <input name="search_type" type="hidden" value="business"
                    class=" focus:outline-none focus:ring-none bg-white  px-3 py-1 rounded-l">
                <button type="submit" class="bg-gray-100 p-1.5 h-full rounded-r absolute right-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </button>
            </div>
        </form>
        {{-- <div class="relative md:mt-16 flex items-center border-collapse border-l-0 border border-gray-300 rounded">
            <input type="search" placeholder="Search schools"
                class="focus:outline-none focus:ring-primary bg-white rounded px-3 py-1 border-y-0 border-gray-300 rounded-l border-l-4 border-l-primary">
            <button class="bg-gray-100 p-1.5 rounded-r border-l border-gray-300 h-full absolute right-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </button>
        </div> --}}
    </div>
    </div>
    @if (!empty($page->image))
        <div class="mt-8 bg-white h-60 md:h-80 2xl:h-96 border w-full sm:w-2/3 mx-auto rounded mb-5">
            <img class="w-full h-full object-contain mx-auto"
                src="{{ asset(largeImage($page->image)) }}" alt="">
        </div>
    @endif
    @isset($page->pageDetail[0])
    <div class="can-edu-p mt-2">
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


    <div class="mt-14">

        <div class="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6 md:mb-10">
            @if ($businesCategories->count() > 0)
            @foreach ($businesCategories as $businesCategory)
                <?php $slug = isset($businesCategory->businessCategoryDetail[0]->slug) ? $businesCategory->businessCategoryDetail[0]->slug : ''; ?>
                <a
                    href="{{ url('/' . $defaultLang['abbreviation'] . '/busines-categories/' . $businesCategory->id . '/' . $slug) }}">
                    <div class="border shadow w-64 md:w-auto mx-auto h-full relative pb-[2.8rem]">
                        <div class="h-48 border bg-white flex items-center justify-center">
                            <img class="w-full object-contain h-40"
                                src="{{ asset(isset($businesCategory->BusinessCategoryImage->thumbnail_image) ? $businesCategory->BusinessCategoryImage->thumbnail_image : '') }}"
                                alt="">
                        </div>
                        <p class="text-base line-clamp-2 text-left px-2 text-ellipsis">
                            {{ isset($businesCategory->businessCategoryDetail[0]->description) ? $businesCategory->businessCategoryDetail[0]->description : '' }}
                        </p>
                        <div class="can-edu-btn-fill rounded-none w-full absolute h-12 bottom-0">
                            <p class="text-white truncate text-center">
                                {{ isset($businesCategory->businessCategoryDetail[0]->name) ? $businesCategory->businessCategoryDetail[0]->name : '' }}
                            </p>
                        </div>
                          
                    </div>
                </a>
            @endforeach
            @else
            <div class="text-center text-black text-lg mt-10">
                {{-- <p>Sorry, your search yielded no results.</p>
                <p>Please double-check your spelling and try different variations of your keywords or key phrases.</p> --}}
                <p>{{ getStaticTranslation('general')['search_yield_error_text'] ?? '' }}</p>
            </div>
        @endif
        </div>
        {{-- {!! $businesCategories->withQueryString()->onEachSide(1)->links('custom_pagination') !!} --}}
    </div>

</div>
