<!DOCTYPE html>
@php
    $defaultLang = getDefaultLanguage(1);
@endphp
<html lang="en" class="light scroll-smooth"
    dir="{{ isset($defaultLang->position) ? $defaultLang->position : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="/assets/fevicon.png">
    {{-- <link rel="icon" href="https://proximastudy.com/img/frontend/logo.png" /> --}}
    <title>Proxima Study</title>
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">
    <link href="/dist/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        /* p{
            color: #000;
        } */
        /* Styles for the preloader */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .preloader-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #b1040e;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Hide preloader when content is loaded */
        .loaded .preloader {
            display: none;
        }

        /* Hidden by default */
        .modal {
            display: none;
        }

        /* Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
        }

        /* Modal container */
        .modal-container {
            position: relative;
            z-index: 2;
        }

        /* Modal content */
        .modal-content {
            overflow: hidden;
        }

        /* Modal close button */
        .modal-close {
            cursor: pointer;
            z-index: 1;
        }

        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            object-fit: cover;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            content: "";
        }

        .active_button {
            background: #f3f4f6 !important;
            border-top-width: 4px !important;
            border-bottom: none;
            --tw-border-opacity: 1 !important;
            border-top-color: rgb(177 4 14 / var(--tw-border-opacity)) !important;
            border-left-color: rgb(209 213 219 / var(--tw-border-opacity)) !important;
            border-right-color: rgb(209 213 219 / var(--tw-border-opacity)) !important;
        }
        .disabled_button:disabled {
            background-color: #C1363E !important; 
            border-color: #C1363E !important; 
        }
        .tox-statusbar__branding{
          display: none !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
            right: 0;
            left: auto !important;
            border-left: 1px solid #aaa !important;
            border-right: none !important;
            border-radius: 0 !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__display{
            padding-right: 20px !important;
        }
        .swal2-styled.swal2-confirm {
            background-color: #b1040e !important;
            color: #ffffff !important;
            border-radius: 4px;
            font-family: 'FuturaMdCnBT';
            font-size: 18px;
            line-height: 120%;
            padding: 8px 20px;
            border: 1px solid #b1040e;
            text-align: center;
            white-space: nowrap;
        }
        .swal2-styled.swal2-confirm:hover{
          background-color: #C1363E40 !important;
          border-color: #C1363E;
        }
        .swal2-styled{
            box-shadow: none !important;
        }
        .swal2-actions{
            margin: 0.5em auto 0 !important;
        }
        .swal2-actions:not(.swal2-loading) .swal2-styled:hover {
            background-image: none !important;
        }
        .filepond--credits{
            display: none;
        }

        .swal2-container.swal2-center>.swal2-popup{
            border: 4px solid #b1040e4d !important;
            border-radius: 1rem !important;
        }
        /* Ensure smooth transitions for opacity and transform */
        .transition-all {
            transition: transform 500ms ease-in-out, opacity 500ms ease-in-out;
        }
        .transition-opacity {
            transition: opacity 500ms ease-in-out;
        }
        .transition-transform {
            transition: transform 500ms ease-in-out;
        }
    /* Modal Background Fade-in and Slide-in */
    .slide-in {
        animation: slideIn 0.3s ease-out forwards;
    }

    .slide-out {
        animation: slideOut 0.3s ease-in forwards;
    }

    /* Keyframes for Slide-In */
    @keyframes slideIn {
        0% {
            transform: translateY(-100%);
            opacity: 0;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Keyframes for Slide-Out */
    @keyframes slideOut {
        0% {
            transform: translateY(0);
            opacity: 1;
        }
        100% {
            transform: translateY(-100%);
            opacity: 0;
        }
    }
/* Initial hidden state for modal (above the screen) */
#warningModal {
    transform: translateY(-10px);
    opacity: 0;
    transition: transform 1s ease-in-out, opacity 1s ease-in-out; /* Transition for both transform and opacity */
}

/* Modal when visible (slide in) */
#warningModal.show {
    transform: translateY(0);
    opacity: 1;
}

#successModal {
    transform: translateY(-10px);
    opacity: 0;
    transition: transform 1s ease-in-out, opacity 1s ease-in-out; 
}
#successModal.show {
    transform: translateY(0);
    opacity: 1;
}

    </style>
    @yield('styles')

</head>

