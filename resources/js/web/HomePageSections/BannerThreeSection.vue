<template>
    <div class="mt-14" v-if="home_settings?.banner3?.banner_type == 'banner_1'">
        <div class="flex rounded-md md:rounded-lg overflow-hidden">
            <div :style="'background-image:url(' + home_settings?.banner3?.image1?.large_image + ')'"
                class="bg-cover bg-no-repeat md:h-48 lg:h-60 w-1/2 md:rounded-l-lg flex items-center px-4 md:px-8 space-y-4">
                <div>
                    <p class="text-lg md:text-xl lg:text-2xl font-FuturaMdCnBT text-white leading-5">
                        {{ home_settings?.banner3?.banner_detail[0]?.title }}
                    </p>
                    <p class="text-white md:mb-4 mt-1 md:mt-2 line-clamp-2 text-xs md:text-base lg:text-lg"
                        v-html="home_settings?.banner3?.banner_detail[0]?.banner_description">
                    </p>
                    <button
                        class="bg-white px-4 md:px-6 text-sm md:text-base py-0.5 md:py-1 lg:py-1.5 text-primary font-FuturaMdCnBT rounded mt-1 md:mt-3">
                        <a :href="home_settings?.banner3?.banner_button_link" target="_blank">
                            {{ home_settings?.banner3?.banner_detail[0]?.banner_button_text }}
                        </a>
                    </button>
                </div>
            </div>
            <div class="w-1/2">
                <img class="object-cover w-full  h-28 md:h-48 lg:h-60 md:rounded-r-lg"
                    :src="home_settings?.banner3?.image2?.large_image" alt="" />
            </div>
        </div>
    </div>
    <div class="mt-14">
        <div class="md:h-48 lg:h-60 mt-4 bg-cover bg-no-repeat rounded-md md:rounded-lg bg-right" :style="'background-image:url(' + home_settings?.banner3?.image1?.large_image + ')'
            " v-if="home_settings?.banner3?.banner_type == 'banner_2'">
            <div class="flex items-center">
                <div class="h-24 md:h-48 lg:h-60 w-1/2 bg-gray-200 float-left"
                    style="clip-path: polygon(0 0, 87% 0, 100% 100%, 0% 100%)">
                    <imgs class="h-full md:h-48 lg:h-60 w-full rounded-l-md md:rounded-l-lg"
                        :src="home_settings?.banner3?.image2?.large_image" alt="" />
                </div>
                <div class="w-1/2">
                    <p class="text-lg md:text-xl lg:text-2xl font-FuturaMdCnBT text-white leading-5">
                        {{ home_settings?.banner3?.banner_detail[0]?.title }}
                    </p>
                    <p class="text-white md:mb-4 mt-1 md:mt-2 line-clamp-2 text-xs md:text-base lg:text-lg" v-html="home_settings?.banner3?.banner_detail[0]
                        ?.banner_description
                        "></p>
                    <button
                        class="bg-white px-4 md:px-6 text-sm md:text-base py-0.5 md:py-1 lg:py-1.5 text-primary font-FuturaMdCnBT rounded mt-1 md:mt-3">
                        <a :href="home_settings?.banner3?.banner_button_link" target="_blank">
                            {{
                                home_settings?.banner3?.banner_detail[0]
                                    ?.banner_button_text
                            }}
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <a :href="formatUrl(home_settings?.banner3?.banner_button_link)" target="_blank">
        <div :style="'background-image:url(' + home_settings?.banner3?.image1?.large_image + ')'"
            class="bg-cover bg-no-repeat md:h-48 lg:h-60 w-full flex items-center px-4 md:px-8 space-y-4" :class="position == 'rtl'
                ? 'rounded-r-lg'
                : 'rounded-l-lg'
                ">

        </div>
    </a>
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
