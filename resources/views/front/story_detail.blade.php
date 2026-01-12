@extends('front.layouts.app')
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

        <section class="relative overflow-hidden">
            <div class="relative container mx-auto">
                <!-- <div class="max-w-lg lg:max-w-3xl xl:max-w-5xl mx-auto"> -->
                <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
                    <div class="border-b-4 pb-2 border-primary w-full">
                        <h1 class="can-edu-h1 ">
                            {{ isset($story->storyDetail[0]->title) ? $story->storyDetail[0]->title : '' }}</h1>
                    </div>
                </div>
                <div class="mt-4">
                    <?php $image = isset($story->storyImage->thumbnail_image) ? $story->storyImage->thumbnail_image : ''; ?>
                    @if (!empty($image))
                        <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
                            <img class="w-full h-full object-contain mx-auto"
                                src="{{ asset($image) }}" alt="">
                        </div>
                        <!-- <br /> <br /> -->
                    @endif
                    <p><span class="font-bold">by:</span> {{ isset($story->student_name) ? $story->student_name : '' }}</p>
                    <p><span class="font-bold">Origin:</span> {{ isset($story->country_of_origin) ? $story->country_of_origin : '' }}</p>

                    <div class="can-edu-p">
                        {!! isset($story->storyDetail[0]->story) ? $story->storyDetail[0]->story : '' !!}
                    </div>
                </div>
                <!-- </div> -->
            </div>
        </section>
    @endsection
