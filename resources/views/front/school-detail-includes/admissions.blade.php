@isset($school->admissionSetting->admissionSettingDetail[0])
    <div class="mt-10">

        {!! $school->admissionSetting->admissionSettingDetail[0]->employees_pre_description ?? '' !!}

    </div>
@endisset
@if (isset($school->schoolEmployees) && count($school->schoolEmployees) > 0)
    <div class="my-10 bg-gray-100 border rounded">
        <div class="p-4 border-b border-gray-300 bg-gray-200">
            <h2 class="can-edu-h2 capitalize mb-0">Employees</h2>
        </div>
        <div class="employee_cards">
            @if (isset($school->schoolEmployees))
                @foreach ($school->schoolEmployees as $employee)
                    <div class="card_bg border-b rounded p-4 w-full grid grid-cols-12 gap-6">
                        <div class="col-span-12 md:col-span-5 flex items-center justify-center">
                            <div class="h-60 border bg-gray-50">
                                <img src="{{ asset(thumbnailImage($employee->image)) }}"
                                    class="h-full w-full object-cover" alt="">
                            </div>
                        </div>
                        <div class="col-span-12 md:col-span-7">
                            <div class="grid grid-cols-1">
                                <div class="grid grid-cols-12">
                                    <div class="col-span-3">
                                        <p class=" font-bold text-gray-950">Name</p>
                                    </div>
                                    <div class="col-span-1">
                                        <p class=" font-bold text-gray-950">:</p>
                                    </div>
                                    <div class="col-span-8 font-semibold text-gray-900">
                                        <p class=" font-bold text-gray-950">
                                            {{ isset($employee->schoolEmployeeDetail[0]->name) ? $employee->schoolEmployeeDetail[0]->name : '' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-12 mt-2">
                                    <div class="col-span-3">
                                        <p class=" font-bold text-gray-950">Position</p>
                                    </div>
                                    <div class="col-span-1">
                                        <p class=" font-bold text-gray-950">:</p>
                                    </div>
                                    <div class="col-span-8 text-gray-700">

                                        <p>{{ isset($employee->position) ? $employee->position : '' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-12 mt-2">
                                    <div class="col-span-4 md:col-span-3">
                                        <p class=" font-bold text-gray-950">Description</p>
                                    </div>
                                    <div class="col-span-1">
                                        <p class=" font-bold text-gray-950">:</p>
                                    </div>
                                    <div class="col-span-7 md:col-span-8 text-gray-700">
                                        <p>
                                            {{ isset($employee->schoolEmployeeDetail[0]->description) ? $employee->schoolEmployeeDetail[0]->description : '' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-12 mt-2">
                                    <div class="col-span-3">
                                        <p class="font-bold text-black">Phone</p>
                                    </div>
                                    <div class="col-span-1 ">
                                        <p class="font-bold text-black">:</p>
                                    </div>
                                    <div class="col-span-8 text-gray-700">
                                        <p> {{ isset($employee->telephone) ? $employee->telephone : '' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-12 mt-2">
                                    <div class="col-span-3 font-bold text-gray-900">
                                        <p class=" font-bold text-gray-950">More 1</p>
                                    </div>
                                    <div class="col-span-1 font-bold text-gray-700">
                                        <p class=" font-bold text-gray-950">:</p>
                                    </div>
                                    <div class="col-span-8 text-gray-700">
                                        <p>{{ isset($employee->more_1) ? $employee->more_1 : '' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-12 mt-2">
                                    <div class="col-span-3 font-bold text-gray-900">
                                        <p class=" font-bold text-gray-950">Email</p>
                                    </div>
                                    <div class="col-span-1 font-bold text-gray-700">
                                        <p class=" font-bold text-gray-950">:</p>
                                    </div>
                                    <div class="col-span-8 text-gray-700">
                                        <p>{{ isset($employee->email) ? $employee->email : '' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-12 mt-2">
                                    <div class="col-span-3 font-bold text-gray-900">
                                        <p class=" font-bold text-gray-950">More 2</p>
                                    </div>
                                    <div class="col-span-1 font-bold text-gray-900">
                                        <p class=" font-bold text-gray-950">:</p>
                                    </div>
                                    <div class="col-span-8 text-gray-700">
                                        <p>{{ isset($employee->more_2) ? $employee->more_2 : '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            @endif
        </div>
    </div>
@endif
@isset($school->admissionSetting->admissionSettingDetail[0])
    <div class="mt-10">

        {!! $school->admissionSetting->admissionSettingDetail[0]->employees_post_description ?? '' !!}

    </div>
    <div class="mt-10">

        {!! $school->admissionSetting->admissionSettingDetail[0]->team_pre_description ?? '' !!}

    </div>
@endisset
@php
    $members = getTeamMembersBySchoolId($school->id);
@endphp

@if ($members && count($members) > 0)
    <div class="my-10">
        <div class="my-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($members as $member)
                <div>
                    @php
                        $images = $member->image;
                        $images = explode(',', $images);
                        $image = $images[0] ?? null;
                    @endphp
                    <div class="h-80 w-full bg-gray-50 border">
                        <img class="w-full h-full object-contain" src="{{ asset($image) }}" alt="">
                    </div>
                    <div class="bg-gray-50 p-4">
                        <h3 class="mb-0">{{ $member->name }}</h3>
                        <h6 class="text-base font-semibold text-gray-600">{{ $member->designation }}</h6>
                        <p class="text-base">{!! $member->summary !!}</p>
                        <div class="flex items-center space-x-2 mt-3 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                            <span>{!! $member->phone !!}</span>
                        </div>
                        <div class="flex items-center space-x-2 mt-3 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <span>{!! $member->email !!}</span>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endif
@isset($school->admissionSetting->admissionSettingDetail[0])
    <div class="mt-10">

        {!! $school->admissionSetting->admissionSettingDetail[0]->team_post_description ?? '' !!}

    </div>
    <div class="mt-10">

        {!! $school->admissionSetting->admissionSettingDetail[0]->faq_pre_description ?? '' !!}

    </div>
@endisset
@php
    $filteredFaqs = $school->faqs->where('type', 'admission')->all();
@endphp
@if (isset($filteredFaqs) && count($filteredFaqs) > 0)
    <div class="my-10">
        <h2 class="can-edu-h3 capitalize mb-2">Frequently asked questions</h2>
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


@isset($school->admissionSetting->admissionSettingDetail[0])
    <div class="mt-10">

        {!! $school->admissionSetting->admissionSettingDetail[0]->faq_post_description ?? '' !!}

    </div>
@endisset

@isset($school->admissionSetting)
    <div class="row justify-content-center mb-5 mt-10">
        <div class="w-full md:w-1/2 mx-auto flex text-center">
            <a href="{{ $school->admissionSetting->admission_apply_button_link ?: '#' }}" 
                target="_blank" 
                class="canedu_btn w-full py-4">
                {{ $school->admissionSetting->admission_apply_button_title ?: 'Apply Now' }}
            </a>
        </div>
    </div>
@endisset

<div class="w-full my-6">
    <div class="col-12">
        <div class="grid grid-cols-12 canedu_btn rounded p-0 w-full mx-auto">
            <div style="max-width: 0.333333%;"></div>

            <!-- First Link for Sub Title -->
            <a href="{{ isset($school->admissionSetting->admission_blue_bar_button_link) ? formatUrl($school->admissionSetting->admission_blue_bar_button_link) : '' }}" 
                target="_blank" 
                class="col-span-4 py-5 bg-[#01468f] rounded-0 text-white font-medium text-center">
                <p class="font-FuturaMdCnBT text-center text-xl text-white">
                    {{ isset($school->admissionSetting->admission_blue_bar_button_title) ? $school->admissionSetting->admission_blue_bar_button_title : 'Good to go?' }}
                </p>
            </a>

            <!-- Second Link for Main Title -->
            <a href="{{ isset($school->admissionSetting->admission_red_bar_button_link) ? formatUrl ($school->admissionSetting->admission_red_bar_button_link) : '' }}" 
                target="_blank" 
                class="col-span-7 py-5 text-white font-medium text-center">
                <p class="font-FuturaMdCnBT text-center text-white  text-xl">
                    {{ isset($school->admissionSetting->admission_red_bar_button_title) ? $school->admissionSetting->admission_red_bar_button_title : 'Let’s apply' }}
                </p>
            </a>
        </div>
    </div>
</div>