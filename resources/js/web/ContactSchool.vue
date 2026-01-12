<template>
    <div>
    <div
        class="relative mt-3 mb-3 flex items-center border border-gray-300 rounded"
    >
        <button
            @click="toggleModal"
            class="flex items-center space-x-1 md:space-x-2 shadow px-2 md:px-5 can-edu-btn-fill font-medium"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="w-4 h-4 mr-2"
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
            <!-- {{ school_name ? `Contact ${school_name}` : "Contact schoools" }} -->
            {{ static_translations?.open_modal_button_text || "" }} {{ school_name ? `${school_name}` : "Contact schools" }}

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
                class="relative w-full bg-white rounded-2xl shadow-2xl border-4 border-primary/30 h-full max-w-2xl md:h-auto"
                ref="elementToDetectClick"
            >
                <!-- Modal content -->
                <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl text-center pt-10">
                    <!-- Modal header -->
                    <div
                        class="flex items-start justify-between p-4 rounded-t dark:border-gray-600"
                    >
                        <h3 class="can-edu-h3 mb-0">
                             <!-- {{
                                static_translations?.modal_title
                                    ? static_translations?.modal_title
                                    : ""
                            }} 
                            {{ school_name ? `Contact ${school_name}` : "Contact schoools" }} -->
                            {{ static_translations?.modal_title || "" }} {{ school_name ? `${school_name}` : "Contact schools" }}

                        </h3>
                        <button
                            type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="defaultModal"
                            @click="toggleModal"
                        >
                            <svg
                                aria-hidden="true"
                                class="w-3 md:w-5 h-3 md:h-5 text-primary"
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
                                static_translations?.school_close_modal_button_text
                                    ? static_translations?.school_close_modal_button_text
                                    : ""
                            }}</span>
                        </button>
                    </div>
                    <div class="flex justify-end">
                        <p class="text-red-500">
                            {{ indicate_required_field }}
                        </p>
                    </div>
                    <div class="px-0 py-4 md:p-4">
                        <form @submit.prevent="recaptcha()" class="mt-4">
                            <div class="relative">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg text-black font-normal text-left"
                                >
                                    {{
                                        static_translations?.school_name_input_label
                                            ? static_translations?.school_name_input_label
                                            : ""
                                    }}
                                    <span class="text-primary">*</span>
                                </label>
                                <input
                                    type="text"
                                    :placeholder="
                                        static_translations?.school_name_input_placeholder
                                            ? static_translations?.school_name_input_placeholder
                                            : ''
                                    "
                                    @input="removeValidationErros('name')"
                                    v-model="name"
                                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
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
                                    class="block text-base lg:text-lg text-black font-normal text-left"
                                >
                                    {{
                                        static_translations?.school_email_input_label
                                            ? static_translations?.school_email_input_label
                                            : ""
                                    }}
                                    <span class="text-primary">*</span>
                                </label>
                                <input
                                    type="text"
                                    :placeholder="
                                        static_translations?.school_email_input_placeholder
                                            ? static_translations?.school_email_input_placeholder
                                            : ''
                                    "
                                    @input="removeValidationErros('email')"
                                    v-model="email"
                                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
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
                                    class="block text-base lg:text-lg text-black font-normal text-left"
                                >
                                    {{
                                        static_translations?.school_message_input_label
                                            ? static_translations?.school_message_input_label
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
                                        static_translations?.school_message_input_placeholder
                                            ? static_translations?.school_message_input_placeholder
                                            : ''
                                    "
                                    @input="removeValidationErros('message')"
                                    v-model="message"
                                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
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
                                    <span class="text-black font-normal">
                                        {{
                                            static_translations?.school_send_me_a_copy_text
                                                ? static_translations?.school_send_me_a_copy_text
                                                : ""
                                        }}
                                    </span>
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
                                        static_translations?.school_close_modal_button_text
                                            ? static_translations?.school_close_modal_button_text
                                            : ""
                                    }}
                                </button> -->
                                <button
                                    type="submit"
                                    class="can-edu-btn-fill font-medium w-32 text-white whitespace-nowrap"
                                >
                                    {{
                                        static_translations?.school_submit_button_text
                                            ? static_translations?.school_submit_button_text
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
    <!-- <transition name="slide">
        <div 
            id="defaultModal"
            
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
        >
            <div class="relative w-full rounded-2xl shadow-2xl border-4 border-primary/30 h-full max-w-lg md:h-auto">
                <div class="">
                    <div class="absolute top-2 right-2 cursor-pointer" >
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path d="M14.348 14.849a1 1 0 0 1-1.415 0L10 11.415l-2.933 2.934a1 1 0 1 1-1.415-1.415l2.934-2.933L5.651 7.068a1 1 0 1 1 1.415-1.415L10 8.585l2.933-2.934a1 1 0 0 1 1.415 1.415l-2.934 2.933 2.934 2.933a1 1 0 0 1 0 1.415z" />
                        </svg>
                    </div>
                    <div class="bg-white py-6 px-10 rounded shadow-lg text-center">
                        <p class="text-center can-edu-p mt-2">
                            Only Premium and Featured schools and businesses can post their articles
                        </p>
                        <button type="button" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4" >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition> -->
    <transition name="slide">
        <div id="defaultModal" tabindex="-1" 
          v-if="showWarning"
          class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
          @click.self="closeWarning"
        >
          <div class="bg-white p-6 rounded-2xl shadow-2xl border-4 border-primary/30 text-center relative">
            <!-- Close Button (X) -->
            <button
              @click="closeWarning"
              class="text-gray-400 bg-transparent absolute top-3 right-3 hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" 
              data-modal-hide="defaultModal"
            >
              <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
              </svg>
            </button>
      
            <p class="mt-6 text-black">
                {{ static_translations?.main_heading_text
                    ? static_translations?.main_heading_text
                    : "" }}
              </p>
      
            <div class="mt-4 flex justify-center gap-4">
              <!-- Login and Register Buttons -->
              <button
              class="can-edu-btn-fill"
              @click="redirectToLogin"
            >
            {{ static_translations?.login_button_text
                ? static_translations?.login_button_text
                : "" }}
            </button>
            <button
            class="can-edu-btn-fill"
            @click="redirectToRegister"
          >
          {{ static_translations?.register_button_text
            ? static_translations?.register_button_text
            : "" }}
          </button>
            </div>
          </div>
        </div>
      </transition>
    
    </div>
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
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                        <p class="text-center can-edu-p mt-2">
                            Your message has been received!                      
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
import ErrorHandling from "../ErrorHandling";
import { mapState } from "vuex";
import { load } from "recaptcha-v3";
import vueRecaptcha from "vue3-recaptcha2";
import Error from "./Error.vue";

export default {
    props: {
        login_url: String,
        register_url: String,
    school_id: String,
    school_contact_translations: Array,
    position: String,
    indicate_required_field: Boolean,
    school_name: String,
    loggedInCustomer: {
        type: Boolean,
        required: true,
    }
},
 
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
            showWarning: false,
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
        clearForm() {
            this.name = "";
            this.email = "";
            this.message = "";
            this.send_me_a_copy = false;
            this.errors = new ErrorHandling();
            this.recaptchaExpired();
            localStorage.removeItem("contact_school_name");
            localStorage.removeItem("contact_school_email");
            localStorage.removeItem("contact_school_message");
            this.showModal = false;
        },
        removeValidationErros(field) {
            this.errors.clear(field);
        },
        // toggleModal() {
        //     this.showModal = !this.showModal;
        // },
        toggleModal() {
            if (this.loggedInCustomer) {
                this.showModal = true; 
            } else {
                this.showWarning = true; 
            }
        },
        closeWarning() {
            this.showWarning = false;
        },    
        redirectToLogin() {
      window.location.href = this.login_url;
    },
    redirectToRegister() {
      window.location.href = this.register_url;
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
                    this.contactschool();
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
    
        contactschool() {
            // e.preventDefault();
            const data = {
                name: this.name,
                email: this.email,
                message: this.message,
                send_me_a_copy: this.send_me_a_copy,
                school_id: this.school_id,
            };
            axios
                .post("/api/web/contact-school", data)
                .then((res) => {
                    if (res?.data?.status == "Success") {
            this.showPopUpModal = true;

                        // helper.swalSuccessMessage(
                        //     "Your message has been received!"
                        // );
                        // window.location.reload();
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
        this.static_translations = JSON.parse(this.school_contact_translations);
    },
    mounted() {
        const savedName = localStorage.getItem("contact_school_name");
        if (savedName) {
            this.name = savedName;
        }
        const savedEmail = localStorage.getItem("contact_school_email");
        if (savedEmail) {
            this.email = savedEmail;
        }
        const savedMessage = localStorage.getItem("contact_school_message");
        if (savedMessage) {
            this.message = savedMessage;
        }
        document.addEventListener("click", this.handleClickOutside);
        document.addEventListener("click", this.handleClickOutsidePopup);

    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutsidePopup);
        document.removeEventListener("click", this.handleClickOutside);
    },
    watch: {
        name(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("contact_school_name", newValue);
            }
        },
        email(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("contact_school_email", newValue);
            }
        },
        message(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("contact_school_message", newValue);
            }
        },
    },
};
</script>
