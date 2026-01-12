@extends('front.layouts.app')
@php
$defaultLang = getDefaultLanguage(1);
$position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
$indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';
$successMessage = getStaticTranslation('toaster_messages')['contact_organizer_success_message'] ?? '';
$loggedInCustomerForblade = Auth::guard('customers')->user();
$showButton = $loggedInCustomerForblade && $loggedInCustomerForblade->user_type === 'school' && $loggedInCustomerForblade->package_price > 0;
if (!function_exists('formatUrl')) {
        function formatUrl($url) {
            return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
        }
    }
    // $schoolRequestTemplate = url('/' . $defaultLang['abbreviation'] . '/' . getPageSlug('school_request_template'));
    // $schoolRequestTemplate = url('/' . $defaultLang['abbreviation'] . '/membership-package');
    if (!$loggedInCustomerForblade) {
    // User not logged in → Send to school request template page
    $schoolRequestTemplate = url('/' . $defaultLang['abbreviation'] . '/' . getPageSlug('school_request_template'));
} elseif ($loggedInCustomerForblade->user_type === 'school' && $loggedInCustomerForblade->package_price <= 0) {
    // Logged-in school user with package price 0 → Send to membership package page
    $schoolRequestTemplate = url('/' . $defaultLang['abbreviation'] . '/membership-package');
} else {
    // Default case
    $schoolRequestTemplate = url('/' . $defaultLang['abbreviation'] . '/membership-package');
}


