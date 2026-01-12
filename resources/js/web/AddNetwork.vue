<template>
    <div
        class="relative md:-mb-5 flex items-center border border-gray-300 rounded"
    >
        <button class="can-edu-btn-fill whitespace-nowrap" @click="toggleModal">
            {{
                static_translations?.submit_banner_button_text
                    ? static_translations?.submit_banner_button_text
                    : ""
            }}
        </button>
    </div>
    <transition name="slide">
        <div
            id="defaultModal"
            tabindex="-1"
            aria-hidden="true"
            class="bg-black bg-opacity-50 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="showModal"
        >
            <div
                class="relative w-full h-full max-w-3xl"
                ref="elementToDetectClick"
            >
                <!-- Modal content -->
                <div class="bg-white rounded shadow-lg p-4">
                    <!-- Modal header -->
                    <div
                        class="flex items-start justify-between p-4 rounded-t dark:border-gray-600"
                    >
                        <div>
                            <h3 class="can-edu-h3 mb-0">
                                {{
                                    static_translations?.modal_title
                                        ? static_translations?.modal_title
                                        : ""
                                }}
                            </h3>
                        </div>
                        <div>
                            <button
                                type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="defaultModal"
                                @click="toggleModal"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="w-4 h-4 text-primary"
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
                                    static_translations?.clos_modal_button_text
                                        ? static_translations?.clos_modal_button_text
                                        : ""
                                }}</span>
                            </button>
                        </div>
                    </div>
                    <div class="p-4 h-[83vh] overflow-auto">
                        <div class="flex justify-end">
                            <p class="text-red-500">
                                {{ indicate_required_field }}
                            </p>
                        </div>
                        <div>
                            <h6 class="text-gray-500">
                                {{
                                    static_translations?.note_text
                                        ? static_translations?.note_text
                                        : "Note:You must place our banner on your website as well"
                                }}
                            </h6>
                        </div>

                        <form @submit.prevent="recaptcha()" class="mt-4">
                            <div>
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                    >{{
                                        static_translations?.point_1_text
                                            ? static_translations?.point_1_text
                                            : "1. Place our banner on your website"
                                    }}</label
                                >
                                <div
                                    class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center gap-4 mt-2 w-full"
                                >
                                    <div class="w-full md:w-3/5">
                                        <textarea
                                        name="banner_image_content"
                                            id="message"
                                            rows="7"
                                            class="block p-2.5 w-full border-l-[5px] border-l-primary text-gray-900 focus:bg-gray-100 rounded border border-gray-300 focus:outline-none focus:border-gray-300 disabled:border-l-gray-300"
                                            placeholder="Your message..."
                                            disabled
                                            :value="banner_image_content"
                                        >
                                        </textarea>
                                    </div>
                                    <div class="w-full md:w-2/5">
                                        <div class="h-40 bg-gray-50 border">
                                            <img
                                                :src="banner_image"
                                                class="w-full h-full object-cover"
                                                alt=""
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="relative mt-4 w-full">
                                    <label
                                        for=""
                                        class="block text-base lg:text-lg"
                                        >{{
                                            static_translations?.banner_location
                                                ? static_translations?.banner_location
                                                : "Please tell us the location where you will place the banner"
                                        }}</label
                                    >
                                    <input
                                        type="location"
                                        name="banner_location"
                                        class="w-full focus:ring-primary focus:ring-1 focus:outline-none px-4 py-1.5 rounded lg:text-lg border border-gray-300"
                                        :class="
                                            position == 'rtl'
                                                ? 'border-r-[5px] rounded-r border-r-primary'
                                                : 'border-l-[5px] rounded-l border-l-primary'
                                        "
                                        v-model="banner_location"
                                    />
                                    <error
                                        :fieldName="'banner_location'"
                                        :validationErros="errors"
                                    />
                                </div>
                            </div>
                            <div class="mt-6">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                    >{{
                                        static_translations?.point_2_text
                                            ? static_translations?.point_2_text
                                            : "2. Tell us about yourself"
                                    }}</label
                                >

                                <div
                                    v-for="(language, key) in languages"
                                    :key="language.id"
                                    :class="
                                        (activeTab == null &&
                                            language.is_default) ||
                                        activeTab == language.id
                                            ? 'block'
                                            : 'hidden'
                                    "
                                    class="relative mt-4 w-full"
                                >
                                    <label
                                        for=""
                                        class="block text-base lg:text-lg"
                                        >{{
                                            static_translations?.full_name_label
                                                ? static_translations?.full_name_label
                                                : "Full Name"
                                        }}
                                        <span class="text-primary">*</span>
                                    </label>
                                    <input
                                        :key="key"
                                        @input="
                                            handleFullNameInput(
                                                $event.target.value,
                                                language.id
                                            )
                                        "
                                        name="full_name"
                                        type="text"
                                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                        :class="
                                            position == 'rtl'
                                                ? 'border-r-[5px] rounded-r border-r-primary'
                                                : 'border-l-[5px] rounded-l border-l-primary'
                                        "
                                        :value="
                                            full_name[
                                                'full_name_' + language.id
                                            ]
                                        "
                                    />
                                    <error
                                        :fieldName="
                                            'full_name.full_name_' + language.id
                                        "
                                        :validationErros="errors"
                                    />
                                </div>
                                <div
                                    v-for="(language, key) in languages"
                                    :key="language.id"
                                    :class="
                                        (activeTab == null &&
                                            language.is_default) ||
                                        activeTab == language.id
                                            ? 'block'
                                            : 'hidden'
                                    "
                                    class="relative mt-4 w-full"
                                >
                                    <label
                                        for=""
                                        class="block text-base lg:text-lg"
                                        >{{
                                            static_translations?.description_label
                                                ? static_translations?.description_label
                                                : "Full Name"
                                        }}
                                        <span class="text-primary">*</span>
                                    </label>
                                    <textarea
                                        :key="key"
                                        @input="
                                            handleDescriptionInput(
                                                $event.target.value,
                                                language.id
                                            )
                                        "
                                        name="description"
                                        type="text"
                                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                        :class="
                                            position == 'rtl'
                                                ? 'border-r-[5px] rounded-r border-r-primary'
                                                : 'border-l-[5px] rounded-l border-l-primary'
                                        "
                                        :value="
                                            description[
                                                'description_' + language.id
                                            ]
                                        "
                                    ></textarea>
                                    <error
                                        :fieldName="
                                            'description.description_' +
                                            language.id
                                        "
                                        :validationErros="errors"
                                    />
                                </div>
                                <div class="relative mt-4 w-full">
                                    <label
                                        for=""
                                        class="block text-base lg:text-lg"
                                        >{{
                                            static_translations?.state_province_label
                                                ? static_translations?.state_province_label
                                                : "State / province"
                                        }}
                                        <span class="text-primary">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="state_province"
                                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                        :class="
                                            position == 'rtl'
                                                ? 'border-r-[5px] rounded-r border-r-primary'
                                                : 'border-l-[5px] rounded-l border-l-primary'
                                        "
                                        v-model="state_province"
                                        placeholder="Please enter your city and country, separated by a comma; e.g. “Montreal, Canada"
                                    />
                                    <error
                                        :fieldName="'state_province'"
                                        :validationErros="errors"
                                    />
                                </div>
                                <div class="w-full mt-4 relative">
                                    <label
                                        for=""
                                        class="block text-base lg:text-lg"
                                        >{{
                                            static_translations?.banner_url_label
                                                ? static_translations?.banner_url_label
                                                : "Full Name"
                                        }}
                                        <span class="text-primary">*</span>
                                    </label>
                                    <input
                                    name="banner_url"
                                        type="text"
                                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                        :class="
                                            position == 'rtl'
                                                ? 'border-r-[5px] rounded-r border-r-primary'
                                                : 'border-l-[5px] rounded-l border-l-primary'
                                        "
                                        v-model="banner_url"
                                    />
                                    <error
                                        :fieldName="'banner_url'"
                                        :validationErros="errors"
                                    />
                                </div>
                                <div class="mt-4 relative">
                                    <label
                                        for=""
                                        class="block text-base lg:text-lg"
                                        >{{
                                            static_translations?.image_label
                                                ? static_translations?.image_label
                                                : "Upload your banner * (Files must be less than 5MB, allowed file types: png, gif, jpg,jpeg)"
                                        }}
                                        <span class="text-primary">*</span>
                                    </label>
                                    <input
                                    name="image"
                                        type="file"
                                        placeholder=""
                                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 border mt-1"
                                        :class="
                                            position == 'rtl'
                                                ? 'border-r-[5px] rounded-r border-r-primary'
                                                : 'border-l-[5px] rounded-l border-l-primary'
                                        "
                                        @change="handleImage"
                                    />
                                    <error
                                        :fieldName="'image'"
                                        :validationErros="errors"
                                    />
                                </div>
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
                            <div
                                class="my-8 flex items-center gap-2 justify-center"
                            >
                                <!-- <button
                                class="can-edu-btn-fill"
                                @click="toggleModal"
                            >
                                {{
                                    static_translations?.clos_modal_button_text
                                        ? static_translations?.clos_modal_button_text
                                        : "Close"
                                }}
                            </button> -->
                                <button
                                    class="can-edu-btn-fill whitespace-nowrap'"
                                    type="submit"
                                >
                                    {{
                                        static_translations?.submit_button_text
                                            ? static_translations?.submit_button_text
                                            : "Submit"
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
import ErrorHandling from "./../ErrorHandling";
import { mapState } from "vuex";
import vueRecaptcha from "vue3-recaptcha2";
import Error from "./Error.vue";

export default {
    props: [
        "success_message",
        "banner_image",
        "is_logged_id",
        "position",
        "logged_in_customer",
        "network_translations",
        "lang",
        "lang_id",
        "app_url",
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
      showPopUpModal: false,
            showModal: false,
            banner_location: "",
            state_province: "",
            image: "",
            banner_url: "",
            full_name: {},
            description: {},
            errors: new ErrorHandling(),
            error_message: "",
            activeTab: null,
            showRecaptcha: true,
            toggelSubmitButton: false,
            static_translations: {},
            elementToDetectClick: null,
            banner_image_content: "",
            submitted: false,
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
        toggleModal() {
            this.showModal = !this.showModal;
            if (!this.is_logged_id) {
                window.location.href =
                    "/" + this.lang + "/login?url=" + window.location.href;
            }
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        handleFullNameInput(val, i) {
            this.full_name["full_name_" + i] = val;
            localStorage.setItem("network_full_name", val);
            localStorage.setItem("network_full_name_index", i);
        },
        handleDescriptionInput(val, i) {
            this.description["description_" + i] = val;
            localStorage.setItem("network_description", val);
            localStorage.setItem("network_description_index", i);
        },
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("media", e.target.files[0]);
            file.append("is_temp_media", true);
            file.append("type", "network_image");
            axios.post("/api/web/media/process", file).then((res) => {
                this.image = JSON.stringify(res?.data);
                localStorage.setItem(
                    "network_image",
                    JSON.stringify(res?.data)
                );
            });
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
                banner_location: this.banner_location,
                state_province: this.state_province,
                image: this.image,
                banner_url: this.banner_url,
                full_name: this.full_name,
                description: this.description,
                status: "no",
                customer_id: this.logged_in_customer,
                is_web: true,
            };
            let justLanguageId = [];
            this.languages.filter((res) => {
                justLanguageId.push(res.id);
            });
            data["language_id"] = justLanguageId;
            axios
                .post("/api/web/networks", data)
                .then((res) => {
                    if (res?.data?.status == "Success") {
            this.showPopUpModal = true;

                        // helper.swalSuccessMessage(
                        //     "You have created network successfully!"
                        // );
                        localStorage.removeItem("network_full_name");
                        localStorage.removeItem("network_full_name_index");
                        localStorage.removeItem("network_description");
                        localStorage.removeItem("network_description_index");
                        localStorage.removeItem("network_image");
                        localStorage.removeItem("network_banner_location");
                        localStorage.removeItem("network_state_province");
                        localStorage.removeItem("network_banner_url");
                        localStorage.removeItem("network_banner_image_content");
                        localStorage.removeItem("network_email");
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
                                "error.response.data.message"
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
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_WEB_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                data.map((res, i) => {
                    this.full_name["full_name_" + res.id] = "";
                    this.description["description_" + res.id] = "";

                    const savedNetworkFN =
                        localStorage.getItem("network_full_name");
                    const savedNetworkFNIndex = localStorage.getItem(
                        "network_full_name_index"
                    );
                    if (savedNetworkFN && savedNetworkFNIndex) {
                        this.full_name[
                            "full_name_" + parseInt(savedNetworkFNIndex)
                        ] = savedNetworkFN;
                    }

                    const savedNetworkDESC = localStorage.getItem(
                        "network_description"
                    );
                    const savedNetworkDESCIndex = localStorage.getItem(
                        "network_description_index"
                    );
                    if (savedNetworkDESC && savedNetworkDESCIndex) {
                        this.description[
                            "description_" + parseInt(savedNetworkDESCIndex)
                        ] = savedNetworkDESC;
                    }
                });
            });

        this.static_translations = JSON.parse(this.network_translations);
        this.activeTab = this.lang_id;
        this.banner_image_content = `<a href='${
            this.app_url + "" + this.banner_image
        }'><img src='  ${this.app_url + "" + this.banner_image}' /></a>`;
    },
   
    mounted() {
        document.addEventListener("click", this.handleClickOutsidePopup);

        // const savedImage = localStorage.getItem("network_image");
        // if (savedImage) {
        //     this.image = savedImage;
        // }
        // const savedBannerLocation = localStorage.getItem(
        //     "network_banner_location"
        // );
        // if (savedBannerLocation) {
        //     this.banner_location = savedBannerLocation;
        // }

        // const savedStateProvince = localStorage.getItem(
        //     "network_state_province"
        // );
        // if (savedStateProvince) {
        //     this.state_province = savedStateProvince;
        // }

        // const savedBannerUrl = localStorage.getItem("network_banner_url");
        // if (savedBannerUrl) {
        //     this.banner_url = savedBannerUrl;
        // }

        // const savedBannerImageContent = localStorage.getItem(
        //     "network_banner_image_content"
        // );
        // if (savedBannerImageContent) {
        //     this.banner_image_content = savedBannerImageContent;
        // }
        localStorage.removeItem("network_image");
    localStorage.removeItem("network_banner_location");
    localStorage.removeItem("network_state_province");
    localStorage.removeItem("network_banner_url");
    localStorage.removeItem("network_banner_image_content");
    localStorage.removeItem("network_full_name");
                        localStorage.removeItem("network_full_name_index");
                        localStorage.removeItem("network_description");
                        localStorage.removeItem("network_description_index");
        document.addEventListener("click", this.handleClickOutside);
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutsidePopup);

        document.removeEventListener("click", this.handleClickOutside);
    },
    watch: {
    "full_name": {
    handler(newValue) {
      Object.keys(newValue).forEach((key) => {
        if (this.errors.has(`full_name.${key}`)) {
          this.errors.clear(`full_name.${key}`);
        }
        if (newValue[key] && newValue[key] !== "") {
          localStorage.setItem(`become_sponsor_full_name_${key}`, newValue[key]);
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
    deep: true, // Ensures Vue detects changes inside the object
  },
        state_province(newValue, oldValue) {
    if (this.errors.has("state_province")) {
        this.errors.clear("state_province");
    }
    if (newValue && newValue !== "") {
        localStorage.setItem("network_state_province", newValue);
    }
},
image(newValue, oldValue) {
    if (this.errors.has("image")) {
        this.errors.clear("image");
    }
    if (newValue && newValue !== "") {
        localStorage.setItem("network_image", newValue);
    }
},
        banner_location(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("network_banner_location", newValue);
            }
        },
        // state_province(newValue, oldValue) {
        //     if (newValue && newValue != "") {
        //         localStorage.setItem("network_state_province", newValue);
        //     }
        // },
        banner_url(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("network_banner_url", newValue);
            }
        },
        banner_image_content(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("network_banner_image_content", newValue);
            }
        },
    },
};
</script>
