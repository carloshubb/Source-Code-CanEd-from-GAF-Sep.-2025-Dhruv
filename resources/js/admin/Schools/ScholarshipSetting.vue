<template>
    <div
        class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full"
    >
        <div class="modal-content py-6 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <h2 class="can-admin-h2">Scholarship</h2>
            </div>
            <div class="modal-body">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
                >
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
                                    activeTab == language.abbreviation
                                        ? 'text-white bg-primary active'
                                        : '',
                                    errors.has(
                                        `title_1.title_1_${language.code}`
                                    )
                                        ? 'bg-red-600 text-white hover:text-white'
                                        : '',
                                ]"
                                >{{ language.abbreviation }}</a
                            >
                        </li>
                    </ul>
                </div>
                <div
                    v-for="language in languages"
                    :key="language.abbreviation"
                    :class="
                        activeTab == language.abbreviation ? 'block' : 'hidden'
                    "
                >
                <div
                    class="w-full mt-2 relative"
                    v-if="isDataLoaded"
                >
                    <label
                        class="text-gray-700 font-semibold text-sm lg:text-base"
                        >Scholarship pre-description</label
                    >
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`scholarship_pre_description_${language.abbreviation}`"
                    ></div> -->
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'scholarship_pre_description'
                                )
                            "
                            :ref="`scholarship_pre_description_${language.abbreviation}`"
                            :id="`scholarship_pre_description_${language.abbreviation}`"
                            :initial-value="form[`scholarship_pre_description`][`scholarship_pre_description_${language?.abbreviation}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <error
                        :fieldName="`scholarship_pre_description.scholarship_pre_description_${language.abbreviation}`"
                        :validationErros="errors"
                    />
                </div>

                <div
                    class="w-full mt-2 relative"
                    v-if="isDataLoaded"
                >
                    <label
                        class="text-gray-700 font-semibold text-sm lg:text-base"
                        >Scholarship post-description</label
                    >
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`scholarship_post_description_${language.abbreviation}`"
                    ></div> -->
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'scholarship_post_description'
                                )
                            "
                            :ref="`scholarship_post_description_${language.abbreviation}`"
                            :id="`scholarship_post_description_${language.abbreviation}`"
                            :initial-value="form[`scholarship_post_description`][`scholarship_post_description_${language?.abbreviation}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <error
                        :fieldName="`scholarship_post_description.scholarship_post_description_${language.abbreviation}`"
                        :validationErros="errors"
                    />
                </div>

                <div
                    class="w-full mt-2 relative"
                    v-if="isDataLoaded"
                >
                    <label
                        class="text-gray-700 font-semibold text-sm lg:text-base"
                        >Programs pre-description</label
                    >
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`programs_pre_description_${language.abbreviation}`"
                    ></div> -->
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'programs_pre_description'
                                )
                            "
                            :ref="`programs_pre_description_${language.abbreviation}`"
                            :id="`programs_pre_description_${language.abbreviation}`"
                            :initial-value="form[`programs_pre_description`][`programs_pre_description_${language?.abbreviation}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <error
                        :fieldName="`programs_pre_description.programs_pre_description_${language.abbreviation}`"
                        :validationErros="errors"
                    />
                </div>

                

                

                <div
                    class="w-full mt-2 relative"
                    v-if="isDataLoaded"
                >
                    <label
                        class="text-gray-700 font-semibold text-sm lg:text-base"
                        >Programs post-description</label
                    >
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`programs_post_description_${language.abbreviation}`"
                    ></div> -->
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'programs_post_description'
                                )
                            "
                            :ref="`programs_post_description_${language.abbreviation}`"
                            :id="`programs_post_description_${language.abbreviation}`"
                            :initial-value="form[`programs_post_description`][`programs_post_description_${language?.abbreviation}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <error
                        :fieldName="`programs_post_description.programs_post_description_${language.abbreviation}`"
                        :validationErros="errors"
                    />
                </div>

                <div
                    class="w-full mt-2 relative"
                    v-if="isDataLoaded"
                >
                    <label
                        class="text-gray-700 font-semibold text-sm lg:text-base"
                        >FAQ pre-description</label
                    >
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'faq_pre_description'
                                )
                            "
                            :ref="`faq_pre_description_${language.abbreviation}`"
                            :id="`faq_pre_description_${language.abbreviation}`"
                            :initial-value="form[`faq_pre_description`][`faq_pre_description_${language?.abbreviation}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <error
                        :fieldName="`faq_pre_description.faq_pre_description_${language.abbreviation}`"
                        :validationErros="errors"
                    />
                </div>
                <div
                    class="w-full mt-2 relative"
                    v-if="isDataLoaded"
                >
                    <label
                        class="text-gray-700 font-semibold text-sm lg:text-base"
                        >FAQ post-description</label
                    >
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`faq_post_description_${language.abbreviation}`"
                    ></div> -->
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'faq_post_description'
                                )
                            "
                            :ref="`faq_post_description_${language.abbreviation}`"
                            :id="`faq_post_description_${language.abbreviation}`"
                            :initial-value="form[`faq_post_description`][`faq_post_description_${language?.abbreviation}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <error
                        :fieldName="`faq_post_description.faq_post_description_${language.abbreviation}`"
                        :validationErros="errors"
                    />
                </div>

                
                
                </div>
                <div class="w-full mt-2 relative">
                    <label
                        for=""
                        class="text-gray-700 font-semibold text-sm lg:text-base"
                        >Youtube video URL</label
                    >
                    <input
                        type="text"
                        placeholder=""
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
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
                        class="text-gray-700 font-semibold text-sm lg:text-base"
                        >Main video URL</label
                    >
                    <input
                        type="text"
                        placeholder=""
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
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
                
                <div class="flex justify-center items-center gap-3 mt-4">
                    <div>
                        <button class="can-edu-btn-fill" @click="addUpdate">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Editor from "@tinymce/tinymce-vue";
