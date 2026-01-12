@extends('front.layouts.app')
@section('content')
    <?php $liveStromWebinar = isset($webinar->live_strom_webinar) ? json_decode($webinar->live_strom_webinar, true) : [];
    // dd($liveStromWebinar['data']['attributes']['owner']['attributes']['first_name']);
    ?>
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-8">
                <div class="border-b-4 pb-2 border-primary w-full flex items-center justify-between">
                    <h1 class="can-edu-h1">
                        {{ isset($webinar->title) ? $webinar->title : '' }}
                    </h1>
                </div>
                <div class="mt-4 bg-white border rounded h-60 md:h-80 xl:h-96 w-full mx-auto">
                    <img class="w-full h-full object-contain"
                        src="{{ asset(largeImage($webinar->image)) }}" alt="">
                </div>

                <div class="text-black my-4">
                    <p class="text-ellipsis... overflow-hidden text-justify can-edu-p">
                        {!! isset($liveStromWebinar['data']['attributes']['description'])
                            ? $liveStromWebinar['data']['attributes']['description']
                            : '' !!}
                    </p>
                </div>
                <div class="sm:w-2/3 mx-auto">
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h5 class="font-bold text-lg">
                                    {{ isset($webinarTranslations['start_date_label_text']) ? $webinarTranslations['start_date_label_text'] : '' }}
                                </h5>
                            </div>
                            <div>
                                <p>
                                    {{ isset($webinar->start_date) ? date('F d, Y', strtotime($webinar->start_date)) : '' }} {{ isset($webinar->timezone) ? $webinar->timezone : '' }}
                                </p>
                            </div>

                            <div>
                                <h5 class="font-bold text-lg">
                                    {{ isset($webinarTranslations['orgnizer_label_text']) ? $webinarTranslations['orgnizer_label_text'] : 'Organizer' }}
                                </h5>
                            </div>
                            <div>
                                <p>
                                    {{ isset($webinar->schoolAmbassador->school->schoolDetail[0]->school_name) ? $webinar->schoolAmbassador->school->schoolDetail[0]->school_name : '' }} 
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h5 class="font-bold text-lg">
                                    {{ isset($webinarTranslations['speaker_label_text']) ? $webinarTranslations['speaker_label_text'] : 'Speaker' }}
                                </h5>
                            </div>
                            <div>
                                <p>
                                    {{ isset($liveStromWebinar['data']['attributes']['owner']['attributes']['first_name']) ? $liveStromWebinar['data']['attributes']['owner']['attributes']['first_name'] : '' }}
                                </p>
                            </div>
                            @if (isset($liveStromWebinar['included'][0]['attributes']['room_link']))
                                <a href="{{ $liveStromWebinar['included'][0]['attributes']['room_link'] }}">
                                    <button class="can-edu-btn-fill" target="_blank">
                                        {{ isset($webinarTranslations['join_webinar_button_text']) ? $webinarTranslations['join_webinar_button_text'] : '' }}
                                    </button>
                                </a>
                            @endif
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-4">
                <div class="border-b-4 pt-1 border-primary">
                    <h2 class="can-edu-h2">
                        {{ isset($webinarTranslations['more_heading_text']) ? $webinarTranslations['more_heading_text'] : '' }}
                        </p>
                </div>
                @foreach ($webinars as $webinar)
                    @php
                        $url = url('/' . getDefaultLanguage(1)['abbreviation'] . '/webinar/' . $webinar->id);
                       $liveStromWebinar = isset($webinar->live_strom_webinar) ? json_decode($webinar->live_strom_webinar, true) : [];
                    @endphp
                    <a href="{{ $url }}">
                        <div class="mt-4">
                            <div class="border p-3 border-gray-300 rounded grid grid-cols-12 gap-4">
                                <div class="col-span-4 sm:col-span-4 md:col-span-4 lg:col-span-4">
                                    <div class="h-24 w-full mx-auto bg-gray-50 border">
                                        <img class="w-full h-full mx-auto object-contain" src="{{ asset($webinar->image) }}"
                                            alt="">
                                    </div>
                                </div>
                                <div class="w-full text-black col-span-8 sm:col-span-8 md:col-span-8 lg:col-span-8">
                                    <p class="can-edu-card-h mb-1">
                                        {{ isset($webinar->title) ? $webinar->title : '' }}
                                    </p>
                                    <div class="can-edu-card-p line-clamp-3">
                                        {!! isset($liveStromWebinar['data']['attributes']['description'])
                                            ? $liveStromWebinar['data']['attributes']['description']
                                            : '' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
@endsection
