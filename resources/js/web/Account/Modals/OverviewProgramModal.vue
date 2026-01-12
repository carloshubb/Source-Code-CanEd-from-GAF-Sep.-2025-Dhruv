<template>
    <div
        v-if="showModal"
        id="modal" 
        class="fixed z-50 inset-0 overflow-y-auto p-4"
    >
        <div class="flex items-center justify-center min-h-screen">
            <div
                class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"
            ></div>
            <div
                class="modal-container bg-white w-full md:w-3/5 mx-auto rounded shadow-lg overflow-y-auto"
            >
                <div class="modal-content py-6 text-left px-6">
                    <div class="flex justify-between items-center pb-3">
                        <div class="can-school-h2 mb-0">Add overview program</div>
                        <div
                            class="modal-close cursor-pointer z-50 border border-primary p-1.5 rounded-full"
                            @click="closeModal"
                        >
                            <svg
                                class="fill-current text-primary"
                                xmlns="http://www.w3.org/2000/svg"
                                width="12"
                                height="12"
                                viewBox="0 0 18 18"
                            >
                                <path
                                    d="M18 1.1L16.9 0 9 7.9 1.1 0 0 1.1 7.9 9 0 16.9 1.1 18 9 10.1l7.9 7.9 1.1-1.1-7.9-7.9z"
                                />
                            </svg>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex justify-end">
                            <p class=text-primary>* Indicates required fields</p>
                        </div>
                        <!-- <div
                            class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
                        >
                            <ul class="flex gap-2 flex-wrap my-4">
                                <li
                                    class="mr-2"
                                    v-for="language in languages"
                                    :key="language.code"
                                >
                                    <a
                                        @click.prevent="
                                            changeLanguageTab(language)
                                        "
                                        href="#"
                                        :class="[
                                            'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                            activeTab != null &&
                                            activeTab == language.language_code
                                                ? 'text-white bg-primary active'
                                                : '',
                                            errors.has(
                                                `name.name_${language.code}`
                                            )
                                                ? 'bg-red-600 text-white hover:text-white'
                                                : '',
                                        ]"
                                        >{{ getLanguageName(language.language_code) }}</a
                                    >
                                </li>
                            </ul>
                        </div> -->
                        <div
                            class="w-full mt-2"
                            v-for="language in languages"
                            :key="language.language_code"
                            :class="
                                activeTab == language.language_code
                                    ? 'block'
                                    : 'hidden'
                            "
                        >
                            <label for="name" class="block text-base lg:text-lg">Name <span class="text-primary">*</span></label>
                            <input
                                type="text"
                                name="name"
                                placeholder=""
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'name', language)"
                                :value="
                                    form['name'] &&
                                    form['name'][
                                        `name_${language.language_code}`
                                    ]
                                        ? form['name'][
                                              `name_${language.language_code}`
                                          ]
                                        : ''
                                "
                            />
                            <error :fieldName="`name.name_${language.language_code}`" :validationErros="errors" />
                           
                        </div>
                        <div class="w-full mt-4">
                            <label for="name" class="block text-base lg:text-lg">Length <span class="text-primary">*</span></label>
                            <input
                                type="number"
                                name="length"
                                placeholder=""
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'length', '')"
                                :value="form['length'] ? form['length'] : ''"
                            />
                            <error :fieldName="'length'" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-4">
                            <label for="name" class="block text-base lg:text-lg">International student tuition fee <span class="text-primary">*</span></label>
                            <input
                                type="text"
                                name="tuition_inter_stu_fee"
                                placeholder=""
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'tuition_inter_stu_fee', '')"
                                :value="form['tuition_inter_stu_fee'] ? form['tuition_inter_stu_fee'] : ''"
                            />
                            <error :fieldName="'tuition_inter_stu_fee'" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-4">
                            <label for="name" class="block text-base lg:text-lg">Candian student tuition fee <span class="text-primary">*</span></label>
                            <input
                                type="text"
                                placeholder=""
                                name="tuition_can_stu_fee"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'tuition_can_stu_fee', '')"
                                :value="form['tuition_can_stu_fee'] ? form['tuition_can_stu_fee'] : ''"
                            />
                            <error :fieldName="'tuition_can_stu_fee'" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-4">
                            <label for="name" class="block text-base lg:text-lg">Candian student tuition fee<span class="text-primary">*</span></label>
                            <input
                                type="text"
                                name="tuition_prov_stu_fee"
                                placeholder=""
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'tuition_prov_stu_fee', '')"
                                :value="form['tuition_prov_stu_fee'] ? form['tuition_prov_stu_fee'] : ''"
                            />
                            <error :fieldName="'tuition_prov_stu_fee'" :validationErros="errors" />
                        </div>

                        <div class="flex justify-center items-center gap-4 mt-4">
                                <button
                                    class="can-edu-btn-fill"
                                    @click="closeModal"
                                >
                                    Close
                                </button>
                                <button
                                    class="can-edu-btn-fill"
                                    @click="addUpdate"
                                >
                                    Submit
                                </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <transition name="slide">
        <div id="defaultModal" tabindex="-1" aria-hidden="true"
        class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
        v-if="showPopUpModal">
        <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
            ref="elementToDetectClick">
            <div class="relative">
            <div class="absolute top-3 right-3 cursor-pointer" @click="togglePopUpModal">
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                    <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class=" py-6 px-10 pt-10 ">
                <p class="text-center can-edu-p mt-2">
                {{
                    popupMsg
                }} </p>
                <div class="flex justify-center">
                    <button type="button" class="can-edu-btn-fill  whitespace-nowrap px-2.5 md:px-5 mt-4"
                        @click="togglePopUpModal">
                        Close
                    </button>
                </div>
            </div>
            </div>
        </div>
        </div>
  </transition>
