@extends('front.layouts.account')
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full relative">
        <h2 class="px-4 pt-4 can-school-h2 text-primary">Suggested Programs</h1>
        <div class="p-4">
            @if (count($programs) > 0)
            <div class="absolute top-4 right-3 text-center flex justify-between items-center">
                {{-- <button class="can-edu-btn-fill flex-grow mx-2">
                    Explore programs
                </button> --}}
                <a href="{{ url(app()->getLocale().'/programs') }}" class="flex-grow mx-2">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                        Explore programs
                    </button>
                </a>
                <a href="{{ url(app()->getLocale().'/programs?slug='.$getSlug.'') }}" class="flex-grow mx-2">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                        Suggest programs
                    </button>
                </a>
            </div>
                @foreach ($programs as $program)
                    <div class="grid grid-cols-12 md:grid-cols-12 lg:grid-cols-12 gap-4 p-4 mt-4 border rounded-md shadow">
                        <div class="md:col-span-12 col-span-12">
                            <div>
                                <p class="text-xl lg:text-2xl font-FuturaMdCnBT">
                                    {{ isset($program) ? $program->name : '' }}
                                </p>
                                @php
                                    $url = url('/'.getDefaultLanguage(1)['abbreviation'].'/program/' . $program->program->id);
                                @endphp
                                <div class="mt-4 flex justify-end gap-2">
                                    <a href="{{ $url }}"><button class="can-edu-btn-fill">View</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="md:col-span-8 col-span-12 w-full">
                    <div class="py-4">
                        <p>You do not have any programs yet</p>
                        <div class="absolute top-4 right-3 text-center flex justify-between items-center">
                            <a href="{{ url(app()->getLocale().'/programs') }}" class="flex-grow mx-2">
                                <button class="can-edu-btn-fill flex-grow mx-2">
                                    Explore programs
                                </button>
                            </a>

                            <a href="{{ url(app()->getLocale().'/programs?slug='.$getSlug.'') }}" class="flex-grow mx-2">
                                <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                                    Suggest programs
                                </button>
                            </a>
                            
                            <a href="{{ url(app()->getLocale().'/programs') }}" class="flex-grow mx-2">
                                <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                                    Create your own program
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
