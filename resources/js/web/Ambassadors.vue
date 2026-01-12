<template>
    <div class="my-10">
        <div class="grid grid-cols-12 gap-4 mt-10">
            <div
                class="col-span-12 md:col-span-6 lg:col-span-4"
                v-for="(singleSchoolAmbassador, i) in school_ambasssadors"
                :key="i"
            >
                <div
                    class="bg-white shadow-md w-full h-full rounded-xl overflow-hidden peer-hover:-translate-y-6 peer-hover:shadow-xl transition-all duration-500 ease-in-out"
                >
                    <div
                        class="relative flex justify-center items-center mb-10"
                    >
                        <div class="triangle-top-left"></div>
                        <div class="mt-20 mb-4 absolute">
                            <div class="relative">
                                <img
                                    class="w-24 h-24 rounded-full border-4 border-white bg-gray-50"
                                    :src="singleSchoolAmbassador?.image"
                                    alt=""
                                />
                                <!-- <span
                                                class="bottom-1.5 right-2 absolute border-2 '/' +singleSchoolAmbassador?.image"
                                                    alt="">
                                            </span> -->
                            </div>
                            <h4 class="text-center">
                                {{
                                    singleSchoolAmbassador?.school_ambassador_detail &&
                                    singleSchoolAmbassador
                                        ?.school_ambassador_detail?.length > 0
                                        ? singleSchoolAmbassador
                                              ?.school_ambassador_detail[0].name
                                        : ""
                                }}
                            </h4>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-2 gap-4 divide-x mb-4">
                            <div
                                class="flex justify-center items-center h-full"
                            >
                                <h6
                                    class="mt-4 font-semibold text-base ld:text-lg leading-5 text-center h-10"
                                >
                                    {{ singleSchoolAmbassador?.category }}
                                </h6>
                            </div>
                            <div
                                class="flex justify-center items-center h-full"
                            >
                                <img
                                    class="w-24 h-14 object-cover mx-auto"
                                    alt="Western New England University"
                                    aria-label="Western New England University"
                                    :src="
                                        getImage(
                                            singleSchoolAmbassador?.school
                                                ?.image
                                        )
                                    "
                                />
                            </div>
                        </div>
                        <p class="line-clamp-2 mb-2 md:mb-4">
                            {{
                                singleSchoolAmbassador?.school_ambassador_detail &&
                                singleSchoolAmbassador?.school_ambassador_detail
                                    ?.length > 0
                                    ? singleSchoolAmbassador
                                          ?.school_ambassador_detail[0].about_me
                                    : ""
                            }}
                        </p>
                        <!-- <a
                            class="text-primary hover:underline font-medium my-4 cursor-pointer text-base lg:text-lg"
                            :href="
                                '/' +
                                lang +
                                '/ambassador/' +
                                singleSchoolAmbassador?.id +
                                '/read-more'
                            "
                        > -->
                        <a
                                class="text-primary hover:underline font-medium my-4 cursor-pointer text-base lg:text-lg"
                                :href="`/${lang}/ambassador/${singleSchoolAmbassador?.id}/${singleSchoolAmbassador?.school_ambassador_detail[0]?.slug}/more`"
                            >
                            {{
                                static_translations?.read_more_link_text
                                    ? static_translations?.read_more_link_text
                                    : ""
                            }}
                            {{
                                singleSchoolAmbassador?.school_ambassador_detail &&
                                singleSchoolAmbassador?.school_ambassador_detail
                                    ?.length > 0
                                    ? singleSchoolAmbassador
                                          ?.school_ambassador_detail[0].name
                                    : ""
                            }}
                        </a>
                        
                        <div class="flex justify-center mt-4" v-if="singleSchoolAmbassador?.school_id != this.school">
                            <a
                             :href="`/${lang}/ambassador/${singleSchoolAmbassador?.id}/${singleSchoolAmbassador?.school_ambassador_detail[0]?.slug}/chat`"
                                class="relative inline-flex items-center justify-start px-8 py-2 overflow-hidden font-semibold rounded-full group"
                            >
                                <span
                                    class="w-32 h-32 rotate-45 translate-x-12 -translate-y-2 absolute left-0 top-0 bg-white opacity-[3%]"
                                ></span>
                                <span
                                    class="absolute top-0 left-0 w-80 h-56 -mt-1 transition-all duration-500 ease-in-out rotate-45 -translate-x-72 -translate-y-10 bg-[#b1040e] opacity-100 group-hover:-translate-x-8"
                                ></span>
                                <span
                                    class="relative w-full text-left text-[#b1040e] transition-colors duration-200 ease-in-out group-hover:text-white"
                                >
                                    {{
                                        static_translations?.chat_button_text
                                            ? static_translations?.chat_button_text
                                            : ""
                                    }}
                                    {{
                                        singleSchoolAmbassador?.school_ambassador_detail &&
                                        singleSchoolAmbassador
                                            ?.school_ambassador_detail?.length >
                                            0
                                            ? singleSchoolAmbassador
                                                  ?.school_ambassador_detail[0]
                                                  .name
                                            : ""
                                    }}
                                </span>
                                <span
                                    class="absolute inset-0 border-2 border-[#b1040e] rounded-full"
                                ></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["ambasssadors", "showTitle", "ambassador_translations", "lang", "school"],
    data() {
        return {
            school_ambasssadors: [],
            singleAmbassador: null,
            static_translations: {},
        };
    },
    methods: {
        showAmbassador(schoolAmbassador) {
            this.singleAmbassador = schoolAmbassador;
        },
        closeModal() {
            this.singleAmbassador = null;
        },
        getImage(image) {
            return "/" + helper.thumbnailImage(image);
        },
    },
    created() {
        console.log('this.ambasssadors', this.ambasssadors)
        console.log('this.school_ambasssadors', this.school_ambasssadors)
        this.school_ambasssadors = JSON.parse(this.ambasssadors);
        this.static_translations = JSON.parse(this.ambassador_translations);
    },
};
</script>
