<template>
    <div class="my-10">
        <!-- School Ambassadors -->
        <div v-if="paginatedAmbassadors.school.length > 0">
            <div class="grid grid-cols-12 gap-4 mt-10">
                <div
                    class="col-span-12 md:col-span-6 lg:col-span-4"
                    v-for="(ambassador, i) in paginatedAmbassadors.school"
                    :key="i"
                >
                    <!-- Ambassador Card -->
                    <div class="bg-white shadow-md w-full h-full rounded-xl overflow-hidden peer-hover:-translate-y-6 peer-hover:shadow-xl transition-all duration-500 ease-in-out">
                        <!-- Card Content -->
                        <div class="relative flex justify-center items-center mb-10">
                            <div class="triangle-top-left"></div>
                            <div class="mt-20 mb-4 absolute">
                                <div class="relative">
                                    <img
                                        class="w-24 h-24 rounded-full border-4 border-white bg-gray-50"
                                        :src="ambassador?.image"
                                        alt=""
                                    />
                                </div>
                                <h4 class="text-center">
                                    {{
                                        ambassador?.school_ambassador_detail &&
                                        ambassador?.school_ambassador_detail?.length > 0
                                            ? ambassador?.school_ambassador_detail[0].name
                                            : ""
                                    }}
                                </h4>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-2 gap-4 divide-x mb-4">
                                <div class="flex justify-center items-center h-full">
                                    <h6 class="mt-4 font-semibold text-base ld:text-lg leading-5 text-center h-10">
                                        {{ ambassador?.category }}
                                    </h6>
                                </div>
                                <div class="flex justify-center items-center h-full">
                                    <img
                                        class="w-24 h-14 object-cover mx-auto"
                                        alt="School Image"
                                        :src="getImage(ambassador?.school?.image)"
                                    />
                                </div>
                            </div>
                            <p class="line-clamp-2 mb-2 md:mb-4">
                                {{
                                    ambassador?.school_ambassador_detail &&
                                    ambassador?.school_ambassador_detail?.length > 0
                                        ? ambassador?.school_ambassador_detail[0].about_me
                                        : ""
                                }}
                            </p>
                            <a
                                class="text-primary hover:underline font-medium my-4 cursor-pointer text-base lg:text-lg"
                                :href="`/${lang}/ambassador/${ambassador?.id}/${ambassador?.school_ambassador_detail[0]?.slug}/more`"
                            >
                                {{
                                    static_translations?.read_more_link_text
                                        ? static_translations?.read_more_link_text
                                        : ""
                                }}
                                {{
                                    ambassador?.school_ambassador_detail &&
                                    ambassador?.school_ambassador_detail?.length > 0
                                        ? ambassador?.school_ambassador_detail[0].name
                                        : ""
                                }}
                            </a>
                            <!-- <div class="flex justify-center mt-4">
                                <a
                                    :href="`/${lang}/ambassador/${ambassador?.id}/${ambassador?.school_ambassador_detail[0]?.slug}/chat`"
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
                                            ambassador?.school_ambassador_detail &&
                                            ambassador?.school_ambassador_detail?.length > 0
                                                ? ambassador?.school_ambassador_detail[0].name
                                                : ""
                                        }}
                                    </span>
                                    <span
                                        class="absolute inset-0 border-2 border-[#b1040e] rounded-full"
                                    ></span>
                                </a>
                            </div> -->
                        </div>
                    </div>
                </div>
               
            </div>
            <div v-if="showRedLine" class="mt-4 border-t-2 border-red-500 pt-4">
                <p class="text-red-500">These ambassadors are standing by to help you as well</p>
            </div>
        </div>

        <!-- Red Line and Text -->
      

        <!-- Proxima Ambassadors -->
        <div v-if="paginatedAmbassadors.proxima.length > 0">
            <div class="grid grid-cols-12 gap-4 mt-10">
                <div
                    class="col-span-12 md:col-span-6 lg:col-span-4"
                    v-for="(ambassador, i) in paginatedAmbassadors.proxima"
                    :key="i"
                >
                    <!-- Ambassador Card -->
                    <div class="bg-white shadow-md w-full h-full rounded-xl overflow-hidden peer-hover:-translate-y-6 peer-hover:shadow-xl transition-all duration-500 ease-in-out">
                        <!-- Card Content -->
                        <div class="relative flex justify-center items-center mb-10">
                            <div class="triangle-top-left"></div>
                            <div class="mt-20 mb-4 absolute">
                                <div class="relative">
                                    <img
                                        class="w-24 h-24 rounded-full border-4 border-white bg-gray-50"
                                        :src="ambassador?.image"
                                        alt=""
                                    />
                                </div>
                                <h4 class="text-center">
                                    {{
                                        ambassador?.school_ambassador_detail &&
                                        ambassador?.school_ambassador_detail?.length > 0
                                            ? ambassador?.school_ambassador_detail[0].name
                                            : ""
                                    }}
                                </h4>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-2 gap-4 divide-x mb-4">
                                <div class="flex justify-center items-center h-full">
                                    <h6 class="mt-4 font-semibold text-base ld:text-lg leading-5 text-center h-10">
                                        {{ ambassador?.category }}
                                    </h6>
                                </div>
                                <div class="flex justify-center items-center h-full">
                                    <img
                                        class="w-24 h-14 object-cover mx-auto"
                                        alt="School Image"
                                        :src="getImage(ambassador?.school?.image)"
                                    />
                                </div>
                            </div>
                            <p class="line-clamp-2 mb-2 md:mb-4">
                                {{
                                    ambassador?.school_ambassador_detail &&
                                    ambassador?.school_ambassador_detail?.length > 0
                                        ? ambassador?.school_ambassador_detail[0].about_me
                                        : ""
                                }}
                            </p>
                            <a
                                class="text-primary hover:underline font-medium my-4 cursor-pointer text-base lg:text-lg"
                                :href="`/${lang}/ambassador/${ambassador?.id}/${ambassador?.school_ambassador_detail[0]?.slug}/more`"
                            >
                                {{
                                    static_translations?.read_more_link_text
                                        ? static_translations?.read_more_link_text
                                        : ""
                                }}
                                {{
                                    ambassador?.school_ambassador_detail &&
                                    ambassador?.school_ambassador_detail?.length > 0
                                        ? ambassador?.school_ambassador_detail[0].name
                                        : ""
                                }}
                            </a>
                            <div class="flex justify-center mt-4">
                                <a
                                    :href="`/${lang}/ambassador/${ambassador?.id}/${ambassador?.school_ambassador_detail[0]?.slug}/chat`"
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
                                            ambassador?.school_ambassador_detail &&
                                            ambassador?.school_ambassador_detail?.length > 0
                                                ? ambassador?.school_ambassador_detail[0].name
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

        <!-- Degree Level Ambassadors -->
        <div v-if="paginatedAmbassadors.degree.length > 0">
            <div class="grid grid-cols-12 gap-4 mt-10">
                <div
                    class="col-span-12 md:col-span-6 lg:col-span-4"
                    v-for="(ambassador, i) in paginatedAmbassadors.degree"
                    :key="i"
                >
                    <!-- Ambassador Card -->
                    <div class="bg-white shadow-md w-full h-full rounded-xl overflow-hidden peer-hover:-translate-y-6 peer-hover:shadow-xl transition-all duration-500 ease-in-out">
                        <!-- Card Content -->
                        <div class="relative flex justify-center items-center mb-10">
                            <div class="triangle-top-left"></div>
                            <div class="mt-20 mb-4 absolute">
                                <div class="relative">
                                    <img
                                        class="w-24 h-24 rounded-full border-4 border-white bg-gray-50"
                                        :src="ambassador?.image"
                                        alt=""
                                    />
                                </div>
                                <h4 class="text-center">
                                    {{
                                        ambassador?.school_ambassador_detail &&
                                        ambassador?.school_ambassador_detail?.length > 0
                                            ? ambassador?.school_ambassador_detail[0].name
                                            : ""
                                    }}
                                </h4>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-2 gap-4 divide-x mb-4">
                                <div class="flex justify-center items-center h-full">
                                    <h6 class="mt-4 font-semibold text-base ld:text-lg leading-5 text-center h-10">
                                        {{ ambassador?.category }}
                                    </h6>
                                </div>
                                <div class="flex justify-center items-center h-full">
                                    <img
                                        class="w-24 h-14 object-cover mx-auto"
                                        alt="School Image"
                                        :src="getImage(ambassador?.school?.image)"
                                    />
                                </div>
                            </div>
                            <p class="line-clamp-2 mb-2 md:mb-4">
                                {{
                                    ambassador?.school_ambassador_detail &&
                                    ambassador?.school_ambassador_detail?.length > 0
                                        ? ambassador?.school_ambassador_detail[0].about_me
                                        : ""
                                }}
                            </p>
                            <a
                                class="text-primary hover:underline font-medium my-4 cursor-pointer text-base lg:text-lg"
                                :href="`/${lang}/ambassador/${ambassador?.id}/${ambassador?.school_ambassador_detail[0]?.slug}/more`"
                            >
                                {{
                                    static_translations?.read_more_link_text
                                        ? static_translations?.read_more_link_text
                                        : ""
                                }}
                                {{
                                    ambassador?.school_ambassador_detail &&
                                    ambassador?.school_ambassador_detail?.length > 0
                                        ? ambassador?.school_ambassador_detail[0].name
                                        : ""
                                }}
                            </a>
                            <div class="flex justify-center mt-4">
                                <a
                                    :href="`/${lang}/ambassador/${ambassador?.id}/${ambassador?.school_ambassador_detail[0]?.slug}/chat`"
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
                                            ambassador?.school_ambassador_detail &&
                                            ambassador?.school_ambassador_detail?.length > 0
                                                ? ambassador?.school_ambassador_detail[0].name
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

        <!-- Other Ambassadors -->
        <div v-if="paginatedAmbassadors.other.length > 0">
            <div class="grid grid-cols-12 gap-4 mt-10">
                <div
                    class="col-span-12 md:col-span-6 lg:col-span-4"
                    v-for="(ambassador, i) in paginatedAmbassadors.other"
                    :key="i"
                >
                    <!-- Ambassador Card -->
                    <div class="bg-white shadow-md w-full h-full rounded-xl overflow-hidden peer-hover:-translate-y-6 peer-hover:shadow-xl transition-all duration-500 ease-in-out">
                        <!-- Card Content -->
                        <div class="relative flex justify-center items-center mb-10">
                            <div class="triangle-top-left"></div>
                            <div class="mt-20 mb-4 absolute">
                                <div class="relative">
                                    <img
                                        class="w-24 h-24 rounded-full border-4 border-white bg-gray-50"
                                        :src="ambassador?.image"
                                        alt=""
                                    />
                                </div>
                                <h4 class="text-center">
                                    {{
                                        ambassador?.school_ambassador_detail &&
                                        ambassador?.school_ambassador_detail?.length > 0
                                            ? ambassador?.school_ambassador_detail[0].name
                                            : ""
                                    }}
                                </h4>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-2 gap-4 divide-x mb-4">
                                <div class="flex justify-center items-center h-full">
                                    <h6 class="mt-4 font-semibold text-base ld:text-lg leading-5 text-center h-10">
                                        {{ ambassador?.category }}
                                    </h6>
                                </div>
                                <div class="flex justify-center items-center h-full">
                                    <img
                                        class="w-24 h-14 object-cover mx-auto"
                                        alt="School Image"
                                        :src="getImage(ambassador?.school?.image)"
                                    />
                                </div>
                            </div>
                            <p class="line-clamp-2 mb-2 md:mb-4">
                                {{
                                    ambassador?.school_ambassador_detail &&
                                    ambassador?.school_ambassador_detail?.length > 0
                                        ? ambassador?.school_ambassador_detail[0].about_me
                                        : ""
                                }}
                            </p>
                            <a
                                class="text-primary hover:underline font-medium my-4 cursor-pointer text-base lg:text-lg"
                                :href="`/${lang}/ambassador/${ambassador?.id}/${ambassador?.school_ambassador_detail[0]?.slug}/more`"
                            >
                                {{
                                    static_translations?.read_more_link_text
                                        ? static_translations?.read_more_link_text
                                        : ""
                                }}
                                {{
                                    ambassador?.school_ambassador_detail &&
                                    ambassador?.school_ambassador_detail?.length > 0
                                        ? ambassador?.school_ambassador_detail[0].name
                                        : ""
                                }}
                            </a>
                            <div class="flex justify-center mt-4">
                                <a
                                    :href="`/${lang}/ambassador/${ambassador?.id}/${ambassador?.school_ambassador_detail[0]?.slug}/chat`"
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
                                            ambassador?.school_ambassador_detail &&
                                            ambassador?.school_ambassador_detail?.length > 0
                                                ? ambassador?.school_ambassador_detail[0].name
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

        <!-- Pagination Controls -->
        <div v-if="totalPages > 1" class="mt-4 flex justify-end">
            <ul class="pagination flex space-x-2">
                <!-- Previous Button -->
                <li class="pagination-item order-first">
                    <button
                        @click="prevPage"
                        :disabled="currentPage === 1"
                        :class="[
                            'flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded border',
                            currentPage === 1
                                ? 'bg-gray-50 text-gray-600 cursor-not-allowed'
                                : 'bg-white text-primary hover:bg-primary hover:text-white border-primary transition duration-200'
                        ]"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 lg:w-6 h-5 lg:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                </li>

                <!-- Page Numbers -->
                <li
                    v-for="page in totalPages"
                    :key="page"
                    class="pagination-item"
                >
                    <button
                        @click="goToPage(page)"
                        :class="[
                            'flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded border',
                            page === currentPage
                                ? 'bg-primary text-white border-primary'
                                : 'bg-white text-gray-600 border hover:bg-primary hover:text-white hover:border-primary transition duration-200'
                        ]"
                    >
                        {{ page }}
                    </button>
                </li>

                <!-- Next Button -->
                <li class="pagination-item order-last">
                    <button
                        @click="nextPage"
                        :disabled="currentPage === totalPages"
                        :class="[
                            'flex items-center justify-center w-8 md:w-10 h-8 md:h-10 text-base lg:text-lg rounded border',
                            currentPage === totalPages
                                ? 'bg-gray-50 text-gray-600 cursor-not-allowed'
                                : 'bg-white text-primary hover:bg-primary hover:text-white border-primary transition duration-200'
                        ]"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 lg:w-6 h-5 lg:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "schoolAmbassadors",
        "proximaAmbassadors",
        "degreeLevelAmbassadors",
        "otherAmbassadors",
        "showTitle",
        "ambassador_translations",
        "lang"
    ],
    data() {
        return {
            static_translations: {},
            currentPage: 1,
            itemsPerPage: 12,
        };
    },
    computed: {
        // Combine all ambassadors into a single array
        combinedAmbassadors() {
            return [
                ...this.schoolAmbassadors,
                ...this.proximaAmbassadors,
                ...this.degreeLevelAmbassadors,
                ...this.otherAmbassadors,
            ];
        },
        // Calculate total number of pages
        totalPages() {
            return Math.ceil(this.combinedAmbassadors.length / this.itemsPerPage);
        },
        // Get paginated ambassadors for the current page
        paginatedAmbassadors() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            const allAmbassadors = this.combinedAmbassadors.slice(start, end);

            // Separate ambassadors by category
            const schoolAmbassadors = allAmbassadors.filter(ambassador =>
                this.schoolAmbassadors.includes(ambassador)
            );
            const proximaAmbassadors = allAmbassadors.filter(ambassador =>
                this.proximaAmbassadors.includes(ambassador)
            );
            const degreeAmbassadors = allAmbassadors.filter(ambassador =>
                this.degreeLevelAmbassadors.includes(ambassador)
            );
            const otherAmbassadors = allAmbassadors.filter(ambassador =>
                this.otherAmbassadors.includes(ambassador)
            );

            return {
                school: schoolAmbassadors,
                proxima: proximaAmbassadors,
                degree: degreeAmbassadors,
                other: otherAmbassadors,
            };
        },
        // Show red line only if school ambassadors are fully displayed
        showRedLine() {
            const schoolAmbassadorsEnd = this.schoolAmbassadors.length;
            const currentEnd = this.currentPage * this.itemsPerPage;
            return currentEnd >= schoolAmbassadorsEnd;
        },
    },
    methods: {
        getImage(image) {
            return "/" + helper.thumbnailImage(image);
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        goToPage(page) {
            this.currentPage = page;
        },
    },
    created() {
        this.static_translations = JSON.parse(this.ambassador_translations);
    },
};
</script>