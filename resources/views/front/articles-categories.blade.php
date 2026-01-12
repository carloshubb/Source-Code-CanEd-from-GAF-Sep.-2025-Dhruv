@extends('front.layouts.app')
@php
$defaultLang = getDefaultLanguage(1);
@endphp
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full justify-between md:justify-center items-end gap-3">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">Articles by category</h1>
            </div>
            <div class="relative md:-mb-4 flex items-center border border-gray-300 rounded mx-auto">
                <a href="{{ url('/' . $defaultLang['abbreviation'] . '/articles') }}" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5">View all articles</a>
            </div>
        </div>

        <div class="can-edu-p mt-8">
            <div class="">
                Please select your articles category
            </div>
        </div>

        <div class="mt-6 md:mt-14">
            <div class="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6 md:mb-10">
                @foreach ($articlesByCategories as $articlesByCategory)
                @php
                $hasParent = \App\Models\ArticleCategory::where('parent_id', $articlesByCategory->id)->exists();
                // dd($hasParent);
                @endphp
            
         
            
                @if($hasParent)
                    
                <a  href="{{ url('/' . $defaultLang['abbreviation'] . '/articles/subcategories?category=' . $articlesByCategory->id) }}">
                @else
                <a  href="{{ url('/' . $defaultLang['abbreviation'] . '/articles?category=' . $articlesByCategory->id) }}">

                @endif
                        <div class="border shadow w-64 md:w-auto mx-auto">
                            <div class="h-48 border bg-white flex items-center justify-center">
                                <img class="w-full object-contain h-40"
                                    src="{{ asset(isset($articlesByCategory->ArticleCategoryImage->thumbnail_image) ? $articlesByCategory->ArticleCategoryImage->thumbnail_image : '') }}"
                                    alt="">
                            </div>
                            <div class="can-edu-btn-fill rounded-none w-full">
                                <p class="text-white truncate text-center">
                                    {{ isset($articlesByCategory->ArticleCategoryDetail[0]->name)
                                        ? $articlesByCategory->ArticleCategoryDetail[0]->name
                                        : '' }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
