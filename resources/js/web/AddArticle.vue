<template>
    <div class="relative md:-mb-5 flex items-center border border-gray-300 rounded">
        <button class="can-edu-btn-fill" @click="toggleModal">
            {{
                static_translations?.open_modal_button_text
                    ? static_translations?.open_modal_button_text
                    : ""
            }}
        </button>
    </div>
    <form @submit.prevent="recaptcha()">
        <transition name="slide">
            <div id="defaultModal" tabindex="-1" aria-hidden="true"
                class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 md:h-full"
                v-if="showModal">
                <div class="relative w-full h-full max-w-xl p-4 rounded-2xl shadow-2xl bg-white border-4 border-primary/30 md:h-auto flex items-center justify-center"
                    ref="elementToDetectClick">
                    <!-- Modal content -->
                    <div class="w-full">
                        <!-- modal cross button -->
                        <div class="absolute top-4 right-4"
                            @click="toggleModal">
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <!-- Modal header -->
                        <div class="text-center w-full pt-10">
                            <p class="text-center text-lg font-FuturaMdCnBT mt-2">
                                {{
                                    static_translations?.premimum_and_featured_popup_message
                                        ? static_translations?.premimum_and_featured_popup_message
                                        : "Enter the quote"
                                }}
                            </p>
                            <p class="mt-2 text-center text-lg font-FuturaMdCnBT"> {{
                                static_translations?.proxima_study_member_popup_message
                                    ? static_translations?.proxima_study_member_popup_message
                                    : "Enter the quote"
                            }} <a href="#" @click="redirectToLogin">Click here</a></p>
                            <div class="mt-2">
                                <label class="font-FuturaMdCnBT text-lg"> {{
                                static_translations?.suggest_your_article_popup_message
                                    ? static_translations?.suggest_your_article_popup_message
                                    : "Enter the quote"
                            }} </label>
                            <div class="flex gap-2 my-2">
                                <input v-model="suggestedArticle" type="text"
                                    class="border border-gray-200 w-full rounded p-2"
                                    @paste="handlePaste">
                            
                                <button type="submit"
                                    class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5"
                                    :class="{ 'opacity-50 pointer-events-none': !suggestedArticle, 'opacity-100 pointer-events-auto': suggestedArticle }">
                                    {{
                                        static_translations?.submit_button_text
                                            ? static_translations?.submit_button_text
                                            : "Submit"
                                    }}
                                </button>
                            </div>
                            
                            <error :fieldName="'suggested_article'" :validationErros="errors" />
                                </div>
                                <!-- <div
                                class="my-8 flex items-center space-x-6 justify-center"
                            >
                                <vue-recaptcha
                                    v-show="showRecaptcha"
                                    :sitekey="`${sitekey}`"
                                    size="normal"
                                    theme="light"
                                    hl="en"
                                    @verify="recaptchaVerified"
                                    @expire="recaptchaExpired"
                                    @fail="recaptchaFailed"
                                    ref="vueRecaptcha"
                                >
                                </vue-recaptcha>
                            </div> -->
                            <div class="recaptcha">
                                <Error
                                v-if="submitted"
                                    fieldName="captcha"
                                    :validationErros="errors"
                                    full_width="1"
                                />
                            </div>
                            <!-- <button type="button" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4"
                            data-modal-hide="defaultModal" @click="toggleModal">
                            {{
                                static_translations?.close_button_text
                                    ? static_translations?.close_button_text
                                    : "Submit"
                            }}
                        </button> -->
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </form>
    <transition name="slide">
        <div id="defaultModal" tabindex="-1" aria-hidden="true"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="showPopUpModal"
            @click.self="togglePopUpModal"> <!-- Closes modal when clicking outside -->
            
            <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto">
                <div class="relative">
                    <!-- Close Button -->
                    <div class="absolute top-3 right-3 cursor-pointer" @click="togglePopUpModal">
                        <button type="button" class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
    
                    <!-- Modal Content -->
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10">
                        <div class="text-center can-edu-p" v-html="static_translations?.suggest_article_success_message
                                ? static_translations?.suggest_article_success_message
                                : 'Enter the quote'">
                        </div>
                        <div class="flex justify-center">
                            <button type="button" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4" @click="togglePopUpModal">
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
import ErrorHandling from "../ErrorHandling";
import Error from "./Error.vue";
import { load } from "recaptcha-v3";
import vueRecaptcha from "vue3-recaptcha2";

export default {
    props: [
        "article_access",
        "lang",
        "slug",
        "logged_in_user_type",
        "is_logged_id",
        "is_package_amount_paid",
        "suggested_article_translations"
    ],
    components: {
        Error,
        vueRecaptcha,
    },
    computed: {
        sitekey() {
            return process.env.MIX_RECAPTCHA_SITE_KEY;
        },
    },
    data() {
        return {
            showPopUpModal: false,
            suggestedArticle: '',
            showRecaptcha: true,
            showModal: false,
            static_translations: {},
            errors: new ErrorHandling(),
            toggelSubmitButton:false,
            submitted: false,

        };
    },
  
    methods: {
        redirectToLogin() {
        window.location.href = "/" + this.lang + "/login?url=" + window.location.href;
    },
        togglePopUpModal() {
            this.showPopUpModal = !this.showPopUpModal;
            if (!this.showPopUpModal) {
                window.location.reload();
            }
        },
        toggleModal() {
            if ((this.logged_in_user_type === 'school' && JSON.parse(this.article_access)) || (this.logged_in_user_type === 'business' && JSON.parse(this.article_access))) {
                window.location.href =
                    window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/article/create";
            } else {
                this.showModal = !this.showModal;
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
                        this.submitForm();
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
        handleClickOutside(event) {
            if (
                this.$refs.elementToDetectClick &&
                event.target.contains(this.$refs.elementToDetectClick)
            ) {
                if (this.showModal == true) {
                    this.showModal = false;
                }
            }
        },    handleClickOutsidePopup(event) {
            if (
                this.$refs.elementToDetectClick &&
                event.target.contains(this.$refs.elementToDetectClick)
            ) {
                if (this.showPopUpModal == true) {
                    this.showPopUpModal = false;
                }
            }
        },
        submitForm() {
            
            axios.post("/api/web/suggested-articles", { suggested_article: this.suggestedArticle })
                .then((res) => {
                    this.showPopUpModal = true
                })
                .catch((error) => {
                    
                    this.error_message = "";
                    this.errors = new ErrorHandling();
                    this.errors.record(error.response.data.errors);
                    console.log('this.errors',this.errors)
        
                });
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

        this.static_translations = JSON.parse(this.suggested_article_translations);
        // this.showPopUpModal = !JSON.parse(this.events_access);
    },
    mounted() {
        // Add a click event listener to the document
        document.addEventListener("click", this.handleClickOutside);
        document.addEventListener("click", this.handleClickOutsidePopup);
    },
    beforeUnmount() {
        // Remove the click event listener when the component is unmounted
        document.removeEventListener("click", this.handleClickOutside);
        document.removeEventListener("click", this.handleClickOutsidePopup);
    },
};
</script>
