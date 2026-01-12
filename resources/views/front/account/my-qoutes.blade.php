@extends('front.layouts.account')
@php
    $loggedInCustomer = Auth::guard('customers')->check() ? Auth::guard('customers')->user() : null;
@endphp
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full relative">
        @if ($loggedInCustomer && $loggedInCustomer->user_type == 'school')
            <h2 class="px-4 pt-4 can-school-h2 text-primary">Our quotes</h2>
        @elseif ($loggedInCustomer && $loggedInCustomer->user_type == 'student')
            <h2 class="px-4 pt-4 can-school-h2 text-primary">My quotes</h2>
        @endif
        <div class="p-4 space-y-4">
           
            @if (count($quotes) > 0)
            <div class="absolute top-4 right-4 text-center flex justify-between items-center">
                <a href="{{ url(app()->getLocale().'/quotes') }}" class="flex-grow mx-2">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                        Explore quotes
                    </button>
                </a>
                {{-- <a href="{{ url(app()->getLocale().'/quotes') }}" class="flex-grow mx-2">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                        Create your own quotes
                    </button>
                </a> --}}
                <a href="{{ url(app()->getLocale().'/quotes') }}" class="flex-grow mx-2" onclick="localStorage.setItem('openModal', 'true')">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                        Create your own quotes
                    </button>
                </a>
                
                
            </div>
                @foreach ($quotes as $quote)
                <div class="mt-4 card_bg border border-gray-300 rounded-lg shadow-md px-4 py-4 md:py-2 relative">
                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                        <div class="w-48 h-48 rounded-lg border bg-gray-200 flex-shrink-0 px-2 mx-auto">
                            <img class="w-full h-full object-contain" src="{{ isset($quote->quoteImage->path) ? asset($quote->quoteImage->path) : '' }}" alt="">
                        </div>
                        <div class="md:p-4 flex-1">
                            <div>
                                <h6 class="text-xl lg:text-2xl font-FuturaMdCnBT">
                                    {{ isset($quote->name) ? $quote->name : '' }}
                                </h6>
                                <p class="text-gray-600 can-edu-card-p">
                                    {{ isset($quote->location) ? $quote->location : '' }}
                                </p>
                                <div class="mt-1 text-gray-500 can-edu-card-p line-clamp-3">
                                    {!! isset($quote->quoteDetail[0]->quote) ? $quote->quoteDetail[0]->quote : '' !!}
                                </div>
                                {{-- <div class="bg-primary p-8 flex items-center justify-center quote_footer">
                                    <div class="w-3/4 text-center">
                                    </div>
                                </div> --}}
                                @php
                                    $url = '#';
                                    if (isset($quote->quoteDetail[0])) {
                                        $url = url('/' . getDefaultLanguage(1)['abbreviation'] . '/quote/' . $quote->id);
                                    }
                                @endphp
                                <div class="mt-4 flex justify-end gap-2">
                                    <a href="{{ $url }}"><button class="can-edu-btn-fill">View</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="md:col-span-8 col-span-12 w-full">
                    <div class="absolute top-4 right-4 text-center flex justify-between items-center">
                        <a href="{{ url(app()->getLocale().'/quotes') }}" class="flex-grow mx-2">
                            <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                                Explore quotes
                            </button>
                        </a>
                        <a href="{{ url(app()->getLocale().'/quotes') }}" class="flex-grow mx-2" onclick="localStorage.setItem('openModal', 'true')">
                            <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                                Create your own quotes
                            </button>
                        </a>
                    </div>
                    <div class="pt-4">
                        <p>You do not have any quotes yet</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
