@extends('front.layouts.app')
@section('content')
    @php
        $defaultLang = getDefaultLanguage(1);
        $masterApplicationSetting = App\Models\MasterApplicationSetting::with([
            'masterApplicationSettingDetail' => function ($q) use ($defaultLang) {
                $q = $q->where('language_id', $defaultLang->id);
            },
        ])->first();
        $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
        $indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';
        $masterApplicationModalTranslations = getStaticTranslation('master_application_pop_up_page');
        $loggedInCustomer = Auth::guard('customers')->check();
        $SchoolSearchButtonsTranslations = getStaticTranslation('school_search_buttons');
        if (!function_exists('formatUrl')) {
        function formatUrl($url) {
            return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
        }
    }
    // $register_url = url('/' . $defaultLang['abbreviation'] . '/' . getPageSlug('register_template'));
    $register_url = url('/' . $defaultLang['abbreviation'] . '/' . getPageSlug('register_template') . '?type=student');
    $login_url = url('/' . $defaultLang['abbreviation'] . '/' . getPageSlug('login_template'));
     
        // dd($loggedInCustomer);
    @endphp
    
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 pb-2 border-primary w-full flex items-center justify-between">
                <h1 class="can-edu-h1">
                    {{ isset($school->schoolDetail[0]->school_name) ? $school->schoolDetail[0]->school_name : '' }}</h1>
                <?php
                $favToolTip = isset(getStaticTranslation('general')['add_to_favorites_text']) ? getStaticTranslation('general')['add_to_favorites_text'] : '';
                ?>
                <fav-icon record_id="{{ $school->id }}" tooltiptext="{{ $favToolTip }}" model="school"
                    is_favourit="{{ $favorite }}" />
            </div>
        </div>

        <div class="mt-4">
            <h5 class="text-xl font-FuturaMdCnBT">{{ $SchoolSearchButtonsTranslations['language_availability_text'] ?? 'Viewasd' }} </h5>
            <div class="flex justify-between items-center space-x-4 ">
                <div class="flex items-center space-x-4">
                    @foreach ($customerLangs as $lang)
                        <a class="{{ $schoolLang == $lang->language_code
                            ? 'mr-1 px-4 py-2 rounded border border-primary bg-primary text-white hover:bg-secondaryRed shadow text-center text-lg leading-6 font-FuturaMdCnBT'
                            : 'mr-1 px-4 py-2 rounded border border-gray-200 text-gray-700 bg-gray-200 shadow text-center text-lg leading-6 font-FuturaMdCnBT' }}"
                            href="{{ url('/' . $defaultLang['abbreviation'] . '/set-school-lang/' . $lang->language_code) }}">
                            {{ getLangByCode($lang->language_code) }}</a>
                    @endforeach
                </div>

                <!-- <p class="font-semibold text-red-500"> -->
                <contact-school indicate_required_field="{{ $indicateRequiredField }}" position="{{ $position }}"
                    school_contact_translations="{{ $schoolContactTranslations }}"
                    school_id="{{ isset($school->id) ? $school->id : '' }}"
                    school_name="{{ isset($school->schoolDetail[0]->school_name) ? $school->schoolDetail[0]->school_name : '' }}" login_url="{{ $login_url }}"  register_url="{{ $register_url }}"
                    :logged-in-customer="{{ json_encode($loggedInCustomer) }}"></contact-school>
                <!-- </p> -->
            </div>
        </div>
        <div class="mt-6">

            <div class="flex flex-col xl:flex-row gap-6">
                <!-- <div class="grid grid-cols-12 gap-6"> -->
                @if (isset($data['logged_in_user_type']) && $data['logged_in_user_type'] == 'student')
                    <div class="w-full xl:w-4/12 order-2 xl:order-1 space-y-4 student_master_application">
                        <!-- <div class="col-span-12 lg:col-span-3 order-2 lg:order-1 space-y-4"> -->
                        <div>
                            <master-application hide_master_application_school_name="0"
                                indicate_required_field="{{ $indicateRequiredField }}" position="{{ $position }}"
                                container="1" master_application_setting="{{ $masterApplicationSetting }}"
                                master_application_modal_translation="{{ $masterApplicationModalTranslations }}" 
                                school_id="{{ isset($school->id) ? $school->id : '' }}"></master-application>
                        </div>
                    </div>
                @endif
                <div class="flex-auto w-full xl:w-8/12 order-1 xl:order-2 ">
                    <!-- <div class="col-span-12 lg:col-span-9 order-1 lg:order-2 "> -->
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 md:col-span-8">
                            {{-- <div class="max-h-96 h-64 lg:h-80 border bg-gray-50">
                                <swiper-container class="mySwiper" navigation="true">
                                    @if (isset($school->youtube_iframe))
                                        <swiper-slide>
                                            <div id="iframe-placeholder"></div>
                                        </swiper-slide>
                                    @endif
                                    @if (isset($school->image) && !empty($school->image))
                                        <swiper-slide> <img class="h-full w-full mx-auto bg-gray-50 object-contain"
                                                src="{{ asset(largeImage($school->image)) }}"
                                                alt=""></swiper-slide>
                                    @endif
                                    @if (isset($school->schoolMoreImages) && count($school->schoolMoreImages) > 0)
                                        @foreach ($school->schoolMoreImages as $school_image)
                                            <swiper-slide> <img class="h-full w-full mx-auto bg-gray-50 object-contain"
                                                    src="{{ asset(largeImage($school_image->image)) }}"
                                                    alt=""></swiper-slide>
                                        @endforeach
                                    @endif
                                </swiper-container>
                            </div> --}}
                            <div class="max-h-96 h-64 lg:h-80 border bg-gray-50">
                                <swiper-container class="mySwiper" navigation="true">
                                    @if (isset($school->youtube_iframe))
                                        <swiper-slide>
                                            <div id="iframe-placeholder"></div>
                                        </swiper-slide>
                                    @endif
                                    @if (isset($school->image) && !empty($school->image))
                                        <swiper-slide>
                                            {{-- <img class="h-full w-full mx-auto bg-white object-contain cursor-pointer"
                                                src="{{ asset(largeImage($school->image)) }}"
                                                alt="" onclick="openModal('{{ asset(largeImage($school->image)) }}')" /> --}}
                                                @php
                                                    $image = $school->image;

                                                    if (filter_var($image, FILTER_VALIDATE_URL)) {
                                                        $imgSrc = $image;
                                                    } else {
                                                        $imgSrc = asset(largeImage($image)); 
                                                    }
                                                @endphp

                                                <img class="h-full w-full mx-auto bg-white object-contain cursor-pointer"
                                                    src="{{ $imgSrc }}"
                                                    alt=""
                                                    onclick="openModal('{{ $imgSrc }}')" />
                                        </swiper-slide>
                                    @endif
                                    @if (isset($school->schoolMoreImages) && count($school->schoolMoreImages) > 0)
                                        @foreach ($school->schoolMoreImages as $school_image)
                                            <swiper-slide>
                                                @php
                                                $moreimage = $school_image->image;

                                                if (filter_var($moreimage, FILTER_VALIDATE_URL)) {
                                                    $imgSrc = $moreimage;
                                                } else {
                                                    $imgSrc = asset(largeImage($moreimage)); 
                                                }
                                            @endphp
                                                {{-- <img class="h-full w-full mx-auto bg-white object-contain cursor-pointer"
                                                    src="{{ asset(largeImage($school_image->image)) }}"
                                                    alt="" onclick="openModal('{{ asset(largeImage($school_image->image)) }}')" /> --}}
                                                    <img class="h-full w-full mx-auto bg-white object-contain cursor-pointer"
                                                    src="{{ $imgSrc }}"
                                                    alt=""
                                                    onclick="openModal('{{ $imgSrc }}')" />
                                            </swiper-slide>
                                        @endforeach
                                    @endif
                                </swiper-container>
                            </div>
                            {{-- modal --}}
                            <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 hidden flex items-center justify-center z-50" onclick="closeModalOnBackgroundClick(event)">
                                <div class="relative max-w-4xl w-full p-4">
                                    <button class="absolute top-4 right-4 bg-white p-1 flex items-center justify-center rounded-full w-7 h-7 text-primary font-bold border border-primary" onclick="closeModal()">✕</button>
                                    <img id="modalImage" class="w-full h-auto max-h-screen object-contain rounded-lg" src="" alt="">
                                </div>
                            </div>

                        </div>
                        <div class="col-span-12 md:col-span-4">
                            <div>
                                <div class="py-2 px-6 bg-primary text-white text-center text-lg font-FuturaMdCnBT">
                                    {{ isset($school->schoolDetail[0]->school_name) ? $school->schoolDetail[0]->school_name : '' }}
                                    Weblinks
                                </div>
                                <div class="grid grid-cols-2">
                                    <div>
                                        @if (isset($school->schoolMoreLinks))
                                            @foreach ($school->schoolMoreLinks as $morelink)
                                                <div class="border border-top-0 p-2">
                                                    <a href="{{ $morelink->link }}" target="_blank"
                                                        class="text-decoration-none">
                                                        <p
                                                            class="text-black font-medium text-sm lg:text-base text-center">
                                                            {{ isset($morelink->schoolMoreLinkDetail[0]->name) ? $morelink->schoolMoreLinkDetail[0]->name : '' }}
                                                        </p>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div>
                              
                                        <div class="border border-top-0 p-1.5">
                                            <a href="{{ isset($school->facebook) ? formatUrl($school->facebook) : '' }}"
                                                target="_blank" class="text-decoration-none">
                                                <div class="flex items-center">
                                                    <div class="w-2/6">
                                                        <div
                                                            class="bg-white mx-auto text-primary hover:border-primary border rounded-full w-7 h-7 items-center flex justify-center">
                                                            <span class="sr-only"></span>
                                                            <img class="h-4"
                                                                src="{{ asset('/assets/social-icons/facebook.png') }}"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="w-4/6">
                                                        <p class="text-black font-medium text-sm lg:text-base ">Facebook
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="border border-top-0 p-2">
                                            <a href="{{ isset($school->twitter) ? formatUrl($school->twitter) : '' }}" target="_blank"
                                                class="text-decoration-none">
                                                <div class="flex items-center">
                                                    <div class="w-2/6">
                                                        <div
                                                            class="bg-white mx-auto text-primary hover:border-primary border rounded-full w-7 h-7 items-center flex justify-center">
                                                            <span class="sr-only"></span>
                                                            <img class="h-3.5"
                                                                src="{{ asset('/assets/social-icons/twitter.png') }}"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="w-4/6">
                                                        <p class="text-black font-medium text-sm lg:text-base ">Twitter
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="border border-top-0 p-2">
                                            <a href="{{ isset($school->insta) ? formatUrl($school->insta) : '' }}" target="_blank"
                                                class="text-decoration-none">
                                                <div class="flex items-center">
                                                    <div class="w-2/6">
                                                        <div
                                                            class="bg-white mx-auto text-primary hover:border-primary border rounded-full w-7 h-7 items-center flex justify-center">
                                                            <span class="sr-only"></span>
                                                            <img class="h-4"
                                                                src="{{ asset('/assets/social-icons/instagaram.png') }}"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="w-4/6">
                                                        <p class="text-black font-medium text-sm lg:text-base ">Instagram
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="border border-top-0 p-2">
                                            <a href="{{ isset($school->youtube) ? formatUrl($school->youtube) : '' }}" target="_blank"
                                                class="text-decoration-none">
                                                <div class="flex items-center">
                                                    <div class="w-2/6">
                                                        <div
                                                            class="bg-white mx-auto text-primary hover:border-primary border rounded-full w-7 h-7 items-center flex justify-center">
                                                            <span class="sr-only"></span>
                                                            <img class="h-3"
                                                                src="{{ asset('/assets/social-icons/youtube.png') }}"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="w-4/6">
                                                        <p class="text-black font-medium text-sm lg:text-base ">YouTube
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="border border-top-0 p-2">
                                            <a href="{{ isset($school->linkedin) ? formatUrl($school->linkedin) : '' }}"
                                                target="_blank" class="text-decoration-none">
                                                <div class="flex items-center">
                                                    <div class="w-2/6">
                                                        <div
                                                            class="bg-white mx-auto text-primary hover:border-primary border rounded-full w-7 h-7 items-center flex justify-center">
                                                            <span class="sr-only"></span>
                                                            <img class="h-4"
                                                                src="{{ asset('/assets/social-icons/linkedin.png') }}"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="w-4/6">
                                                        <p class="text-black font-medium text-sm lg:text-base ">LinkedIn
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $activeTab = isset($data['school_default_tab']) ? (int) $data['school_default_tab'] : 2;
                    ?>
                    <div
                        class="mt-10 flex flex-wrap sm:flex-col md:flex-row lg:flex-row justify-start w-full items-center">
                        @if (isset($school->quick_facts_status) && $school->quick_facts_status == 1)
                            <button onclick="showActiveTab(1, 'quick-facts')"
                                class="{{ $activeTab == 1
                                    ? "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                          py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                          hover:border-t-primary active:border-b-transparent active:border-t-primary
                                          active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT active_button"
                                    : "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                              py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                              hover:border-t-primary active:border-b-transparent active:border-t-primary
                                              active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT" }}"
                                id="tab-button-1">
                                Quick facts
                            </button>
                        @endif
                        @if (isset($school->overview_status) && $school->overview_status == 1)
                            <button onclick="showActiveTab(2, 'overview')"
                                class="{{ $activeTab == 2
                                    ? "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                                                                                                                  py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                                                                                                                  hover:border-t-primary active:border-b-transparent active:border-t-primary
                                                                                                                                  active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT active_button"
                                    : "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                                                                                                                  py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                                                                                                                  hover:border-t-primary active:border-b-transparent active:border-t-primary
                                                                                                                                  active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT" }}"
                                id="tab-button-2">
                                Overview
                            </button>
                        @endif
                        @if (isset($school->program_status) && $school->program_status == 1)
                            <button onclick="showActiveTab(3, 'programs')"
                                class="{{ $activeTab == 3
                                    ? "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                                                                                                                  py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                                                                                                                  hover:border-t-primary active:border-b-transparent active:border-t-primary
                                                                                                                                  active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT active_button"
                                    : "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                                                                                                                  py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                                                                                                                  hover:border-t-primary active:border-b-transparent active:border-t-primary
                                                                                                                                  active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT" }}"
                                id="tab-button-3">
                                Programs
                            </button>
                        @endif
                        @if (isset($school->admission_status) && $school->admission_status == 1)
                            <button onclick="showActiveTab(4, 'admissions')"
                                class="{{ $activeTab == 4
                                    ? "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                                                                                                                  py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                                                                                                                  hover:border-t-primary active:border-b-transparent active:border-t-primary
                                                                                                                                  active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT active_button"
                                    : "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                                                                                                                  py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                                                                                                                  hover:border-t-primary active:border-b-transparent active:border-t-primary
                                                                                                                                  active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT" }}"
                                id="tab-button-4">
                                Admissions
                            </button>
                        @endif
                        @if (isset($school->financial_status) && $school->financial_status == 1)
                            <button onclick="showActiveTab(5, 'financials')"
                                class="{{ $activeTab == 5
                                    ? "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                                                                                                                  py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                                                                                                                  hover:border-t-primary active:border-b-transparent active:border-t-primary
                                                                                                                                  active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT active_button"
                                    : "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                                                                                                                  py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                                                                                                                  hover:border-t-primary active:border-b-transparent active:border-t-primary
                                                                                                                                  active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT" }}"
                                id="tab-button-5">
                                Financials
                            </button>
                        @endif
                        @if (isset($school->scholarship_status) && $school->scholarship_status == 1)
                            <button onclick="showActiveTab(6, 'scholarships')"
                                class="{{ $activeTab == 6
                                    ? "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                                                                                                                  py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                                                                                                                  hover:border-t-primary active:border-b-transparent active:border-t-primary
                                                                                                                                  active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT active_button"
                                    : "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                                                                                                                  py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                                                                                                                  hover:border-t-primary active:border-b-transparent active:border-t-primary
                                                                                                                                  active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT" }}"
                                id="tab-button-6">
                                Scholarships
                            </button>
                        @endif
                        @if (isset($school->contacts_status) && $school->contacts_status == 1)
                            <button onclick="showActiveTab(7, 'contacts')"
                                class="{{ $activeTab == 7
                                    ? "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                                                                                                                  py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                                                                                                                  hover:border-t-primary active:border-b-transparent active:border-t-primary
                                                                                                                                  active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT active_button"
                                    : "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                                                                                                                  py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                                                                                                                  hover:border-t-primary active:border-b-transparent active:border-t-primary
                                                                                                                                  active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT" }}"
                                id="tab-button-7">
                                Contacts
                            </button>
                        @endif
                        @if (isset($school->ambassador_status) && $school->ambassador_status == 1)
                            <button onclick="showActiveTab(8, 'ambassadors')"
                                class="{{ $activeTab == 8
                                    ? "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                                                                                                                  py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                                                                                                                  hover:border-t-primary active:border-b-transparent active:border-t-primary
                                                                                                                                  active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT active_button"
                                    : "bg-white border-b-gray-300 border -mb-[1px] flex-auto
                                                                                                                                  py-1.5 px-1.5 2xl:px-3 whitespace-nowrap hover:border-t-4 hover:border-gray-300 text-black
                                                                                                                                  hover:border-t-primary active:border-b-transparent active:border-t-primary
                                                                                                                                  active:border-gray-300 font-medium text-lg md:text-xl 2xl:text-2xl font-FuturaMdCnBT" }}"
                                id="tab-button-8">
                                Ambassadors
                            </button>
                        @endif

                    </div>

                    @if (isset($school->quick_facts_status) && $school->quick_facts_status == 1)
                        <div id="tab-content-1"
                            class="{{ $activeTab == 1 ? 'tab-content school_tabs' : 'tab-content school_tabs hidden' }}">
                            @include('front.school-detail-includes.quickfacts', ['school', $school])
                        </div>
                    @endif
                    @if (isset($school->overview_status) && $school->overview_status == 1)
                        <div id="tab-content-2"
                            class="{{ $activeTab == 2 ? 'tab-content school_tabs school_tab_button mt-4' : 'tab-content school_tabs mt-4 hidden' }}">
                            @include('front.school-detail-includes.overviews', ['school', $school])
                        </div>
                    @endif
                    @if (isset($school->program_status) && $school->program_status == 1)
                        <div id="tab-content-3"
                            class="{{ $activeTab == 3 ? 'tab-content school_tabs mt-4' : 'tab-content school_tabs mt-4 hidden' }}">
                            @include('front.school-detail-includes.programs', ['school', $school])
                        </div>
                    @endif
                    @if (isset($school->admission_status) && $school->admission_status == 1)
                        <div id="tab-content-4"
                            class="{{ $activeTab == 4 ? 'tab-content school_tabs mt-4' : 'tab-content school_tabs mt-4 hidden' }}">
                            @include('front.school-detail-includes.admissions', ['school', $school])
                        </div>
                    @endif
                    @if (isset($school->financial_status) && $school->financial_status == 1)
                        <div id="tab-content-5"
                            class="{{ $activeTab == 5 ? 'tab-content school_tabs school_tab_button mt-4' : 'tab-content school_tabs mt-4 hidden' }}">
                            @include('front.school-detail-includes.financials', ['school', $school])
                        </div>
                    @endif
                    @if (isset($school->scholarship_status) && $school->scholarship_status == 1)
                        <div id="tab-content-6"
                            class="{{ $activeTab == 6 ? 'tab-content school_tabs mt-4' : 'tab-content school_tabs mt-4 hidden' }}">
                            @include('front.school-detail-includes.scholarships', ['school', $school])
                        </div>
                    @endif
                    @if (isset($school->contacts_status) && $school->contacts_status == 1)
                        <div id="tab-content-7"
                            class="{{ $activeTab == 7 ? 'tab-content school_tabs mt-4' : 'tab-content school_tabs mt-4 hidden' }}">
                            @include('front.school-detail-includes.contacts', ['school', $school])
                        </div>
                    @endif
                    @if (isset($school->ambassador_status) && $school->ambassador_status == 1)
                        <div id="tab-content-8"
                            class="{{ $activeTab == 8 ? 'tab-content school_tabs mt-4' : 'tab-content school_tabs mt-4 hidden' }}">
                            @include('front.school-detail-includes.ambassadors', ['school', $school])
                            {{-- @php
                                dd($school);
                            @endphp --}}
                        </div>
                    @endif
                    {{-- <div class="row justify-content-center mb-5 mt-10">
                        <div class="w-full md:w-1/2 mx-auto flex text-center">
                            <a href="{{ isset($school->other_button_link) ? formatUrl($school->other_button_link) : '' }}"
                                target="_blank"
                                class="canedu_btn w-full py-4">{{ isset($school->schoolDetail[0]->other_button_title) ? $school->schoolDetail[0]->other_button_title : '' }}</a>
                        </div>
                    </div> --}}

                    {{-- @include('front.school-detail-includes.bottom-setting', ['school', $school]) --}}
                    @include('front.school-detail-includes.related-articles', ['articles', $articles])
                </div>
            </div>

        </div>

    </div>
