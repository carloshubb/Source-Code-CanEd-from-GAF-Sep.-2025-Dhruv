<?php
 $defaultLang = getDefaultLanguage(1);
 $degrees = App\Models\Degree::with([
        'degreeDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
        'degreeImage',
    ])
    ->addSelect([
        'name_order' => App\Models\DegreeDetail::whereColumn('degree_id', 'degrees.id')
            ->limit(1)
            ->select('name'),
    ])
    
    ->orderBy('name_order')
    ->get();
?>
<div class="bg-white container mx-auto lg:pt-14 md:pt-10 pt-8">

    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
        <div class="border-b-4 pb-2 pt-1 border-primary w-full">
            <h1 class="can-edu-h1">{{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : '' }}
            </h1>
        </div>
        <div class="mt-10 flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
            <a href="{{ url('/' . $defaultLang['abbreviation'] . '/school-registration-page') }}" class="can-edu-btn-fill" style="cursor: pointer">
                Register school
            </a>
            {{-- @endif --}}
        </div>
        {{-- <div class="relative md:mt-16 flex items-center border-collapse border-l-0 border border-gray-300 rounded">
            <input type="search" placeholder="Search schools"
                class="focus:outline-none focus:ring-none bg-white  px-3 py-1 border-y-0 border-gray-300 rounded-l border-l-4 border-l-primary">
            <button class="bg-gray-100 p-1.5 rounded-r border-l border-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </button>
        </div> --}}
    </div>
    @if (!empty($page->image))
       <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
            <img class="w-full h-full object-contain mx-auto"
                src="{{ asset(largeImage($page->image)) }}" alt="">
        </div>
    @endif
    @isset($page->pageDetail[0])
    <div class="can-edu-p mt-2">
        <div class="">
            @php
                $page_detail = $page->pageDetail[0]->description;
            @endphp
            @include('front.pages.widgets.render-widget-with-detail', [
                'page_detail' => $page_detail,
            ])
        </div>
    </div>
    @endisset

    <div class="">

        <div class="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($degrees as $degree)
                {{-- <a href="{{ url('/'.$defaultLang['abbreviation'].'/school/school-degree/' . $degree->id) }}"> --}}
                    <a href="{{ url('/'.$defaultLang['abbreviation'].'/school/school-degree/' . $degree->id . '/' . ($degree->degreeDetail[0]->slug ?? '')) }}">

                    <div class="border rounded overflow-hidden shadow w-64 md:w-auto mx-auto">
                        <div class="h-40 flex justify-center items-center border bg-gray-50"> 
                        <div class="border border-black rounded-full bg-white p-4 flex items-center justify-center w-32 h-32">
                            <img class="w-full object-contain h-12"
                            src="{{ asset(isset($degree->degreeImage->thumbnail_image) ? $degree->degreeImage->thumbnail_image : '') }}"
                            alt="">
                        </div>
                                </div>
                        <div class="bg-primary hover:bg-secondaryRed rounded-none py-2 px-3 w-full">
                            <p class="text-white font-FuturaMdCnBT truncate text-center">
                                {{ isset($degree->degreeDetail[0]->name) ? $degree->degreeDetail[0]->name : '' }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

    </div>

</div>
