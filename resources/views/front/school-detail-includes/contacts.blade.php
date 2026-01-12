@isset($school->schoolContactSetting)
    <div class="mt-10">
        <p class="text-black">
            {!! isset($school->schoolContactSetting->top_page_text)
                ? $school->schoolContactSetting->top_page_text
                : '' !!}
        </p>
    </div>
@endisset
@isset($school->schoolContactSetting)
@if(file_exists(asset($school->schoolContactSetting->top_photo)))
    <div class="mt-10">
      <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
        <img class="w-full h-full object-contain mx-auto"
        src="{{ asset($school->schoolContactSetting->top_photo) }}" 
        alt="School Image">
      </div>
    </div>
@endif
@endisset
@isset($school->schoolContactSetting->schoolContactSettingDetail[0])
    <div class="mt-10">
        <p class="text-black">
            {!! isset($school->schoolContactSetting->schoolContactSettingDetail[0]->main_paragraph)
                ? $school->schoolContactSetting->schoolContactSettingDetail[0]->main_paragraph
                : '' !!}
        </p>
    </div>
@endisset

@if (isset($school->schoolContacts) && count($school->schoolContacts) > 0)
    <div class="my-10 bg-gray-100 border rouned">
        <div class="p-4 border-b border-gray-300 bg-gray-200">
        <h2 class="can-edu-h2 capitalize mb-0">Contact
            {{ isset($school->schoolDetail[0]->school_name) ? $school->schoolDetail[0]->school_name : '' }}</h2>
        </div>
        <div class="">
            @foreach ($school->schoolContacts as $schoolContact)
                {{-- <div class="contact_card_bg border-b rounded p-4 w-full">
                    <h6 class="font-Roboto text-lg font-semibold">
                        {{ isset($schoolContact->schoolContactDetail[0]->name) ? $schoolContact->schoolContactDetail[0]->name : '' }}
                    </h6>
                    <p class="text-black text-base">
                        {{ isset($schoolContact->department) ? $schoolContact->department : '' }}
                    </p>
                    <p class="text-black text-base">
                        {{ isset($schoolContact->address) ? $schoolContact->address : '' }}
                    </p>
                    <p class="text-black text-base">
                        {{ isset($schoolContact->city) ? $schoolContact->city : '' }}
                    </p>
                    <p class="text-black text-base">
                        {{ isset($schoolContact->country) ? $schoolContact->country : '' }}
                    </p>
                    <p class="text-black text-base">Tel: <span>{{ isset($schoolContact->phone) ? $schoolContact->phone : '' }}</span></p>
                    <p class="text-black text-base">Fax: <span>{{ isset($schoolContact->fax) ? $schoolContact->fax : '' }}</span></p>
                    <p class="text-black text-base">Website: <a href="{{ isset($schoolContact->website_link) ? $schoolContact->website_link : '' }}"
                        target="_blank" class="font-medium text-primary">
                        {{ isset($schoolContact->website_link) ? $schoolContact->website_link : '' }}
                        </a>
                    </p>
                </div> --}}
                <div class="contact_card_bg border-b rounded p-4 w-full flex items-start gap-6">
                    <!-- Left side: Contact details -->
                    <div class="w-2/3">
                        <h6 class="font-Roboto text-lg font-semibold">
                            {{ $schoolContact->schoolContactDetail[0]->name ?? '' }}
                        </h6>
                        {{-- <p class="text-black text-base">Brief description: <span>{{ $schoolContact->schoolContactDetail[0]->brief_descr ?? '' }}</span></p> --}}
                        <p class="text-black text-base"><span>{{ $schoolContact->schoolContactDetail[0]->brief_descr ?? '' }}</span></p>
                        <p class="text-black text-base">Department: <span>{{ $schoolContact->department ?? '' }}</span></p>
                        <p class="text-black text-base">Address: <span>{{ $schoolContact->address ?? '' }}</span></p>
                        <p class="text-black text-base">City: {{ $schoolContact->city ?? '' }}</p>
                        <p class="text-black text-base">Country: <span>{{ $schoolContact->country ?? '' }}</span></p>
                        <p class="text-black text-base">Tel: <span>{{ $schoolContact->phone ?? '' }}</span></p>
                        {{-- <p class="text-black text-base">Fax: <span>{{ $schoolContact->fax ?? '' }}</span></p> --}}
                        @if(!empty($schoolContact->fax))
                            <p class="text-black text-base">Fax: <span>{{ $schoolContact->fax }}</span></p>
                        @endif
                        <p class="text-black text-base">Direct email: <span>{{ $schoolContact->direct_email ?? '' }}</span></p>
                        <p class="text-black text-base">
                            Website: 
                            <a href="{{ $schoolContact->website_link ?? '#' }}" 
                               target="_blank" class="font-medium text-primary">
                               {{ $schoolContact->website_link ?? '' }}
                            </a>
                        </p>
                        @php
                        $socialLinks = [
                            'contact_facebook' => '/assets/social-icons/facebook.png',
                            'contact_instagram' => '/assets/social-icons/instagaram.png',
                            'contact_linkedin' => '/assets/social-icons/linkedin.png',
                        ];
                    @endphp
                    
                    @if($schoolContact->contact_facebook || $schoolContact->contact_instagram || $schoolContact->contact_linkedin)
                        <p class="text-black text-base flex items-center space-x-3">
                            Here are my social media profiles: 
                            @foreach($socialLinks as $key => $icon)
                                @if(!empty($schoolContact->$key))
                                    <a href="{{ $schoolContact->$key }}" target="_blank" class="ml-3">
                                        <img class="h-4" src="{{ asset($icon) }}" alt="">
                                    </a>
                                @endif
                            @endforeach
                        </p>
                    @endif

                    </div>
                
                    <!-- Right side: Image -->
                    <div class="w-1/3 flex justify-end">
                        @if (!empty($schoolContact->image))
                        <img class="w-32 h-32 object-cover rounded-lg shadow-lg" 
                             src="{{ asset($schoolContact->image) }}" 
                             alt="">
                    @endif
                    
                    </div>
                </div>
                
            @endforeach
    

        </div>
   

    </div>
   
