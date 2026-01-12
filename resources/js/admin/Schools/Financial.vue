<template>
    <AppLayout>
        <header class="py-4 bg-white">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="can-edu-h1">School financials</h1>
                    <router-link
                        :to="{ name: 'admin.schools.index' }"
                        class="can-edu-btn-fill"
                    >
                        Back
                    </router-link>
                </div>
            </div>
            <div v-if="$route?.params?.id">
                <other-options type="financial" :id="$route?.params?.id" />
            </div>
        </header>
        <div class="p-5 bg-white dark:bg-gray-800">
            <div class="modal-content py-6 text-left px-6">
                <div class="flex justify-between items-center pb-3">
                    <h2 class="can-admin-h2">School Financial</h2>
                </div>
                <div class="modal-body">
                    <div
                        class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
                    >
                        <ul class="flex flex-wrap my-4">
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
                    v-for="(language, index) in languages"
                        :key="language.abbreviation"
                        :class="
                            activeTab == language.abbreviation
                                ? 'block'
                                : 'hidden'
                        "
                        >
                    <div
                        class="w-full mt-2 relative"
                        v-if="isDataLoaded"
                    >
                        <label
                            class="text-gray-700 font-semibold text-sm lg:text-base"
                            >Tabs pre-description</label
                        >
                        <!-- <div
                            class="mt-5 ckeditorText"
                            :id="`tabs_pre_description_${language.abbreviation}`"
                        ></div> -->
                        <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'tabs_pre_description'
                                )
                            "
                            :ref="`tabs_pre_description_${language.abbreviation}`"
                            :id="`tabs_pre_description_${language.abbreviation}`"
                            :initial-value="form[`tabs_pre_description`][`tabs_pre_description_${language?.abbreviation}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                        <error
                            :fieldName="`tabs_pre_description.tabs_pre_description_${language.abbreviation}`"
                            :validationErros="errors"
                        />
                    </div>
                    <div
                        class="w-full mt-2 relative"
                    >
                        <label
                            class="text-gray-700 font-semibold text-sm lg:text-base"
                            >Tab 1 name</label
                        >
                        <input
                            type="text"
                            placeholder="Tab 1 name"
                            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="handleInput($event, 'tab1_name', language)"
                            :value="
                                form['tab1_name'] &&
                                form['tab1_name'][
                                    `tab1_name_${language.abbreviation}`
                                ]
                                    ? form['tab1_name'][
                                          `tab1_name_${language.abbreviation}`
                                      ]
                                    : ''
                            "
                        />
                        <error
                            :fieldName="`tab1_name.tab1_name_${language.abbreviation}`"
                            :validationErros="errors"
                        />
                    </div>
                    <div
                        class="w-full mt-2 relative"
                    >
                        <label
                            class="text-gray-700 font-semibold text-sm lg:text-base"
                            >Tab 2 name</label
                        >
                        <input
                            type="text"
                            placeholder="Tab 2 name"
                            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="handleInput($event, 'tab2_name', language)"
                            :value="
                                form['tab2_name'] &&
                                form['tab2_name'][
                                    `tab2_name_${language.abbreviation}`
                                ]
                                    ? form['tab2_name'][
                                          `tab2_name_${language.abbreviation}`
                                      ]
                                    : ''
                            "
                        />
                        <error
                            :fieldName="`tab2_name.tab2_name_${language.abbreviation}`"
                            :validationErros="errors"
                        />
                    </div>
                    <div
                        class="w-full mt-2 relative"
                    >
                        <label
                            class="text-gray-700 font-semibold text-sm lg:text-base"
                            >Tab 3 name</label
                        >
                        <input
                            type="text"
                            placeholder="Tab 3 name"
                            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="handleInput($event, 'tab3_name', language)"
                            :value="
                                form['tab3_name'] &&
                                form['tab3_name'][
                                    `tab3_name_${language.abbreviation}`
                                ]
                                    ? form['tab3_name'][
                                          `tab3_name_${language.abbreviation}`
                                      ]
                                    : ''
                            "
                        />
                        <error
                            :fieldName="`tab3_name.tab3_name_${language.abbreviation}`"
                            :validationErros="errors"
                        />
                    </div>
                    <div
                        class="w-full mt-2 relative"
                        v-if="isDataLoaded"
                    >
                        <label
                            class="text-gray-700 font-semibold text-sm lg:text-base"
                            >Tabs post-description</label
                        >
                        <!-- <div
                            class="mt-5 ckeditorText"
                            :id="`tabs_post_description_${language.abbreviation}`"
                        ></div> -->
                        <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'tabs_post_description'
                                )
                            "
                            :ref="`tabs_post_description_${language.abbreviation}`"
                            :id="`tabs_post_description_${language.abbreviation}`"
                            :initial-value="form[`tabs_post_description`][`tabs_post_description_${language?.abbreviation}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                        <error
                            :fieldName="`tabs_post_description.tabs_post_description_${language.abbreviation}`"
                            :validationErros="errors"
                        />
                    </div>
                    <div
                        class="w-full mt-2 relative"
                        v-if="isDataLoaded"
                    >
                        <label
                            class="text-gray-700 font-semibold text-sm lg:text-base"
                            >Tab 1 description</label
                        >
                        <!-- <div
                            class="mt-5 ckeditorText"
                            :id="`tab1_description_${language.abbreviation}`"
                        ></div> -->
                        <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'tab1_description'
                                )
                            "
                            :ref="`tab1_description_${language.abbreviation}`"
                            :id="`tab1_description_${language.abbreviation}`"
                            :initial-value="form[`tab1_description`][`tab1_description_${language?.abbreviation}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                        <error
                            :fieldName="`tab1_description.tab1_description_${language.abbreviation}`"
                            :validationErros="errors"
                        />
                    </div>
                    <div
                        class="w-full mt-2 relative"
                        v-if="isDataLoaded"
                    >
                        <label
                            class="text-gray-700 font-semibold text-sm lg:text-base"
                            >Tab 2 description</label
                        >
                        <!-- <div
                            class="mt-5 ckeditorText"
                            :id="`tab2_description_${language.abbreviation}`"
                        ></div> -->
                        <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'tab2_description'
                                )
                            "
                            :ref="`tab2_description_${language.abbreviation}`"
                            :id="`tab2_description_${language.abbreviation}`"
                            :initial-value="form[`tab2_description`][`tab2_description_${language?.abbreviation}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                        <error
                            :fieldName="`tab2_description.tab2_description_${language.abbreviation}`"
                            :validationErros="errors"
                        />
                    </div>
                    <div
                        class="w-full mt-2 relative"
                        v-if="isDataLoaded"
                    >
                        <label
                            class="text-gray-700 font-semibold text-sm lg:text-base"
                            >Tab 3 description</label
                        >
                        <!-- <div
                            class="mt-5 ckeditorText"
                            :id="`tab3_description_${language.abbreviation}`"
                        ></div> -->
                        <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'tab3_description'
                                )
                            "
                            :ref="`tab3_description_${language.abbreviation}`"
                            :id="`tab3_description_${language.abbreviation}`"
                            :initial-value="form[`tab3_description`][`tab3_description_${language?.abbreviation}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                        <error
                            :fieldName="`tab3_description.tab3_description_${language.abbreviation}`"
                            :validationErros="errors"
                        />
                    </div>
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
                        <!-- <div
                            class="mt-5 ckeditorText"
                            :id="`faq_pre_description_${language.abbreviation}`"
                        ></div> -->
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
                for="video_url"
                class="text-gray-700 font-semibold text-sm lg:text-base"
                >Youtube URL</label
              >
              <input
                id="video_url"
                type="text"
                placeholder=""
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="
                  handleInput($event, `video_url`)
                "
                :value="form?.[`video_url`] || ''"
              />
              <error
                :fieldName="`video_url`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative">
                <label
                  for="video_url"
                  class="text-gray-700 font-semibold text-sm lg:text-base"
                  >School finanical button title</label
                >
                <input
                  id="school_financials_apply_button_title"
                  type="text"
                  placeholder=""
                  class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                  @input="
                    handleInput($event, `school_financials_apply_button_title`)
                  "
                  :value="form?.[`school_financials_apply_button_title`] || ''"
                />
                <error
                  :fieldName="`school_financials_apply_button_title`"
                  :validationErros="errors"
                />
              </div>
              <div class="w-full mt-2 relative">
                <label
                  for="video_url"
                  class="text-gray-700 font-semibold text-sm lg:text-base"
                  >School finanical button link</label
                >
                <input
                  id="school_financials_apply_button_link"
                  type="text"
                  placeholder=""
                  class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                  @input="
                    handleInput($event, `school_financials_apply_button_link`)
                  "
                  :value="form?.[`school_financials_apply_button_link`] || ''"
                />
                <error
                  :fieldName="`school_financials_apply_button_link`"
                  :validationErros="errors"
                />
              </div>


              <div class="w-full mt-2 relative">
                <label
                  for="video_url"
                  class="text-gray-700 font-semibold text-sm lg:text-base"
                  >Good to go button title</label
                >
                <input
                  id="school_financials_blue_bar_button_title"
                  type="text"
                  placeholder=""
                  class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                  @input="
                    handleInput($event, `school_financials_blue_bar_button_title`)
                  "
                  :value="form?.[`school_financials_blue_bar_button_title`] || ''"
                />
                <error
                  :fieldName="`school_financials_blue_bar_button_title`"
                  :validationErros="errors"
                />
              </div>

              <div class="w-full mt-2 relative">
                <label
                  for="video_url"
                  class="text-gray-700 font-semibold text-sm lg:text-base"
                  >Good to go button link</label
                >
                <input
                  id="school_financials_blue_bar_button_link"
                  type="text"
                  placeholder=""
                  class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                  @input="
                    handleInput($event, `school_financials_blue_bar_button_link`)
                  "
                  :value="form?.[`school_financials_blue_bar_button_link`] || ''"
                />
                <error
                  :fieldName="`school_financials_blue_bar_button_link`"
                  :validationErros="errors"
                />
              </div>



              <div class="w-full mt-2 relative">
                <label
                  for="video_url"
                  class="text-gray-700 font-semibold text-sm lg:text-base"
                  >Let's apply button title</label
                >
                <input
                  id="school_financials_red_bar_button_title"
                  type="text"
                  placeholder=""
                  class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                  @input="
                    handleInput($event, `school_financials_red_bar_button_title`)
                  "
                  :value="form?.[`school_financials_red_bar_button_title`] || ''"
                />
                <error
                  :fieldName="`school_financials_red_bar_button_title`"
                  :validationErros="errors"
                />
              </div>

              <div class="w-full mt-2 relative">
                <label
                  for="video_url"
                  class="text-gray-700 font-semibold text-sm lg:text-base"
                  >Let's apply button link</label
                >
                <input
                  id="school_financials_red_bar_button_link"
                  type="text"
                  placeholder=""
                  class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                  @input="
                    handleInput($event, `school_financials_red_bar_button_link`)
                  "
                  :value="form?.[`school_financials_red_bar_button_link`] || ''"
                />
                <error
                  :fieldName="`school_financials_red_bar_button_link`"
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
    </AppLayout>
