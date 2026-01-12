<template>
    <transition name="slide">
        <div
            id="defaultModal"
            tabindex="-1"
            aria-hidden="true"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 md:h-full"
            v-if="showModal"
        >
            <div
                class="relative flex items-center justify-center w-full h-full max-w-2xl overflow-auto"
                ref="elementToDetectClick"
            >
                <!-- Modal content -->
                <div class="bg-white rounded-2xl shadow-2xl border-4 border-primary/30 max-w-xl w-full p-4">
                    <!-- Modal header -->
                    <div
                        class="flex items-start justify-between p-4 rounded-t dark:border-gray-600"
                    >
                        <div>
                            <h3 class="can-edu-h3 mb-0">
                                What are you registering as?
                                 <!-- {{
                                    static_translations?.you_are_registering_as_title
                                      ? static_translations?.you_are_registering_as_title
                                      : ""
                                  }} -->
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
                                <span class="sr-only">{{
                                    static_translations?.clos_modal_button_text
                                        ? static_translations?.clos_modal_button_text
                                        : ""
                                }}</span>
                            </button>
                        </div>
                    </div>
                    <div
                        class="flex items-start justify-center p-4 rounded-t dark:border-gray-600"
                    >
                        <div class="grid grid-cols-3 gap-4 p-4">
                            <div
                                class="can-edu-btn-fill"
                            >
                                <a
                                    :href="`/${lang}/${register_school_slug}`"
                                    class=""
                                    >School</a
                                >
                            </div>
                            <div
                                class="can-edu-btn-fill"
                            >
                                <a
                                    :href="`/${lang}/${register_business_slug}`"
                                    class=""
                                    >Business</a
                                >
                            </div>
                            <div
                                class="can-edu-btn-fill"
                            >
                                <a
                                    :href="`/${lang}/${slug}?type=student`"
                                    class=""
                                    >Student</a
                                >
                            </div>
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
// ES6 Modules or TypeScript
import Error from "./Error.vue";

export default {
    props: ["lang","slug","register_school_slug","register_business_slug","lang_id", "toggleModal", "register_modal_translation"],
    components: {
        Error,
    },
    created() {
  console.log("register_modal_fields_page:", this.register_modal_fields_page);
  this.static_translations = this.register_modal_fields_page
    ? JSON.parse(this.register_modal_fields_page)
    : {};
  console.log("static_translations:", this.static_translations);
},
    data() {
        return {
            static_translations: [],
            showModal: this.toggleModal,
        };
    },
    methods: {
        toggleModal() {
            this.showModal = false;
        },
        handleClickOutside(event) {
            // // Check if the click target is not within the element
            if (
                this.$refs.elementToDetectClick &&
                event.target.contains(this.$refs.elementToDetectClick)
            ) {
                // Clicked outside the element, you can perform actions here
                this.showModal = false;
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
    watch: {
        toggleModal: function (newVal, oldVal) {
            // watch it
            console.log("Prop changed: ", newVal, " | was: ", oldVal);
            this.showModal = newVal;
        },
    },
};
</script>
