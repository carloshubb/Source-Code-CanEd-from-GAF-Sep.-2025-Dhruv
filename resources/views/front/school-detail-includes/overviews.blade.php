@isset($school->schoolOverview->schoolOverviewDetail[0])
    @isset($school->schoolOverview->schoolOverviewDetail[0]->blog_pre_description)
        <div class="my-10">
            {!! $school->schoolOverview->schoolOverviewDetail[0]->blog_pre_description !!}
        </div>
    @endisset
    @if (isset($school->schoolOverview->display_blog) && $school->schoolOverview->display_blog == true)
        @php
            $blogs = getBlogNewsBySchoolId($school->id, $school->schoolOverview->number_of_blog_posts, $school->schoolOverview->blog_posts_order);
        @endphp
        @isset($blogs)
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-8 mx-auto my-4">
                @foreach ($blogs as $blog)
                    <div class="bg-gray-100">
                        <div class="bg-gray-50 border h-96 ">
                            @php
                                $images = $blog->image;
                                $images = explode(',', $images);
                                $image = $images[0] ?? null;
                            @endphp

                            <img class="h-full w-full img-fluid object-cover" src="{{ asset($image) }}" alt="" />
                        </div>
                        <div class="p-4">
                            <p>{{ $blog->blogDetail[0]->category_name }}</p>
                            <h3 class="line-clamp-1 w-4/5">{{ $blog->blogDetail[0]->title }}</h3>
                            <p>{!! $blog->blogDetail[0]->short_description !!}</p>
                            <div class="flex items-center justify-between mt-4">
                                <p class="text-black">
                                    {{ $blog->publised_at }}
                                </p>
                                <a href="{{ route('web.view.blog-detail', ['lang' => $defaultLang->abbreviation, 'id' => $blog->id]) }}"
                                    target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" class="w-10 h-8 text-gray-700 cursor-pointer">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        @endisset
    @endif
    @isset($school->schoolOverview->schoolOverviewDetail[0]->blog_post_description)
        <div class="my-10">
            {!! $school->schoolOverview->schoolOverviewDetail[0]->blog_post_description !!}
        </div>
    @endisset
    @isset($school->schoolOverview->schoolOverviewDetail[0]->programs_pre_description)
        <div class="my-10">
            {!! $school->schoolOverview->schoolOverviewDetail[0]->programs_pre_description !!}
        </div>
    @endisset
    <div class="my-10">
        <div>
            @if (isset($school->schoolOverview->overviewPrograms) && count($school->schoolOverview->overviewPrograms) > 0)
                <!-- Table -->
                <div class="w-[90vw] sm:w-auto mx-auto">

                    <div class="flex flex-col">
                        <div class="overflow-x-auto">
                            <div class="inline-block w-full align-middle">
                                <div class="overflow-auto ">
                                    <table class="w-full divide-y divide-gray-200 border-b">
                                        <thead class="bg-blue-900">
                                            <tr>
                                                <th scope="col"
                                                    class="py-3 px-6 font-medium tracking-tight text-center text-white">
                                                    Program name
                                                </th>
                                                <th scope="col"
                                                    class="py-3 px-6 font-medium tracking-tight text-center text-white">
                                                    Length
                                                </th>
                                                <th scope="col"
                                                    class="py-3 px-6 font-medium tracking-tight text-center text-white">
                                                    Tuition, International students
                                                </th>
                                                <th scope="col"
                                                    class="py-3 px-6 font-medium tracking-tight text-center text-white">
                                                    Tuition, Canadian students
                                                </th>
                                                <th scope="col"
                                                    class="py-3 px-6 font-medium tracking-tight text-center text-white">
                                                    Tuition, Provincial students
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800">
                                            @foreach ($school->schoolOverview->overviewPrograms as $overviewProgram)
                                                <tr class="">
                                                    <td class="py-4 px-5 text-black text-center">
                                                        {{ isset($overviewProgram->overviewProgramDetail[0]->name) ? $overviewProgram->overviewProgramDetail[0]->name : '' }}
                                                    </td>
                                                    <td class="py-4 px-5 text-black text-center">
                                                        {{ $overviewProgram->length }}
                                                    </td>
                                                    <td class="py-4 px-5 font-medium text-black text-center">
                                                        {{ $overviewProgram->tuition_inter_stu_fee }}
                                                    </td>
                                                    <td class="py-4 px-5 font-medium text-black text-center">
                                                        {{ $overviewProgram->tuition_can_stu_fee }}
                                                    </td>
                                                    <td class="py-4 px-5 font-medium text-black text-center">
                                                        {{ $overviewProgram->tuition_prov_stu_fee }}
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @isset($school->schoolOverview->schoolOverviewDetail[0]->programs_post_description)
        <div class="my-10">
            {!! $school->schoolOverview->schoolOverviewDetail[0]->programs_post_description !!}
        </div>
    @endisset
    @isset($school->schoolOverview->video_url)
        <div class="my-10">
            {!! $school->schoolOverview->video_iframe !!}
        </div>
    @endisset