<body>
    <!-- Preloader element -->
    <div class="preloader">
        <div class="preloader-spinner"></div>
    </div>

    <div id="canedu-app" class="flex flex-col h-full min-h-screen ">
        <div class="sticky top-0 z-50 flex-initial">

            <div class="bg-darkgray w-full" id="topbar">
                <div id="topbar-content" class="h-full">
                    <div
                        class="container mx-auto h-full flex items-center justify-end
                    @if (isset($defaultLang->position) && $defaultLang->position === 'rtl') divide-0
                                        @else
                                        divide-x @endif
                                        ">

                        @php
                            $topMenu = getTopMenu($defaultLang);
                            $topMenuItems = isset($topMenu->menuDetail[0])
                                ? json_decode($topMenu->menuDetail[0]->menu_items, 1)
                                : null;
                                // dd($topMenuItems);
                        @endphp
                        <ul class="navigation-menu flex items-center divide-x text-base lg:text-lg font-FuturaMdCnBT"
                            id="nav_items">
                            @isset($topMenuItems)
                                @foreach ($topMenuItems as $topMenuItem)
                                    @if (count($topMenuItem['menus']) > 0)
                                        <li class="has-submenu parent-menu-item items-center flex dropdown-menu-exp">

                                            <a aria-label="Proxima study" href="#">{{ $topMenuItem['name'] }}</a><span
                                                class="menu-arrow"></span>
                                            @include('front.includes.navbar-child', [
                                                'childs' => $topMenuItem['menus'],
                                            ])
                                        </li>
                                        <li class="has-submenu parent-menu-item dropdown-menu-exp-responsive">
                                            <a aria-label="Proxima study" class="" onclick="toggleCollapsible()"
                                                href="#">
                                                <span class="flex gap-x-1 items-center">
                                                    {{ $topMenuItem['name'] }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                                                        class="w-3 h-3" id="arrowIcon">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                    </svg>
                                                </span>


                                            </a>
                                            <div id="collapsibleContent"
                                                class="hidden p-2 w-11/12 mx-auto bg-gray-50 rounded ">
                                                @include('front.includes.mobile-navbar-child', [
                                                    'childs' => $topMenuItem['menus'],
                                                ])
                                            </div>
                                        </li>
                                    @else
                                        <li>

                                            @php
                                                $url = langBasedURL($defaultLang, $topMenuItem['link']);
                                            @endphp
                                            <a aria-label="Proxima study" href="{{ $url }}"
                                                class="sub-menu-item text-white font-FuturaMdCnBT px-1 md:px-2 lg:px-4 text-base lg:text-lg">{{ $topMenuItem['name'] }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endisset
                        </ul>
                        {{-- @foreach ($data['topMenus'] as $topMenu)
                            @if (isset($topMenu->menuDetail) && isset($topMenu->url))
                                @php
                                    $urlWithoutString = str_replace(env('APP_URL') . '/', '', $topMenu->url);
                                @endphp
                                <a href="{{ url(isset($topMenu->url) ? $defaultLang['abbreviation'] . '/' . $urlWithoutString : '') }}"
                                    class="text-white font-FuturaMdCnBT px-1 md:px-2 lg:px-4 text-base lg:text-lg
                                    @if (isset($defaultLang->position) && $defaultLang->position === 'rtl') last:pl-2 border-r border-white first:border-none
                                        @else
                                        last:pr-0 @endif
                                        ">
                                    {{ isset($topMenu->menuDetail[0]) ? $topMenu->menuDetail[0]->name : '' }}
                                </a>
                            @endif
                        @endforeach --}}
                        @guest('customers')
                            @guest('school_ambassadors')
                                <a id="topbar-content2"
                                    href="{{ url('/' . $defaultLang['abbreviation'] . '/' . getPageSlug('login_template')) }}"
                                    class="text-white font-FuturaMdCnBT text-base lg:text-lg
                                    @if (isset($defaultLang->position) && $defaultLang->position === 'rtl') pr-1 md:pr-2 lg:pr-4 border-r first:border-none
                                        @else
                                        pl-1 md:pl-2 lg:pl-4 border-l @endif
                                        ">{{ isset(getGeneralTranslation()['login_menu_text']) ? getGeneralTranslation()['login_menu_text'] : 'Login' }}</a>
                            @endguest
                        @endguest

                        <div class="relative block" id="topbar-content3">
                            @auth('customers')
                                <button
                                    class="text-white font-FuturaMdCnBT flex items-center text-base lg:text-lg mb-1ease-linear transition-all duration-150 @if (isset($defaultLang->position) && $defaultLang->position === 'rtl') pr-1 md:pr-2 lg:pr-4 border-r
                                    @else
                                    pl-1 md:pl-2 lg:pl-4 border-l @endif
                                    "
                                    type="button" onclick="toggleNav()">
                                    <?php $image = isset(auth()->guard('customers')->user()->image) && !empty(auth()->guard('customers')->user()->image) ? auth()->guard('customers')->user()->image : ''; ?>
                                    <div class="flex items-center space-2">
                                        @if (!empty($image))
                                            <div
                                                class="h-6 w-6 bg-gray-50 border rounded-full flex items-center justify-center">
                                                <img class="object-cover rounded-full h-full w-full"
                                                    src="{{ asset($image) }}" alt="">
                                            </div>
                                        @endif
                                        <span>
                                            @if (isset(auth()->guard('customers')->user()->display_name) && !empty(auth()->guard('customers')->user()->display_name))
                                                {{ auth()->guard('customers')->user()->display_name }}
                                            @elseif(isset(auth()->guard('customers')->user()->first_name))
                                                {{ auth()->guard('customers')->user()->first_name }}
                                            @endif

                                        </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                        </svg>
                                    </div>
                                </button>
                            @endauth
                            @auth('school_ambassadors')
                                <button
                                    class="text-white font-FuturaMdCnBT pl-1 md:pl-2 lg:pl-4 flex items-center text-base lg:text-lg mb-1ease-linear transition-all duration-150"
                                    type="button" onclick="toggleNav()">
                                    <?php $image = isset(auth()->guard('school_ambassadors')->user()->image) && !empty(auth()->guard('school_ambassadors')->user()->image) ? auth()->guard('school_ambassadors')->user()->image : ''; ?>
                                    <div class="flex items-center space-x-2">
                                        @if (!empty($image))
                                            <div
                                                class="h-6 w-6 bg-gray-50 border rounded-full flex items-center justify-center">
                                                <img class="object-cover h-full w-full rounded-full"
                                                    src="{{ asset($image) }}" alt="">
                                            </div>
                                        @endif
                                        <span>
                                            @if (isset(auth()->guard('school_ambassadors')->user()->schoolAmbassadorDetail[0]->name) &&
                                                    !empty(auth()->guard('school_ambassadors')->user()->schoolAmbassadorDetail[0]->name))
                                                {{ auth()->guard('school_ambassadors')->user()->schoolAmbassadorDetail[0]->name }}
                                            @endif

                                        </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                        </svg>
                                    </div>
                                </button>
                            @endauth
                            <div class="hidden bg-secondaryRed  overflow-hidden -right-2 md:right-0 min-w-max w-32 md:w-36 divide-y absolute text-base z-50 float-left list-none text-left rounded shadow-lg"
                                id="toggle_nav">
                                @auth('customers')
                                    <div class="py-1.5 hover:bg-primary">
                                        <a href="{{ url('/' . $defaultLang['abbreviation'] . '/' . auth()->guard('customers')->user()->slug . '/our-profile') }}"
                                            class="text-white whitespace-nowrap font-FuturaMdCnBT px-2 lg:px-4 w-full text-base lg:text-lg">{{ isset(getGeneralTranslation()['account_profile_menu_text']) ? getGeneralTranslation()['account_profile_menu_text'] : 'My profile' }}</a>
                                    </div>

                                    @if (auth()->guard('customers')->user()->is_package_amount_paid && auth()->guard('customers')->user()->user_type != 'student' )
                                        <div class="py-1.5 hover:bg-primary ">
                                            <a href="{{ url('/' . $defaultLang['abbreviation'] . '/membership-package') }}"
                                                class="text-white font-FuturaMdCnBT whitespace-nowrap text-base lg:text-lg px-2 lg:px-4">{{ isset(getGeneralTranslation()['upgrade_plan_menu_text']) ? getGeneralTranslation()['upgrade_plan_menu_text'] : 'Upgrade Plan' }}</a>
                                        </div>
                                    @elseif (auth()->guard('customers')->user()->is_package_amount_paid && auth()->guard('customers')->user()->user_type == 'student')
                                        <div class="py-1.5 hover:bg-primary ">
                                            <a href="{{ url('/' . $defaultLang['abbreviation'] . '/paid-services') }}"
                                                class="text-white font-FuturaMdCnBT whitespace-nowrap text-base lg:text-lg px-2 lg:px-4">Paid services</a>
                                        </div>
                                    @endif

                                    @if (auth()->guard('customers')->user()->user_type !== 'business') 
                                    <div class="py-1.5 hover:bg-primary ">
                                        <a href="{{ route('chat-inbox', ['lang' => $defaultLang['abbreviation']]) }}"
                                            class="text-white font-FuturaMdCnBT whitespace-nowrap text-base lg:text-lg px-2 lg:px-4">
                                            {{ isset(getGeneralTranslation()['ambassador_chat_menu_text']) ? getGeneralTranslation()['ambassador_chat_menu_text'] : 'Ambassador Chat' }}
                                        </a>
                                    </div>
                                @endif

                                    {{-- <div class="py-1.5 hover:bg-primary ">
                                        <a href="{{ route('chat-inbox', ['lang' => $defaultLang['abbreviation']]) }}"
                                            class="text-white font-FuturaMdCnBT whitespace-nowrap text-base lg:text-lg px-2 lg:px-4">{{ isset(getGeneralTranslation()['ambassador_chat_menu_text']) ? getGeneralTranslation()['ambassador_chat_menu_text'] : 'Ambassador Chat' }}</a>
                                    </div> --}}

                                    @if (auth()->guard('customers')->user()->user_type == 'student')
                                        <div class="py-1.5 hover:bg-primary ">
                                            <a href="{{ route('chat-admin', ['lang' => $defaultLang['abbreviation']]) }}"
                                                class="text-white font-FuturaMdCnBT whitespace-nowrap text-base lg:text-lg px-2 lg:px-4">{{ isset(getGeneralTranslation()['admin_chat_menu_text']) ? getGeneralTranslation()['admin_chat_menu_text'] : 'Chat with us' }}</a>
                                        </div>
                                    @endif

                                    @if (auth()->guard('customers')->user()->user_type == 'student')
                                        <div class="py-1.5 hover:bg-primary ">
                                            <a href="{{ url('/' . $defaultLang['abbreviation'] . '/master-application')}}"
                                                class="text-white font-FuturaMdCnBT whitespace-nowrap text-base lg:text-lg px-2 lg:px-4">{{ isset(getGeneralTranslation()['add_master_application_text']) ? getGeneralTranslation()['add_master_application_text'] : 'Add mastr applicationss' }}</a>
                                        </div>
                                    @endif

                                    <button
                                        class="text-white font-FuturaMdCnBT whitespace-nowrap hover:bg-primary text-left px-2 lg:px-4 py-1.5 w-full text-base lg:text-lg"
                                        onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();">{{ isset(getGeneralTranslation()['logout_menu_text']) ? getGeneralTranslation()['logout_menu_text'] : 'Logout' }}</button>
                                    <form id="user-logout-form" action="{{ route('web.user.logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        <input type="hidden" id="logout_last_page" name="logout_last_page">
                                    </form>

                                @endauth
                                @auth('school_ambassadors')
                                    <div class="py-1.5 hover:bg-primary ">
                                        <a href="{{ route('web.ambassador.chat', ['lang' => $defaultLang['abbreviation']]) }}"
                                            class="text-white font-FuturaMdCnBT whitespace-nowrap text-base lg:text-lg px-2 lg:px-4">{{ isset(getGeneralTranslation()['student_chat_menu_text']) ? getGeneralTranslation()['student_chat_menu_text'] : 'Student Chat Menu Text' }}</a>
                                    </div>
                                    <button
                                        class="text-white font-FuturaMdCnBT whitespace-nowrap hover:bg-primary text-left px-2 lg:px-4 py-1.5 w-full text-base lg:text-lg"
                                        onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();">{{ isset(getGeneralTranslation()['logout_menu_text']) ? getGeneralTranslation()['logout_menu_text'] : 'Logout' }}</button>
                                    <form id="user-logout-form" action="{{ route('web.user.logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="shadow-lg bg-primary w-full">
                <header class="container mx-auto py-0.5 relative w-full">
                    <nav class="mx-auto flex items-center font-FuturaMdCnBT justify-between" aria-label="Global"
                        id="navbar">
                        <div class=" md:mb-0">
                            <a href="{{ url('/' . $defaultLang['abbreviation']) }}" class="absolute left-50 mx-auto"
                                id="logo_position">
                                <span class="sr-only">Your Company</span>
                                <?php $mainLogo = isset($data['main_logo']) ? $data['main_logo'] : ''; ?>
                                <?php $staticLogo = isset($data['static_logo']) ? $data['static_logo'] : ''; ?>
                                <img class="max-w-[10rem] md:max-w-[13rem] lg:max-w-[215px] h-auto"
                                    src="{{ asset($mainLogo) }}" alt="" id="logo">
                                <img class=" h-auto" src="{{ asset($staticLogo) }}" alt=""
                                    id="logo_scroll">
                            </a>
                        </div>
                        <div class="flex md:hidden">
                            <button onclick="responsivenav()" type="button"
                                class="inline-flex items-center justify-center rounded-md p-2.5 text-white">
                                <span class="sr-only">Open main menu</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </button>
                        </div>
                        @php
                            $menu = getMainMenu($defaultLang);
                            $menuItems = isset($menu->menuDetail[0])
                                ? json_decode($menu->menuDetail[0]->menu_items, 1)
                                : null;
                        @endphp
                        <ul class="navigation-menu text-base lg:text-lg font-FuturaMdCnBT hidden md:flex justify-end divide flex items-center divide-x"
                            id="nav_items">
                            @isset($menuItems)
                                @foreach ($menuItems as $menuItem)
                                    @if (count($menuItem['menus']) > 0)
                                        <li class="has-submenu parent-menu-item items-center flex dropdown-menu-exp">

                                            <a aria-label="Proxima study" href="#">{{ $menuItem['name'] }}</a><span
                                                class="menu-arrow"></span>
                                            @include('front.includes.navbar-child', [
                                                'childs' => $menuItem['menus'],
                                            ])
                                        </li>
                                        <li class="has-submenu parent-menu-item dropdown-menu-exp-responsive">
                                            <a aria-label="Proxima study" class="" onclick="toggleCollapsible()"
                                                href="#">
                                                <span class="flex gap-x-1 items-center">
                                                    {{ $menuItem['name'] }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                                                        class="w-3 h-3" id="arrowIcon">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                    </svg>
                                                </span>


                                            </a>
                                            <div id="collapsibleContent"
                                                class="hidden p-2 w-11/12 mx-auto bg-gray-50 rounded ">
                                                @include('front.includes.mobile-navbar-child', [
                                                    'childs' => $menuItem['menus'],
                                                ])
                                            </div>
                                        </li>
                                    @else
                                        <li class=" flex-1 px-1 md:px-2 lg:px-4 last:pr-0">

                                            @php
                                                $url = langBasedURL($defaultLang, $menuItem['link']);
                                            @endphp
                                            <a aria-label="Proxima study" href="{{ $url }}"
                                                class="sub-menu-item md:text-base lg:text-lg font-FuturaMdCnBT hover:font-semibold text-white whitespace-nowrap">{{ $menuItem['name'] }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endisset
                        </ul>
                        {{-- <div
                            class="hidden md:flex justify-end divide flex items-center
                        @if (isset($defaultLang->position) && $defaultLang->position === 'rtl') divide-0
                                        @else
                                        divide-x @endif

                        ">
                            @foreach ($data['mainMenu'] as $topMenu)
                                @if (isset($topMenu->menuDetail) && isset($topMenu->url))
                                    @php
                                        $urlWithoutString = str_replace(env('APP_URL') . '/', '', $topMenu->url);
                                    @endphp
                                    <a href="{{ url(isset($topMenu->url) ? $defaultLang['abbreviation'] . '/' . $urlWithoutString : '') }}"
                                        class="md:text-base lg:text-lg font-FuturaMdCnBT hover:font-semibold text-white whitespace-nowrap flex-1 px-1 md:px-2 lg:px-4
                                        @if (isset($defaultLang->position) && $defaultLang->position === 'rtl') last:pl-2 border-r border-white first:border-none
                                        @else
                                        last:pr-0 @endif
                                        ">
                                        {{ isset($topMenu->menuDetail[0]) ? $topMenu->menuDetail[0]->name : '' }}
                                    </a>
                                @endif
                            @endforeach
                        </div> --}}



                    </nav>
                    <!-- Mobile menu, show/hide based on menu open state. -->
                    <div id="mobile_menu" class="hidden" role="dialog" aria-modal="true">
                        <!-- Background backdrop, show/hide based on slide-over state. -->
                        <div class="fixed inset-0 z-10"></div>
                        <div
                            class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-primary px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                            <div class="flex items-center justify-between">
                                <a href="#" class="-m-1.5 p-1.5">
                                    <span class="sr-only">Your Company</span>
                                    <img class="max-w-[215px] h-auto" src="{{ asset($mainLogo) }}" alt="">
                                </a>
                                <button onclick="responsivenav()" type="button"
                                    class="-m-2.5 rounded-full border  border-white p-1 text-white">
                                    <span class="sr-only">Close menu</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-6 flow-root">
                                <div class="-my-6 divide-y divide-gray-500/10">
                                    <div class="space-y-2 py-6">
                                        @php
                                            $menu = getMainMenu($defaultLang);
                                            $menuItems = isset($menu->menuDetail[0])
                                                ? json_decode($menu->menuDetail[0]->menu_items, 1)
                                                : null;
                                        @endphp
                                        <ul class="navigation-menu text-base md:text-base lg:text-lg font-FuturaMdCnBT md:flex justify-end items-center"
                                            id="nav_items">
                                            @isset($menuItems)
                                                @foreach ($menuItems as $menuItem)
                                                    @if (count($menuItem['menus']) > 0)
                                                        <li
                                                            class="has-submenu parent-menu-item items-center flex dropdown-menu-exp">

                                                            <a aria-label="Proxima study"
                                                                href="#">{{ $menuItem['name'] }}</a><span
                                                                class="menu-arrow"></span>
                                                            @include('front.includes.navbar-child', [
                                                                'childs' => $menuItem['menus'],
                                                            ])
                                                        </li>
                                                        <li
                                                            class="has-submenu parent-menu-item dropdown-menu-exp-responsive">
                                                            <a aria-label="Proxima study" class=""
                                                                onclick="toggleCollapsible()" href="#">
                                                                <span class="flex gap-x-1 items-center">
                                                                    {{ $menuItem['name'] }}
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="3"
                                                                        stroke="currentColor" class="w-3 h-3"
                                                                        id="arrowIcon">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                                    </svg>
                                                                </span>


                                                            </a>
                                                            <div id="collapsibleContent"
                                                                class="hidden p-2 w-11/12 mx-auto bg-gray-50 rounded ">
                                                                @include(
                                                                    'front.includes.mobile-navbar-child',
                                                                    [
                                                                        'childs' => $menuItem['menus'],
                                                                    ]
                                                                )
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li class=" flex-1 py-2 px-1 md:px-2 lg:px-4 last:pr-0">

                                                            @php
                                                                $url = langBasedURL($defaultLang, $menuItem['link']);
                                                            @endphp
                                                            <a aria-label="Proxima study" href="{{ $url }}"
                                                                class="sub-menu-item text-lg font-FuturaMdCnBT hover:font-semibold text-white whitespace-nowrap">{{ $menuItem['name'] }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endisset
                                        </ul>
                                        {{-- @foreach ($data['mainMenu'] as $topMenu)
                                            @if (isset($topMenu->menuDetail) && isset($topMenu->url))
                                                @php
                                                    $urlWithoutString = str_replace(env('APP_URL') . '/', '', $topMenu->url);
                                                @endphp
                                                <a href="{{ url(isset($topMenu->url) ? $defaultLang['abbreviation'] . '/' . $urlWithoutString : '') }}"
                                                    class="-mx-3 block rounded-lg px-3 py-2 text-base font-FuturaMdCnBT leading-7 text-white hover:text-gray-200">
                                                    {{ isset($topMenu->menuDetail[0]) ? $topMenu->menuDetail[0]->name : '' }}
                                                </a>
                                            @endif
                                        @endforeach --}}
                                        <a href="{{ route('login') }}" class="can-edu-btn-outline mt-4">Login as
                                            admin </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="flex-auto">
            @yield('content')
        </div>
        @php
            $languages = getAllLanguages();
            $params = \Request::getRequestUri();
            $params = explode('?', $params);
            $params = isset($params[1]) ? $params[1] : null;
        @endphp
        @if ($languages && count($languages) > 1)
            <language-modal
                title="{{ isset(getGeneralTranslation()['language_switch_modal_title']) ? getGeneralTranslation()['language_switch_modal_title'] : 'Select website language' }}"
                :languages="{{ $languages }}" current_url="{{ \Request::url() }}"
                url_params="{{ $params }}"></language-modal>
        @endif
        <footer class="bg-gray-100  flex-initial mt-14 relative" aria-labelledby="footer-heading">
            <h2 id="footer-heading" class="sr-only">Footer</h2>
            <div class="mx-auto container py-0.5 relative w-full pb-8 pt-16 sm:pt-24">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 xl:gap-8 px-2">
                    <!-- <div class="grid grid-cols-2 gap-8 xl:col-span-3"> -->
                    <!-- <div class="md:grid md:grid-cols-2 md:gap-8"> -->
                    <div class="">
                        <div>
                            <h3 class="heading3">
                                {{ isset($data['footerSettings']->footerSettingDetail[0]->section_1_title) ? $data['footerSettings']->footerSettingDetail[0]->section_1_title : '' }}
                            </h3>
                            @php
                                $menu = $data['footerSettings']->menu_1->menuDetail;
                                $menu = $menu->where('language_id', $defaultLang['id'])->value('menu_items');
                                $menuItems = json_decode($menu, 1);
                            @endphp
                            <ul role="list" class="mt-4">
                                @foreach ($menuItems as $sec1Men)
                                    @if (isset($sec1Men) && isset($sec1Men['link']))
                                        @php
                                            $urlWithoutString = str_replace(env('APP_URL') . '/', '', $sec1Men['link']);
                                        @endphp
                                        <li>
                                            <a href="{{ url(isset($sec1Men['link']) ? $defaultLang['abbreviation'] . '/' . $urlWithoutString : '') }}"
                                                class=" leading-6 text-gray-600 hover:text-gray-900">
                                                {{ $sec1Men['name'] }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="">
                        <div class="">
                            <h3 class="heading3">
                                {{ isset($data['footerSettings']->footerSettingDetail[0]->section_2_title) ? $data['footerSettings']->footerSettingDetail[0]->section_2_title : '' }}
                            </h3>
                            @php
                                $menu = $data['footerSettings']->menu_2->menuDetail;
                                $menu = $menu->where('language_id', $defaultLang['id'])->value('menu_items');
                                $menuItems = json_decode($menu, 1);
                            @endphp
                            <ul role="list" class="mt-4">
                                @foreach ($menuItems as $sec1Men)
                                    @if (isset($sec1Men) && isset($sec1Men['link']))
                                        @php
                                            $urlWithoutString = str_replace(env('APP_URL') . '/', '', $sec1Men['link']);
                                        @endphp
                                        <li>
                                            <a href="{{ url(isset($sec1Men['link']) ? $defaultLang['abbreviation'] . '/' . $urlWithoutString : '') }}"
                                                class=" leading-6 text-gray-600 hover:text-gray-900">
                                                {{ $sec1Men['name'] }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <!-- </div> -->
                        <!-- <div class="md:grid md:grid-cols-2 md:gap-8"> -->
                    </div>
                    <div class="">
                        <div>
                            <h3 class="heading3">
                                {{ isset($data['footerSettings']->footerSettingDetail[0]->section_3_title)
                                    ? $data['footerSettings']->footerSettingDetail[0]->section_3_title
                                    : '' }}
                            </h3>
                            @php
                                $menu = $data['footerSettings']->menu_3->menuDetail;
                                $menu = $menu->where('language_id', $defaultLang['id'])->value('menu_items');
                                $menuItems = json_decode($menu, 1);
                            @endphp
                            <ul role="list" class="mt-4">
                                @foreach ($menuItems as $sec1Men)
                                    @if (isset($sec1Men) && isset($sec1Men['link']))
                                        @php
                                            $urlWithoutString = str_replace(env('APP_URL') . '/', '', $sec1Men['link']);
                                        @endphp
                                        <li>
                                            <a href="{{ url(isset($sec1Men['link']) ? $defaultLang['abbreviation'] . '/' . $urlWithoutString : '') }}"
                                                class=" leading-6 text-gray-600 hover:text-gray-900">
                                                {{ $sec1Men['name'] }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mt-10 border-gray-900/10 pt-8 md:flex md:items-center md:justify-center">
                    <!-- <div class="flex justify-center space-x-3 md:space-x-6 md:order-2"> -->
                    <div class="flex justify-center md:order-2">
                        <a href="{{ isset($data['footerSettings']->facebook_url) ? $data['footerSettings']->facebook_url : '' }}"
                            class="bg-white text-primary hover:border-primary border rounded-full w-12 h-12 items-center flex justify-center mx-1 md:mx-2.5">
                            <span class="sr-only"></span>
                            <img class="h-6"
                                src="{{ asset(isset($data['footerSettings']->facebook_icon) ? $data['footerSettings']->facebook_icon : '') }}"
                                alt="">
                        </a>

                        <a href="{{ isset($data['footerSettings']->twitter_url) ? $data['footerSettings']->twitter_url : '' }}"
                            class="bg-white text-primary hover:border-primary border rounded-full w-12 h-12 items-center flex justify-center mx-1 md:mx-2.5">
                            <span class="sr-only"></span>
                            <img class="h-5"
                                src="{{ asset(isset($data['footerSettings']->twitter_icon) ? $data['footerSettings']->twitter_icon : '') }}"
                                alt="">
                        </a>

                        <a href="{{ isset($data['footerSettings']->insta_url) ? $data['footerSettings']->insta_url : '' }}"
                            class="bg-white text-primary hover:border-primary border rounded-full w-12 h-12 items-center flex justify-center mx-1 md:mx-2.5">
                            <span class="sr-only"></span>
                            <img class="h-6"
                                src="{{ asset(isset($data['footerSettings']->insta_icon) ? $data['footerSettings']->insta_icon : '') }}"
                                alt="">
                        </a>


                        <a href="{{ isset($data['footerSettings']->linkedin_url) ? $data['footerSettings']->linkedin_url : '' }}"
                            class="bg-white text-primary hover:border-primary border rounded-full w-12 h-12 items-center flex justify-center mx-1 md:mx-2.5">
                            <span class="sr-only"></span>
                            <img class="h-5"
                                src="{{ asset(isset($data['footerSettings']->linkedin_icon) ? $data['footerSettings']->linkedin_icon : '') }}"
                                alt="">
                        </a>

                        <a href="{{ isset($data['footerSettings']->youtube_url) ? $data['footerSettings']->youtube_url : '' }}"
                            class="bg-white text-primary hover:border-primary border rounded-full w-12 h-12 items-center flex justify-center mx-1 md:mx-2.5">
                            <span class="sr-only"></span>
                            <img class="h-4"
                                src="{{ asset(isset($data['footerSettings']->youtube_icon) ? $data['footerSettings']->youtube_icon : '') }}"
                                alt="">
                        </a>
                    </div>
                </div>
            </div>
        </footer>
        <div class="p-5 text-center border-t bg-primary">
            <div class="mt-8 text-xs leading-5 text-white flex items-center justify-center md:order-1 md:mt-0">
                {!! isset($data['footerSettings']->footerSettingDetail[0]->copy_right_text)
                    ? $data['footerSettings']->footerSettingDetail[0]->copy_right_text
                    : '' !!}
            </div>
        </div>

        <button type="button" data-mdb-ripple="true" data-mdb-ripple-color="light"
            class="inline-block p-3 w-10 h-10 z-20 fixed bottom-2 right-5 bg-primary bg-opacity-70 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-red-900 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"
            id="btn-back-to-top">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" class="w-4 h-4" role="img"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path fill="currentColor"
                    d="M34.9 289.5l-22.2-22.2c-9.4-9.4-9.4-24.6 0-33.9L207 39c9.4-9.4 24.6-9.4 33.9 0l194.3 194.3c9.4 9.4 9.4 24.6 0 33.9L413 289.4c-9.5 9.5-25 9.3-34.3-.4L264 168.6V456c0 13.3-10.7 24-24 24h-32c-13.3 0-24-10.7-24-24V168.6L69.2 289.1c-9.3 9.8-24.8 10-34.3.4z">
                </path>
            </svg>
        </button>
        @php
            $cookies_allow = 0;
        @endphp
        @if (Session::has('cookies_allow') && Session::get('cookies_allow') == 1)
            @php
                $cookies_allow = Session::get('cookies_allow');
            @endphp
        @endif
        <!-- Cookie Popup -->
        @if (empty($data['cookie_allowed']))
            <div id="cookies-contest"
                class="max-w-screen-lg mx-auto fixed bottom-0 bg-white border border-gray-200 z-10 left-0 right-0 p-5 rounded-t-lg lg:rounded-lg drop-shadow-2xl flex gap-4 flex-wrap md:flex-nowrap text-center md:text-left items-center justify-center md:justify-between w-4/5">
                <div class="w-full text-sm md:text-sm lg:text-base">
                    {!! isset($data['cookieSettings']->cookieSettingDetail[0]->text) ? $data['cookieSettings']->cookieSettingDetail[0]->text : '' !!}
                    {{-- <a href="{{ isset($data['cookieSettings']->cookieSettingDetail[0]->learn_more_link) ? $data['cookieSettings']->cookieSettingDetail[0]->learn_more_link : '' }}"
                        class="text-primary text-sm md:text-base whitespace-nowrap  hover:underline">{{ isset($data['cookieSettings']->cookieSettingDetail[0]->learn_more_text) ? $data['cookieSettings']->cookieSettingDetail[0]->learn_more_text : '' }}</a> --}}
                </div>
                <div class="flex gap-4 items-center flex-shrink-0">
                    <button type="button" onclick="setcookie()"
                        class="can-edu-btn-fill">{{ isset($data['cookieSettings']->cookieSettingDetail[0]->button_text) ? $data['cookieSettings']->cookieSettingDetail[0]->button_text : '' }}</button>
                </div>
            </div>
        @endif
        <!-- Cookie Popup End -->

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Slick JS -->
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.multiple-items2').slick({
                slidesToShow: 4,  // Adjust this number to show multiple slides at once
                slidesToScroll: 1,
                autoplay: false,    // Optional: Enable auto sliding
                autoplaySpeed: 2000,  // Optional: Set the speed for auto sliding (in ms)
                arrows: true,      // Optional: Show next/prev arrows
                dots: false,
                gap: 10,         // Optional: Show dots for navigation
                prevArrow: $('.slick-prev2'),  // Use custom previous arrow
                nextArrow: $('.slick-next2'),
                responsive: [
                {
                    breakpoint: 1024,  // When screen width is less than 1024px
                    settings: {
                        slidesToShow: 2,  // Show 2 slides
                        slidesToScroll: 1,
                        arrows: true,     // Optional: Show arrows
                        dots: false,      // Optional: Show dots
                    }
                },
                {
                    breakpoint: 768,  // When screen width is less than 768px
                    settings: {
                        slidesToShow: 1,  // Show 1 slide
                        slidesToScroll: 1,
                        arrows: true,     // Optional: Show arrows
                        dots: true,       // Optional: Show dots
                    }
                },
                {
                    breakpoint: 480,  // When screen width is less than 480px
                    settings: {
                        slidesToShow: 1,  // Show 1 slide
                        slidesToScroll: 1,
                        arrows: false,    // Optional: Hide arrows on very small screens
                        dots: true,       // Optional: Show dots on small screens
                    }
                }
            ]

            });
        });
    </script>

<script type="text/javascript">
        $(document).ready(function(){
            $('.multiple-items').slick({
                slidesToShow: 4,  // Adjust this number to show multiple slides at once
                slidesToScroll: 1,
                autoplay: false,    // Optional: Enable auto sliding
                autoplaySpeed: 2000,  // Optional: Set the speed for auto sliding (in ms)
                arrows: true,      // Optional: Show next/prev arrows
                dots: false,
                gap: 10,         // Optional: Show dots for navigation
                prevArrow: $('.slick-prev'),  // Use custom previous arrow
                nextArrow: $('.slick-next'),
                responsive: [
                {
                    breakpoint: 1024,  // When screen width is less than 1024px
                    settings: {
                        slidesToShow: 2,  // Show 2 slides
                        slidesToScroll: 1,
                        arrows: true,     // Optional: Show arrows
                        dots: false,      // Optional: Show dots
                    }
                },
                {
                    breakpoint: 768,  // When screen width is less than 768px
                    settings: {
                        slidesToShow: 1,  // Show 1 slide
                        slidesToScroll: 1,
                        arrows: true,     // Optional: Show arrows
                        dots: true,       // Optional: Show dots
                    }
                },
                {
                    breakpoint: 480,  // When screen width is less than 480px
                    settings: {
                        slidesToShow: 1,  // Show 1 slide
                        slidesToScroll: 1,
                        arrows: false,    // Optional: Hide arrows on very small screens
                        dots: true,       // Optional: Show dots on small screens
                    }
                }
            ]

            });
        });
    </script>

    {{-- <script>
        window.start.init({
            Palette: "palette8",
            Theme: "wire",
            Time: "5",
        })
    </script> --}}
    <script>
        function setcookie() {
            fetch("{{ url('set-cookies') }}", {
                method: 'GET', // or 'POST', 'PUT', 'DELETE', etc.
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(data => {
                document.getElementById('cookies-contest').remove();
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
    <script src="{{ asset('/js/web.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>
    <!-- Timer -->
    <script>

        function loadScript() {
            const scriptPlaceholder = document.getElementById('script-placeholder');
            const script = document.createElement('script');
            script.src = 'https://www.google.com/recaptcha/api.js';
            scriptPlaceholder.appendChild(script);
        }

        window.addEventListener('load', function() {
            const iframeHtml = `{!! isset($customer->customerMedia->video)
                ? $customer->customerMedia->video_frame
                : '<iframe class="media-iframe" src="https://www.youtube.com/embed/xZGPCklgdGc?si=iGzu5XP5J6NNmKr9" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' !!}`;

            const iframePlaceholder = document.getElementById('iframe-placeholder');
            iframePlaceholder.innerHTML = iframeHtml;

            loadScript();
        });
        // Get the countdown container element
        const countdownContainer = document.getElementById("countdown-container");

        // Set the target date and time (adjust it according to your needs)
        const targetDate = new Date("2023-12-31T23:59:59").getTime();

        // Function to initialize the countdown
        function startCountdown() {
            // Get the current date and time
            const currentDate = new Date().getTime();

            // Calculate the time remaining
            const timeRemaining = targetDate - currentDate;

            // Calculate and update the days, hours, minutes, and seconds
            const daysElement = document.getElementById("days");
            const hoursElement = document.getElementById("hours");
            const minutesElement = document.getElementById("minutes");
            const secondsElement = document.getElementById("seconds");

            // Calculate the days, hours, minutes, and seconds remaining
            let days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
            let hours = Math.floor(
                (timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
            );
            let minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
            hours = String(hours).padStart(2, "0");
            minutes = String(minutes).padStart(2, "0");
            seconds = String(seconds).padStart(2, "0");
            // Update the HTML elements with the calculated values
            daysElement?.textContent = days;
            hoursElement?.textContent = hours;
            minutesElement?.textContent = minutes;
            secondsElement?.textContent = seconds;

            // TODO: Implement the countdown logic to update the timer every second
        }

        // ...

        // Update the countdown timer every second
        setInterval(startCountdown, 1000);

        // ...
    </script>
    <!-- Timer End -->
    <script>
        function responsivenav() {

            let NavBar = document.getElementById("mobile_menu");

            NavBar.classList.toggle("hidden");
        }
    </script>
    <script>
        function closePopup(event) {
            let modal = document.getElementById('popup-modal');
            let modalContent = document.getElementById('modal_content');
            if (modal && modalContent) {
                // Add classes for the closing animation (fade out and slide down)
                modalContent.classList.add('opacity-0', '-translate-y-5');
                // After the animation duration, hide the modal
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 500);
            }
        }
        document.getElementById('popup-modal').addEventListener('click', function (event) {
            if (event.target === this) {
                closePopup(event);
            }
        });
        
        function toggleNav() {
            let NavBar = document.getElementById("toggle_nav");
            NavBar.classList.toggle("hidden");
        }

        // Function to close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            let dropdownWrapper = document.getElementById("topbar-content3");
            let NavBar = document.getElementById("toggle_nav");
            let targetElement = event.target;

            // Check if the clicked element is not inside the dropdown or its wrapper
            if (targetElement !== NavBar && !dropdownWrapper.contains(targetElement)) {
                NavBar.classList.add('hidden');
            }
        });
    </script>
    <script>
        window.addEventListener('scroll', function() {
            var topbar = document.getElementById("topbar");
            // if (window.pageYOffset > 0) {
            if (window.scrollY > 0) {
                document.getElementById("navbar").style.padding = "12px 0";
                document.getElementById("logo_position").style.bottom = "-3px";
                document.getElementById("logo").style.width = "180px";
                document.getElementById("logo").style.opacity = "0";
                document.getElementById("logo_scroll").style.opacity = "1";
                document.getElementById("logo_scroll").style.width = "180px";
                document.getElementById("topbar").style.height = "0px";
                document.getElementById("topbar").style.padding = "0px";
                document.getElementById("topbar").style.display = "none !important";
                document.getElementById("topbar").style.transition = "all 500ms ease-in-out";
                document.getElementById("navbar").style.transition = "all 500ms ease-in-out";
                document.getElementById("logo").style.transition = "all 500ms ease-in-out";
                document.getElementById("logo_scroll").style.transition = "all 500ms ease-in-out";
                var innerContent = document.querySelectorAll("#topbar > *");
                for (var i = 0; i < innerContent.length; i++) {
                    innerContent[i].style.display = "none";
                }
                // Adjust topbar height based on screen size
                // if (window.innerWidth <= 380) {
                //   topbar.style.height = "0";
                //   topbar.style.padding = "0";
                // } else {
                //   topbar.style.height = "0";
                //   topbar.style.padding = "0";
                // }

                if (window.innerWidth <= 1024) {
                    document.getElementById("navbar").style.padding = "15px 0";
                    document.getElementById("navbar").style.transition = "all 100ms ease-in-out";
                } else {}

                if (window.innerWidth <= 425) {
                    document.getElementById("navbar").style.padding = "7px 0";
                    document.getElementById("navbar").style.transition = "all 100ms ease-in-out";
                } else {}


            } else {
                document.getElementById("navbar").style.padding = "27px 0";
                document.getElementById("navbar").style.transition = "all 500ms ease-in-out";
                document.getElementById("logo_position").style.bottom = "-1px";
                document.getElementById("logo").style.opacity = "1";
                document.getElementById("logo").style.width = "215px";
                document.getElementById("logo").style.transition = "all 500ms ease-in-out";
                document.getElementById("logo_scroll").style.opacity = "0";
                // document.getElementById("topbar").style.height = "40px";
                // document.getElementById("topbar").style.padding = "7px";
                document.getElementById("topbar").style.display = "block !important";
                // Show inner content of the topbar
                var innerContent = document.querySelectorAll("#topbar > *");
                for (var i = 0; i < innerContent.length; i++) {
                    innerContent[i].style.display = "block";
                }
                // Reset topbar height based on screen size
                if (window.innerWidth <= 380) {
                    topbar.style.height = "60px";
                    document.getElementById("navbar").style.padding = "20px 0";

                    topbar.style.padding = "5px";
                } else {
                    topbar.style.height = "40px";
                    topbar.style.padding = "7px";
                }
            }
        })
    </script>

    <script>
        // Get the button
        let mybutton = document.getElementById("btn-back-to-top");
        mybutton?.addEventListener("click", backToTop);

        function backToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>

    <script>
        const element = document.getElementsByClassName("delete");
        for (var i = 0; i < element.length; i++) {
            const elementId = element[i].id;
            const newElement = document.getElementsByClassName("section_" + elementId);

            newElement[0].addEventListener("click", () => {
                var secondText = document.getElementById("main_section_" + newElement[0].id);
                secondText.classList.add("opacity-50");
                setTimeout(() => {
                    secondText.remove()
                }, 500);
            });
        }

        const linkTag = document.getElementsByTagName('a');

        for (var i = 0; i < linkTag.length; i++) {
            const aTag = linkTag[i];
            aTag.addEventListener("click", function(e) {
                e.preventDefault();
                link = aTag.href;
                if (link.includes("{{ ENV('APP_URL') }}")) {
                    window.location.href = link;
                } else {
                    let a = document.createElement('a');
                    a.target = '_blank';
                    a.href = link;
                    a.click();
                }
            })

        }
    </script>
    <script>
        const defaultActiveTab =
            " {{ isset(getGeneralTranslation()['school_default_tab']) ? getGeneralTranslation()['school_default_tab'] : 0 }}"

        function showTab(tabNumber, page = null) {
            // Hide all tab content
            document.querySelectorAll('[id^="tab-content-"]').forEach(tabContent => tabContent.classList.add('hidden'));
            document.querySelectorAll('[id^="tab-button-"]').forEach(tabContent => tabContent.classList.remove(
                'active_button'));
            // Show the selected tab content
            if (document.getElementById('tab-content-' + tabNumber)) {
                document.getElementById('tab-content-' + tabNumber).classList.remove('hidden');
            }
            if (document.getElementById('tab-button-' + tabNumber)) {
                document.getElementById('tab-button-' + tabNumber).classList.add('active_button');
            }
            if (page === 'career') {
                document.getElementById('career-tab-1').classList.remove('border-t-4', 'border-t-primary', 'border-b-0',
                    'bg-gray-100');
                document.getElementById('career-tab-2').classList.remove('border-t-4', 'border-t-primary', 'border-b-0',
                    'bg-gray-100');
                document.getElementById('career-tab-3').classList.remove('border-t-4', 'border-t-primary', 'border-b-0',
                    'bg-gray-100');
                document.getElementById('career-tab-' + tabNumber).classList.add('border-t-4', 'border-t-primary',
                    'border-b-0', 'bg-gray-100');
            }

        }

        function changeAtiveTab(event, tabID) {
            let element = event.target;
            while (element.nodeName !== "SPAN") {
                element = element.parentNode;
            }
            ulElement = element.parentNode.parentNode;
            aElements = ulElement.querySelectorAll("li > span");
            tabContents = document.getElementById("tabs-id").querySelectorAll(
                ".tab-content > div");
            for (let i = 0; i < aElements.length; i++) {
                aElements[i].classList.remove("bg-gray-100", "py-[11px]", "border-t-4", "border-t-primary", "border-b-0");
                aElements[i].classList.add("bg-white" , "py-3");
                tabContents[i].classList.add("hidden");
                tabContents[i].classList.remove("block");
            }
            element.classList.remove("bg-white" , "py-3");
            element.classList.add("bg-gray-100", "py-[11px]", "border-t-4", "border-t-primary", "border-b-0");
            document.getElementById(tabID).classList.remove("hidden");
            document.getElementById(tabID).classList.add("block");
        }

        function hideLoading() {
            document.querySelector('.preloader').classList.add('hidden');
        }
        hideLoading();

        // function hideCookieContest(doit) {
        //     document.getElementById('cookies-contest').classList.toggle("hidden");
        //     if (doit) {
        //         @php
            //                 Session::put('cookies_allow', 1);

            //
        @endphp
        //     }

        // }
    </script>

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
    window.addEventListener('beforeunload', function() {
    if (!window.location.href.includes('login')) {
        localStorage.setItem('lastPage', window.location.href);
        
    }
});
localStorage.setItem('logoutlastPage', window.location.href);
url=localStorage.getItem('logoutlastPage')??'';
document.getElementById('logout_last_page').value =url;






</script>
    @yield('scripts')
</body>

</html>
