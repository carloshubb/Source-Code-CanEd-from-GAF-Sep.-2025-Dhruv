<template>
    <div
        class="md:col-span-8 col-span-12 w-full"
    >
        <div class="modal-content py-6 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <h2 class="can-school-h2 text-primary">Scholarships</h2>
            </div>
            <div class="modal-body">
                <div
                   class="text-sm font-medium text-center text-gray-500 dark:text-gray-400 dark:border-gray-700"
                >
                    <h3 class="text-left">Language</h3>
                    <p class="text-left text-base font-normal text-gray-700">Select the languages under which you want your school profile to appear</p>
                    <ul class="flex gap-2 flex-wrap my-4">
                        <li
                            class="mr-2"
                            v-for="language in languages"
                            :key="language.code"
                        >
                            <a
                                @click.prevent="changeLanguageTab(language)"
                                href="#"
                                :class="[
                                    'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                    activeTab != null &&
                                    activeTab == language.language_code
                                        ? 'text-white bg-primary active'
                                        : '',
                                    errors.has(
                                        `title_1.title_1_${language.code}`
                                    )
                                        ? 'bg-red-600 text-white hover:text-white'
                                        : '',
                                ]"
                                >{{ getLanguageName(language.language_code) }}</a
                            >
                        </li>
                    </ul>
                </div>
                <div
                    v-for="language in languages"
                    :key="language.language_code"
                    :class="
                        activeTab == language.language_code ? 'block' : 'hidden'
                    "
                >
                <div
                    class="w-full mt-2 relative"
                    v-if="isDataLoaded"
                >
                    <label
                        class="block text-base lg:text-lg mb-2"
                        >Scholarship pre-description</label
                    >
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`scholarship_pre_description_${language.language_code}`"
                    ></div> -->
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'scholarship_pre_description'
                                )
                            "
                            :ref="`scholarship_pre_description_${language.language_code}`"
                            :id="`scholarship_pre_description_${language.language_code}`"
                            :initial-value="form[`scholarship_pre_description`][`scholarship_pre_description_${language?.language_code}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <error
                        :fieldName="`scholarship_pre_description.scholarship_pre_description_${language.language_code}`"
                        :validationErros="errors"
                    />
                    
                </div>

                <div
                    class="w-full mt-2 relative"
                    v-if="isDataLoaded"
                >
                    <label
                        class="block text-base lg:text-lg mb-2"
                        >Scholarship post-description</label
                    >
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`scholarship_post_description_${language.language_code}`"
                    ></div> -->
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'scholarship_post_description'
                                )
                            "
                            :ref="`scholarship_post_description_${language.language_code}`"
                            :id="`scholarship_post_description_${language.language_code}`"
                            :initial-value="form[`scholarship_post_description`][`scholarship_post_description_${language?.language_code}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <error
                        :fieldName="`scholarship_post_description.scholarship_post_description_${language.language_code}`"
                        :validationErros="errors"
                    />
                </div>

                <div
                    class="w-full mt-2 relative"
                    v-if="isDataLoaded"
                >
                    <label
                        class="block text-base lg:text-lg mb-2"
                        >Programs pre-description</label
                    >
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`programs_pre_description_${language.language_code}`"
                    ></div> -->
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'programs_pre_description'
                                )
                            "
                            :ref="`programs_pre_description_${language.language_code}`"
                            :id="`programs_pre_description_${language.language_code}`"
                            :initial-value="form[`programs_pre_description`][`programs_pre_description_${language?.language_code}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <error
                        :fieldName="`programs_pre_description.programs_pre_description_${language.language_code}`"
                        :validationErros="errors"
                    />
                </div>

                <div
                    class="w-full mt-2 relative"
                    v-if="isDataLoaded"
                >
                    <label
                        class="block text-base lg:text-lg mb-2"
                        >Programs post-description</label
                    >
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`programs_post_description_${language.language_code}`"
                    ></div> -->
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'programs_post_description'
                                )
                            "
                            :ref="`programs_post_description_${language.language_code}`"
                            :id="`programs_post_description_${language.language_code}`"
                            :initial-value="form[`programs_post_description`][`programs_post_description_${language?.language_code}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <error
                        :fieldName="`programs_post_description.programs_post_description_${language.language_code}`"
                        :validationErros="errors"
                    />
                </div>

                <div
                    class="w-full mt-2 relative"
                    v-if="isDataLoaded"
                >
                    <label
                        class="block text-base lg:text-lg mb-2"
                        >FAQ pre-description</label
                    >
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`faq_pre_description_${language.language_code}`"
                    ></div> -->
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'faq_pre_description'
                                )
                            "
                            :ref="`faq_pre_description_${language.language_code}`"
                            :id="`faq_pre_description_${language.language_code}`"
                            :initial-value="form[`faq_pre_description`][`faq_pre_description_${language?.language_code}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <error
                        :fieldName="`faq_pre_description.faq_pre_description_${language.language_code}`"
                        :validationErros="errors"
                    />
                </div>

                <div
                    class="w-full mt-2 relative"
                    v-if="isDataLoaded"
                >
                    <label
                        class="block text-base lg:text-lg mb-2"
                        >FAQ post-description</label
                    >
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`faq_post_description_${language.language_code}`"
                    ></div> -->
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'faq_post_description'
                                )
                            "
                            :ref="`faq_post_description_${language.language_code}`"
                            :id="`faq_post_description_${language.language_code}`"
                            :initial-value="form[`faq_post_description`][`faq_post_description_${language?.language_code}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <error
                        :fieldName="`faq_post_description.faq_post_description_${language.language_code}`"
                        :validationErros="errors"
                    />
                </div>

                
                </div>
                <div class="w-full mt-2 relative">
                    <label
                        for=""
                        class="block text-base lg:text-lg"
                        >Youtube video URL</label
                    >
                    <input name="video_url"
                        type="text"
                        placeholder=""
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'video_url', '')"
                        :value="
                            form['video_url']
                                ? form['video_url']
                                : ''
                        "
                    />
                    <error
                        :fieldName="`video_url`"
                        :validationErros="errors"
                    />
                </div>
                <div class="w-full mt-2 relative">
                    <label
                        for=""
                        class="block text-base lg:text-lg"
                        >Main video URL</label
                    >
                    <input
                        type="text"
                        placeholder=""
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'top_page_video_url', '')"
                        :value="
                            form['top_page_video_url']
                                ? form['top_page_video_url']
                                : ''
                        "
                    />
                    <error
                        :fieldName="`top_page_video_url`"
                        :validationErros="errors"
                    />
                </div>
                <div class="w-full mt-2 relative">
                    <label
                      for=""
                      class="text-gray-700 font-semibold text-sm lg:text-base"
                      >School scholarships button title</label
                    >
                    <input
                      type="text"
                      placeholder=""
                      class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                      @input="handleInput($event, 'scholarship_settings_apply_button_title', '')"
                      :value="
                        form['scholarship_settings_apply_button_title'] ? form['scholarship_settings_apply_button_title'] : ''
                      "
                    />
                    <error
                      :fieldName="`scholarship_settings_apply_button_title`"
                      :validationErros="errors"
                    />
                  </div>
                  <div class="w-full mt-2 relative">
                    <label
                      for=""
                      class="text-gray-700 font-semibold text-sm lg:text-base"
                      >School scholarships button link</label
                    >
                    <input
                      type="text"
                      placeholder=""
                      class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                      @input="handleInput($event, 'scholarship_settings_apply_button_link', '')"
                      :value="
                        form['scholarship_settings_apply_button_link'] ? form['scholarship_settings_apply_button_link'] : ''
                      "
                    />
                    <error
                      :fieldName="`scholarship_settings_apply_button_link`"
                      :validationErros="errors"
                    />
                  </div>

                  
                  <div class="w-full mt-2 relative">
                    <label
                      for=""
                      class="text-gray-700 font-semibold text-sm lg:text-base"
                      >Good to go button title</label
                    >
                    <input
                      type="text"
                      placeholder=""
                      class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                      @input="handleInput($event, 'scholarship_settings_blue_bar_button_title', '')"
                      :value="
                        form['scholarship_settings_blue_bar_button_title'] ? form['scholarship_settings_blue_bar_button_title'] : ''
                      "
                    />
                    <error
                      :fieldName="`scholarship_settings_blue_bar_button_title`"
                      :validationErros="errors"
                    />
                  </div>

                  <div class="w-full mt-2 relative">
                    <label
                      for=""
                      class="text-gray-700 font-semibold text-sm lg:text-base"
                      >Good to go button link</label
                    >
                    <input
                      type="text"
                      placeholder=""
                      class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                      @input="handleInput($event, 'scholarship_settings_blue_bar_button_link', '')"
                      :value="
                        form['scholarship_settings_blue_bar_button_link'] ? form['scholarship_settings_blue_bar_button_link'] : ''
                      "
                    />
                    <error
                      :fieldName="`scholarship_settings_blue_bar_button_link`"
                      :validationErros="errors"
                    />
                  </div>


                  <div class="w-full mt-2 relative">
                    <label
                      for=""
                      class="text-gray-700 font-semibold text-sm lg:text-base"
                      >Let's go button title</label
                    >
                    <input
                      type="text"
                      placeholder=""
                      class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                      @input="handleInput($event, 'scholarship_settings_red_bar_button_title', '')"
                      :value="
                        form['scholarship_settings_red_bar_button_title'] ? form['scholarship_settings_red_bar_button_title'] : ''
                      "
                    />
                    <error
                      :fieldName="`scholarship_settings_red_bar_button_title`"
                      :validationErros="errors"
                    />
                  </div>

                  <div class="w-full mt-2 relative">
                    <label
                      for=""
                      class="text-gray-700 font-semibold text-sm lg:text-base"
                      >Let's go button link</label
                    >
                    <input
                      type="text"
                      placeholder=""
                      class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                      @input="handleInput($event, 'scholarship_settings_red_bar_button_link', '')"
                      :value="
                        form['scholarship_settings_red_bar_button_link'] ? form['scholarship_settings_red_bar_button_link'] : ''
                      "
                    />
                    <error
                      :fieldName="`scholarship_settings_red_bar_button_link`"
                      :validationErros="errors"
                    />
                  </div>
                
                <div class="flex justify-end items-center gap-3 mt-4">
                    <button class="can-edu-btn-fill" @click="addUpdate">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Editor from "@tinymce/tinymce-vue";
