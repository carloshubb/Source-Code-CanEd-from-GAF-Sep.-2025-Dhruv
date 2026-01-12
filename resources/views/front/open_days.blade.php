<?php
$defaultLang = getDefaultLanguage(1);
$open_days = App\Models\OpenDay::with([
    'openDayDetail' => function ($q) use ($defaultLang) {
        $q->where('language_code', $defaultLang->abbreviation);
    },
    'school.schoolDetail' => function ($q) use ($defaultLang) {
        // $q->where('language_code', $defaultLang->abbreviation)->limit(1); // Fetch only one schoolDetail per school
        $q->where('language_code', $defaultLang->abbreviation); // Fetch only one schoolDetail per school
    }
])
    ->whereStatus('approved')
    ->where(function ($query) {
        $query->whereDate('date', '>', now()) // Fetch records with future dates
              ->orWhere(function ($subQuery) {
                  $subQuery->whereDate('date', '=', now()) // Allow today's date
                           ->whereTime('time', '>', now()); // Only if time is in the future
              });
    })
    ->addSelect([
        'name_order' => App\Models\OpenDayDetail::whereColumn('open_day_id', 'open_days.id')
            ->limit(1)
            ->select('title'),
    ])
    ->orderBy('name_order')
    ->paginate(10);

    $isLoggedIn = Auth::guard('customers')->check();
    $isLoggedInCust = Auth::guard('customers')->user();
    if($isLoggedIn){
        if($isLoggedInCust->user_type == 'school'){

            
            $schoolRequestTemplate =  url('/' . $defaultLang['abbreviation'] . '/membership-package');
        }else{

            $schoolRequestTemplate =  url('/' . $defaultLang['abbreviation'] . '/' . getPageSlug('school_request_template'));
        }
    }else{

        
        $schoolRequestTemplate =  url('/' . $defaultLang['abbreviation'] . '/' . getPageSlug('school_request_template'));
    }


$loggedInCustomerForblade = Auth::guard('customers')->user();
$showButton = $loggedInCustomerForblade && $loggedInCustomerForblade->user_type === 'school' && $loggedInCustomerForblade->package_price > 0;

$loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
$school_id = isset(Auth::guard('customers')->user()->school->id) ? Auth::guard('customers')->user()->school->id : '';
$OpenDayTranslations = getStaticTranslation('open_houses');
$OpenDayPopupTranslations = getStaticTranslation('open_house_day_popup');
$lang_abbreviation = $defaultLang['abbreviation'];
?>
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full justify-between md:justify-center items-end gap-3">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">{{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : '' }}
            </h1>
        </div>
        {{-- <div class="flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
            <div class="relative md:-mb-5 flex items-center border border-gray-300 rounded">
                <a href="{{ url('/' . $defaultLang['abbreviation'] . '/' . auth()->guard('customers')->user()->slug . '/our-profile/open-house/create') }}">
                    <button class="can-edu-btn-fill">
                        {{ isset($OpenDayTranslations['post_your_open_house_text']) ? $OpenDayTranslations['post_your_open_house_text'] : '' }}
                    </button>
                </a>
            </div>
            </div> --}}
            <div class="flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
                <div class="relative md:-mb-5 flex items-center border border-gray-300 rounded">
                    @if($showButton)
                    <a href="{{ url('/' . $defaultLang['abbreviation'] . '/' . auth()->guard('customers')->user()->slug . '/our-profile/open-house/create') }}">
                        <button class="can-edu-btn-fill">
                            {{ isset($OpenDayTranslations['post_your_open_house_text']) ? $OpenDayTranslations['post_your_open_house_text'] : '' }}
                        </button>
                    </a>
                    @else
                        <button class="can-edu-btn-fill" onclick="showWarningModal()">
                            {{ isset($OpenDayTranslations['post_your_open_house_text']) ? $OpenDayTranslations['post_your_open_house_text'] : '' }}
                        </button>
                    @endif
                </div>
            </div>
            <div id="warningModal" class="hidden bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4">
                <div class="relative w-full h-full max-w-lg flex items-center justify-center">
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl border-4 border-primary/30 text-center relative">
                        <div class="absolute top-3 right-3">
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeWarningModal()">
                                <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-center can-edu-p mt-4">
                            {{ $OpenDayPopupTranslations['feature_availability_text'] ?? '' }} 
                            <a href="{{ $schoolRequestTemplate }}" class="text-primary font-semibold underline">{{ $OpenDayPopupTranslations['click_here_text'] ?? '' }}</a> {{ $OpenDayPopupTranslations['upgrade_membership_text'] ?? '' }}
                        </p>
                        <button type="button" class="can-edu-btn-fill whitespace-nowrap px-5 mt-4" onclick="closeWarningModal()">
                            {{ $OpenDayPopupTranslations['close_button_text'] ?? '' }}
                        </button>
                    </div>
                </div>
            </div>
    </div>
    @if (!empty($page->image))
        <div class="mt-8 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
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
    <div class="mt-16 md:mt-10">
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6 md:mb-10">
            @foreach ($open_days as $open_day)
                <a href="{{ url('/' . $defaultLang['abbreviation'] . '/open-house/' . $open_day->id) }}">
                    <div class="border shadow w-72 md:w-auto mx-auto bg-white p-4 rounded-lg">
                        <div class="h-56 border bg-white">
                            <img class="w-full object-cover h-full" src="{{ asset(thumbnailImage($open_day->image)) }}" alt="">
                        </div>
                        <div class="p-4 text-center">
                            <p class="text-lg font-semibold text-gray-800">
                                {{ $open_day->school->schoolDetail->first()->school_name ?? 'Unknown School' }}
                            </p>
                        </div>
                        <div class="can-edu-btn-fill w-full rounded-none">
                            <p class="text-white truncate text-center">
                                {{ isset($open_day->openDayDetail[0]->title) ? $open_day->openDayDetail[0]->title : '' }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        {!! $open_days->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
    </div>
</div>
</div>
@section('scripts')
<script>
    function showWarningModal() {
    const modal = document.getElementById('warningModal');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.add('show');
    }, 10); 
}

function closeWarningModal() {
    const modal = document.getElementById('warningModal');
    modal.classList.remove('show');

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 1000); 
}

document.addEventListener("click", function (event) {
    let modal = document.getElementById("warningModal");

    if (!modal.classList.contains("hidden") && event.target === modal) {
        closeWarningModal();
    }
});

</script>

@endsection