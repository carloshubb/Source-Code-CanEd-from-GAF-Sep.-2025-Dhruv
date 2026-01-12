<?php
$defaultLang = getDefaultLanguage(1);
$business_directory = App\Models\BusDirectorySetting::with([
    'busDirectorySettingDetail' => function ($q) use ($defaultLang) {
        $q->where('language_id', $defaultLang->id);
    },
])->first();

$industries = App\Models\BusinessDirectory::groupBy('industry')->pluck('industry');
?>
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                {{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : '' }}</h1>
        </div>

    </div>
    @if (!empty($page->image))
        <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
            <img class="w-full h-full object-contain mx-auto"
                src="{{ asset(largeImage($page->image)) }}" alt="">
        </div>
    @endif
    @isset($page->pageDetail[0])
    <div class="can-edu-p mt-2">
        <div class="">
            @php
                $page_detail = $page->pageDetail[0]->description;
            @endphp
            @include('front.pages.widgets.render-widget-with-detail', [
                'page_detail' => $page_detail,
            ])
        </div>
    </div>
    @endisset
    <business-directory lang="{{$defaultLang['abbreviation']}}" position="{{$defaultLang['position']}}" industs="{{ $industries }}"
    business_directory_settings="{{ $business_directory }}"></business-directory>
    {{-- <form action="{{ url('/' . $defaultLang['abbreviation'] . '/search/business-directory') }}" method="GET">
        <div class="w-full  mx-auto mt-10">
            <div class="grid grid-cols-5">
                <div class="ml-2">
                    <input type="text" name="keyword"
                        placeholder="{{ isset($business_directory->busDirectorySettingDetail[0]->company_name_placeholder) ? $business_directory->busDirectorySettingDetail[0]->company_name_placeholder : '' }}"
                        class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                </div>
                <div class="ml-2">
                    <input type="text" name="city"
                        placeholder="{{ isset($business_directory->busDirectorySettingDetail[0]->city_placeholder) ? $business_directory->busDirectorySettingDetail[0]->city_placeholder : '' }}"
                        class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300

                        {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}

                        ">
                </div>
                <div class="ml-2">
                    <input type="text" name="province"
                        placeholder="{{ isset($business_directory->busDirectorySettingDetail[0]->province_placeholder) ? $business_directory->busDirectorySettingDetail[0]->province_placeholder : '' }}"
                        class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300

                        {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}

                        " />
                </div>
                <div class="ml-2">
                    <select
                        class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}"
                        multiple name="industry">
                        <option value="">
                            {{ isset($business_directory->busDirectorySettingDetail[0]->industry_placeholder) ? $business_directory->busDirectorySettingDetail[0]->industry_placeholder : '' }}
                        </option>
                        @foreach ($industries as $item)
                            <option value="{{ $item }}">
                                {{ $item }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="ml-2">
                    <button type="submit" class="can-edu-btn-fill">
                        {{ isset($business_directory->busDirectorySettingDetail[0]->button_text) ? $business_directory->busDirectorySettingDetail[0]->button_text : '' }}
                    </button>
                </div>
            </div>
        </div>
    </form> --}}


</div>
