@extends('front.layouts.app')
@php
$defaultLang = getDefaultLanguage(1);
$loggedInCustomer = Auth::guard('customers')->check() ? Auth::guard('customers')->user() : null;
@endphp
@section('content')
    <div class="bg-white container mx-auto">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 py-2 border-primary mt-6 w-full">
                <h1 class="can-edu-h1">{{$ambassador_name}}</h1>
            </div>
        </div>

        <div class="my-10">
            <div class="flex flex-wrap" id="tabs-id">
                <div class="w-full flex flex-col md:flex-row  items-start">
                    <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 md:flex-col md:w-56 mr-4">
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/'.$defaultLang['abbreviation'].'/chat/ambassadors') }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-primary bg-white border border-primary">
                                Ambassadors
                            </a>
                        </li>
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/'.$defaultLang['abbreviation'].'/my-ambassadors') }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal  text-white bg-primary border border-primary">
                                Inbox
                            </a>
                        </li>
                        @if ($loggedInCustomer && $loggedInCustomer->user_type === 'school' && $loggedInCustomer->package_price > 0)
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ route('web.account.school.ambassador', ['lang' => app()->getLocale(), 'slug' => auth()->guard('customers')->user()->slug]) }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-white bg-primary border border-primary">
                                Add our own ambassadors
                            </a>
                        </li>
                    @else
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="#" onclick="showWarningModal()"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-white bg-primary border border-primary">
                                Add our own ambassadors
                            </a>
                        </li>
                    @endif
                    </ul>
         




                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                        <div class="px-4 py-5 flex-auto">
                            <div class="block" id="tab-inbox">
                                @foreach ($conversations as $converstion)
                                
                                {{-- @php
                                    dd($conversations);
                                @endphp --}}
                                {{-- <a href="{{ url('/' . $defaultLang['abbreviation'] . '/ambassador/student/' . $converstion->customer->id . '/chat') }}"> --}}
                            <a href="{{ route('web.all.ambassador.student.chat', ['lang' => app()->getLocale(), 'ambassador_id' => $ambassador_id, 'id' => $converstion->customer->id]) }}">
{{-- 
                                    @php
                                        dd(url('/'.$defaultLang['abbreviation'].'/ambassador/student/' . $converstion->customer->id . '/chat'));
                                    @endphp --}}
                                        <div class="space-y-4">
                                            <div
                                                class="relative border border-gray-200 px-4 py-2 rounded shadow bg-white flex justify-between items-center">

                                                <div class="flex items-center">
                                                    <img class="object-cover w-12 h-12 rounded-full"
                                                        src="{{ asset(isset($converstion->customer->image) ? $converstion->customer->image : '') }}"
                                                        alt="" />

                                                    <div class="ml-3 overflow-hidden">
                                                        <p class="font-medium text-gray-900 text-sm"><span
                                                                class="font-semibold">{{ isset($converstion->customer->first_name) ? $converstion->customer->first_name : '' }},
                                                            </span>
                                                        </p>
                                                        <p class="max-w-xs text-sm text-gray-500 truncate">
                                                            {{ isset($converstion->customer_last_messages[0]->content) ? $converstion->customer_last_messages[0]->content : '' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="flex items-center">
                                                    {{-- <img class="object-cover w-12 h-12"
                                                        src="{{ isset($converstion->school_ambassador->school->image) ? $converstion->school_ambassador->school->image : '' }}"
                                                        alt="" /> --}}

                                                    <div class="ml-4 mobile:ml-10 flex flex-col mobile:flex-row items-center">
                                                        <span
                                                        class="bg-red-600 text-white w-4 h-4 flex items-center justify-center mr-3 text-sm rounded-full">{{ count($converstion->unAmbassadorSeenmessages) > 0 ? count($converstion->unAmbassadorSeenmessages) : 0 }}</span>
                                                        <p class="max-w-xs text-sm text-gray-500 truncate">
                                                            {{ isset($converstion->customer_last_messages[0]->created_at) ? $converstion->customer_last_messages[0]->created_at->diffForHumans() : '' }}

                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="warningModal"
            class="hidden bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4">
            <div class="relative w-full h-full max-w-lg flex items-center justify-center">
                <div class="bg-white py-6 px-10 rounded shadow-lg text-center relative">
                    <button class="absolute top-3 right-3" onclick="closeWarningModal()">
                        <div class="text-gray-400 bg-transparent cursor-pointer hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </button>
                    <p class="text-center can-edu-p mt-4">
                        This feature is only available for premium and featured schools.
                    </p>
                    <button type="button" class="can-edu-btn-fill whitespace-nowrap px-5 mt-4"
                        onclick="closeWarningModal()">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
    <script>
        function showWarningModal(event) {
            if (event) event.preventDefault(); // Prevents the link from opening a new tab
            document.getElementById('warningModal').classList.remove('hidden');
        }

        function closeWarningModal() {
            document.getElementById('warningModal').classList.add('hidden');
        }
        document.addEventListener("click", function(event) {
            let modal = document.getElementById("warningModal");

            // Make sure modal is visible before checking
            if (!modal.classList.contains("hidden") && event.target === modal) {
                closeWarningModal();
            }
        });
    </script>
@endsection
@endsection