@endsection
@section('scripts')
    <script>
        @if (isset($school->youtube_iframe))
            window.addEventListener('load', function() {
                const iframeHtml = `{!! $school->youtube_iframe !!}`;

                const iframePlaceholder = document.getElementById('iframe-placeholder');
                iframePlaceholder.innerHTML = iframeHtml;

                loadScript();
            });
        @endif

        function showActiveTab(tabNumber, tabIdentifier) {
            // Hide all tab content
            document.querySelectorAll('[id^="tab-content-"]').forEach(tabContent => tabContent.classList.add('hidden'));
            document.querySelectorAll('[id^="tab-button-"]').forEach(tabContent => tabContent.classList.remove(
                'active_button'));

            document.getElementById('tab-content-' + tabNumber).classList.remove('hidden');
            document.getElementById('tab-button-' + tabNumber).classList.add('active_button');

            history.replaceState(null, null, '#' + tabIdentifier);
        }

        document.addEventListener('DOMContentLoaded', function() {
            var tabIdentifier = window.location.hash.slice(1);

            var tabMapping = {
                'quick-facts': 1,
                'overview': 2,
                'programs': 3,
                'admissions': 4,
                'financials': 5,
                'scholarships': 6,
                'contacts': 7,
                'ambassadors': 8,
            };

            if (tabIdentifier) {
                showActiveTab(tabMapping[tabIdentifier] || 2, tabIdentifier);
            }
        });
    function openModal(imageSrc) {
            document.getElementById("modalImage").src = imageSrc;
            const modal = document.getElementById("imageModal");

            // Remove hidden class and apply slide-in animation
            modal.classList.remove("hidden");
            modal.classList.add("slide-in");
        }

        function closeModal() {
            const modal = document.getElementById("imageModal");

            // Add slide-out animation before hiding the modal
            modal.classList.remove("slide-in");
            modal.classList.add("slide-out");

            // After animation completes (0.3s), hide the modal
            setTimeout(() => {
                modal.classList.add("hidden");
                modal.classList.remove("slide-out");
            }, 300); // match the animation duration
        }

        // Function to close modal when background is clicked
        function closeModalOnBackgroundClick(event) {
            // Check if the click was on the background (not the content)
            if (event.target === document.getElementById("imageModal")) {
                closeModal();
            }
        }
    </script>
@endsection
