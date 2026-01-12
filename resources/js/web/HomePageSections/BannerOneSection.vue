<template>
    <a :href="formatUrl(home_settings?.banner1?.banner_button_link)" target="_blank">
        <div :style="'background-image:url(' + home_settings?.banner1?.image1?.large_image + ')'"
            class="bg-cover bg-no-repeat md:h-48 lg:h-60 w-full flex items-center px-4 md:px-8 space-y-4" :class="position == 'rtl'
                ? 'rounded-r-lg'
                : 'rounded-l-lg'
                ">

        </div>
    </a>
    <div class="mt-14">
        <div class="md:h-48 lg:h-60 mt-4 bg-cover bg-no-repeat rounded-md md:rounded-lg bg-right" :style="'background-image:url(' + home_settings?.banner1?.image1?.large_image + ')'
            " v-if="home_settings?.banner1?.banner_type == 'banner_2'">
            <div class="flex items-center">
                <div class="h-24 md:h-48 lg:h-60 w-1/2 bg-gray-200 float-left"
                    style="clip-path: polygon(0 0, 87% 0, 100% 100%, 0% 100%)">
                    <img class="h-full md:h-48 lg:h-60 w-full " :class="position == 'rtl'
                        ? 'rounded-l-lg'
                        : 'rounded-r-lg'
                        " :src="home_settings?.banner1?.image2?.large_image" alt="" />
                </div>
                <div class="w-1/2">
                    <p class="text-lg md:text-xl lg:text-2xl font-FuturaMdCnBT text-white leading-5">
                        {{ home_settings?.banner1?.banner_detail[0]?.title }}
                    </p>
                    <p class="text-white md:mb-4 mt-1 md:mt-2 line-clamp-2 text-xs md:text-base lg:text-lg" v-html="home_settings?.banner1?.banner_detail[0]
                        ?.banner_description
                        "></p>
                    <button
                        class="bg-white px-4 md:px-6 text-sm md:text-base py-0.5 md:py-1 lg:py-1.5 text-primary font-FuturaMdCnBT rounded mt-1 md:mt-3">
                        <a :href="home_settings?.banner1?.banner_button_link" target="_blank">
                            {{
                                home_settings?.banner1?.banner_detail[0]
                                    ?.banner_button_text
                            }}
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-14">
        <div class="md:h-48 lg:h-60 rounded-md flex px-20 my-10"
            v-if="home_settings?.banner1?.banner_type == 'banner_3'">
            <div :style="'background-image:url(' +
                home_settings?.banner1?.image1?.large_image +
                ')'
                " class="bg-center bg-cover md:h-48 lg:h-60 flex items-center w-1/2">
                <div class="px-16 space-y-3">
                    <h2 class="text-lg md:text-xl lg:text-2xl font-FuturaMdCnBT text-white leading-5">
                        {{ home_settings?.banner1?.banner_detail[0]?.title }}
                    </h2>
                    <p class="text-white md:mb-4 mt-1 md:mt-2 line-clamp-2 text-xs md:text-base lg:text-lg" v-html="home_settings?.banner1?.banner_detail[0]
                        ?.banner_description
                        "></p>
                    <button
                        class="bg-white px-4 md:px-6 text-sm md:text-base py-0.5 md:py-1 lg:py-1.5 text-primary font-FuturaMdCnBT rounded mt-1 md:mt-3">
                        <a :href="home_settings?.banner1?.banner_button_link">
                            {{
                                home_settings?.banner1?.banner_detail[0]
                                    ?.banner_button_text
                            }}
                        </a>
                    </button>
                </div>
            </div>

            <div class="relative w-1/2">
                <img :src="home_settings?.banner1?.image2?.large_image"
                    class="h-full md:h-48 lg:h-60 w-full object-cover" alt="" />
                <div class="absolute left-0 top-0 flex h-full">
                    <div class="flex space-x-3 h-full">
                        <span class="w-1 h-full bg-red-600 bg-opacity-70"></span>
                        <span class="w-1.5 h-full bg-red-600 bg-opacity-70"></span>
                        <span class="w-2 h-full bg-red-600 bg-opacity-70"></span>
                        <span class="w-2.5 h-full bg-red-600 bg-opacity-70"></span>
                    </div>
                    <span class="w-2 h-full bg-red-600 bg-opacity-70 ml-20"></span>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    props: ["home_page_settings", "position"],
    data() {
        return {
            home_settings: null,
        };
    },
    mounted() {
        this.home_settings = JSON.parse(this.home_page_settings);
        // console.clear();
        // console?.log(this.home_settings,"in banner");
    },
    methods: {
        formatUrl(url) {
            if (!url) return '#';
            if (/^https?:\/\//i.test(url)) {
                return url;
            }
            if (/^(www\.|[a-zA-Z0-9-]+\.[a-zA-Z]{2,})/i.test(url)) {
                if (/^www\./i.test(url)) {
                    return 'https://' + url;
                }
                return 'https://' + (url.startsWith('/') ? '' : '') + url;
            }
            if (url.startsWith('/')) {
                return url;
            }

            return 'https://' + url;
        }
    }
};
</script>
