<template>
    <div class="relative flex items-center border border-gray-300 rounded">
        <button class="can-edu-btn-fill" @click="toggleModal">
            {{
                static_translations?.contact_orgnizer_button_text
                    ? static_translations?.contact_orgnizer_button_text
                    : ""
            }}
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
                <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                    <!-- Modal header -->
                    <div
                        class="flex items-start justify-between p-4 rounded-t dark:border-gray-600"
                    >
                        <h3 class="can-edu-h3 mb-0">
                            {{
                                static_translations?.open_house_orgnizer_modal_title
                                    ? static_translations?.open_house_orgnizer_modal_title
                                    : ""
                            }}
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
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="flex justify-end">
                        <p class="text-red-500">
                            {{ indicate_required_field }}
                        </p>
                    </div>
                    <div class="p-4">
                        <form @submit.prevent="recaptcha()" class="my-4">
                            <div class="relative">
                                <label
                                for=""
                                class="block text-base lg:text-lg text-black font-normal"
                            >
                                {{
                                    static_translations?.open_house_name_label_text
                                        ? static_translations?.open_house_name_label_text
                                        : ""
                                }}
                                <span class="text-primary">*</span>
                            </label>
                                <input
                                    type="text"
                                   
                                    v-model="name"
                                    class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-[5px] rounded-r border-r-primary'
                                            : 'border-l-[5px] rounded-l border-l-primary'
                                    "
                                />
                                <error
                                    :fieldName="'name'"
                                    :validationErros="errors"
                                />
                            </div>
                            <div class="mt-4 relative">
                                <label
                                for=""
                                class="block text-base lg:text-lg text-black font-normal"
                            >
                                {{
                                    static_translations?.open_house_email_label_text
                                        ? static_translations?.open_house_email_label_text
                                        : ""
                                }}
                                <span class="text-primary">*</span>
                            </label>
                                <input
                                    type="text"
                                 
                                    v-model="email"
                                    class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-[5px] rounded-r border-r-primary'
                                            : 'border-l-[5px] rounded-l border-l-primary'
                                    "
                                />
                                <error
                                    :fieldName="'email'"
                                    :validationErros="errors"
                                />
                            </div>
                            <div class="mt-4 relative">
                                <label
                                for=""
                                class="block text-base lg:text-lg text-black font-normal"
                            >
                                {{
                                    static_translations?.open_house_message_label_text
                                        ? static_translations?.open_house_message_label_text
                                        : ""
                                }}
                                <span class="text-primary">*</span>
                            </label>
                                <textarea
                                    name=""
                                    id=""
                                    cols="30"
                                    rows="10"
                                  
                                    v-model="message"
                                    class="border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-[5px] rounded-r border-r-primary'
                                            : 'border-l-[5px] rounded-l border-l-primary'
                                    "
                                ></textarea>
                                <error
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
                                        static_translations?.open_house_send_me_a_copy_text
                                            ? static_translations?.open_house_send_me_a_copy_text
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
                                <button
                                    type="submit"
                                    class="can-edu-btn-fill w-32 text-white whitespace-nowrap"
                                >
                                    {{
                                        static_translations?.open_house_submit_button_text
                                            ? static_translations?.open_house_submit_button_text
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
                        <p class="text-center can-edu-p" >
                          {{success_message}}                    </p>
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
import axios from "axios";
import ErrorHandling from "../ErrorHandling";
import { mapState } from "vuex";
import vueRecaptcha from "vue3-recaptcha2";
import { load } from "recaptcha-v3";
import Error from "./Error.vue";
export default {
    components: {
        vueRecaptcha,
        Error,
    },
    computed: {
        sitekey() {
            return process.env.MIX_RECAPTCHA_SITE_KEY;
        },
    },
    props: ["open_house", "position", "open_house_translations","indicate_required_field","success_message"],
    data() {
        return {
            showPopUpModal: false,
            submitted: false,
            showModal: false,
            open_house_data: {},
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
        handleClickOutsidePopup(event) {
            if (
                this.$refs.elementToDetectClick &&
                event.target.contains(this.$refs.elementToDetectClick)
            ) {
                if (this.showPopUpModal == true) {
                    this.showPopUpModal = false;
            window.location.reload();


                }
            }
        },
        togglePopUpModal() {
            this.showPopUpModal = !this.showPopUpModal;
            if (!this.showPopUpModal) {
            window.location.reload();

                    }
        },
        toggleModal() {
            this.showModal = !this.showModal;
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
                        this.contactOrgnizer();
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
        contactOrgnizer() {
            // e.preventDefault();
            const data = {
                name: this.name,
                email: this.email,
                message: this.message,
                send_me_a_copy: this.send_me_a_copy,
                open_house_id: this.open_house_id,
                open_house: this.open_house_data,
            };
            axios
                .post("/api/web/contact-openhouse-orgnizer", data)
                .then((res) => {
                    if (res?.data?.status == "Success") {
                        // helper.swalSuccessMessage(
                        //     "Your message has been received!"
                        // );
                        this.showPopUpModal = true;
                        localStorage.removeItem("open_house_name");
                        localStorage.removeItem("open_house_email");
                        localStorage.removeItem("open_house_message");
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
    },
    created() {
        this.open_house_data = JSON.parse(this.open_house);
        this.static_translations = JSON.parse(this.open_house_translations);
    },

    // mounted() {
    //     const savedName = localStorage.getItem("open_house_name");
    //     if (savedName) {
    //         this.name = savedName;
    //     }
    //     const savedEmail = localStorage.getItem("open_house_email");
    //     if (savedEmail) {
    //         this.email = savedEmail;
    //     }
    //     const savedMessage = localStorage.getItem("open_house_message");
    //     if (savedMessage) {
    //         this.message = savedMessage;
    //     }
    //     document.addEventListener("click", this.handleClickOutside);
    // },
    mounted() {
    localStorage.removeItem("open_house_name");
    localStorage.removeItem("open_house_email");
    localStorage.removeItem("open_house_message");

    this.name = "";
    this.email = "";
    this.message = "";

    document.addEventListener("click", this.handleClickOutsidePopup);
    document.addEventListener("click", this.handleClickOutside);
},

    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutside);
        document.removeEventListener("click", this.handleClickOutsidePopup);
    },
    watch: {
        name(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("open_house_name", newValue);
                this.errors.clear("name");
            }
        },
        email(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("open_house_email", newValue);
                this.errors.clear("email");
            }
        },
        message(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("open_house_message", newValue);
                this.errors.clear("message");
            }
        },
    },
};
</script>
