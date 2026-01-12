@extends('front.layouts.app')
@section('content')
    <div class="bg-white container mx-auto mt-5">
        <section class="md:w-1/2 w-full mx-auto rounded bg-white shadow relative py-20 lg:py-24 overflow-hidden">
            <div class="relative container px-4 mx-auto">

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form class="mt-4" method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <x-label for="email" :value="__('Email')" />

                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)"
                            required autofocus />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('Password')" />

                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button
                            class="can-edu-btn-fill w-56 text-white whitespace-nowrap">

                            {{ __('Reset Password') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
