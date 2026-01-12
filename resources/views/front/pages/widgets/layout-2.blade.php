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
<div class="my-5 md:my-7">
    @isset($widget, $widget->bannerDetail[0])
    <div class="h-24 md:h-48 lg:h-60 w-full bg-primary flex items-center relative rounded-lg">
        <div class="h-24 md:h-48 lg:h-60  w-[58%] bg-red-600 absolute left-0 rounded-l-lg object-fill {{ isset($lang->direction) && $lang->direction == 'ltr' ? 'order-1' : 'order-2' }}" style="clip-path: polygon(0 0, 75% 0%, 100% 100%, 0% 100%);">
            <img class="rounded-l-lg object-fill w-full h-full" src="{{ isset($widget->Image1) ? asset($widget->Image1->path) : asset('/media/banners/blue_banner_02.jpg') }}" alt="">
        </div>
        <div class="h-24 md:h-48 lg:h-60 w-[57%] bg-green-600 absolute right-0 rounded-r-lg" style="clip-path: polygon(0 0, 100% 0, 100% 100%, 24% 100%);">
            <img class="absolute top-0 rounded-r-lg object-fill w-full h-full" src="{{ isset($widget->Image2) ? asset($widget->Image2->path) : '' }}" alt="">
            <div class="relative z-10 flex items-center justify-center h-full w-full">
                <div class="md:w-[60%] pl-10 md:pl-8 pr-4 md:pr-8 {{ isset($lang->direction) && $lang->direction == 'ltr' ? 'order-2' : 'order-1' }}">
                    <p class="text-lg md:text-xl lg:text-2xl font-FuturaMdCnBT text-white leading-5">
                        {!! $widget->bannerDetail[0]->title !!}
                    </p>
                    <p class="text-white md:mb-4 mt-1 md:mt-2 line-clamp-2 text-xs md:text-base lg:text-lg">
                        {!! $widget->bannerDetail[0]->banner_description !!}
                    </p>
                    <button
                        class="bg-white px-2 md:px-6 text-sm md:text-base py-0.5 md:py-1 lg:py-1.5 text-primary font-FuturaMdCnBT rounded mt-1 md:mt-3">
                        {{-- <a href="{!! $widget->bannerDetail[0]->button_link !!}" target="_blank"> --}}
                            <a href="{{ $formatUrl($widget->banner_button_link) }}" target="_blank">
                            {!! $widget->bannerDetail[0]->banner_button_text !!}
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endisset
</div>