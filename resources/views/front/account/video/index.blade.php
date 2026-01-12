@extends('front.layouts.account')
@php
$defaultLang = getDefaultLanguage(1);
@endphp
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full">
        <div class="p-4">
        <div class="mb-4 flex justify-between items-center gap-2 p-2">
            <h2 class="can-school-h2 text-primary">Our videos</h2>
            <a href="{{ route('web.account.video.create', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white">
                    Create new
                </button>
            </a>
        </div>
        @if (count($videos) > 0)
        <div class="ring-1 ring-gray-300 sm:mx-0 sm:rounded-lg overflow-auto">
        <table class="min-w-full divide-y divide-gray-300 overflow-auto m-0">
            <thead>
              <tr class="divide-x divide-gray-200">
                <th
                  scope="col"
                  class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6"
                >
                  Title
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
            @foreach ($videos as $video)
              <tr class="bg-white divide-x divide-gray-200 hover:bg-gray-50" >
                <td class="relative py-4 pl-4 pr-3 text-base sm:pl-6 font-medium text-gray-900">
                    {{ isset($video->videoDetail[0]->title) ? $video->videoDetail[0]->title : '' }}
                </td>
                <td class="relative py-3.5 px-3 text-center text-sm font-medium whitespace-nowrap space-x-2">
                  <div class="flex items-center justify-center gap-2">
                    <a href="{{ url(app()->getLocale().'/videos') }}" class="can-edu-btn-fill rounded-full">View</a>
                    {{-- <a
                      href="{{ route('web.account.video.edit', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug, 'video' => $video->id]) }}"
                      class="can-edu-btn-fill rounded-full"
                    >
                    Edit
                    </a> --}}
                    {{-- <article-delete lang="{{ $defaultLang['abbreviation'] }}"
                    article_id="{{ $video->id }}">
                    </article-delete> --}}
                    <a
                      type="button"
                      class="can-edu-btn-fill rounded-full"
                    >
                      Delete
                    </a>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
            <br />
            {!! $videos->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
        @else
        <div class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full bg-[url(/assets/error-bg-image.png)]">
          <div>
              <img class="mx-auto" src="{{ asset('assets/404.png') }}" alt="">
          </div>
          <div class="space-y-4 flex justify-center items-center flex-col my-10 mx-auto">
              <h1 class="text-[#014790] text-4xl md:text-5xl xl:text-6xl font-FuturaMdCnBT text-center">Oops</h1>
              <p class="text-center text-base md:text-lg lg:text-2xl">We are sorry,We are sorry, <br/> but there is no content here yet</p>
              <div class="pt-4 pb-2">
                  <a href="" class="can-edu-btn-fill rounded-full px-12">BACK TO HOME</a>
              </div>
              <p class="text-base md:text-lg lg:text-xl text-gray-500 text-center">Videos not found</p>
          </div>
      </div>
        @endif
        </div>
    </div>
@endsection