import axios from "axios";
import { mapState } from "vuex";
import Error from "./Error.vue";
export default {
    components: {
        Error,
        editor: Editor
    },
    props: ["logged_in_customer", "school_id"],
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
        },
        handleSelectionChange(language, key) {
            this.$store.commit(`scholarship_settings/updateFormData`, {
                value: tinymce.get(`${key}_${language.abbreviation}`).getContent(),
                id: language.abbreviation,
                key:key,
            });
        },
        changeLanguageTab(language) {
            this.activeTab = language.abbreviation;
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
                            "scholarship_settings/fetchScholarshipSettings",
                            {
                                url: `${process.env.MIX_WEB_API_URL}scholarship-settings?withScholarshipSettingDetail=1&is_admin=1&school_id=${this.$route.params.id}`,
                            }
                        );
                    }
                });
        },
        
        fetchScholarshipSettings() {
            this.$store
                .dispatch("scholarship_settings/fetchScholarshipSettings", {
                    url: `${process.env.MIX_WEB_API_URL}scholarship-settings?withScholarshipSettingDetail=1&is_admin=1&school_id=${this.$route.params.id}`,
                })
                .then((res) => {
                    let school_keys = [
                        "customer_id",
                        "scholarship_settings_apply_button_link",
                        "scholarship_settings_apply_button_title",
                        "scholarship_settings_red_bar_button_link",
                        "scholarship_settings_red_bar_button_title",
                        "scholarship_settings_blue_bar_button_title",
                        "scholarship_settings_blue_bar_button_link",
                        "video_url",
                        "top_page_video_url",
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
                        "faq_post_description",
                        "faq_pre_description",
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
            key: "school_id",
            value: this.$route.params.id,
        });
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
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
                            "faq_post_description",
                            "faq_pre_description",
                        ];
                        for (var i = 0; i < moreFields?.length; i++) {
                            let obj = {};
                            data.map((res) => {
                                obj[moreFields[i] + "_" + res.abbreviation] =
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
                        if(this.$route.params.id){
                    this.fetchScholarshipSettings();
                }
                else{
                    this.isDataLoaded = 1;
                }
                    }, 1000);
                }
            });
    },
};
</script>