@endisset
@php
    $filteredFaqs = $school->faqs->where('type', 'overview')->all();
@endphp
@if (isset($filteredFaqs) && count($filteredFaqs) > 0)
    <div class="my-10">
        <h2 class="can-edu-h2 normal-case mb-2">Frequently asked questions</h2>
        <div class="flex justify-center items-center">

            <!-- Collapse Start -->
            <div class="flex flex-col w-full">
                @foreach ($filteredFaqs as $faq)
                    <button class="group border border-gray-300 mb-3 focus:outline-none">
                        <div
                            class="flex items-center justify-between group-focus:bg-blue-100 h-12 px-3 font-semibold hover:bg-gray-200 ">
                            <span
                                class="truncate text-black font-bold lg:text-lg">{{ isset($faq->FaqDetail[0]->question) ? $faq->FaqDetail[0]->question : '' }}</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" stroke="1.5">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="max-h-0 overflow-hidden duration-300 group-focus:max-h-max">
                            <p class="text-gray-600 text-left text-lg p-4">
                                {!! isset($faq->FaqDetail[0]->answer) ? $faq->FaqDetail[0]->answer : '' !!}
                            </p>
                        </div>
                    </button>
                @endforeach
            </div>
            <!-- Collapse End  -->

        </div>
    </div>
@endif

@isset($school->schoolOverview)
    <div class="row justify-content-center mb-5 mt-10">
        <div class="w-full md:w-1/2 mx-auto flex text-center">
            <a href="{{ $school->schoolOverview->school_overviews_apply_button_link ?: '#' }}" 
                target="_blank" 
                class="canedu_btn w-full py-4">
                {{ $school->schoolOverview->school_overviews_apply_button_title ?: 'Apply Now' }}
            </a>
        </div>
    </div>
@endisset

<div class="w-full my-6">
    <div class="col-12">
        <div class="grid grid-cols-12 canedu_btn rounded p-0 w-full mx-auto">
            <div style="max-width: 0.333333%;"></div>

            <!-- First Link for Sub Title -->
            <a href="{{ isset($school->schoolOverview->school_overviews_blue_bar_button_link) ? formatUrl($school->schoolOverview->school_overviews_blue_bar_button_link) : '' }}" 
                target="_blank" 
                class="col-span-4 py-5 bg-[#01468f] rounded-0 text-white font-medium text-center">
                <p class="font-FuturaMdCnBT text-center text-xl text-white">
                    {{ isset($school->schoolOverview->school_overviews_blue_bar_button_title) ? $school->schoolOverview->school_overviews_blue_bar_button_title : 'Good to go?' }}
                </p>
            </a>

            <!-- Second Link for Main Title -->
            <a href="{{ isset($school->schoolOverview->school_overviews_red_bar_button_link) ? formatUrl ($school->schoolOverview->school_overviews_red_bar_button_link) : '' }}" 
                target="_blank" 
                class="col-span-7 py-5 text-white font-medium text-center">
                <p class="font-FuturaMdCnBT text-center text-white  text-xl">
                    {{ isset($school->schoolOverview->school_overviews_red_bar_button_title) ? $school->schoolOverview->school_overviews_red_bar_button_title : 'Let’s apply' }}
                </p>
            </a>
        </div>
    </div>
</div>

{{-- @section('scripts')
    <script>
        @if (isset($school->schoolOverview->video_url))
            window.addEventListener('load', function() {
                const iframeHtml = `{!! $school->schoolOverview->video_url !!}`;

                const iframePlaceholder = document.getElementById('iframe-placeholder');
                iframePlaceholder.innerHTML = iframeHtml;

                loadScript();
            });
        @endif
    </script>
@endsection --}}