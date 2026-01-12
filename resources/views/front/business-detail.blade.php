@extends('front.layouts.app')
@section('content')
    @php
    $defaultLang = getDefaultLanguage(1);
        $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
        $indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';

        function getYoutubeID($url) {
    preg_match('/(?:youtu\.be\/|youtube\.com\/(?:.*v=|.*\/(?:shorts\/|embed\/|v\/|.*[?&]v=)))([^"&?\/\s]{11})/', $url, $matches);
    return $matches[1] ?? '';
}
    @endphp
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="">
            <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
                <div class="border-b-4 pb-2 border-primary w-full flex items-center justify-between">
                    <h1 class="can-edu-h1">
                        {{ isset($business->businessDetail[0]->business_name) ? $business->businessDetail[0]->business_name : '' }}
                    </h1>
                    <?php
                    $favToolTip = isset(getStaticTranslation('general')['add_to_favorites_text']) ? getStaticTranslation('general')['add_to_favorites_text'] : '';
                    ?>
                    <fav-icon record_id="{{ $business->id }}" model="business" is_favourit="{{ $favorite }}"
                        tooltiptext="{{ $favToolTip }}" />
                </div>
            </div>

            <div class="my-8">
                <p class="text-black break-words">
                    {!! isset($business->businessDetail[0]->description) ? $business->businessDetail[0]->description : '' !!}
                </p>
                {{-- <p class="text-black break-words">
                    {!! isset($business->businessDetail[0]->detail_description) ? $business->businessDetail[0]->detail_description : '' !!}
                </p> --}}

                

                <div class="my-4">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" role="tablist">
                        <li class="me-2" role="presentation">
                            <button class="inline-block bg-white border border-primary text-primary rounded px-5 py-2 text-lg font-FuturaMdCnBT text-center" id="profile-styled-tab" data-tabs-target="#styled-profile" type="button" role="tab" aria-controls="profile" aria-selected="true">Contact</button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button class="inline-block bg-white border border-primary text-primary rounded px-5 py-2 text-lg font-FuturaMdCnBT text-center" id="media-styled-tab" data-tabs-target="#styled-media" type="button" role="tab" aria-controls="media" aria-selected="false">Media</button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button class="inline-block bg-white border border-primary text-primary rounded px-5 py-2 text-lg font-FuturaMdCnBT text-center" id="dashboard-styled-tab" data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">Overview</button>
                        </li>
                    </ul>
                </div>
                <div id="default-styled-tab-content" class="mt-4">
                    <div class="p-4 rounded-lg bg-gray-100 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="order-2 md:order-1">
                                    <table class="border-spacing-y-1 border-separate border-none">
                                        <tbody>
                                            <!-- <tr class="mb-3 border-none">
                                                <td
                                                    class="text-primary mr-1 w-1/2 text-base md:text-base lg:text-lg border-none break-all align-top">
                                                    {{ isset($businessTranslations['business_category_heading']) ? $businessTranslations['business_category_heading'] : '' }}:
                                                </td>
                                                <td class="text-base md:text-base lg:text-lg border-none break-words align-top pl-3">
                                                    <p class="text-base md:text-base lg:text-lg break-words">
                                                        {{ isset($business->businessCategory1->businessCategoryDetail[0]->name) ? $business->businessCategory1->businessCategoryDetail[0]->name : '' }}
                                                    </p>
                                                    <p class="text-base md:text-base lg:text-lg break-words">
                                                        {{ isset($business->businessCategory2->businessCategoryDetail[0]->name) ? $business->businessCategory2->businessCategoryDetail[0]->name : '' }}
                                                    </p>
                                                    <p class="text-base md:text-base lg:text-lg break-words">
                                                        {{ isset($business->businessCategory3->businessCategoryDetail[0]->name) ? $business->businessCategory3->businessCategoryDetail[0]->name : '' }}
                                                    </p>
                                                </td>
                                            </tr> -->
                                            <tr class="py-3 border-none bg-gray-50">
                                                <td
                                                    class="text-primary mr-1 w-1/2 text-base md:text-base lg:text-lg border-none break-all align-top">
                                                    {{ isset($businessTranslations['contact_person_heading']) ? $businessTranslations['contact_person_heading'] : '' }}:
                                                </td>
                                                <td class="text-base md:text-base lg:text-lg border-none break-words align-top pl-3">
                                                    {{ isset($business->contact_name) ? $business->contact_name : '' }}
                                                </td>
                                            </tr>
                                            <tr class="py-3 border-none bg-gray-100">
                                                <td
                                                    class="text-primary mr-1 w-1/2 text-base md:text-base lg:text-lg border-none break-all align-top">
                                                    {{ isset($businessTranslations['email_heading']) ? $businessTranslations['email_heading'] : '' }}:
                                                </td>
                                                <td class="text-base md:text-base lg:text-lg border-none break-words align-top pl-3">
                                                    {{ isset($business->email) ? $business->email : '' }}
                                                </td>
                                            </tr>
                                            <tr class="py-3 border-none bg-gray-50">
                                                <td
                                                    class="text-primary mr-1 w-1/2 text-base md:text-base lg:text-lg border-none break-all align-top">
                                                    {{ isset($businessTranslations['phone_heading']) ? $businessTranslations['phone_heading'] : '' }}:
                                                </td>
                                                <td class="text-base md:text-base lg:text-lg border-none break-words align-top pl-3">
                                                    {{ isset($business->phone) ? $business->phone : '' }}
                                                </td>
                                            </tr>
                                            <tr class="py-3 border-none bg-gray-100">
                                                <td
                                                    class="text-primary mr-1 w-1/2 text-base md:text-base lg:text-lg border-none break-all align-top">
                                                    {{ isset($businessTranslations['address_heading']) ? $businessTranslations['address_heading'] : '' }}:
                                                </td>
                                                <td class="text-base md:text-base lg:text-lg border-none break-words align-top pl-3">
                                                    {{ isset($business->address) ? $business->address : '' }}
                                                </td>
                                            </tr>
                                            <tr class="mb-3 border-none"></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="order-1 md:order-2">
                                    @php
                                        $images = explode(',', $business->image);
                                    @endphp
                                    <div class="bg-gray-50 h-60 md:h-80 w-full border rounded">
                                        <swiper-container class="mySwiper" navigation="true">
                                            {{-- Show Video First If Available --}}
                                            @if (!empty($business->welcome_video))
                                                <swiper-slide>
                                                    <iframe class="h-full w-full" 
                                                        src="https://www.youtube.com/embed/{{ getYoutubeID($business->welcome_video) }}" 
                                                        frameborder="0" 
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                        allowfullscreen>
                                                    </iframe>
                                                </swiper-slide>
                                            @endif
                                
                                            {{-- Show Images After the Video --}}
                                            @foreach ($images as $image)
                                            @php
                                                $imgSrc1 = filter_var(trim($image), FILTER_VALIDATE_URL) ? trim($image) : asset(trim($image));
                                            @endphp
                                                <swiper-slide>
                                                    <img class="h-full w-full mx-auto bg-white object-contain cursor-pointer"
                                                        src="{{ $imgSrc1 }}" 
                                                        alt="" 
                                                        onclick="openModal('{{ $imgSrc1 }}')" />
                                                </swiper-slide>
                                            @endforeach
                                        </swiper-container>
                                    </div>
                                </div>
                                
                                <!-- Modal for Fullscreen Image -->
                                <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 hidden flex items-center justify-center z-50" onclick="closeModalOnBackgroundClick(event)">
                                    <div class="relative max-w-4xl w-full p-4">
                                        <button class="absolute top-4 right-4 bg-white p-1 flex items-center justify-center rounded-full w-7 h-7 text-primary font-bold border border-primary" onclick="closeModal()">✕</button>
                                        <img id="modalImage" class="w-full h-auto max-h-screen object-contain rounded-lg" src="" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row justify-between items-center border-t px-4 mt-3 py-2 gap-6">

                                <div class="flex flex-col sm:flex-row md:flex-row lg:flex-row items-center gap-4 my-2">
                                    @php
                                        function formatUrl($url) {
                                            return filter_var($url, FILTER_VALIDATE_URL) ? $url : 'https://' . ltrim($url, '/');
                                        }
                                    @endphp
                                    {{-- <div class="flex items-center gap-4 my-2">
                                        @if (isset($business->facebook_url))
                                            <a aria-label="Candian Exporters" target="_blank"
                                                href="{{ isset($business->facebook_url) ? formatUrl($business->facebook_url) : '#' }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10">
                                                <img class="h-4 md:h-5" src="{{ asset('/assets/social-icons/facebook.png') }}"
                                                    alt="facebook icon">
                                            </a>
                                        @endif
                                        @if (isset($business->twitter_url))
                                            <a aria-label="Candian Exporters" target="_blank"
                                                href="{{ isset($business->twitter_url) ? formatUrl($business->twitter_url) : '#' }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10">
                                                <img class="h-3 md:h-4" src="{{ asset('/assets/social-icons/twitter.png') }}"
                                                    alt="twitter icon">
                                            </a>
                                        @endif
                                        @if (isset($business->linked_url))
                                            <a aria-label="Candian Exporters" target="_blank"
                                                href="{{ isset($business->linked_url) ? formatUrl($business->linked_url) : '#' }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10">
                                                <img class="h-3 md:h-5" src="{{ asset('/assets/social-icons/linkedin.png') }}"
                                                    alt="linkedin icon">
                                            </a>
                                        @endif
                                        @if (isset($business->youtube_url))
                                            <a aria-label="Candian Exporters" target="_blank"
                                                href="{{ isset($business->youtube_url) ? formatUrl($business->youtube_url) : '#' }}"
                                                class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10">
                                                <img class="h-3 md:h-4" src="{{ asset('/assets/social-icons/youtube.png') }}"
                                                    alt="youtube icon">
                                            </a>
                                        @endif
                                    </div> --}}
                                
                                    @if (!empty($business->facebook_url) || !empty($business->twitter_url) || !empty($business->linked_url) || !empty($business->youtube_url) || !empty($business->other_social_url))
                                        <div class="flex items-center gap-4 my-2">
                                            <span class="font-semibold">
                                                {{ $business->businessDetail[0]->business_name ?? '' }}  {{ isset($businessTranslations['company_name_text']) ? $businessTranslations['company_name_text'] : '' }}:
                                            </span>
                                            @if (!empty($business->facebook_url))
                                                <a aria-label="Canadian Exporters" target="_blank"
                                                    href="{{ formatUrl($business->facebook_url) }}"
                                                    class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10">
                                                    <img class="h-4 md:h-5" src="{{ asset('/assets/social-icons/facebook.png') }}" alt="facebook icon">
                                                </a>
                                            @endif
                                            @if (!empty($business->twitter_url))
                                                <a aria-label="Canadian Exporters" target="_blank"
                                                    href="{{ formatUrl($business->twitter_url) }}"
                                                    class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10">
                                                    <img class="h-3 md:h-4" src="{{ asset('/assets/social-icons/twitter.png') }}" alt="twitter icon">
                                                </a>
                                            @endif
                                            @if (!empty($business->linked_url))
                                                <a aria-label="Canadian Exporters" target="_blank"
                                                    href="{{ formatUrl($business->linked_url) }}"
                                                    class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10">
                                                    <img class="h-3 md:h-5" src="{{ asset('/assets/social-icons/linkedin.png') }}" alt="linkedin icon">
                                                </a>
                                            @endif
                                            @if (!empty($business->youtube_url))
                                                <a aria-label="Canadian Exporters" target="_blank"
                                                    href="{{ formatUrl($business->youtube_url) }}"
                                                    class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10">
                                                    <img class="h-3 md:h-4" src="{{ asset('/assets/social-icons/youtube.png') }}" alt="youtube icon">
                                                </a>
                                            @endif
                                            @if (!empty($business->other_social_url))
                                                <a aria-label="Canadian Exporters" target="_blank"
                                                    href="{{ formatUrl($business->other_social_url) }}"
                                                    class="flex justify-center items-center bg-gray-50 border-2 border-gray-300 hover:border-primary rounded-full">
                                                    {{ $business->other_social_url }}
                                                </a>
                                            @endif
                                        </div>
                                    @endif

                                </div>
                                <div class="flex items-center space-x-4">
                                <contact-business indicate_required_field="{{ $indicateRequiredField }}"
                                    business_contact_translations="{{ $businessContactTranslations }}" position="{{ $position }}"
                                    business_id="{{ $business->id }}" business_name="{{ $business->businessDetail[0]->business_name ?? '' }}">
                                </contact-business>
                                {{-- <button class="can-edu-btn-fill">Visit our website</button> --}}
                                @if (isset($business->website_url))
                                    <a class="can-edu-btn-no-fill" aria-label="Candian Education" href="{{ formatUrl($business->website_url) }}" target="_blank">
                                        {{-- <button aria-label="Candian Education" class="can-edu-btn-no-fill"> Visit our website </button> --}}
                                        Visit our website
                                    </a>
                                @endif
                                </div>
                            </div>
                        </div>
                </div>
               
                <div class="hidden p-4 rounded-lg bg-gray-100 dark:bg-gray-800" id="styled-media" role="tabpanel" aria-labelledby="media-tab">
                    <div class="mb-6">
                        <h2 class="text-2xl text-black">
                            {{ $business->businessDetail[0]->media_section_title ?? 'No Title Available' }}
                        </h2>
                        <p class="text-lg text-black mt-1">
                            {{ $business->businessDetail[0]->media_section_description ?? 'No Description Available' }}
                        </p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach ($images as $image)
                        @php
                            $img = filter_var(trim($image), FILTER_VALIDATE_URL) ? trim($image) : asset(trim($image));
                        @endphp
                            <div class="bg-gray-50 rounded border overflow-hidden p-4">
                                <img class="h-48 w-full mx-auto bg-white object-contain cursor-pointer rounded-lg" 
                                    src="{{ $img }}" alt="" />
                            </div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-gray-50 rounded border overflow-hidden p-4">
                        @php

                            $logo = filter_var(trim($business->logo), FILTER_VALIDATE_URL) ? trim($business->logo) : asset(trim($business->logo));
                        @endphp
                            <img class="h-48 w-full mx-auto bg-white object-contain cursor-pointer rounded-lg" 
                                src="{{ $logo }}" alt="" />
                        </div>
                    </div>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-100 dark:bg-gray-800" id="styled-dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                    <div class="">
                            <p class="text-black break-words">
                                {!! isset($business->businessDetail[0]->detail_description) ? $business->businessDetail[0]->detail_description : '' !!}
                            </p>
                            {{-- <p class="text-black break-words">
                                {!! isset($business->businessDetail[0]->media_section_description) ? $business->businessDetail[0]->media_section_description : '' !!}
                            </p>   --}}
                        </div>
                </div>

                <div class="mt-10">
                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
                        <div class="border-b-4 pb-2 pt-1 border-primary w-full flex items-center justify-between">
                            <h2 class="can-edu-h2 mb-0">
                                {{ isset($businessTranslations['related_business_heading']) ? $businessTranslations['related_business_heading'] : '' }}
                            </h2>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        @foreach ($businesses as $business)
                            <div class="mt-4">
                                <?php $slug = isset($business->businessDetail[0]->slug) ? $business->businessDetail[0]->slug : ''; ?>
                                <a
                                    href="{{ url('/' . $defaultLang['abbreviation'] . '/business/' . $business->id . '/' . $slug) }}">
                                    <div class="border rounded overflow-hidden">
                                    @php
                                        $imgSrc = filter_var(trim($business->image), FILTER_VALIDATE_URL) ? trim($business->image) : asset(thumbnailImage(trim($business->image)));
                                    @endphp
                                        <div class="h-48 border-b bg-white"> <img class="w-full object-contain h-full"
                                                src="{{ $imgSrc }}" alt="">
                                        </div>
                                        <div class="p-4">
                                            <h5 class="text-black font-bold text-center">
                                                {{ isset($business->businessDetail[0]->business_name) ? $business->businessDetail[0]->business_name : '' }}
                                            </h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                </div>


                
            </div>

            
        </div>
    </div>
    @section('scripts')
    <script>
        function openModal(imageSrc) {
            document.getElementById("modalImage").src = imageSrc;
            const modal = document.getElementById("imageModal");

            // Remove hidden class and apply slide-in animation
            modal.classList.remove("hidden");
            modal.classList.add("slide-in");
        }

        function closeModal() {
            const modal = document.getElementById("imageModal");

            // Add slide-out animation before hiding the modal
            modal.classList.remove("slide-in");
            modal.classList.add("slide-out");

            // After animation completes (0.3s), hide the modal
            setTimeout(() => {
                modal.classList.add("hidden");
                modal.classList.remove("slide-out");
            }, 300); // match the animation duration
        }

        // Function to close modal when background is clicked
        function closeModalOnBackgroundClick(event) {
            // Check if the click was on the background (not the content)
            if (event.target === document.getElementById("imageModal")) {
                closeModal();
            }
        }

        // Select all tab buttons
        const tabs = document.querySelectorAll('[role="tab"]');
        // Select all tab content panels
        const tabContents = document.querySelectorAll('[role="tabpanel"]');

        // Add event listener to each tab button
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active classes from all tabs and content panels
                tabs.forEach(t => {
                    t.setAttribute('aria-selected', 'false');
                    t.classList.remove('bg-primary', 'text-white');
                    t.classList.add('bg-white', 'text-primary');
                });
                tabContents.forEach(content => content.classList.add('hidden'));

                // Add active class to the clicked tab and its content panel
                tab.setAttribute('aria-selected', 'true');
                tab.classList.add('bg-primary', 'text-white');
                tab.classList.remove('bg-white', 'text-primary');
                const targetContent = document.querySelector(tab.getAttribute('data-tabs-target'));
                targetContent.classList.remove('hidden');
            });
        });

        // Ensure the first tab is active on page load
        document.querySelector('[aria-selected="true"]')?.click();
    </script>
@endsection
@endsection
