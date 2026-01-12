<template>
    <div
        class="relative -mb-5 flex items-center border border-gray-300 rounded"
    >
        <button
            class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5"
            @click="toggleModal"
        >
            Add your video
        </button>
    </div>
    <transition name="slide">
        <div
            id="defaultModal"
            tabindex="-1"
            aria-hidden="true"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 md:h-full"
            v-if="showModal"
        >
            <div
                class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                ref="elementToDetectClick"
            >
                <!-- Modal content -->
                <div class="">
                    <div class="absolute top-4 right-4 cursor-pointer" @click="toggleModal">
                        <button type="button" class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                            <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Modal header -->
                    <!-- <div
                        class="flex items-start justify-between p-4  rounded-t dark:border-gray-600"
                    >
                        <div>
                            <h3 class="can-edu-h3 mb-0">
                                Add your video
                            </h3>
                        </div>
                        <div>
                            <button
                                type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="defaultModal"
                                @click="toggleModal"
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
                                <span class="sr-only"></span>
                            </button>
                        </div>
                    </div> -->
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-xl text-center pt-10">
                        <p class="text-center can-edu-p mt-2">
                            This feature is available exclusively to our Premium and Featured schools.
                        </p>
                        <div class="flex justify-center">
                        <button
                                type="button"
                                class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4"
                                data-modal-hide="defaultModal"
                                @click="toggleModal"
                            >
                               Close
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
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
    props: [
        "lang",
        "slug",
        "logged_in_user_type",
        "is_package_amount_paid",
    ],
    data() {
        return {
            showModal: false,
        };
    },
    methods: {
        toggleModal() {
            if (this.logged_in_user_type === 'school' && this.is_package_amount_paid > '0') {
                window.location.href =
                    "/" + this.lang + "/" + this.slug + "/our-profile/video/create";
            } else {
                this.showModal = !this.showModal;
            }
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
