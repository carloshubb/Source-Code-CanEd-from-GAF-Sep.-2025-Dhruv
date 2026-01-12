@extends('front.layouts.account')
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full relative">
        
        <div class=" flex justify-between items-center gap-2 p-4 pb-0">
            <h2 class="can-school-h2 text-primary">Our events</h2>
          
        </div>

        <div class="p-4">
            @if (count($events) > 0)
            <div class="mt-8 text-center flex justify-between items-center">      
                <a href="{{ url(app()->getLocale().'/events') }}" class="flex-grow mx-2">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                        Explore events
                    </button>
                </a>
                <a href="{{ route('web.account.event.create', ['lang' => app()->getLocale(), 'slug' => auth()->guard('customers')->user()->slug]) }}" class="flex-grow mx-2">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                        Add your own event
                    </button>
                </a>
            </div>
            @php
            $userEvents = $events->where('customer_id', Auth::guard('customers')->user()->id);
            $favEvents = $events->whereNotIn('id', $userEvents->pluck('id'));
        @endphp

            @if ($userEvents->count() > 0)
            <h2 class="text-2xl font-bold mt-6 mb-3">Our events</h2>
            @foreach ($userEvents as $event)
            <div class="mt-4 card_bg border border-gray-300 rounded-lg shadow-md px-4 py-4 md:py-2 relative">
                <div class="absolute top-3 right-3 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-primary">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                      </svg>
                                                    
                </div>
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
                        <div class="mt-1 text-gray-500 can-edu-card-p line-clamp-3">
                            {!!isset($event->eventDetail[0]->short_description) ? $event->eventDetail[0]->short_description : '' !!}
                        </div>
                        @php
                            $url = '#';
                            if (isset($event->eventDetail[0])) {
                                $url =  url('/'.getDefaultLanguage(1)['abbreviation'].'/event/' . $event->slug);
                            }
                        @endphp
                        <div class="mt-4 flex justify-start gap-2">
                            <a href="{{ $url }}"><button class="can-edu-btn-fill">View</button></a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            @endforeach
            @endif

            @if ($favEvents->count() > 0)
            <h2 class="text-2xl font-bold mt-6 mb-3">Favorite events</h2>
            @foreach ($favEvents as $event)
            <div class="mt-4 card_bg border border-gray-300 rounded-lg shadow-md px-4 py-4 md:py-2 relative">
                <div class="absolute top-3 right-3 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-primary">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                      </svg>                              
                </div>
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
                        <div class="mt-1 text-gray-500 can-edu-card-p line-clamp-3">
                            {!!isset($event->eventDetail[0]->short_description) ? $event->eventDetail[0]->short_description : '' !!}
                        </div>
                        @php
                            $url = '#';
                            if (isset($event->eventDetail[0])) {
                                $url =  url('/'.getDefaultLanguage(1)['abbreviation'].'/event/' . $event->slug);
                            }
                        @endphp
                        <div class="mt-4 flex justify-start gap-2">
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
            @endif

            
            @else
            <div class="md:col-span-8 col-span-12 w-full">
                <div class="border border-blue-700 rounded-md p-5">
                    <div class="border border-primary rounded p-4">
                            <p>You do not have any Favorite events yet.. </p>
                        <p>
                            Make sure to visit our “Events” page; it has plenty of 
                            helpful content from Proxima Study, from schools, as well as from fellow 
                            students that we are sure you will find useful
                        </p>
                    </div>
                </div>
                <div class="mt-8 text-center flex justify-between items-center">
                    <a href="{{ url(app()->getLocale().'/events') }}" class="can-edu-btn-fill flex-grow mx-2">
                        Explore Events
                    </a>
                    <a href="{{ route('web.event.create', ['lang' => app()->getLocale()]) }}" class="flex-grow mx-2">
                        <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                            Add your own event
                        </button>
                    </a>
                </div>
                
            </div>
            @endif
        </div>
    </div>
@endsection
