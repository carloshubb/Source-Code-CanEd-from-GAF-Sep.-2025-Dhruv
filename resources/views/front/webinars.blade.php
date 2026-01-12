<?php
$defaultLang = getDefaultLanguage(1);
$past_webinar_title = getStaticTranslation('webinar_page')['past_but_still_usefull'];
$upcoming_webinars_title = getStaticTranslation('webinar_page')['upcoming_webinars_title'];
$upcomingWebinars = $pastWebinars = [];
$webinars = App\Models\Webinar::orderBy('id', 'desc')->get();
if (count($webinars) > 0) {
    foreach ($webinars as $webinar) {
        $liveStromWebinar = json_decode($webinar->live_strom_webinar, true);
        if (isset($liveStromWebinar['data']['attributes'])) {
            $dateTime = new DateTime($webinar->start_date);
            $formattedDate = $dateTime->format('Y-m-d');
            $formattedTime = $dateTime->format('H:i:s');
            if ($formattedDate >= \Carbon\Carbon::now()->format('Y-m-d') && $formattedTime >= \Carbon\Carbon::now()->format('H:i:s')) {
                array_push($upcomingWebinars, $webinar);
            } elseif ($formattedDate <= \Carbon\Carbon::now()->format('Y-m-d') && $formattedTime <= \Carbon\Carbon::now()->format('H:i:s')) {
                if ($liveStromWebinar['data']['attributes']['recording_enabled'] == 1) {
                    array_push($pastWebinars, $webinar);
                }
            }
        }
    }
}
?>
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-end h-14 gap-3">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">{{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : '' }}
            </h1>
        </div>
        <div class="mt-10 flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
            <a href="{{ route("web.account.webinar.create",['lang' => $defaultLang['abbreviation']]) }}" class="can-edu-btn-fill" style="cursor: pointer">
                Add Your Own Webinar
            </a>
            {{-- @endif --}}
        </div>
    </div>
    @if (!empty($page->image))
        <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
            <img class="w-full h-full object-contain mx-auto"
                src="{{ asset(largeImage($page->image)) }}" alt="webinar">
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


    <div class="mt-6 md:mt-10">
        @if (count($upcomingWebinars) > 0)
            <h3>{{$upcoming_webinars_title}}</h3>
            <div class="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($upcomingWebinars as $webinar)
                {{-- {{ dd($upcomingWebinars) }} --}}
                    <a href="{{ url('/' . $defaultLang['abbreviation'] . '/webinar/' . $webinar->id) }}"
                        class="h-full">
                        <div class="border shadow h-full bg-primary">
                            <div class="h-48 border bg-white"> <img class="w-full object-contain h-full"
                                    src="{{ asset(thumbnailImage($webinar->image)) }}" alt=""></div>
                            <div class="whitespace-normal leading-5 can-edu-btn-fill w-full rounded-none">
                                <p class="text-white leading-5 break-words text-center">
                                    {{ isset($webinar->title) ? $webinar->title : '' }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
        @if (count($pastWebinars) > 0)
            <br /><br />
            <h3>{{$past_webinar_title}} </h3>
            <div class="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($pastWebinars as $webinar)
                    <a href="{{ url('/' . $defaultLang['abbreviation'] . '/webinar/' . $webinar->id) }}"
                        class="h-full">
                        <div class="border shadow h-full bg-primary">
                            <div class="h-48 border bg-white"> <img class="w-full object-contain h-full"
                                    src="{{ asset(thumbnailImage($webinar->image)) }}" alt=""></div>
                            <div class="whitespace-normal leading-5 can-edu-btn-fill w-full rounded-none">
                                <p class="text-white leading-5 break-words text-center">
                                    {{ isset($webinar->title) ? $webinar->title : '' }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

</div>