</template>
<script>
import Editor from "@tinymce/tinymce-vue";
import axios from "axios";
import { mapState } from "vuex";
import Error from "./Error.vue";
import OtherOptions from "./OtherOptions.vue";
export default {
    components: {
        Error,
        OtherOptions,
        editor: Editor,
    },
    props: ["logged_in_customer", "school_id"],
    computed: {
        ...mapState({
            form: (state) => state.school_financials.form,
            school_financials: (state) =>
                state.school_financials.school_financials,
            is_featured_array: (state) =>
                state.school_financials.is_featured_array,
            errors: (state) => state.school_financials.errors,
            isLoading: (state) => state.school_financials.isLoading,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            activeSubTab: "tab-1",
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
            this.$store.commit("school_financials/setIsFeatured", {
                checked: val,
                key,
            });
        },
        closeModal() {
            this.$store.commit("school_financials/setShowModal", 0);
        },
        handleInput(e, key, language) {
            this.$store.commit("school_financials/setForData", {
                key,
                language: language ? language : "",
                value: e.target.value,
            });
        },
        handleSelectionChange(language, key) {
            this.$store.commit(`school_financials/updateFormData`, {
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
                .dispatch("school_financials/addUpdateForm")
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$store.commit("school_financials/setLimit", 10);
                        this.$store.commit("school_financials/setSortBy", "id");
                        this.$store.commit(
                            "school_financials/setSortType",
                            "desc"
                        );
                        this.$store.dispatch(
                            "school_financials/fetchSchoolFinancials",
                            {
                                url: `${process.env.MIX_WEB_API_URL}school-financials?withSchoolFinancialDetail=1&is_admin=1&school_id=${this.$route.params.id}`,
                            }
                        );
                    }
                });
        },
        fetchSchoolFinancials() {
            this.$store
                .dispatch("school_financials/fetchSchoolFinancials", {
                    url: `${process.env.MIX_WEB_API_URL}school-financials?withSchoolFinancialDetail=1&is_admin=1&school_id=${this.$route.params.id}`,
                })
                .then((res) => {
                    let school_keys = [
                        "video_url",
                        "school_financials_apply_button_link",
                        "school_financials_apply_button_title",
                        "school_financials_red_bar_button_link",
                        "school_financials_red_bar_button_title",
                        "school_financials_blue_bar_button_link",
                        "school_financials_blue_bar_button_title",
                        "customer_id"
                    ];
                    let data = res.data.data ? res.data.data : [];
                    for (var i = 0; i < school_keys?.length; i++) {
                        this.$store.commit("school_financials/setForData", {
                            key: school_keys[i],
                            value: data[school_keys[i]]
                                ? data[school_keys[i]]
                                : "",
                        });
                    }

                    data =
                        res.data.data && res.data.data.school_financial_detail
                            ? res.data.data.school_financial_detail
                            : [];
                    var moreFields = [
                        "tabs_pre_description",
                        "tabs_post_description",
                        "tab1_name",
                        "tab2_name",
                        "tab3_name",
                        "tab1_description",
                        "tab2_description",
                        "tab3_description",
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
                                res[moreFields[i]];
                        });
                        this.$store.commit("school_financials/setForData", {
                            key: moreFields[i],
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
                this.$store.commit("school_financials/setForData", {
                    key: key,
                    value: res?.data,
                    language: "",
                });
            });
        },
    },

    created() {
        this.$store.commit("school_financials/setForData", {
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
                        "school_financials/setLanguages",
                        res.data.data
                    );
                    setTimeout(() => {
                        let data = res.data.data;
                        var moreFields = [
                            "video_url",
                        ];
                        for (var i = 0; i < moreFields?.length; i++) {
                            let obj = {};
                            data.map((res) => {
                                obj[moreFields[i] + "_" + res.abbreviation] =
                                    "";
                            });
                            this.$store.commit("school_financials/setForData", {
                                key: moreFields[i],
                                value: obj,
                            });
                        }
                        var moreFields = [
                        "tabs_pre_description",
                        "tabs_post_description",
                        "tab1_name",
                        "tab2_name",
                        "tab3_name",
                        "tab1_description",
                        "tab2_description",
                        "tab3_description",
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
                                obj[moreFields[i] + "_" + res.abbreviation] =
                                    "";
                            });
                            this.$store.commit("school_financials/setForData", {
                                key: moreFields[i],
                                value: obj,
                            });
                        }
                        if(this.$route.params.id){
                    this.fetchSchoolFinancials();
                }
                else{
                    this.isDataLoaded = 1;
                }
                    }, 1300);
                }
            });
    },
};
</script>
