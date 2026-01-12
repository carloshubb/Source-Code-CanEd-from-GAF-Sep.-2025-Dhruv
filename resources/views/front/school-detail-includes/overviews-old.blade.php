@isset($school->schoolOverview->schoolOverviewDetail[0])
    <div class="my-10">
        <h2 class="can-edu-h2 normal-case mb-2">
            {{ isset($school->schoolOverview->schoolOverviewDetail[0]->title_1) ? $school->schoolOverview->schoolOverviewDetail[0]->title_1 : '' }}
        </h2>
        <p class="text-gray-500">
            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_1_paragraph)
                ? $school->schoolOverview->schoolOverviewDetail[0]->title_1_paragraph
                : '' !!}
        </p>
        <p class="text-gray-500">
            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_1_content)
                ? $school->schoolOverview->schoolOverviewDetail[0]->title_1_content
                : '' !!}
        </p>
    </div>
    <div class="bg-gray-100 p-4 py-8 my-10">
        <h2 class="can-edu-h2 mb-2">
        Quick Facts About Our School
        </h2>
        <p class="can-edu-p">
           <p>Standing true to our beliefs as First Peoples and guided by our cultural teachings, the First Peoples' House provides an environment of empowerment for First Nations, Métis, and Inuit (FNMI) students at the University of Alberta to achieve personal and academic growth.</p>
           <p>Our vision is to demonstrate our commitment to the First Nations, Métis, and Inuit student community on campus and provide services that reflect this responsibility. We will continue to honour the Indigenous worldview of education as a continuous ceremony of learning by respecting and supporting the voices and spirit of our student community at the University of Alberta.</p>
            <p>The Office of the Vice-Provost (Indigenous Programming & Research) facilitates institutional collaboration and communication to support the development and implementation of programs, services and initiatives related to Indigenous engagement. The office is also working to enable transformative institutional practices that respect and honour Indigenous knowledges across the University of Alberta.</p>
        </p>
    </div>
    <div>
        <div class="my-10">
            <h2 class="can-edu-h2 normal-case mb-2">
                {{ isset($school->schoolOverview->schoolOverviewDetail[0]->title_2) ? $school->schoolOverview->schoolOverviewDetail[0]->title_2 : '' }}
            </h2>
            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_2_bullet_points)
                ? $school->schoolOverview->schoolOverviewDetail[0]->title_2_bullet_points
                : '' !!}
        </div>
        <div class="grid grid-cols-12 gap-4 bg-gray-100">
            <div class="col-span-12 md:col-span-7 relative">
                <div  class="h-96 border bg-gray-50">
                <img class="h-full object-cover w-full"
                    src="{{ asset(thumbnailImage($school->schoolOverview->title_3_image)) }}"
                    alt=""></div>
                    <span class="bg-neutral-700/60 text-white bottom-4 pl-4 py-1 pr-2 absolute ">
                {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_3_image_name)
                    ? $school->schoolOverview->schoolOverviewDetail[0]->title_3_image_name
                    : '' !!}
                </span>
            </div>
            <div class="col-span-12 md:col-span-5 flex items-center w-full p-4">
                <div class="w-full">
                    <div class="mb-4">
                        <h3 class="text-gray-700 font-bold text-xl mb-4">
                            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_3)
                                ? $school->schoolOverview->schoolOverviewDetail[0]->title_3
                                : '' !!}</h3>
                        {{-- <h3 class="can-edu-h3 my-2">
                            Static Heading
                        </h3> --}}
                        <div class="text-gray-500 line-clamp-6">
                            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_3_paragraph)
                                ? $school->schoolOverview->schoolOverviewDetail[0]->title_3_paragraph
                                : '' !!}
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <p class="text-gray-500">
                                {{-- Nov 10, 2021 --}}
                                {{ isset($school->schoolOverview->title_3_date) ? $school->schoolOverview->title_3_date : '' }}
                            </p>
                            <a target="_blank"
                                href="{{ isset($school->schoolOverview->title_3_button_link) ? $school->schoolOverview->title_3_button_link : 'title_3_button_link' }}">
                                <!-- <button class="canedu_btn">
                                    {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_3_button_title)
                                        ? $school->schoolOverview->schoolOverviewDetail[0]->title_3_button_title
                                        : '' !!}
                                </button> -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-8 text-gray-700 cursor-pointer">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-10">
        <h2 class="can-edu-h2 normal-case mb-2">{!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_4)
            ? $school->schoolOverview->schoolOverviewDetail[0]->title_4
            : '' !!}</h2>
        <p class="text-gray-500">
            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_4_paragraph)
                ? $school->schoolOverview->schoolOverviewDetail[0]->title_4_paragraph
                : '' !!}
        </p>
        <div class="w-full grid grid-cols-2 gap-8 mx-auto my-4">
            <div class="bg-gray-50 border h-96 ">
                <img class="h-full w-full img-fluid object-cover"
                src="{{  asset(thumbnailImage($school->schoolOverview->title_4_image)) }}"
                alt="">
            </div>
            <div class="bg-gray-50 border h-96 ">
                <img class="h-full w-full img-fluid object-cover"
                src="{{  asset('./images/1680783336.jpg') }}"
                alt="">
            </div>
        </div>
    </div>
    <div class="my-10">
        <h2 class="can-edu-h2 normal-case mb-2">
            Student's life at our school
        </h2>
        <p class="text-gray-500">
            Rhoncus dolor purus non enim praesent elementum facilisis leo vel. Blandit cursus risus at ultrices mi. In ante metus dictum at. Sodales neque sodales ut etiam sit amet nisl.
            Rhoncus dolor purus non enim praesent elementum facilisis leo vel. Blandit cursus risus at ultrices mi. In ante metus dictum at. Sodales neque sodales ut etiam sit amet nisl.
            Rhoncus dolor purus non enim praesent elementum facilisis leo vel. Blandit cursus risus at ultrices mi. In ante metus dictum at. Sodales neque sodales ut etiam sit amet nisl.
        </p>
        <div class="w-full grid grid-cols-2 gap-8 mx-auto my-4">
            <div class="bg-gray-100">
                <div class="bg-gray-50 border h-96 ">
                    <img class="h-full w-full img-fluid object-cover"
                    src="{{  asset('./images/1680501597.jpg') }}"
                    alt="">
                </div>
                <div class="p-4">
                    <p>Video</p>
                    <h3 class="line-clamp-1 w-4/5">Blandit cursus risus at ultrices mi In ante metus dictum at</h3>
                    <p>praesent elementum facilisis leo vel. Blandit cursus risus at ultrices mi. In ante metus dictum at. Sodales neque sodales ut etiam sit amet nisl.</p>
                    <div class="flex items-center justify-between mt-4">
                        <p class="text-gray-500">
                            Nov 10, 2021
                        </p>
                        <a target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-8 text-gray-700 cursor-pointer">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100">
                <div class="bg-gray-50 border h-96 ">
                    <img class="h-full w-full img-fluid object-cover"
                    src="{{  asset('./images/1680501641.jpg') }}"
                    alt="">
                </div>
                <div class="p-4">
                    <p>Video</p>
                    <h3 class="line-clamp-1 w-4/5">Blandit cursus risus at ultrices mi In ante metus dictum at</h3>
                    <p>praesent elementum facilisis leo vel. Blandit cursus risus at ultrices mi. In ante metus dictum at. Sodales neque sodales ut etiam sit amet nisl.</p>
                    <div class="flex items-center justify-between mt-4">
                        <p class="text-gray-500">
                            Nov 10, 2021
                        </p>
                        <a target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-8 text-gray-700 cursor-pointer">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-10">
        <h2 class="can-edu-h2 normal-case mb-2">
            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_5)
            ? $school->schoolOverview->schoolOverviewDetail[0]->title_5
            : '' !!}
        </h2>
        <p class="text-gray-500">
            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_5_paragraph)
            ? $school->schoolOverview->schoolOverviewDetail[0]->title_5_paragraph
            : '' !!}
        </p>
    </div>
    <div class="grid grid-cols-2 gap-8 my-10">
        <div>
            <h2 class="can-edu-h2 normal-case mb-2">
                {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_6)
                ? $school->schoolOverview->schoolOverviewDetail[0]->title_6
                : '' !!}
            </h2>
            <p class="text-gray-500">
                {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_6_paragraph)
                ? $school->schoolOverview->schoolOverviewDetail[0]->title_6_paragraph
                : '' !!}
            </p>
            <a class="flex items-center space-x-2 mt-4" href="{{ isset($school->schoolOverview->title_6_button_link) ? $school->schoolOverview->title_6_button_link : '' }}"
                 target="_blank">
                <p class="text-primary font-medium">
                 {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_6_button_title)
                 ? $school->schoolOverview->schoolOverviewDetail[0]->title_6_button_title
                 : '' !!}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-8 text-gray-700 cursor-pointer">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                </svg>
            </a>
        </div>
        <div>
            <h2 class="can-edu-h2 normal-case mb-2">
                {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_8)
                ? $school->schoolOverview->schoolOverviewDetail[0]->title_8
                : '' !!}
            </h2>
            <p class="text-gray-500">
                {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_8_paragraph)
                ? $school->schoolOverview->schoolOverviewDetail[0]->title_8_paragraph
                : '' !!}
            </p>
            <a class="flex items-center space-x-2 mt-4" href="{{ isset($school->schoolOverview->title_8_button_link) ? $school->schoolOverview->title_8_button_link : '' }}"
             target="_blank">
                <p class="text-primary font-medium">
                    {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_7_button_title)
                    ? $school->schoolOverview->schoolOverviewDetail[0]->title_7_button_title
                    : '' !!}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-8 text-gray-700 cursor-pointer">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                </svg>
            </a>
        </div>
    </div>
    <div class="my-10">
        <h2 class="can-edu-h2 normal-case mb-2">
            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_7)
                ? $school->schoolOverview->schoolOverviewDetail[0]->title_7
                : '' !!}
        </h2>
        <p class="text-gray-500">
            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_7_paragraph)
                ? $school->schoolOverview->schoolOverviewDetail[0]->title_7_paragraph
                : '' !!}
        </p>
        <div class="bg-gray-100 p-6 py-8 grid grid-cols-12 gap-8 mt-4">
            <div class="col-span-3">
                <h2 class="can-edu-h2">Highlights the School</h2>
                <a class="flex items-center space-x-2 mt-4" href="#!" target="_blank">
                    <p class="text-primary font-medium">Explore topic title</p>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-8 text-gray-700 cursor-pointer">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                    </svg>
                </a>
            </div>
            <div class="col-span-9 lg:pl-4">
                <p>Sit amet nisl purus in mollis nunc sed id semper. Risus viverra adipiscing at in tellus. Facilisi nullam vehicula ipsum a arcu cursus vitae. Dui accumsan sit amet nulla facilisi morbi. Non quam lacus suspendisse faucibus interdum posuere. Pellentesque habitant morbi tristique senectus et netus. Purus sit amet volutpat consequat mauris nunc. Sed nisi lacus sed viverra. Urna nunc id cursus metus aliquam eleifend mi in. Tincidunt nunc pulvinar sapien et ligula. Auctor urna nunc id cursus metus aliquam eleifend mi in. Amet mattis vulputate enim nulla aliquet. Enim nec dui nunc mattis. Aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed</p>
            </div>
        </div>
    </div>
    <div class="my-10">
        <h2 class="can-edu-h2 normal-case mb-2">
            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_9)
                ? $school->schoolOverview->schoolOverviewDetail[0]->title_9
                : '' !!}
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="relative">
                <div class="h-72 border bg-white">
                <img class="h-full object-cover w-full "
                    src="{{  asset(thumbnailImage($school->schoolOverview->title_9_image))  }}"
                    alt=""></div>
                    <span class="bg-neutral-700/60 text-white bottom-4 pl-4 py-1 pr-2 absolute ">
                {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_9_image_name)
                    ? $school->schoolOverview->schoolOverviewDetail[0]->title_9_image_name
                    : '' !!}
                </span>
            </div>
            <div class="flex items-center w-full">
                <div class="w-full mb-4">
                    <div class="mb-4">
                        <h3 class="can-edu-h3 my-2">
                            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_9_subtitle)
                                ? $school->schoolOverview->schoolOverviewDetail[0]->title_9_subtitle
                                : '' !!}
                        </h3>
                        <div class="text-gray-500 line-clamp-6">
                            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_9_paragraph)
                                ? $school->schoolOverview->schoolOverviewDetail[0]->title_9_paragraph
                                : '' !!}
                        </div>
                    </div>
                    <div class="flex justify-start">
                        <a href="{{ isset($school->schoolOverview->title_9_button_link) ? $school->schoolOverview->title_9_button_link : '' }}"
                            target="_blank">
                            <button class="canedu_btn">
                                {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_9_button_title)
                                    ? $school->schoolOverview->schoolOverviewDetail[0]->title_9_button_title
                                    : '' !!}
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-10">
        <div class="bg-gray-100 rounded text-gray-500 p-4">
            <h2 class="can-edu-h2 normal-case mb-2">
                {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_10)
                    ? $school->schoolOverview->schoolOverviewDetail[0]->title_10
                    : '' !!}
            </h2>
            <p class="text-gray-500">
                {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_10_paragraph)
                    ? $school->schoolOverview->schoolOverviewDetail[0]->title_10_paragraph
                    : '' !!}
            </p>

        </div>
        <div>
            @if(isset($school->schoolOverview->overviewPrograms) && count($school->schoolOverview->overviewPrograms) > 0)
            <!-- Table -->
            <div class=" mx-auto">

                <div class="flex flex-col">
                    <div class="overflow-x-auto">
                        <div class="inline-block w-full align-middle">
                            <div class="overflow-auto ">
                                <table class="w-full divide-y divide-gray-200 border-b">
                                    <thead class="bg-blue-900">
                                        <tr>
                                            <th scope="col"
                                                class="py-3 px-6 font-medium tracking-tight text-center text-white">
                                                Program name
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 font-medium tracking-tight text-center text-white">
                                                Length
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 font-medium tracking-tight text-center text-white">
                                                Tuition, International students
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 font-medium tracking-tight text-center text-white">
                                                Tuition, Canadian students
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 font-medium tracking-tight text-center text-white">
                                                Tuition, Provincial students
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800">
                                        @foreach ($school->schoolOverview->overviewPrograms as $overviewProgram)
                                        <tr class="">
                                            <td class="py-4 px-5 text-gray-900 text-center">
                                                {{ isset($overviewProgram->overviewProgramDetail[0]->name) ? $overviewProgram->overviewProgramDetail[0]->name : "" }}
                                            </td>
                                            <td class="py-4 px-5 text-gray-900 text-center">
                                               {{$overviewProgram->length}}
                                            </td>
                                            <td class="py-4 px-5 font-medium text-gray-900 text-center">
                                                {{$overviewProgram->tuition_inter_stu_fee}}
                                            </td>
                                            <td class="py-4 px-5 font-medium text-gray-900 text-center">
                                                {{$overviewProgram->tuition_can_stu_fee}}
                                            </td>
                                            <td class="py-4 px-5 font-medium text-gray-900 text-center">
                                                {{$overviewProgram->tuition_prov_stu_fee}}
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="my-10">
        <h2 class="can-edu-h2 normal-case mb-2">
            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_11)
                ? $school->schoolOverview->schoolOverviewDetail[0]->title_11
                : '' !!}
        </h2>
        <p class="text-gray-500">
            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_11_paragraph)
            ? $school->schoolOverview->schoolOverviewDetail[0]->title_11_paragraph
            : '' !!}
        </p>
    </div>
    <div class="my-10">
        <h2 class="can-edu-h2 normal-case mb-2">{!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_12)
            ? $school->schoolOverview->schoolOverviewDetail[0]->title_12
            : '' !!}
        </h2>
        <p class="text-gray-500">
            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_12_bullet_points)
                ? $school->schoolOverview->schoolOverviewDetail[0]->title_12_bullet_points
                : '' !!}
        </p>
        <div class="mt-10 bg-gray-100">
            <video class="mx-auto w-4/5 max-h-[500px]" controls>
                <source src="path/to/your/video.mp4" type="video/mp4">
            </video>
        </div>    
    </div>
    <div class="my-10">
        <h2 class="can-edu-h2 normal-case mb-2">Future students portal</h2>
        <div class="md:flex mt-6">
            <div class="flex flex-col justify-center space-y space-y-4 text-sm font-medium text-gray-500 dark:text-gray-400 tab_btns md:-mr-4 z-20 mb-4 md:mb-0">
                <button class="bg-gradient-to-b from-[#cb0410] to-[#6a0001] text-white rounded p-4 flex items-center 
                 justify-between active w-64" aria-current="page">
                    <span class="font-FuturaMdCnBT">On campus</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
                <button class="bg-gray-100 text-gray-700 border rounded p-4 py-3 flex items-center 
                 justify-between w-64" aria-current="page">
                    <span class="font-FuturaMdCnBT">Off campus</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
                <button class="bg-gray-100 text-gray-700 border rounded p-4 py-3 flex items-center 
                 justify-between w-64" aria-current="page">
                    <span class="font-FuturaMdCnBT">Online courses</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
                <button class="bg-gray-100 text-gray-700 border rounded p-4 py-3 flex items-center 
                 justify-between w-64" aria-current="page">
                    <span class="font-FuturaMdCnBT">Tours & Events</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
                <button class="bg-gray-100 text-gray-700 border rounded p-4 py-3 flex items-center 
                 justify-between w-64" aria-current="page">
                    <span class="font-FuturaMdCnBT">Request informations</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            </div>
            <div class="p-8 bg-gray-100 text-medium text-gray-500 w-full z-10">
                <div class="grid grid-cols-12 gap-8">
                    <div class="col-span-12 md:col-span-5 flex items-center">
                        <div class="bg-gray-50 border h-96 ">
                         <img class="h-full w-full img-fluid object-cover" src="{{  asset('./images/1680501597.jpg') }}"
                            alt="">
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-7">
                        <h2 class="can-edu-h2 normal-case mb-2">Pellentesque habitant morbi tristique senectus et netus</h2>   
                        <p class="text-gray-500">
                            Sit amet nisl purus in mollis nunc sed id semper. Risus viverra adipiscing at in tellus. Facilisi nullam vehicula ipsum a arcu cursus vitae. Dui accumsan sit amet nulla facilisi morbi. Non quam lacus suspendisse faucibus interdum posuere. Pellentesque habitant morbi tristique senectus et netus. Purus sit amet volutpat consequat mauris nunc. Sed nisi lacus sed viverra. Urna nunc id cursus metus aliquam eleifend mi in. Tincidunt nunc pulvinar sapien et ligula. Auctor urna nunc id cursus metus aliquam eleifend mi in. Amet mattis vulputate enim nulla aliquet. Enim nec dui nunc mattis. Aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed
                        </p>
                        <div class="flex items-center space-x-2 mt-4">
                            <button class="bg-gray-700 rounded border font-FuturaMdCnBT text-white text-xl px-4 py-2">Learn more</button>
                            <button class="bg-white rounded border font-FuturaMdCnBT text-gray-700 text-xl px-4 py-2">Ask a question</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-10">
        <h2 class="can-edu-h2 normal-case mb-2">{!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_13)
            ? $school->schoolOverview->schoolOverviewDetail[0]->title_13
            : '' !!}</h2>
        <p class="text-gray-500">
            {!! isset($school->schoolOverview->schoolOverviewDetail[0]->title_13_paragraph)
                ? $school->schoolOverview->schoolOverviewDetail[0]->title_13_paragraph
                : '' !!}
        </p>
        <div class="w-full grid grid-cols-2 gap-8 mx-auto my-4">
            <div class="bg-gray-100">
                <div class="bg-gray-50 border h-96 ">
                    <img class="h-full w-full img-fluid object-cover"
                    src="{{  asset('./images/1680501597.jpg') }}"
                    alt="">
                </div>
                <div class="p-4">
                    <p>Video</p>
                    <h3 class="line-clamp-1 w-4/5">Blandit cursus risus at ultrices mi In ante metus dictum at</h3>
                    <p>praesent elementum facilisis leo vel. Blandit cursus risus at ultrices mi. In ante metus dictum at. Sodales neque sodales ut etiam sit amet nisl.</p>
                    <div class="flex items-center justify-between mt-4">
                            <p class="text-gray-500">
                                Nov 10, 2021
                            </p>
                            <a href="#!" class="cursor-pointer" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-8 text-gray-700 cursor-pointer">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                </svg>
                            </a>
                        </div>
                </div>
            </div>
            <div class="bg-gray-100">
                <div class="bg-gray-50 border h-96 ">
                    <img class="h-full w-full img-fluid object-cover"
                    src="{{  asset('./images/1680501641.jpg') }}"
                    alt="">
                </div>
                <div class="p-4">
                    <p>Video</p>
                    <h3 class="line-clamp-1 w-4/5">Blandit cursus risus at ultrices mi In ante metus dictum at</h3>
                    <p>praesent elementum facilisis leo vel. Blandit cursus risus at ultrices mi. In ante metus dictum at. Sodales neque sodales ut etiam sit amet nisl.</p>
                    <div class="flex items-center justify-between mt-4">
                            <p class="text-gray-500">
                                Nov 10, 2021
                            </p>
                            <a href="#!" class="cursor-pointer" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-8 text-gray-700 cursor-pointer">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                </svg>
                            </a>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endisset
@php
    $filteredFaqs = $school->faqs->where('type', 'overview')->all();
@endphp
@if (isset($filteredFaqs) && count($filteredFaqs) > 0)
    <div class="my-10">
        <h2 class="can-edu-h2 normal-case mb-2">Frequently asked questions</h2>
        <div class="flex justify-center items-center">

            <!-- Collapse Start -->
            <div class="flex flex-col w-full">
                @foreach ($filteredFaqs as $faq)
                <button class="group border border-gray-300 mb-3 focus:outline-none">
                    <div
                        class="flex items-center justify-between group-focus:bg-blue-100 h-12 px-3 font-semibold hover:bg-gray-200 ">
                        <span
                            class="truncate text-gray-600 font-bold">{{ isset($faq->FaqDetail[0]->question) ? $faq->FaqDetail[0]->question : '' }}</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" stroke="1.5">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="max-h-0 overflow-hidden duration-300 group-focus:max-h-max">
                        <p class="text-gray-600 text-left text-lg p-4">
                            {!! isset($faq->FaqDetail[0]->answer) ? $faq->FaqDetail[0]->answer : '' !!}
                        </p>
                    </div>
                </button>
                @endforeach
            </div>
            <!-- Collapse End  -->

        </div>
    </div>
@endif
