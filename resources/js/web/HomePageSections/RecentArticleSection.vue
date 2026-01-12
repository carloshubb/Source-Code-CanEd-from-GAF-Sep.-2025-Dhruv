<template>
    <!--academic help-->
    <div class="mt-14">
        <div class="py-2">
            <div class="mx-auto container px-2">
                <div class="mx-auto lg:mx-0">
                    <h2 class="heading2 mb-2">
                        {{
                            home_settings?.home_page_setting_detail?.length > 0
                                ? home_settings?.home_page_setting_detail[0]
                                      ?.recent_article_title
                                : ""
                        }}
                    </h2>
                    <p
                        class="can-edu-p mb-2"
                        v-html="
                            home_settings?.home_page_setting_detail?.length > 0
                                ? home_settings?.home_page_setting_detail[0]
                                      ?.recent_article_description
                                : ''
                        "
                    ></p>
                </div>
            </div>
        </div>

        <div class="bg-white">
            <div class="mx-auto container px-2">
                <div
                    class="mx-auto mt-4 grid max-w-2xl grid-cols-2 md:grid-cols-3 2xl:gap-8 gap-4 lg:mx-0 lg:max-w-none lg:grid-cols-4"
                >
                    <article
                        class="flex flex-col items-start justify-between"
                    >
                        <div class="relative w-full">
                            <img
                                :src=" home_settings?.home_page_setting_detail?.length > 0 ? home_settings?.home_page_setting_detail[0]?.recent_article_image : ''"
                                alt=""
                                class="rounded-full bg-gray-100 object-cover h-32 md:h-48 lg:h-52 xl:h-64 w-32 md:w-48 lg:w-52 xl:w-64 mx-auto"
                            />
                        </div>
                        <div class="max-w-xl w-full">
                            <div class="group relative py-2 px-2 text-center">
                                <h3
                                    class="card_heading line-clamp-1 group-hover:text-gray-600"
                                >
                                    <a
                                        :href='"/"+lang+"/articles/categories"'
                                    >
                                        {{ home_settings?.home_page_setting_detail?.length > 0 ? home_settings?.home_page_setting_detail[0]?.article_card_title : '' }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </article>
                    <article
                        class="flex flex-col items-start justify-between"
                    >
                        <div class="relative w-full">
                            <img
                                :src="home_settings?.home_page_setting_detail?.length > 0 ? home_settings?.home_page_setting_detail[0]?.recent_video_image : ''"
                                alt=""
                                class="rounded-full bg-gray-100 object-cover h-32 md:h-48 lg:h-52 xl:h-64 w-32 md:w-48 lg:w-52 xl:w-64 mx-auto"
                            />
                        </div>
                        <div class="max-w-xl w-full">
                            <div class="group relative py-2 px-2 text-center">
                                <h3
                                    class="card_heading line-clamp-1 group-hover:text-gray-600"
                                >
                                    <a
                                        :href='"/"+lang+"/videos/categories"'
                                    >
                                        {{ home_settings?.home_page_setting_detail?.length > 0 ? home_settings?.home_page_setting_detail[0]?.video_card_title : '' }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["home_page_settings", "articles","lang"],
    data() {
        return {
            home_settings: null,
            recent_articles: null,
        };
    },
    mounted() {
        this.home_settings = JSON.parse(this.home_page_settings);
        this.recent_articles = JSON.parse(this.articles);
        console.log(this.recent_articles);
    },
};
</script>
