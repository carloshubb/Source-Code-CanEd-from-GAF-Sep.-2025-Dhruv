@if (isset($school->schoolFinancial->schoolFinancialDetail[0]->tabs_pre_description))
    <div class="mt-10">

        {!! $school->schoolFinancial->schoolFinancialDetail[0]->tabs_pre_description ?? '' !!}

    </div>
@endif
@if (isset($school->schoolFinancial->schoolFinancialDetail[0]->tab1_name) &&
        isset($school->schoolFinancial->schoolFinancialDetail[0]->tab2_name) &&
        isset($school->schoolFinancial->schoolFinancialDetail[0]->tab3_name))
    <div class="my-10">
        <div class="flex flex-wrap" id="tabs-id">
            <div class="w-full">
                <ul class="flex mb-0 list-none flex-wrap pt-3 flex-row">
                    @if (isset($school->schoolFinancial->schoolFinancialDetail[0]->tab1_name))
                        <li class=" w-1/3 text-center pl-0 before:hidden">
                            <span
                                class="cursor-pointer font-medium px-2 lg:px-5 py-[11px] block lg:leading-normal border-t-4 border-t-primary border-b-0 bg-gray-100 font-FuturaMdCnBT text-xl leading-6 lg:text-2xl text-gray-800 hover:bg-gray-100 border"
                                onclick="changeAtiveTab(event,'tab-international-student')">
                                {!! $school->schoolFinancial->schoolFinancialDetail[0]->tab1_name ?? '' !!}
                            </span>
                        </li>
                    @endif
                    @if (isset($school->schoolFinancial->schoolFinancialDetail[0]->tab2_name))
                        <li class=" w-1/3 text-center pl-0 before:hidden">
                            <span
                                class="cursor-pointer font-medium px-5 py-3 block lg:leading-normal font-FuturaMdCnBT text-xl leading-6 lg:text-2xl text-gray-800 hover:bg-gray-100 border bg-white"
                                onclick="changeAtiveTab(event,'tab-settings')">
                                {!! $school->schoolFinancial->schoolFinancialDetail[0]->tab2_name ?? '' !!}
                            </span>
                        </li>
                    @endif
                    @if (isset($school->schoolFinancial->schoolFinancialDetail[0]->tab3_name))
                        <li class=" w-1/3 text-center pl-0 before:hidden">
                            <span
                                class="cursor-pointer font-medium px-5 py-3 block lg:leading-normal font-FuturaMdCnBT text-xl leading-6 lg:text-2xl text-gray-800 hover:bg-gray-100 border bg-white"
                                onclick="changeAtiveTab(event,'tab-options')">
                                {!! $school->schoolFinancial->schoolFinancialDetail[0]->tab3_name ?? '' !!}
                            </span>
                        </li>
                    @endif
                </ul>
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6">
                    <div class="flex-auto">
                        <div class="tab-content tab-space">
                            <div class="block bg-gray-100 tab_form" id="tab-international-student">
                                {!! $school->schoolFinancial->schoolFinancialDetail[0]->tab1_description ?? '' !!}
                            </div>
                            <div class="hidden bg-gray-100 tab_form" id="tab-settings">
                                {!! $school->schoolFinancial->schoolFinancialDetail[0]->tab2_description ?? '' !!}
                            </div>
                            <div class="hidden bg-gray-100 tab_form" id="tab-options">
                                {!! $school->schoolFinancial->schoolFinancialDetail[0]->tab3_description ?? '' !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@if (isset($school->schoolFinancial->schoolFinancialDetail[0]->tabs_post_description))
    <div class="mt-10">

        {!! $school->schoolFinancial->schoolFinancialDetail[0]->tabs_post_description ?? '' !!}

    </div>
@endif
@if (isset($school->schoolFinancial->schoolFinancialDetail[0]->scholarship_pre_description))
    <div class="mt-10">

        {!! $school->schoolFinancial->schoolFinancialDetail[0]->scholarship_pre_description ?? '' !!}

    </div>
@endif
@isset($school->schoolScholarships)
    <div class="my-10">
        <h2 class="can-edu-h2 capitalize mb-2">Scholarships states</h2>
        @php
            $scholarshipTranslations = getStaticTranslation('scholarships');
        @endphp
        <div class="flex flex-col w-full">
            <!-- Scholarships, international students -->
            @foreach ($school->schoolScholarships as $schoolScholarship)
                <button class="group border border-gray-300 focus:outline-none">
                    <div
                        class="flex items-center justify-between bg-primary text-white group-focus:bg-primary h-12 px-3 font-semibold hover:bg-secondaryRed ">
                        <span class="truncate text-white font-bold lg:text-lg">
                            {{ $schoolScholarship->schoolScholarshipDetail[0]->name ?? '' }}
                        </span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            stroke="1.5">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="max-h-0 overflow-hidden duration-300 group-focus:max-h-max employee_cards">
                        <!-- Scholarships cards-->
                        <div class="card_bg p-4 border-b">
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-bold">
                                    <p class="font-bold font-FuturaMdCnBT text-xl">
                                        {{ $scholarshipTranslations['province_text'] ?? '' }}
                                    </p>
                                </div>
                                <div class="col-span-1 text-center font-bold">:</div>
                                <div class="col-span-7 md:col-span-9 text-black">
                                    <p>
                                        {!! $schoolScholarship->province ?? '' !!}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-bold">
                                    <p class="font-bold font-FuturaMdCnBT text-xl">
                                        {{ $scholarshipTranslations['amount_text'] ?? '' }}
                                    </p>
                                </div>
                                <div class="col-span-1 text-center font-bold">:</div>
                                <div class="col-span-7 md:col-span-9 text-black">
                                    <p>
                                        {!! $schoolScholarship->amount ?? '' !!}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-bold">
                                    <p class="font-bold font-FuturaMdCnBT text-xl">
                                        {{ $scholarshipTranslations['award_text'] ?? '' }}
                                    </p>
                                </div>
                                <div class="col-span-1 text-center font-bold">:</div>
                                <div class="col-span-7 md:col-span-9 text-black">
                                    <p>
                                        {!! $schoolScholarship->award ?? '' !!}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-bold">
                                    <p class="font-bold font-FuturaMdCnBT text-xl">
                                        {{ $scholarshipTranslations['action_text'] ?? '' }}
                                    </p>
                                </div>
                                <div class="col-span-1 text-center font-bold">:</div>
                                <div class="col-span-7 md:col-span-9 text-black">
                                    <p>
                                        {!! $schoolScholarship->action ?? '' !!}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-bold">
                                    <p class="font-bold font-FuturaMdCnBT text-xl">
                                        {{ $scholarshipTranslations['duration_text'] ?? '' }}
                                    </p>
                                </div>
                                <div class="col-span-1 text-center font-bold">:</div>
                                <div class="col-span-7 md:col-span-9 text-black">
                                    <p>
                                        {!! $schoolScholarship->duration ?? '' !!}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-bold">
                                    <p class="font-bold font-FuturaMdCnBT text-xl">
                                        {{ $scholarshipTranslations['date_posted_text'] ?? '' }}
                                    </p>
                                </div>
                                <div class="col-span-1 text-center font-bold">:</div>
                                <div class="col-span-7 md:col-span-9 text-black">
                                    <p>
                                        {{ isset($schoolScholarship->date_posted) ? date('F d, Y', strtotime($schoolScholarship->date_posted)) : '' }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-bold">
                                    <p class="font-bold font-FuturaMdCnBT text-xl">
                                        {{ $scholarshipTranslations['deadline_text'] ?? '' }}
                                    </p>
                                </div>
                                <div class="col-span-1 text-center font-bold">:</div>
                                <div class="col-span-7 md:col-span-9 text-black">
                                    <p>
                                        {{ isset($schoolScholarship->deadline_date) ? date('F d, Y', strtotime($schoolScholarship->deadline_date)) : '' }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-bold">
                                    <p class="font-bold font-FuturaMdCnBT text-xl">
                                        {{ $scholarshipTranslations['expiry_date_text'] ?? '' }}
                                    </p>
                                </div>
                                <div class="col-span-1 text-center font-bold">:</div>
                                <div class="col-span-7 md:col-span-9 text-black">
                                    <p>
                                        {{ isset($schoolScholarship->expiry_date) ? date('F d, Y', strtotime($schoolScholarship->expiry_date)) : '' }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-bold">
                                    <p class="font-bold font-FuturaMdCnBT text-xl">
                                        {{ $scholarshipTranslations['level_of_study_text'] ?? '' }}
                                    </p>
                                </div>
                                <div class="col-span-1 text-center font-bold">:</div>
                                <div class="col-span-7 md:col-span-9 text-black">
                                    <p>
                                        {!! $schoolScholarship->study_level ?? '' !!}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-bold">
                                    <p class="font-bold font-FuturaMdCnBT text-xl">
                                        {{ $scholarshipTranslations['availability_text'] ?? '' }}
                                    </p>
                                </div>
                                <div class="col-span-1 text-center font-bold">:</div>
                                <div class="col-span-7 md:col-span-9 text-black">
                                    <p>
                                        {!! $schoolScholarship->availability ?? '' !!}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-bold">
                                    <p class="font-bold font-FuturaMdCnBT text-xl">
                                        {{ $scholarshipTranslations['email_text'] ?? '' }}
                                    </p>
                                </div>
                                <div class="col-span-1 text-center font-bold">:</div>
                                <div class="col-span-7 md:col-span-9 text-black">
                                    <p>
                                        {!! $schoolScholarship->email ?? '' !!}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-bold">
                                    <p class="font-bold font-FuturaMdCnBT text-xl">
                                        {{ $scholarshipTranslations['phone_text'] ?? '' }}
                                    </p>
                                </div>
                                <div class="col-span-1 text-center font-bold">:</div>
                                <div class="col-span-7 md:col-span-9 text-black">
                                    <p>
                                        {!! $schoolScholarship->phone ?? '' !!}
                                    </p>
                                </div>
                            </div>
                            {{-- <div class="grid grid-cols-12 mt-3">
                                <div class="col-span-4 md:col-span-2 font-bold">
                                    <p class="font-bold font-FuturaMdCnBT text-xl">
                                        Summary
                                    </p>
                                </div>
                                <div class="col-span-1 text-center font-bold">:</div>
                                <div class="col-span-7 md:col-span-9 text-black line-clamp-3 text_justify">
                                    {!! $schoolScholarship->schoolScholarshipDetail[0]->summary ?? '' !!}
                                </div>
                            </div> --}}
                            {{-- <div class="grid grid-cols-12 mt-3">
                        <div class="col-span-4 md:col-span-2 font-bold">
                            <p class="font-bold font-FuturaMdCnBT text-xl">
                                Criteria
                            </p>
                        </div>
                        <div class="col-span-1 text-center font-bold">:</div>
                        <div class="col-span-7 md:col-span-9 text-black">
                            <p class="font-bold font-FuturaMdCnBT text-xl">

                            {!!$schoolScholarship->schoolScholarshipDetail[0]->criteria ?? ''!!}
                            </p>
                        </div>
                    </div> --}}
                            <div class="flex justify-start mt-6">
                                <a href="{{ isset($scholarship->link) ? $scholarship->link : '' }}" target="_blank"
                                    role="button"
                                    class="canedu_btn w-72">{{ $scholarshipTranslations['apply_now_button_text'] ?? '' }}
                                </a>
                            </div>
                        </div>

                    </div>
                </button>
            @endforeach

        </div>
    </div>
@endisset
@if (isset($school->schoolFinancial->schoolFinancialDetail[0]->scholarship_post_description))
    <div class="mt-10">

        {!! $school->schoolFinancial->schoolFinancialDetail[0]->scholarship_post_description ?? '' !!}

    </div>
@endif
@if (isset($school->schoolFinancial->schoolFinancialDetail[0]->programs_pre_description))
    <div class="mt-10">

        {!! $school->schoolFinancial->schoolFinancialDetail[0]->programs_pre_description ?? '' !!}

    </div>
@endif

@php
    $filteredPrograms = $school->schoolPrograms->filter(function ($program) {
        if(isset($program->Program)){

            return $program->Program->status === 'approved';
        }
    });
@endphp
@if (isset($filteredPrograms) && count($filteredPrograms) > 0)
    <div class="my-10">

        <div class="bg-gray-100 border p-4 py-6">
            <h2 class="can-edu-h2 capitalize mb-2">
                Other programs
            </h2>
            <table class="mt-4 min-w-full md:min-w-auto">
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
    </div>
@endif
@if (isset($school->schoolFinancial->schoolFinancialDetail[0]->programs_post_description))
    <div class="mt-10">

        {!! $school->schoolFinancial->schoolFinancialDetail[0]->programs_post_description ?? '' !!}

    </div>
@endif

@isset($school->schoolFinancial->video_url)
<div class="my-10">
        {!! $school->schoolFinancial->video_iframe !!}
    </div>
        {{-- @php
            dd($school->schoolFinancial->video_iframe)
        @endphp --}}
@endisset
@if (isset($school->schoolFinancial->schoolFinancialDetail[0]->faq_pre_description))
    <div class="mt-10">

        {!! $school->schoolFinancial->schoolFinancialDetail[0]->faq_pre_description ?? '' !!}

    </div>
@endif
@php
    $filteredFaqs = $school->faqs->where('type', 'financial')->all();
@endphp
@if (isset($filteredFaqs) && count($filteredFaqs) > 0)
    <div class="my-10">
        <h2 class="can-edu-h2 capitalize mb-2">Frequently asked questions</h2>
        <div class="flex justify-center items-center">

            <!-- Collapse Start -->
            <div class="flex flex-col w-full">
                @foreach ($filteredFaqs as $faq)
                    <button class="group border border-gray-300 mb-3 focus:outline-none">
                        <div
                            class="flex items-center justify-between group-focus:bg-blue-100 h-12 px-3 font-semibold hover:bg-gray-200 ">
                            <span
                                class=" text-black font-bold lg:text-lg">{{ isset($faq->FaqDetail[0]->question) ? $faq->FaqDetail[0]->question : '' }}</span>
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


@if (isset($school->schoolFinancial->schoolFinancialDetail[0]->faq_post_description))
    <div class="mt-10">

        {!! $school->schoolFinancial->schoolFinancialDetail[0]->faq_post_description ?? '' !!}

    </div>
@endif

@isset($school->schoolFinancial)
    <div class="row justify-content-center mb-5 mt-10">
        <div class="w-full md:w-1/2 mx-auto flex text-center">
            <a href="{{ $school->schoolFinancial->school_financials_apply_button_link ?: '#' }}" 
                target="_blank" 
                class="canedu_btn w-full py-4">
                {{ $school->schoolFinancial->school_financials_apply_button_title ?: 'Apply Now' }}
            </a>
        </div>
    </div>
@endisset

<div class="w-full my-6">
    <div class="col-12">
        <div class="grid grid-cols-12 canedu_btn rounded p-0 w-full mx-auto">
            <div style="max-width: 0.333333%;"></div>

            <!-- First Link for Sub Title -->
            <a href="{{ isset($school->schoolFinancial->school_financials_blue_bar_button_link) ? formatUrl($school->schoolFinancial->school_financials_blue_bar_button_link) : '' }}" 
                target="_blank" 
                class="col-span-4 py-5 bg-[#01468f] rounded-0 text-white font-medium text-center">
                <p class="font-FuturaMdCnBT text-center text-xl text-white">
                    {{ isset($school->schoolFinancial->school_financials_blue_bar_button_title) ? $school->schoolFinancial->school_financials_blue_bar_button_title : 'Good to go?' }}
                </p>
            </a>

            <!-- Second Link for Main Title -->
            <a href="{{ isset($school->schoolFinancial->school_financials_red_bar_button_link) ? formatUrl ($school->schoolFinancial->school_financials_red_bar_button_link) : '' }}" 
                target="_blank" 
                class="col-span-7 py-5 text-white font-medium text-center">
                <p class="font-FuturaMdCnBT text-center text-white  text-xl">
                    {{ isset($school->schoolFinancial->school_financials_red_bar_button_title) ? $school->schoolFinancial->school_financials_red_bar_button_title : 'Let’s apply' }}
                </p>
            </a>
        </div>
    </div>
</div>