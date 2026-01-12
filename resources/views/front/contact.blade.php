@php
    $defaultLang = getDefaultLanguage(1);
    $contactPageSetting = App\Models\ContactPageSetting::with([
        'contactPageSettingDetail' => function ($q) use ($defaultLang) {
            $q = $q->where('language_id', $defaultLang->id);
        },
    ])->first();
    $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
    $indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';
    $successMessage = getStaticTranslation('toaster_messages')['contact_us_submit_success_message'] ?? '';

@endphp
<section class="relative overflow-hidden">
    <div class="relative container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <!-- <div class="max-w-lg lg:max-w-3xl xl:max-w-5xl mx-auto"> -->
        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1 ">
                    {{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : '' }}</h1>
            </div>
        </div>
        <div class="mt-4">
            @if (!empty($page->image))
                <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
                    <img class="w-full h-full object-contain mx-auto"
                        src="{{ asset(largeImage($page->image)) }}" alt="">
                </div>
                <!-- <br /> <br /> -->
            @endif
            @isset($page->pageDetail[0])
            <div class="can-edu-p">
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
        </div>
        <!-- </div> -->
    </div>
</section>
<contact-page indicate_required_field="{{$indicateRequiredField}}" position="{{ $position }}" contact_page_setting="{{ $contactPageSetting }}" 
success_message="{{ $successMessage }}"

></contact-page>
