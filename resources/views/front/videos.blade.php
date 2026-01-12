@php
    $defaultLang = getDefaultLanguage(1);
    $videos = App\Models\Video::with([
        'videoDetail' => function ($q) use ($defaultLang) {
            $q = $q->where('language_id', $defaultLang->id);
        },
    ])->get();
    $logged_in_user_type = isset($data['logged_in_user_type']) ? $data['logged_in_user_type'] : '';
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user() : '';
    $slug = isset(Auth::guard('customers')->user()->slug) ? Auth::guard('customers')->user()->slug : '';
    $is_package_amount_paid = isset($loggedInCustomer->package_price) ? $loggedInCustomer->package_price : '0';
@endphp
@php
    $defaultLang = getDefaultLanguage(1);
    $videos = App\Models\Video::with([
        'videoDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
    ])
    ->where('status', 'yes')
    ->get();

    $logged_in_user_type = isset($data['logged_in_user_type']) ? $data['logged_in_user_type'] : '';
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user() : '';
    $is_package_amount_paid = isset($loggedInCustomer->package_price) ? $loggedInCustomer->package_price : '0';
@endphp

<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="flex flex-row w-full items-end gap-3 h-14 mb-8">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">{{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : 'Videos' }}</h1>
        </div>
        <add-video lang="{{ $defaultLang['abbreviation'] }}" slug="{{ $slug }}" logged_in_user_type="{{ $logged_in_user_type }}"
            is_package_amount_paid="{{ $is_package_amount_paid }}"></add-video>
    </div>
    @if (!empty($page->image))
        <div class="mt-8 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
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

    <div class="mt-10">
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
            @foreach ($videos as $video)
                <div>
                    <div class="border shadow w-auto mx-auto">
                        <div>
                            {{-- <iframe width="560" height="315"
                                src="https://www.youtube.com/embed/uW4M3Sxxv6U?si=sAyRlY5-QWDxhyl9"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe> --}}

                            @php
                                $youtubeUrl = $video->link;
                                parse_str(parse_url($youtubeUrl, PHP_URL_QUERY), $query);
                                $videoId = $query['v'] ?? '';
                            @endphp
                            <div class="relative w-full h-64 lg:h-80 cursor-pointer video-thumbnail" 
                              onclick="this.innerHTML='<iframe class=\'w-full h-full\' src=\'https://www.youtube.com/embed/{{ $videoId }}?autoplay=1\' allowfullscreen></iframe>'">
                                <img src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" alt="Video Thumbnail" class="w-full h-full object-cover">
                                <div class="absolute inset-0 flex items-center justify-center bg-black/40">
                                  <div class="text-white text-3xl bg-[#f00] hover:bg-red-700 rounded-md px-6 py-2">▶</div>
                                </div>
                            </div>
                        
                            {{-- <iframe class="h-64 lg:h-80" width="100%" height="100%" src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=0&amp;controls=0&amp;showinfo=0&amp;rel=0&amp;loop=0&amp;modestbranding=1&amp;wmode=transparent"></iframe> --}}
                        </div>
                        <div
                            class="text-center py-2 text-lg font-FuturaMdCnBT text-white w-full bg-primary">
                            <p class="text-center">{{ isset($video->videoDetail[0]->title) ? $video->videoDetail[0]->title : '' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
