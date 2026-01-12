<nav id="topnav" class="defaultscroll is-sticky bg-gray-100 shadow-lg">
    <div class="container">
        <!-- Logo container-->
        <a class="logo pl-0" href="/">
            <span class="inline-block dark:hidden">
                <img src="{{asset('assets/images/logo.png')}}" class="l-dark h-16" alt="">
                <img src="{{asset('assets/images/logo.png')}}" class="l-light h-16" alt="">
            </span>
            <img src="{{asset('assets/images/logo.png')}}" class="hidden dark:inline-block h-16" alt="">
        </a>

        <!-- End Logo container-->
        <div class="menu-extras">
            <div class="menu-item">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </div>
        </div>

        <!--Login button Start-->
        <ul class="buy-button list-none mb-0 font-Futura">
        @auth('customers')
            <li class="inline mb-0">
                <div class="relative inline-flex align-middle">
                    <button type="button" class="flex space-x-2 items-center menu font-Futura text-sm lg:text-base text-gray-800  hover:text-primary font-medium transition duration-300 p-1 lg:p-2"
                        onclick="openDropdown(event,'dropdown-id2')">
                        <span class="font-semibold text-md">Welcome</span>
                        <div class="dropdown-toggle w-10 h-10 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110" role="button" aria-expanded="false" data-tw-toggle="dropdown"><img alt="user" src="https://ui-avatars.com/api/?name={{auth()->guard('customers')->user()->name}}&amp;color=7F9CF5&amp;background=EBF4FF"></div>
                    </button>
                    <div class="hidden bg-white divide-y z-50 float-left py-2 list-none text-left rounded shadow-lg mt-1"
                        style="min-width:12rem" id="dropdown-id2">
                        <a href="{{route('user.account-settings.index')}}"
                            class="menu font-FuturaBold text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                            Account Settings
                        </a>
                        <a href="{{route('user.buissness-settings.index')}}"
                            class="menu font-FuturaBold text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                            Business profile setting
                        </a>
                        <a href="#"
                            class="menu font-FuturaBold text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                            Media Setting
                        </a>
                        <a href="{{route('user.social-media-settings.index')}}"
                            class="menu font-FuturaBold text-sm lg:text-base py-2 px-4 block w-full whitespace-nowrap bg-transparent text-slate-700">
                            Social Media Setting
                        </a>
                        <a href="{{ url('/dashboard') }}" class="ml-4 btn bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-full" onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();">Logout</a>
                        <form id="user-logout-form" action="{{ route('web.user.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </li>
        @endauth
        @guest('customers')
            <li class="inline mb-0">
                <a href="{{url('/signin')}}" class="btn bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-full">Log in</a>
            </li>
            <li class="inline pl-1 mb-0">
                <a href="{{ route('web.signup') }}" class="btn bg-primary/5 hover:bg-primary border-primary/10 hover:border-primary text-primary hover:text-white rounded-full">Register</a>
            </li>
        @endguest
    </ul>

        <!--Login button End-->

        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu font-FuturaBold">
                <li class="has-submenu parent-menu-item">
                    <a href="javascript:void(0)">About Us</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a href="/about" class="sub-menu-item">About us</a></li>
                        <li><a href="/contact" class="sub-menu-item">Contact us</a></li>
                        <li><a href="/how-do-we-delete-our-profile" class="sub-menu-item">How do we delete our profile</a></li>
                        <li><a href="/how-the-business-categories-came-about" class="sub-menu-item">How the business categories came about</a></li>
                        <li><a href="/inquiries-to-buy" class="sub-menu-item">Inquiries to buy</a></li>
                        <li><a href="/scam-alerts" class="sub-menu-item">Scam alerts</a></li>
                        <li><a href="/success-stories" class="sub-menu-item">Success stories</a></li>

                    </ul>
                </li>
                <li><a href="/testimonials" class="sub-menu-item">Testimonials</a></li>
                <li><a href="/info-letter" class="sub-menu-item">Info-Letter</a></li>
                <li><a href="/resources" class="sub-menu-item">Resources</a></li>
            </ul>
        </div>
    </div>
</nav>