@endphp
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-8">
                <div class="border-b-4 pb-2 border-primary w-full flex items-center justify-between">
                    <h1 class="can-edu-h1">
                        {{ isset($openDay->openDayDetail[0]->title) ? $openDay->openDayDetail[0]->title : '' }}
                    </h1>
                    <?php
                    $favToolTip = isset(getStaticTranslation('general')['add_to_favorites_text']) ? getStaticTranslation('general')['add_to_favorites_text'] : '';
                    ?>
                    <fav-icon tooltiptext="{{ $favToolTip }}" record_id="{{ $openDay->id }}" model="openday"
                        is_favourit="{{ $favorite }}" />
                </div>
                <div class="mt-4 bg-white border h-60 md:h-80 xl:h-96 rounded">
                    <img class="w-full h-full object-contain mx-auto"
                        src="{{ asset(largeImage($openDay->image)) }}" alt="">
                </div>

                <div class="text-black my-4">
                    <p class="text-ellipsis... overflow-hidden text-justify can-edu-p">
                        {!! isset($openDay->openDayDetail[0]->description) ? $openDay->openDayDetail[0]->description : '' !!}
                    </p>
                </div>
                <div class="sm:w-2/3 mx-auto">
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h5 class="font-bold text-base lg:text-lg">
                                    {{ isset($openDayContactTranslations['school_label_text']) ? $openDayContactTranslations['school_label_text'] : '' }}
                                </h5>
                            </div>
                            <div>
                                <p>
                                    {{ isset($openDay->school->schoolDetail[0]->school_name) ? $openDay->school->schoolDetail[0]->school_name : '' }}
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h5 class="font-bold text-base lg:text-lg">
                                    {{ isset($openDayContactTranslations['address_label_text']) ? $openDayContactTranslations['address_label_text'] : '' }}
                                </h5>
                            </div>
                            <div>
                                <p>
                                    {{ $openDay->address }}
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h5 class="font-bold text-base lg:text-lg">
                                    {{ isset($openDayContactTranslations['date_and_time_label_text']) ? $openDayContactTranslations['date_and_time_label_text'] : '' }}
                                </h5>
                            </div>
                            <div>
                                <p>
                                    {{ isset($openDay->date) ? date('F d, Y', strtotime($openDay->date)) : '' }} 
                                    at {{ date('h:i a', strtotime($openDay->time)) }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h5 class="font-bold text-base lg:text-lg">
                                    {{ isset($openDayContactTranslations['open_house_location_text']) ? $openDayContactTranslations['open_house_location_text'] : '' }}
                                </h5>
                            </div>
                            <div>
                                <p>
                                    {{ $openDay->city }}, {{ $openDay->country }}&nbsp;&nbsp;{{ $openDay->postal_code }}

                                </p>
                            </div>
                        </div>

                    </div>
                    <div
                        class="flex flex-col sm:flex-row items-center justify-center my-10 md:pr-12 space-x-3 space-y-3 sm:space-y-0">
                        <div class="flex items-center">
                            {{-- @php
                            function formatUrl($url) {
                                return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
                            }
                        @endphp --}}
                            <a href="{{ formatUrl($openDay->open_day_url) }}" target="_blank" class="">
                                <button class="can-edu-btn-fill {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'ml-3' : 'mr-3' }}" target="_blank">
                                    {{ isset($openDayContactTranslations['visit_website_button_text']) ? $openDayContactTranslations['visit_website_button_text'] : '' }}
                                </button>
                            </a>
                            <span class="cursor-pointer">
                                <Open-day-contact-orgnizer position="{{ $position }}" open_house_translations="{{ $openDayContactTranslations }}" indicate_required_field="{{ $indicateRequiredField }}"
                                    open_house="{{ $openDay }}" success_message="{{ $successMessage }}" />
                            </span>
                        </div>
                        {{-- @if (isset($data['logged_in_user_type']) && $data['logged_in_user_type'] == 'school') --}}
                        @if ($loggedInCustomerForblade && $loggedInCustomerForblade->package_price > 0)
                            {{-- <a href="{{ url('/' . $defaultLang['abbreviation'] . '/' . auth()->guard('customers')->user()->slug  . '/our-profile/open-house/create') }}" class="" target="_blank">
                                <button class="can-edu-btn-fill">
                                    {{ isset($openDayContactTranslations['add_your_open_house_button_text']) ? $openDayContactTranslations['add_your_open_house_button_text'] : '' }}
                                </button>
                            </a> --}}
                            <a href="#" onclick="window.open('{{ url('/' . $defaultLang['abbreviation'] . '/' . auth()->guard('customers')->user()->slug . '/our-profile/open-house/create') }}', '_blank'); return false;">
                                <button class="can-edu-btn-fill">
                                    {{ isset($openDayContactTranslations['add_your_open_house_button_text']) ? $openDayContactTranslations['add_your_open_house_button_text'] : '' }}
                                </button>
                            </a>
                            
                        @else
                            <button class="can-edu-btn-fill" onclick="showWarningModal()">
                                {{ isset($openDayContactTranslations['add_your_open_house_button_text']) ? $openDayContactTranslations['add_your_open_house_button_text'] : '' }}
                            </button>
                        @endif
                    {{-- @endif --}}
                    </div>
                    <div id="warningModal" class="hidden bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4">
                        <div class="relative w-full h-full max-w-lg flex items-center justify-center">
                            <div class="bg-white py-6 px-10 rounded shadow-lg text-center relative">
                                <div class="absolute top-3 right-3">
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeWarningModal()">
                                        <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-center can-edu-p mt-4">
                                    Only Featured and Premium schools can register their Open House days. 
                                    Click <a href="{{ $schoolRequestTemplate }}" class="text-primary font-semibold underline">register</a> to register your Open House day.
                                </p>
                                <button type="button" class="can-edu-btn-fill whitespace-nowrap px-5 mt-4" onclick="closeWarningModal()">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-4">
                <div class="border-b-4 pt-1 border-primary">
                    <h2 class="can-edu-h2">
                        {{ isset($openDayContactTranslations['more_open_house_text']) ? $openDayContactTranslations['more_open_house_text'] : '' }}
                        </p>
                </div>
                @foreach ($openDays as $openDay)
                    @php
                        $url = url('/' . $defaultLang['abbreviation'] . '/open-house/' . $openDay->id);
                    @endphp
                    <a href="{{ $url }}">
                        <div class="mt-4">
                            <div class="border p-3 border-gray-300 rounded grid grid-cols-12 gap-4">
                                <div class="col-span-4 sm:col-span-4 md:col-span-4 lg:col-span-4">
                                    <div class="h-24 w-full mx-auto bg-gray-50 border">
                                        <img class="w-full h-full mx-auto object-contain"
                                            src="{{ asset(thumbnailImage($openDay->image)) }}" alt="">
                                    </div>
                                </div>
                                <div class="w-full text-black col-span-8 sm:col-span-8 md:col-span-8 lg:col-span-8">
                                    <p class="can-edu-card-h mb-1 line-clamp-1 md:line-clamp-none">
                                        {{ isset($openDay->openDayDetail[0]->title) ? $openDay->openDayDetail[0]->title : '' }}
                                    </p>
                                    <p class="can-edu-card-p line-clamp-3 text-justify">
                                        {!! isset($openDay->openDayDetail[0]->description) ? $openDay->openDayDetail[0]->description : '' !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
@endsection
@section('scripts')
<script>
    function showWarningModal() {
        document.getElementById('warningModal').classList.remove('hidden');
    }

    function closeWarningModal() {
        document.getElementById('warningModal').classList.add('hidden');
    }

    document.addEventListener("click", function (event) {
        let modal = document.getElementById("warningModal");

        // Make sure modal is visible before checking
        if (!modal.classList.contains("hidden") && event.target === modal) {
            closeWarningModal();
        }
    });
</script>
@endsection