import axios from "axios";
import { mapState } from "vuex";
import Error from '../Error.vue';
export default {
  components: { Error, editor: Editor },
    props: ["logged_in_customer", "school_id", "languages_with_names"],
    computed: {
        ...mapState({
            form: (state) => state.scholarship_settings.form,
            scholarship_settings: (state) =>
                state.scholarship_settings.scholarship_settings,
            is_featured_array: (state) =>
                state.scholarship_settings.is_featured_array,
            errors: (state) => state.scholarship_settings.errors,
            isLoading: (state) => state.scholarship_settings.isLoading,
            languages: (state) => state.scholarship_settings.languages,
        }),
        parsedLanguages() {
        if (typeof this.languages_with_names === 'string') {
            try {
                return JSON.parse(this.languages_with_names);
            } catch (error) {
                console.error('Error parsing JSON:', error);
                return []; // Return an empty array as a fallback
            }
        }
        return this.languages_with_names; // Return as is if already an array or object
    }
    },
    data() {
        return {
            activeTab: "en",
            isDataLoaded: false,
            editorConfig: {
                height: 250,
                menubar: false,
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen',
            },
            tinymceScriptSrc: "/plugins/tinymce/tinymce.min.js",
        };
    },
    methods: {
        getLanguageName(language_code) {
        const languages = this.parsedLanguages; // Use the computed property
        if (Array.isArray(languages)) {
            const language = languages.find(
                (lang) => lang.language_code === language_code
            );
            return language ? language.language_name : language_code;
        }
        return language_code; // Fallback if parsedLanguages is not an array
    },
        handleIsFeatured(val, key) {
            this.$store.commit("scholarship_settings/setIsFeatured", {
                checked: val,
                key,
            });
        },
        closeModal() {
            this.$store.commit("scholarship_settings/setShowModal", 0);
        },
        handleInput(e, key, language) {
            this.$store.commit("scholarship_settings/setForData", {
                key,
                language: language ? language : "",
                value: e.target.value,
            });
            if (this.errors.has(key)) {
        this.errors.clear(key);
    }
        },
        handleSelectionChange(language, key) {
            this.$store.commit(`scholarship_settings/updateFormData`, {
                value: tinymce.get(`${key}_${language.language_code}`).getContent(),
                id: language.language_code,
                key:key,
            });
        },
        changeLanguageTab(language) {
            this.activeTab = language.language_code;
        },
        addUpdate() {
            this.$store
                .dispatch("scholarship_settings/addUpdateForm")
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$store.commit("scholarship_settings/setLimit", 10);
                        this.$store.commit(
                            "scholarship_settings/setSortBy",
                            "id"
                        );
                        this.$store.commit(
                            "scholarship_settings/setSortType",
                            "desc"
                        );
                        this.$store.dispatch(
                            "scholarship_settings/fetchScholarshipSettings"
                        );
                    }
                }).catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.focusOnFirstErrorInput(error.response.data.errors);
                    }
                });
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
        fetchScholarshipSettings() {
            this.$store
                .dispatch("scholarship_settings/fetchScholarshipSettings", {
                    url: `${process.env.MIX_WEB_API_URL}scholarship-settings?withScholarshipSettingDetail=1`,
                })
                .then((res) => {
                    let school_keys = [
                        "video_url",
                        "top_page_video_url",
                        "scholarship_settings_apply_button_title",
                        "scholarship_settings_apply_button_link",
                        "scholarship_settings_red_bar_button_link",
                        "scholarship_settings_red_bar_button_title",
                        "scholarship_settings_blue_bar_button_title",
                        "scholarship_settings_blue_bar_button_link",
                    ];
                    let data = res.data.data ? res.data.data : [];
                    for (var i = 0; i < school_keys?.length; i++) {
                        this.$store.commit("scholarship_settings/setForData", {
                            key: school_keys[i],
                            value: data[school_keys[i]]
                                ? data[school_keys[i]]
                                : "",
                        });
                    }

                    data =
                        res.data.data &&
                        res.data.data.scholarship_setting_detail
                            ? res.data.data.scholarship_setting_detail
                            : [];

                    var moreFields1 = [
                        "scholarship_pre_description",
                        "scholarship_post_description",
                        "programs_pre_description",
                        "programs_post_description",
                        "faq_pre_description",
                        "faq_post_description",
                    ];
                    for (var i = 0; i < moreFields1?.length; i++) {
                        let obj = {};
                        data.map((res) => {
                            obj[moreFields1[i] + "_" + res.language_code] =
                                res[moreFields1[i]];
                        });
                        this.$store.commit("scholarship_settings/setForData", {
                            key: moreFields1[i],
                            value: obj,
                        });
                    }
                    this.isDataLoaded = 1;
                });
        },
        handleImage(e, key) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.$store.commit("scholarship_settings/setForData", {
                    key: key,
                    value: res?.data,
                    language: "",
                });
            });
        },
    },

    created() {
        this.$store.commit("scholarship_settings/setForData", {
            key: "customer_id",
            value: this.logged_in_customer,
        });
        this.$store.commit("scholarship_settings/setForData", {
            key: "school_id",
            value: this.school_id,
        });
        axios
            .get(
                "/api/web/customer-languages?customer_id=" +
                    this.logged_in_customer
            )
            .then((res) => {
                if (res.data.status == "Success") {
                    this.$store.commit(
                        "scholarship_settings/setLanguages",
                        res.data.data
                    );

                    setTimeout(() => {
                        let data = res.data.data;
                        var moreFields = [
                            "scholarship_pre_description",
                            "scholarship_post_description",
                            "programs_pre_description",
                            "programs_post_description",
                            "faq_pre_description",
                            "faq_post_description",
                        ];
                        for (var i = 0; i < moreFields?.length; i++) {
                            let obj = {};
                            data.map((res) => {
                                obj[moreFields[i] + "_" + res.language_code] =
                                    "";
                            });
                            this.$store.commit(
                                "scholarship_settings/setForData",
                                {
                                    key: moreFields[i],
                                    value: obj,
                                }
                            );
                        }
                            this.fetchScholarshipSettings();
                    }, 1000);
                }
            });
    },
};
</script>
