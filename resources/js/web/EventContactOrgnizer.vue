<template>
    <button class="can-edu-btn-fill py-1.5" @click="toggleModal">
        Contact organizer
    </button>
    <transition name="slide">
        <div
            id="defaultModal"
            tabindex="-1"
            aria-hidden="true"
            class="bg-black bg-opacity-50 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="showModal"
        >
            <div
                class="relative w-full rounded-2xl shadow-2xl border-4 border-primary/30 bg-white h-full max-w-lg md:h-auto"
                ref="elementToDetectClick"
            >
                <!-- Modal content -->
                <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl text-center pt-10">
                    <!-- Modal header -->
                    <div
                        class="flex items-start justify-between p-4 rounded-t dark:border-gray-600"
                    >
                        <h3 class="can-edu-h3 mb-0">
                            Event orgnizer contact detail
                        </h3>
                        <button
                            type="button"
                            class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
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
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-4">
                        <p>
                            Event orgnizer email :
                            <a class="text-primary font-medium">
                                {{ event_data?.contact_email }}
                            </a>
                        </p>
                        <p>
                            Event orgnizer phone :
                            {{ event_data?.contact_phone }}
                        </p>
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
    props: ["event"],
    data() {
        return {
            showModal: false,
            event_data: {},
            toggelSubmitButton: false,
        };
    },
    methods: {
        toggleModal() {
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
        this.event_data = JSON.parse(this.event);
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
