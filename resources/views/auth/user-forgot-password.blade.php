@extends('front.layouts.app')
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <section class="md:w-1/2 w-full mx-auto">
        <div class="border-b-4 pb-2 border-primary mb-4">
                <h1 class="can-edu-h1">
                    {{-- Forgot Password --}}
                    {{ isset($forgetPassowrdTranslations['page_title']) ? $forgetPassowrdTranslations['page_title'] : '' }}
                </h1>
            </div>
            <div class="relative container px-0 mx-auto">
                <div class="max-w-lg lg:max-w-3xl xl:max-w-5xl mx-auto text-base lg:text-lg">
                    {{ isset($forgetPassowrdTranslations['forget_page_description']) ? $forgetPassowrdTranslations['forget_page_description'] : '' }}
                </div>
                
                <!-- Session Status -->


                <form id="password-reset-form" class="mt-4" method="POST" action="{{ route('user.password.email') }}">
                    @csrf
                    <!-- Email Address -->
                    <div class="relative">
                        <x-label for="email" :value="isset($forgetPassowrdTranslations['forget_email_label']) ? $forgetPassowrdTranslations['forget_email_label'] : __('Email')" />

                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                            required autofocus :placeholder="isset($forgetPassowrdTranslations['forget_email_placeholder']) ? $forgetPassowrdTranslations['forget_email_placeholder'] : __('Enter your email')"  />
                            
                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <ul id="errordiv" class="hidden mt-3 list-none list-inside text-sm text-red-600">
                                {{-- <li>{{ $error }}</li> --}}
                                <li>
                                    <div class="relative tooltip -bottom-4 group-hover:flex" >
                                        <div role="tooltip"
                                            class="relative tooltiptext -top-2 z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-red-100 border border-primary text-gray-600 w_full w-fit md:w_half rounded ">
                                            <p id="error" class="text-primary leading-none text-left text-sm lg:text-base">ddddddddddddddd</p>
                                        </div>
                                    </div>
                                </li>
                        </ul>
                    </div>

                    <div class="flex items-center justify-center mt-6">
                        <x-button
                            class="can-edu-btn-fill text-white text-center whitespace-nowrap">
                            {{ isset($forgetPassowrdTranslations['forget_button_text']) ? $forgetPassowrdTranslations['forget_button_text'] : '' }}
                            
                        </x-button>
                    </div>
                </form>
                
            </div>
            
        </div>
        <div id="warningModal" class="hidden bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4">
            <div class="relative w-full h-full max-w-lg flex items-center justify-center">
                <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl border-4 border-primary/30 text-center relative">
                    <div class="absolute top-3 right-3" onclick="closeWarningModal()">
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                            <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <p id="modal-status-message" class="text-center can-edu-p mt-6"></p>
                    <p class="text-center can-edu-p mt-4">
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                    </p>
                    <button type="button" class="can-edu-btn-fill whitespace-nowrap px-5 mt-4" onclick="closeWarningModal()">
                        Close
                    </button>
                </div>
            </div>
        </div>
        </div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  <!-- Include jQuery -->

<script>
$(document).ready(function () {
    const $form = $('#password-reset-form');
    const $modal = $('#warningModal');
    const $modalMessage = $('#modal-status-message');
    const $emailInput = $('#email'); 
    const $error = $('#error'); 
      // Show Modal
      function showWarningModal() {
        $modal.removeClass('hidden');
        setTimeout(() => {
            $modal.addClass('show');
        }, 10);
    }

    // Close Modal
    function closeWarningModal() {
        $modal.removeClass('show');
        setTimeout(() => {
            $modal.addClass('hidden');
        }, 1000);
        $emailInput.val('');
        window.location.reload();
    }

    // Close Modal when clicking outside
    document.addEventListener("click", function (event) {
        let modal = document.getElementById("warningModal");
        if (!modal.classList.contains("hidden") && event.target === modal) {
            closeWarningModal();
        }
    });

    $form.on('submit', function(event) {
        event.preventDefault();
        
        const formData = new FormData($form[0]);
        
        // $.ajax({
        //     url: $form.attr('action'),
        //     method: 'POST',
        //     data: formData,
        //     contentType: false,
        //     processData: false,
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     success: function(data) {
        //         console.log('errorrrrrrrrrrrr',messages[0])
        //         if (data.errors) {
        //     $.each(data.errors, function(field, messages) {
        //         if (field === 'email') {
        //             console.log('errorrrrrrrrrrrr',messages[0])
        //             $('#error').text(messages[0]); 
        //         }
        //     });
        // } 
        //        else if (data.status === 'success') {
        //             $modalMessage.text(data.message);
        //             $modalMessage.removeClass('text-red-500').addClass('text-green-500');
        //             showWarningModal();
        //         } else {
        //            window.location.reload()
        //         }
        //     },
         
        // });
        $.ajax({
    url: $form.attr('action'),
    method: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(data) {
        console.log('data',data)
         if (data.status === 'success') {
                    $modalMessage.text(data.message);
                    $modalMessage.removeClass('text-red-500').addClass('can-edu-p');
                    showWarningModal();
                } else {
                   window.location.reload()
                }
         
    },
    error: function(xhr, status, error) {
        if (xhr.status === 422) {
            try {
                const data = JSON.parse(xhr.responseText);
                if (data.errors) {
                    $.each(data.errors, function(field, messages) {
                        if (field === 'email') {
                            $('#errordiv').removeClass('hidden')
                            console.log('Error with email:', messages[0]);
                            $('#error').text(messages[0]); 
                        }
                    });
                }
            } catch (e) {
                console.error('Error parsing the response:', e);
                $('#error').text('An unexpected error occurred.');
            }
        } else {
            console.error('AJAX error:', error);
            $('#error').text('An error occurred while processing your request.');
        }
    }
});

    });

    window.closeWarningModal = closeWarningModal; 
});

</script>


@endsection
