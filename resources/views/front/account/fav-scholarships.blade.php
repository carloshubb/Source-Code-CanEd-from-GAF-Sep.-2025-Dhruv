@extends('front.layouts.account')
@php
            $defaultLang = getDefaultLanguage(1);
@endphp
@section('account-content')
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full relative">
        <h2 class="px-4 pt-4 can-school-h2 text-primary">Our scholarships</h2>
        <div class="p-4">
            
            @if (count($scholarships) > 0)
            <div class="absolute top-4 right-4">      
                <a href="{{ url(app()->getLocale().'/scholarships') }}" class="flex-grow mx-2 ">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                        Explore Scholarships
                    </button>
                </a>
                <a href="{{ route('web.account.school.scholarship', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}" class="flex-grow mx-2 ">
                    <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white ">
                        Add your own scholarship
                    </button>
                </a>
            </div>
            @php
            $userSchoolScholarships = $scholarships->where('customer_id', Auth::guard('customers')->user()->id);
            $favSchoolScholarships = $scholarships->whereNotIn('id', $userSchoolScholarships->pluck('id'));
        @endphp

         @if ($userSchoolScholarships->count() > 0)
         {{-- <h2 class="text-2xl font-bold mt-6 mb-3">Our scholarships</h2> --}}
         @foreach ($userSchoolScholarships as $scholarship)
         <div class="grid grid-cols-12 md:grid-cols-12 lg:grid-cols-12 gap-4 card_bg relative p-4 border rounded-md shadow">
            <div class="absolute top-3 right-3 cursor-pointer">
                {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                  </svg>                               --}}
            </div>
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
                </div>
            </div>
        </div>
         @endforeach
         @endif

         @if ($favSchoolScholarships->count() > 0)
         <h2 class="pt-4 can-school-h2 text-primary">Favorite scholarships</h2>
         <div class="space-y-4 mt-4">
          @foreach ($favSchoolScholarships as $scholarship)
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
         @endif

            @else
            <div class="md:col-span-8 col-span-12 w-full">
                <p>You do not have any Favorite scholarship yet</p>
                <div class="absolute right-4 top-4 flex justify-between items-center">
                    <a href="{{ url(app()->getLocale().'/scholarships') }}" class="can-edu-btn-fill flex-grow mx-2">Explore Scholarships</a>
                    <a href="{{ route('web.account.school.scholarship', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]) }}" class="flex-grow mx-2">
                        <button class="bg-primary hover:bg-secondaryRed px-6 py-2 font-FuturaMdCnBT rounded text-white w-full">
                            Add your own scholarship
                        </button>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
