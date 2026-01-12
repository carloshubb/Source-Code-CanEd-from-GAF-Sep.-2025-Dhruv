@php
$defaultLang = getDefaultLanguage(1);
    $quotes = App\Models\Quote::with([
        'quoteDetail' => function ($q) use ($defaultLang) {
            $q = $q->where('language_id', $defaultLang->id);
        },
        'user',
        'quoteImage',
        'customer',
        'school',
        'school.schoolDetail',
    ])
        ->where('status', 'yes')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    $isLoggedIn = Auth::guard('customers')->check();
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
    $school_id = isset(Auth::guard('customers')->user()->school->id) ? Auth::guard('customers')->user()->school->id : '';
    $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
    $quoteTranslations = getStaticTranslation('quote');
    $lang_abbreviation = $defaultLang['abbreviation'];
    $lang_id = $defaultLang['id'];
    $indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text']) ? getStaticTranslation('general')['indicate_required_field_text'] : '';
@endphp
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="flex flex-row w-full items-end gap-3 h-14 mb-8">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                {!! isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : 'Our teams' !!}</h1>
        </div>
        <add-quote indicate_required_field="{{$indicateRequiredField}}" lang_id="{{$lang_id}}" lang="{{ $lang_abbreviation }}" quote_translations="{{ $quoteTranslations }}" position="{{ $position }}"
            school_id="{{ $school_id }}" is_logged_id="{{ $isLoggedIn }}"
            logged_in_customer="{{ $loggedInCustomer }}"></add-quote>
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-10 mb-6 md:mb-10">
        @foreach ($quotes as $quote)
            <div class="flex flex-col max-w-sm mx-4 my-6 shadow-lg">
                <div class="px-4 py-12 h-full rounded-t-lg sm:px-8 md:px-12 dark:bg-gray-900">
                    <p class="relative py-1 text-lg italic text-center dark:text-gray-100 w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"
                            class="w-8 h-8 dark:text-violet-400">
                            <path d="M232,246.857V16H16V416H54.4ZM48,48H200V233.143L48,377.905Z"></path>
                            <path d="M280,416h38.4L496,246.857V16H280ZM312,48H464V233.143L312,377.905Z"></path>
                        </svg>
                        <div class="px-4">
                            {!! isset($quote->quoteDetail[0]->quote) ? $quote->quoteDetail[0]->quote : '' !!}
                        </div>
                        <div class="flex justify-end mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"
                            class="w-8 h-8 dark:text-violet-400">
                            <path d="M280,185.143V416H496V16H457.6ZM464,384H312V198.857L464,54.1Z"></path>
                            <path d="M232,16H193.6L16,185.143V416H232ZM200,384H48V198.857L200,54.1Z"></path>
                        </svg>
                        </div>
                    </p>
                </div>
                <div
                    class="flex flex-col items-center justify-center p-8  rounded-b-lg bg-primary text-white">
                    @if(isset($quote->quoteImage->thumbnail_image))
                    <img src="{{ isset($quote->quoteImage->thumbnail_image) ? asset($quote->quoteImage->thumbnail_image) : '' }}" alt=""
                        class="w-16 h-16 mb-2 -mt-16 bg-center bg-cover rounded-full dark:bg-gray-500">
                         @else
                    <img src="{{ asset('assets/front/logo.png')}}" alt=""
                        class="w-16 h-16 mb-2 -mt-16 bg-center bg-cover rounded-full dark:bg-gray-500">
                        @endif
                    <p class="text-xl font-semibold leadi">{{isset($quote->name) ? $quote->name : ''}}</p>
                    <p class="text-sm capitalize">{{isset($quote->location) ? $quote->location : ''}}</p>
                </div>
            </div>
        @endforeach
    </div>
    {!! $quotes->withQueryString()->onEachSide(1)->links('custom_pagination') !!}
</div>
