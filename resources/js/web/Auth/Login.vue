<template>
    <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-4">
        <div class="">
            <form @submit.prevent="recaptcha()" method="POST">
                <div class="border-b-4 pt-1 pb-2 border-primary">
                    <h1 class="can-edu-h1">
                        {{
                            login_settings?.login_page_setting_detail?.length >
                                0
                                ? login_settings?.login_page_setting_detail[0]
                                    ?.page_title
                                : ""
                        }}
                    </h1>
                </div>
                <div class="mt-4 relative">
                    <input type="text" v-model="email" :placeholder="login_settings?.login_page_setting_detail?.length >
                        0
                        ? login_settings?.login_page_setting_detail[0]
                            ?.login_email_placeholder
                        : ''
                        " @change="validateEmail($event)"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="position == 'rtl'
                            ? 'border-r-4 rounded-r border-r-primary'
                            : 'border-l-4 rounded-l border-l-primary'
                            " />
                    <error :fieldName="'email'" :validationErros="errors" />


                    <div class="relative tooltip -bottom-4 group-hover:flex" v-if="error_message != ''">
                        <div role="tooltip"
                            class="relative tooltiptext -top-2 wfull z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-red-100 border border-primary text-gray-600 w_full md:w_half rounded "
                            :class="full_width ? 'w-full' : 'w-fit'">
                            <p class="text-primary leading-none text-left text-sm lg:text-base">{{ error_message }}</p>
                        </div>
                    </div>

                    <div class="relative tooltip -bottom-4 group-hover:flex" v-if="emailValidationErro != ''">
                        <div role="tooltip"
                            class="relative tooltiptext -top-2 wfull z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-red-100 border border-primary text-gray-600 w_full md:w_half rounded "
                            :class="full_width ? 'w-full' : 'w-fit'">
                            <p class="text-primary leading-none text-left text-sm lg:text-base">{{ emailValidationErro
                                }}</p>
                        </div>
                    </div>


                    <div class="relative tooltip -bottom-4 group-hover:flex"
                        v-if="credentialsError != '' && !error_message">
                        <div role="tooltip"
                            class="relative tooltiptext -top-2 wfull z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 flex bg-red-100 border border-primary text-gray-600 w_full md:w_half rounded "
                            :class="full_width ? 'w-full' : 'w-fit'">
                            <p class="text-primary leading-none text-left text-sm lg:text-base">{{ credentialsError }}
                            </p>
                        </div>
                    </div>

                </div>
                <div class="mt-4 relative">
                    <input v-model="password" type="password" :placeholder="login_settings?.login_page_setting_detail?.length >
                        0
                        ? login_settings?.login_page_setting_detail[0]
                            ?.login_passowrd_placeholder
                        : ''
                        "
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="position == 'rtl'
                            ? 'border-r-4 rounded-r border-r-primary'
                            : 'border-l-4 rounded-l border-l-primary'
                            " />
                    <error :fieldName="'password'" :validationErros="errors" />
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <div class="flex gap-2 items-center">
                        <input type="checkbox" class="rounded-md checked:bg-primary" v-model="keep_me_logged_in" />
                        <p class="text-sm xl:text-base text-black">
                            {{
                                login_settings?.login_page_setting_detail
                                    ?.length > 0
                                    ? login_settings
                                        ?.login_page_setting_detail[0]
                                        ?.keep_me_logged_in_text
                                    : ""
                            }}
                        </p>
                    </div>
                    <div>
                        <a :href="`/${lang}/forgot-password`" class="text-sm xl:text-base text-primary">{{
                            login_settings?.login_page_setting_detail
                                ?.length > 0
                                ? login_settings
                                    ?.login_page_setting_detail[0]
                                    ?.forget_password_text
                                : ""
                        }}</a>
                    </div>
                </div>
                <!-- <div class="my-8 flex items-center space-x-6 justify-center">
                    <vue-recaptcha v-show="showRecaptcha" :sitekey="`${sitekey}`" size="normal" theme="light" hl="en"
                        @verify="recaptchaVerified" @expire="recaptchaExpired" @fail="recaptchaFailed"
                        ref="vueRecaptcha">
                    </vue-recaptcha>
                </div> -->
                <div class="recaptcha">
                    <Error v-if="submitted" fieldName="captcha" :validationErros="errors" full_width="1" />
                </div>
                <div class="mt-8 flex justify-center">
                    <button class="can-edu-btn-fill w-56 text-white whitespace-nowrap" type="submit">
                        {{
                            login_settings?.login_page_setting_detail?.length >
                                0
                                ? login_settings?.login_page_setting_detail[0]
                                    ?.login_button_text
                                : ""
                        }}
                    </button>

                </div>
            </form>
        </div>

        <div class="px-6 mt-16">
            <div class="flex flex-col space-y-2 mt-3">
                <button @click="openLink(`/${lang}/login/facebook`)"
                    class="bg-gray-50 border rounded py-2 px-4 flex gap-4 w-full xl:w-11/12 items-center hover:bg-gray-200">
                    <img class="w-5 h-5" src="https://cdn-icons-png.flaticon.com/512/124/124010.png" />
                    <span class="font-semibold text-base">
                        {{
                            login_settings?.login_page_setting_detail?.length > 0
                                ? login_settings?.login_page_setting_detail[0]?.facebook_login_text
                                : ""
                        }}
                    </span>
                </button>
                <button @click="openLink(`/${lang}/login/google`)"
                    class="bg-gray-50 border rounded py-2 px-4 flex gap-4 w-full xl:w-11/12 items-center hover:bg-gray-200">
                    <img class="w-5 h-5"
                        src="https://static-00.iconduck.com/assets.00/google-icon-2048x2048-czn3g8x8.png" />
                    <span class="font-semibold text-base">
                        {{
                            login_settings?.login_page_setting_detail?.length > 0
                                ? login_settings?.login_page_setting_detail[0]?.google_login_text
                                : ""
                        }}
                    </span>
                </button>
                <button @click="openLink(`/${lang}/login/linkedin`)"
                    class="bg-gray-50 border rounded py-2 px-4 flex gap-4 w-full xl:w-11/12 items-center hover:bg-gray-200">
                    <img class="w-5 h-5" src="https://cdn-icons-png.flaticon.com/512/174/174857.png" />
                    <span class="font-semibold text-base">
                        {{
                            login_settings?.login_page_setting_detail?.length > 0
                                ? login_settings?.login_page_setting_detail[0]?.linkedin_login_text
                                : ""
                        }}
                    </span>
                </button>
            </div>
        </div>

        <div class="mt-10 lg:mt-0">
            <div class="border-b-4 border-primary py-2">
                <h2 class="can-edu-h2 mb-0">
                    {{
                        login_settings?.login_page_setting_detail?.length > 0
                            ? login_settings?.login_page_setting_detail[0]
                                ?.not_register_yet_text
                            : ""
                    }}
                </h2>
            </div>
            <div class="my-4 w-full">
                <button @click="registerTypeModal" class="can-edu-btn-fill w-full">
                    {{
                        login_settings?.login_page_setting_detail?.length > 0
                            ? login_settings?.login_page_setting_detail[0]
                                ?.create_account_button_text
                            : ""
                    }}
                </button>
                <!-- <a :href="`/${lang}/${slug}`"> </a> -->
            </div>
            <hr />
            <div class="border rounded-md p-3 mt-4">
                <div class="flex items-center gap-2">
                    <!-- <img class="h-5" src="assets/sheildicon.png" alt="" /> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffa500"
                        class="bi bi-shield-shaded w-5 h-5" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8 14.933a.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067v13.866zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z" />
                    </svg>
                    <p class="can-edu-card-h">
                        {{
                            login_settings?.login_page_setting_detail?.length >
                                0
                                ? login_settings?.login_page_setting_detail[0]
                                    ?.protect_your_account_text
                                : ""
                        }}
                    </p>
                </div>
                <div class="mt-2 can-edu-card-p" v-html="login_settings?.login_page_setting_detail?.length > 0
                    ? login_settings?.login_page_setting_detail[0]
                        ?.protect_your_account_description
                    : ''
                    "></div>
            </div>
        </div>
        <RegisterTypeModal :slug="slug" :register_school_slug="register_school_slug"
            :register_business_slug="register_business_slug" :toggleModal="toggleModal" :lang="lang" :lang_id="lang_id"
            @registerTypeModal="registerTypeModal"></RegisterTypeModal>
    </div>
