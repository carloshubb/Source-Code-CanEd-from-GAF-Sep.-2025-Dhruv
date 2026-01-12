@php
    $defaultLang = getDefaultLanguage(1);
    $scholarships = App\Models\SchoolScholarship::with([
        'schoolScholarshipDetail' => function ($q) use ($defaultLang) {
            $q->where('language_code', $defaultLang->abbreviation);
        },
        'school',
        'school.schoolDetail' => function ($q) use ($defaultLang) {
            $q->where('language_code', $defaultLang->abbreviation);
        },
    ]);
    $scholarships = $scholarships->addSelect([
        'name_order' => App\Models\SchoolScholarshipDetail::where('language_code', $defaultLang->abbreviation)
            ->whereColumn('school_scholarship_id', 'school_scholarships.id')
            ->limit(1)
            ->select('name'),
    ]);
    $scholarships = $scholarships->orderBy('name_order')->paginate(10);
    $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
    $scholarshipTranslations = getStaticTranslation('scholarships');
    $scholarshipPopupTranslations = getStaticTranslation('scholarship_popup');
    // dd($scholarshipTranslations);
    $scholarshipModalTranslations = getStaticTranslation('scholarship_modal');
    $lang_abbreviation = $defaultLang['abbreviation'];
    $loggedInCustomer = Auth::guard('customers')->check() ? Auth::guard('customers')->user()->id : '';
    $logged_in_user_type = Auth::guard('customers')->check() ? Auth::guard('customers')->user()->user_type : '';
