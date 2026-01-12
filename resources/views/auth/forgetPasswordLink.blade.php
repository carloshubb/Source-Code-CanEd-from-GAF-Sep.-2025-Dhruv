@extends('front.layouts.app')
@php
$defaultLang = getDefaultLanguage(1);
@endphp
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <section class="md:w-1/2 w-full mx-auto">
            <div class="border-b-4 pb-2 border-primary mb-4">
                <h1 class="can-edu-h1">
                    {{ isset($forgetPassowrdTranslations['reset_page_title']) ? $forgetPassowrdTranslations['reset_page_title'] : '' }}
                </h1>
            </div>
            <div class="relative container px-0 mx-auto">
                @if (Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('message') }}
                    </div>
                @endif
                <form action="{{ url('/password-reset') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="lang" value="{{ $lang }}">

                    
                    <div class="form-group row mt-4">
                        <label for="email_address"
                            class="block text-base lg:text-lg">{{ isset($forgetPassowrdTranslations['reset_email_text']) ? $forgetPassowrdTranslations['reset_email_text'] : '' }}</label>
                        <div class="col-md-6">
                            <input type="text"
                                placeholder="{{ isset($forgetPassowrdTranslations['reset_email_placeholder']) ? $forgetPassowrdTranslations['reset_email_placeholder'] : '' }}"
                                id="email_address" class="form-control w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 
                                {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}" name="email" required autofocus>
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mt-4">
                        <label for="password"
                            class="block text-base lg:text-lg">{{ isset($forgetPassowrdTranslations['reset_password_text']) ? $forgetPassowrdTranslations['reset_password_text'] : '' }}</label>
                        <div class="col-md-6">
                            <input type="password" id="password"
                                placeholder="{{ isset($forgetPassowrdTranslations['reset_password_placeholder']) ? $forgetPassowrdTranslations['reset_password_placeholder'] : '' }}"
                                class="form-control w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 
                                {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}" name="password" required autofocus>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mt-4">
                        <label for="password-confirm"
                            class="block text-base lg:text-lg">{{ isset($forgetPassowrdTranslations['reset_confirm_password_text']) ? $forgetPassowrdTranslations['reset_confirm_password_text'] : '' }}</label>
                        <div class="col-md-6">
                            <input type="password" id="password-confirm"
                                placeholder="{{ isset($forgetPassowrdTranslations['reset_confirm_password_placeholder']) ? $forgetPassowrdTranslations['reset_confirm_password_placeholder'] : '' }}"
                                class="form-control w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 
                                {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}" name="password_confirmation" required autofocus>
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 offset-md-4 mt-4">
                        <button type="submit" class="can-edu-btn-fill mt-4">
                            {{ isset($forgetPassowrdTranslations['reset_button_text']) ? $forgetPassowrdTranslations['reset_button_text'] : '' }}
                        </button>
                    </div>
                </form>
                @if(Session::has('show_success_popup'))
                <div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                    <div class="bg-white rounded-2xl shadow-2xl border-4 border-primary/30 max-w-lg w-full p-6 mx-4 relative">
                        <div class="text-right absolute top-3 right-3">
                            <button onclick="closeSuccessModalAndRedirect()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="text-center pt-5">
                            <p class="text-center can-edu-p mt-2">
                                Your password has been changed successfully!
                            </p>
                            <button onclick="closeSuccessModalAndRedirect()" 
                                class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4">
                                OK
                            </button>
                        </div>
                    </div>
                </div>
                @endif

            </div>
    </div>
    </div>
@endsection
@section('scripts')
<script>
    // Show modal when page loads if success condition exists
    document.addEventListener('DOMContentLoaded', function() {
        @if(Session::has('show_success_popup'))
            showSuccessModal();
        @endif
    });

    function showSuccessModal() {
        const modal = document.getElementById('successModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }

    function closeSuccessModalAndRedirect() {
        const modal = document.getElementById('successModal');
        modal.classList.remove('show');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 1000);
        window.location.href = '/{{ $lang }}/login';
    }

    // Close modal when clicking outside
    document.addEventListener("click", function(event) {
        const modal = document.getElementById("successModal");
        if (!modal.classList.contains("hidden") && event.target === modal) {
            closeSuccessModalAndRedirect();
        }
    });
</script>
@endsection
