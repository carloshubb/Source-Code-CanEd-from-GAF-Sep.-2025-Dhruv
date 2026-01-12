<template>
    <div>
        <div class="py-2">
            <div class="mx-auto container px-2">
                <div class="mx-auto lg:mx-0">
                    <h2 class="heading2 mb-2">
                        {{
                            home_settings?.home_page_setting_detail?.length > 0
                                ? home_settings?.home_page_setting_detail[0]
                                      ?.featured_title
                                : ""
                        }}
                    </h2>
                    <p
                        class="can-edu-p mb-2"
                        v-html="
                            home_settings?.home_page_setting_detail?.length > 0
                                ? home_settings?.home_page_setting_detail[0]
                                      ?.featured_description
                                : ''
                        "
                    ></p>
                </div>
            </div>
        </div>
        <div class="bg-white my-6">
            <div class="px-2 relative z-0">
                <button class="bg-primary rounded-full h-10 w-10 flex items-center justify-center slick-prev2 slick-arrow2 absolute text-black top-1/2 -left-3 z-10" aria-label="Previous" type="button" style="">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </button>

                <div class="multiple-items2" >


                    <div class="mx-2 h-80" v-for="(school, i) in school_listing"
                    :key="i">
                        <div class="cursor-pointer h-80 bg-gray-200" @click="cardHeading( `${lang}/school/` + school?.id + '/' + createSlug(school?.school_detail[0] ?.school_name))">
                            <div class="relative w-full border bg-white h-auto">
                                <img :src="getImage(school?.image)" alt="" class="w-full h-56 bg-gray-100 object-cover" />
                            </div>
                            <div class="p-2">
                                <a class="card_heading line-clamp-1 group-hover:text-gray-600" :href=" `${lang}/school/` + school?.id + '/' + createSlug(school?.school_detail[0] ?.school_name)">
                                    {{school?.school_detail?.length > 0 ? school?.school_detail[0] ?.school_name : ""}}
                                </a>
                                <p class="line-clamp-2 can-edu-card-p leading-4" v-html=" school?.school_detail?.length > 0 ? school?.school_detail[0] ?.description : ''">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="bg-primary rounded-full h-10 w-10 flex items-center justify-center slick-next2 slick-arrow2 absolute text-black top-1/2 -right-3 z-10" aria-label="Next" type="button" style="">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-white">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["home_page_settings", "schools", "lang"],
    data() {
        return {
            home_settings: null,
            school_listing: null,
        };
    },
    methods: {
        cardHeading(link){
            window.location.href=link
        },
        getImage(image) {
            return helper.thumbnailImage(image);
        },
        createSlug(string) {
            // Convert the string to lowercase
            string = string.toLowerCase();

            // Remove spaces and special characters (except for hyphens and underscores)
            string = string.replace(/[^a-z0-9-_]+/g, "-");

            // Remove any leading or trailing hyphens
            string = string.replace(/^-+|-+$/g, "");

            // Replace multiple consecutive hyphens with a single hyphen
            string = string.replace(/-+/g, "-");

            return string;
        },
    },
    mounted() {
        this.home_settings = JSON.parse(this.home_page_settings);
        this.school_listing = JSON.parse(this.schools);
    },
};
</script>
<style scoped>
.slick-prev2:before {
    content: '';
}
.slick-next2:before {
    content: '';
}
</style>