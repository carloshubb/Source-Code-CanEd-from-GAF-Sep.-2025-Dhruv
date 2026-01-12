@php
    $defaultLang = getDefaultLanguage(1);

    $customerId = "";
    $schoolId = "";
    if(isset($_GET['slug']) && $_GET['slug'] != ""){
        $customerId = App\Models\Customer::where('slug', $_GET['slug'])->value('id');
        if($customerId != null && $customerId != ""){
            $schoolId =  App\Models\School::where('customer_id', $customerId)->value('id');
        }
    }
    

    $programs = App\Models\Program::with([
        'programDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
            if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
                $q->where('name', 'LIKE', '%' . $_GET['keyword'] . '%');
            }
        },
    ])->addSelect([
        'name_order' => App\Models\ProgramDetail::where('language_id', $defaultLang->id)
            ->whereColumn('program_id', 'programs.id')
            ->limit(1)
            ->select('name'),
    ]);

    if(isset($_GET['slug']) && $_GET['slug'] != ""){
        $programs = $programs->where('customer_id', $customerId);
        // $schoolPrograms = App\Models\SchoolProgram::where('school_id', $schoolId)->pluck('program_id');
        // $programs = $programs->whereIn('id', $schoolPrograms);
    }

    if (isset($_GET['location']) && !empty($_GET['location'])) {
        $location = $_GET['location'];
        $schoolPrograms = App\Models\SchoolProgram::whereHas('school', function ($q) use ($location) {
            $q->where('province', $location)
                ->orWhere('country', $location)
                ->orWhere('country', $location)
                ->orWhere('city', $location);
        })->pluck('program_id');
        $programs = $programs->whereIn('id', $schoolPrograms);
    }
    if (isset($_GET['degree_id']) && !empty($_GET['degree_id'])) {
        $location = $_GET['location'];
        $degreePrograms = App\Models\ProgramDegreeLevel::where('degree_id', $_GET['degree_id'])->pluck('program_id');
        $programs = $programs->whereIn('id', $degreePrograms);
    }
    $programs = $programs->where('status', 'approved')->orderBy('name_order')->get();
    $degrees = App\Models\Degree::with([
        'degreeDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
        'degreeImage',
    ])

        ->orderBy('order')

        ->get();

        if(isset($_GET['slug']) && $_GET['slug'] != ""){
            $customerId = App\Models\Customer::where('slug', $_GET['slug'])->value('id');
            if($customerId == null){
                $programs = [];
            }
        }

        

    $programSetting = App\Models\ProgramSetting::with([
        'programSettingDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        },
    ])->first();
    $isLoggedIn = Auth::guard('customers')->check();
    $loggedInCustomer = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user()->id : '';
    $logged_in_user_type = isset($data['logged_in_user_type']) ? $data['logged_in_user_type'] : '';
    $school_id = isset(Auth::guard('customers')->user()->school->id)
        ? Auth::guard('customers')->user()->school->id
        : '';
    $loggedIn = isset(Auth::guard('customers')->user()->id) ? Auth::guard('customers')->user() : '';
    $is_package_amount_paid = isset($loggedIn->package_price) ? $loggedIn->package_price : '0';
    $position = isset($defaultLang->position) ? $defaultLang->position : 'rtl';
    $programTranslations = getStaticTranslation('program');
    $lang_abbreviation = $defaultLang['abbreviation'];
    $lang_id = $defaultLang['id'];
    $indicateRequiredField = isset(getStaticTranslation('general')['indicate_required_field_text'])
        ? getStaticTranslation('general')['indicate_required_field_text']
        : '';
        $successMessage = getStaticTranslation('toaster_messages')['program_add_success_message'] ?? '';

