<template>
    <div class="w-full md:w-2/3 mx-auto mt-10">
        <div class="">
            <div class="border-b-4 py-2 border-primary mt-6 w-full">
                <h2 class="can-edu-h2">
                    {{
                        sug_page_settings?.sug_page_setting_detail?.length > 0
                            ? sug_page_settings?.sug_page_setting_detail[0]
                                .form_title
                            : ""
                    }}
                </h2>
            </div>
            <div class="flex justify-end mt-4">
                <p class="font-semibold text-red-500">
                    {{ indicate_required_field }}
                </p>
            </div>
            <div>
                <div class="mt-4">
                    <input type="text" :placeholder="sug_page_settings?.sug_page_setting_detail?.length >
                            0
                            ? sug_page_settings?.sug_page_setting_detail[0]
                                .name_placeholder + ' *'
                            : ''
                        " v-model="name"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="position == 'rtl'
                                ? 'border-r-4 rounded-r border-r-primary'
                                : 'border-l-4 rounded-l border-l-primary'
                            " />
                    <error :fieldName="'name'" :validationErros="errors" />
                </div>
                <div class="mt-4">
                    <input type="email" :placeholder="sug_page_settings?.sug_page_setting_detail?.length >
                            0
                            ? sug_page_settings?.sug_page_setting_detail[0]
                                .email_placeholder + ' *'
                            : ''
                        " v-model="email"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="position == 'rtl'
                                ? 'border-r-4 rounded-r border-r-primary'
                                : 'border-l-4 rounded-l border-l-primary'
                            " />
                    <error :fieldName="'email'" :validationErros="errors" />
                </div>
                <div class="mt-4">
                    <textarea name="" id="" cols="30" rows="10" :placeholder="sug_page_settings?.sug_page_setting_detail?.length >
                            0
                            ? sug_page_settings?.sug_page_setting_detail[0]
                                .message_placeholder + ' *'
                            : ''
                        "
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="position == 'rtl'
                                ? 'border-r-4 rounded-r border-r-primary'
                                : 'border-l-4 rounded-l border-l-primary'
                            " v-model="message"></textarea>
                    <error :fieldName="'message'" :validationErros="errors" />
                </div>
            </div>
            <div class="mt-4 text-center">
                <div class="recaptcha">
                    <Error
                    v-if="submitted"
                        fieldName="captcha"
                        :validationErros="errors"
                        full_width="1"
                    />
                </div>
                <br />
                <button class="can-edu-btn-fill whitespace-nowrap" type="button" @click="recaptcha()">
                    {{
                        sug_page_settings?.sug_page_setting_detail?.length > 0
                            ? sug_page_settings?.sug_page_setting_detail[0]
                                .button_text
                            : ""
                    }}
                </button>
            </div>
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
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl text-center pt-10">
                        <p class="text-center can-edu-p mt-2">
                            {{success_message}}                     
                        </p>
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
<script>
// ES6 Modules or TypeScript
import Swal from "sweetalert2";
import axios from "axios";
import ErrorHandling from "./../ErrorHandling";
import vueRecaptcha from "vue3-recaptcha2";
import { load } from "recaptcha-v3";
import Error from "./Error.vue";
export default {
    components: { vueRecaptcha, Error },
    computed: {
        sitekey() {
            return process.env.MIX_RECAPTCHA_SITE_KEY;
        },
    },
    props: [
        "success_message",
        "sug_page_setting",
        "is_logged_id",
        "logged_in_customer",
        "position",
        "indicate_required_field"
    ],
    data() {
        return {
            submitted: false,
            showPopUpModal: false,
            sug_page_settings: null,
            logged_id: null,
            customer_id: "",
            errors: new ErrorHandling(),
            error_message: "",
            activeTab: null,
            showRecaptcha: true,
            toggelSubmitButton: false,
            name: "",
            email: "",
            message: "",
            type: "suggession",
        };
    },
    methods: {
        togglePopUpModal() {
            this.showPopUpModal = !this.showPopUpModal;
            if (!this.showPopUpModal) {
            // window.location.reload();

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


                }
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
        // saveSuggession() {
        //     axios
        //         .post(`${process.env.MIX_WEB_API_URL}contact-us`, {
        //             email: this.email,
        //             name: this.name,
        //             message: this.message,
        //             type: this.type,
        //         })
        //         .then((res) => {
        //             if (res.data.status == "Success") {
        //                 helper.swalSuccessMessage(
        //                     "Thanks for your Suggession we will do the needfull"
        //                 );
        //                 this.name = "";
        //                 this.email = "";
        //                 this.message = "";
        //                 this.errors = new ErrorHandling();
        //                 this.error_message = "";
        //                 localStorage.removeItem("suggession_name");
        //                 localStorage.removeItem("suggession_email");
        //                 localStorage.removeItem("suggession_message");
        //             }
        //             if (res.data.status == "Error") {
        //                 helper.swalErrorMessage(res.data.message);
        //             }
        //         })
        //         .catch((error) => {
        //             this.error_message = "";
        //             this.errors = new ErrorHandling();
        //             if (error.response.status == 422) {
        //                 if (error.response.data.status == "Error") {
        //                     this.$toaster.error(error.response.data.message);
        //                 } else {
        //                     this.errors.record(error.response.data.errors);
        //                 }
        //             }
        //         })
        //         .finally(() => (this.$parent.loading = false));
        // },
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
                        this.saveSuggession();
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
        saveSuggession() {
            axios
                .post(`${process.env.MIX_WEB_API_URL}contact-us`, {
                    email: this.email,
                    name: this.name,
                    message: this.message,
                    type: this.type,
                })
                .then((res) => {
                    if (res.data.status === "Success") {
            this.showPopUpModal = true;
                        // this.showSwal("Thank you for reaching out. Your interest is valued, and we aim to respond to your inquiry within two business days");
                        this.name = "";
                        this.email = "";
                        this.message = "";
                        this.errors = new ErrorHandling();
                        this.error_message = "";
                        localStorage.removeItem("suggession_name");
                        localStorage.removeItem("suggession_email");
                        localStorage.removeItem("suggession_message");
                    }
                    if (res.data.status === "Error") {
                        this.showSwal(res.data.message);
                    }
                })
                .catch((error) => {
                    this.error_message = "";
                    this.errors = new ErrorHandling();
                    if (error.response && error.response.status === 422) {
                        if (error.response.data.status === "Error") {
                            this.showSwal(error.response.data.message);
                        } else {
                            this.errors.record(error.response.data.errors);
                        }
                    }
                })
                .finally(() => (this.$parent.loading = false));
        },

        showSwal(message) {
            Swal.fire({
                text: message,
                showConfirmButton: true, 
                confirmButtonText: "Close",
                allowOutsideClick: false,
                allowEscapeKey: false, 
            });
        },
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutsidePopup);
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutsidePopup);

        // const savedName = localStorage.getItem("suggession_name");
        // if (savedName) {
        //     this.name = savedName;
        // }
        // const savedEmail = localStorage.getItem("suggession_email");
        // if (savedEmail) {
        //     this.email = savedEmail;
        // }
        // const savedMessage = localStorage.getItem("suggession_message");
        // if (savedMessage) {
        //     this.message = savedMessage;
        // }
        localStorage.removeItem("suggession_name");
    localStorage.removeItem("suggession_email");
    localStorage.removeItem("suggession_message");

    this.name = "";
    this.email = "";
    this.message = "";
        this.sug_page_settings = JSON.parse(this.sug_page_setting);
        this.logged_id = this.is_logged_id;
        this.customer_id = this.logged_in_customer;
    },
    watch: {
        name(newValue, oldValue) {
            this.errors.has("name") ? this.errors.clear("name") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("suggession_name", newValue);
            }
        },
        email(newValue, oldValue) {
            this.errors.has("email") ? this.errors.clear("email") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("suggession_email", newValue);
            }
        },
        message(newValue, oldValue) {
            this.errors.has("message") ? this.errors.clear("message") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("suggession_message", newValue);
            }
        },
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