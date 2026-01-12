<?php
$defaultLang = getDefaultLanguage(1);
$programSetting = App\Models\ProximaRequestSetting::with([
    'proximaRequestSettingDetail' => function ($q) use ($defaultLang) {
        $q = $q->where('language_id', $defaultLang->id);
    },
])->first();
$isLoggedIn = Auth::guard('customers')->check();
$position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
$proxiMatchTranslations = getStaticTranslation('proximatch');

$indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';
$successMessage = getStaticTranslation('toaster_messages')['proximatch_request_success_message'] ?? '';

?>
<div class="bg-white container mx-auto">
    <section class="relative overflow-hidden">
        <div class="relative container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
            <!-- <div class="max-w-lg lg:max-w-3xl xl:max-w-5xl mx-auto"> -->
            <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
                <div class="border-b-4 pb-2 border-primary w-full">
                    <h1 class="can-edu-h1">
                        {{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : '' }}</h1>
                </div>
            </div>
            <div>
                @if (!empty($page->image))
                  <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
                    <img class="w-full h-full object-contain mx-auto"
                            src="{{ asset(largeImage($page->image)) }}" alt="">
                  </div>
                @endif
                @isset($page->pageDetail[0])
                <div class="can-edu-p mt-6">
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

                <proximatch-modal success_message="{{ $successMessage }}" indicate_required_field="{{$indicateRequiredField}}" proximatch_translation="{{ $proxiMatchTranslations }}" position="{{ $position }}"
                    program_setting="{{ $programSetting }}" is_logged_id="{{ $isLoggedIn }}"></proximatch-modal>
            </div>
            <!-- </div> -->
        </div>
    </section>

</div>
<br />
