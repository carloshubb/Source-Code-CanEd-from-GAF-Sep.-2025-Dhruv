@extends('front.layouts.nostyle')
@php
$defaultLang = getDefaultLanguage(1);
@endphp
@section('content')
<div class="w-full bg-[length:100%_100%] xl:bg-cover 2xl:bg-[length:100%_100%] desktop:bg-cover min-h-[45rem] bg-no-repeat bg-center h-screen"
        style="background-image: url('{{ asset('assets/404-assets/background.jpg') }}');">
        <div class="flex items-end justify-center h-full w-full relative max-w-screen-2xl mx-auto">
            <div class="absolute top-[55%] md:top-1/2 left-[5%]">
                <img class="animate-bounce transition delay-150 duration-300 ease-in-out w-14 md:w-20 h-14 md:h-20"
                    src="{{ asset('/assets/404-assets/stone.png') }}" alt="">
            </div>
            <div class="absolute error_outer pt-20 xl:pt-0 w-full md:w-2/3 lg:w-1/2 h-[44rem]">
                <div class="w-[9rem] md:w-[12rem] lg:w-[18rem] h-[16rem] md:h-[18rem] lg:h-[24rem] relative mx-auto">
                    <img class="w-full h-full animate-wiggle absolute top-0"
                        src="{{ asset('/assets/404-assets/light2.png') }}" alt="">
                    <img class="error absolute bottom-6 md:-bottom-[2%] left-[16%] md:left-[20%] z-20"
                        src="{{ asset('/assets/404-assets/404-01.png') }}" alt="">
                </div>
                <div class="text-center my-20 w-full mx-auto px-6 lg:my-12">
                    <h1 class="text-white text-2xl font-medium uppercase md:text-3xl">OPPS! PAGE NOT FOUNDED</h1>
                    <p class="text-white text-xl xl:text-2xl ">The page you are looking for was moved, removed,
                        <br class="hidden md:block">
                        rename or might never be existed
                    </p>
                    <div class="flex items-center justify-center space-x-4">
                        <a href="{{ url('/'.$defaultLang['abbreviation'].'/') }}">
                            <button
                                class="mt-4 w-32 px-4 py-2 bg-emerald-200 text-blue-900 text-lg  font-FuturaMdCnBT tracking-tight rounded hover:bg-blue-300 focus:outline-none focus:bg-blue-500">
                               Go home</button>
                        </a>
                        <a href="{{ url('/'.$defaultLang['abbreviation'].'/contact-us') }}">
                            <button
                                class="mt-4 w-32 px-4 py-2 bg-emerald-200 text-blue-900 text-lg  font-FuturaMdCnBT tracking-tight rounded hover:bg-blue-300 focus:outline-none focus:bg-blue-500">
                                Contact us</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="absolute right-[10%] top-[11%] md:top-[30%]">
                <div class="w-28 md:w-36 lg:w-64 h-28 md:h-36 lg:h-64 relative">
                    <img class="animate-wiggle absolute  -top-8 lg:top-0" src="{{ asset('/assets/404-assets/robot.png') }}"
                        alt="">
                    <img class="w-20 md:w-28 lg:w-44 absolute -right-8 md:-right-12 lg:-right-20 -top-12 md:-top-16 lg:-top-9 z-20"
                        src="{{ asset('/assets/404-assets/rocket.png') }}" alt="">
                </div>
            </div>
            <div class="absolute top-[20%] md:top-auto bottom-auto md:bottom-[10%] right-[5%]">
                <img class="animate-bounce w-14 md:w-20 h-14 md:h-20" src="{{ asset('/assets/404-assets/stone.png') }}"
                    alt="">
            </div>
        </div>
    </div>
    @endsection