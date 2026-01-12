<template>
    <div class="border bg-white h-20 sm:h-28 md:h-52">
        <img
            class="cursor-pointer w-full h-full mx-auto object-contain"
            :src=" image"
            alt=""
            @click="showImage(image)"
        />
    </div>
    <transition name="slide">
        <div
            id="defaultModal"
            tabindex="-1"
            aria-hidden="true"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="selectedImage != ''"
        >
            <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-2xl md:h-auto" ref="elementToDetectClick">
                <!-- Modal header -->
                <div
                    class="flex items-end justify-between p-4 rounded-t dark:border-gray-600"
                >
                    <button
                            type="button"
                            class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="defaultModal"
                            @click="selectedImage = ''"
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
                    </button>
                </div>
                <div class="p-4">
                    <div class="w-full h-80">
                        <img class="w-full h-full" :src=" large_image" />
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
    props: ["image", "large_image"],
    data() {
        return {
            selectedImage: "",
        };
    },
    methods: {
        showImage(image) {
            this.selectedImage = image;
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
                this.selectedImage = "";
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
