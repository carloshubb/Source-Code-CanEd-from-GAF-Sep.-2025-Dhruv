@php
    $lang = $lang ?? getDefaultLanguage(1);
    $formatUrl = function($url) {
        if (!$url) return '#';
        if (preg_match('/^https?:\/\//i', $url)) {
            return $url;
        }
        if (preg_match('/^(www\.|[a-zA-Z0-9-]+\.[a-zA-Z]{2,})/i', $url)) {
            if (preg_match('/^www\./i', $url)) {
                return 'https://' . $url;
            }
            return 'https://' . (str_starts_with($url, '/') ? '' : '') . $url;
        }
        if (str_starts_with($url, '/')) {
            return $url;
        }
        return 'https://' . $url;
    };
@endphp
<div class="mt-14">
    @isset($widget, $widget->bannerDetail[0])
    <div class="md:h-48 lg:h-60 rounded-lg flex overflow-hidden my-10">
        <div style="background-image: url('{{ isset($widget->Image1) ? asset($widget->Image1->path) : asset('/media/banners/blue_banner_01.jpg') }};"
            class="bg-center bg-cover md:h-48 lg:h-60 flex items-center w-1/2">
            <div class="px-4 md:px-8 lg:px-16 space-y-1 md:space-y-3 py-1">
                <h2 class="text-lg md:text-xl lg:text-2xl font-FuturaMdCnBT text-white leading-5">
                    {!! $widget->bannerDetail[0]->title !!}
                </h2>
                <p class="text-white md:mb-4 mt-1 md:mt-2 line-clamp-2 text-xs md:text-base lg:text-lg">
                    {!! $widget->bannerDetail[0]->banner_description !!}
                </p>
                <button
                    class="bg-white px-6 text-sm md:text-base py-0.5 md:py-1 lg:py-1.5 text-primary font-FuturaMdCnBT rounded mt-3">
                    {{-- <a :href="{!! $widget->bannerDetail[0]->button_link !!}"> --}}
                        <a href="{{ $formatUrl($widget->banner_button_link) }}" target="_blank">
                        {!! $widget->bannerDetail[0]->banner_button_text !!}
                    </a>
                </button>
            </div>
        </div>

        <div class="relative w-1/2">
            <img src="{{ isset($widget->Image2) ? asset($widget->Image2->path) : '' }}"
                class="h-full md:h-48 lg:h-60 w-full object-cover" alt="" />
            <div
                class="absolute top-0 flex h-full {{ isset($lang->direction) && $lang->direction == 'rtl' ? 'right-0' : 'left-0' }}">
                <div class="flex space-x-3 h-full">
                    <span class="w-1 h-full bg-red-600 bg-opacity-70"></span>
                    <span class="w-1.5 h-full bg-red-600 bg-opacity-70"></span>
                    <span class="w-2 h-full bg-red-600 bg-opacity-70"></span>
                    <span class="w-2.5 h-full bg-red-600 bg-opacity-70"></span>
                </div>
                <span class="w-3 h-full bg-red-600 bg-opacity-70 ml-20"></span>
            </div>
        </div>
    </div>
    @endisset
</div>
