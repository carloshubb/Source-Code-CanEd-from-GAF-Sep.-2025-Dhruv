@extends('front.layouts.app')
@php
    $defaultLang = getDefaultLanguage(1);
@endphp
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-8">
                <div class="border-b-4 pb-2 border-primary w-full flex items-center justify-between">
                    <h1 class="can-edu-h1">
                        {{ isset($event->eventDetail[0]->title) ? $event->eventDetail[0]->title : '' }}
                    </h1>
                    <?php
                    $favToolTip = isset(getStaticTranslation('general')['add_to_favorites_text']) ? getStaticTranslation('general')['add_to_favorites_text'] : '';
                    ?>
                    <fav-icon tooltiptext="{{ $favToolTip }}" record_id="{{ $event->id }}" model="event"
                        is_favourit="{{ $favorite }}" />
                </div>
                <div class="mt-4 bg-white h-60 md:h-80 xl:h-96 border rounded">
                    <img class="w-full h-full object-contain mx-auto"
                        src="{{ asset(isset($event->eventImage->large_image) ? $event->eventImage->large_image : '') }}"
                        alt="">
                </div>
                {{-- <div class="text-black my-4 can-edu-p">
                    <p class="text-ellipsis... overflow-hidden">
                        {!! isset($event->eventDetail[0]->short_description) ? $event->eventDetail[0]->short_description : '' !!}
                    </p>
                </div> --}}

                <div class="text-black my-4 can-edu-p">
                    <p class="text-ellipsis... overflow-hidden">
                        {!! isset($event->eventDetail[0]->description) ? $event->eventDetail[0]->description : '' !!}
                    </p>
                </div>

                <div class="flex items-center justify-center space-x-2">
                    {{-- @php
                    function formatUrl($url) {
                        return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
                    }
                @endphp --}}
                    @if (isset($event->event_website))
                        <a href="{{ formatUrl($event->event_website) }}" target="_blank" class="can-edu-btn-fill">Event’s
                            website</a>
                    @endif
                    @if (isset($event->visitor_url))
                        <a href="{{ formatUrl($event->visitor_url) }}" target="_blank" class="can-edu-btn-fill">For visitors</a>
                    @endif
                    @if (isset($event->press_url))
                        <a href="{{ formatUrl($event->press_url) }}" target="_blank" class="can-edu-btn-fill">For the press</a>
                    @endif
                    @if (isset($event->exibiters_url))
                    <a href="{{ formatUrl($event->exibiters_url) }}" target="_blank" class="can-edu-btn-fill">For the event media</a>
                @endif
                </div>

                {{-- <div>
                    <h4>{{ isset($eventTranslations['social_icons_text']) ? $eventTranslations['social_icons_text'] : '' }}
                    </h4>
                    <div class="flex space-x-1 items-center mt-4">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/' . $defaultLang['abbreviation'] . '/event/' . $event->id) }}"
                            target="_blank"
                            class="bg-white text-primary hover:border-primary border rounded-full w-9 h-9 items-center flex justify-center">
                            <span class="sr-only"></span>
                            <img class="h-5" src="{{ asset('/assets/social-icons/facebook.png') }}" alt="">
                        </a>

                        <a href="http://www.twitter.com/share?url={{ url('/' . $defaultLang['abbreviation'] . '/event/' . $event->id) }}"
                            target="_blank"
                            class="bg-white text-primary hover:border-primary border rounded-full w-9 h-9 items-center flex justify-center">
                            <span class="sr-only"></span>
                            <img class="h-4" src="{{ asset('/assets/social-icons/twitter.png') }}" alt="">
                        </a>


                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url('/' . $defaultLang['abbreviation'] . '/event/' . $event->id) }}"
                            target="_blank"
                            class="bg-white text-primary hover:border-primary border rounded-full w-9 h-9 items-center flex justify-center">
                            <span class="sr-only"></span>
                            <img class="h-4" src="{{ asset('/assets/social-icons/linkedin.png') }}" alt="">
                        </a>
                    </div>
                </div> --}}
                <h4 class="mt-5">
{{-- 
                    <div class="mt-4 bg-gray-50 h-60 md:h-80 xl:h-96 border rounded">
                        @if(isset($event->video_url))
                        <div id="iframe-placeholder"></div>
                        @else
                        <img class="w-full h-full object-contain mx-auto"
                            src="{{ asset(isset($event->eventImage->large_image) ? $event->eventImage->large_image : '') }}"
                            alt="">
                        @endif
                    </div> --}}

                    @if (!empty($event->video_url))
                    <div class="mt-4 bg-white h-60 md:h-80 xl:h-96 border rounded">
                            @if (Str::contains($event->video_url, '<iframe'))
                                {!! $event->video_url !!}
                            @else
                                @php
                                    $youtubeUrl = $event->video_url;
                                    $videoId = '';
                    
                                    if (preg_match('/(?:v=|youtu\.be\/|\/embed\/)([^&?\/]+)/', $youtubeUrl, $matches)) {
                                        $videoId = $matches[1];
                                    }
                                @endphp
                    
                                @if ($videoId)
                                    <iframe width="100%" height="100%" 
                                            src="https://www.youtube.com/embed/{{ $videoId }}" 
                                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen>
                                    </iframe>
                                @else
                                    <p class="text-center text-gray-500">Invalid YouTube URL provided.</p>
                                @endif
                            @endif
                        </div>
                        @endif
                    
                    
              
              
                    
                    {{-- <div class="bg-white rounded-lg shadow-md mt-10">
                        <div class="border-b rounded-t-lg bg-primary py-3 px-4">
                            <h4 class="text-white mb-0">
                                {{ isset($eventTranslations['photos_label_text']) ? $eventTranslations['photos_label_text'] : '' }}
                            </h4>
                        </div>
                        <div class="grid grid-cols-3 gap-2 p-4 mt-4">
                            @foreach ($event->eventImages as $image)
                                <event-image large_image="{{ asset($image->image) }}"
                                    image="{{ asset(thumbnailImage($image->image)) }}"></event-image>
                            @endforeach
                        </div>
                    </div> --}}
                    @if ($event->eventImages->isNotEmpty())
                    <div class="bg-white rounded-lg shadow-md mt-10">
                        <div class="border-b rounded-t-lg bg-primary py-3 px-4">
                            <h4 class="text-white mb-0">
                                {{ isset($eventTranslations['photos_label_text']) ? $eventTranslations['photos_label_text'] : '' }}
                            </h4>
                        </div>
                        <div class="grid grid-cols-3 gap-2 p-4 mt-4">
                            @foreach ($event->eventImages as $image)
                                <event-image large_image="{{ asset($image->image) }}"
                                    image="{{ asset(thumbnailImage($image->image)) }}"></event-image>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
            <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-4">
                <div class="bg-white rounded-lg border overflow-hidden mt-4">
                    <div class="bg-primary text-white font-FuturaMdCnBT text-xl p-2">
                        {{-- {{ isset($event->eventDetail[0]->title) ? $event->eventDetail[0]->title : '' }} --}}
                        <span class="text-white">
                            {{ isset($eventTranslations['where_when_tab_text']) ? $eventTranslations['where_when_tab_text'] : '' }}
                        </span>
                    </div>
                    {{-- <div class="flex justify-between items-center p-4">
                        <h2 class="mb-0">
                            {{ isset($event->eventDetail[0]->title) ? $event->eventDetail[0]->title : '' }}
                            {{ isset($eventTranslations['event_detail_heading_text']) ? $eventTranslations['event_detail_heading_text'] : '' }}
                        </h2>
                        <div class="flex items-center space-x-2">
                            <div class="border rounded p-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                                <span class="text-gray-500 text-sm ml-2 font-medium">{{ isset($favs) ? $favs : 0 }}</span>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div>
                        @isset($event->customer->school->schoolDetail[0]->school_name)
                            <div class="bg-primary text-white font-FuturaMdCnBT text-xl p-2"
                                id="countdown-container">
                                <p>{{ isset($event->customer->school->schoolDetail[0]->school_name) ? $event->customer->school->schoolDetail[0]->school_name : '' }}
                                </p>
                            </div>
                        @endisset
                    </div> --}}
                    <div class="px-4 pb-4">
                        <div class="flex items-start py-4 border-b ">
                            <div>
                                <svg version="1.1"
                                    class="w-6 h-7 fill-primary mt-2 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'ml-4' : 'mr-4' }}"
                                    xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px"
                                    y="0px" viewBox="0 0 59 59" xml:space="preserve">
                                    <g>
                                        <path
                                            d="M51.179,40.429l-5.596,8.04l-3.949-3.241c-0.426-0.352-1.057-0.288-1.407,0.138c-0.351,0.427-0.289,1.058,0.139,1.407 l4.786,3.929c0.18,0.148,0.404,0.228,0.634,0.228c0.045,0,0.091-0.003,0.137-0.01c0.276-0.038,0.524-0.19,0.684-0.419l6.214-8.929 c0.315-0.453,0.204-1.076-0.25-1.392C52.116,39.861,51.494,39.975,51.179,40.429z">
                                        </path>
                                        <path
                                            d="M52,34.479V15V5c0-0.553-0.448-1-1-1h-5V1c0-0.553-0.448-1-1-1h-7c-0.552,0-1,0.447-1,1v3H15V1c0-0.553-0.448-1-1-1H7 C6.448,0,6,0.447,6,1v3H1C0.448,4,0,4.447,0,5v10v41c0,0.553,0.448,1,1,1h38.104c2.002,1.26,4.362,2,6.896,2 c7.168,0,13-5.832,13-13C59,40.997,56.154,36.651,52,34.479z M39,2h5v3v3h-5V5V2z M8,2h5v3v3H8V5V2z M2,6h4v3c0,0.553,0.448,1,1,1 h7c0.552,0,1-0.447,1-1V6h22v3c0,0.553,0.448,1,1,1h7c0.552,0,1-0.447,1-1V6h4v8H2V6z M2,55V16h48v17.636 c-0.196-0.063-0.396-0.114-0.596-0.169c-0.185-0.051-0.37-0.101-0.557-0.144c-0.169-0.038-0.34-0.071-0.511-0.102 c-0.244-0.045-0.489-0.082-0.735-0.113c-0.137-0.017-0.273-0.036-0.411-0.049C46.796,33.024,46.399,33,46,33 c-0.338,0-0.669,0.025-1,0.051V32v-2v-9h-9h-2h-7h-2h-7h-2H7v9v2v7v2v9h9h2h7h2h6.636c0.029,0.088,0.065,0.173,0.095,0.26 c0.084,0.243,0.167,0.487,0.266,0.724c0.055,0.133,0.12,0.26,0.18,0.39c0.115,0.254,0.232,0.507,0.363,0.753 c0.058,0.107,0.123,0.21,0.184,0.316c0.148,0.259,0.298,0.515,0.464,0.763c0.061,0.091,0.128,0.177,0.191,0.267 c0.176,0.25,0.356,0.498,0.551,0.736c0.072,0.088,0.15,0.17,0.224,0.256c0.155,0.18,0.303,0.364,0.468,0.536H2z M40.313,34.328 c-0.108,0.052-0.218,0.101-0.324,0.156c-0.188,0.098-0.37,0.206-0.552,0.313c-0.159,0.093-0.318,0.188-0.473,0.287 c-0.157,0.102-0.31,0.206-0.462,0.314c-0.173,0.122-0.341,0.25-0.508,0.38c-0.134,0.105-0.268,0.209-0.397,0.32 c-0.175,0.148-0.342,0.305-0.509,0.462c-0.115,0.109-0.234,0.214-0.345,0.326c-0.181,0.184-0.352,0.379-0.522,0.574 c-0.072,0.083-0.151,0.159-0.222,0.244V32h7v1.362c-0.017,0.004-0.033,0.01-0.049,0.014C42.029,33.599,41.147,33.92,40.313,34.328z M33.57,42.199c-0.035,0.115-0.058,0.233-0.09,0.349c-0.08,0.29-0.162,0.58-0.222,0.879c-0.047,0.231-0.073,0.467-0.107,0.701 c-0.027,0.189-0.065,0.375-0.085,0.567C33.023,45.126,33,45.562,33,46c0,0.361,0.02,0.726,0.053,1.092 c0.006,0.067,0.006,0.135,0.013,0.202c0.016,0.162,0.048,0.319,0.07,0.479c0,0,0,0.001,0,0.001 c0.011,0.076,0.015,0.151,0.027,0.226H27v-7h7v0.007c-0.01,0.024-0.016,0.049-0.026,0.073 C33.824,41.445,33.687,41.818,33.57,42.199z M9,41h7v7H9V41z M9,32h7v7H9V32z M43,30h-7v-7h7V30z M34,30h-7v-7h7V30z M34,39h-7v-7 h7V39z M18,32h7v7h-7V32z M25,30h-7v-7h7V30z M16,30H9v-7h7V30z M18,41h7v7h-7V41z M46,57c-2.258,0-4.359-0.686-6.107-1.858 c-0.341-0.228-0.663-0.476-0.972-0.736c-0.108-0.092-0.21-0.19-0.314-0.286c-0.197-0.179-0.388-0.363-0.57-0.554 c-0.117-0.123-0.23-0.248-0.341-0.375c-0.164-0.189-0.318-0.384-0.468-0.583c-0.096-0.127-0.195-0.25-0.286-0.381 c-0.221-0.321-0.429-0.651-0.615-0.993c-0.043-0.08-0.077-0.164-0.118-0.245c-0.146-0.286-0.282-0.576-0.403-0.874 c-0.052-0.13-0.097-0.263-0.145-0.395c-0.094-0.262-0.18-0.528-0.255-0.797c-0.017-0.062-0.032-0.124-0.048-0.186 c-0.113-0.44-0.196-0.877-0.255-1.312c-0.004-0.031-0.01-0.062-0.014-0.094C35.031,46.882,35,46.437,35,46 c0-0.379,0.019-0.755,0.058-1.128c0.003-0.031,0.011-0.061,0.014-0.092c0.038-0.341,0.088-0.681,0.158-1.016 c0.007-0.032,0.018-0.063,0.025-0.095c0.072-0.332,0.157-0.662,0.26-0.988c0.012-0.038,0.029-0.075,0.041-0.113 c0.103-0.312,0.217-0.622,0.349-0.926c0.124-0.286,0.258-0.567,0.405-0.84l0.099-0.171c0.04-0.072,0.087-0.14,0.129-0.211 c0.174-0.293,0.36-0.577,0.557-0.851c0.049-0.068,0.1-0.135,0.151-0.202c0.18-0.238,0.37-0.467,0.568-0.688 c0.069-0.077,0.138-0.155,0.209-0.23c0.196-0.208,0.402-0.405,0.613-0.596c0.075-0.068,0.148-0.138,0.225-0.204 c0.248-0.212,0.505-0.411,0.77-0.6c0.042-0.03,0.082-0.063,0.124-0.093c1.305-0.902,2.804-1.52,4.412-1.79l0.021-0.003 C44.778,35.064,45.381,35,46,35c0.389,0,0.776,0.021,1.16,0.063c0.06,0.006,0.118,0.02,0.178,0.027 c0.328,0.041,0.655,0.09,0.978,0.16c0.04,0.009,0.078,0.021,0.117,0.03c0.344,0.079,0.685,0.171,1.022,0.284 c0.023,0.008,0.045,0.017,0.068,0.025c0.345,0.118,0.685,0.253,1.022,0.406C54.347,37.729,57,41.557,57,46 C57,52.065,52.065,57,46,57z">
                                        </path>
                                    </g>
                                </svg>
                            </div>
                            <div>
                                <h4 class="mb-0">
                                    {{ isset($eventTranslations['start_date_label_text']) ? $eventTranslations['start_date_label_text'] : '' }}
                                </h4>
                                <p class="text-sm text-gray-500">
                                    {{ isset($event->start_date) ? date('F d, Y', strtotime($event->start_date)) : '' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start py-4 border-b ">
                            <div>
                                <svg version="1.1" xmlns="https://www.w3.org/2000/svg"
                                    class="w-6 h-7 fill-primary mt-2 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'ml-4' : 'mr-4' }}"
                                    xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 59 59"
                                    xml:space="preserve">
                                    <g>
                                        <path
                                            d="M50.95,41.13c-0.391-0.391-1.023-0.391-1.414,0L46,44.666l-3.536-3.536c-0.391-0.391-1.023-0.391-1.414,0 s-0.391,1.023,0,1.414l3.536,3.536l-3.536,3.536c-0.391,0.391-0.391,1.023,0,1.414c0.195,0.195,0.451,0.293,0.707,0.293 s0.512-0.098,0.707-0.293L46,47.494l3.536,3.536c0.195,0.195,0.451,0.293,0.707,0.293s0.512-0.098,0.707-0.293 c0.391-0.391,0.391-1.023,0-1.414l-3.536-3.536l3.536-3.536C51.34,42.153,51.34,41.521,50.95,41.13z">
                                        </path>
                                        <path
                                            d="M52,34.479V15V5c0-0.553-0.448-1-1-1h-5V1c0-0.553-0.448-1-1-1h-7c-0.552,0-1,0.447-1,1v3H15V1c0-0.553-0.448-1-1-1H7 C6.448,0,6,0.447,6,1v3H1C0.448,4,0,4.447,0,5v10v41c0,0.553,0.448,1,1,1h38.104c2.002,1.26,4.362,2,6.896,2 c7.168,0,13-5.832,13-13C59,40.997,56.154,36.651,52,34.479z M39,2h5v3v3h-5V5V2z M8,2h5v3v3H8V5V2z M2,6h4v3c0,0.553,0.448,1,1,1 h7c0.552,0,1-0.447,1-1V6h22v3c0,0.553,0.448,1,1,1h7c0.552,0,1-0.447,1-1V6h4v8H2V6z M2,55V16h48v17.636 c-0.196-0.063-0.396-0.114-0.596-0.169c-0.185-0.051-0.37-0.101-0.557-0.144c-0.169-0.038-0.34-0.071-0.511-0.102 c-0.244-0.045-0.489-0.082-0.735-0.113c-0.137-0.017-0.273-0.036-0.411-0.049C46.796,33.024,46.399,33,46,33 c-0.338,0-0.669,0.025-1,0.051V32v-2v-9h-9h-2h-7h-2h-7h-2H7v9v2v7v2v9h9h2h7h2h6.636c0.029,0.088,0.065,0.173,0.095,0.26 c0.084,0.243,0.167,0.487,0.266,0.724c0.055,0.133,0.12,0.26,0.18,0.39c0.115,0.254,0.232,0.507,0.363,0.753 c0.058,0.107,0.123,0.21,0.184,0.316c0.148,0.259,0.298,0.515,0.464,0.763c0.061,0.091,0.128,0.177,0.191,0.267 c0.176,0.25,0.356,0.498,0.551,0.736c0.072,0.088,0.15,0.17,0.224,0.256c0.155,0.18,0.303,0.364,0.468,0.536H2z M40.313,34.328 c-0.108,0.052-0.218,0.101-0.324,0.156c-0.188,0.098-0.37,0.206-0.552,0.313c-0.159,0.093-0.318,0.188-0.473,0.287 c-0.157,0.102-0.31,0.206-0.462,0.314c-0.173,0.122-0.341,0.25-0.508,0.38c-0.134,0.105-0.268,0.209-0.397,0.32 c-0.175,0.148-0.342,0.305-0.509,0.462c-0.115,0.109-0.234,0.214-0.345,0.326c-0.181,0.184-0.352,0.379-0.522,0.574 c-0.072,0.083-0.151,0.159-0.222,0.244V32h7v1.362c-0.017,0.004-0.033,0.01-0.049,0.014C42.029,33.599,41.147,33.92,40.313,34.328z M33.57,42.199c-0.035,0.115-0.058,0.233-0.09,0.349c-0.08,0.29-0.162,0.58-0.222,0.879c-0.047,0.231-0.073,0.467-0.107,0.701 c-0.027,0.189-0.065,0.375-0.085,0.567C33.023,45.126,33,45.562,33,46c0,0.361,0.02,0.726,0.053,1.092 c0.006,0.067,0.006,0.135,0.013,0.202c0.016,0.162,0.048,0.319,0.07,0.479c0,0,0,0.001,0,0.001 c0.011,0.076,0.015,0.151,0.027,0.226H27v-7h7v0.007c-0.01,0.024-0.016,0.049-0.026,0.073 C33.824,41.445,33.687,41.818,33.57,42.199z M9,41h7v7H9V41z M9,32h7v7H9V32z M43,30h-7v-7h7V30z M34,30h-7v-7h7V30z M34,39h-7v-7 h7V39z M18,32h7v7h-7V32z M25,30h-7v-7h7V30z M16,30H9v-7h7V30z M18,41h7v7h-7V41z M46,57c-2.258,0-4.359-0.686-6.107-1.858 c-0.341-0.228-0.663-0.476-0.972-0.736c-0.108-0.092-0.21-0.19-0.314-0.286c-0.197-0.179-0.388-0.363-0.57-0.554 c-0.117-0.123-0.23-0.248-0.341-0.375c-0.164-0.189-0.318-0.384-0.468-0.583c-0.096-0.127-0.195-0.25-0.286-0.381 c-0.221-0.321-0.429-0.651-0.615-0.993c-0.043-0.08-0.077-0.164-0.118-0.245c-0.146-0.286-0.282-0.576-0.403-0.874 c-0.052-0.13-0.097-0.263-0.145-0.395c-0.094-0.262-0.18-0.528-0.255-0.797c-0.017-0.062-0.032-0.124-0.048-0.186 c-0.113-0.44-0.196-0.877-0.255-1.312c-0.004-0.031-0.01-0.062-0.014-0.094C35.031,46.882,35,46.437,35,46 c0-0.379,0.019-0.755,0.058-1.128c0.003-0.031,0.011-0.061,0.014-0.092c0.038-0.341,0.088-0.681,0.158-1.016 c0.007-0.032,0.018-0.063,0.025-0.095c0.072-0.332,0.157-0.662,0.26-0.988c0.012-0.038,0.029-0.075,0.041-0.113 c0.103-0.312,0.217-0.622,0.349-0.926c0.124-0.286,0.258-0.567,0.405-0.84l0.099-0.171c0.04-0.072,0.087-0.14,0.129-0.211 c0.174-0.293,0.36-0.577,0.557-0.851c0.049-0.068,0.1-0.135,0.151-0.202c0.18-0.238,0.37-0.467,0.568-0.688 c0.069-0.077,0.138-0.155,0.209-0.23c0.196-0.208,0.402-0.405,0.613-0.596c0.075-0.068,0.148-0.138,0.225-0.204 c0.248-0.212,0.505-0.411,0.77-0.6c0.042-0.03,0.082-0.063,0.124-0.093c1.305-0.902,2.804-1.52,4.412-1.79l0.021-0.003 C44.778,35.064,45.381,35,46,35c0.389,0,0.776,0.021,1.16,0.063c0.06,0.006,0.118,0.02,0.178,0.027 c0.328,0.041,0.655,0.09,0.978,0.16c0.04,0.009,0.078,0.021,0.117,0.03c0.344,0.079,0.685,0.171,1.022,0.284 c0.023,0.008,0.045,0.017,0.068,0.025c0.345,0.118,0.685,0.253,1.022,0.406C54.347,37.729,57,41.557,57,46 C57,52.065,52.065,57,46,57z">
                                        </path>
                                    </g>
                                </svg>
                            </div>
                            <div>
                                <h4 class="mb-0">
                                    {{ isset($eventTranslations['end_date_label_text']) ? $eventTranslations['end_date_label_text'] : '' }}
                                </h4>
                                <p class="text-sm text-gray-500">
                                    {{ isset($event->end_date) ? date('F d, Y', strtotime($event->end_date)) : '' }}</p>
                            </div>
                        </div>
                        {{-- <div class="flex items-start py-4 border-b ">
                            <div>
                                <svg version="1.1" xmlns="https://www.w3.org/2000/svg"
                                    class="w-6 h-6 fill-primary mt-2 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'ml-4' : 'mr-4' }}"
                                    xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 54.757 54.757"
                                    xml:space="preserve">
                                    <g>
                                        <path
                                            d="M27.557,12c-3.859,0-7,3.141-7,7s3.141,7,7,7s7-3.141,7-7S31.416,12,27.557,12z M27.557,24c-2.757,0-5-2.243-5-5 s2.243-5,5-5s5,2.243,5,5S30.314,24,27.557,24z">
                                        </path>
                                        <path
                                            d="M40.94,5.617C37.318,1.995,32.502,0,27.38,0c-5.123,0-9.938,1.995-13.56,5.617c-6.703,6.702-7.536,19.312-1.804,26.952 L27.38,54.757L42.721,32.6C48.476,24.929,47.643,12.319,40.94,5.617z M41.099,31.431L27.38,51.243L13.639,31.4 C8.44,24.468,9.185,13.08,15.235,7.031C18.479,3.787,22.792,2,27.38,2s8.901,1.787,12.146,5.031 C45.576,13.08,46.321,24.468,41.099,31.431z">
                                        </path>
                                    </g>
                                </svg>
                            </div>
                        </div> --}}
                        <div class="flex items-start py-4 border-b ">
                            <div>
                                <svg version="1.1" xmlns="https://www.w3.org/2000/svg"
                                    class="w-6 h-6 fill-primary mt-2 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'ml-4' : 'mr-4' }}"
                                    xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 55.017 55.017"
                                    xml:space="preserve">
                                    <g>
                                        <path
                                            d="M51.688,23.013H40.789c-0.553,0-1,0.447-1,1s0.447,1,1,1h9.102l2.899,27H2.268l3.403-27h9.118c0.553,0,1-0.447,1-1 s-0.447-1-1-1H3.907L0,54.013h55.017L51.688,23.013z">
                                        </path>
                                        <path
                                            d="M26.654,38.968c-0.147,0.087-0.304,0.164-0.445,0.255c-0.22,0.142-0.435,0.291-0.646,0.445 c-0.445,0.327-0.541,0.953-0.215,1.398c0.196,0.267,0.5,0.408,0.808,0.408c0.205,0,0.412-0.063,0.591-0.193 c0.178-0.131,0.359-0.257,0.548-0.379c0.321-0.208,0.662-0.403,1.014-0.581c0.468-0.237,0.658-0.791,0.462-1.269 c0.008-0.008,0.018-0.014,0.025-0.022c1.809-1.916,7.905-9.096,10.429-21.058c0.512-2.426,0.627-4.754,0.342-6.919 c-0.86-6.575-4.945-10.051-11.813-10.051c-6.866,0-10.951,3.476-11.813,10.051c-0.284,2.166-0.169,4.494,0.343,6.919 C18.783,29.818,24.783,36.97,26.654,38.968z M17.924,11.314c0.733-5.592,3.949-8.311,9.831-8.311c5.883,0,9.098,2.719,9.83,8.311 c0.255,1.94,0.148,4.043-0.316,6.247C35,28.314,29.59,35.137,27.755,37.207c-1.837-2.072-7.246-8.898-9.514-19.646 C17.776,15.357,17.67,13.255,17.924,11.314z">
                                        </path>
                                        <path
                                            d="M27.755,19.925c4.051,0,7.346-3.295,7.346-7.346s-3.295-7.346-7.346-7.346s-7.346,3.295-7.346,7.346 S23.704,19.925,27.755,19.925z M27.755,7.234c2.947,0,5.346,2.398,5.346,5.346s-2.398,5.346-5.346,5.346s-5.346-2.398-5.346-5.346 S24.808,7.234,27.755,7.234z">
                                        </path>
                                        <path
                                            d="M31.428,37.17c-0.54,0.114-0.884,0.646-0.769,1.187c0.1,0.47,0.515,0.791,0.977,0.791c0.069,0,0.14-0.007,0.21-0.022 c0.586-0.124,1.221-0.229,1.886-0.313c0.548-0.067,0.938-0.567,0.869-1.115c-0.068-0.549-0.563-0.945-1.115-0.869 C32.763,36.918,32.07,37.033,31.428,37.17z">
                                        </path>
                                        <path
                                            d="M36.599,37.576c0.022,0.537,0.466,0.957,0.998,0.957c0.015,0,0.029,0,0.044-0.001l2.001-0.083 c0.551-0.025,0.979-0.493,0.953-1.044c-0.025-0.553-0.539-0.984-1.044-0.954l-1.996,0.083 C37.003,36.557,36.575,37.023,36.599,37.576z">
                                        </path>
                                        <path
                                            d="M22.433,42.177c-0.514,0.388-1.045,0.761-1.58,1.107c-0.463,0.301-0.595,0.92-0.294,1.384 c0.191,0.295,0.513,0.455,0.84,0.455c0.187,0,0.375-0.052,0.544-0.161c0.573-0.372,1.144-0.772,1.695-1.188 c0.44-0.333,0.528-0.96,0.196-1.401C23.501,41.936,22.876,41.844,22.433,42.177z">
                                        </path>
                                        <path
                                            d="M44.72,35.583c-0.338,0.237-0.777,0.409-1.346,0.526c-0.541,0.111-0.889,0.641-0.777,1.182 c0.098,0.473,0.514,0.798,0.979,0.798c0.067,0,0.135-0.007,0.203-0.021c0.842-0.174,1.526-0.452,2.096-0.853l0.134-0.098 c0.44-0.334,0.527-0.961,0.194-1.401c-0.334-0.44-0.96-0.526-1.401-0.194L44.72,35.583z">
                                        </path>
                                        <path
                                            d="M8.86,43.402c0.145-0.533-0.171-1.082-0.704-1.226c-0.529-0.149-1.082,0.169-1.226,0.704 c-0.126,0.464-0.201,0.938-0.225,1.405C6.7,44.4,6.697,44.516,6.697,44.638c0.001,0.196,0.01,0.392,0.029,0.587 c0.053,0.515,0.487,0.898,0.994,0.898c0.033,0,0.067-0.002,0.103-0.005c0.549-0.057,0.949-0.547,0.894-1.097 c-0.014-0.131-0.019-0.264-0.02-0.39c0-0.083,0.003-0.166,0.007-0.248C8.72,44.059,8.772,43.728,8.86,43.402z">
                                        </path>
                                        <path
                                            d="M44.698,27.81c-0.794-0.106-1.604-0.041-2.386,0.181c-0.532,0.149-0.841,0.702-0.69,1.233 c0.124,0.441,0.525,0.729,0.961,0.729c0.091,0,0.182-0.012,0.272-0.038c0.52-0.146,1.055-0.192,1.575-0.122 c0.562,0.07,1.052-0.311,1.125-0.857C45.629,28.387,45.245,27.884,44.698,27.81z">
                                        </path>
                                        <path
                                            d="M46.688,32.764c-0.163,0.527,0.133,1.088,0.66,1.25c0.099,0.031,0.197,0.045,0.295,0.045c0.428,0,0.823-0.275,0.955-0.705 c0.099-0.318,0.16-0.641,0.183-0.963c0.005-0.083,0.008-0.167,0.008-0.25c0-0.468-0.086-0.937-0.255-1.392 c-0.192-0.519-0.771-0.781-1.285-0.59c-0.519,0.192-0.782,0.768-0.59,1.285c0.086,0.232,0.13,0.467,0.13,0.696l-0.003,0.117 C46.774,32.423,46.742,32.589,46.688,32.764z">
                                        </path>
                                        <path
                                            d="M17.481,45.164c-0.586,0.275-1.183,0.53-1.774,0.759c-0.515,0.198-0.771,0.777-0.572,1.293 c0.153,0.396,0.531,0.64,0.933,0.64c0.12,0,0.242-0.021,0.36-0.067c0.635-0.245,1.275-0.519,1.903-0.813 c0.5-0.234,0.715-0.83,0.48-1.33C18.578,45.145,17.984,44.928,17.481,45.164z">
                                        </path>
                                        <path
                                            d="M10.201,41.001c0.161,0,0.325-0.039,0.478-0.122c0.288-0.157,0.595-0.255,0.911-0.289c0.135-0.016,0.273-0.016,0.406,0.002 c0.563,0.073,1.05-0.313,1.122-0.86c0.072-0.548-0.313-1.05-0.86-1.122c-0.298-0.039-0.601-0.041-0.891-0.008 c-0.574,0.063-1.128,0.239-1.646,0.521c-0.485,0.265-0.664,0.871-0.399,1.356C9.504,40.813,9.847,41.001,10.201,41.001z">
                                        </path>
                                        <path
                                            d="M9.993,48.842c0.216,0.056,0.436,0.098,0.654,0.124c0.256,0.031,0.512,0.047,0.769,0.047c0.313,0,0.627-0.022,0.94-0.062 c0.548-0.069,0.937-0.569,0.867-1.117s-0.567-0.934-1.117-0.867c-0.404,0.052-0.812,0.064-1.216,0.015 c-0.132-0.017-0.264-0.042-0.394-0.075c-0.535-0.143-1.08,0.181-1.22,0.716C9.139,48.158,9.459,48.704,9.993,48.842z">
                                        </path>
                                    </g>
                                </svg>
                            </div>
                            <div>
                                <h4 class="mb-0">
                                    {{ isset($eventTranslations['venue_label_text']) ? $eventTranslations['venue_label_text'] : '' }}
                                </h4>
                                <p class="text-sm text-gray-500">
                                    {{ isset($event->veneue) ? $event->veneue : '' }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ isset($event->location) ? $event->location : '' }}</p>
                            </div>
                        </div>
                        {{-- <div class="flex items-start py-4 border-b ">
                            <div>
                                <svg version="1.1" xmlns="https://www.w3.org/2000/svg"
                                    class="w-6 h-6 fill-primary mt-2 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'ml-4' : 'mr-4' }}"
                                    xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60"
                                    xml:space="preserve">
                                    <path
                                        d="M44.18,20l9.668-15.47c0.193-0.309,0.203-0.697,0.027-1.015C53.698,3.197,53.363,3,53,3H8V1c0-0.553-0.447-1-1-1 S6,0.447,6,1v3v29v3v23c0,0.553,0.447,1,1,1s1-0.447,1-1V37h45c0.363,0,0.698-0.197,0.875-0.516 c0.176-0.317,0.166-0.706-0.027-1.015L44.18,20z M8,35v-2V5h43.195l-9.043,14.47c-0.203,0.324-0.203,0.736,0,1.061L51.195,35H8z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="mb-0">
                                    {{ isset($eventTranslations['state_province_label_text']) ? $eventTranslations['state_province_label_text'] : '' }}
                                </h4>
                                <p class="text-sm text-gray-500">
                                    {{ isset($event->state_province) ? $event->state_province : '' }}</p>
                            </div>
                        </div> --}}

                        <div class="flex items-start py-4 ">
                            <div>
                                <svg version="1.1" xmlns="https://www.w3.org/2000/svg"
                                    class="w-6 h-6 fill-primary mt-2 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'ml-4' : 'mr-4' }}"
                                    xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 58.995 58.995"
                                    xml:space="preserve">
                                    <path
                                        d="M39.927,41.929c-0.524,0.524-0.975,1.1-1.365,1.709l-17.28-10.489c0.457-1.144,0.716-2.388,0.716-3.693 c0-1.305-0.259-2.549-0.715-3.693l17.284-10.409C40.342,18.142,43.454,20,46.998,20c5.514,0,10-4.486,10-10s-4.486-10-10-10 s-10,4.486-10,10c0,1.256,0.243,2.454,0.667,3.562L20.358,23.985c-1.788-2.724-4.866-4.529-8.361-4.529c-5.514,0-10,4.486-10,10 s4.486,10,10,10c3.495,0,6.572-1.805,8.36-4.529L37.661,45.43c-0.43,1.126-0.664,2.329-0.664,3.57c0,2.671,1.04,5.183,2.929,7.071 c1.949,1.949,4.51,2.924,7.071,2.924s5.122-0.975,7.071-2.924c1.889-1.889,2.929-4.4,2.929-7.071s-1.04-5.183-2.929-7.071 C50.169,38.029,43.826,38.029,39.927,41.929z M46.998,2c4.411,0,8,3.589,8,8s-3.589,8-8,8s-8-3.589-8-8S42.586,2,46.998,2z M11.998,37.456c-4.411,0-8-3.589-8-8s3.589-8,8-8s8,3.589,8,8S16.409,37.456,11.998,37.456z M52.654,54.657 c-3.119,3.119-8.194,3.119-11.313,0c-1.511-1.511-2.343-3.521-2.343-5.657s0.832-4.146,2.343-5.657 c1.56-1.56,3.608-2.339,5.657-2.339s4.097,0.779,5.657,2.339c1.511,1.511,2.343,3.521,2.343,5.657S54.166,53.146,52.654,54.657z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="mb-0">
                                    {{ isset($eventTranslations['network_label_text']) ? $eventTranslations['network_label_text'] : '' }}
                                </h4>
                                <div class="flex space-x-1 items-center mt-2">
                                    @php
                                    function formatUrl($url) {
                                        return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
                                    }
                                @endphp
                                @if (!empty($event->facebook_url))
                                    <a href="{{ isset($event->facebook_url) ? formatUrl( $event->facebook_url) : '#' }}"
                                        class="bg-white text-primary hover:border-primary border rounded-full w-9 h-9 items-center flex justify-center">
                                        <span class="sr-only"></span>
                                        <img class="h-5" src="{{ asset('/assets/social-icons/facebook.png') }}"
                                            alt="">
                                    </a>
                                    @endif
                                    @if (!empty($event->facebook_url))
                                    <a href="{{ isset($event->twitter_url) ? formatUrl($event->twitter_url) : '#' }}"
                                        class="bg-white text-primary hover:border-primary border rounded-full w-9 h-9 items-center flex justify-center">
                                        <span class="sr-only"></span>
                                        <img class="h-4" src="{{ asset('/assets/social-icons/twitter.png') }}"
                                            alt="">
                                    </a>
                                    @endif
                                    @if (!empty($event->facebook_url))
                                    <a href="{{ isset($event->instagram_url) ? formatUrl($event->instagram_url) : '#' }}"
                                        class="bg-white text-primary hover:border-primary border rounded-full w-9 h-9 items-center flex justify-center">
                                        <span class="sr-only"></span>
                                        <img class="h-5" src="{{ asset('/assets/social-icons/instagaram.png') }}"
                                            alt="">
                                    </a>
                                    @endif

                                    @if (!empty($event->facebook_url))
                                    <a href="{{ isset($event->linkedin_url) ? formatUrl($event->linkedin_url) : '#' }}"
                                        class="bg-white text-primary hover:border-primary border rounded-full w-9 h-9 items-center flex justify-center">
                                        <span class="sr-only"></span>
                                        <img class="h-4" src="{{ asset('/assets/social-icons/linkedin.png') }}"
                                            alt="">
                                    </a>
                                    @endif
                                    @if (!empty($event->facebook_url))
                                    <a href="{{ isset($event->youtube_url) ? formatUrl($event->youtube_url) : '#' }}"
                                        class="bg-white text-primary hover:border-primary border rounded-full w-9 h-9 items-center flex justify-center">
                                        <span class="sr-only"></span>
                                        <img class="h-3.5" src="{{ asset('/assets/social-icons/youtube.png') }}"
                                            alt="">
                                    </a>
                                    @endif
                                    @if (!empty($event->facebook_url))
                                    <a href="{{ isset($event->snapchat_url) ? formatUrl($event->snapchat_url) : '#' }}"
                                        class="bg-white text-primary hover:border-primary border rounded-full w-9 h-9 items-center flex justify-center">
                                        <span class="sr-only"></span>
                                        <img class="h-5" src="{{ asset('/assets/social-icons/snapchat.png') }}"
                                            alt="">
                                    </a>
                                    @endif
                                    @if (!empty($event->facebook_url))
                                    <a href="{{ isset($event->pintrest_url) ? formatUrl($event->pintrest_url) : '#' }}"
                                        class="bg-white text-primary hover:border-primary border rounded-full w-9 h-9 items-center flex justify-center">
                                        <span class="sr-only"></span>
                                        <img class="h-5" src="{{ asset('/assets/social-icons/pintrest.png') }}"
                                            alt="">
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 border rounded-lg overflow-hidden mt-4">
                    <div class="border-b bg-primary py-3 px-4">
                        <h4 class="mb-0 text-white">
                            {{ isset($eventTranslations['contact_tab_text']) ? $eventTranslations['contact_tab_text'] : '' }}
                        </h4>
                    </div>
                    @foreach ($event->eventContact as $contact)
                        <div class="grid grid-cols-3 gap-2 p-2 border-b card_bg">
                            <div class="w-full h-24 bg-gray-50 border rounded">
                                {{-- <img class="w-full h-full object-contain" src="{{ asset('assets/financial-help-03.jpg') }}" alt=""> --}}
                                                {{-- <img class="w-full h-full object-contain" src="{{ isset($contact->contact_photo) ? asset($contact->contact_photo) : asset('assets/default-image.jpg') }}" alt="Contact Photo"> --}}
                                                <event-contact-image 
                                                contact_image="{{ $contact->contact_photo ? asset($contact->contact_photo) : 'https://www.w3schools.com/howto/img_avatar.png' }}"
                                                default_image="https://www.w3schools.com/howto/img_avatar.png">
                                            </event-contact-image>
                                            

                                            </div>
                            <div class="col-span-2 p-2">
                                <h6 class="text-black mb-1 text-xl font-medium font-FuturaMdCnBT">
                                    {{ isset($contact->contact_name) ? $contact->contact_name : '' }}</h6>
                                {{-- <p>{{ isset($contact->contact_title) ? $contact->contact_title : '' }}</p> --}}
                                <p class="text-sm">{{ isset($contact->contact_email) ? $contact->contact_email : '' }}</p>
                                <p class="text-sm">{{ isset($contact->contact_phone) ? $contact->contact_phone : '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function loadScript() {
            const scriptPlaceholder = document.getElementById('script-placeholder');
            const script = document.createElement('script');
            script.src = 'https://www.google.com/recaptcha/api.js';
            scriptPlaceholder.appendChild(script);
        }

        window.addEventListener('load', function() {
            const iframeHtml = `{!! isset($event->video_url)
                ? $event->video_url
                : null !!}`;

                if(iframeHtml){
                    const iframePlaceholder = document.getElementById('iframe-placeholder');
                    iframePlaceholder.innerHTML = iframeHtml;
        
                    loadScript();
                }

        });
    </script>
@endsection
