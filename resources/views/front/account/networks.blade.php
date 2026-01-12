@extends('front.layouts.account')
@php
    $loggedInCustomer = Auth::guard('customers')->check() ? Auth::guard('customers')->user() : null;
@endphp
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full relative">
        {{-- <h2 class="px-4 pt-4 can-school-h2 text-primary">Our networks</h2> --}}
        @if ($loggedInCustomer && $loggedInCustomer->user_type == 'school')
            <h2 class="px-4 pt-4 can-school-h2 text-primary">Our networks</h2>
        @elseif ($loggedInCustomer && $loggedInCustomer->user_type == 'student')
            <h2 class="px-4 pt-4 can-school-h2 text-primary">My networks</h2>
        @endif
        <div class="p-4">
         
            @if (count($networks) > 0)
            <div class="absolute right-3 top-4 text-center flex justify-between items-center">
                <a href="{{ url(app()->getLocale().'/world-wide-network') }}" class="flex-grow mx-2">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-fit">
                        Explore Networks
                    </button>
                </a>
                <a href="{{ url(app()->getLocale().'/world-wide-network') }}" class="flex-grow mx-2">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-fit">
                        Create your own networks
                    </button>
                </a>
                
            </div>
            <div class="space-y-4 mt-4">
                @foreach ($networks as $network)
                <div class="mt-4 card_bg border border-gray-300 rounded-lg shadow-md px-4 py-4 md:py-2 relative">
                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row md:items-center space-x-2">
                        <div class="w-48 h-48 rounded-lg border bg-gray-200 flex-shrink-0 px-2 mx-auto">
                            <img class="h-full w-full object-contain"
                                src="{{ asset(isset($network->networkImage->path) ? $network->networkImage->path : '') }}" alt="">
                        </div>
                        <div class="md:p-4 flex-1">
                            <div>
                                <p class="text-xl lg:text-2xl font-FuturaMdCnBT">
                                    {{ isset($network->networkDetail[0]->full_name) ? $network->networkDetail[0]->full_name : '' }}
                                </p>
                                <div class="mt-1 text-gray-500 can-edu-card-p line-clamp-3">
                                    {!! isset($network->networkDetail[0]->description) ? $network->networkDetail[0]->description : '' !!}
                                </div>
                                <div class="mt-4 flex justify-end gap-2">
                                    <a href="{{ $network->website_url }}" target="_blank"><button class="can-edu-btn-fill">View</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
                <div class="md:col-span-8 col-span-12 w-full mt-4">
                    <p>You do not have any network yet.</p>
                    <div class="absolute top-4 right-3 text-center flex justify-between items-center">
                        <button class="can-edu-btn-fill flex-grow mx-2">
                            Explore Networks
                        </button>
                        <a href="{{ route('web.account.networks', ['lang' => app()->getLocale(), 'slug' => auth()->guard('customers')->user()->slug]) }}" class="flex-grow mx-2">
                            <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                                Create your networks
                            </button>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
