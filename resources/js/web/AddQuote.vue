<template>
    <div
        class="relative md:-mb-4 flex items-center border border-gray-300 rounded"
    >
        <button
            class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5"
            @click="toggleModal"
        >
            {{
                static_translations?.post_your_qoute_text
                    ? static_translations?.post_your_qoute_text
                    : "Post your qoute"
            }}
        </button>
    </div>
    <transition name="slide">
        <div
            id="defaultModal"
            tabindex="-1"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 md:h-full"
            v-if="showModal"
        >
            <div
                class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                ref="elementToDetectClick"
            >
                <!-- Modal content -->
                <div class="bg-white py-6 px-10 rounded-xl shadow-xl pt-10">
                    <!-- Modal header -->
                    <div
                        class="flex items-start justify-between py-4 px-6 rounded-t"
                    >
                        <div>
                            <h3 class="can-edu-h3 mb-0">
                                {{
                                    static_translations?.modal_title
                                        ? static_translations?.modal_title
                                        : "Post your qoute"
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
                                <span class="sr-only"></span>
                            </button>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-end mt-4 px-6">
                            <p class="font-semibold text-red-500">
                                {{ indicate_required_field }}
                            </p>
                        </div>
                        <div class="p-4">
                            <form @submit.prevent="recaptcha()" class="mt-4">
                                <!-- <ul class="flex gap-2 flex-wrap my-4">
                                    <li
                                        class="mr-2 mb-2"
                                        v-for="(language, key) in languages"
                                        :key="language.id"
                                    >
                                        <a
                                            @click.prevent="changeLanguageTab(language)"
                                            href="#"
                                            :class="[
                                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                                (activeTab == null &&
                                                    language.is_default) ||
                                                activeTab == language.id
                                                    ? 'text-white bg-primary active'
                                                    : '',
                                                errors.has(`quote.quote_` + language.id)
                                                    ? 'bg-red-600 text-white hover:text-white'
                                                    : '',
                                            ]"
                                            >{{ language.name }}</a
                                        >
                                    </li>
                                </ul> -->
                                <div class="mt-6">
                                    <div class="mt-4 relative">
                                        <label
                                            class="block text-base lg:text-lg"
                                            >{{
                                                static_translations?.name_label_text
                                                    ? static_translations?.name_label_text
                                                    : "Enter Your Name"
                                            }}
                                            <span class="text-primary">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            name="name"
                                            class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 border"
                                            :class="
                                                position == 'rtl'
                                                    ? 'border-r-4 rounded-r border-r-primary'
                                                    : 'border-l-4 rounded-l border-l-primary'
                                            "
                                            @input="
                                                handleInput(
                                                    $event.target.value,
                                                    'name'
                                                )
                                            "
                                            :value="name"
                                        />
                                        <error
                                            :fieldName="'name'"
                                            :validationErros="errors"
                                        />
                                    </div>
                                    <div class="mt-4 relative">
                                        <label
                                            class="block text-base lg:text-lg"
                                            >{{
                                                static_translations?.location_label_text
                                                    ? static_translations?.location_label_text
                                                    : "Enter Your Location"
                                            }}
                                            <span class="text-primary">*</span>
                                        </label>
                                        <input
                                        name="location"
                                            type="text"
                                            class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 border"
                                            :placeholder="
                                             static_translations?.location_input_placeholder
                                                    ? static_translations?.location_input_placeholder
                                                    : ''
                                                    "
                                            
                                          :class="
                                                position == 'rtl'
                                                    ? 'border-r-4 rounded-r border-r-primary'
                                                    : 'border-l-4 rounded-l border-l-primary'
                                            "
                                            @input="
                                                handleInput(
                                                    $event.target.value,
                                                    'location'
                                                )
                                            "
                                            :value="location"
                                        />
                                        <error
                                            :fieldName="'location'"
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
                                                static_translations?.quote_label_text
                                                    ? static_translations?.quote_label_text
                                                    : "Your Quote"
                                            }}
                                            <span class="text-primary">*</span>
                                        </label>
                                        <textarea
                                            :key="key"
                                            @input="
                                                handleNameInput(
                                                    $event.target.value,
                                                    language.id,
                                                    'quote'
                                                )
                                            "
                                            name="quote"
                                            class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                            :class="
                                                position == 'rtl'
                                                    ? 'border-r-4 rounded-r border-r-primary'
                                                    : 'border-l-4 rounded-l border-l-primary'
                                            "
                                            :value="
                                                quote['quote_' + language.id]
                                            "
                                            :placeholder="
                                             static_translations?.quote_input_placeholder
                                                    ? static_translations?.quote_input_placeholder
                                                    : ''
                                                    "
                                        ></textarea>
                                        <error
                                            :fieldName="
                                                'quote.quote_' + language.id
                                            "
                                            :validationErros="errors"
                                        />
                                    </div>
                                    <div class="mt-4 relative">
                                        <label
                                            class="block text-base lg:text-lg"
                                            >{{
                                                static_translations?.image_upload_label_text
                                                    ? static_translations?.image_upload_label_text
                                                    : "Enter the quote"
                                            }}
                                            <!-- <span class="text-primary">*</span> -->
                                        </label>
                                        <input
                                            type="file"
                                            name="image"
                                            placeholder=""
                                            class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 border"
                                            :class="
                                                position == 'rtl'
                                                    ? 'border-r-4 rounded-r border-r-primary'
                                                    : 'border-l-4 rounded-l border-l-primary'
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
                                    class="my-8 flex items-center gap-6 justify-center"
                                >
                                    <button
                                        class="can-edu-btn-fill whitespace-nowrap"
                                        type="submit"
                                    >
                                        {{
                                            static_translations?.submit_button_text
                                                ? static_translations?.submit_button_text
                                                : "Enter the quote"
                                        }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div v-if="!is_logged_id" class="absolute inset-0 bg-gray-900 p-10 bg-opacity-50 flex justify-center items-center">
                        <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 border-4 border-primary/30" >
                            <div class="absolute top-3 right-3 cursor-pointer" @click="toggleModal">
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                    <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-center can-edu-p mt-4">Only registered users can post their quotes. If you are already registered, please log in. Otherwise, you are always welcome to join the Proxima Study family. Registration is free and only takes a minute.</p>
                            <div class="flex justify-center">
                            <button
                                type="button"
                                class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4"
                                data-modal-hide="defaultModal"
                                @click="toggleModal"
                            >
                                Close
                            </button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    <transition name="slide">
                <div id="defaultModal" tabindex="-1" 
                  class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 md:h-full"
                  v-if="showPopUpModal">
                  <div class="relative w-full bg-white rounded-2xl shadow-2xl border-4 border-primary/30 h-full max-w-2xl md:h-auto"
                    ref="elementToDetectClick">
                    <div class="relative">
                        <div class="absolute top-4 right-4 cursor-pointer" @click="togglePopUpModal">
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                      <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                        <p class="text-center can-edu-p mt-2">
                            {{
                                            static_translations?.success_popup_text
                                                ? static_translations?.success_popup_text
                                                : "Enter the quote"
                                        }}                        </p>
                                        <div class="flex justify-center">
                        <button type="button" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4"
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
        "is_logged_id",
        "logged_in_customer",
        "school_id",
        "position",
        "quote_translations",
        "lang",
        "lang_id",
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
            showModal: false,
            image: "",
            quote: {},
            name: "",
            location: "",
            errors: new ErrorHandling(),
            error_message: "",
            activeTab: null,
            showRecaptcha: true,
            toggelSubmitButton: false,
            emailValidationErro: "",
            static_translations: {},
        };
    },
    watch:{
        name(newValue, oldValue) {
      this.errors.has("name") ? this.errors.clear("name") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("quote_name", newValue);
      }
    },
    location(newValue, oldValue) {
      this.errors.has("location") ? this.errors.clear("location") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("quote_location", newValue);
      }
    },
    image(newValue, oldValue) {
      this.errors.has("image") ? this.errors.clear("image") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("quote_image", newValue);
      }
    },
    },
    
    methods: {
        togglePopUpModal() {
      this.showPopUpModal = !this.showPopUpModal;
      if (!this.showPopUpModal) {
        window.location.reload();
    }},
  
        toggleModal() {
            this.showModal = !this.showModal;
            // if (!this.is_logged_id) {
            //     window.location.href =
            //         "/" + this.lang + "/login?url=" + window.location.href;
            // }
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("media", e.target.files[0]);
            file.append("is_temp_media", true);
            file.append("type", "quote_image");
            axios.post("/api/web/media/process", file).then((res) => {
                this.image = JSON.stringify(res?.data);
                localStorage.setItem("quote_image", JSON.stringify(res?.data));
            });
        },
        handleInput(val, key) {
            this[key] = val;
            localStorage.setItem("quote_" + key, val);
        },
        // handleNameInput(val, i) {
        //     this.quote["quote_" + i] = val;
        //     localStorage.setItem("quote_quote", val);
        //     localStorage.setItem("quote_quote_index", i);
        // },
        handleNameInput(val, i) {
    this.quote["quote_" + i] = val;

    // Remove validation error if it exists
    if (this.errors?.has && this.errors.has("quote.quote_" + i)) {
        this.errors.clear("quote.quote_" + i);
    }

    localStorage.setItem("quote_quote", val);
    localStorage.setItem("quote_quote_index", i);
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
                quote: this.quote,
                name: this.name,
                location: this.location,
                image: this.image,
                status: "no",
                customer_id: this.logged_in_customer,
                school_id: this.school_id,
                is_web: 1,
            };
            let justLanguageId = [];
            this.languages.filter((res) => {
                justLanguageId.push(res.id);
            });
            data["language_id"] = justLanguageId;
            axios
                .post("/api/web/quotes", data)
                .then((res) => {
                    if (res?.data?.status == "Success") {
                        // helper.swalSuccessMessage(
                        //     "Thank you for your quote. We will post it live as soon as it is reviewed by our team. Have a good day!"
                        // );
                        this.showPopUpModal=true
                        localStorage.removeItem("quote_quote");
                        localStorage.removeItem("quote_quote_index");
                        localStorage.removeItem("quote_image");
                        localStorage.removeItem("quote_location");
                        localStorage.removeItem("quote_name");
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
                    this.showPopUpModal = false;

                }
            }
        },   handleClickOutsidePopup(event) {
            if (
                this.$refs.elementToDetectClick &&
                event.target.contains(this.$refs.elementToDetectClick)
            ) {
                if (this.showPopUpModal == true) {
                    this.showPopUpModal = false;
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
                    this.quote["quote_" + res?.id] = "";
                    const savedQuote = localStorage.getItem("quote_quote");
                    const savedQuoteIndex =
                        localStorage.getItem("quote_quote_index");
                    if (savedQuote && savedQuoteIndex) {
                        this.quote["quote_" + parseInt(savedQuoteIndex)] =
                            savedQuote;
                    }
                });
            });
        this.static_translations = JSON.parse(this.quote_translations);
        this.activeTab = this.lang_id;
    },
    mounted() {
        if (localStorage.getItem('openModal') === 'true') {
        this.showModal = true;
        localStorage.removeItem('openModal'); // Remove flag after use
    }
        // const save
        // dImage = localStorage.getItem("quote_image");
        // if (savedImage) {
        //     this.image = savedImage;
        // }

        // const savedLocation = localStorage.getItem("quote_location");
        // if (savedLocation) {
        //     this.location = savedLocation;
        // }
        // const savedName = localStorage.getItem("quote_name");
        // if (savedName) {
        //     this.name = savedName;
        // }
        localStorage.removeItem("quote_image");
    localStorage.removeItem("quote_location");
    localStorage.removeItem("quote_name");
    localStorage.removeItem("quote_quote");
    localStorage.removeItem("quote_quote_index");

    // Set fields to empty values
    this.quote = {};
    this.image = "";
    this.location = "";
    this.name = "";

        document.addEventListener("click", this.handleClickOutside);
        document.addEventListener("click", this.handleClickOutsidePopup);

    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutsidePopup);
        document.removeEventListener("click", this.handleClickOutside);
    },
};
</script>
