<template>
    <div>
        <div class="fixed bottom-14 right-3 z-30">
            <span
                class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-gray-400 bg-opacity-70 cursor-pointer"
                @click="toggleLanguageModal"
            >
                <span class="font-semibold text-white">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-8 h-8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 01-3.827-5.802"
                        />
                    </svg>
                </span>
            </span>
        </div>
        <!-- Main modal -->
        <transition name="slide">
            <div
                id="defaultModal"
                tabindex="-1"
                aria-hidden="true"
                class="bg-black bg-opacity-50 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto inset-0 h-[calc(100%-1rem)] md:h-full"
                v-if="showModal"
            >
                <div
                    class="relative w-full bg-white rounded-2xl shadow-2xl border-4 border-primary/30 h-full max-w-2xl md:h-auto"
                    ref="elementToDetectClick"
                >
                    <!-- Modal content -->
                    <div
                        class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 "
                    >
                        <!-- Modal header -->
                        <div
                            class="flex items-start justify-between p-4 rounded-t dark:border-gray-600"
                        >
                            <div>
                                <h3 class="can-edu-h3 mb-0">{{ title }}</h3>
                            </div>
                            <div>
                                <button
                                    type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="defaultModal"
                                    @click="toggleLanguageModal"
                                >
                                    <svg
                                        aria-hidden="true"
                                        class="w-5 h-5 text-primary"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                        </div>
                        <!-- Modal body -->
                        <div class="p-6 space-y-6">
                            <div
                                class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-3 grid-cols-3 gap-2"
                            >
                                <div
                                    v-for="(language, key) in languages"
                                    :key="key"
                                >
                                    <a
                                        :href="`/set-language/${language?.id}?url=${current_url}&url_params=${url_params}`"
                                    >
                                        <img
                                            class=""
                                            :src="
                                                '/' +
                                                language?.flag_icon
                                                    ?.thumbnail_image
                                            "
                                            style="width: 32px; height: 32px"
                                        />
                                        {{ language?.name }}
                                        <span v-if="language.is_default != 1"
                                            >,{{ language?.native_name }}
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <!-- <div
                        class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600"
                    >
                        <button
                            data-modal-hide="defaultModal"
                            type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            I accept
                        </button>
                        <button
                            data-modal-hide="defaultModal"
                            type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                        @click="toggleLanguageModal"
                            >
                            Decline
                        </button>
                    </div> -->
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
<style scoped>
/* Slide Animation */
.slide-enter-active, .slide-leave-active {
  transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}
.slide-enter-from, .slide-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}
</style>

<script>
export default {
    props: ["languages", "title", "current_url", "url_params"],
    data() {
        return {
            showModal: false,
        };
    },
    methods: {
        toggleLanguageModal() {
            this.showModal = !this.showModal;
        },
        handleClickOutside(event) {
            // // Check if the click target is not within the element
            if (
                this.$refs.elementToDetectClick &&
                event.target.contains(this.$refs.elementToDetectClick)
            ) {
                // Clicked outside the element, you can perform actions here
                if (this.showModal == true) {
                    this.showModal = false;
                }
            }
        },
    },
    created() {
    },
    mounted() {
        // Add a click event listener to the document
        document.addEventListener("click", this.handleClickOutside);
    },
    beforeUnmount() {
        // Remove the click event listener when the component is unmounted
        document.removeEventListener("click", this.handleClickOutside);
    },
};
</script>
