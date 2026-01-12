<template>
    <div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">
        <div class="flex">
            <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                <div class="">
                    <div class="border-b-4 pb-2 border-primary w-full">
                        <h1 class="can-edu-h1">
                            {{
                                contact_setting?.contact_page_setting_detail
                                    .length > 0
                                    ? contact_setting
                                        ?.contact_page_setting_detail[0]
                                        ?.page_title_1
                                    : ""
                            }}
                        </h1>
                    </div>

                    <div class="mt-10">
                        <div class="text-black">
                            <p v-html="contact_setting?.contact_page_setting_detail
                                .length > 0
                                ? contact_setting
                                    ?.contact_page_setting_detail[0]
                                    ?.description
                                : ''
                                "></p>
                        </div>
                        <div class="mt-4">
                            <div class="grid grid-cols-12 mt-2">
                                <div class="col-span-5">
                                    <p class="font-bold text-gray-950">
                                        {{
                                            contact_setting
                                                ?.contact_page_setting_detail
                                                .length > 0
                                                ? contact_setting
                                                    ?.contact_page_setting_detail[0]
                                                    ?.mainling_address_lable
                                                : ""
                                        }}
                                    </p>
                                </div>
                                <div class="col-span-1 font-extrabold flex justify-center">
                                    <p>:</p>
                                </div>
                                <div class="col-span-6 text-gray-700 break-words">
                                    <p v-html="contact_setting
                                        ?.contact_page_setting_detail
                                        .length > 0
                                        ? contact_setting
                                            ?.contact_page_setting_detail[0]
                                            ?.mainling_address
                                        : ''
                                        "></p>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 mt-2">
                                <div class="col-span-5">
                                    <p class="font-bold text-gray-950">
                                        {{
                                            contact_setting
                                                ?.contact_page_setting_detail
                                                .length > 0
                                                ? contact_setting
                                                    ?.contact_page_setting_detail[0]
                                                    ?.toll_free_lable
                                                : ""
                                        }}
                                    </p>
                                </div>
                                <div class="col-span-1 font-extrabold flex justify-center">
                                    <p>:</p>
                                </div>
                                <div class="col-span-6 text-gray-700 break-words">
                                    <p>
                                        {{
                                            contact_setting
                                                ?.contact_page_setting_detail
                                                .length > 0
                                                ? contact_setting
                                                    ?.contact_page_setting_detail[0]
                                                    ?.toll_free
                                                : ""
                                        }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-2">
                                <div class="col-span-5">
                                    <p class="font-bold text-gray-950">
                                        {{
                                            contact_setting
                                                ?.contact_page_setting_detail
                                                .length > 0
                                                ? contact_setting
                                                    ?.contact_page_setting_detail[0]
                                                    ?.phone_lable
                                                : ""
                                        }}
                                    </p>
                                </div>
                                <div class="col-span-1 font-extrabold flex justify-center">
                                    <p>:</p>
                                </div>
                                <div class="col-span-6 text-gray-700 break-words">
                                    <p>
                                        {{
                                            contact_setting
                                                ?.contact_page_setting_detail
                                                .length > 0
                                                ? contact_setting
                                                    ?.contact_page_setting_detail[0]
                                                    ?.phone
                                                : ""
                                        }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-2">
                                <div class="col-span-5">
                                    <p class="font-bold text-gray-950">
                                        {{
                                            contact_setting
                                                ?.contact_page_setting_detail
                                                .length > 0
                                                ? contact_setting
                                                    ?.contact_page_setting_detail[0]
                                                    ?.email_lable
                                                : ""
                                        }}
                                    </p>
                                </div>
                                <div class="col-span-1 font-extrabold flex justify-center">
                                    <p>:</p>
                                </div>
                                <div class="col-span-6 text-gray-700 break-words">
                                    <p>
                                        {{
                                            contact_setting
                                                ?.contact_page_setting_detail
                                                .length > 0
                                                ? contact_setting
                                                    ?.contact_page_setting_detail[0]
                                                    ?.email
                                                : ""
                                        }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 mt-2">
                                <div class="col-span-5">
                                    <p class="font-bold text-gray-950">
                                        {{
                                            contact_setting
                                                ?.contact_page_setting_detail
                                                .length > 0
                                                ? contact_setting
                                                    ?.contact_page_setting_detail[0]
                                                    ?.website_lable
                                                : ""
                                        }}
                                    </p>
                                </div>
                                <div class="col-span-1 font-extrabold flex justify-center">
                                    <p>:</p>
                                </div>
                                <div class="col-span-6 text-gray-700 break-words">
                                    <p>
                                        <a href="javascript:void(0);" class="text-primary hover:underline font-medium">
                                            {{
                                                contact_setting
                                                    ?.contact_page_setting_detail
                                                    .length > 0
                                                    ? contact_setting
                                                        ?.contact_page_setting_detail[0]
                                                        ?.website
                                                    : ""
                                            }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="border-b-4 pb-2 border-primary w-full">
                        <h1 class="can-edu-h1">
                            {{
                                contact_setting?.contact_page_setting_detail
                                    .length > 0
                                    ? contact_setting
                                        ?.contact_page_setting_detail[0]
                                        ?.page_title_2
                                    : ""
                            }}
                        </h1>
                    </div>
                    <div class="flex justify-end mt-4">
                        <p class="font-semibold text-red-500">
                            {{ indicate_required_field }}
                        </p>
                    </div>
                    <div class="mt-10">
                        <div class="relative">
                            <input type="text" :placeholder="contact_setting?.contact_page_setting_detail
                                .length > 0
                                ? contact_setting
                                    ?.contact_page_setting_detail[0]
                                    ?.name_input_placeholder + ' *'
                                : ''
                                " v-model="name"
                                class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                :class="position == 'rtl'
                                    ? 'border-r-4 rounded-r border-r-primary'
                                    : 'border-l-4 rounded-l border-l-primary'
                                    " />
                            <error :fieldName="'name'" :validationErros="errors" />
                        </div>
                        <div class="mt-4 relative">
                            <input type="email" :placeholder="contact_setting?.contact_page_setting_detail
                                .length > 0
                                ? contact_setting
                                    ?.contact_page_setting_detail[0]
                                    ?.email_input_placeholder + ' *'
                                : ''
                                " @change="validateEmail($event)" v-model="email"
                                class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                :class="position == 'rtl'
                                    ? 'border-r-4 rounded-r border-r-primary'
                                    : 'border-l-4 rounded-l border-l-primary'
                                    " />
                            <error :fieldName="'email'" :validationErros="errors" />
                            <!-- <small class="text-red-600 text-sm mt-2" v-if="emailValidationErro != ''"
                                v-text="emailValidationErro"></small> -->
                        </div>
                        <div class="mt-4 relative">
                            <textarea name="" id="" cols="30" rows="10" :placeholder="contact_setting?.contact_page_setting_detail
                                .length > 0
                                ? contact_setting
                                    ?.contact_page_setting_detail[0]
                                    ?.message_input_placeholder + ' *'
                                : ''
                                " v-model="message"
                                class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                :class="position == 'rtl'
                                    ? 'border-r-4 rounded-r border-r-primary'
                                    : 'border-l-4 rounded-l border-l-primary'
                                    "></textarea>
                            <error :fieldName="'message'" :validationErros="errors" />
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
                    <div class="mt-4 text-center">
                        <button class="can-edu-btn-fill w-56 text-white whitespace-nowrap" @click="recaptcha()">
                            {{
                                contact_setting?.contact_page_setting_detail
                                    .length > 0
                                    ? contact_setting
                                        ?.contact_page_setting_detail[0]
                                        ?.button_text
                                    : ""
                            }}
                        </button>
                    </div>
                </div>
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
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
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
import vueRecaptcha from "vue3-recaptcha2";
import axios from "axios";
import ErrorHandling from "./../ErrorHandling";
import { load } from "recaptcha-v3";
import Swal from "sweetalert2";
import Error from "./Error.vue";
export default {
    props: ["contact_page_setting", "position", "indicate_required_field","success_message"],
    components: {
        vueRecaptcha,
        Error,
    },
    computed: {
        sitekey() {
            return process.env.MIX_RECAPTCHA_SITE_KEY;
        },
    },
    data() {
        return {
            submitted: false,
            showPopUpModal: false,
            name: "",
            email: "",
            message: "",
            type: "contact",
            errors: new ErrorHandling(),
            error_message: "",
            contact_setting: null,
            showRecaptcha: true,
            toggelSubmitButton: false,
            emailValidationErro: "",
        };
    },
    methods: {
        togglePopUpModal() {
            this.showPopUpModal = !this.showPopUpModal;
            if (!this.showPopUpModal) {
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

                }
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
                //this.emailValidationErro =
                  //  "please use this format your@email.com";
            }
            return false;
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
        // contactUs() {
        //     console.log(this.name, this.email, this.message);
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
        //                     "Thanks for contact us we have received your information"
        //                 );
        //                 this.name = "";
        //                 this.email = "";
        //                 this.message = "";
        //                 this.errors = new ErrorHandling();
        //                 this.error_message = "";
        //                 localStorage.removeItem("contact_us_name");
        //                 localStorage.removeItem("contact_us_email");
        //                 localStorage.removeItem("contact_us_message");
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
        //                     helper.swalErrorMessage(
        //                         error.response.data.message
        //                     );
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
                        this.contactUs();
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
        contactUs() {
            console.log(this.name, this.email, this.message);
            axios
                .post(`${process.env.MIX_WEB_API_URL}contact-us`, {
                    email: this.email,
                    name: this.name,
                    message: this.message,
                    type: this.type,
                })
                .then((res) => {
                    if (res.data.status === "Success") {
                        this.showPopUpModal=true;
                 

                        this.name = "";
                        this.email = "";
                        this.message = "";
                        this.errors = new ErrorHandling();
                        this.error_message = "";
                        localStorage.removeItem("contact_us_name");
                        localStorage.removeItem("contact_us_email");
                        localStorage.removeItem("contact_us_message");
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
        // const savedName = localStorage.getItem("contact_us_name");
        // if (savedName) {
        //     this.name = savedName;
        // }
        // const savedEmail = localStorage.getItem("contact_us_email");
        // if (savedEmail) {
        //     this.email = savedEmail;
        // }
        // const savedMessage = localStorage.getItem("contact_us_message");
        // if (savedMessage) {
        //     this.message = savedMessage;
        // }
        localStorage.removeItem("contact_us_name");
        localStorage.removeItem("contact_us_email");
        localStorage.removeItem("contact_us_message");

        this.name = "";
        this.email = "";
        this.message = "";
        this.contact_setting = JSON.parse(this.contact_page_setting);
    },
    watch: {
        name(newValue, oldValue) {
            this.errors.has("name") ? this.errors.clear("name") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("contact_us_name", newValue);
            }
        },
        email(newValue, oldValue) {
            this.errors.has("email") ? this.errors.clear("email") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("contact_us_email", newValue);
            }
        },
        message(newValue, oldValue) {
            this.errors.has("message") ? this.errors.clear("message") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("contact_us_message", newValue);
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