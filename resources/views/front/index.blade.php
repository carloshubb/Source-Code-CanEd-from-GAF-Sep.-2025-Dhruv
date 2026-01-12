@extends('front.layouts.app')
@section('content')
    <div class="backdrop-blur-sm bg-black bg-cover bg-center flex items-center justify-center h-96 w-full"
        style="background-image: url('assets/banner.jpg');">
        <div class="container mx-auto px-4 lg:w-1/2 w-full">
            <div class="bg-white bg-opacity-40 p-2 rounded-md flex justify-between">
                <div class="w-full md:w-2/3">
                    <input type="search"
                        class="w-full py-2 px-3 border border-gray-400 focus:outline-none focus:ring focus:border-blue-200"
                        placeholder="Search by school name" />
                </div>
                <div class="w-full md:w-1/3">
                    <select id="location" name="location"
                        class="w-full py-2 px-3 border border-gray-400 border-l-0 focus:outline-none focus:ring focus:border-blue-200"
                        style="max-width: 100%;">
                        <option>Schools</option>
                        <option>Buisnesses</option>
                        <option>Programs</option>
                        <option>Articles</option>
                        <option selected>Scholarships</option>
                    </select>
                </div>
                <button class="bg-white p-2 lg:p-2.5 px-4 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </button>
            </div>
            <div class="bg-white bg-opacity-40 w-44 p-2 rounded mx-auto mt-6">
                <button class="bg-primary px-4 whitespace-nowrap py-2 font-bold text-white">
                    Advanced Search
                </button>
            </div>
        </div>
    </div>

    {{-- <div style="background-image: url('assets/banner.jpg');"
        class="backdrop-blur-sm bg-black bg-cover flex items-center justify-center h-96 w-full">
        <div class="xl:w-[60rem]">
            <div class="bg-white bg-opacity-40 p-2 rounded">
                <div class="flex items-center divide-x bg-white rounded ">
                    <input type="search" class="w-full focus:outline-none focus:ring-none"
                        placeholder="Search by school name">
                        <div>
                            <select id="location" name="location" class="inline-block w-full py-2 px-2 border-l-0 pl-1 pr-12 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option>Schools</option>
                            <option>Buisnesses</option>
                            <option>Programs</option>
                            <option>Articles</option>
                            <option selected>Scholarships</option>
                            </select>
                        </div>
                    <button class="bg-white p-2 px-4 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="bg-white bg-opacity-40 w-44 p-2 rounded mx-auto mt-6">
                <button class="bg-primary px-4 whitespace-nowrap py-2 font-bold text-white">
                    Advanced Search
                </button>
            </div>
        </div>
    </div> --}}
    <school-category-section degrees='{{ $degrees }}'></school-category-section>
    <div class="bg-white">
        <school-category-section-mobile degrees='{{ $degrees }}'></school-category-section-mobile>
        <proxima-study-section home_page_settings='{{ $homePageSettings }}'></proxima-study-section>
        <div class="container mx-auto mt-14">
            <feetured-school-section schools='{{ $schools }}' home_page_settings='{{ $homePageSettings }}'>
            </feetured-school-section>
            <financial-help articles="{{ $sectionArticles1 }}" home_page_settings='{{ $homePageSettings }}'>
            </financial-help>
            <banner-one-section home_page_settings='{{ $homePageSettings }}'></banner-one-section>
            <work-while-study articles="{{ $sectionArticles2 }}" home_page_settings='{{ $homePageSettings }}'>
            </work-while-study>
            <banner-two-section home_page_settings='{{ $homePageSettings }}'></banner-two-section>
            <proxima-study-section-two articles="{{ $sectionArticles3 }}" home_page_settings='{{ $homePageSettings }}'>
            </proxima-study-section-two>
            <recent-article-section articles="{{ $articles }}" home_page_settings='{{ $homePageSettings }}'>
            </recent-article-section>
            <banner-three-section home_page_settings='{{ $homePageSettings }}'></banner-three-section>
        </div>
    </div>
@endsection
