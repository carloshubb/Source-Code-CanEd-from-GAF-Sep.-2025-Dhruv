@php
    $defaultLang = getDefaultLanguage(1);
    $search = request('search') ?? null;
    $events = getEventListing($defaultLang, $search);
    $isLoggedIn = Auth::guard('customers')->check();
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user() : '';
    $school_id = isset(Auth::guard('customers')->user()->school->id)
    ? Auth::guard('customers')->user()->school->id
    : '';
    $eventTranslations = getStaticTranslation('events');
    $eventPopupTranslations = getStaticTranslation('event_popup');
    $packageLabels = [
        'free' => 'More Events',
        'featured' => 'Featured Events',
        'premium' => 'Premium Events',
    ];
    
    function formatUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
    }
    
@endphp

<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
    <div class="flex flex-col md:flex-row w-full items-end gap-3 md:h-14">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                {{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : 'Events' }}
            </h1>
        </div>
        <div class="md:-mb-4 flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
            <add-event event_modal_translation="{{ $eventTranslations }}" events_popups_translation="{{ $eventPopupTranslations }}" position="{{ $defaultLang->position ?? 'rtl' }}"
                lang="{{ $defaultLang['abbreviation'] }}" school_id="{{ $school_id }}"
                is_logged_id="{{ $isLoggedIn }}" logged_in_customer="{{ $loggedInCustomer }}"
                logged_in_user_type="{{ $data['logged_in_user_type'] }}">
            </add-event>
            <form method="GET">
                <div class="relative flex items-center border-collapse border border-gray-300 rounded border-l-0">
                    <input name="search" type="search" placeholder="Search events"
                        class="focus:outline-none focus:ring-primary rounded bg-white px-3 border-y-0 border-gray-300 border-l-4 rounded-l border-l-primary"
                        value="{{ $search }}" />
                    <button type="submit" class="bg-gray-100 p-1.5 py-2 rounded-r absolute right-0 h-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if (!empty($page->image))
        <div class="mt-8 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
            <img class="w-full h-full object-contain mx-auto" src="{{ asset(largeImage($page->image)) }}" alt="">
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
        @php
            $displayedPackageTypes = [];
        @endphp
        @if ($events->count() > 0)
            @foreach ($events as $event)
                @if (!in_array($event->package_type, $displayedPackageTypes))
                    @php
                        $displayedPackageTypes[] = $event->package_type;
                    @endphp
                    <div class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                        <h2 class="normal-case can-edu-h2 mb-0 text-white">
                            {{ $packageLabels[$event->package_type] ?? $event->package_type }}
                        </h2>
                    </div>
                @endif

                @if ($event->package_type == 'featured')
                    <div class="rounded-lg cards_wrapper bg-gradient-to-r from-pink-300 via-red-300 to-yellow-300 p-0.5 mb-4">
                @elseif ($event->package_type == 'premium')
                    <div class="rounded-lg cards_wrapper bg-gradient-to-r from-pink-300 via-red-300 to-yellow-300 p-0.5 mb-4">
                @elseif ($event->package_type == 'free')
                    <div class="bg-gradient-to-r cards_wrapper from-gray-300 via-gray-300 to-gray-300 p-0.5 rounded">
                @else
                    <div class="bg-gradient-to-r cards_wrapper from-gray-300 via-gray-300 to-gray-300 p-0.5 rounded">
                @endif

                <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2 border rounded p-4 card_bg">
                    @if ($event->package_type == 'featured')
                        <div class="w-96 h-96 border border-gray-300 bg-gray-200 flex-shrink-0 mx-auto">
                    @elseif ($event->package_type == 'premium')
                        <div class="w-80 h-80 border border-gray-300 bg-gray-200 flex-shrink-0 mx-auto">
                    @elseif ($event->package_type == 'free')
                        <div class="w-72 h-72 border border-gray-300 bg-gray-200 flex-shrink-0 mx-auto">
                    @else
                        <div class="w-72 h-72 border border-gray-300 bg-gray-200 flex-shrink-0 mx-auto">
                    @endif

                    @php
                        // Extract YouTube Video ID
                        preg_match(
                            '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i',
                            $event->video_url,
                            $matches,
                        );
                        $youtubeId = $matches[1] ?? null;
                    @endphp

                    @if ($event->package_type == 'featured' && $youtubeId)
                        <iframe class="h-full w-full" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allowfullscreen></iframe>
                    @else
                        <img src="{{ isset($event->eventImage->thumbnail_image) ? asset($event->eventImage->thumbnail_image) : '' }}" class="h-full w-full object-contain" alt="">
                    @endif
                    </div>

                    <div class="md:p-4 flex-1 bg-transparent">
                        <div class="grid grid-cols-1 md:pl-4">
                            <div class="bg-primary text-white font-FuturaMdCnBT text-lg flex divide-x justify-center mb-4" id="countdown-container">
                                <p>{{ $event->eventDetail[0]->title ?? '' }}</p>
                            </div>
                            <div class="grid grid-cols-12">
                                <div class="col-span-4 md:col-span-3 font-bold">
                                    <p>{{ isset($eventTranslations['title_label_text']) ? $eventTranslations['title_label_text'] : '' }}</p>
                                </div>
                                <div class="col-span-7 md:col-span-8 font-bold text-black">
                                    <p class="break-words">{{ $event->customer->school->schoolDetail[0]->school_name ?? '' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 mt-2">
                                <div class="col-span-4 md:col-span-3 font-bold">
                                    <p>{{ isset($eventTranslations['start_date_label_text']) ? $eventTranslations['start_date_label_text'] : '' }}</p>
                                </div>
                                <div class="col-span-7 md:col-span-8 text-black">
                                    <p class="inline">{{ isset($event->start_date) ? date('F d, Y', strtotime($event->start_date)) : '' }}</p>
                                    @if(isset($event->start_date) && isset($event->end_date))
                                        <span class="mx-2">-</span>
                                    @endif
                                    <p class="inline">{{ isset($event->end_date) ? date('F d, Y', strtotime($event->end_date)) : '' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 mt-2">
                                <div class="col-span-4 md:col-span-3 font-bold">
                                    <p>{{ isset($eventTranslations['location_label_text']) ? $eventTranslations['location_label_text'] : '' }}</p>
                                </div>
                                <div class="col-span-7 md:col-span-8 text-black">
                                    <p>{{ isset($event->location) ? $event->location : '' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <p class="break-words text-black line-clamp-3" style="word-break: break-all;">
                                    {{ $event->eventDetail[0]->short_description ?? '' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex justify-end mb-3 mx-4 md:mx-0 mt-3 md:mt-6">
                            @if (($event->package_type == 'featured' || $event->package_type == 'premium') && isset($event->event_website))
                                <a href="{{ formatUrl($event->event_website) }}" target="_blank" class="can-edu-btn-fill mr-3">
                                    {{ isset($eventTranslations['visit_website_button_text']) ? $eventTranslations['visit_website_button_text'] : '' }}
                                </a>
                            @endif
                            <a href="{{ url('/' . $defaultLang['abbreviation'] . '/event/' . $event->slug) }}">
                                <button class="can-edu-btn-fill">
                                    {{ isset($eventTranslations['read_more_label_text']) ? $eventTranslations['read_more_label_text'] : '' }}
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="text-center text-black text-lg mt-10">
                <p>{{ getStaticTranslation('general')['search_yield_error_text'] ?? '' }}</p>
            </div>
        @endif

        {!! $events->appends($_GET)->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
    </div>
</div>