<template>
    <div class="relative -mb-5 flex items-center border border-gray-300 rounded">
        <button class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5" @click="toggleModal">
            {{ button_text }}
        </button>
    </div>

    <transition name="slide">
        <div id="defaultModal" tabindex="-1" aria-hidden="true"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full md:inset-0 md:h-full"
            v-if="showModal">
            <div class="relative w-full bg-white rounded-2xl shadow-2xl border-4 border-primary/30 h-full max-w-2xl md:h-auto overflow-auto"
                ref="elementToDetectClick">
                <!-- Modal content -->
                <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 overflow-y-auto w-full">

                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 rounded-t dark:border-gray-600">
                        <div>
                            <h3 class="can-edu-h3 mb-0">
                                {{
                                    static_translations?.program_suggestion_modal_title
                                        ? static_translations?.program_suggestion_modal_title
                                        : ""
                                }}
                            </h3>
                        </div>
                        <div>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="defaultModal" @click="toggleModal">
                                <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">{{
                                    static_translations?.clos_modal_button_text
                                        ? static_translations?.clos_modal_button_text
                                        : ""
                                }}</span>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-start justify-between p-4">
                        <div class="w-full px-4">
                            <div class="flex justify-end">
                                <p class="text-red-500">
                                    {{ indicate_required_field }}
                                </p>
                            </div>
                            <form @submit.prevent="recaptcha()" class="">
                                <!-- <ul class="flex gap-2 flex-wrap my-4">
                            <li
                                class="mr-2 mb-2"
                                v-for="language in languages"
                                :key="language.id"
                            >
                                <a
                                    @click.prevent="changeLanguageTab(language)"
                                    href="#"
                                    :class="[
                                        'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                        (activeTab == null &&
                                            language.is_default) ||
                                        activeTab == language.id
                                            ? 'text-white bg-primary active'
                                            : '',
                                        errors.has(
                                            `name.name_` + language.id
                                        ) ||
                                        errors.has(
                                            `description.description_` +
                                                language.id
                                        )
                                            ? 'bg-red-600 text-white hover:text-white'
                                            : '',
                                    ]"
                                    >{{ language.name }}</a
                                >
                            </li>
                        </ul> -->

                                <div class="">
                                    <div v-for="(language, key) in languages" :key="language.id" :class="(activeTab == null &&
                                        language.is_default) ||
                                        activeTab == language.id
                                        ? 'block'
                                        : 'hidden'
                                        " class="relative w-full">
                                        <label for="" class="block text-base lg:text-lg">
                                            {{
                                                static_translations?.program_suggestion_name_input_label
                                                    ? static_translations?.program_suggestion_name_input_label
                                                    : ""
                                            }}
                                            <span class="text-primary">*</span>
                                        </label>
                                        <input :key="key" name="name" @input="
                                            handleInput(
                                                $event.target.value,
                                                language.id,
                                                'name'
                                            )
                                            " :value="name['name_' + language.id]"
                                            class="w-full focus:ring-primary focus:ring-1 focus:ring-0.5 focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 mb-1 border"
                                            :class="position == 'rtl'
                                                ? 'border-r-[5px] rounded-r border-r-primary'
                                                : 'border-l-[5px] rounded-l border-l-primary'
                                                " :placeholder="static_translations?.program_suggestion_name_input_placeholder || ''" />
                                        <error :fieldName="'name.name_' + language.id
                                            " :validationErros="errors" />
                                    </div>
                                    <div v-for="(language, key) in languages" :key="language.id" :class="(activeTab == null &&
                                        language.is_default) ||
                                        activeTab == language.id
                                        ? 'block'
                                        : 'hidden'
                                        " class="relative my-4 w-full">
                                        <label for="" class="block text-base lg:text-lg">
                                            {{
                                                static_translations?.program_suggestion_description_input_label
                                                    ? static_translations?.program_suggestion_description_input_label
                                                    : ""
                                            }}
                                            <span class="text-primary">*</span>
                                        </label>
                                        <textarea :key="key" name="description" @input="
                                            handleInput(
                                                $event.target.value,
                                                language.id,
                                                'description'
                                            )
                                            "
                                            class="w-full focus:ring-primary focus:ring-1 focus:ring-.5 focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                            :class="position == 'rtl'
                                                ? 'border-r-[5px] rounded-r border-r-primary'
                                                : 'border-l-[5px] rounded-l border-l-primary'
                                                " :value="description[
                                                    'description_' + language.id
                                                ]

                                                    "
                                            :placeholder="static_translations?.program_suggestion_description_input_placeholder || ''"></textarea>
                                        <!-- <div class="z-10 bottom-14 left-1/4 absolute">
                                    <p
                                        class="tooltiptext line-clamp-2 w-80 px-3 py-1 bg-primary text-white text-center rounded transition-all delay-300 after:absolute after:top-full after:left-1/2 after:-ml-1 after:border-[6px]"
                                        v-if="
                                            errors.has(
                                                'description.description_' +
                                                    language.id
                                            )
                                        "
                                        v-text="
                                            errors.get(
                                                'description.description_' +
                                                    language.id
                                            )
                                        "
                                    ></p>
                                </div> -->
                                        <error :fieldName="'description.description_' +
                                            language.id
                                            " :validationErros="errors" />
                                    </div>

                                    <div class="relative mt-4 w-full">
                                        <label for="" class="block text-base lg:text-lg">
                                            {{
                                                static_translations?.program_suggestion_degree_input_label
                                                    ? static_translations?.program_suggestion_degree_input_label
                                                    : ""
                                            }}
                                            <span class="text-primary">*</span>
                                        </label>
                                        <!-- <select
                                            class="w-full focus:ring-primary focus:ring-1 focus:ring-.5 focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 mb-1"
                                            :class="
                                                position == 'rtl'
                                                    ? 'border-r-[5px] rounded-r border-r-primary'
                                                    : 'border-l-[5px] rounded-l border-l-primary'
                                            "
                                            v-model="degree_id"
                                        >
                                            <option value="">
                                                {{
                                                    static_translations?.degree_input_placeholder
                                                        ? static_translations?.degree_input_placeholder
                                                        : ""
                                                }}
                                            </option>
                                            <option
                                                v-for="(degree, key) in degrees"
                                                :key="key"
                                                :value="degree?.id"
                                            >
                                                {{
                                                    degree?.degree_detail[0]
                                                        ?.name
                                                }}
                                            </option>
                                        </select> -->
                                        <v-select name="degree_id" v-model="degree_id" :options="degrees"
                                            :reduce="(degrees) => degrees.id" label="degree_name" multiple taggable
                                            :placeholder="static_translations?.program_suggestion_degree_input_placeholder || ''">
                                        </v-select>
                                        <!-- <div class="z-10 bottom-14 left-1/4 absolute">
                                    <p
                                        class="tooltiptext line-clamp-2 w-80 px-3 py-1 bg-primary text-white text-center rounded transition-all delay-300 after:absolute after:top-full after:left-1/2 after:-ml-1 after:border-[6px]"
                                        v-if="errors.has('degree_id')"
                                        v-text="errors.get('degree_id')"
                                    ></p>
                                </div> -->
                                        <error :fieldName="'degree_id'" :validationErros="errors" />
                                    </div>
                                </div>
                                <div class="recaptcha">
                                    <Error v-if="submitted" fieldName="captcha" :validationErros="errors"
                                        full_width="1" />
                                </div>
                                <div class="my-8 flex items-center gap-2 justify-center">
                                    <button class="can-edu-btn-fill whitespace-nowrap" type="submit">
                                        {{
                                            static_translations?.program_suggestion_submit_button_text
                                                ? static_translations?.program_suggestion_submit_button_text
                                                : ""
                                        }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <div v-if="logged_in_user_type !== 'school' || (logged_in_user_type === 'school' && is_package_amount_paid <= '0')" class="absolute inset-0 bg-gray-900 pt-0 p-10 h-[110vh] bg-opacity-50 flex justify-center items-center"> -->
                    <div v-if="!is_logged_id"
                        class="absolute top-0 bottom-0 left-0 right-0 bg-black bg-opacity-50 flex justify-center items-center">
                        <div
                            class="relative bg-white py-6 px-10 rounded-2xl shadow-2xl border-4 border-primary/30 text-center overflow-y-auto max-w-lg w-full">
                            <div class="absolute top-4 right-4 cursor-pointer" @click="toggleModal">
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="defaultModal">
                                    <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-center can-edu-p mt-4">You must be a registered customer to suggest programs.
                            </p>
                            <div class="flex justify-center">
                            <button type="button" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4"
                                data-modal-hide="defaultModal" @click="toggleModal">
                                Close
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    <transition name="slide">
        <div id="defaultModal" tabindex="-1"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 md:h-full"
            v-if="showPopUpModal">
            <div class="relative w-full bg-white rounded-2xl shadow-2xl border-4 border-primary/30 h-full max-w-2xl md:h-auto"
                ref="elementToDetectClick">
                <div class="relative">
                    <div class="absolute top-4 right-4 cursor-pointer" @click="togglePopUpModal">
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
                            {{ success_message }} </p>
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
<script>
// ES6 Modules or TypeScript
import Swal from "sweetalert2";
import axios from "axios";
import ErrorHandling from "../ErrorHandling";
import { load } from "recaptcha-v3";
import { mapState } from "vuex";
import vueRecaptcha from "vue3-recaptcha2";
import Error from "./Error.vue";

export default {
    props: [
        "success_message",
        "is_logged_id",
        "logged_in_customer",
        "logged_in_user_type",
        "is_package_amount_paid",
        "school_id",
        "button_text",
        "position",
        "program_translations",
        "lang",
        "lang_id",
        "indicate_required_field",
    ],
    components: {
        vueRecaptcha,
        Error,
    },
    computed: {
        ...mapState({
            languages: (state) => state.languages.languages,
            degrees: (state) => state.degrees.degrees,
        }),
        sitekey() {
            return process.env.MIX_RECAPTCHA_SITE_KEY;
        },
    },
    data() {
        return {
            submitted: false,
            popupMsg: '',
            showPopUpModal: false,
            showModal: false,
            degree_id: "",
            name: {},
            description: {},
            errors: new ErrorHandling(),
            error_message: "",
            activeTab: null,
            showRecaptcha: true,
            toggelSubmitButton: false,
            emailValidationErro: "",
            static_translations: {},
            selectedDegrees: [],
        };
    },
    methods: {
        clearErrors() {
            this.errors.clearAll(); // Clear all error messages
        },
        togglePopUpModal() {
            this.showPopUpModal = !this.showPopUpModal;
            if (!this.showPopUpModal) {
                window.location.reload();
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
                    window.location.reload();


                }
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
                    this.clearErrors()

                }
            }
        },
        toggleModal() {
            this.showModal = !this.showModal;
            this.clearErrors()

        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        handleInput(val, i, key) {
            this[key][key + "_" + i] = val;
            localStorage.setItem("program_" + key, val);
            localStorage.setItem("program_" + key + "_index", i);
        },
        async recaptcha() {
            this.submitted = true;
            // this.loading = 1;
            load(process.env.MIX_reCAPTCHA_site_key_new).then((recaptcha) => {
                recaptcha.showBadge()
                recaptcha.execute("submit").then((token) => {
                    axios
                        .post(`${process.env.MIX_WEB_API_URL}verifyRecaptcha`, {
                            token: token,
                        })
                        .then((res) => {
                            setTimeout(() => {
                                recaptcha.hideBadge()
                            }, 3000);
                            if (res.data.status == "Success") {
                                this.saveNetwork();
                            } else if (res.data.status == "Error") {
                                // this.loading = 0;
                                this.errors.record({
                                    captcha: [res.data.message],
                                });
                            }
                        });
                });
            });
        },

        saveNetwork() {
            // e.preventDefault();
            const data = {
                degree_id: this.degree_id,
                selectedDegrees: this.selectedDegrees,
                name: this.name,
                description: this.description,
                customer_id: this.logged_in_customer,
                is_web: true,
            };
            let justLanguageId = [];
            this.languages.filter((res) => {
                justLanguageId.push(res.id);
            });
            data["language_id"] = justLanguageId;
            axios
                .post("/api/web/programs", data)
                .then((res) => {
                    if (res?.data?.status == "Success") {

                        this.showPopUpModal = true;

                        // helper.swalSuccessMessage(
                        //     "You have create program successfully!"
                        // );
                        localStorage.removeItem("program_name");
                        localStorage.removeItem("program_name_index");
                        localStorage.removeItem("program_description");
                        localStorage.removeItem("program_description_index");
                        localStorage.removeItem("program_degree_id");
                        // window.location.reload();
                    }
                    if (res.data.status == "Error") {
                        helper.swalErrorMessage(res.data.message);
                    }
                })
                .catch((error) => {
                    this.error_message = "";
                    this.errors = new ErrorHandling();
                    if (error.response.status == 422) {
                        if (error.response.data.status == "Error") {
                            helper.swalErrorMessage(
                                error.response.data.message
                            );
                        } else {
                            this.errors.record(error.response.data.errors);
                            this.focusOnFirstErrorInput(error.response.data.errors);
                        }
                    }
                })
                .finally(() => (this.$parent.loading = false));
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
        recaptchaVerified(response) {
            this.toggelSubmitButton = true;
        },
        recaptchaExpired() {
            this.toggelSubmitButton = false;
            this.$refs.vueRecaptcha.reset();
        },
        recaptchaFailed() {
            this.toggelSubmitButton = false;
        },
    },
    created() {
        console.log("program_translations:", this.program_translations);
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_WEB_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                data.map((res, i) => {
                    this.name["name_" + res?.id] = "";
                    this.description["description_" + res?.id] = "";

                    const savedProgramName =
                        localStorage.getItem("program_name");
                    const savedProgramNameIndex =
                        localStorage.getItem("program_name_index");
                    if (savedProgramName && savedProgramNameIndex) {
                        this.name["name_" + parseInt(savedProgramNameIndex)] =
                            savedProgramName;
                    }

                    const savedProgramDesc = localStorage.getItem(
                        "program_description"
                    );
                    const savedProgramDescIndex = localStorage.getItem(
                        "program_description_index"
                    );
                    if (savedProgramDesc && savedProgramDescIndex) {
                        this.description[
                            "description_" + parseInt(savedProgramDescIndex)
                        ] = savedProgramDesc;
                    }
                });
            });
        this.$store.commit("degrees/setLimit", 100);
        this.$store.commit("degrees/setSortBy", "id");
        this.$store.commit("degrees/setSortType", "desc");
        this.$store.dispatch("degrees/fetchDegrees");
        this.static_translations = JSON.parse(this.program_translations);
        this.activeTab = this.lang_id;
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutsidePopup);

        // // Add a click event listener to the document
        // const savedDegreeId = localStorage.getItem("program_degree_id");
        // if (savedDegreeId) {
        //     this.degree_id = savedDegreeId;
        // }

        if (performance.navigation.type !== performance.navigation.TYPE_RELOAD) {
            // Clear local storage only on page navigation
            localStorage.removeItem("program_degree_id");
            localStorage.removeItem("program_name");
            localStorage.removeItem("program_name_index");
            localStorage.removeItem("program_description");
            localStorage.removeItem("program_description_index");

            // Reset fields
            this.degree_id = "";
            Object.keys(this.name).forEach(key => {
                this.name[key] = "";
            });
            Object.keys(this.description).forEach(key => {
                this.description[key] = "";
            });
        }

        document.addEventListener("click", this.handleClickOutside);
    },
    beforeUnmount() {
        // Remove the click event listener when the component is unmounted
        document.removeEventListener("click", this.handleClickOutside);

        document.removeEventListener("click", this.handleClickOutsidePopup);
    },
    watch: {
        "name": {
            handler(newValue) {
                Object.keys(newValue).forEach((key) => {
                    if (this.errors.has(`name.${key}`)) {
                        this.errors.clear(`name.${key}`);
                    }
                    if (newValue[key] && newValue[key] !== "") {
                        localStorage.setItem(`become_sponsor_name_${key}`, newValue[key]);
                    }
                });
            },
            deep: true, // Ensures Vue detects changes inside the object
        },
        "description": {
            handler(newValue) {
                Object.keys(newValue).forEach((key) => {
                    if (this.errors.has(`description.${key}`)) {
                        this.errors.clear(`description.${key}`);
                    }
                    if (newValue[key] && newValue[key] !== "") {
                        localStorage.setItem(`become_sponsor_description_${key}`, newValue[key]);
                    }
                });
            },
            deep: true,
        },
        // name(newValue, oldValue) {
        //     if (newValue && newValue != "") {
        //         localStorage.setItem("contact_business_name", newValue);
        //     }
        // },
        // email(newValue, oldValue) {
        //     if (newValue && newValue != "") {
        //         localStorage.setItem("contact_business_email", newValue);
        //     }
        // },
        // degree_id(newValue, oldValue) {
        //     if (newValue && newValue != "") {
        //         localStorage.setItem("program_degree_id", newValue);
        //     }
        // },
    },
};
</script>
