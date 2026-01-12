@extends('front.layouts.app')
@php
    $defaultLang = getDefaultLanguage(1);
@endphp
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <section class="md:w-1/2 w-full mx-auto">
            <div class="border-b-4 pb-2 border-primary mb-4">
                <h1 class="can-edu-h1">
                    {{ isset($forgetPassowrdTranslations['page_title']) ? $forgetPassowrdTranslations['page_title'] : '' }}
                </h1>
            </div>
            <div class="relative container px-0 mx-auto">
                <div class="max-w-lg lg:max-w-3xl xl:max-w-5xl mx-auto text-base lg:text-lg">
                    {{ isset($forgetPassowrdTranslations['forget_page_description']) ? $forgetPassowrdTranslations['forget_page_description'] : '' }}
                </div>
                @if (Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('message') }}
                    </div>
                @endif

                <form action="{{ route('forget.password.post') }}" method="POST">
                    @csrf
                    <div class="form-group row mt-2">
                        {{-- <label for="email_address"
                            class="block text-base lg:text-lg">{{ isset($forgetPassowrdTranslations['forget_email_label']) ? $forgetPassowrdTranslations['forget_email_label'] : '' }}</label> --}}
                        <div class="col-md-6">
                            <input type="text"
                                placeholder="{{ isset($forgetPassowrdTranslations['forget_email_placeholder']) ? $forgetPassowrdTranslations['forget_email_placeholder'] : '' }}"
                                id="email_address"
                                class="form-control w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300
                                {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}"
                                name="email" autofocus oninput="removeErrorMessage()">

                                @error('email')
                      <div class="relative tooltip -bottom-4 group-hover:flex">
                        <div role="tooltip" class="relative tooltiptext -top-2 z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-primary text-gray-600 w-full md:w-1/2 rounded" >
                            <p class="text-white leading-none text-sm lg:text-base">{{ $message }}</p>
                        </div>
                      </div>
                    @enderror

                            {{-- @if ($errors->has('email'))


                            
                                <div id="error-message"
                                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-2"
                                    role="alert">
                                    <span class="block sm:inline">
                                        {{ isset($forgetPassowrdTranslations['forget_email_error']) ? $forgetPassowrdTranslations['forget_email_error'] : 'An error occurred.' }}
                                    </span>
                                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="removeErrorMessage()">
                                        <svg class="fill-current h-6 w-6 text-red-500" role="button"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path
                                                d="M14.348 14.849a1 1 0 0 1-1.415 0L10 11.415l-2.933 2.934a1 1 0 1 1-1.415-1.415l2.934-2.933L5.651 7.068a1 1 0 1 1 1.415-1.415L10 8.585l2.933-2.934a1 1 0 0 1 1.415 1.415l-2.934 2.933 2.934 2.933a1 1 0 0 1 0 1.415z" />
                                        </svg>
                                    </span>
                                </div>
                            @endif --}}
                        </div>
                    </div>
                    <div class="col-md-6 offset-md-4 mt-4">
                        <button type="submit" class="can-edu-btn-fill">
                            {{ isset($forgetPassowrdTranslations['forget_button_text']) ? $forgetPassowrdTranslations['forget_button_text'] : '' }}
                        </button>
                    </div>
                </form>
                <div id="warningModal"
                    class="hidden bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4">
                    <div class="relative w-full h-full max-w-lg flex items-center justify-center">
                        <div class="bg-white py-6 px-10 rounded shadow-lg text-center relative">
                            <div class="absolute top-3 right-3">
                                <button onclick="closeWarningModal()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                    <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-center can-edu-p mt-4" id="can-edu-p"></p> <!-- The success message will be injected here -->
                            <button type="button" class="can-edu-btn-fill whitespace-nowrap px-5 mt-4"
                                onclick="closeWarningModal()">
                                Close
                            </button>
                        </div>
                    </div>
                </div>

            </div>
    </div>
    </div>

    <script>
        function removeErrorMessage() {
            const errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const emailField = document.getElementById('email_address');
            const errorDiv = document.getElementById('error-message');

            if ({{ $errors->has('email') ? 'true' : 'false' }}) {
                errorDiv.classList.remove('hidden');
            }

            emailField.addEventListener('input', removeErrorMessage);
        });


        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form");
            const modal = document.getElementById("warningModal");
            const modalText = modal.querySelector("p");
            const closeButton = modal.querySelector("button");
            const closeIcon = modal.querySelector("svg");


            if (sessionStorage.getItem("successMessage")) {
                showWarningModal(sessionStorage.getItem("successMessage"));
                sessionStorage.removeItem("successMessage");
            }

            // form.addEventListener("submit", function(event) {
            //     event.preventDefault();

            //     const formData = new FormData(form);

            //     fetch("{{ route('forget.password.post') }}", {
            //             method: "POST",
            //             headers: {
            //                 "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
            //                 "Accept": "application/json",
            //             },
            //             body: formData,
            //         })
            //         .then((response) => response.json())
            //         .then((data) => {
            //             if (data.message) {
            //                 sessionStorage.setItem("successMessage", data.message);
            //                 location.reload();
            //             }
            //         })
            //         .catch((error) => console.error("Error:", error));
            // });

            function showWarningModal(message) {
                modalText.textContent = message;
                modal.classList.remove("hidden");


                closeButton.addEventListener("click", closeWarningModal);
                closeIcon.addEventListener("click", closeWarningModal);


                modal.addEventListener("click", function(event) {
                    if (event.target === modal) {
                        closeWarningModal();
                    }
                });
            }

        });
        function closeWarningModal() {
    const modal = document.getElementById("warningModal");
        
            modal.classList.add("hidden");
        }
    </script>


<script>
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function () {
            // Set the success message inside the modal
            document.getElementById('can-edu-p').textContent = '{{ session('success') }}';

            // Show the modal
            document.getElementById('warningModal').classList.remove('hidden');

        });
    @endif
</script>


@endsection
