<div class="w-full my-6">
    <div class="col-12">
        <a href="{{ isset($school->main_button_link) ? formatUrl($school->main_button_link) :"" }}" target="_blank" class="p-0 border-0 btn text-white w-full font-medium">
        <div class="grid grid-cols-12 canedu_btn rounded p-0 w-full mx-auto">
            <div style="max-width: 0.333333%;"></div> 
            <div class="col-span-4 py-5 bg-[#01468f] rounded-0">
            <p class="font-FuturaMdCnBT text-center text-xl">
            {{ isset($school->schoolDetail[0]->more_button_sub_title) ? $school->schoolDetail[0]->more_button_sub_title : '' }}
            </p>
            </div>
            <div class="col-span-7 py-5">
                <p class="font-FuturaMdCnBT text-center text-xl">
                {{ isset($school->schoolDetail[0]->more_button_title) ? $school->schoolDetail[0]->more_button_title : '' }}
                </p>
            </div>
        </div>
        </a>
    </div>
</div>
