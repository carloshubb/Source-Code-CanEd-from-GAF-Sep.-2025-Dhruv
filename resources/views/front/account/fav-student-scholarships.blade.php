@extends('front.layouts.account')
@php
            $defaultLang = getDefaultLanguage(1);
@endphp
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full relative">
        <h1 class="px-4 pt-4 can-school-h1">Favorite scholarships</h1>
        <div class="p-4">
            
            @if (count($scholarships) > 0)
            <div class="absolute right-3 top-4">      
                <a href="{{ url(app()->getLocale().'/scholarships') }}" class="flex-grow mx-2 ">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                        Explore Scholarships
                    </button>
                </a>
                {{-- <a href="{{ route('web.account.school.scholarship', ['lang' => $defaultLang['abbreviation']]) }}" class="flex-grow mx-2 ">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                        Add your own scholarship
                    </button>
                </a> --}}
            </div>
            <div class="space-y-4 mt-4">
                @foreach ($scholarships as $scholarship)
                    <div class="grid grid-cols-12 md:grid-cols-12 lg:grid-cols-12 gap-4 card_bg p-4 border rounded-md shadow relative">
                        <div class="md:col-span-12 col-span-12">
                            <div>
                                <p class="text-xl lg:text-2xl font-FuturaMdCnBT">
                                    {{ isset($scholarship->schoolScholarshipDetail[0]->name) ? $scholarship->schoolScholarshipDetail[0]->name : '' }}
                                </p>
                                <div class="mt-1 text-gray-500 can-edu-card-p line-clamp-3">
                                    {!! isset($scholarship->schoolScholarshipDetail[0]->summary)
                                        ? $scholarship->schoolScholarshipDetail[0]->summary
                                        : '' !!}
                                </div>
                                @php
                                    $url = route('web.view.scholarship.detail', ['lang' => getDefaultLanguage(1)['abbreviation'], 'id' => $scholarship->id]);
                                @endphp
                                <div class="mt-4 flex justify-end gap-2">
                                    <a href="{{ $url }}"><button class="can-edu-btn-fill">View</button></a>
                                </div>
                                <remove-fav-icon
                                 record_id="{{ $scholarship->id }}" model="scholarship"
                                   />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
            <div class="md:col-span-8 col-span-12 w-full mt-4">
                <p>You do not have any Favorite scholarship yet.. </p>
                <div class="absolute top-4 right-3">      
                    <a href="{{ url(app()->getLocale().'/scholarships') }}" class="flex-grow mx-2 ">
                        <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                            Explore Scholarships
                        </button>
                    </a>
                    {{-- <a href="{{ route('web.account.school.scholarship', ['lang' => $defaultLang['abbreviation']]) }}" class="flex-grow mx-2 ">
                        <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                            Add your own scholarship
                        </button>
                    </a> --}}
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