</template>
<script>
import axios from "axios";
import { mapState } from "vuex";
import Error from "../../Error.vue"
export default {
    props: ["school_overview_id","languages_with_names"],
    components: { Error },
    computed: {
        ...mapState({
            form: (state) => state.overview_programs.form,
            showModal: (state) => state.overview_programs.showModal,
            overview_programs: (state) =>
                state.overview_programs.overview_programs,
            pagination: (state) => state.overview_programs.pagination,
            errors: (state) => state.overview_programs.errors,
            searchParam: (state) => state.overview_programs.searchParam,
            loading: (state) => state.overview_programs.loading,
            languages: (state) => state.overview_programs.form.languages,
        }),
        parsedLanguages() {
        if (typeof this.languages_with_names === 'string') {
            try {
                return JSON.parse(this.languages_with_names);
            } catch (error) {
                console.error('Error parsing JSON:', error);
                return []; // Return an empty array as a fallback
            }
        }
        return this.languages_with_names; // Return as is if already an array or object
    }
    },
    data() {
        return {
            showPopUpModal: false,
            popupMsg: '',
            activeTab: "en",
        };
    },
    methods: {
        togglePopUpModal() {
      this.showPopUpModal = !this.showPopUpModal;
      if (!this.showPopUpModal) {
        // window.location.reload();
        this.closeModal();

      }
    },
    handleClickOutsidePopup(event) {
      // // Check if the click target is not within the element
      if (
        this.$refs.elementToDetectClick &&
        event.target.contains(this.$refs.elementToDetectClick)
      ) {
        // Clicked outside the element, you can perform actions here
        if (this.showPopUpModal == true) {
          this.showPopUpModal = false;
          // window.location.reload();
          this.closeModal();


        }
      }
    },
        getLanguageName(language_code) {
        const languages = this.parsedLanguages; // Use the computed property
        if (Array.isArray(languages)) {
            const language = languages.find(
                (lang) => lang.language_code === language_code
            );
            return language ? language.language_name : language_code;
        }
        return language_code; // Fallback if parsedLanguages is not an array
    },
        closeModal() {
            this.$store.commit("overview_programs/resetForm");
            this.$store.commit("overview_programs/setShowModal", 0);
            this.fetchCustomerLangs();
            this.$store.commit("overview_programs/setForData", {
                key: "school_overviews_id",
                language: "",
                value: this.school_overview_id,
            });
        },
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.$store.commit("overview_programs/setForData", {
                    key: "image",
                    language: "",
                    value: res?.data,
                });
            });
        },
        handleInput(e, key, language) {
            const errorKey = language
        ? `${key}.${key}_${language.language_code}`
        : key;
            this.$store.commit("overview_programs/setForData", {
                key,
                language,
                value: e.target.value,
            });
            if (this.errors.has(errorKey)) {
                this.errors.clear(errorKey);
            }
        },
        changeLanguageTab(language) {
            this.activeTab = language.language_code;
        },
        addUpdate() {
            this.$store
                .dispatch("overview_programs/addUpdateForm")
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$store.commit("overview_programs/setLimit", 10);
                        this.$store.commit(
                            "overview_programs/setSortBy",
                            "id"
                        );
                        this.$store.commit(
                            "overview_programs/setSortType",
                            "desc"
                        );
                        this.$store.dispatch(
                            "overview_programs/fetchOverviewPrograms"
                        );
                        this.showPopUpModal = true;
                        this.popupMsg = res.data.message;
                    }
                }).catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.focusOnFirstErrorInput(error.response.data.errors);
                    }
                });
        },
        focusOnFirstErrorInput(errors) {
            console.log("Errors object:", errors);
            const firstErrorField = Object.keys(errors)[0];
            console.log("First error field name:", firstErrorField);

            if (!firstErrorField) {
                console.log("No error field found");
                return;
            }

            const fieldNameParts = firstErrorField.split(".");
            const fieldName = fieldNameParts[0];
            console.log("Stripped error field name:", fieldName);

            let inputElement = document.querySelector(
                `[name="${fieldName}"], [v-model="${fieldName}"], [data-v-model="${fieldName}"], [data-value="${fieldName}"]`
            );

            if (!inputElement) {
                console.log(`No standard input field found for ${fieldName}, checking for rich text editor...`);

                const editorId = fieldNameParts[1] || fieldName;
                const tinymceEditor = window.tinymce?.get(editorId);

                if (tinymceEditor) {
                    console.log(`Focusing on TinyMCE editor: ${editorId}`);
                    tinymceEditor.focus();
                    tinymceEditor.getBody().scrollIntoView({ behavior: "smooth", block: "center" });
                    return;
                } else {
                    console.log(`TinyMCE editor instance not found for ${editorId}`);
                }
            }

            if (inputElement) {
                console.log("Found input element:", inputElement);
                inputElement.scrollIntoView({ behavior: "smooth", block: "center" });
                inputElement.focus();
            } else {
                console.log(`No input field found for ${fieldName}`);
            }
        },
        fetchCustomerLangs() {
            axios
                .get(
                    "/api/web/customer-languages"
                )
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$store.commit(
                            "overview_programs/setLanguages",
                            res.data.data
                        );

                        res.data.data?.filter((lang) => {
                            this.$store.commit(
                                "overview_programs/setForData",
                                {
                                    key: "name",
                                    language: lang,
                                    value: "",
                                }
                            );
                        });
                    }
                });
        },
    },
    beforeUnmount() {
    document.removeEventListener("click", this.handleClickOutsidePopup);

  },
  mounted() {
    document.addEventListener("click", this.handleClickOutsidePopup);

        this.fetchCustomerLangs();
    },
};
</script>
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
