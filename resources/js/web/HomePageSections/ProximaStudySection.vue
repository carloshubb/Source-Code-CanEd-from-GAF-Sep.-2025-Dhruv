<template>
  <div class="relative bg-gray-100">
  <!-- <div class="mx-auto container grid grid-cols-12"> -->
  <div class="mx-auto container grid grid-cols-12 gap-3 md:gap-4 xl:gap-8">
    <div class="md:px-1 py-4 sm:py-10 lg:py-20 col-span-6 md:col-span-7 flex items-center">
        <div class="mx-auto lg:mx-0">
        <div class="text-primary font-FuturaMdCnBT text-[20px] sm:text-2xl md:text-4xl xl:text-[40px] md:mb-4">{{ home_settings?.home_page_setting_detail?.length > 0 ? home_settings?.home_page_setting_detail[0]?.welcome_title : '' }}</div>
        <!-- <p class="mt-2 text-xl font-semibold tracking-tight text-gray-900 sm:text-4xl">subheading</p> -->
        <div class=" proxima-section-p line-clamp-2 md:line-clamp-3" v-html="home_settings?.home_page_setting_detail?.length > 0 ? home_settings?.home_page_setting_detail[0]?.welcome_description : ''"></div>
        <div class="flex items-center gap-x-6 mt-4 md:mt-8">
          <a :href="home_settings?.home_page_setting_detail?.length > 0 ? home_settings?.home_page_setting_detail[0]?.welcome_button_link : ''" target="_self" class="can-edu-btn-fill px-2 md:px-5 py-0.5 md:py-2 text-sm md:text-base lg:text-lg">{{ home_settings?.home_page_setting_detail?.length > 0 ? home_settings?.home_page_setting_detail[0]?.welcome_button_text : ''}}</a>
        </div>
      </div>
    </div>
    <div class="relative col-span-6 md:col-span-5">
      <img class="w-full bg-gray-50 object-cover h-full" :src=" home_settings?.home_page_setting_detail?.length > 0 ? home_settings?.home_page_setting_detail[0]?.welcome_image : ''" alt="proxima">
    </div>
  </div>
</div>
</template>
<script>
export default {
    props: ["home_page_settings"],
    data() {
        return {
            home_settings: null,
        };
    },
    mounted() {
        this.home_settings = JSON.parse(this.home_page_settings);
    },
};
</script>
