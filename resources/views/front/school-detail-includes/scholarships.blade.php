    {{-- @php
    function getYouTubeEmbedUrl($url) {
        $pattern = '/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=))([\w-]+)/';
        if (preg_match($pattern, $url, $matches)) {
            return "https://www.youtube.com/embed/" . $matches[1];
        }
        return null; // Invalid YouTube URL
    }

    $topPageVideoUrl = getYouTubeEmbedUrl($school->scholarshipSetting->top_page_video_url ?? '');
@endphp

@isset($topPageVideoUrl)
    <div class="my-10 flex justify-center px-10">
        <iframe class="w-full max-w-4xl h-60 rounded-lg shadow-lg" src="{{ $topPageVideoUrl }}" frameborder="0" allowfullscreen></iframe>
    </div>
@endisset --}}
@php
if (!function_exists('getYouTubeEmbedUrl')) {
    function getYouTubeEmbedUrl($url) {
        $pattern = '/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=))([\w-]+)/';
        if (preg_match($pattern, $url, $matches)) {
            return "https://www.youtube.com/embed/" . $matches[1];
        }
        return null; // Invalid YouTube URL
    }
}

$topPageVideoUrl = getYouTubeEmbedUrl($school->scholarshipSetting->top_page_video_url ?? '');
@endphp

@isset($topPageVideoUrl)
    <div class="my-10 flex justify-center px-10">
        <iframe class="w-full max-w-4xl h-60 rounded-lg shadow-lg" src="{{ $topPageVideoUrl }}" frameborder="0" allowfullscreen></iframe>
    </div>
@endisset

@isset($school->scholarshipSetting->scholarshipSettingDetail[0])
    <div class="mt-10">
        {!! $school->scholarshipSetting->scholarshipSettingDetail[0]->scholarship_pre_description ?? '' !!}
    </div>
@endisset


<div class="my-10">
    @php
        $scholarshipModalTranslations = getStaticTranslation('scholarship_modal');
    @endphp
    <div>
        <scholarship-advanced-search-on-school-page
            scholarship_advance_search_translation="{{ $scholarshipModalTranslations }}" school_id="{{ $school->id }}"
            lang="{{ $defaultLang }}"></scholarship-advanced-search-on-school-page>


    </div>
</div>
@isset($school->scholarshipSetting->scholarshipSettingDetail[0])
    <div class="mt-10">
        {!! $school->scholarshipSetting->scholarshipSettingDetail[0]->scholarship_post_description ?? '' !!}
    </div>
    <div class="mt-10">
        {!! $school->scholarshipSetting->scholarshipSettingDetail[0]->programs_pre_description ?? '' !!}
    </div>
@endisset
@php
    $filteredPrograms = $school->schoolPrograms->filter(function ($program) {
        if(isset($program->Program)){
            return $program->Program->status === 'approved';
        }
    });
@endphp
@if (isset($filteredPrograms) && count($filteredPrograms) > 0)
    <div class="mt-10 bg-gray-100 p-4 py-6">
        <table class="min-w-full md:min-w-auto">
            <thead>
                <tr>
                    <th>Degree</th>
                    <th>Program</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filteredPrograms as $schoolProgram)
                    <tr>
                        <td>{{ $schoolProgram->Degree->degreeDetail[0]->name ?? '' }}</td>
                        <td>{{ $schoolProgram->Program->ProgramDetail[0]->name ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@isset($school->scholarshipSetting->scholarshipSettingDetail[0])
    <div class="mt-10">
        {!! $school->scholarshipSetting->scholarshipSettingDetail[0]->programs_post_description ?? '' !!}
    </div>
@endisset
{{-- @isset($school->scholarshipSetting, $school->scholarshipSetting->video_url)
    <div class="mt-10">
        {!! $school->scholarshipSetting->video_iframe !!}
    </div>
@endisset --}}
@isset($school->scholarshipSetting->scholarshipSettingDetail[0])
    <div class="mt-10">
        {!! $school->scholarshipSetting->scholarshipSettingDetail[0]->faq_pre_description ?? '' !!}
    </div>
@endisset

@isset($school->scholarshipSetting->video_url)
        <div class="my-10">
            {!! $school->scholarshipSetting->video_iframe !!}
        </div>
    @endisset

@php
    $filteredFaqs = $school->faqs->where('type', 'scholarship')->all();
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
                                class="text-black font-bold lg:text-lg">{{ isset($faq->FaqDetail[0]->question) ? $faq->FaqDetail[0]->question : '' }}</span>
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
@isset($school->scholarshipSetting->scholarshipSettingDetail[0])
    <div class="mt-10">
        {!! $school->scholarshipSetting->scholarshipSettingDetail[0]->faq_post_description ?? '' !!}
    </div>
@endisset


@isset($school->scholarshipSetting)
    <div class="row justify-content-center mb-5 mt-10">
        <div class="w-full md:w-1/2 mx-auto flex text-center">
            <a href="{{ $school->scholarshipSetting->scholarship_settings_apply_button_link ?: '#' }}" 
                target="_blank" 
                class="canedu_btn w-full py-4">
                {{ $school->scholarshipSetting->scholarship_settings_apply_button_title ?: 'Apply Now' }}
            </a>
        </div>
    </div>
@endisset

<div class="w-full my-6">
    <div class="col-12">
        <div class="grid grid-cols-12 canedu_btn rounded p-0 w-full mx-auto">
            <div style="max-width: 0.333333%;"></div>

            <!-- First Link for Sub Title -->
            <a href="{{ isset($school->scholarshipSetting->scholarship_settings_blue_bar_button_link) ? formatUrl($school->scholarshipSetting->scholarship_settings_blue_bar_button_link) : '' }}" 
                target="_blank" 
                class="col-span-4 py-5 bg-[#01468f] rounded-0 text-white font-medium text-center">
                <p class="font-FuturaMdCnBT text-center text-xl text-white">
                    {{ isset($school->scholarshipSetting->scholarship_settings_blue_bar_button_title) ? $school->scholarshipSetting->scholarship_settings_blue_bar_button_title : 'Good to go?' }}
                </p>
            </a>

            <!-- Second Link for Main Title -->
            <a href="{{ isset($school->scholarshipSetting->scholarship_settings_red_bar_button_link) ? formatUrl ($school->scholarshipSetting->scholarship_settings_red_bar_button_link) : '' }}" 
                target="_blank" 
                class="col-span-7 py-5 text-white font-medium text-center">
                <p class="font-FuturaMdCnBT text-center text-white  text-xl">
                    {{ isset($school->scholarshipSetting->scholarship_settings_red_bar_button_title) ? $school->scholarshipSetting->scholarship_settings_red_bar_button_title : 'Let’s apply' }}
                </p>
            </a>
        </div>
    </div>
</div>