<template>
    <div class="bg-white mx-auto">

            <div class="flex justify-end">
                <p class="text-red-500">
                    {{ indicate_required_field }}
                </p>
            </div>
            <form @submit.prevent="recaptcha()">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template v-for="(language, key) in languages" :key="language.id">
                        <div :class="(activeTab == null && language.is_default) ||
                            activeTab == language.id
                            ? 'block'
                            : 'hidden'
                            " class="relative md:col-span-2">
                            <label class="block text-base lg:text-lg">{{
                                static_translations?.class_name_label
                                    ? static_translations?.class_name_label
                                : ""
                                }}
                                <span class="text-primary">*</span>
                            </label>
                            <input name="class_name" :key="key" :value="class_name['class_name_' + language.id]"
                                @input="handleInput($event.target.value, language.id, 'class_name')"
                                class="border w-full focus:ring-primary mb-2 focus:outline-none px-4 py-1.5 rounded border-gray-300"
                                :class="position == 'rtl'
                                    ? 'border-r-[5px] rounded-r border-r-primary'
                                    : 'border-l-[5px] rounded-l border-l-primary'
                                    "
                                    :placeholder="static_translations?.class_name_placeholder
                                    ? static_translations?.class_name_placeholder
                                    : ''
                                    " />
                            <error :fieldName="'class_name.class_name_' + language.id" :validationErros="errors" />
                        </div>
                        <div :class="(activeTab == null && language.is_default) ||
                            activeTab == language.id
                            ? 'block'
                            : 'hidden'
                            " class="relative md:col-span-2">
                            <label class="block text-base lg:text-lg">{{
                                static_translations?.class_name_definition_label
                                    ? static_translations?.class_name_definition_label
                                : ""
                                }}
                                <span class="text-primary">*</span>
                            </label>
                            <textarea name="class_definition"  class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300" rows="2" :key="key" @input="
                                handleInput(
                                    $event.target.value,
                                    language.id,
                                    'class_definition'
                                )
                                " 
                                :placeholder="static_translations?.class_name_definition_placeholder
                                ? static_translations?.class_name_definition_placeholder
                                : ''
                                "
                                :class="position == 'rtl'
                                    ? 'border-r-[5px] rounded-r border-r-primary'
                                    : 'border-l-[5px] rounded-l border-l-primary'
                                    " :value="class_definition['class_definition_' + language.id]"></textarea>
                            <error :fieldName="'class_definition.class_definition_' + language.id"
                                :validationErros="errors" />
                        </div>
                    </template>

                    <div class="relative z-0 w-full group flex items-center space-x-2">
                        <input
                            type="checkbox"
                            name="hot"
                            id="hot"
                            placeholder=" "
                            v-model="hot"
                        />
                        <label
                            for="hot"
                            class="text-base text-gray-700"
                            >{{
                                static_translations?.hot_listing_checkbox_label
                                  ? static_translations?.hot_listing_checkbox_label
                                  : ""
                              }}</label
                        >
                        <error :fieldName="'hot'" :validationErros="errors" />
                    </div>
                </div>
                <div class="recaptcha">
                    <Error
                    v-if="submitted"
                        fieldName="captcha"
                        :validationErros="errors"
                        full_width="1"
                    />
                </div>
                <div class="my-8 flex items-center gap-2 justify-center">
                    <!-- <button
                      class="can-edu-btn-fill whitespace-nowrap"
                      @click="toggleModal"
                  >
                      {{
                          static_translations?.close_button_text
                              ? static_translations?.close_button_text
                              : ""
                      }}
                  </button> -->
                    <button class="can-edu-btn-fill whitespace-nowrap" type="submit">
                        {{
                            static_translations?.career_submit_button_text
                                ? static_translations?.career_submit_button_text
                                : ""
                        }}
                    </button>
                </div>
            </form>
        
      
    </div>
