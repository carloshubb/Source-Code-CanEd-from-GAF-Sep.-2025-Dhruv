@extends('front.layouts.account')
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full relative">

        <h1 class="px-4 pt-4 can-school-h1">Favorite events</h1>
        <div class="p-4">
            @if (count($events) > 0)
            {{-- <div class="mt-8 text-center flex justify-between items-center">       --}}
            <div class="absolute top-4 right-3">      
                <a href="{{ url(app()->getLocale().'/events') }}" class="flex-grow mx-2 ">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                        Explore events
                    </button>
                </a>
                {{-- <a href="{{ route('web.account.event.create', ['lang' => app()->getLocale()]) }}" class="flex-grow mx-2">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                        Add your own event
                    </button>
                </a> --}}
            </div>
            <div class="space-y-4">
                @foreach ($events as $event)
                <div class="mt-4 card_bg border border-gray-300 rounded-lg shadow-md px-4 py-4 md:py-2 relative">
                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                        <div class="w-48 h-48 rounded-lg border bg-gray-200 flex-shrink-0 px-2 mx-auto">
                            <img class="h-full w-full object-contain"
                                src="{{ isset($event->eventImage->thumbnail_image) ? asset($event->eventImage->thumbnail_image) : '' }}" alt="">
                        </div>
                        <div class="md:p-4 flex-1">
                            <div>
                                <p class="text-xl lg:text-2xl font-FuturaMdCnBT">
                                    {{ isset($event->eventDetail[0]->title) ? $event->eventDetail[0]->title : '' }}
                                </p>
                                <div class="mt-1 text-gray-500 can-edu-card-p line-clamp-5">
                                    {!!isset($event->eventDetail[0]->short_description) ? $event->eventDetail[0]->short_description : '' !!}
                                </div>
                                @php
                                    $url = '#';
                                    if (isset($event->eventDetail[0])) {
                                        $url =  url('/'.getDefaultLanguage(1)['abbreviation'].'/event/' . $event->slug);
                                    }
                                @endphp
                                <div class="mt-4 flex justify-end gap-2">
                                    <a href="{{ $url }}"><button class="can-edu-btn-fill">View</button></a>
                                </div>
                                <remove-fav-icon
                                 record_id="{{ $event->id }}" model="event"
                                   />
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
                <div class="md:col-span-8 col-span-12 w-full mt-4">
                    <p>You do not have any Favorite events yet</p>
                    <div class="text-center absolute top-4 right-3">
                        {{-- <button class="can-edu-btn-fill">Explore
                            Events </button> --}}
                            <a href="{{ url(app()->getLocale().'/events') }}" class="flex-grow mx-2">
                                <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                                    Explore events
                                </button>
                            </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
