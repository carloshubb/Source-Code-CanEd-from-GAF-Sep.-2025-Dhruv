@php
$defaultLang = getDefaultLanguage(1);
    $stories = App\Models\Story::with([
        'storyDetail' => function ($q) use ($defaultLang) {
            $q = $q->where('language_id', $defaultLang->id);
        },
    ])
        ->addSelect([
            'name_order' => App\Models\StoryDetail::where('language_id', $defaultLang->id)->whereColumn('story_id', 'stories.id')
                ->limit(1)
                ->select('title'),
        ])
        ->orderBy('name_order')
        ->get();

        $storiesTranslations = getStaticTranslation('story_create_page');
    $isLoggedIn = Auth::guard('customers')->check();
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
    $school_id = isset(Auth::guard('customers')->user()->school->id)
        ? Auth::guard('customers')->user()->school->id
        : '';
@endphp
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="">
        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full justify-between md:justify-center items-end gap-3 mb-6">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">
                   {{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : 'Our stories' }}
               </h1>
           </div>
           <div class="md:-mb-4 flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
               <add-story story_modal_translation="{{ $storiesTranslations }}"
               position="{{ $defaultLang->position ?? 'rtl' }}" lang="{{ $defaultLang['abbreviation'] }}"
               school_id="{{ $school_id }}" is_logged_id="{{ $isLoggedIn }}"
               logged_in_customer="{{ $loggedInCustomer }}" logged_in_user_type="{{ $data['logged_in_user_type'] }}"></add-story>
           </div>
        </div>
          

            @if (!empty($page->image))
        <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
            <img class="w-full h-full object-contain mx-auto"
                src="{{ asset(largeImage($page->image)) }}" alt="demetra">
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
            <div class="mt-4">

            <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 my-6">
                @foreach ($stories as $story)
                    <a href="{{url('/'.$defaultLang['abbreviation'].'/story/' . $story->id)}}" target="_blank">
                        <div class="border shadow w-64 md:w-auto mx-auto">
                            <?php $image = isset($story->storyImage->thumbnail_image) ?  $story->storyImage->thumbnail_image : ''; ?>
                            <div class="h-48 bg-gray-50 border">
                                <img class="w-full object-contain h-full"
                                    src="{{ asset($image) }}"
                                    alt="">
                            </div>
                            <div class="bg-primary hover:bg-secondaryRed text-white font-FuturaMdCnBT px-5 py-2 border border-primary hover:border-secondaryRed text-center focus:bg-primary active:bg-primary w-full">
                                <p class="text-white truncate text-center">
                                    {{ isset($story->storyDetail[0]->title) ? $story->storyDetail[0]->title : '' }}
                                    
                                </p>
                                {{-- <p class="text-white truncate text-center">
                                    {{ isset($story->student_name) ? $story->student_name : '' }}
                                </p> --}}
                                
                            </div>
                        </div>
                    </a>
                @endforeach


            </div>

        </div>
    </div>

</div>