@endif


{{-- <div class="flex justify-center space-x-4 mt-4 mb-4">
    <h2 class="text-lg font-semibold text-gray-800 mb-2">Here are my social media profiles:</h2>
    @if(isset($school->schoolContactSetting->contact_settings_facebook))
        <a href="{{ formatUrl($school->schoolContactSetting->contact_settings_facebook) }}" target="_blank">
            <div class="bg-white border rounded-full w-10 h-10 flex items-center justify-center hover:border-primary">
                <img class="h-5" src="{{ asset('/assets/social-icons/facebook.png') }}" alt="Facebook">
            </div>
        </a>
    @endif

    @if(isset($school->schoolContactSetting->contact_settings_instagram))
        <a href="{{ formatUrl($school->schoolContactSetting->contact_settings_instagram) }}" target="_blank">
            <div class="bg-white border rounded-full w-10 h-10 flex items-center justify-center hover:border-primary">
                <img class="h-5" src="{{ asset('/assets/social-icons/instagaram.png') }}" alt="Instagram">
            </div>
        </a>
    @endif

    @if(isset($school->schoolContactSetting->contact_settings_linkedin))
        <a href="{{ formatUrl($school->schoolContactSetting->contact_settings_linkedin) }}" target="_blank">
            <div class="bg-white border rounded-full w-10 h-10 flex items-center justify-center hover:border-primary">
                <img class="h-5" src="{{ asset('/assets/social-icons/linkedin.png') }}" alt="LinkedIn">
            </div>
        </a>
    @endif
</div> --}}

{{-- @isset($school->schoolContactSetting)
<div class="text-center mt-10">
    <a href="{{ $school->schoolContactSetting->school_contact_apply_button_link ?: '#' }}" 
       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
       target="_blank">
        {{ $school->schoolContactSetting->school_contact_apply_button_title ?: 'Apply Now' }}
    </a>
</div>
@endisset --}}
@isset($school->schoolContactSetting)
    <div class="row justify-content-center mb-5 mt-10">
        <div class="w-full md:w-1/2 mx-auto flex text-center">
            <a href="{{ $school->schoolContactSetting->school_contact_apply_button_link ?: '#' }}" 
                target="_blank" 
                class="canedu_btn w-full py-4">
                {{ $school->schoolContactSetting->school_contact_apply_button_title ?: 'Apply Now' }}
            </a>
        </div>
    </div>
@endisset

<div class="w-full my-6">
    <div class="col-12">
        <div class="grid grid-cols-12 canedu_btn rounded p-0 w-full mx-auto">
            <div style="max-width: 0.333333%;"></div>

            <!-- First Link for Sub Title -->
            <a href="{{ isset($school->schoolContactSetting->school_contact_blue_bar_button_link) ? formatUrl($school->schoolContactSetting->school_contact_blue_bar_button_link) : '' }}" 
                target="_blank" 
                class="col-span-4 py-5 bg-[#01468f] rounded-0 text-white font-medium text-center">
                <p class="font-FuturaMdCnBT text-center text-xl text-white">
                    {{ isset($school->schoolContactSetting->school_contact_blue_bar_button_title) ? $school->schoolContactSetting->school_contact_blue_bar_button_title : 'Good to go?' }}
                </p>
            </a>

            <!-- Second Link for Main Title -->
            <a href="{{ isset($school->schoolContactSetting->school_contact_red_bar_button_link) ? formatUrl ($school->schoolContactSetting->school_contact_red_bar_button_link) : '' }}" 
                target="_blank" 
                class="col-span-7 py-5 text-white font-medium text-center">
                <p class="font-FuturaMdCnBT text-center text-white  text-xl">
                    {{ isset($school->schoolContactSetting->school_contact_red_bar_button_title) ? $school->schoolContactSetting->school_contact_red_bar_button_title : 'Let’s apply' }}
                </p>
            </a>
        </div>
    </div>
</div>