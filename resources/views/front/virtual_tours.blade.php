@php
    $VirtualTours = App\Models\VirtualTour::with([
    'virtualTourDetail' => function ($q) use ($defaultLang) {
    $q = $q->where('language_id', $defaultLang->id);
    },
    ])
    ->whereStatus('approved')
    // ->whereDate('deadline_date', '>=', now())
    ->with('school')
    ->paginate(10);
    $isLoggedIn = Auth::guard('customers')->check();
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user() : '';
    $school_id = isset(Auth::guard('customers')->user()->school->id) ? Auth::guard('customers')->user()->school->id : '';
    $slug = isset(Auth::guard('customers')->user()->slug) ? Auth::guard('customers')->user()->slug : '';
    $VirtualTourTranslations = getStaticTranslation('virtual_tours');
    $virtualTourPopup = getStaticTranslation('virtual_tour_popup');
    $lang_abbreviation = getDefaultLanguage(1)['abbreviation'];
    $logged_in_user_type = isset($data['logged_in_user_type']) ? $data['logged_in_user_type'] : '';
    $is_package_amount_paid = isset($loggedInCustomer->package_price) ? $loggedInCustomer->package_price : '0';
@endphp
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full justify-between md:justify-center items-end gap-3 mb-8">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                {{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : 'Our virtual Tours' }}</h1>
        </div>
        <div
         class="flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
        <add-virtual-tour lang="{{ $lang_abbreviation }}" virtual_tour_translations="{{ $VirtualTourTranslations }}" virtual_tour_popups="{{ $virtualTourPopup }}"
            school_id="{{ $school_id }}" slug="{{ $slug }}" is_logged_id="{{ $isLoggedIn }}" logged_in_user_type="{{ $logged_in_user_type }}"
            is_package_amount_paid="{{ $is_package_amount_paid }}" register_school_slug="{{ getPageSlug('school_request_template') }}"
            register_business_slug="{{ getPageSlug('register_business_template') }}" login_slug="{{ getPageSlug('login_template') }}">
        </add-virtual-tour>
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

    <div class="mt-16 md:mt-10 mb-6 md:mb-10">
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @php
                function formatUrl($url) {
                    return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
                }
            @endphp
            @foreach ($VirtualTours as $VirtualTour)
                <a href="{{ formatUrl($VirtualTour->link) }}" class="relative" title="" target="_blank">
                    <div class="border rounded-md relative peer">
                        <div class="p-2 w-full bg-primary text-center h-[74px] relative">
                            <p class="font-FuturaMdCnBT text-base text-white text-left line-clamp-2">
                                {{-- {{ isset($VirtualTour->school->schoolDetail[0]->school_name) ? $VirtualTour->school->schoolDetail[0]->school_name : '' }} --}}
                                {{ isset($VirtualTour->virtualTourDetail[0]->description) ? $VirtualTour->virtualTourDetail[0]->description : '' }}
                            </p>
                        </div>
                        <div style="background-image: url('<?= thumbnailImage($VirtualTour->image) ?>')"
                            class="bg-cover bg-gray-50 border bg-no-repeat z-10 relative bg-center h-72">
                            <div class="bg-gradient-to-t from-black/50 via-black/30 to-black-10 w-full h-full">
                            {{-- <div class="text-white absolute bottom-2 left-2 text-lg font-semibold">
                                <p class="text-base lg:text-lg line-clamp-2"
                                    style="color:{{ !empty($VirtualTour->color) ? $VirtualTour->color : '' }}">
                                    {{ isset($VirtualTour->virtualTourDetail[0]->description) ? $VirtualTour->virtualTourDetail[0]->description : '' }}
                                </p>
                            </div> --}}
                        </div>
                        </div>
                    </div>
                    {{-- <div class="absolute tooltip right-1/4 top-16 group-hover:flex hidden peer-hover:flex">
                        <div role="tooltip"
                            class="absolute tooltiptext_icon after:right-24 right-0 -top-2 z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-red-100  border border-primary text-gray-600 rounded w-52 px-4">
                            <p class="text-primary text-center font-semibold leading-none text-sm lg:text-base">
                                {{ $VirtualTourTranslations['virtual_tour_hover_text'] }}
                            </p>
                        </div>
                    </div> --}}
                </a>
            @endforeach
        </div>
    </div>
    {!! $VirtualTours->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
</div>
