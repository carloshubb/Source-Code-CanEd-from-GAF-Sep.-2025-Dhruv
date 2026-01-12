@php
    $defaultLang = getDefaultLanguage(1);
    $page = '';
    if (!empty($slug) && $slug != $defaultLang->abbreviation) {
        $page = App\Models\Page::with([
            'pageDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ])
            ->where('slug', $slug)
            ->first();
    } elseif (!empty($lange) && $lange == $defaultLang->abbreviation) {
        $page = App\Models\Page::with([
            'pageDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ])
            ->where('set_as_home', 1)
            ->first();
    }
@endphp
@extends($page == '' || $page == null ? 'front.layouts.nostyle' : 'front.layouts.app')
@section('content')
    @if (Session::has('status') && Session::has('message'))
    <div id="popup-modal" class="fixed inset-0 z-50 bg-black bg-opacity-50 transition-opacity opacity-100" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 w-screen overflow-y-auto" onclick="closePopup(event)">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
                <div id="modal_content" onclick="event.stopPropagation()"
                    class="relative transform overflow-hidden rounded-2xl shadow-2xl border-4 border-primary/30 bg-white text-center transition-all sm:my-8 sm:w-full sm:max-w-md opacity-100 translate-y-0">
                    <div class="bg-white p-4 sm:p-6">
                        <div class="mt-4 text-center">
                            <p class="text-lg text-center text-black">{!! session('message') !!}</p>
                        </div>
                    </div>
                    <div class="bg-white pt-0 p-4 sm:flex sm:flex-row-reverse sm:p-6 sm:pt-0 justify-center">
                        <a href="" onclick="closePopup(event)" class="can-edu-btn-fill">Close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @endif

    @if (isset($page->template) && $page->template == 'home_template')
        @include('front.home')
    @elseif(isset($page->template) && $page->template == 'login_template')
        @include('front.auth.login')
    @elseif(isset($page->template) && $page->template == 'register_template')
        @include('front.auth.register')
    @elseif(isset($page->template) && $page->template == 'school_request_template')
        @include('front.register-school')
    @elseif(isset($page->template) && $page->template == 'contact_page_template')
        @include('front.contact')
    @elseif(isset($page->template) && $page->template == 'master_application_template')
        @include('front.master-application')
    @elseif(isset($page->template) && $page->template == 'career_setting')
        @include('front.career')
    @elseif(isset($page->template) && $page->template == 'program_setting')
        @include('front.program')
    @elseif(isset($page->template) && $page->template == 'register_business_template')
        @include('front.register-business')
    @elseif(isset($page->template) && $page->template == 'article_page_setting')
        @include('front.articles')
    @elseif(isset($page->template) && $page->template == 'our_sponsor')
        @include('front.sponsors', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'meet_our_team')
        @include('front.team', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'quotes')
        @include('front.quotes', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'networks')
        @include('front.networks', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'videos')
        @include('front.videos', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'scholar_ship')
        @include('front.scholarships', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'schools')
        @include('front.schools', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'virtual_tour')
        @include('front.virtual_tours', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'open_houses')
        @include('front.open_days', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'events')
        @include('front.events', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'business_directory')
        @include('front.business_directory', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'businesses')
        @include('front.business', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'jobs')
        @include('front.jobs', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'suggessions')
        @include('front.suggessions', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'demetra')
        @include('front.demetra_search', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'proximatch')
        @include('front.proximatch', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'ambassadors')
        @include('front.ambassadors', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'sitemap')
        @include('front.sitemap', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'webinars')
        @include('front.webinars', ['page' => $page])
    @elseif(isset($page->template) && $page->template == 'story')
        @include('front.stories', ['page' => $page])
    @else
        @if ($page == '' || $page == null)
            @include('front.404')
        @else
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
        @endif
    @endif
@endsection
