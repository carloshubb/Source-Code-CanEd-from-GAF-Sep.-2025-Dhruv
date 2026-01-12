@php
    $defaultLang = getDefaultLanguage(1);
@endphp
@if (isset($defaultLang->position) && $defaultLang->position == 'ltr')
    @if ($paginator->total() > $paginator->perPage())
        <ul class="pagination flex space-x-2 justify-end">
            @if ($paginator->onFirstPage())
                <li class="pagination-item disabled  order-first">
                    <span
                        class=" flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded bg-gray-50 border text-gray-600 cursor-not-allowed  ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 lg:w-6 h-5 lg:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </span>
                </li>
            @else
                <li class="pagination-item  order-first">
                    <a href="{{ $paginator->previousPageUrl() }}{{ isset($type) ? '&type=' . $type : '' }}"
                        rel="prev"
                        class=" flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded bg-white text-primary hover:bg-primary hover:text-white border border-primary transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 lg:w-6 h-5 lg:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </a>
                </li>
            @endif

            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                $onEachSide = 1; 
            @endphp

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="pagination-item disabled">
                        <span
                            class=" flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded bg-gray-50 border text-gray-600 cursor-not-allowed">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination-item">
                                <span
                                    class=" flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded bg-primary text-white border border-primary">{{ $page }}</span>
                            </li>
                        @elseif ($page <= 2 || $page >= $lastPage - 1 || ($page >= $currentPage - $onEachSide && $page <= $currentPage + $onEachSide))
                            <li class="pagination-item">
                                <a href="{{ $url }}{{ isset($type) ? '&type=' . $type : '' }}"
                                    class=" flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded bg-white text-gray-600 border hover:bg-primary hover:text-white hover:border-primary transition duration-200">{{ $page }}</a>
                            </li>
                        @elseif (($page == 3 && $currentPage > 3 + $onEachSide) || ($page == $lastPage - 2 && $currentPage < $lastPage - 2 - $onEachSide))
                            <li class="pagination-item disabled">
                                <span
                                    class=" flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded bg-gray-50 border text-gray-600 cursor-not-allowed">...</span>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="pagination-item  order-last">
                    <a href="{{ $paginator->nextPageUrl() }}{{ isset($type) ? '&type=' . $type : '' }}" rel="next"
                        class=" flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded border bg-white text-primary border-primary hover:bg-primary hover:text-white transition duration-200 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 lg:w-6 h-5 lg:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </li>
            @else
                <li class="pagination-item disabled  order-last">
                    <span
                        class=" flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded border bg-gray-50 text-gray-600 cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 lg:w-6 h-5 lg:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </span>
                </li>
            @endif
        </ul>
    @endif
@endif

@if (isset($defaultLang->position) && $defaultLang->position == 'rtl')
    @if ($paginator->total() > $paginator->perPage())
        <ul class="pagination flex space-x-2 justify-end">
            @if ($paginator->onFirstPage())
                <li class="pagination-item disabled  order-first">
                    <span
                        class=" flex items-center ml-2 justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded bg-gray-50 border text-gray-600 cursor-not-allowed  ">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 lg:w-6 h-5 lg:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </span>
                </li>
            @else
                <li class="pagination-item  order-first">
                    <a href="{{ $paginator->previousPageUrl() }}{{ isset($type) ? '&type=' . $type : '' }}"
                        rel="prev"
                        class=" flex items-center justify-center w-8 md:w-10 ml-2 h-8 md:h-10 text-base lg:text-lg rounded bg-white text-primary hover:bg-primary hover:text-white border border-primary transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 lg:w-6 h-5 lg:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </li>
            @endif

            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                $onEachSide = 1; 
            @endphp

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="pagination-item disabled">
                        <span
                            class=" flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded bg-gray-50 border text-gray-600 cursor-not-allowed">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination-item">
                                <span
                                    class=" flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded bg-primary text-white border border-primary">{{ $page }}</span>
                            </li>
                        @elseif ($page <= 2 || $page >= $lastPage - 1 || ($page >= $currentPage - $onEachSide && $page <= $currentPage + $onEachSide))
                            <li class="pagination-item">
                                <a href="{{ $url }}{{ isset($type) ? '&type=' . $type : '' }}"
                                    class=" flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded bg-white text-gray-600 border hover:bg-primary hover:text-white hover:border-primary transition duration-200">{{ $page }}</a>
                            </li>
                        @elseif (($page == 3 && $currentPage > 3 + $onEachSide) || ($page == $lastPage - 2 && $currentPage < $lastPage - 2 - $onEachSide))
                            <li class="pagination-item disabled">
                                <span
                                    class=" flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded bg-gray-50 border text-gray-600 cursor-not-allowed">...</span>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="pagination-item order-last">
                    <a href="{{ $paginator->nextPageUrl() }}{{ isset($type) ? '&type=' . $type : '' }}" rel="next"
                        class=" flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded border bg-white text-primary border-primary hover:bg-primary hover:text-white transition duration-200 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 lg:w-6 h-5 lg:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </a>
                </li>
            @else
                <li class="pagination-item disabled order-last">
                    <span
                        class=" flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded border bg-gray-50 text-gray-600 cursor-not-allowed">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 lg:w-6 h-5 lg:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </span>
                </li>
            @endif
        </ul>
    @endif
@endif