@php
    $isLoggedIn = Auth::guard('customers')->check();
    
    $defaultLang = getDefaultLanguage(1);
    $SugPageSetting = App\Models\SugPageSetting::with([
        'sugPageSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
    ])->first();
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
    $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
    $indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';
    $successMessage = getStaticTranslation('toaster_messages')['suggession_feedback_submit_success_message'] ?? '';

@endphp
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                {{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : 'Our sponsors' }}</h1>
        </div>
        <div class="mt-4">
            @if (isset($page->image))
              <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
                <img class="w-full h-full object-contain mx-auto" src="{{ asset(largeImage($page->image)) }}"
                    alt="">
              </div>
            @endif
            @isset($page->pageDetail[0])
            <div class="text-black text-justify mt-4">
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

            <suggession-form indicate_required_field="{{ $indicateRequiredField }}" position="{{ $position }}"
                sug_page_setting="{{ $SugPageSetting }}" logged_in_customer="{{ $loggedInCustomer }}"
                logged_id="{{ $isLoggedIn }}"
                success_message="{{ $successMessage }}"

                >
            </suggession-form>
        </div>

    </div>

</div>
