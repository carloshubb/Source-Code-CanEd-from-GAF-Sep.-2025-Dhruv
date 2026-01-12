@extends('front.layouts.app')
@section('content')
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
            <div class="border-b-4 pb-2 border-primary w-full">
                <h1 class="can-edu-h1">
                    Schools - {{ isset($degree->degreeDetail[0]->name) ? $degree->degreeDetail[0]->name : '' }}
                </h1>
            </div>
        </div>


        <div class="mt-10">
            @if ($schools->where('package_type', 'featured')->count())
                <p class="mt-5 can-edu-h1 mt-5">
                    Featured Schools
                </p>
            @endif
            <div class="mt-5 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($schools as $school)
                    @if ($school->package_type == 'featured')
                        <a href="{{ url('/school/' . $school->id) }}">
                            <div class="border shadow">
                                <div class="h-40 bg-gray-50 border"> <img class="w-full object-cover h-full"
                                        src="{{ asset(thumbnailImage($school->image)) }}" alt=""></div>
                                <div class="bg-primary rouned-none hover:bg-secondaryRed py-2 px-3 w-full">
                                    <p class="text-white truncate font-FuturaMdCnBT text-center">
                                        {{ isset($school->schoolDetail[0]->school_name) ? $school->schoolDetail[0]->school_name : '' }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
            @if ($schools->where('package_type', 'premium')->count())
                <p class="mt-5 can-edu-h1 mt-5">
                    Premium Schools
                </p>
            @endif
            <div class="mt-5 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($schools as $school)
                    @if ($school->package_type == 'premium')
                        <a href="{{ url('/school/' . $school->id) }}">
                            <div class="border shadow">
                                <div class="h-40 bg-gray-50 border"> <img class="w-full object-cover h-full"
                                        src="{{ asset(thumbnailImage($school->image)) }}" alt=""></div>
                                <div class="bg-primary rouned-none hover:bg-secondaryRed py-2 px-3 w-full">
                                    <p class="text-white truncate font-FuturaMdCnBT text-center">

                                        {{ isset($school->schoolDetail[0]->school_name) ? $school->schoolDetail[0]->school_name : '' }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
            @if ($schools->where('package_type', 'free')->count())
                <p class="mt-5 can-edu-h1 mt-5">
                    More Schools
                </p>
            @endif
            <div class="mt-5 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($schools as $school)
                    @if ($school->package_type == 'free')
                        <a href="{{ url('/school/' . $school->id) }}">
                            <div class="border shadow">
                                <div class="h-40 bg-gray-50 border"> <img class="w-full object-cover h-full"
                                        src="{{ asset(thumbnailImage($school->image)) }}" alt=""></div>
                                <div class="bg-primary rouned-none hover:bg-secondaryRed py-2 px-3 w-full">
                                    <p class="text-white truncate font-FuturaMdCnBT text-center">

                                        {{ isset($school->schoolDetail[0]->school_name) ? $school->schoolDetail[0]->school_name : '' }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>

        </div>

    </div>
@endsection
