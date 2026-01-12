<?php
$defaultLang = getDefaultLanguage(1);
$demetraPageSetting = App\Models\DemetraPageSetting::with([
    'demetraPageSettingDetail' => function ($q) use ($defaultLang) {
        $q = $q->where('language_id', $defaultLang->id);
    },
])->first();

$sports = App\Models\Sport::with([
    'sportDetail' => function ($q) use ($defaultLang) {
        $q = $q->where('language_id', $defaultLang->id);
    },
])->get();

$activities = App\Models\Activity::with([
    'details' => function ($q) use ($defaultLang) {
        $q->where('language_id', $defaultLang->id);
    },
])->where('status', 1)->get();

$languageLearnings = App\Models\LearningLanguage::with([
    'learningLanguageDetail' => function ($q) use ($defaultLang) {
        $q = $q->where('language_id', $defaultLang->id);
    },
])->get();

$comunityServices = App\Models\ComunityService::with([
    'comunityServiceDetail' => function ($q) use ($defaultLang) {
        $q = $q->where('language_id', $defaultLang->id);
    },
])->get();
$isLoggedIn = Auth::guard('customers')->check();
?>
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">{{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : '' }}
            </h1>
        </div>
    </div>
    @if (!empty($page->image))
        <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
            <img class="w-full h-full object-contain mx-auto"
                src="{{ asset(largeImage($page->image)) }}" alt="demetra">
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
    {{-- @if (isset($data['logged_in_user_type']) && $data['logged_in_user_type'] == 'student' && Auth::guard('customers')->user()->package_price > '0') --}}
        <demetra-search logged_in_user_type="{{$data['logged_in_user_type']}}" package_price="{{Auth::guard('customers')->user()->package_price ?? null}}" is_logged_in="{{$isLoggedIn}}" demetra_page_setting="{{ $demetraPageSetting }}" sports="{{$sports}}" comunity_services="{{$comunityServices}}" lang="{{$defaultLang['abbreviation']}}"  activities="{{$activities}}"></demetra-search>
    {{-- @else
        <br />
        <demetra-search logged_in_user_type="{{$data['logged_in_user_type']}}" package_price="{{Auth::guard('customers')->user()->package_price ?? null}}" is_logged_in="{{$isLoggedIn}}" demetra_page_setting="{{ $demetraPageSetting }}" sports="{{$sports}}" comunity_services="{{$comunityServices}}" lang="{{$defaultLang['abbreviation']}}"  activities="{{$activities}}"></demetra-search>
        <p class="text-primary">Only students with paid package can use demetra search</p>
    @endif --}}
</div>