@endphp
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div
        class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full justify-between md:justify-center items-end gap-3 mb-8">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">{{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : '' }}
            </h1>
        </div>
        <div
            class="md:-mb-4 flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
            <scholarship-advanced-search lang="{{ $lang_abbreviation }}"
                scholarship_advance_search_translation="{{ $scholarshipModalTranslations }}"
                position="{{ $position }}"></scholarship-advanced-search>
                <div class="flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
                    @if(!$loggedInCustomer || $logged_in_user_type != 'school')
                        {{-- <a href="#" class="can-edu-btn-fill" style="cursor: pointer" onclick="showWarningModal()">
                            Add Scholarship
                        </a> --}}
                        <button type="button" class="can-edu-btn-fill" style="cursor: pointer" onclick="showWarningModal()">
                            {{ isset($scholarshipTranslations['add_scholarship_button_text']) ? $scholarshipTranslations['add_scholarship_button_text'] : '' }}
                        </button>
                    @else
                    <a href="{{ route('web.account.school.scholarship', ['lang' => app()->getLocale(), 'slug' => auth()->guard('customers')->user()->slug]) }}" 
                        class="can-edu-btn-fill" style="cursor: pointer">
                        {{ isset($scholarshipTranslations['add_scholarship_button_text']) ? $scholarshipTranslations['add_scholarship_button_text'] : '' }}
                        </a>
                    @endif
                </div>
                <transition name="slide">
                    <div id="defaultModal" tabindex="-1" aria-hidden="true"
                        class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full hidden"
                        onclick="hideWarningModal()">
                        <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                            onclick="event.stopPropagation()">
                            <div class="relative">
                                <div class="absolute top-3 right-3 cursor-pointer">
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center"
                                        onclick="hideWarningModal()">
                                        <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10">
                                    <p class="text-center can-edu-p mt-2" id="popupMessage"></p>
                                    <div class="flex justify-center">
                                        <button type="button" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4"
                                            onclick="hideWarningModal()">
                                            {{ $scholarshipPopupTranslations['close_button_text'] ?? '' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
             

            <form action="{{ route('web.search', ['lang' => $defaultLang['abbreviation']]) }}" method="GET">
                <div
                    class="relative flex items-center border-collapse border border-gray-300 rounded {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-0' : 'border-l-0' }}">
                    <input name="search" type="search" placeholder="Search scholarships"
                        value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}"
                        class=" focus:outline-none focus:ring-primary rounded bg-white  px-3 border-y-0 border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-4 rounded-r border-r-primary' : 'border-l-4 rounded-l border-l-primary' }} ">
                    <input name="search_type" type="hidden" value="scholarship"
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


    <div class="mt-10 space-y-4">
        @foreach ($scholarships as $scholarship)
                    {{-- @php
                        function formatUrl($url) {
                            return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
                        }
                    @endphp --}}
            <div class="card_bg grid grid-cols-1 p-4 border rounded">

                <div class="grid grid-cols-12">
                    <div class="col-span-4 md:col-span-2 font-extrabold">
                        <p class="font-extrabold">
                            {{ isset($scholarshipTranslations['name_text']) ? $scholarshipTranslations['name_text'] : '' }}
                        </p>
                    </div>
                    <div class="col-span-7 md:col-span-9 font-extrabold text-black">
                        <p>{{ isset($scholarship->schoolScholarshipDetail[0]->name) ? $scholarship->schoolScholarshipDetail[0]->name : '' }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-12 mt-3">
                    <div class="col-span-4 md:col-span-2 font-extrabold">
                        <p>{{ isset($scholarshipTranslations['school_text']) ? $scholarshipTranslations['school_text'] : '' }}
                        </p>
                    </div>
                    
                    <div class="col-span-7 md:col-span-9 text-black">
                        <p>{{ isset($scholarship->school->schoolDetail[0]->school_name) ? $scholarship->school->schoolDetail[0]->school_name : '' }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-12 mt-3">
                    <div class="col-span-4 md:col-span-2 font-extrabold">
                        <p>{{ isset($scholarshipTranslations['summary_text']) ? $scholarshipTranslations['summary_text'] : '' }}
                        </p>
                    </div>
                    
                    <div class="col-span-7 md:col-span-9 text-black line-clamp-3 text_justify">
                        <p>{!! isset($scholarship->schoolScholarshipDetail[0]->summary)
                            ? $scholarship->schoolScholarshipDetail[0]->summary
                            : '' !!}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-12 mt-3">
                    <div class="col-span-4 md:col-span-2 font-extrabold">
                        <p>{{ isset($scholarshipTranslations['province_text']) ? $scholarshipTranslations['province_text'] : '' }}
                        </p>
                    </div>
                    
                    <div class="col-span-7 md:col-span-9 text-black">
                        <p>{{ isset($scholarship->province) ? $scholarship->province : '' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-12 mt-3">
                    <div class="col-span-4 md:col-span-2 font-extrabold">
                        <p>{{ isset($scholarshipTranslations['deadline_text']) ? $scholarshipTranslations['deadline_text'] : '' }}
                        </p>
                    </div>
                    
                    <div class="col-span-7 md:col-span-9 text-black">
                        <p>
                            {{-- {{ isset($scholarship->deadline_date) ? date('F d, Y', strtotime($scholarship->deadline_date)) : '' }} --}}
                            {{ !empty($scholarship->deadline_date) && strtotime($scholarship->deadline_date) 
                                ? date('F d, Y', strtotime($scholarship->deadline_date)) 
                                : 'Not available' }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-12 mt-3">
                    <div class="col-span-4 md:col-span-2 font-extrabold">
                        <p>{{ isset($scholarshipTranslations['duration_text']) ? $scholarshipTranslations['duration_text'] : '' }}
                        </p>
                    </div>
                    
                    <div class="col-span-7 md:col-span-9 text-black">
                        <p>{{ isset($scholarship->duration) ? $scholarship->duration : '' }}</p>
                    </div>
                </div>

                <div class="flex justify-center md:justify-end items-center mt-4">
                            
                    <div class="flex items-center gap-2">
                        <a href="{{ $scholarship->more_info_link ?? '#' }}" target="_blank">
                            <button
                                class="can-edu-btn-fill whitespace-nowrap">{{ isset($scholarshipTranslations['apply_now_button_text']) ? $scholarshipTranslations['apply_now_button_text'] : '' }}</button>
                        </a>
                        <a href="{{ route('web.view.scholarship.detail', ['lang' => $defaultLang['abbreviation'], 'id' => $scholarship->id]) }}"
                            target="_blank">
                            <button
                                class="can-edu-btn-fill whitespace-nowrap">{{ isset($scholarshipTranslations['learn_more_button_text']) ? $scholarshipTranslations['learn_more_button_text'] : '' }}</button>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="mt-4">
            {!! $scholarships->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
        </div>
    </div>

</div>
@section('scripts')
<script>
function showWarningModal() {
    let message = "";
    @if(!$loggedInCustomer || $logged_in_user_type != 'school')
        message = @json(getStaticTranslation('scholarship_popup')['feature_availability_text'] ?? '');
    @endif

    document.getElementById("popupMessage").innerText = message;
    document.getElementById("defaultModal").classList.remove("hidden");
}

function hideWarningModal() {
    document.getElementById("defaultModal").classList.add("hidden");
}
</script>
@endsection