<template>
    <div class="mt-14">
        <div class="py-2">
            <div class="mx-auto container px-2">
                <div class="mx-auto lg:mx-0">
                    <h2 class="heading2 mb-2" v-if="financial_help_article_categories?.length == 0">
                        <a :href='"/"+lang+"/articles?category="+home_settings?.article_section_1_category_id'>
                        {{
                            home_settings?.home_page_setting_detail?.length > 0
                                ? home_settings?.home_page_setting_detail[0]
                                      ?.article_section_1_title
                                : ""
                        }}
                        </a>
                    </h2>
                    <h2 class="heading2 mb-2" v-else>
                        <a :href='"/"+lang+"/articles/category/"+home_settings?.article_section_1_category_id'>{{
                            home_settings?.home_page_setting_detail?.length > 0
                                ? home_settings?.home_page_setting_detail[0]
                                      ?.article_section_1_title
                                : ""
                        }}</a>
                    </h2>
                    <p
                        class=" can-edu-p mb-2"
                        v-html="
                            home_settings?.home_page_setting_detail?.length > 0
                                ? home_settings?.home_page_setting_detail[0]
                                      ?.article_section_1_description
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
                    v-if="financial_help_article_categories?.length == 0"
                    >
                    <article
                        class="flex flex-col items-start justify-between"
                        v-for="(article, key) in financial_help_articles"
                        :key="key"
                    >
                        <div class="relative w-full">
                            <img
                                :src="'/'+lang+'/'+article?.article_image?.thumbnail_image"
                                alt=""
                                class="rounded-full bg-gray-100 object-cover h-32 md:h-48 lg:h-52 xl:h-64 w-32 md:w-48 lg:w-52 xl:w-64 mx-auto"
                            />
                        </div>
                        <div class="max-w-xl w-full">
                            <div class="group relative py-2 px-2 text-center">
                                <h3
                                    class="card_heading line-clamp-2 group-hover:text-gray-600 h-20"
                                >
                                    <a
                                        :href="`${lang}/article/${article?.id}/${
                                            article?.article_detail?.length > 0
                                                ? article?.article_detail[0]
                                                      ?.slug
                                                : ''
                                        }`"
                                    >
                                        <!-- <span class="absolute inset-0"></span> -->
                                        {{
                                            article?.article_detail?.length > 0
                                                ? article?.article_detail[0]
                                                      ?.name
                                                : ""
                                        }}
                                    </a>
                                </h3>
                                <p
                                    class="line-clamp-2 can-edu-card-p leading-5"
                                >
                                    {{
                                        article?.article_detail?.length > 0
                                            ? article?.article_detail[0]
                                                  ?.short_description
                                            : ""
                                    }}
                                </p>
                            </div>
                        </div>
                    </article>
                </div>
                <div
                    class="mx-auto mt-4 grid max-w-2xl grid-cols-2 md:grid-cols-3 2xl:gap-8 gap-4 lg:mx-0 lg:max-w-none lg:grid-cols-4"
                    v-else
                    >
                    <article
                        class="flex flex-col items-start justify-between"
                        v-for="(category, key) in financial_help_article_categories"
                        :key="key"
                    >
                        <div class="relative w-full">
                            <img
                                :src="category?.article_category_image?.thumbnail_image"
                                alt=""
                                class="rounded-full bg-gray-100 object-cover h-32 md:h-48 lg:h-52 xl:h-64 w-32 md:w-48 lg:w-52 xl:w-64 mx-auto"
                            />
                        </div>
                        <div class="w-full max-w-xl">
                            <div class="group relative py-2 px-2 text-center">
                                <h3
                                    class="card_heading line-clamp-2 group-hover:text-gray-600 h-20"
                                >
                                    <a
                                        :href="`${lang}/articles?category=${category?.id}`"
                                    >
                                        <!-- <span class="absolute inset-0"></span> -->
                                        {{
                                             category?.article_category_detail?.length > 0
                                                ?  category?.article_category_detail[0]
                                                      ?.name
                                                : ""
                                        }}
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
    props: ["home_page_settings", "articles","article_categories","lang"],
    data() {
        return {
            home_settings: null,
            financial_help_articles: null,
            financial_help_article_categories:null
        };
    },
    mounted() {
        this.home_settings = JSON.parse(this.home_page_settings);
        this.financial_help_articles = JSON.parse(this.articles);
        this.financial_help_article_categories = JSON.parse(this.article_categories);
    },
};
</script>
