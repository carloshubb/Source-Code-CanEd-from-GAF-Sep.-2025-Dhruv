@extends('front.layouts.app')
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 pb-2 border-primary w-full flex items-center justify-between">
                <h1 class="can-edu-h1">
                    {{ $blog->blogDetail[0]->title ?? '' }}</h1>
            </div>
        </div>

        <div class="mt-6">

            <div class="flex gap-6">
                <div class="flex-auto order-1 lg:order-2 ">
                    {{-- <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 md:col-span-12"> --}}
                            <div class="max-h-96 h-64 lg:h-80 border bg-gray-50">
                                <swiper-container class="mySwiper" navigation="true">
                                    {{-- @if (isset($blog->youtube_iframe))
                                        <swiper-slide>
                                            <div id="iframe-placeholder"></div>
                                        </swiper-slide>
                                    @endif --}}
                                    @php
                                        $images = explode(',', $blog->image);
                                    @endphp
                                    @if (isset($images) && !empty($images))
                                        @foreach ($images as $blog_image)
                                            <swiper-slide> <img class="h-full w-full mx-auto bg-gray-50 object-contain"
                                                    src="{{ asset(largeImage($blog_image)) }}"
                                                    alt=""></swiper-slide>
                                        @endforeach
                                    @endif
                                </swiper-container>
                            </div>
                        {{-- </div> --}}
                        <div class="mt-10">
                            {!! $blog->blogDetail[0]->detail_description ?? '' !!}
                        </div>

                    {{-- </div> --}}

                </div>
            </div>

        </div>

    </div>
@endsection
@section('scripts')
@endsection
