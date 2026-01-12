<template>
    <!--Proxima study -->
    <div class="mt-14">
        <div class="py-2">
            <div class="mx-auto container px-2">
                <div class="mx-auto lg:mx-0">
                    <h2 class="heading2 mb-2" v-if="proxima_articles_categories?.length == 0">
                        <a :href='"/"+lang+"/articles?category="+home_settings?.article_section_3_category_id'>
                        {{
                            home_settings?.home_page_setting_detail?.length > 0
                                ? home_settings?.home_page_setting_detail[0]
                                      ?.article_section_3_title
                                : ""
                        }}
                        </a>
                    </h2>
                    <h2 class="heading2 mb-2" v-else>
                        <a :href='"/"+lang+"/articles/category/"+home_settings?.article_section_3_category_id'>{{
                            home_settings?.home_page_setting_detail?.length > 0
                                ? home_settings?.home_page_setting_detail[0]
                                      ?.article_section_3_title
                                : ""
                        }}</a>
                    </h2>
                    <p
                        class="can-edu-p mb-2"
                        v-html="
                            home_settings?.home_page_setting_detail?.length > 0
                                ? home_settings?.home_page_setting_detail[0]
                                      ?.article_section_3_description
                                : ''
                        "
                    ></p>
                </div>
            </div>
        </div>
        <div class="bg-white py-2">
            <div class="mx-auto container px-2">
                <div
                    class="mx-auto mt-4 grid max-w-2xl auto-rows-fr grid-cols-2 md:grid-cols-3 gap-4 2xl:gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-4"
                    v-if="proxima_articles_categories?.length == 0"
                >
                    <article
                        class="relative isolate flex flex-col justify-end overflow-hidden h-40 md:h-52 xl:h-64 bg-gray-900 px-4 pb-4"
                        v-for="(article, index) in proxima_articles"
                        :key="index"
                    >
                        <img
                            :src="article?.article_image?.thumbnail_image"
                            alt=""
                            class="absolute inset-0 -z-10 h-full w-full object-cover"
                        />
                        <div
                            class="absolute inset-0 -z-10 bg-gradient-to-t from-gray-900 via-gray-900/40"
                        ></div>
                        <!-- <div
                            class="absolute inset-0 -z-10 rounded-2xl ring-1 ring-inset ring-gray-900/10"
                        ></div> -->
                        <h3 class="mt-3 card_heading mb-0 line-clamp-1 text-white">
                            <a
                                :href="`${lang}/article/${article?.id}/${
                                    article?.article_detail?.length > 0
                                        ? article?.article_detail[0]?.slug
                                        : ''
                                }`"
                            >
                                <span class="absolute inset-0"></span>
                                {{
                                    article?.article_detail?.length > 0
                                        ? article?.article_detail[0]?.name
                                        : ""
                                }}
                            </a>
                        </h3>
                        <div
                            class="flex flex-wrap items-center gap-y-1 overflow-hidden text-base leading-6 text-gray-300"
                        >
                            <div
                                class="md:mr-3 text_left line-clamp-1 leading-5 text-white"
                            v-html="article?.article_detail?.length > 0
                                        ? article?.article_detail[0]
                                              ?.short_description
                                        : ''">
                            
                            </div>
                        </div>
                    </article>
                </div>
                <div
                    class="mx-auto mt-4 grid max-w-2xl auto-rows-fr grid-cols-2 md:grid-cols-3 gap-4 lg:mx-0 lg:max-w-none lg:grid-cols-4"
                    v-else
                >
                    <article
                        class="relative isolate flex flex-col justify-end overflow-hidden h-40 xl:h-52 bg-gray-900 px-4 pb-4"
                        v-for="(category, index) in proxima_articles_categories"
                        :key="index"
                    >
                        <img
                            :src="category?.article_category_image?.thumbnail_image"
                            alt=""
                            class="absolute inset-0 -z-10 h-full w-full object-cover"
                        />
                        <div
                            class="absolute inset-0 -z-10 bg-gradient-to-t from-gray-900 via-gray-900/40"
                        ></div>
                        <!-- <div
                            class="absolute inset-0 -z-10 rounded-2xl ring-1 ring-inset ring-gray-900/10"
                        ></div> -->
                        <h3 class="mt-3 card_heading line-clamp-1 text-white">
                            <a
                                :href="`${lang}/articles?category=`+category?.id"
                            >
                                <span class="absolute inset-0"></span>
                                {{
                                    category?.article_category_detail?.length > 0
                                        ? category?.article_category_detail[0]?.name
                                        : ""
                                }}
                            </a>
                        </h3>
                    </article>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["home_page_settings", "articles", "article_categories","lang"],
    data() {
        return {
            home_settings: null,
            proxima_articles: null,
            proxima_articles_categories: null,
        };
    },
    mounted() {
        this.home_settings = JSON.parse(this.home_page_settings);
        this.proxima_articles = JSON.parse(this.articles);
        this.proxima_articles_categories = JSON.parse(this.article_categories);
    },
};
</script>
