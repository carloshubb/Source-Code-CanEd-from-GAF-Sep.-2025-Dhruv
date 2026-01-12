    @php
    $defaultLang = getDefaultLanguage(1);
    
    $school_ambassadors = App\Models\SchoolAmbassador::with([
        'schoolAmbassadorDetail' => function ($q) use ($defaultLang) {
            $q = $q->where('language_code', $defaultLang->abbreviation)->orderBy('name', 'asc');
        },'school'
    ]);
    $school_ambassadors = $school_ambassadors->addSelect([
        'name_order' => App\Models\SchoolAmbassadorDetail::whereColumn('school_ambassador_id', 'school_ambassadors.id')
            ->limit(1)
            ->select('name'),
    ]);
    $school_ambassadors = $school_ambassadors->orderBy('name_order')->where('status','active')->paginate(10);
    // dd($school_ambassadors);
    $ambassadorTranslations = getStaticTranslation('ambassadors');
    $ambassadorPopupTranslations = getStaticTranslation('ambassador_popup');
    $lang_abbreviation = $defaultLang['abbreviation'];
    // $loggedInCustomer = Auth::guard('customers')->check() ? Auth::guard('customers')->user()->id : '';
    $loggedInCustomer = Auth::guard('customers')->check() ? Auth::guard('customers')->user() : null;
    // $logged_in_user_type = Auth::guard('customers')->check() ? Auth::guard('customers')->user()->user_type : '';
    $logged_in_user_type = $loggedInCustomer ? $loggedInCustomer->user_type : '';
    $package_price = $loggedInCustomer ? $loggedInCustomer->package_price : 0;
    // dd($logged_in_user_type);
@endphp
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">{{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : '' }}
            </h1>
        </div>
        {{-- <div class="mt-10 flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
                <a href="{{ route('web.account.school.ambassador', ['lang' => app()->getLocale()]) }}" class="can-edu-btn-fill" style="cursor: pointer">
                Add ambasaador
            </a>
        </div> --}}
        <div class="mt-10 flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
            {{-- @if(!$loggedInCustomer || $logged_in_user_type != 'school') --}}
            @if(!$loggedInCustomer || 
        (!in_array($logged_in_user_type, ['school', 'business']) || $package_price <= 0))
                <button type="button" class="can-edu-btn-fill" onclick="showWarningModal()">
                    {{ isset($ambassadorPopupTranslations['add_ambassador_button_text']) ? $ambassadorPopupTranslations['add_ambassador_button_text'] : '' }}
                </button>
            @else
                <a href="{{ route('web.account.school.ambassador', ['lang' => app()->getLocale(), 'slug' => auth()->guard('customers')->user()->slug]) }}" class="can-edu-btn-fill" style="cursor: pointer">
                    {{ isset($ambassadorPopupTranslations['add_ambassador_button_text']) ? $ambassadorPopupTranslations['add_ambassador_button_text'] : '' }}
                </a>
            @endif
        </div>
        <div id="warningModal" class="hidden bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4">
            <div class="relative w-full h-full max-w-lg flex items-center justify-center">
                <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl border-4 border-primary/30 text-center relative">
                    <div class="absolute top-3 right-3" onclick="closeWarningModal()">
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                            <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="text-center can-edu-p mt-4">
                        {{ isset($ambassadorPopupTranslations['feature_availability_text']) ? $ambassadorPopupTranslations['feature_availability_text'] : '' }}
                    </p>
                    <button type="button" class="can-edu-btn-fill whitespace-nowrap px-5 mt-4" onclick="closeWarningModal()">
                        {{ isset($ambassadorPopupTranslations['close_button_text']) ? $ambassadorPopupTranslations['close_button_text'] : '' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @if (!empty($page->image))
        <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
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
    <div class="mt-10 space-y-4">
        <ambassadors-component lang="{{ $lang_abbreviation }}" ambassador_translations="{{$ambassadorTranslations}}" school="" showTitle='0' ambasssadors="{{ $school_ambassadors->getCollection() ? $school_ambassadors->getCollection() : [] }}" />
    </div>
    <br />
    {!! $school_ambassadors->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
</div>
@section('scripts')
<script>
//   function showWarningModal() {
//     console.log(12)
//     document.getElementById('warningModal').classList.remove('hidden');
// }

// function closeWarningModal() {
//     document.getElementById('warningModal').classList.add('hidden');
// }

// document.addEventListener("click", function (event) {
//     let modal = document.getElementById("warningModal");
//     if (!modal.classList.contains("hidden") && event.target === modal) {
//         closeWarningModal();
//     }
// });

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