</template>
<script>
// ES6 Modules or TypeScript
import Swal from "sweetalert2";
import axios from "axios";
import ErrorHandling from "../ErrorHandling";
import { mapState } from "vuex";
import { load } from "recaptcha-v3";
import vueRecaptcha from "vue3-recaptcha2";
import Error from "./Error.vue";

export default {
    props: [
        "is_logged_id",
        "logged_in_customer",
        "school_id",
        "lang",
        "lang_id",
        "career_modal_translation",
        "position",
        "indicate_required_field",
    ],
    components: {
        vueRecaptcha,
        Error,
    },
    computed: {
        ...mapState({
            languages: (state) => state.languages.languages,
        }),
        sitekey() {
            return process.env.MIX_RECAPTCHA_SITE_KEY;
        },
    },
    data() {
        return {
            hot: false,
            class_name: {},
            class_definition: {},
            errors: new ErrorHandling(),
            error_message: "",
            activeTab: null,
            showRecaptcha: true,
            toggelSubmitButton: false,
            emailValidationErro: "",
            static_translations: [],
            submitted: false,
        };
    },
    methods: {
        restrictToNumbers(event, allowedLength) {
            const keyCode = event.which ? event.which : event.keyCode;
            const inputChar = String.fromCharCode(keyCode);
            const valid = /^\d$|^[\+\-\(\)]$/.test(inputChar);
            const maxLengthReached = event.target.value.length >= allowedLength;
            if (!valid || maxLengthReached) {
                event.preventDefault();
            }
            return true;
        },
        handleClickOutside(event) {
            if (
                this.$refs.elementToDetectClick &&
                !this.$refs.elementToDetectClick.contains(event.target)
            ) {
                if (this.showModal) {
                    this.showModal = false;
                    window.location.href = "/" + this.lang + "/careers";
                }
            }
        },


        toggleModal() {
            this.showModal = !this.showModal;
            if (!this.showModal) {
                window.location.href = "/" + this.lang + "/careers";
            }
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        handleInput(val, languageId, key) {
            const fieldName = `${key}.${key}_${languageId}`;
            this[key][`${key}_${languageId}`] = val;

            if (this.errors.has(fieldName)) {
                this.errors.clear(fieldName);
            }

            localStorage.setItem(`career_${key}_${languageId}`, val);
            localStorage.setItem(`career_${key}_index`, languageId);
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
                class_name: this.class_name,
                class_definition: this.class_definition,
                hot: this.hot,
                is_web: true,
            };
            let justLanguageId = [];
            this.languages.filter((res) => {
                justLanguageId.push(res.id);
            });
            data["language_id"] = justLanguageId;
            axios
                .post("/api/web/careers", data)
                .then((res) => {
                    if (res?.data?.status == "Success") {
                        helper.swalSuccessMessage("You have created career successfully!");
                        let careerfields = [
                            "hot",
                        ];
                        careerfields?.map((f) => {
                            const savedField = localStorage.removeItem("career_" + f);
                        });
                        let multiKeys = ["class_name", "class_definition"];
                        multiKeys.map((field) => {
                            localStorage.removeItem("career_" + field);
                            localStorage.removeItem("career_" + field + "_index");
                        });
                        window.location.reload();
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
                            helper.swalErrorMessage(error.response.data.message);
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
        // if (!this.is_logged_id) {
        //     window.location.href =
        //     window.location.href = "/" + this.lang + "/careers";
        // }

        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_WEB_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;

                data.forEach((res) => {
                    this.title["class_name_" + res?.id] = "";
                    this.description["class_definition_" + res?.id] = "";
                });

                localStorage.removeItem("class_name");
                localStorage.removeItem("class_name_index");
                localStorage.removeItem("class_definition_");
                localStorage.removeItem("class_definition_index");
            });

        this.activeTab = this.lang_id;
        this.static_translations = JSON.parse(this.career_modal_translation);
    },

    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutside);
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutside);
        this.toggleModal();
        let careerfields = [
            "hot",
        ];
        careerfields?.map((f) => {
            this[f] = "";
        });
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