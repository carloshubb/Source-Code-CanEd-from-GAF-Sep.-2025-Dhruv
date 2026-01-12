@php
    $defaultLang = getDefaultLanguage(1);
    $teams = App\Models\Team::whereStatus('yes')->with([
        'teamDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
    ]);
    $teams = $teams
        ->addSelect([
            'name_order' => App\Models\TeamDetail::where('language_id', $defaultLang->id)
                ->whereColumn('team_id', 'teams.id')
                ->limit(1)
                ->select('name'),
        ])
        ->orderBy('name_order')
        ->get();
@endphp
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                {{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : 'Our teams' }}</h1>
        </div>
        <div class="mt-4">
            @if (isset($page->image))
              <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
                <img class="w-full h-full object-contain mx-auto" src="{{ asset(largeImage($page->image)) }}" alt="">
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

            <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                @foreach ($teams as $team)
                    <div class="border shadow w-64 md:w-full mx-auto relative">
                        <div class="h-48 border bg-white">
                            <?php $image = isset($team->teamImage->thumbnail_image) ? $team->teamImage->thumbnail_image : ''; ?>
                            <img class="w-full object-contain h-full" src="{{ asset($image) }}" alt="">
                        </div>
                        <div
                        class="px-4 py-2 text-center w-full mb-12">
                        <p class="can-edu-card-p text-black">
                            {{ isset($team->teamDetail[0]->title) ? $team->teamDetail[0]->title : '' }}</p>
                    </div>
                        <div
                            class="absolute h-12 bottom-0 bg-primary hover:bg-secondaryRed text-white font-FuturaMdCnBT px-5 py-2 border border-primary hover:border-secondaryRed text-center focus:bg-primary active:bg-primary w-full">
                            <p class="text-white truncate text-center">
                                {{ isset($team->teamDetail[0]->name) ? $team->teamDetail[0]->name : '' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
