@extends('front.layouts.account')
@php
$defaultLang = getDefaultLanguage(1);
@endphp
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full p-4">

        <div class="my-4 items-center flex justify-between gap-2 p-2">
            <h2 class="can-school-h2 text-primary">Open house days</h2>
            <a href="{{ route('web.account.open.house.create', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white">
                    Create new
                </button>
            </a>
        </div>
        @if (count($openDays) > 0)
        <div class="ring-1 ring-gray-300 sm:mx-0 sm:rounded-lg overflow-auto">
            <table class="min-w-full divide-y divide-gray-300 overflow-auto m-0">
                <thead>
                  <tr class="divide-x divide-gray-200">
                    <th
                      scope="col"
                      class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6"
                    >
                      Image
                    </th>
                    <th
                      scope="col"
                      class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6"
                    >
                      Title
                    </th>
                    <th
                      scope="col"
                      class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6"
                    >
                      City
                    </th>
                    <th
                      scope="col"
                      class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6"
                    >
                      Country
                    </th>
                    <th
                      scope="col"
                      class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6"
                    >
                      Address
                    </th>
                    <th
                      scope="col"
                      class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6"
                    >
                      Status
                    </th>
                    <th
                      scope="col"
                      class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-3 pr-4 sm:pr-6 text-center text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white lg:table-cell"
                    >
                      Action
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($openDays as $openDay)
                  <tr class="bg-white divide-x divide-gray-200 hover:bg-gray-50" >
                    <td>
                        <img class="w-10 h-10 rounded-full mx-auto"
                           src="{{ asset(isset($openDay->image)) ? $openDay->image : '' }}" alt="">
                    </td>
                    <td class="relative py-4 pl-4 pr-3 text-base sm:pl-6 font-medium text-gray-900">
                      @if($openDay->openDayDetail->isNotEmpty())
                          {{ $openDay->openDayDetail->first()->title ?? 'No Title Available' }}
                      @else
                          No Title Available
                      @endif
                    </td>
                    <td class="relative py-4 pl-4 pr-3 text-base sm:pl-6 font-medium text-gray-900">
                        {{ isset($openDay->city) ? $openDay->city : '' }}
                    </td>
                    <td class="relative py-4 pl-4 pr-3 text-base sm:pl-6 font-medium text-gray-900">
                        {{ isset($openDay->country) ? $openDay->country : '' }}
                    </td>
                    <td class="relative py-4 pl-4 pr-3 text-base sm:pl-6 font-medium text-gray-900">
                        {{ isset($openDay->address) ? $openDay->address : '' }}
                    </td>
                    <td class="relative py-4 pl-4 pr-3 text-base sm:pl-6 font-medium text-gray-900">
                        {{ isset($openDay->status) ? $openDay->status : '' }} 
                    </td>
                    <td class="relative py-3.5 px-3 text-center text-sm font-medium whitespace-nowrap gap-2">
                      <div class="flex items-center justify-center gap-2">
                        <a
                          href="{{ route('web.account.open.house.edit', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug, 'open_day' => $openDay->id]) }}"
                          class="can-edu-btn-fill rounded-full"
                        >
                          Edit
                        </a>
                        <open-day-delete lang="{{ $defaultLang['abbreviation'] }}" open_day_id="{{ $openDay->id }}"></open-day-delete>
                      </div>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <br />
            {!! $openDays->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
        @else
        <div class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full bg-[url(/assets/error-bg-image.png)]">
          <div>
              <img class="mx-auto" src="{{ asset('assets/404.png') }}" alt="">
          </div>
          <div class="space-y-4 flex justify-center items-center flex-col my-10 mx-auto">
              <h1 class="text-[#014790] text-4xl md:text-5xl xl:text-6xl font-FuturaMdCnBT text-center">Oops</h1>
              <p class="text-center text-base md:text-lg lg:text-2xl">We are sorry,We are sorry, <br/> but there is no content here yet</p>
              <div class="pt-4 pb-2">
                <a href="{{ route('web.account.open.house.create',['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                  <button class="can-edu-btn-fill">Explore
                      open house </button>
              </a>
              </div>
              <p class="text-base md:text-lg lg:text-xl text-gray-500 text-center">You do not have any Open house yet</p>
          </div>
        </div>
        @endif
    </div>
@endsection
