@extends('front.layouts.app')
@section('content')
    @php
        $defaultLang = getDefaultLanguage(1);
        
    @endphp
    <?php $school_slug = isset(\Auth::guard('customers')->user()->school->schoolDetail[0]->school_name) ? \Auth::guard('customers')->user()->school->schoolDetail[0]->school_name : '';
    $school_slug = createSlug($school_slug);
    ?>
    <div class="bg-white container mx-auto">
        <div class="grid grid-cols-12 gap-4 mt-10">
            <div class="md:col-span-3 col-span-12 border border-gray-500 rounded-md w-full">
                <div>
                    <h3 class=" px-4 pt-4 heading3 text-primary mb-0" style="margin-bottom: 0 !important;">Our account</h3>
                    <ul class="ml-4 px-4 py-4 font-FuturaMedium">
                        <li
                            class="{{ Route::currentRouteName() == 'web.account' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                            <a class="text-lg"
                                href="{{ route('web.account', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">Account
                                dashboard</a>
                        </li>
                        <li
                            class="{{ Route::currentRouteName() == 'web.account.info' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                            <a class="text-lg"
                                href="{{ route('web.account.info', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">Account
                                information</a>
                        </li>
                        {{-- <li
                            class="{{ Route::currentRouteName() == 'web.account.fav.article' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                            <a class="text-lg"
                                href="{{ route('web.account.fav.article', ['lang' => $defaultLang['abbreviation']]) }}">Our
                                articles & videos</a>
                        </li> --}}
                        {{-- <li
                            class="{{ Route::currentRouteName() == 'web.account.fav.business' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                            <a class="text-lg"
                                href="{{ route('web.account.fav.business', ['lang' => $defaultLang['abbreviation']]) }}">
                                Fovourite businesses
                            </a>
                        </li> --}}
                        @if (!isset($data['logged_in_user_type']) || ( $data['logged_in_user_type'] != 'student') && ( $data['logged_in_user_type'] != 'business'))
                        <li
                            class="{{ Route::currentRouteName() == 'web.account.fav.article' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                            <a class="text-lg"
                                href="{{ route('web.account.fav.article', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                Favorite articles & videos
                            </a>
                        </li>
                    @endif
                    @if (!isset($data['logged_in_user_type']) || ( $data['logged_in_user_type'] != 'student') && ( $data['logged_in_user_type'] != 'school'))
                    <li
                        class="{{ Route::currentRouteName() == 'web.account.our.articles' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                        <a class="text-lg"
                            href="{{ route('web.account.our.articles', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                            Our articles & videos
                        </a>
                    </li>
                @endif
                    {{-- @if (!isset($data['logged_in_user_type']) || ($data['logged_in_user_type'] != 'school' && $data['logged_in_user_type'] != 'student'))
                    <li
                        class="{{ Route::currentRouteName() == 'web.account.fav.article' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                        <a class="text-lg"
                            href="{{ route('web.account.fav.article', ['lang' => $defaultLang['abbreviation']]) }}">
                            Our articles & videos
                        </a>
                    </li>
                @endif --}}
                        @if (!isset($data['logged_in_user_type']) || ($data['logged_in_user_type'] != 'business' && $data['logged_in_user_type'] != 'student'))
                        <li
                            class="{{ Route::currentRouteName() == 'web.account.fav.business' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                            <a class="text-lg"
                                href="{{ route('web.account.fav.business', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                Our businesses
                            </a>
                        </li>
                    @endif

                        {{-- @if (!isset($data['logged_in_user_type']) || $data['logged_in_user_type'] != 'business'  && $data['logged_in_user_type'] != 'student')
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.fav.event' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.fav.event', ['lang' => $defaultLang['abbreviation']]) }}">
                                    Our events
                                </a>
                            </li>
                        @endif --}}

                        @if (!isset($data['logged_in_user_type']) || $data['logged_in_user_type'] != 'business' && $data['logged_in_user_type'] != 'student')
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.fav.scholarships' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.fav.scholarship', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Our scholarships
                                </a>
                            </li>
                        @endif



                        @if (!isset($data['logged_in_user_type']) || $data['logged_in_user_type'] != 'business' && $data['logged_in_user_type'] != 'school')
                        <li
                            class="{{ Route::currentRouteName() == 'web.account.fav.articles' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                            <a class="text-lg"
                                href="{{ route('web.account.fav.articles', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                Favorite articles & videos
                            </a>
                        </li>
                        <li
                        class="{{ Route::currentRouteName() == 'web.account.my.articles' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                        <a class="text-lg"
                            href="{{ route('web.account.my.articles', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                            My articles & vidoes
                        </a>
                    </li>
                    @endif
                        
                        @if (!isset($data['logged_in_user_type']) || $data['logged_in_user_type'] != 'business' && $data['logged_in_user_type'] != 'school')
                        <li
                            class="{{ Route::currentRouteName() == 'web.account.my.events' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                            <a class="text-lg"
                                href="{{ route('web.account.my.events', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                Favorite events
                            </a>
                        </li>
                    @endif
                        @if (!isset($data['logged_in_user_type']) || $data['logged_in_user_type'] != 'business' && $data['logged_in_user_type'] != 'school')
                        <li
                            class="{{ Route::currentRouteName() == 'web.account.fav.businesses' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                            <a class="text-lg"
                                href="{{ route('web.account.fav.businesses', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                Favorite businesses
                            </a>
                        </li>
                    @endif
                        @if (!isset($data['logged_in_user_type']) || $data['logged_in_user_type'] != 'business' && $data['logged_in_user_type'] != 'school')
                        <li
                            class="{{ Route::currentRouteName() == 'web.account.fav.scholarship' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                            <a class="text-lg"
                                href="{{ route('web.account.fav.scholarships', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                Favorite scholarships
                            </a>
                        </li>
                    @endif
                        @if (!isset($data['logged_in_user_type']) || $data['logged_in_user_type'] != 'business' && $data['logged_in_user_type'] != 'school')
                        <li
                            class="{{ Route::currentRouteName() == 'web.account.my.qoutes' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                            <a class="text-lg"
                                href="{{ route('web.account.my.qoutes', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                My quotes
                            </a>
                        </li>
                    @endif
                        @if (!isset($data['logged_in_user_type']) || $data['logged_in_user_type'] != 'business' && $data['logged_in_user_type'] != 'school')
                        <li
                            class="{{ Route::currentRouteName() == 'web.account.networks' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                            <a class="text-lg"
                                href="{{ route('web.account.networks', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                My networks
                            </a>
                        </li>
                    @endif


                        @if (!isset($data['logged_in_user_type']) || $data['logged_in_user_type'] != 'business' && $data['logged_in_user_type'] != 'school')
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.fav.school' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.fav.school', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Favorite schools
                                </a>
                            </li>
                        @endif


                        @if (isset($data['logged_in_user_type']) && $data['logged_in_user_type'] == 'school')
                            {{-- <li
                                class="{{ Route::currentRouteName() == 'web.account.my.events' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.my.events', ['lang' => $defaultLang['abbreviation']]) }}">
                                    Our events
                                </a>
                            </li> --}}
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.networks' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.networks', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Our network banners
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.my.qoutes' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.my.qoutes', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Our quotes
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.suggested.programs' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.suggested.programs', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Suggested programs
                                </a>
                            </li>
                        @endif
                    </ul>
                    @if (isset($data['logged_in_user_type']) && $data['logged_in_user_type'] == 'business')
                        <hr>
                        <h3 class="px-4 pt-4 heading3 text-primary mb-0" style="margin-bottom: 0px !important;">Business</h3>
                        <ul class="ml-4 px-4 py-4 font-FuturaMedium">
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.business' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.business', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">Businesses
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.school.articles' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.articles', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Articles
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.virtual.tour' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.virtual.tour', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Virtual tours
                                </a>
                            </li>
                            {{-- <li
                                class="{{ Route::currentRouteName() == 'web.account.school.articles.done' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.articles', ['lang' => $defaultLang['abbreviation']]) }}">
                                    Other articles & videos
                                </a>
                            </li> --}}
                        </ul>
                        <hr>
                    @endif
                    @if (isset($data['logged_in_user_type']) && $data['logged_in_user_type'] == 'student')
                        <hr>
                        {{-- <h3 class=" px-4 pt-4 heading3 text-primary mb-0" style="margin-bottom: 0 !important;">Student profile</h3> --}}
                        {{-- <ul class="ml-4 px-4 py-4 font-FuturaMedium"> --}}
                            {{-- <li
                                class="{{ Route::currentRouteName() == 'web.account.student.profile' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.student.profile', ['lang' => $defaultLang['abbreviation']]) }}">Update
                                    profile</a>
                            </li> --}}
                            {{-- <li class="{{ Route::currentRouteName() == 'web.account.school.articles' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.articles', ['lang' => $defaultLang['abbreviation']]) }}">
                                    Articles
                                </a>
                            </li> --}}
                            {{-- <li class="{{ Route::currentRouteName() == 'web.account.school.events' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.events', ['lang' => $defaultLang['abbreviation']]) }}">
                                    Events
                                </a>
                            </li> --}}
                        {{-- </ul> --}}
                        {{-- <ul class="ml-4 px-4 py-4 font-FuturaMedium">
                            <li class="{{ Route::currentRouteName() == 'web.account.school.articles' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.articles', ['lang' => $defaultLang['abbreviation']]) }}">
                                    Articles
                                </a>
                            </li>
                        </ul> --}}
                        <hr>
                    @endif
                    {{-- @if (isset($data['logged_in_user_type']) && $data['logged_in_user_type'] == 'student')
                        <ul class="ml-4 px-4 py-4 font-FuturaMedium">
                            <li class="{{ Route::currentRouteName() == 'web.account.school.articles' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.articles', ['lang' => $defaultLang['abbreviation']]) }}">
                                    Articles
                                </a>
                            </li>
                            <li class="{{ Route::currentRouteName() == 'web.account.school.events' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.events', ['lang' => $defaultLang['abbreviation']]) }}">
                                    Events
                                </a>
                            </li>
                        </ul>
                    @endif --}}
                    @if (isset($data['logged_in_user_type']) &&
                            $data['logged_in_user_type'] == 'school' &&
                            $data['school'] != '' &&
                            $data['school'] != null)
                        <h3 class="px-4 pt-4 heading3 text-primary mb-0" style="margin-bottom: 0px !important;">School dashboard</h3>
                        <ul class="ml-4 px-4 py-4 font-FuturaMedium">
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.school.articles' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.articles', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Articles
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.school.events' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.events', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Our events
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.school.employee' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.employee', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Admissions
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.admission.faq' && request()->route('type') == 'admission' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.admission.faq', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug, 'type' => 'admission']) }}">
                                    Admission FAQ
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.school.contact' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.contact', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Contacts
                                </a>
                            </li>
                            <li
                            class="{{ Route::currentRouteName() == 'web.account.school.ambassador.setting' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.ambassador.setting', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Ambassadors
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.school.financial' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.financial', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Financials
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.admission.faq' && request()->route('type') == 'financial' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.admission.faq', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug, 'type' => 'financial']) }}">
                                    Financials FAQ
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.school.information' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.information', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">School information</a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.school.overview' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.overview', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Overview
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.admission.faq' && request()->route('type') == 'overview' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.admission.faq', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug, 'type' => 'overview']) }}">
                                    Overview FAQ
                                </a>
                            </li>

                            <li
                                class="{{ Route::currentRouteName() == 'web.account.school.program' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.program', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Programs
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.admission.faq' && request()->route('type') == 'programs' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.admission.faq', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug, 'type' => 'programs']) }}">
                                    Programs FAQ
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.school.quick-fact' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">

                                <a class="text-lg"
                                    href="{{ route('web.account.school.quick-fact', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    School Quick Facts
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.admission.faq' && request()->route('type') == 'quick_facts' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.admission.faq', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug, 'type' => 'quick_facts']) }}">
                                    Quick Facts FAQ
                                </a>
                            </li>

                            <li
                                class="{{ Route::currentRouteName() == 'web.account.school.scholarship' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.scholarship', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Scholarships
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.admission.faq' && request()->route('type') == 'scholarship' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.admission.faq', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug, 'type' => 'scholarship']) }}">
                                    Scholarships FAQ
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.school.blog' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.blog', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Blogs
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.school.school-teams' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.school-teams', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Teams
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.open.house' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.open.house', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Open house days
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.virtual.tour' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.virtual.tour', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Virtual tours
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.school.ambassador' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.ambassador', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    School ambassadors
                                </a>
                            </li>

                            {{-- <li class="{{ Route::currentRouteName() == 'web.account' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2':'font-FuturaMdCnBT text-lg'}}">
                                <a class="text-lg" href="{{ route('web.account.search.student') }}">
                                    Search students
                                </a>
                            </li> --}}
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.demetra' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.demetra', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Our Reverse Admissions
                                </a>
                            </li>

                            <li class="font-FuturaMdCnBT text-lg">
                                <a class="text-lg"
                                    href="{{ route('web.view.school', ['lang' => $defaultLang['abbreviation'], 'id' => $data['school'], 'slug' => $school_slug]) }}">
                                    View our school
                                </a>
                            </li>
                            <li
                                class="{{ Route::currentRouteName() == 'web.account.school.videos' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                                <a class="text-lg"
                                    href="{{ route('web.account.school.videos', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                    Videos
                                </a>
                            </li>
                        </ul>
                        <hr>
                    @endif


                    <h3 class="px-4 pt-4 heading3 text-primary mb-0" style="margin-bottom: 0 !important;">Account settings</h3>
                    <ul class="ml-4 px-4 py-4 font-FuturaMedium">
                        <li
                            class="{{ Route::currentRouteName() == 'web.update.password' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                            <a class="text-lg"
                                href="{{ route('web.update.password', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">Update
                                password</a>
                        </li>

                        <li
                            class="{{ Route::currentRouteName() == 'web.account.school.setting' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                            <a class="text-lg"
                                href="{{ route('web.account.school.setting', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">
                                Languages
                            </a>
                        </li>
                        <li
                            class="{{ Route::currentRouteName() == 'web.account.close' ? 'font-FuturaMdCnBT text-lg text-white bg-primary p-2' : 'font-FuturaMdCnBT text-lg' }}">
                            <a class="text-lg"
                                href="{{ route('web.account.close', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}">Close
                                our account</a>
                        </li>
                    </ul>
                </div>
            </div>
            @yield('account-content')
            <br />
        </div>
    </div>
@endsection
