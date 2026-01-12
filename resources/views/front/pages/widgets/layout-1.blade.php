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
        <div class="flex rounded-md md:rounded-lg overflow-hidden">
            <div style="background-image: url('{{ isset($widget->Image1) ? asset($widget->Image1->path) : asset('/media/banners/blue_banner_02.jpg') }}');"
                class="bg-cover bg-no-repeat md:h-48 lg:h-60 w-1/2  flex items-center px-4 md:px-8 space-y-4  {{ isset($lang->direction) && $lang->direction == 'rtl' ? 'rounded-r-lg' : 'rounded-l-lg' }}">
                <div>
                    <p class="text-lg md:text-xl lg:text-2xl font-FuturaMdCnBT text-white leading-5">
                        {{ $widget->bannerDetail[0]['title'] }}
                    </p>
                    <p class="text-white md:mb-4 mt-1 md:mt-2 line-clamp-2 text-xs md:text-base lg:text-lg">
                        {{ $widget->bannerDetail[0]['banner_description'] }}
                    </p>
                    <button
                        class="bg-white px-4 md:px-6 text-sm md:text-base py-0.5 md:py-1 lg:py-1.5 text-primary font-FuturaMdCnBT rounded mt-1 md:mt-3">
                        {{-- <a :href="{!! $widget->banner_button_link !!}" target="_blank"> --}}
                            <a href="{{ $formatUrl($widget->banner_button_link) }}" target="_blank">
                            {!! $widget->bannerDetail[0]->banner_button_text !!}
                        </a>
                    </button>
                </div>
            </div>
            <div class="w-1/2">
                <img class="object-cover w-full  h-28 md:h-48 lg:h-60 {{ isset($lang->direction) && $lang->direction == 'rtl' ? 'rounded-l-lg' : 'rounded-r-lg' }}"
                    src="{{ isset($widget->Image2) ? asset($widget->Image2->path) : '' }}" alt="" />
            </div>
        </div>
    @endisset
</div>
