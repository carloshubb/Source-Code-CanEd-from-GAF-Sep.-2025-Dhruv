<template>
    <div class="border bg-gray-50 h-24">
        <img
            class="cursor-pointer w-full h-full mx-auto object-contain"
            :src="contact_image || default_image"
            alt=""
              @click="showImage(contact_image || default_image)"
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
            <div class="relative w-full rounded-2xl overflow-hidden shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto" ref="elementToDetectClick">
                <!-- Modal header -->
                <div
                    class="flex justify-end p-4 rounded-t-xl bg-white"
                >
                    <button
                            type="button"
                            data-modal-hide="defaultModal"
                            @click="selectedImage = ''"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-primary">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                          </svg>  
                    </button>
                </div>
                <div class="bg-white rounded-b-xl py-6 px-10 shadow-2xl pt-10 ">
                    <div class="w-full h-72 bg-gray-50 border rounded">
                        <img class="w-full h-full object-contain" :src=" selectedImage" />
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
    props: ["default_image", "contact_image"],
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
