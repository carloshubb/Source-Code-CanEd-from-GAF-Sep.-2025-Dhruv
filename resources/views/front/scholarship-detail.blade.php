@extends('front.layouts.app')
@php
    $currentScholarshipId = request()->route('id'); 
@endphp
@section('content')
    <div class="bg-white container mx-auto">
        <div class="">
            <div class="grid grid-cols-12 gap-4 lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
                <div class="col-span-12 sm:col-span-12 md:col-span-8 lg:col-span-8 md:px-4">
                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
                        <div class="border-b-4 pb-2 border-primary w-full flex items-center justify-between">
                            <h1 class="can-edu-h1">
                                {{ isset($scholarship->schoolScholarshipDetail[0]->name) ? $scholarship->schoolScholarshipDetail[0]->name : '' }}
                            </h1>
                            <?php 
                                $favToolTip = isset(getStaticTranslation('general')['add_to_favorites_text']) ? getStaticTranslation('general')['add_to_favorites_text'] : '';
                            ?>
                            <?php
                            $favToolTip = isset(getStaticTranslation('general')['add_to_favorites_text']) ? getStaticTranslation('general')['add_to_favorites_text'] : '';
                            ?>
                            <fav-icon record_id="{{ $scholarship->id }}" model="scholarship"
                                is_favourit="{{ $favorite }}" tooltiptext="{{$favToolTip}}" />
                        </div>
                    </div>

                    @if (!empty($scholarship->image))
                        <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border rounded mb-5">
                            <img class="w-full h-full object-contain mx-auto"
                                src="{{ asset(largeImage($scholarship->image)) }}" alt="">
                        </div>
                    @endif

                    <div class="mt-6">
                        <div class="text-black text_justify">
                            {!! isset($scholarship->schoolScholarshipDetail[0]->summary)
                                ? $scholarship->schoolScholarshipDetail[0]->summary
                                : '' !!}
                        </div>
                        

                        <div class="grid grid-cols-1 pt-4">

                            <div class="grid grid-cols-12 gap-4 ">
                                <div class="col-span-4 font-extrabold">
                                    <p>{{ isset($scholarshipTranslations['school_text']) ? $scholarshipTranslations['school_text'] : '' }}
                                    </p>
                                </div>
                                
                                <div class="col-span-8 text-black">
                                    <p>{{ isset($scholarship->school->schoolDetail[0]->school_name) ? $scholarship->school->schoolDetail[0]->school_name : '' }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 mt-3">
                                <div class="col-span-4 font-extrabold">
                                    <p>{{ isset($scholarshipTranslations['province_text']) ? $scholarshipTranslations['province_text'] : '' }}
                                    </p>
                                </div>
                                
                                <div class="col-span-8 text-black">
                                    <p>{{ isset($scholarship->province) ? $scholarship->province : '---' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 mt-3">
                                <div class="col-span-4 font-extrabold">
                                    <p>{{ isset($scholarshipTranslations['amount_text']) ? $scholarshipTranslations['amount_text'] : '' }}
                                    </p>
                                </div>
                                
                                <div class="col-span-8 text-black">
                                    <p>{{ isset($scholarship->amount) ? $scholarship->amount : '---' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 mt-3">
                                <div class="col-span-4 font-extrabold">
                                    <p>{{ isset($scholarshipTranslations['award_text']) ? $scholarshipTranslations['award_text'] : '' }}
                                    </p>
                                </div>
                                
                                <div class="col-span-8 text-black">
                                    <p>{{ isset($scholarship->award) ? $scholarship->award : '---' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 mt-3">
                                <div class="col-span-4 font-extrabold">
                                    <p>{{ isset($scholarshipTranslations['action_text']) ? $scholarshipTranslations['action_text'] : '' }}
                                    </p>
                                </div>
                                
                                <div class="col-span-8 text-black">
                                    <p>{{ isset($scholarship->action) ? $scholarship->action : '---' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 mt-3">
                                <div class="col-span-4 font-extrabold">
                                    <p>{{ isset($scholarshipTranslations['duration_text']) ? $scholarshipTranslations['duration_text'] : '' }}
                                    </p>
                                </div>
                                
                                <div class="col-span-8 text-black">
                                    <p>{{ isset($scholarship->duration) ? $scholarship->duration : '---' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 mt-3">
                                <div class="col-span-4 font-extrabold">
                                    <p>{{ isset($scholarshipTranslations['date_posted_text']) ? $scholarshipTranslations['date_posted_text'] : '' }}
                                    </p>
                                </div>
                                
                                <div class="col-span-8 text-black">
                                    <p>
                                        {{ !empty($scholarship->date_posted) && strtotime($scholarship->date_posted) 
                                            ? date('F d, Y', strtotime($scholarship->date_posted)) 
                                            : 'Not available' }}
                                        </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 mt-3">
                                <div class="col-span-4 font-extrabold">
                                    <p>{{ isset($scholarshipTranslations['deadline_text']) ? $scholarshipTranslations['deadline_text'] : '' }}
                                    </p>
                                </div>
                                
                                <div class="col-span-8 text-black">
                                    <p>
                                        
                                        {{-- {{ isset($scholarship->deadline_date) ? date('F d, Y', strtotime($scholarship->deadline_date)) : '---' }} --}}
                                        {{ !empty($scholarship->deadline_date) && strtotime($scholarship->deadline_date) 
                                            ? date('F d, Y', strtotime($scholarship->deadline_date)) 
                                            : 'Not available' }}
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 mt-3">
                                <div class="col-span-4 font-extrabold">
                                    <p>{{ isset($scholarshipTranslations['expiry_date_text']) ? $scholarshipTranslations['expiry_date_text'] : '' }}
                                    </p>
                                </div>
                                
                                <div class="col-span-8 text-black">
                                    <p>
                                        {{-- {{ isset($scholarship->expiry_date) ? date('F d, Y', strtotime($scholarship->expiry_date)) : '---' }} --}}
                                        {{ !empty($scholarship->expiry_date) && strtotime($scholarship->expiry_date) 
                                            ? date('F d, Y', strtotime($scholarship->expiry_date)) 
                                            : 'Not available' }}
                                        </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 mt-3">
                                <div class="col-span-4 font-extrabold">
                                    <p>{{ isset($scholarshipTranslations['level_of_study_text']) ? $scholarshipTranslations['level_of_study_text'] : '' }}
                                    </p>
                                </div>
                                
                                <div class="col-span-8 text-black">
                                    <p>{{ isset($scholarship->study_level) ? $scholarship->study_level : '---' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 mt-3">
                                <div class="col-span-4 font-extrabold">
                                    <p>{{ isset($scholarshipTranslations['availability_text']) ? $scholarshipTranslations['availability_text'] : '' }}
                                    </p>
                                </div>
                                
                                <div class="col-span-8 text-black">
                                    <p>{{ isset($scholarship->availability) ? $scholarship->availability : '---' }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 gap-4 mt-3">
                                <div class="col-span-4 font-extrabold">
                                    <p>Criteria</p>
                                </div>
                                
                                <div class="col-span-8 text-black">
                                    <p>
                                        {{ isset($scholarship->schoolScholarshipDetail[0]->criteria) ? $scholarship->schoolScholarshipDetail[0]->criteria : '' }}
                                    </p>
                                </div>
                            </div>

                            {{-- <div class="grid grid-cols-12 gap-4 mt-3">
                                <div class="col-span-4 font-extrabold">
                                    <p>{{ isset($scholarshipTranslations['email_text']) ? $scholarshipTranslations['email_text'] : '' }}
                                    </p>
                                </div>
                                
                                <div class="col-span-8 text-black">
                                    <p>{{ isset($scholarship->email) ? $scholarship->email : '---' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 mt-3">
                                <div class="col-span-4 font-extrabold">
                                    <p>{{ isset($scholarshipTranslations['phone_text']) ? $scholarshipTranslations['phone_text'] : '' }}
                                    </p>
                                </div>
                                
                                <div class="col-span-8 text-black">
                                    <p>{{ isset($scholarship->phone) ? $scholarship->phone : '---' }}</p>
                                </div>
                            </div> --}}

                                                                    @php
                                            function formatUrl($url) {
                                                return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
                                            }
                                        @endphp
                            <div class="flex justify-center items-center mt-10 gap-5">
                                <a href="{{ isset($scholarship->more_info_link) ? formatUrl($scholarship->more_info_link) : '' }}" target="_blank">
                                    <button
                                        class="can-edu-btn-fill whitespace-nowrap">{{ isset($scholarshipTranslations['apply_now_button_text']) ? $scholarshipTranslations['apply_now_button_text'] : '' }}</button>
                                </a>
                                <a href="{{ isset($scholarship->link) ? formatUrl($scholarship->link) : '' }}"
                                    target="_blank">
                                    <button
                                        class="can-edu-btn-fill whitespace-nowrap">
                                        {{-- {{ isset($scholarshipTranslations['learn_more_button_text']) ? $scholarshipTranslations['learn_more_button_text'] : '' }} --}}
                                        Apply now
                                    </button>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-12 md:col-span-4 lg:col-span-4 space-y-4">
                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
                        <div class="border-b-4 pb-2 pt-1 border-primary w-full flex items-center justify-between">
                            <h2 class="can-edu-h2 mb-0">
                                {{ isset($scholarshipTranslations['more_scholarship_text']) ? $scholarshipTranslations['more_scholarship_text'] : '' }}
                            </h2>
                        </div>
                    </div>
                    {{-- @foreach ($scholarships as $scholarship)
                        <div class="mt-4">
                            <a
                                href="{{ route('web.view.scholarship.detail', ['lang' => getDefaultLanguage(1)['abbreviation'], 'id' => $scholarship->id]) }}">
                                <div class="border rounded p-4">
                                    <h5 class="can-edu-card-h mb-1">
                                        {{ isset($scholarship->schoolScholarshipDetail[0]->name) ? $scholarship->schoolScholarshipDetail[0]->name : '' }}
                                    </h5>
                                    <div class="can-edu-card-p line-clamp-3 text_justify text-justify">{!! isset($scholarship->schoolScholarshipDetail[0]->summary)
                                        ? $scholarship->schoolScholarshipDetail[0]->summary
                                        : '' !!}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach --}}
                    @foreach ($scholarships->where('id', '!=', $currentScholarshipId) as $scholarship)
                            <div class="mt-4">
                                <a href="{{ route('web.view.scholarship.detail', ['lang' => getDefaultLanguage(1)['abbreviation'], 'id' => $scholarship->id]) }}">
                                    <div class="border rounded p-4">
                                        <h5 class="can-edu-card-h mb-1">
                                            {{ $scholarship->schoolScholarshipDetail[0]->name ?? '' }}
                                        </h5>
                                        <div class="can-edu-card-p line-clamp-3 text_justify text-justify">
                                            {!! $scholarship->schoolScholarshipDetail[0]->summary ?? '' !!}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                </div>
            </div>

        </div>

    </div>
@endsection
