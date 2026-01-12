@extends('front.layouts.account')
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full relative">
        <h2 class="px-4 pt-4 can-school-h2 text-primary">Our businesses</h2>
        <div class="p-4">
            @if (count($business) > 0)
            <div class="absolute top-4 right-3">      
                <a href="{{ url(app()->getLocale().'/businesses') }}" class="flex-grow mx-2 ">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                        Explore businesses
                    </button>
                </a>
                <a href="{{ url(app()->getLocale().'/register-business') }}" class="flex-grow mx-2 ">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                        Create your own businesses
                    </button>
                </a>
            </div>
            @php
            $userBusinesses = $business->where('customer_id', Auth::guard('customers')->user()->id);
            $favBusinesses = $business->whereNotIn('id', $userBusinesses->pluck('id'));
        @endphp

        @if ($userBusinesses->count() > 0)
        @foreach ($userBusinesses as $business)
        <div class="mt-4 card_bg border border-gray-300 rounded-lg shadow-md px-4 py-4 md:py-2 relative">
            <div class="absolute top-3 right-3 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                  </svg>                              
            </div>
            <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                <div class="w-48 h-48 rounded-lg border bg-gray-200 flex-shrink-0 px-2 mx-auto">
                    <img src="{{ asset(thumbnailImage($business->image)) }}" class="h-full w-full object-contain" alt="">
                </div>
                <div class="md:p-4 flex-1">
                <div>
                    <p class="text-xl lg:text-2xl font-FuturaMdCnBT">
                        {{ isset($business->businessDetail[0]->business_name) ? $business->businessDetail[0]->business_name : '' }}
                    </p>
                    <div class="mt-1 text-gray-500 can-edu-card-p line-clamp-3">
                        {!! isset($business->businessDetail[0]) ? $business->businessDetail[0]->description : '' !!}
                    </div>
                    @php
                        $slug = isset($business->slug) ? $business->slug : '';
                        $url = '#';
                        if (isset($business->businessDetail[0])) {
                            $url = url('/'.getDefaultLanguage(1)['abbreviation'].'/business/' . $business->id . '/' . $slug);
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


        @if ($favBusinesses->count() > 0)
        <h2 class="pt-4 can-school-h2 text-primary">Favorite businesses</h2>
        @foreach ($favBusinesses as $business)
        <div class="mt-4 card_bg border border-gray-300 rounded-lg shadow-md px-4 py-4 md:py-2 relative">
            <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                <div class="w-48 h-48 rounded-lg border bg-gray-200 flex-shrink-0 px-2 mx-auto">
                    <img src="{{ asset(thumbnailImage($business->image)) }}" class="h-full w-full object-contain" alt="">
                </div>
                <div class="md:p-4 flex-1">
                <div>
                    <p class="text-xl lg:text-2xl font-FuturaMdCnBT">
                        {{ isset($business->businessDetail[0]->business_name) ? $business->businessDetail[0]->business_name : '' }}
                    </p>
                    <div class="mt-1 text-gray-500 can-edu-card-p line-clamp-3">
                        {!! isset($business->businessDetail[0]) ? $business->businessDetail[0]->description : '' !!}
                    </div>
                    @php
                        $slug = isset($business->slug) ? $business->slug : '';
                        $url = '#';
                        if (isset($business->businessDetail[0])) {
                            $url = url('/'.getDefaultLanguage(1)['abbreviation'].'/business/' . $business->id . '/' . $slug);
                        }
                    @endphp
                    <div class="mt-4 flex justify-start gap-2">
                        <a href="{{ $url }}"><button class="can-edu-btn-fill">View</button></a>
                    </div>
                    <remove-fav-icon
                    record_id="{{ $business->id }}" model="business"
                      />
                </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif




                {{-- @foreach ($businesses as $business)
                    <div class="mt-4 card_bg border border-gray-300 rounded-lg shadow-md px-4 py-4 md:py-2 relative">
                        <div class="absolute top-3 right-3 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-primary">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                              </svg>                              
                        </div>
                        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                            <div class="w-48 h-48 rounded-lg border bg-gray-200 flex-shrink-0 px-2 mx-auto">
                                <img src="{{ asset(thumbnailImage($business->image)) }}" class="h-full w-full object-contain" alt="">
                            </div>
                            <div class="md:p-4 flex-1">
                            <div>
                                <p class="text-xl lg:text-2xl font-FuturaMdCnBT">
                                    {{ isset($business->businessDetail[0]->business_name) ? $business->businessDetail[0]->business_name : '' }}
                                </p>
                                <div class="mt-1 text-gray-500 can-edu-card-p line-clamp-3">
                                    {!! isset($business->businessDetail[0]) ? $business->businessDetail[0]->description : '' !!}
                                </div>
                                @php
                                    $slug = isset($business->slug) ? $business->slug : '';
                                    $url = '#';
                                    if (isset($business->businessDetail[0])) {
                                        $url = url('/'.getDefaultLanguage(1)['abbreviation'].'/business/' . $business->id . '/' . $slug);
                                    }
                                @endphp
                                <div class="mt-4 flex justify-start gap-2">
                                    <a href="{{ $url }}"><button class="can-edu-btn-fill">View</button></a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                @endforeach --}}
            @else
            <div class="md:col-span-8 col-span-12 w-full">
                {{-- <div class="border border-blue-700 rounded-md p-5"> --}}
                    {{-- <div class="border border-primary rounded p-4"> --}}
                        <p>You do not have any Favorite businesses yet</p>
                    {{-- </div> --}}
                {{-- </div> --}}
                <div class="absolute top-4 right-3">      
                    <a href="{{ url(app()->getLocale().'/businesses') }}" class="flex-grow mx-2 ">
                        <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                            Explore businesses
                        </button>
                    </a>
                    <a href="{{ url(app()->getLocale().'/register-business') }}" class="flex-grow mx-2 ">
                        <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                            Create your own businesses
                        </button>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
