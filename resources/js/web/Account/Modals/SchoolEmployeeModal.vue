<template>
    <div v-if="showModal" id="modal" class="fixed z-50 inset-0 overflow-y-auto p-4">
        <div class="flex items-center justify-center min-h-screen">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
            <div class="modal-container bg-white w-full md:w-3/5 mx-auto rounded shadow-lg overflow-y-auto">
                <div class="modal-content py-6 text-left px-6">
                    <div class="flex justify-between items-center pb-3">
                        <div class="can-school-h2 mb-0">Add school employee</div>
                        <div class="modal-close cursor-pointer z-50 border border-primary p-1.5 rounded-full"
                            @click="closeModal">
                            <svg class="fill-current text-primary" xmlns="http://www.w3.org/2000/svg" width="12"
                                height="12" viewBox="0 0 18 18">
                                <path
                                    d="M18 1.1L16.9 0 9 7.9 1.1 0 0 1.1 7.9 9 0 16.9 1.1 18 9 10.1l7.9 7.9 1.1-1.1-7.9-7.9z" />
                            </svg>
                        </div>
                    </div>
                    <div class="modal-body">
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
                        <div class="w-full mt-2" v-for="language in languages" :key="language.language_code" :class="activeTab == language.language_code
                            ? 'block'
                            : 'hidden'
                            ">
                            <label for="name" class="block text-base lg:text-lg">Name <span
                                    class="text-primary">*</span></label>
                            <input type="text" placeholder="" name="name"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'name', language)" :value="form['name'] &&
                                    form['name'][
                                    `name_${language.language_code}`
                                    ]
                                    ? form['name'][
                                    `name_${language.language_code}`
                                    ]
                                    : ''
                                    " />
                            <error :fieldName="`name.name_${language.language_code}`" :validationErros="errors" />

                        </div>
                        <div class="w-full mt-2" v-for="language in languages" :key="language.language_code" :class="activeTab == language.language_code
                            ? 'block'
                            : 'hidden'
                            ">
                            <label for="description" class="block text-base lg:text-lg">Description <span
                                    class="text-primary">*</span></label>
                            <textarea name="description" id="" cols="5" rows="5" placeholder=""
                                class="border border-l-[5px] w-full border-l-primary border-gray-300 rounded mt-2 p-3 focus:outline-none focus:ring-primary"
                                @input="
                                    handleInput($event, 'description', language)
                                    ">{{
                                        form["description"] &&
                                            form["description"][
                                            `description_${language.language_code}`
                                            ]
                                            ? form["description"][
                                            `description_${language.language_code}`
                                            ]
                                            : ""
                                    }}</textarea>
                            <error :fieldName="`description.description_${language.language_code}`"
                                :validationErros="errors" />

                        </div>
                        <div class="w-full mt-2">
                            <label for="position" class="block text-base lg:text-lg">Position <span
                                    class="text-primary">*</span></label>
                            <input type="text" name="position" placeholder=""
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'position', '')" :value="form['position'] ? form['position'] : ''
                                    " />
                            <error :fieldName="`position`" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-2">
                            <label for="telephone" class="block text-base lg:text-lg">Telephone</label>
                            <input type="text" name="telephone" placeholder=""
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'telephone', '')" :value="form['telephone'] ? form['telephone'] : ''
                                    " @keypress="restrictToNumbers($event, 15)" />
                            <error :fieldName="`telephone`" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-2">
                            <label for="more_1" class="block text-base lg:text-lg">More_1 <span
                                    class="text-primary">*</span></label>
                            <input type="text" name="more_1" placeholder=""
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'more_1', '')"
                                :value="form['more_1'] ? form['more_1'] : ''" />
                            <error :fieldName="`more_1`" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-2">
                            <label for="email" class="block text-base lg:text-lg">Email <span
                                    class="text-primary">*</span></label>
                            <input type="email" name="email" placeholder=""
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'email', '')" :value="form['email'] ? form['email'] : ''" />
                            <error :fieldName="`email`" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-2">
                            <label for="more_2" class="block text-base lg:text-lg">More_2 <span
                                    class="text-primary">*</span></label>
                            <input type="text" name="more_2" placeholder=""
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'more_2', '')"
                                :value="form['more_2'] ? form['more_2'] : ''" />
                            <error :fieldName="`more_2`" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-2">
                            <label for="order" class="block text-base lg:text-lg">Order <span
                                    class="text-primary">*</span></label>
                            <input type="number" name="order" placeholder=""
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'order', '')" :value="form['order'] ? form['order'] : ''" />
                            <error :fieldName="`order`" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Image</label>
                            <p class="text-base">
                                (Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)
                            </p>
                            <input type="file" name="image"
                                class="border w-full border-l-[5px] focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @change="handleImage($event)" />
                            <error :fieldName="`image`" :validationErros="errors" />
                            <img v-if="form['image']" :src="form?.image ? form.image : ''"
                                style="height: 100px; width: 100px" />
                        </div>

                        <div class="flex justify-center items-center gap-4 mt-4">
                            <button class="can-edu-btn-fill" @click="closeModal">
                                Close
                            </button>
                            <button class="can-edu-btn-fill" @click="addUpdate">
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
            <div class="relative w-full rounded-2xl bg-white shadow-2xl border-4 border-primary/30 h-full max-w-lg md:h-auto"
                ref="elementToDetectClick">
                <div class="relative">
                    <div class="absolute top-3 right-3 cursor-pointer" @click="togglePopUpModal">
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="defaultModal">
                            <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                        <p class="text-center can-edu-p mt-2">
                            {{
                                popupMsg
                            }}
                        </p>
                        <div class="flex justify-center">
                        <button type="button" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4"
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
    props: ["logged_in_customer", "school_id", "languages_with_names"],
    components: { Error },
    computed: {
        ...mapState({
            form: (state) => state.school_employees.form,
            showModal: (state) => state.school_employees.showModal,
            school_employees: (state) =>
                state.school_employees.school_employees,
            pagination: (state) => state.school_employees.pagination,
            errors: (state) => state.school_employees.errors,
            searchParam: (state) => state.school_employees.searchParam,
            loading: (state) => state.school_employees.loading,
            languages: (state) => state.school_employees.form.languages,
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
        restrictToNumbers(event, allowedLength=15) {
            const keyCode = event.which ? event.which : event.keyCode;
            const inputChar = String.fromCharCode(keyCode);
            const isValidSpecialChar = /^[\+\-\(\)]$/.test(inputChar);
            const isDigit = /^\d$/.test(inputChar);
            let currentValue = event.target.value + inputChar;
            const digitCount = currentValue.replace(/[^\d]/g, "").length;
            if (!isValidSpecialChar && (!isDigit || digitCount > allowedLength)) {
                event.preventDefault();
            }
        },
        closeModal() {
            this.$store.commit("school_employees/setShowModal", 0);
            this.$store.commit("school_employees/resetForm");
            this.fetchCustomerLangs();
            setTimeout(() => {
                this.$store.commit("school_employees/setForData", {
                    key: "customer_id",
                    language: "",
                    value: this.logged_in_customer,
                });

                this.$store.commit("school_employees/setForData", {
                    key: "school_id",
                    language: "",
                    value: this.school_id,
                });
            }, 500);
        },
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.$store.commit("school_employees/setForData", {
                    key: "image",
                    language: "",
                    value: res?.data,
                });
                if (this.errors.has("image")) {
                    this.errors.clear("image");
                }
            });
        },
        handleInput(e, key, language) {
            const errorKey = language
                ? `${key}.${key}_${language.language_code}`
                : key;
            this.$store.commit("school_employees/setForData", {
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
                .dispatch("school_employees/addUpdateForm")
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.showPopUpModal = true;
                        this.popupMsg = res.data.message;
                        this.$store.commit("school_employees/setLimit", 10);
                        this.$store.commit("school_employees/setSortBy", "id");
                        this.$store.commit(
                            "school_employees/setSortType",
                            "name"
                        );
                        this.$store.dispatch(
                            "school_employees/fetchSchoolEmployees"
                        );
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
                    "/api/web/customer-languages?customer_id=" +
                    this.logged_in_customer
                )
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$store.commit(
                            "school_employees/setLanguages",
                            res.data.data
                        );

                        res.data.data?.filter((lang) => {
                            this.$store.commit("school_employees/setForData", {
                                key: "name",
                                language: lang,
                                value: "",
                            });
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
    watch: {

    }
};
</script>
<style scoped>
/* Slide Animation */
.slide-enter-active,
.slide-leave-active {
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}

.slide-enter-from,
.slide-leave-to {
    transform: translateY(-20px);
    opacity: 0;
}
</style>