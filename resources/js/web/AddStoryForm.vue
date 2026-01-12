<template>
    <div class="bg-white mx-auto">
        <template v-if="!is_logged_id">
            <div class="flex justify-end">
                <p class="text-red-500">
                    {{ indicate_required_field }}
                </p>
            </div>
            <form @submit.prevent="recaptcha()">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template v-for="(language, key) in languages" :key="language.id">
                        <div :class="(activeTab == null && language.is_default) ||
                            activeTab == language.id
                            ? 'block'
                            : 'hidden'
                            " class="relative md:col-span-2">
                            <label class="block text-base lg:text-lg">{{
                                static_translations?.title_label
                                    ? static_translations?.title_label
                                    : ""
                            }}
                                <span class="text-primary">*</span>
                            </label>
                            <input :key="key" :value="title['title_' + language.id]"
                                @input="handleMultipleInput($event.target.value, language.id, 'title')"
                                class="border w-full focus:ring-primary mb-2 focus:outline-none px-4 py-1.5 rounded border-gray-300"
                                :class="position == 'rtl'
                                    ? 'border-r-[5px] rounded-r border-r-primary'
                                    : 'border-l-[5px] rounded-l border-l-primary'
                                    " :placeholder="static_translations?.title_placeholder
                                        ? static_translations?.title_placeholder
                                        : ''
                                        " />
                            <error :fieldName="'title.title_' + language.id" :validationErros="errors" />
                        </div>
                        <div :class="(activeTab == null && language.is_default) ||
                            activeTab == language.id
                            ? 'block'
                            : 'hidden'
                            " class="relative md:col-span-2">
                            <label class="block text-base lg:text-lg">{{
                                static_translations?.story_label
                                    ? static_translations?.story_label
                                    : ""
                            }}
                                <span class="text-primary">*</span>
                            </label>
                            <!-- <editor
                            @selectionChange="
                              handleSelectionChange(language, 'story')
                            "
                            :ref="`story_${language.id}`"
                            :id="`story_${language.id}`"
                            :placeholder="
                              static_translations?.story_placeholder || ''
                            "
                            :initial-value="story?.[`story_${language?.id}`] || ''"

                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                          /> -->
                            <editor @selectionChange="handleSelectionChange(language, 'story')"
                                :ref="`story_${language.id}`" :id="`story_${language.id}`"
                                :placeholder="static_translations?.story_placeholder || ''"
                                :initial-value="story?.[`story_${language.id}`] || ''" :init="editorConfig"
                                :tinymce-script-src="tinymceScriptSrc" />

                            <error :fieldName="'story.story_' + language.id" :validationErros="errors" />
                        </div>
                    </template>

                    <div class="relative">
                        <label for="" class="block text-base lg:text-lg">{{
                            static_translations?.student_name_label
                                ? static_translations?.student_name_label
                                : ""
                        }}
                            <span class="text-primary">*</span>
                        </label>
                        <input type="text"
                            class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                            :class="position == 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                                " :placeholder="static_translations?.student_name_placeholder
                                    ? static_translations?.student_name_placeholder
                                    : ''
                                    " v-model="student_name" />
                        <error :fieldName="'student_name'" :validationErros="errors" />
                    </div>

                    <div class="relative">
                        <label for="" class="block text-base lg:text-lg">{{
                            static_translations?.email_label
                                ? static_translations?.email_label
                                : ""
                        }}
                            <span class="text-primary">*</span>
                        </label>
                        <input type="email"
                            class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                            :class="position == 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                                " :placeholder="static_translations?.email_placeholder
                                    ? static_translations?.email_placeholder
                                    : ''
                                    " v-model="email" />
                        <error :fieldName="'email'" :validationErros="errors" />
                    </div>

                    <div class="relative">
                        <label for="" class="block text-base lg:text-lg">{{
                            static_translations?.location_label
                                ? static_translations?.location_label
                                : ""
                        }}
                            <!-- <span class="text-primary">*</span> -->
                        </label>
                        <input type="text"
                            class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                            :class="position == 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                                " :placeholder="static_translations?.location_placeholder
                                    ? static_translations?.location_placeholder
                                    : ''
                                    " v-model="country_of_origin" />
                        <error :fieldName="'country_of_origin'" :validationErros="errors" />
                    </div>

                    <div class="relative z-0 w-full group">
                        <label for="image" class="block text-base lg:text-lg mb-2">
                            {{ static_translations?.image_label || "" }}
                        </label>
                        <FilePond name="image" class-name="my-pond" accepted-file-types="image/*"
                            @init="handleFilePondInit" @processfile="handleFilePondFlagIconProcess"
                            @removefile="handleFilePondFlagIconRemoveFile" />
                        <error :fieldName="'image'" :validationErros="errors" />
                    </div>


                </div>
                <div class="recaptcha">
                    <Error v-if="submitted" fieldName="captcha" :validationErros="errors" full_width="1" />
                </div>
                <div class="my-8 flex items-center gap-2 justify-center">
                    <!-- <button
                      class="can-edu-btn-fill whitespace-nowrap"
                      @click="toggleModal"
                  >
                      {{
                          static_translations?.close_button_text
                              ? static_translations?.close_button_text
                              : ""
                      }}
                  </button> -->
                    <button class="can-edu-btn-fill whitespace-nowrap" type="submit">
                        {{
                            static_translations?.story_submit_button_text
                                ? static_translations?.story_submit_button_text
                                : ""
                        }}
                    </button>
                </div>
            </form>
            <transition name="slide">
                <div v-if="showUnregisteredUserModal" 
                     class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto"
                     @click.self="toggleUnregisteredUserModal">
                    <div
                        class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                        ref="elementToDetectClick"
                    >
                        <div class="relative bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                            
                            
                            <div class="absolute top-3 right-3 cursor-pointer" @click="toggleUnregisteredUserModal"> 
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1">
                                    <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
            
                          
                            <p class="text-center can-edu-p mt-2">
                                {{
                                    static_translations?.logged_in_user_modal_text
                                        ? static_translations?.logged_in_user_modal_text
                                        : ""
                                }}
                            </p>
            
                            <!-- Close Button -->
                            <div class="flex justify-center">
                                <button type="button" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4" 
                                    @click="toggleUnregisteredUserModal"> 
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
            
        </template>
        <template v-else-if="JSON.parse(this.logged_in_customer)?.['package_price'] > 0">
            <div class="flex justify-end">
                <p class="text-red-500">
                    {{ indicate_required_field }}
                </p>
            </div>
            <form @submit.prevent="recaptcha()">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template v-for="(language, key) in languages" :key="language.id">
                        <div :class="(activeTab == null && language.is_default) ||
                            activeTab == language.id
                            ? 'block'
                            : 'hidden'
                            " class="relative md:col-span-2">
                            <label class="block text-base lg:text-lg">{{
                                static_translations?.title_label
                                    ? static_translations?.title_label
                                    : ""
                            }}
                                <span class="text-primary">*</span>
                            </label>
                            <input name="title" :key="key" :value="title['title_' + language.id]"
                                @input="handleMultipleInput($event.target.value, language.id, 'title')"
                                class="border w-full focus:ring-primary mb-2 focus:outline-none px-4 py-1.5 rounded border-gray-300"
                                :class="position == 'rtl'
                                    ? 'border-r-[5px] rounded-r border-r-primary'
                                    : 'border-l-[5px] rounded-l border-l-primary'
                                    " :placeholder="static_translations?.title_placeholder
                                        ? static_translations?.title_placeholder
                                        : ''
                                        " />
                            <error :fieldName="'title.title_' + language.id" :validationErros="errors" />
                        </div>
                        <div :class="(activeTab == null && language.is_default) ||
                            activeTab == language.id
                            ? 'block'
                            : 'hidden'
                            " class="relative md:col-span-2">
                            <label class="block text-base lg:text-lg">{{
                                static_translations?.story_label
                                    ? static_translations?.story_label
                                    : ""
                            }}
                                <span class="text-primary">*</span>
                            </label>
                            <!-- <editor
                            @selectionChange="
                              handleSelectionChange(language, 'story')
                            "
                            :ref="`story_${language.id}`"
                            :id="`story_${language.id}`"
                            :placeholder="
                              static_translations?.story_placeholder || ''
                            "
                            :initial-value="story?.[`story_${language?.id}`] || ''"

                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                          /> -->
                            <editor @selectionChange="handleSelectionChange(language, 'story')"
                                :ref="`story_${language.id}`" :id="`story_${language.id}`"
                                :placeholder="static_translations?.story_placeholder || ''"
                                :initial-value="story?.[`story_${language.id}`] || ''" :init="editorConfig"
                                :tinymce-script-src="tinymceScriptSrc" />

                            <error :fieldName="'story.story_' + language.id" :validationErros="errors" />
                        </div>
                    </template>

                    <div class="relative">
                        <label for="" class="block text-base lg:text-lg">{{
                            static_translations?.student_name_label
                                ? static_translations?.student_name_label
                                : ""
                        }}
                            <span class="text-primary">*</span>
                        </label>
                        <input type="text" name="student_name"
                            class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                            :class="position == 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                                " :placeholder="static_translations?.student_name_placeholder
                                    ? static_translations?.student_name_placeholder
                                    : ''
                                    " v-model="student_name" />
                        <error :fieldName="'student_name'" :validationErros="errors" />
                    </div>

                    <div class="relative">
                        <label for="" class="block text-base lg:text-lg">{{
                            static_translations?.email_label
                                ? static_translations?.email_label
                                : ""
                        }}
                            <span class="text-primary">*</span>
                        </label>
                        <input type="email" name="email"
                            class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                            :class="position == 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                                " :placeholder="static_translations?.email_placeholder
                                    ? static_translations?.email_placeholder
                                    : ''
                                    " v-model="email" />
                        <error :fieldName="'email'" :validationErros="errors" />
                    </div>

                    <div class="relative">
                        <label for="" class="block text-base lg:text-lg">{{
                            static_translations?.location_label
                                ? static_translations?.location_label
                                : ""
                        }}
                            <!-- <span class="text-primary">*</span> -->
                        </label>
                        <input type="text" name="country_of_origin"
                            class="mb-2 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded border-gray-300"
                            :class="position == 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                                " :placeholder="static_translations?.location_placeholder
                                    ? static_translations?.location_placeholder
                                    : ''
                                    " v-model="country_of_origin" />
                        <error :fieldName="'country_of_origin'" :validationErros="errors" />
                    </div>

                    <div class="relative z-0 w-full group">
                        <label for="image" class="block text-base lg:text-lg mb-2">
                            {{ static_translations?.image_label || "" }}
                        </label>
                        <FilePond name="image" class-name="my-pond" accepted-file-types="image/*"
                            @init="handleFilePondInit" @processfile="handleFilePondFlagIconProcess"
                            @removefile="handleFilePondFlagIconRemoveFile" />
                        <error :fieldName="'image'" :validationErros="errors" />
                    </div>


                </div>
                <div class="recaptcha">
                    <Error v-if="submitted" fieldName="captcha" :validationErros="errors" full_width="1" />
                </div>
                <div class="my-8 flex items-center gap-2 justify-center">
                    <!-- <button
                      class="can-edu-btn-fill whitespace-nowrap"
                      @click="toggleModal"
                  >
                      {{
                          static_translations?.close_button_text
                              ? static_translations?.close_button_text
                              : ""
                      }}
                  </button> -->
                    <button class="can-edu-btn-fill whitespace-nowrap" type="submit">
                        {{
                            static_translations?.story_submit_button_text
                                ? static_translations?.story_submit_button_text
                                : ""
                        }}
                    </button>
                </div>
            </form>
        </template>
        <template v-else>
            <transition name="slide">
                <div id="defaultModal" tabindex="-1" aria-hidden="true"
                    class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 md:h-full"
                    v-if="showModal">
                    <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                        ref="elementToDetectClick">
                        <!-- Modal content -->
                        <div class="">
                            <!-- modal cross button -->
                            <div class="absolute top-3 right-3 cursor-pointer" @click="toggleModal">
                                <button type="button"
                                    class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="defaultModal">
                                    <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="bg-white py-6 px-10 rounded shadow-lg text-center">
                                <p class="text-center can-edu-p mt-2">
                                    This feature is available exclusively to our Sponsors, as well as to our Premium and
                                    Featured schools
                                    and
                                    businesses
                                </p>
                                <div class="flex justify-center">
                                <button type="button" class="can-edu-btn-fill  whitespace-nowrap px-2.5 md:px-5 mt-4"
                                    @click="toggleModal">
                                    Close
                                </button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </template>
        <transition name="slide">
            <div id="defaultModal" tabindex="-1" aria-hidden="true"
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
                                {{success_message
                                }} </p>
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
        <!-- Unregistered User Modal -->


    </div>
