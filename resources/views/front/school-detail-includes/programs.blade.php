@isset($school->schoolProgramSetting->schoolProgramSettingDetail[0])
    <div class="my-10">
        <h2 class="can-edu-h2 normal-case mb-2">
            {!! isset($school->schoolProgramSetting->schoolProgramSettingDetail[0]->title_1)
                ? $school->schoolProgramSetting->schoolProgramSettingDetail[0]->title_1
                : '' !!}
        </h2>
        <p class="text-gray-500">
            {!! isset($school->schoolProgramSetting->schoolProgramSettingDetail[0]->title_1_paragraph)
                ? $school->schoolProgramSetting->schoolProgramSettingDetail[0]->title_1_paragraph
                : '' !!}
        </p>
    </div>
@endisset
@if (count($school->schoolPrograms) > 0)
    <div class="my-10">
        <div class="border">
            @if (isset($school->schoolPrograms))
                <?php $degrees = []; ?>
                @foreach ($school->schoolPrograms as $schoolProgram)
                    @if (!in_array($schoolProgram->degree_id, $degrees))
                        @if (isset($schoolProgram->program) && !is_null($schoolProgram->program) && $schoolProgram->program->status == 'approved')
                            <div class="programs_list p-4 border-b">
                                <h4 class="heading4 normal-case mb-2">
                                    {{ isset($schoolProgram->degree->degreeDetail[0]->name) ? $schoolProgram->degree->degreeDetail[0]->name : '' }}
                                </h4>
                                <ul class="max-w-md space-y-1 text-gray-500 list-inside mb-4">
                                    @foreach ($school->schoolPrograms as $schoolProgram1)
                                        @if ($schoolProgram->degree_id == $schoolProgram1->degree_id)
                                            <li class="flex items-center before:hidden pl-0">
                                                <span class=" mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                                                        class="w-5 h-5 stroke-blue-900">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                                    </svg>
                                                </span>
                                                {{ isset($schoolProgram1->program->programDetail[0]->name) ? $schoolProgram1->program->programDetail[0]->name : '' }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <?php $degrees[] = $schoolProgram->degree_id; ?>
                        @endif
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@endif
@php
    $filteredFaqs = $school->faqs->where('type', 'programs')->all();
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
                                class="truncate text-gray-600 font-bold">{{ isset($faq->FaqDetail[0]->question) ? $faq->FaqDetail[0]->question : '' }}</span>
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

@isset($school->schoolProgramSetting)
    <div class="row justify-content-center mb-5 mt-10">
        <div class="w-full md:w-1/2 mx-auto flex text-center">
            <a href="{{ $school->schoolProgramSetting->school_program_apply_button_link ?: '#' }}" 
                target="_blank" 
                class="canedu_btn w-full py-4">
                {{ $school->schoolProgramSetting->school_program_apply_button_title ?: 'Apply Now' }}
            </a>
        </div>
    </div>
@endisset

<div class="w-full my-6">
    <div class="col-12">
        <div class="grid grid-cols-12 canedu_btn rounded p-0 w-full mx-auto">
            <div style="max-width: 0.333333%;"></div>

            <!-- First Link for Sub Title -->
            <a href="{{ isset($school->schoolProgramSetting->school_program_blue_bar_button_link) ? formatUrl($school->schoolProgramSetting->school_program_blue_bar_button_link) : '' }}" 
                target="_blank" 
                class="col-span-4 py-5 bg-[#01468f] rounded-0 text-white font-medium text-center">
                <p class="font-FuturaMdCnBT text-center text-xl text-white">
                    {{ isset($school->schoolProgramSetting->school_program_blue_bar_button_title) ? $school->schoolProgramSetting->school_program_blue_bar_button_title : 'Good to go?' }}
                </p>
            </a>

            <!-- Second Link for Main Title -->
            <a href="{{ isset($school->schoolProgramSetting->school_program_red_bar_button_link) ? formatUrl ($school->schoolProgramSetting->school_program_red_bar_button_link) : '' }}" 
                target="_blank" 
                class="col-span-7 py-5 text-white font-medium text-center">
                <p class="font-FuturaMdCnBT text-center text-white  text-xl">
                    {{ isset($school->schoolProgramSetting->school_program_red_bar_button_title) ? $school->schoolProgramSetting->school_program_red_bar_button_title : 'Let’s apply' }}
                </p>
            </a>
        </div>
    </div>
</div>