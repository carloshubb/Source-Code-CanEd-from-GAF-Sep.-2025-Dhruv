@php
    $quickFeatures = null;
@endphp
@isset($school->schoolQuickFact)
    @php
        $quickFeatures = getMarkedQuickFactFeaturesById($school->schoolQuickFact->id);
    @endphp
@endisset
@php
    // function formatUrl123($url) {
    //     return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
    // }
    if (!function_exists('formatUrl123')) {
        function formatUrl123($url) {
            return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
        }
    }
@endphp
@if (isset($quickFeatures))
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 2xl:gap-8 mb-10 py-6 p-4 bg-gray-100">
        @foreach ($quickFeatures as $quickFeature)
            <div class="bg-white rounded-lg border border-gray-300 shadow-md p-4 flex items-center justify-center">
                <div class="text-center break-words text-regular">
                    <div class="text-base lg:text-lg font-bold">
                        {{ ucfirst(str_replace('_', ' ', $quickFeature->type)) }}
                    </div>
                    <p class="text-base text-gray-500 text-center">
                        {{ ucfirst(str_replace('_', ' ', $quickFeature->value)) }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
@endisset
@isset($school->schoolQuickFact->schoolQuickFactDetail[0])
    <div class="my-10">
        <h2 class="can-edu-h2 mb-2">
            {{ isset($school->schoolQuickFact->schoolQuickFactDetail[0]->title_1) ? $school->schoolQuickFact->schoolQuickFactDetail[0]->title_1 : '' }}
        </h2>
        <p class="can-edu-p">
            {!! isset($school->schoolQuickFact->schoolQuickFactDetail[0]->title_1_paragraph)
                ? $school->schoolQuickFact->schoolQuickFactDetail[0]->title_1_paragraph
                : '' !!}
        </p>
    </div>
    <div class="my-10">
        <h2 class="can-edu-h2 mb-2">
            {{ isset($school->schoolQuickFact->schoolQuickFactDetail[0]->title_2) ? $school->schoolQuickFact->schoolQuickFactDetail[0]->title_2 : '' }}
        </h2>
        <div class="grid grid-cols-1 {{file_exists(asset(isset($school->schoolQuickFact->title_2_image) ? $school->schoolQuickFact->title_2_image : '')) ? 'md:grid-cols-2' : 'md:grid-cols-1'}} gap-6">
            @if(file_exists(asset(isset($school->schoolQuickFact->title_2_image) ? $school->schoolQuickFact->title_2_image : '')))
            <div class="h-72 border bg-white">
                <img class="h-full object-cover w-full"
                    src="{{ asset(isset($school->schoolQuickFact->title_2_image) ? $school->schoolQuickFact->title_2_image : '') }}"
                    alt="">
            </div>
            @endif
            <div class="flex items-center w-full">
                <div class="w-full mb-4">
                    <div class="mb-4">
                        <h3 class="can-edu-h3 my-2">
                            {{ isset($school->schoolQuickFact->schoolQuickFactDetail[0]->title_2_subtitle) ? $school->schoolQuickFact->schoolQuickFactDetail[0]->title_2_subtitle : '' }}
                        </h3>
                        <p class="text-black line-clamp-6">
                            {{-- Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. --}}
                            {!! isset($school->schoolQuickFact->schoolQuickFactDetail[0]->title_2_paragraph)
                                ? $school->schoolQuickFact->schoolQuickFactDetail[0]->title_2_paragraph
                                : '' !!}
                        </p>
                    </div>
                    <div class="flex justify-strat">
                        <a href="{{ isset($school->schoolQuickFact->title_2_button_link) ? formatUrl123($school->schoolQuickFact->title_2_button_link) : '' }}"
                            target="_blank">
                            <button class="canedu_btn">
                                {{ isset($school->schoolQuickFact->schoolQuickFactDetail[0]->title_2_button_title) ? $school->schoolQuickFact->schoolQuickFactDetail[0]->title_2_button_title : '' }}
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endisset
@php
    $faqs = $school->faqs ?? null;
    $quick_facts_faqs = isset($faqs) ? $faqs->where('type', 'quick_facts') : null;
@endphp
@if (isset($quick_facts_faqs) && count($quick_facts_faqs) > 0)
    <div class="my-10">
        <h2 class="can-edu-h2 normal-case mb-2">Frequently asked questions</h2>
        <div class="flex justify-center items-center">

            <!-- Collapse Start -->
            <div class="flex flex-col w-full">
                @foreach ($quick_facts_faqs as $faq)
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

@if (isset($school->schoolContacts))
    @php
        $schoolContacts = $school->schoolContacts;
        $schoolContacts = $schoolContacts->sortBy([['order', 'asc']])->all();
    @endphp
    <div class="bg-gray-100 border rounded">
        <div class="p-4 border-b border-gray-300 bg-gray-200">
            <h2 class="can-edu-h2 normal-case mb-0">Contact this school</h2>
        </div>
        @foreach ($schoolContacts as $schoolContact)
            <div class="card_bg border-b p-4">
                <h6 class="font-Roboto text-lg font-semibold">{{ $schoolContact->department }}</h6>
                <p class="text-black text-base">
                    {{ isset($schoolContact->schoolContactDetail[0]) ? $schoolContact->schoolContactDetail[0]->name : '' }}
                </p>
                <p class="text-black text-base">{{ $schoolContact->address }}</p>
                <p class="text-black text-base">{{ $schoolContact->city }}</p>
                <p class="text-black text-base">{{ $schoolContact->country }}</p>
                <p class="text-black text-base">Tel: <span>{{ $schoolContact->phone }}</span></p>
                <p class="text-black text-base">Fax: <span>{{ $schoolContact->fax }}</span></p>
                <p class="text-black text-base">Website: <span
                        class="text-primary font-medium">{{ $schoolContact->website_link }}</span></p>
            </div>
        @endforeach
    </div>
@endisset
{{-- @isset($school->schoolQuickFact)
<div class="text-center mt-10">
    <a href="{{ $school->schoolQuickFact->school_quick_facts_apply_button_link ?: '#' }}" 
       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
       target="_blank">
        {{ $school->schoolQuickFact->school_quick_facts_apply_button_title ?: 'Apply Now' }}
    </a>
</div>
@endisset --}}
@isset($school->schoolQuickFact)
    <div class="row justify-content-center mb-5 mt-10">
        <div class="w-full md:w-1/2 mx-auto flex text-center">
            <a href="{{ $school->schoolQuickFact->school_quick_facts_apply_button_link ?: '#' }}" 
                target="_blank" 
                class="canedu_btn w-full py-4">
                {{ $school->schoolQuickFact->school_quick_facts_apply_button_title ?: 'Need help planning your career' }}
            </a>
        </div>
    </div>
@endisset

<div class="w-full my-6">
    <div class="col-12">
        <div class="grid grid-cols-12 canedu_btn rounded p-0 w-full mx-auto">
            <div style="max-width: 0.333333%;"></div>

            <!-- First Link for Sub Title -->
            <a href="{{ isset($school->schoolQuickFact->school_quick_facts_blue_bar_button_link) ? formatUrl($school->schoolQuickFact->school_quick_facts_blue_bar_button_link) : '' }}" 
                target="_blank" 
                class="col-span-4 py-5 bg-[#01468f] rounded-0 text-white font-medium text-center">
                <p class="font-FuturaMdCnBT text-center text-xl text-white">
                    {{ isset($school->schoolQuickFact->school_quick_facts_blue_bar_button_title) ? $school->schoolQuickFact->school_quick_facts_blue_bar_button_title : 'Good to go?' }}
                </p>
            </a>

            <!-- Second Link for Main Title -->
            <a href="{{ isset($school->schoolQuickFact->school_quick_facts_red_bar_button_link) ? formatUrl ($school->schoolQuickFact->school_quick_facts_red_bar_button_link) : '' }}" 
                target="_blank" 
                class="col-span-7 py-5 text-white font-medium text-center">
                <p class="font-FuturaMdCnBT text-center text-white  text-xl">
                    {{ isset($school->schoolQuickFact->school_quick_facts_red_bar_button_title) ? $school->schoolQuickFact->school_quick_facts_red_bar_button_title : 'Let’s apply' }}
                </p>
            </a>
        </div>
    </div>
</div>