</template>

<script>
import axios from "axios";
import ErrorHandling from "./../../ErrorHandling";
import vueRecaptcha from "vue3-recaptcha2";
import { load } from "recaptcha-v3";
import Error from "../Error.vue";
import RegisterTypeModal from "../RegisterTypeModal.vue";


export default {
    props: [
        "login_page_settings",
        "slug",
        "register_school_slug",
        "register_business_slug",
        "error",
        "position",
        "lang",
        "return_url",
        "lang_id"
    ],
    components: { vueRecaptcha, Error, RegisterTypeModal },
    computed: {
        sitekey() {
            return process.env.MIX_RECAPTCHA_SITE_KEY;
        },
    },
    data() {
        return {
            email: "",
            password: "",
            keep_me_logged_in: false,
            errors: new ErrorHandling(),
            error_message: "",
            login_settings: null,
            showRecaptcha: true,
            toggelSubmitButton: false,
            emailValidationErro: "",
            credentialsError: "",
            toggleModal: false,
            submitted: false,
        };
    },
    methods: {
        openLink(url) {
            window.open(url, "_blank");
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
                                this.login();
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
        registerTypeModal() {
            this.toggleModal = !this.toggleModal;
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
        login() {
            this.error_message = "";
            this.credentialsError = "";
            this.errors = new ErrorHandling();
            console.log(this.errors)
            const redirectUrl = localStorage.getItem('lastPage') || '';
            const BLOCKED_REDIRECT_URLS = [
        '/reset-password/',
        '/register-business',
        '/school-registration-page',
        '/register?type=student',
        // Add more if needed
    ];
            // console.log('redirect url ', this.redirectUrl)
            // if (redirectUrl.includes('/reset-password/')) {
            //     localStorage.removeItem('lastPage');
            //     redirectUrl = '/';
            // }
            const isBlockedUrl = BLOCKED_REDIRECT_URLS.some(url => redirectUrl.includes(url));
    if (isBlockedUrl) {
        localStorage.removeItem('lastPage'); // Clean up
        redirectUrl = '/'; // Force home redirect
    }

    console.log('Final redirect URL:', redirectUrl);

            axios
                .post(`${process.env.MIX_WEB_API_URL}login`, {
                    email: this.email,
                    password: this.password,
                    redirect_url: redirectUrl
                })
                .then((res) => {
                    if (res.data.status == "Success") {
                        if (this?.return_url && this?.return_url != "") {
                            // window.open(this.return_url, "_blank");
                            window.location.href = this.return_url;
                        } else {
                            // window.open(res.data.data.redirect_url, '_blank');
                            window.location.href = res.data.data.redirect_url;
                        }
                        this.email = "";
                        this.password = "";
                        this.error_message = "";
                        this.errors.clear();
                    } else if (res.data.status === "Error") {
                        this.error_message = res.data.message;
                        this.credentialsError = this.login_settings?.login_page_setting_detail?.length > 0
                            ? this.login_settings?.login_page_setting_detail[0]?.credentails_match_error_text
                            : "Invalid email or password";
                    }
                })
                .catch((error) => {
                    this.error_message = "";
                    this.errors = new ErrorHandling();
                    if (error.response.status == 422) {
                        if (error.response.data.status == "Error") {
                            this.$toaster.error(error.response.data.message);
                            this.credentialsError = this.login_settings?.login_page_setting_detail?.length > 0
                                ? this.login_settings?.login_page_setting_detail[0]?.credentails_match_error_text
                                : "Invalid email or password";
                        } else {
                            this.errors.record(error.response.data.errors);
                        }
                    }
                })
                .finally(() => (this.$parent.loading = false));
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
                //     this.login_settings?.login_page_setting_detail?.length > 0
                //         ? this.login_settings?.login_page_setting_detail[0]
                //             ?.email_format_error_text
                //         : "";
            }
            return false;
        },
    },
    mounted() {
        this.login_settings = JSON.parse(this.login_page_settings);
        this.error_message = this.error;
        console.log('errors ', this.errors)
        console.log('redirect url ', this.redirectUrl)
    },
};
</script>
