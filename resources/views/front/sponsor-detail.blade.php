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
                        {{ $sponsor->sponsorDetail[0]->title ?? '' }}
                    </h1>
                </div>
                <div class="mt-4 bg-white h-60 md:h-80 xl:h-96 border rounded">
                    @php
                        $image = isset($sponsor->sponsorImage->thumbnail_image)
                            ? $sponsor->sponsorImage->thumbnail_image
                            : '';
                    @endphp
                    <img class="w-full h-full object-contain mx-auto" src="{{ asset($image) }}" alt="">
                </div>

                <div class="text-black my-4 can-edu-p">
                    <p class="text-ellipsis... overflow-hidden">
                        {!! isset($sponsor->sponsorDetail[0]->description) ? $sponsor->sponsorDetail[0]->description : '' !!}
                    </p>
                </div>

                @isset($sponsor->sponsorDetail[0]->contact_person_name)

                <div class="mt-5">

                    <div class="bg-gray-100 border rounded-lg overflow-hidden">
                        <div class="border-b bg-primary py-3 px-4">
                            <h4 class="mb-0 text-white">
                                {{ isset($sponsorPageTranslation['contact_tab_text']) ? $sponsorPageTranslation['contact_tab_text'] : 'Contact information' }}
                            </h4>
                        </div>
                            <div class="grid grid-cols-4 gap-4 p-4 border-b card_bg">
                                <div class="col-span-3 p-4">
                                    <h6 class="text-black mb-1 text-xl font-medium font-FuturaMdCnBT">
                                        {{ $sponsor->sponsorDetail[0]->contact_person_name ?? '' }}</h6>
                                    <p>
                                        {{ $sponsor->contact_person_email ?? '' }}</p>
                                    <p>
                                        {{ $sponsor->contact_person_phone ?? '' }}</p>
                                </div>
                                @if (!empty($sponsor->contact_person_image))
                                <div class="flex items-center justify-center">
                                    <img src="{{ asset($sponsor->contact_person_image) }}" alt="Contact Person"
                                        class="w-32 h-32 object-cover border">
                                </div>
                            @endif
                            </div>
                    </div>
                </div>
                @endisset
            </div>
            <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-4">
                <div class="bg-white rounded border overflow-hidden mt-4">
                    <div class="bg-primary text-white font-FuturaMdCnBT text-xl p-2">
                        Sponsor's information
                    </div>
                    <div class="px-4 pb-4">
                        <div class="flex items-start py-4 border-b ">
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
                            <div>
                                <h4 class="mb-0">
                                    {{ isset($sponsorTranslations['start_date_label_text']) ? $sponsorTranslations['start_date_label_text'] : 'Location' }}
                                </h4>
                                <p class="text-sm text-gray-500">
                                    {{ $sponsor->country ?? '' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start py-4 border-b ">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                                class="w-6 h-6 text-primary mt-2 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'ml-4' : 'mr-4' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                </svg>                                  
                            </div>
                            <div>
                                <h4 class="mb-0">
                                    {{ isset($sponsorTranslations['venue_label_text']) ? $sponsorTranslations['venue_label_text'] : 'Website' }}
                                </h4>
                                {{-- <p class="text-sm text-gray-500">
                                    {{ $sponsor->url ?? '' }}</p> --}}
                                    <a class="text-sm text-primary" target="_blanK" href="{{ $sponsor->url ?? '' }}">{{ $sponsor->url ?? '' }}</a>
                            </div>
                           
                        </div>
                        
                        
                        
                        <div class="flex items-start pt-4">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" 
                                  class="w-6 h-6 fill-primary mt-2 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'ml-4' : 'mr-4' }}"
                                  viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M0 10.5A1.5 1.5 0 0 1 1.5 9h1A1.5 1.5 0 0 1 4 10.5v1A1.5 1.5 0 0 1 2.5 13h-1A1.5 1.5 0 0 1 0 11.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm10.5.5A1.5 1.5 0 0 1 13.5 9h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM6 4.5A1.5 1.5 0 0 1 7.5 3h1A1.5 1.5 0 0 1 10 4.5v1A1.5 1.5 0 0 1 8.5 7h-1A1.5 1.5 0 0 1 6 5.5zM7.5 4a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                                    <path d="M6 4.5H1.866a1 1 0 1 0 0 1h2.668A6.52 6.52 0 0 0 1.814 9H2.5q.186 0 .358.043a5.52 5.52 0 0 1 3.185-3.185A1.5 1.5 0 0 1 6 5.5zm3.957 1.358A1.5 1.5 0 0 0 10 5.5v-1h4.134a1 1 0 1 1 0 1h-2.668a6.52 6.52 0 0 1 2.72 3.5H13.5q-.185 0-.358.043a5.52 5.52 0 0 0-3.185-3.185"/>
                                  </svg>
                            </div>
                            
                            <div>
                                <h4 class="mb-0">
                                    {{ isset($sponsorTranslations['subsidiary_label_text']) ? $sponsorTranslations['subsidiary_label_text'] : 'Subsidiary' }}
                                </h4>
                                <p class="text-sm text-gray-500">
                                    {{ $sponsor->sponsorDetail[0]->subsidiary ?? '' }}</p>
                                    {{-- <a class="text-sm text-gray-500" target="_blanK" href="{{ $sponsor->url ?? '' }}">{{ $sponsor->url ?? '' }}</a> --}}
                            </div>
                           
                        </div>
                        

                        
                    </div>
                </div>
                @php
                $service1 = $sponsor->sponsorDetail[0]->service1_name ?? '';
                $service2 = $sponsor->sponsorDetail[0]->service2_name ?? '';
                $service3 = $sponsor->sponsorDetail[0]->service3_name ?? '';
                $service4 = $sponsor->sponsorDetail[0]->service4_name ?? '';
                $service5 = $sponsor->sponsorDetail[0]->service5_name ?? '';
                $service1URL = $sponsor->sponsorDetail[0]->service1_url ?? '';
                $service2URL = $sponsor->sponsorDetail[0]->service2_url ?? '';
                $service3URL = $sponsor->sponsorDetail[0]->service3_url ?? '';
                $service4URL = $sponsor->sponsorDetail[0]->service4_url ?? '';
                $service5URL = $sponsor->sponsorDetail[0]->service5_url ?? '';
                @endphp
                @if($service1 || $service2 || $service3 || $service4 || $service5)
                <div class="bg-white rounded border overflow-hidden mt-4">
                    <div class="bg-primary text-white font-FuturaMdCnBT text-xl p-2">
                        Services offered to the students
                    </div>
                    @php
    $service1URL = (filter_var($service1URL, FILTER_VALIDATE_URL)) ? $service1URL : 'https://' . ltrim($service1URL, 'www.');
    $service2URL = (filter_var($service2URL, FILTER_VALIDATE_URL)) ? $service2URL : 'https://' . ltrim($service2URL, 'www.');
    $service3URL = (filter_var($service3URL, FILTER_VALIDATE_URL)) ? $service3URL : 'https://' . ltrim($service3URL, 'www.');
    $service4URL = (filter_var($service4URL, FILTER_VALIDATE_URL)) ? $service4URL : 'https://' . ltrim($service4URL, 'www.');
    $service5URL = (filter_var($service5URL, FILTER_VALIDATE_URL)) ? $service5URL : 'https://' . ltrim($service5URL, 'www.');
@endphp
                    <div class="px-4 py-4 space-y-3">
                        @if($service1)
                        <div class="border border-primary text-primary rounded p-2 flex items-center justify-between">
                            {{$service1}}
                            @if($service1URL)
                                <a href="{{$service1URL}}" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m12.75 15 3-3m0 0-3-3m3 3h-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>                                      
                                    {{-- {{$service1URL}} --}}
                                </a>
                            @endif
                        </div>
                        @endif
                        @if($service2)
                        <div class="border border-primary text-primary rounded p-2 flex items-center justify-between">
                            {{$service2}}
                            @if($service2URL)
                                <a href="{{$service2URL}}" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m12.75 15 3-3m0 0-3-3m3 3h-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>                                      
                                    {{-- {{$service2URL}} --}}
                                </a>
                            @endif
                        </div>
                        @endif
                        @if($service3)
                        <div class="border border-primary text-primary rounded p-2 flex items-center justify-between">
                            {{$service3}}
                            @if($service3URL)
                                <a href="{{$service3URL}}" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m12.75 15 3-3m0 0-3-3m3 3h-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>                                      
                                    {{-- {{$service3URL}} --}}
                                </a>
                            @endif
                        </div>
                        @endif
                        @if($service4)
                        <div class="border border-primary text-primary rounded p-2 flex items-center justify-between">
                            {{$service4}}
                            @if($service4URL)
                                <a href="{{$service4URL}}" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m12.75 15 3-3m0 0-3-3m3 3h-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>                                      
                                    {{-- {{$service4URL}} --}}
                                </a>
                            @endif
                        </div>
                        @endif
                        @if($service5)
                        <div class="border border-primary text-primary rounded p-2 flex items-center justify-between">
                            {{$service5}}
                            @if($service5URL)
                                <a href="{{$service5URL}}" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m12.75 15 3-3m0 0-3-3m3 3h-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>                                      
                                    {{-- {{$service5URL}} --}}
                                </a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
@endsection
@section('scripts')
@endsection