</template>
<script>
// ES6 Modules or TypeScript
import Swal from "sweetalert2";
import axios from "axios";
import ErrorHandling from "../ErrorHandling";
import { mapState } from "vuex";
import vueRecaptcha from "vue3-recaptcha2";
import Error from "./Error.vue";

import Editor from "@tinymce/tinymce-vue";
import { load } from "recaptcha-v3";

import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

export default {
    props: [
        "is_logged_id",
        "logged_in_customer",
        "school_id",
        "lang",
        "lang_id",
        "stories_modal_translation",
        "position",
        "indicate_required_field",
        "success_message",
    ],
    components: {
        vueRecaptcha,
        FilePond,
        editor: Editor,
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
            showUnregisteredUserModal: false,
            showPopUpModal: false,
            student_name: '',
            image: '',
            email: '',
            country_of_origin: '',
            story: {},
            title: {},
            errors: new ErrorHandling(),
            error_message: "",
            activeTab: null,
            showRecaptcha: true,
            toggelSubmitButton: false,
            emailValidationErro: "",
            static_translations: [],
            editorConfig: {
                height: 250,
                menubar: false,
                plugins:
                    "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code",
                toolbar:
                    "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen",
            },
            tinymceScriptSrc: "/plugins/tinymce/tinymce.min.js",
        };
    },
    methods: {
        toggleUnregisteredUserModal() {
    this.showUnregisteredUserModal = false;
    window.location.href = "/" + this.lang + "/story";
},

        // handleSelectionChange(language, key) {
        //     this.$store.commit(`stories/updateState`, {
        //         value: tinymce.get(`${key}_${language.id}`).getContent(),
        //         id: language.id,
        //         key:key,
        //     });
        // },
        // handleSelectionChange(language, key) {
        //     let val = tinymce.get(`${key}_${language.id}`).getContent();
        //     // Make sure to directly update the 'story' object, not 'form'.
        //     this.story[`story_${language.id}`] = val;
        // },
        handleSelectionChange(language, key) {
            const fieldName = `${key}.${key}_${language.id}`;
            let val = tinymce.get(`${key}_${language.id}`).getContent();

            // Update the story object with new content
            if (val.trim() !== this.story[`story_${language.id}`]) {
                this.story[`story_${language.id}`] = val;

                // Clear the validation error ONLY when text is entered
                if (this.errors.has(fieldName) && val.trim() !== '') {
                    this.errors.clear(fieldName);
                }
            }
        },

        handleClickOutside(event) {
            if (
                this.$refs.elementToDetectClick &&
                !this.$refs.elementToDetectClick.contains(event.target)
            ) {
                if (this.showModal) {
                    this.showModal = false;
                    this.showPopUpModal = false;
                    window.location.href = "/" + this.lang + "/story";
                }
            }
        },


        toggleModal() {
            this.showModal = !this.showModal;
            if (!this.showModal) {
                window.location.href = "/" + this.lang + "/story";
            }
        },
        togglePopUpModal() {
            this.showPopUpModal = !this.showPopUpModal;
            if (!this.showPopUpModal) {
                window.location.href = "/" + this.lang + "/story";
            }
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        // handleMultipleInput(key, value, language) {
        //     this.$store.commit("stories/updateState", {
        //         value: value,
        //         id: language.id,
        //         key,
        //     });
        // },
        handleMultipleInput(val, languageId, key) {
            const fieldName = `${key}.${key}_${languageId}`;
            this[key][`${key}_${languageId}`] = val;

            if (this.errors.has(fieldName)) {
                this.errors.clear(fieldName);
            }

            localStorage.setItem(`story_${key}_${languageId}`, val);
            localStorage.setItem(`story_${key}_index`, languageId);
        },
        handleFilePondInit() {
            setOptions({
                credits: false,
                server: {
                    url: process.env.MIX_WEB_API_URL,
                    process: (
                        fieldName,
                        file,
                        metadata,
                        load,
                        error,
                        progress,
                        abort,
                        transfer,
                        options
                    ) => {
                        const formData = new FormData();
                        formData.append("media", file, file.name);
                        formData.append("is_temp_media", 1);
                        formData.append("type", "image");

                        const request = new XMLHttpRequest();
                        request.open("POST", `${process.env.MIX_WEB_API_URL}media/process`);
                        request.setRequestHeader(
                            "X-CSRF-TOKEN",
                            document.head.querySelector('meta[name="csrf-token"]').content
                        );

                        request.upload.onprogress = (e) => {
                            progress(e.lengthComputable, e.loaded, e.total);
                        };
                        request.onload = function () {
                            if (request.status >= 200 && request.status < 300) {
                                load(request.responseText);
                            } else {
                                error("oh no");
                            }
                        };

                        request.send(formData);

                        return {
                            abort: () => {
                                request.abort();
                                abort();
                            },
                        };
                    },
                    revert: (uniqueFileId, load, error) => {
                        const formData = new FormData();
                        formData.append("media", uniqueFileId);

                        const request = new XMLHttpRequest();
                        request.open("POST", `${process.env.MIX_WEB_API_URL}media/revert`);
                        request.setRequestHeader(
                            "X-CSRF-TOKEN",
                            document.head.querySelector('meta[name="csrf-token"]').content
                        );

                        request.send(formData);

                        return {
                            abort: () => {
                                request.abort();
                                abort();
                            },
                        };
                    },
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                },
            });
        },
        handleFilePondFlagIconProcess(error, file) {
            this.image = file.serverId || null;
            this.id = this.$route.params.id || null;
        },
        handleFilePondFlagIconRemoveFile(error, file) {
            this.image = null;
        },
        convertImgUrlToBase64(url, type) {
            var image = new Image();

            image.onload = function () {
                var canvas = document.createElement("canvas");
                canvas.width = image.width;
                canvas.height = image.height;

                canvas.getContext("2d").drawImage(this, 0, 0);

                canvas.toBlob(
                    function (source) {
                        var newImg = document.createElement("img"),
                            url = URL.createObjectURL(source);

                        newImg.onload = function () {
                            URL.revokeObjectURL(url);
                        };

                        newImg.src = url;
                    },
                    type,
                    1
                );
                let dataUrl = canvas.toDataURL(type);
                let files = [
                    {
                        source: dataUrl,
                        options: {
                            type: "local",
                        },
                    },
                ];
                setOptions({
                    files: files,
                });
            };
            image.src = url;
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
                story: this.story,
                title: this.title,
                student_name: this.student_name,
                country_of_origin: this.country_of_origin,
                email: this.email,
                image: this.image,
                is_web: true,
            };
            let justLanguageId = [];
            this.languages.filter((res) => {
                justLanguageId.push(res.id);
            });
            data["language_id"] = justLanguageId;
            axios
                .post("/api/web/stories", data)
                .then((res) => {
                    if (res?.data?.status == "Success") {
                        this.showPopUpModal=true
                        let careerfields = [
                            "student_name",
                            "country_of_origin",
                            "email",
                            "image",
                        ];
                        careerfields?.map((f) => {
                            const savedField = localStorage.removeItem("story_" + f);
                        });
                        let multiKeys = ["title", "story"];
                        multiKeys.map((field) => {
                            localStorage.removeItem("story_" + field);
                            localStorage.removeItem("story_" + field + "_index");
                        });
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
                            helper.swalErrorMessage(error.response.data.message);
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
    },
    watch: {
        email(newValue) {
            if (this.errors.has("email") && newValue.trim() !== "") {
                this.errors.clear("email");
            }
        },
        student_name(newValue) {
            if (this.errors.has("student_name") && newValue.trim() !== "") {
                this.errors.clear("student_name");
            }
        },
        image(newValue) {
            if (this.errors.has("image") && newValue.trim() !== "") {
                this.errors.clear("image");
            }
        }
    },

    created() {
        // if (!this.is_logged_id) {
        //     window.location.href =
        //         "/" + this.lang + "/login?url=" + window.location.href;
        // }
        if (!this.is_logged_id) {
        this.showUnregisteredUserModal = true; // ✅ Show modal instead of redirecting
    }

        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_WEB_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;

                data.forEach((res) => {
                    this.title["title_" + res?.id] = "";
                    this.story["story_" + res?.id] = "";
                });

                localStorage.removeItem("title");
                localStorage.removeItem("title_index");
                localStorage.removeItem("story_");
                localStorage.removeItem("story_index");
            });

        this.activeTab = this.lang_id;
        this.static_translations = JSON.parse(this.stories_modal_translation);
    },

    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutside);
    },
    mounted() {
        console.log("Story Data:", this.story);
        document.addEventListener("click", this.handleClickOutside);
        this.toggleModal();
        let careerfields = [
            "country_of_origin",
            "email",
            "image",
            "student_name",
        ];
        careerfields?.map((f) => {
            this[f] = "";
        });
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