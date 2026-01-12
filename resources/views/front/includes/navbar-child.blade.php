<ul class="submenu">
    @foreach ($childs as $child)
        @if (count($child['menus']) > 0)
            <li class="has-submenu parent-menu-item flex items-center justify-between">
                <a aria-label="Proxima study" href="#">{{ $child['name'] }}</a>
                {{-- <span class="menu-arrow"></span> --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 pr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>

                @include('front.includes.navbar-child', ['childs' => $child['menus']])
            </li>
        @else
            @php
                $url = langBasedURL(getDefaultLanguage(1), $child['link']);
            @endphp
            <li><a aria-label="Proxima study" href="{{ $url }}" class="sub-menu-item">{{ $child['name'] }}</a></li>
        @endif
    @endforeach
</ul>
