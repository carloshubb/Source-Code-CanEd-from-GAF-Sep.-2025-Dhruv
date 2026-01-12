@extends('front.layouts.app')
@php
  $loggedInCustomer = Auth::guard('customers')->user();
    $userType = $loggedInCustomer ? $loggedInCustomer->user_type : '';

    // Fetch customer_id and school_id
    $customerId = $ambassadorObject->customer_id ?? null;
    $schoolId = $ambassadorObject->school_id ?? null;

    // Determine the title text
    if ($userType === 'school' || $userType === 'student') {
        $titleText = 'This is my school';
    } elseif ($userType === 'business' || (is_null($customerId) && is_null($schoolId))) {
        $titleText = 'This is my work';
    } else {
        $titleText = '';
    }
@endphp
@section('content')
    <div class="bg-white container mx-auto">
       
        <div class="w-full mt-10">
            <div class="p-5 bg-white rounded shadow-md border">
                <div class="border-b-4 py-2 border-primary mt-4 w-full">
                    <div class="flex justify-between items-center">
                        <p class="can-edu-h3 text-primary">
                            {{ isset($ambassadorObject->schoolAmbassadorDetail[0]->name) ? $ambassadorObject->schoolAmbassadorDetail[0]->name : '' }}'s
                            {{ isset($ambassadorTranslations['profile_label_text']) ? $ambassadorTranslations['profile_label_text'] : '' }}
                        </p>
                    </div>
                </div>
                <div class="justify-center flex -mt-6">
                    <div>
                        <div class="relative">
                            {{-- <img class="w-36 h-36 rounded-full border-[6px] border-white bg-gray-50"
                                src="{{ asset($ambassadorObject->image) }}" alt="asdasd" /> --}}
                            <img class="w-36 h-36 rounded-full border-[6px] border-white bg-gray-50"
                                src="{{ $ambassadorObject->image ? asset($ambassadorObject->image) : 'https://www.w3schools.com/howto/img_avatar.png' }}"
                                alt="Avatar" />

                        </div>
                        <h4 class="text-center">
                            Hey! I am
                            {{ isset($ambassadorObject->schoolAmbassadorDetail[0]->name) ? $ambassadorObject->schoolAmbassadorDetail[0]->name : '' }}
                        </h4>
                    </div>
                </div>
                <div class="mt-3 px-3">
                    <div class="border-b">
                        <div class="flex items-center gap-4 relative divide-x pb-3">
                            {{-- <div class="w-1/2 justify-center flex">
                                <div class="relative">
                                    <img class="w-56 h-32 object-cover mt-4" alt="Western New England University"
                                        aria-label="Western New England University"
                                        src="
                                        {{ asset($ambassadorObject->school->image) }}
                                    " />
                                </div>
                            </div> --}}
                            <div class="w-1/2 justify-center flex flex-col items-center">
                                @if($titleText)
                                    <h4 class="text-center">
                                        {{ $titleText }}
                                    </h4>
                                @endif
                            
                                <div class="relative">
                                    <img class="w-56 h-32 object-cover mt-4" alt="Western New England University"
                                        aria-label="Western New England University"
                                        src="{{ asset($ambassadorObject?->school?->image) }}" />
                                </div>
                            </div>
                            <div class="w-1/2 flex justify-center">
                                <div class="py-4">
                                    <h4 class="block font-bold">Field of study:</h4>
                                    <h4>{{ $ambassadorObject->category }}</h4>
                                </div>

                            </div>
                        </div>
                        <div class="flex justify-center mb-4 w-full">
                            {{-- <a
                                href="{{ route('web.school.ambassador.chat', [getDefaultLanguage(1)['abbreviation'], $ambassadorObject->id]) }}
                               
                            "> --}}
                            <a
                                href="{{ route('web.school.ambassador.chat', [
                                    getDefaultLanguage(1)['abbreviation'],
                                    $ambassadorObject->id,
                                    $ambassadorObject->schoolAmbassadorDetail[0]->slug,
                                ]) }}">
                                <button
                                    class="text-primary border border-primary hover:bg-primary hover:text-white active:bg-red-600 font-medium px-4 py-1.5 rounded-full outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                    type="button">

                                    {{ isset($ambassadorTranslations['chat_button_text']) ? $ambassadorTranslations['chat_button_text'] : '' }}
                                    with
                                    {{ isset($ambassadorObject->schoolAmbassadorDetail[0]->name)
                                        ? $ambassadorObject->schoolAmbassadorDetail[0]->name
                                        : '' }}
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
           
                <div class="py-4 px-2">
                    @php $index = 0; @endphp
                
                    @foreach([
                        'i_came_from_label_text' => $ambassadorObject->region,
                        'province_label_text' => $ambassadorObject->province,
                        'city_label_text' => $ambassadorObject->city,
                        'i_speak_label_text' => $ambassadorObject->langs,
                        'study_here_label_text' => $ambassadorObject->I_study_here,
                        'degree_level_label_text' => $ambassadorObject->degree_level,
                        'fav_module_label_text' => $ambassadorObject->fav_module,
                        'my_major_label_text' => $ambassadorObject->my_major,
                        'category_label_text' => $ambassadorObject->category,
                        'my_minor_label_text' => $ambassadorObject->my_minor,
                        'hobby_and_interest_label_text' => $ambassadorObject->hobies_interests,
                        'societies_label_text' => $ambassadorObject->societies,
                    ] as $labelKey => $value)
                
                        @if(!empty($value))
                            <div class="flex items-center gap-4 p-2 {{ $index % 2 === 0 ? 'bg-white' : 'bg-red-50' }}">
                                <h4 class="w-40 mb-0 flex-none">
                                    {{ $ambassadorTranslations[$labelKey] ?? '' }}:
                                </h4>
                                <p class="mt-1 line-clamp-2">{{ $value }}</p>
                            </div>
                            @php $index++; @endphp
                        @endif
                
                    @endforeach
@if(isset($apps) && count($apps)>0)
                    <h3>
                        {{ $ambassadorTranslations['messaging_app_text'] ?? '' }}
                    </h3>
                
                    @foreach ($apps as $app)
                        @foreach ($app->messagingApp->messagingAppDetail as $messageApp)
                            @if ($messageApp->language_id == $language->id)
                                <div class="flex items-center gap-4 p-2 {{ $index % 2 === 0 ? 'bg-white' : 'bg-red-50' }}">
                                    <h4 class="w-40 mb-0 flex-none">{{ $messageApp->name }}:</h4>
                                    <p class="mt-1">{{ $app->username }}</p>
                                </div>
                                @php $index++; @endphp
                            @endif
                        @endforeach
                    @endforeach
                @endif
                    @if (!empty($ambassadorObject->schoolAmbassadorDetail[0]->about_me))
                        <div class="flex items-center gap-4 p-2 {{ $index % 2 === 0 ? 'bg-white' : 'bg-red-50' }}">
                            <h4 class="w-40 mb-0 flex-none">
                                {{ $ambassadorTranslations['about_me_label_text'] ?? '' }}:
                            </h4>
                            <p class="mt-1">{{ $ambassadorObject->schoolAmbassadorDetail[0]->about_me }}</p>
                        </div>
                    @endif
                </div>
                
            </div>
        </div>
    </div>
@endsection
