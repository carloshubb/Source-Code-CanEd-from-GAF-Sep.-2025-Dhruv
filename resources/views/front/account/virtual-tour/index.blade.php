@extends('front.layouts.account')
@php
$defaultLang = getDefaultLanguage(1);
$loggedInCustomerPackage = isset(Auth::guard('customers')->user()->id) 
    && Auth::guard('customers')->user()->user_type === 'school' 
    && Auth::guard('customers')->user()->registration_package_id == 1 
    ? Auth::guard('customers')->user()->registration_package_id 
    : Auth::guard('customers')->user()->registration_package_id;
@endphp
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full p-4">

        <div class="mt-2 flex justify-between items-center gap-2 p-2">
            <h2 class="can-school-h2 text-primary">Virtual tour</h2>
            <a href="{{ route('web.account.virtual.tour.create', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                <button class="can-edu-btn-fill">
                    Create new
                </button>
            </a>
        </div>
    

        {{-- @if ($loggedInCustomerPackage == 1)
        <div class="can-edu-p mt-2">
          <div class="">
              This feature is available exclusively to our Sponsors, as well as to our Premium and Featured
              schools
          </div>
      </div>
@else --}}
    @if (count($virtualTours) > 0)
        <div class="ring-1 ring-gray-300 sm:mx-0 sm:rounded-lg overflow-auto">
            <table class="min-w-full divide-y divide-gray-300 overflow-auto m-0">
                <thead>
                    <tr class="divide-x divide-gray-200">
                        <th scope="col" class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6">Image</th>
                        <th scope="col" class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6">Description</th>
                        <th scope="col" class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6">Status</th>
                        <th scope="col" class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-3 pr-4 sm:pr-6 text-center text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white lg:table-cell">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($virtualTours as $virtualTour)
                    <tr class="bg-white divide-x divide-gray-200 hover:bg-gray-50">
                        <td>
                            <img class="w-10 h-10 rounded-full mx-auto" src="{{ asset(isset($virtualTour->image)) ? $virtualTour->image : '' }}" alt="">
                        </td>
                        <td class="relative py-4 pl-4 pr-3 text-base sm:pl-6 font-medium text-gray-900">
                            {{ isset($virtualTour->virtualTourDetail[0]->description) ? $virtualTour->virtualTourDetail[0]->description : '' }}
                        </td>
                        <td class="relative py-4 pl-4 pr-3 text-base sm:pl-6 font-medium text-gray-900">
                            {{ isset($virtualTour->status) ? $virtualTour->status : '' }}
                        </td>
                        <td class="relative py-3.5 px-3 text-center text-sm font-medium whitespace-nowrap gap-2">
                            <div class="flex items-center justify-center gap-2">
                              @if ($loggedInCustomerPackage != 1)
                              <a href="{{ route('web.account.virtual.tour.edit', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug, 'virtual_tour' => $virtualTour->id]) }}" class="can-edu-btn-fill rounded-full">
                                  Edit
                              </a>
                              <virtual-tour-delete lang="{{ $defaultLang['abbreviation'] }}" virtual_tour_id="{{ $virtualTour->id }}"></virtual-tour-delete>
                          @else
                              <!-- Disabled version of the buttons -->
                              <button class="can-edu-btn-fill rounded-full cursor-not-allowed">
                                  Edit
                              </button>
                              <virtual-tour-delete 
                              lang="{{ $defaultLang['abbreviation'] }}" 
                              virtual_tour_id="{{ $virtualTour->id }}"
                              :disabled="true">
                          </virtual-tour-delete>
                          @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <br />
        {!! $virtualTours->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
    @else
    <div class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full bg-[url(/assets/error-bg-image.png)]">
        <div>
            <img class="mx-auto" src="{{ asset('assets/404.png') }}" alt="">
        </div>
        <div class="space-y-4 flex justify-center items-center flex-col my-10 mx-auto">
            <h1 class="text-[#014790] text-4xl md:text-5xl xl:text-6xl font-FuturaMdCnBT text-center">Oops</h1>
            <p class="text-center text-base md:text-lg lg:text-2xl">We are sorry,We are sorry, <br/> but there is no content here yet</p>
            <div class="pt-4 pb-2">
                <a href="{{ route('web.account.virtual.tour.create', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                    <button class="can-edu-btn-fill">Explore virtual tour</button>
                </a>
            </div>
            <p class="text-base md:text-lg lg:text-xl text-gray-500 text-center">You do not have any Virtual tour yet</p>
        </div>
      </div>
    @endif
{{-- @endif --}}
    </div>
@endsection
