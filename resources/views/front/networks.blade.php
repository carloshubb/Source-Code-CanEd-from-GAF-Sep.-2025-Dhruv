@php
    $defaultLang = getDefaultLanguage(1);
    $networks = App\Models\Network::with([
        'networkDetail' => function ($q) use ($defaultLang) {
            $q = $q->where('language_id', $defaultLang->id);
        },
    ])
        ->addSelect([
            'name_order' => App\Models\NetworkDetail::where('language_id', $defaultLang->id)
                ->whereColumn('network_id', 'networks.id')
                ->limit(1)
                ->select('full_name'),
        ])
        ->where('status', 'yes')
        ->orderBy('name_order')
        ->paginate(10);
    $isLoggedIn = Auth::guard('customers')->check();
    $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
    $networkTranslations = getStaticTranslation('network');
    $lang_abbreviation = $defaultLang['abbreviation'];
    $lang_id = $defaultLang['id'];
    $banner_image = largeImage($data['network_banner']);
    $indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';
    $successMessage = getStaticTranslation('toaster_messages')['netowrk_add_success_message'] ?? '';

@endphp
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full justify-between md:justify-center items-end gap-3 mb-6">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                {{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : 'Worldwide network' }}
            </h1>
        </div>
        {{-- @if (isset($data['logged_in_user_type']) && $data['logged_in_user_type'] == 'school') --}}
        @if (isset($data['logged_in_user_type']) && ($data['logged_in_user_type'] == 'school' || $data['logged_in_user_type'] == 'student'))
        <div class="flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
            <add-network indicate_required_field="{{ $indicateRequiredField }}" app_url="{{ env('APP_URL') }}"
                banner_image="{{ $banner_image }}" lang_id="{{ $lang_id }}" lang="{{ $lang_abbreviation }}"
                network_translations="{{ $networkTranslations }}" logged_in_customer="{{ $loggedInCustomer }}"
                position="{{ $position }}" is_logged_id="{{ $isLoggedIn }}"
                success_message="{{ $successMessage }}"

                ></add-network>
        </div>
        @endif
    </div>
    @if (!empty($page->image))
    <div class="mt-4 bg-white h-60 md:h-80 2xl:h-96 border w-full md:w-2/3 mx-auto rounded mb-5">
        <img class="w-full h-full object-contain mx-auto"
            src="{{ asset(largeImage($page->image)) }}" alt="demetra">
    </div>
@endif
    @isset($page->pageDetail[0])
    <div class="can-edu-p mt-4">
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


    <div class="mt-16 md:mt-10">

        <div class="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($networks as $network)
                <div class="border w-full rounded-md shadow h-full bg-gray-50">
                    <a href="{{ $network->website_url }}" target="_blank">
                        <div class="h-60 bg-white border">
                            <?php $image = isset($network->networkImage->thumbnail_image) ? $network->networkImage->thumbnail_image : ''; ?>
                            <img class="h-full w-full object-contain" src="{{ asset($image) }}" alt="">
                        </div>
                        <div class="bg-gray-50 p-4 w-full text-center">
                            <p class="can-edu-card-h">
                                {{ isset($network->networkDetail[0]->full_name) ? $network->networkDetail[0]->full_name : '' }}
                            </p>
                            {{-- <p class="font-semibold text-gray-700">
                                {{ isset($network->country) ? $network->country : '' }}</p> --}}
                            <div class="can-edu-p line-clamp-2">
                                {!! isset($network->networkDetail[0]->description) ? $network->networkDetail[0]->description : '' !!}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
        {!! $networks->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
    </div>

</div>
