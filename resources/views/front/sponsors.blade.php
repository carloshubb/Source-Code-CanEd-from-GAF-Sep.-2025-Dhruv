@php
    $defaultLang = getDefaultLanguage(1);
    $sponsors = getSponsorListing($defaultLang);
@endphp
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="">
        <div class="flex flex-row w-full items-end gap-3 h-14">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">
                    {{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : 'Our sponsors' }}</h1>
            </div>
            <div class="relative -mb-5">
                <add-sponsor-button lang="{{ $defaultLang }}"></add-sponsor-button>
            </div>
        </div>
        <div class="mt-8">
            {{-- <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
                <img class="w-full h-full object-contain mx-auto"
                  src="{{ asset(largeImage($page->image)) }}" alt="">
            </div> --}}
            @if(!empty($page->image))
            <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
                        <img class="w-full h-full object-contain mx-auto"
                            src="{{ asset(largeImage($page->image)) }}" alt="">
                    </div>
            @endif
            @isset($page->pageDetail[0])
                <div class="text-black text-justify">
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

            <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-8 gap-x-4 my-6">
                @foreach ($sponsors as $sponsor)
                    <div class="border shadow w-64 md:w-full mx-auto flex flex-col">
                        <?php $image = isset($sponsor->sponsorImage->thumbnail_image) ? $sponsor->sponsorImage->thumbnail_image : ''; ?>
                        <div class="h-48 bg-white border flex-initial">
                            <img class="w-full object-contain h-full" src="{{ asset($image) }}" alt="">
                        </div>
                        <div class="flex-auto p-2">
                            <p>
                                {!! $sponsor->sponsorDetail[0]->short_description ?? '' !!}
                            </p>
                        </div>
                        <a href="{{ route('web.sponsor.detail', [$defaultLang['abbreviation'], $sponsor->id, $sponsor->sponsorDetail[0]->slug]) }}"
                            class="bg-primary hover:bg-secondaryRed text-white font-FuturaMdCnBT px-5 py-2 border border-primary hover:border-secondaryRed text-center focus:bg-primary active:bg-primary w-full flex-initial">
                            <p class="text-white truncate text-center">
                                {{ $sponsor->sponsorDetail[0]->title ?? '' }}
                            </p>
                        </a>
                    </div>
                @endforeach


            </div>

        </div>
        {!! $sponsors->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
    </div>

</div>
