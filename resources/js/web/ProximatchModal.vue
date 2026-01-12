<template>
    <div>
        <!-- Modal content -->
        <div class="mt-6 bg-white px-4 py-6 border shadow rounded-md w-full">
            <div class="flex justify-end">
                <p class="text-red-500">
                    {{ indicate_required_field }}
                </p>
            </div>
            <form @submit.prevent="recaptcha()" class="mt-4">
                <div class="mt-3">
                    <label for="" class="block text-base lg:text-lg">{{
                        static_translations?.proxima_request_setting_detail[0]?.name_label
                            ? static_translations?.proxima_request_setting_detail[0]?.name_label
                            : ""
                    }}
                        <span class="text-primary">*</span>
                    </label>

                    <div class="relative w-full">
                        <input type="text" name="name"
                            class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                            :class="position == 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                                " v-model="name"
                            :placeholder="static_translations?.proxima_request_setting_detail[0]?.name_placeholder || ''" />
                        <error :fieldName="'name'" :validationErros="errors" />
                        <!-- <error :fieldName="'name'" :validationErros="errors">
                            
                                <p v-if="static_translations?.proxima_request_setting_detail[0]?.name_error" class="text-red-500 text-sm mt-1">
                                    {{ static_translations?.proxima_request_setting_detail[0]?.name_error }}
                                </p>
                         </error> -->

                    </div>
                </div>

                <div class="mt-3">
                    <label for="" class="block text-base lg:text-lg">{{
                        static_translations?.proxima_request_setting_detail[0]?.phone_label
                            ? static_translations?.proxima_request_setting_detail[0]?.phone_label
                            : ""
                    }}
                        <span class="text-primary">*</span>
                    </label>

                    <div class="relative w-full">
                        <input type="text" name="phone"
                            class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                            :class="position == 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                                " v-model="phone"
                            :placeholder="static_translations?.proxima_request_setting_detail[0]?.phone_placeholder || ''" 
                            @keypress="restrictToNumbers($event, 15)"/>
                        <error :fieldName="'phone'" :validationErros="errors" />
                    </div>
                </div>

                <div class="mt-3">
                    <label for="" class="block text-base lg:text-lg">{{
                        static_translations?.proxima_request_setting_detail[0]?.email_label
                            ? static_translations?.proxima_request_setting_detail[0]?.email_label
                            : ""
                    }}
                        <span class="text-primary">*</span>
                    </label>

                    <div class="relative w-full">
                        <input type="text" name="email"
                            class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                            :class="position == 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                                " v-model="email"
                            :placeholder="static_translations?.proxima_request_setting_detail[0]?.email_placeholder || ''" />

                        <error :fieldName="'email'" :validationErros="errors" />
                    </div>
                </div>

                <div class="mt-3">
                    <label for="" class="block text-base lg:text-lg">{{
                        static_translations?.proxima_request_setting_detail[0]?.inquiry_label
                            ? static_translations?.proxima_request_setting_detail[0]?.inquiry_label
                            : ""
                    }}
                        <span class="text-primary">*</span>
                    </label>

                    <div class="relative w-full">
                        <textarea cols="12" rows="12" name="inquiry"
                            class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                            :class="position == 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                                " v-model="inquiry"
                            :placeholder="static_translations?.proxima_request_setting_detail[0]?.inquiry_placeholder || ''"></textarea>
                        <error :fieldName="'inquiry'" :validationErros="errors" />
                    </div>
                </div>
                <div class="flex items-center mt-4 mb-4">
                    <input id="default-checkbox" name="send_me_a_copy" type="checkbox" value="" v-model="send_me_a_copy" />
                    <label for="default-checkbox" class="ml-2 text-black">Send me a copy
                    </label>
                </div>
                <br />
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
                                class="can-edu-btn-fill"
                                @click="toggleModal"
                            >
                                {{
                                    static_translations?.close_modal_button_text
                                        ? static_translations?.close_modal_button_text
                                        : ""
                                }}
                            </button> -->
                    <button class="can-edu-btn-fill whitespace-nowrap" type="submit">
                        {{
                            static_translations?.proxima_request_setting_detail[0]?.button_text
                                ? static_translations?.proxima_request_setting_detail[0]?.button_text
                                : ""
                        }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <transition name="slide">
        <div id="defaultModal" tabindex="-1" 
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="showPopUpModal">
            <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                ref="elementToDetectClick">
                <div class="relative">
                    <div class="absolute top-3 right-3 cursor-pointer" @click="togglePopUpModal">
                        <button type="button" class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                            <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                        <p class="text-center can-edu-p mt-2">
                            {{success_message}}                        </p>
                            <div class="flex justify-center">
                        <button type="button" class="can-edu-btn-fill  whitespace-nowrap px-2.5 md:px-5 mt-4" @click="togglePopUpModal">
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
// ES6 Modules or TypeScript
import Swal from "sweetalert2";
import axios from "axios";
import { load } from "recaptcha-v3";
import ErrorHandling from "../ErrorHandling";
import { mapState } from "vuex";
import vueRecaptcha from "vue3-recaptcha2";
import Error from "./Error.vue";

export default {
    props: [
        "success_message",
        "is_logged_id",
        "position",
        "program_setting",
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
            submitted: false,
            showPopUpModal: false,
            programSettingDetail: {},
            showModal: false,
            name: "",
            phone: "",
            email: "",
            inquiry: "",
            send_me_a_copy: false,
            errors: new ErrorHandling(),
            error_message: "",
            activeTab: null,
            showRecaptcha: true,
            toggelSubmitButton: false,
            emailValidationErro: "",
            static_translations: {},
        };
    },
    methods: {
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
        restrictToNumbers(event, allowedLength) {
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
        validateEmail(e) {
            this.emailValidationErro = "";
            if (
                /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(
                    e.target.value
                )
            ) {
                return true;
            } else {
                // this.emailValidationErro =
                //     "please use this format your@email.com";
            }
            return false;
        },
        toggleModal() {
            this.showModal = !this.showModal;
            // if (!this.is_logged_id) {
            //     window.location.href = "/login";
            // }
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
                name: this.name,
                email: this.email,
                phone: this.phone,
                inquiry: this.inquiry,
                image: this.image,
                send_me_a_copy: this.send_me_a_copy,
            };
            axios
                .post("/api/web/proxima_requests", data)
                .then((res) => {
                    if (res?.data?.status == "Success") {
            this.showPopUpModal = true;

                        // helper.swalSuccessMessage(
                        //     "Your request has been submitted!"
                        // );
                        localStorage.removeItem("proximatch_name");
                        localStorage.removeItem("proximatch_phone");
                        localStorage.removeItem("proximatch_email");
                        localStorage.removeItem("proximatch_inquiry");
                        localStorage.removeItem("proximatch_send_me_a_copy");
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
        handleClickOutside(event) {
            if (
                this.$refs.elementToDetectClick &&
                event.target.contains(this.$refs.elementToDetectClick)
            ) {
                if (this.showModal == true) {
                    this.showModal = false;
                }
            }
        },
        clearLocalStorage() {
            localStorage.removeItem("proximatch_name");
            localStorage.removeItem("proximatch_phone");
            localStorage.removeItem("proximatch_email");
            localStorage.removeItem("proximatch_inquiry");
            localStorage.removeItem("proximatch_send_me_a_copy");
        }
    },

    beforeDestroy() {
        window.removeEventListener("beforeunload", this.clearLocalStorage);
    },
    created() {
        // if (!this.is_logged_id) {
        //     window.location.href =
        //         "/" + this.lang + "/login?url=" + window.location.href;
        // }
        this.static_translations = JSON.parse(this.program_setting);
    
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutsidePopup);
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutsidePopup);
    
        const savedName = localStorage.getItem("proximatch_name");
        if (savedName) {
            this.name = savedName;
        }
        const savedPhone = localStorage.getItem("proximatch_phone");
        if (savedPhone) {
            this.phone = savedPhone;
        }

        const savedEmail = localStorage.getItem("proximatch_email");
        if (savedEmail) {
            this.email = savedEmail;
        }
        const savedInquiry = localStorage.getItem("proximatch_inquiry");
        if (savedInquiry) {
            this.inquiry = savedInquiry;
        }
        const savedSendMeACopy = localStorage.getItem("proximatch_send_me_a_copy");
        if (savedSendMeACopy) {
            this.send_me_a_copy = savedSendMeACopy;
        }
        document.addEventListener("click", this.handleClickOutside);
        window.addEventListener("beforeunload", this.clearLocalStorage);
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutside);
    },
    watch: {
        name(newValue, oldValue) {
            this.errors?.has("name") ? this.errors.clear("name") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("proximatch_name", newValue);
            }
        },
        phone(newValue, oldValue) {
            this.errors?.has("phone") ? this.errors.clear("phone") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("proximatch_phone", newValue);
            }
        },
        email(newValue, oldValue) {
            this.errors?.has("email") ? this.errors.clear("email") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("proximatch_email", newValue);
            }
        },
        inquiry(newValue, oldValue) {
            this.errors?.has("inquiry") ? this.errors.clear("inquiry") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("proximatch_inquiry", newValue);
            }
        },
        send_me_a_copy(newValue, oldValue) {
            this.errors?.has("send_me_a_copy") ? this.errors.clear("send_me_a_copy") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("proximatch_send_me_a_copy", newValue);
            }
        },

    },
};
</script>