@endphp
<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="flex flex-row w-full items-end gap-3 h-14">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">
                {{-- {{ isset($programSetting->programSettingDetail[0]) ? $programSetting->programSettingDetail[0]->page_title : '' }} --}}
                {{ isset($page->pageDetail[0]) ? $page->pageDetail[0]->name : '' }}
            </h1>
        </div>
        <add-program indicate_required_field="{{ $indicateRequiredField }}" lang_id="{{ $lang_id }}"
            lang="{{ $lang_abbreviation }}" program_translations="{{ $programTranslations }}"
            position="{{ $position }}" school_id="{{ $school_id }}" is_logged_id="{{ $isLoggedIn }}"
            logged_in_user_type="{{ $logged_in_user_type }}" logged_in_customer="{{ $loggedInCustomer }}"
            is_package_amount_paid="{{ $is_package_amount_paid }}"
            button_text="{{ isset($programSetting->programSettingDetail[0]) ? $programSetting->programSettingDetail[0]->button_text : '' }}"
            success_message="{{ $successMessage }}"

            />
    </div>


    <div class="mt-10 ml10">
        {{-- @isset($programSetting->programSettingDetail[0]) --}}
        @isset($page->pageDetail[0])
            <div class="can-edu-p">
                <div class="">
                    @php
                        $page_detail = $page->pageDetail[0]->description;
                    @endphp
                    @include('front.pages.widgets.render-widget-with-detail', [
                        'page_detail' => $page_detail,
                    ])
                </div>
            </div>
        @endisset
        <form action="{{ url('/' . $defaultLang['abbreviation'] . '/programs') }}" method="GET">
            <div class="w-full  mx-auto mt-10">
                <div class="grid grid-cols-1 gap-2 md:grid-cols-4">
                    <div class="">

                        <input type="text" value="{{ isset($_GET['keyword']) ? $_GET['keyword'] : '' }}"
                            name="keyword"
                            placeholder="{{ isset($programTranslations['keyword_search_input_placeholder']) ? $programTranslations['keyword_search_input_placeholder'] : '' }}"
                            class="border w-full focus:ring-primary focus:outline-none px-2 py-1.5 rounded lg:text-lg border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                    </div>
                    <div class="">
                        <select name="degree_id" id=""
                            class="border w-full focus:ring-primary focus:outline-none px-2 py-1.5 rounded lg:text-lg border-gray-300 {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}">
                            <option value="">
                                {{ isset($programTranslations['degree_search_input_placeholder']) ? $programTranslations['degree_search_input_placeholder'] : '' }}
                            </option>
                            @php
                                $sortedDegrees = $degrees->sortBy(function ($degree) {
                                    return $degree->degreeDetail[0]->name ?? '';
                                });
                            @endphp
                            {{-- @foreach ($degrees as $degree)
                                <option
                                    {{ isset($_GET['degree_id']) && $_GET['degree_id'] == $degree->id ? 'selected' : '' }}
                                    value="{{ $degree->id }}">
                                    {{ isset($degree->degreeDetail[0]->name) ? $degree->degreeDetail[0]->name : '' }}
                                </option>
                            @endforeach --}}
                            @foreach ($sortedDegrees as $degree)
                                <option
                                    {{ isset($_GET['degree_id']) && $_GET['degree_id'] == $degree->id ? 'selected' : '' }}
                                    value="{{ $degree->id }}">
                                    {{ $degree->degreeDetail[0]->name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="">
                        <input type="text" value="{{ isset($_GET['location']) ? $_GET['location'] : '' }}"
                            name="location"
                            placeholder="{{ isset($programTranslations['location_search_input_placeholder']) ? $programTranslations['location_search_input_placeholder'] : '' }}"
                            class="border w-full focus:ring-primary focus:outline-none px-2 py-1.5 rounded lg:text-lg border-gray-300
        
                                {{ isset($defaultLang->position) && $defaultLang->position === 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary' }}
        
                                " />
                    </div>
                    <div class="">
                        <button type="submit" class="can-edu-btn-fill">
                            {{ isset($programTranslations['search_button_text']) ? $programTranslations['search_button_text'] : '' }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="grid grid-cols-1 md:grid-cols-3 space-y-2 md:space-y-0 mt-10 gap-2">

            @if (count($programs) > 0)
            @foreach ($programs as $program)
                @isset($program->programDetail[0]->name)
                    <div
                        class="flex items-center p-2 text-base md:text-base lg:text-lg border border-yellow-300 rounded-lg bg-yellow-50">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="flex-shrink-0 inline w-6 h-6 mr-3 text-primary">
                                <path fill-rule="evenodd"
                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="text-black hover:underline hover:underline-offset-2"><a
                                href="{{ url('/' . $defaultLang['abbreviation'] . '/program/' . $program->id) }}">{{ isset($program->programDetail[0]->name) ? $program->programDetail[0]->name : '' }}</a>
                        </div>
                    </div>
                @endisset
            @endforeach
            @else
            <div class="text-center text-black text-lg mt-10 col-span-3">
                {{-- <p>Sorry, your search yielded no results.</p>
                <p>Please double-check your spelling and try different variations of your keywords or key phrases.</p> --}}
                <p>{{ getStaticTranslation('general')['search_yield_error_text'] ?? '' }}</p>
            </div>
        @endif
        </div>
    </div>

</div>
