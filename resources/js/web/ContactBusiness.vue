<template>
    <div class="relative mt-3 mb-3 flex items-center border border-gray-300 rounded">
        <button
            @click="toggleModal"
            class="flex items-center space-x-1 md:space-x-2 shadow px-2 md:px-5 can-edu-btn-fill font-medium"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-5 h-5 mr-2"
            >
                <path
                    d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z"
                />
                <path
                    d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z"
                />
            </svg>
            <!-- {{
                static_translations?.open_modal_button_text
                    ? static_translations?.open_modal_button_text
                    : ""
            }} -->
            {{ static_translations?.open_modal_button_text || "" }} {{ business_name ? `${business_name}` : "Contact buisness" }}
        </button>
    </div>
    <transition name="slide">
        <div
            id="defaultModal"
            tabindex="-1"
            aria-hidden="true"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="showModal"
        >
            <div
                class="relative w-full h-full max-w-2xl h-[90vh] rounded-2xl shadow-2xl bg-white border-4 border-primary/30 overflow-auto"
                ref="elementToDetectClick"
            >
                <!-- Modal content -->
                <div class="bg-white container mx-auto">
                    <!-- Modal header -->
                    <div
                        class="flex items-start justify-between p-4 rounded-t dark:border-gray-600"
                    >
                        <h3 class="can-edu-h3 mb-0">
                            <!-- {{
                                static_translations?.modal_title
                                    ? static_translations?.modal_title
                                    : ""
                            }} -->
                            <!-- {{ business_name ? `Contact ${business_name}` : "Contact BusinessSS" }} -->
                            {{ static_translations?.modal_title || "" }} {{ business_name ? `${business_name}` : "Contact buisness" }}
                        </h3>
                        <button
                            type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
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
                                static_translations?.business_close_modal_button_text
                                    ? static_translations?.business_close_modal_button_text
                                    : ""
                            }}</span>
                        </button>
                    </div>
                    <div class="flex justify-end">
                        <p class="text-red-500 mt-2">
                            {{ indicate_required_field }}
                        </p>
                    </div>
                    <div class="px-0 py-4 md:p-4">
                        <form @submit.prevent="recaptcha()" class="my-4">
                            <div class="relative">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                >
                                    {{
                                        static_translations?.business_name_input_label
                                            ? static_translations?.business_name_input_label
                                            : ""
                                    }}
                                    <span class="text-primary">*</span>
                                </label>
                                <input
                                    type="text"
                                    :placeholder="
                                        static_translations?.business_name_input_placeholder
                                            ? static_translations?.business_name_input_placeholder
                                            : ''
                                    "
                                    @input="removeValidationErros('name')"
                                    v-model="name"
                                    class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-[5px] rounded-r border-r-primary'
                                            : 'border-l-[5px] rounded-l border-l-primary'
                                    "
                                />
                                <error
                                    class="whitespace-nowrap w-fit"
                                    full_width="true"
                                    :fieldName="'name'"
                                    :validationErros="errors"
                                />
                            </div>
                            <div class="mt-4 relative">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                >
                                    {{
                                        static_translations?.business_email_input_label
                                            ? static_translations?.business_email_input_label
                                            : ""
                                    }}
                                    <span class="text-primary">*</span>
                                </label>
                                <input 
                                    type="text"
                                    :placeholder="
                                        static_translations?.business_email_input_placeholder
                                            ? static_translations?.business_email_input_placeholder
                                            : ''
                                    "
                                    @input="removeValidationErros('email')"
                                    v-model="email"
                                    class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-[5px] rounded-r border-r-primary'
                                            : 'border-l-[5px] rounded-l border-l-primary'
                                    "
                                />
                                <error
                                    class="whitespace-nowrap w-fit"
                                    full_width="true"
                                    :fieldName="'email'"
                                    :validationErros="errors"
                                />
                            </div>
                            <div class="mt-4 relative">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                >
                                    {{
                                        static_translations?.business_message_input_label
                                            ? static_translations?.business_message_input_label
                                            : ""
                                    }}
                                    <span class="text-primary">*</span>
                                </label>
                                <textarea
                                    name=""
                                    id=""
                                    cols="30"
                                    rows="10"
                                    :placeholder="
                                        static_translations?.business_message_input_placeholder
                                            ? static_translations?.business_message_input_placeholder
                                            : ''
                                    "
                                    @input="removeValidationErros('message')"
                                    v-model="message"
                                    class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-[5px] rounded-r border-r-primary'
                                            : 'border-l-[5px] rounded-l border-l-primary'
                                    "
                                ></textarea>
                                <error
                                    class="whitespace-nowrap w-fit"
                                    full_width="true"
                                    :fieldName="'message'"
                                    :validationErros="errors"
                                />
                                <div class="flex items-center mt-4 mb-4">
                                    <input
                                        id="default-checkbox"
                                        type="checkbox"
                                        class="mr-1"
                                        value=""
                                        v-model="send_me_a_copy"
                                    />
                                    {{
                                        static_translations?.business_send_me_a_copy_text
                                            ? static_translations?.business_send_me_a_copy_text
                                            : ""
                                    }}
                                </div>
                                <div class="recaptcha">
                                    <Error
                                    v-if="submitted"
                                        fieldName="captcha"
                                        :validationErros="errors"
                                        full_width="1"
                                    />
                                </div>
                            </div>
                            <div
                                class="flex justify-center items-center gap-3 mt-4"
                            >
                                <!-- <button
                                class="can-edu-btn-fill w-32"
                                @click="toggleModal"
                            >
                                {{
                                    static_translations?.business_close_modal_button_text
                                        ? static_translations?.business_close_modal_button_text
                                        : ""
                                }}
                            </button> -->
                                <button
                                    type="submit"
                                    class="can-edu-btn-fill w-32 text-white whitespace-nowrap"
                                >
                                    {{
                                        static_translations?.business_submit_button_text
                                            ? static_translations?.business_submit_button_text
                                            : ""
                                    }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    <transition name="slide">
                <div id="defaultModal" tabindex="-1" 
                  class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
                  v-if="showPopUpModal"
                  @click.self="togglePopUpModal">
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
                      <div class="bg-white py-6 px-10 rounded shadow-lg text-center">
                        <p class="text-center can-edu-p mt-2">
                            Your message has been sent. Thank you</p>
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
<style scoped>
/* Slide Animation */
.slide-enter-active, .slide-leave-active {
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
  }
  .slide-enter-from, .slide-leave-to {
    transform: translateY(-20px);
    opacity: 0;
  }
    /* width */
::-webkit-scrollbar {
  width: 8px;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #b1040e; 
  border-radius: 12px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #b1040e4d ; 
}
</style>

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
        "login_url",
        "register_url",
        "business_id",
        "business_contact_translations",
        "position",
        "indicate_required_field",
        "business_name",
    ],
    components: {
        vueRecaptcha,
        Error,
    },
    computed: {
        ...mapState({
            languages: (state) => state.languages.languages,
            schools: (state) => state.schools.schools,
        }),
        sitekey() {
            return process.env.MIX_RECAPTCHA_SITE_KEY;
        },
    },
    data() {
        return {
            submitted: false,
            showPopUpModal: false,
            showModal: false,
            name: "",
            email: "",
            message: "",
            send_me_a_copy: false,
            errors: new ErrorHandling(),
            error_message: "",
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
        // window.location.reload();
    }},
    handleClickOutsidePopup(event) {
            if (
                this.$refs.elementToDetectClick &&
                event.target.contains(this.$refs.elementToDetectClick)
            ) {
                if (this.showPopUpModal == true) {
                    this.showPopUpModal = false;
                }
            }
        },
        clearForm() {
            this.name = "";
            this.email = "";
            this.message = "";
            this.send_me_a_copy = false;
            this.errors = new ErrorHandling();
            this.recaptchaExpired();
            localStorage.removeItem("contact_business_name");
            localStorage.removeItem("contact_business_email");
            localStorage.removeItem("contact_business_message");
            this.showModal = false;
        },
        removeValidationErros(field) {
            this.errors.clear(field);
        },
        toggleModal() {
            this.showModal = !this.showModal;
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
                        this.contactBusiness();
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
        contactBusiness() {
            // e.preventDefault();
            const data = {
                name: this.name,
                email: this.email,
                message: this.message,
                send_me_a_copy: this.send_me_a_copy,
                business_id: this.business_id,
            };
            axios
                .post("/api/web/contact-bussiness", data)
                .then((res) => {
                    if (res?.data?.status == "Success") {
                        this.showPopUpModal=true

                        // helper.swalSuccessMessage(
                        //     "Your message has been sent. Thank you"
                        // );
                        this.clearForm();
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
                        }
                    }
                })
                .finally(() => (this.$parent.loading = false));
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
        this.static_translations = JSON.parse(
            this.business_contact_translations
        );
    },
    mounted() {
        const savedName = localStorage.getItem("contact_business_name");
        if (savedName) {
            this.name = savedName;
        }
        const savedEmail = localStorage.getItem("contact_business_email");
        if (savedEmail) {
            this.email = savedEmail;
        }
        const savedMessage = localStorage.getItem("contact_business_message");
        if (savedMessage) {
            this.message = savedMessage;
        }
        document.addEventListener("click", this.handleClickOutside);
        document.addEventListener("click", this.handleClickOutsidePopup);

    },
    beforeUnmount() {
        // Remove the click event listener when the component is unmounted
        document.removeEventListener("click", this.handleClickOutside);
        document.removeEventListener("click", this.handleClickOutsidePopup);
    },
    watch: {
        name(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("contact_business_name", newValue);
            }
        },
        email(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("contact_business_email", newValue);
            }
        },
        message(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("contact_business_message", newValue);
            }
        },
    },
};
</script>
