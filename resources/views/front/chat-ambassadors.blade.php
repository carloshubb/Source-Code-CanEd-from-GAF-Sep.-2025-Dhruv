@extends('front.layouts.app')
@section('content')
    <?php
    $defaultLang = getDefaultLanguage(1);
    $ambassadorTranslations = getStaticTranslation('ambassadors');
    $lang = $defaultLang['abbreviation'];
    $loggedInCustomer = Auth::guard('customers')->check() ? Auth::guard('customers')->user() : null;
    ?>
    <div class="bg-white container mx-auto">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-end gap-3">
            <div class="border-b-4 py-2 border-primary mt-6 w-full">
                <h1 class="can-edu-h1">Chat with ambassadors</h1>
            </div>
            <div
            class="flex flex-col sm:flex-row w-full md:w-auto md:flex-row lg:flex-row gap-4 justify-between lg:justify-end items-center">
            <form action="{{ url('/' . $defaultLang['abbreviation'] . '/ambassador-search') }}">
                <div
                    class="relative md:-mb-4 flex items-center border-collapse border border-gray-300 rounded {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-0' : 'border-l-0' }}">
                    <input type="search" name="search"
                        placeholder="Ambassadors"
                        class=" focus:outline-none focus:ring-primary rounded bg-white  px-3 border-y-0 border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-4 rounded-r border-r-primary' : 'border-l-4 rounded-l border-l-primary' }} ">
                    <button type="submit" class="bg-gray-100 p-1.5 rounded-r h-full absolute right-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </div>
            </form>
            </div>
        </div>

        <div class="my-10">
            <div class="flex flex-wrap" id="tabs-id">
                <div class="w-full flex flex-col md:flex-row items-start">
                    <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 md:flex-col md:w-56 mr-4">
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/' . $defaultLang['abbreviation'] . '/chat/ambassadors') }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-white bg-primary border border-primary">
                                Ambassadors
                            </a>
                        </li>
                        <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ url('/' . $defaultLang['abbreviation'] . '/my-ambassadors') }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal  text-primary bg-white border border-primary">
                                Inbox
                            </a>
                        </li>
                        {{-- <li class="-mb-px mr-2 flex-auto text-center">
                            <a href="{{ route('web.account.school.ambassador', ['lang' => app()->getLocale()]) }}"
                                class="font-bold mb-4 px-5 py-3 shadow-md rounded block leading-normal text-white bg-primary border border-primary">
                                Add our own ambassadors
                            </a>
                        </li> --}}
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
                            <div class="block" id="tab-profile">
                            <ambassadors-component lang="{{ $lang }}"
                                    ambassador_translations="{{ $ambassadorTranslations }}" school="{{ $schoolId }}" showTitle='0'
                                    ambasssadors="{{ $ambassadors }}" />
                            </div>

                        </div>
                    </div>
                    <div id="warningModal" class="hidden bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4">
                        <div class="relative w-full h-full max-w-lg flex items-center justify-center">
                            <div class="bg-white py-6 px-10 rounded shadow-lg text-center relative">
                                <div class="absolute top-2 right-2">
                                    <button type="button" onclick="closeWarningModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                        <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-center can-edu-p mt-4">
                                    This feature is only available for premium and featured schools.
                                </p>
                                <button type="button" class="can-edu-btn-fill whitespace-nowrap px-5 mt-4" onclick="closeWarningModal()">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
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
    document.addEventListener("click", function (event) {
        let modal = document.getElementById("warningModal");

        // Make sure modal is visible before checking
        if (!modal.classList.contains("hidden") && event.target === modal) {
            closeWarningModal();
        }
    });
</script>
@endsection
@endsection
