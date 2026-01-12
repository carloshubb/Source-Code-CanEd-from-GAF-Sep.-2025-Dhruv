<template>
    <div
        class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full"
    >
    <div class="p-4">
        <div class="modal-content py-6 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <h2 class="can-admin-h2">School Contact</h2>
            </div>
            <div class="modal-body">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
                >
                    <ul class="flex flex-wrap my-4">
                        <li
                            class="mr-2"
                            v-for="language in languages"
                            :key="language.abbreviation"
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
                                        `main_paragraph.main_paragraph_${language.abbreviation}`
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
                    class="w-full mt-2"
                    v-if="isDataLoaded"
                >
                    <label
                        class="text-gray-700 font-semibold text-sm lg:text-base"
                        >Title 1 Paragraph</label
                    >
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`main_paragraph_${language.abbreviation}`"
                    ></div> -->
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'main_paragraph'
                                )
                            "
                            :ref="`main_paragraph_${language.abbreviation}`"
                            :id="`main_paragraph_${language.abbreviation}`"
                            :initial-value="form[`main_paragraph`][`main_paragraph_${language?.abbreviation}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <error
                        :fieldName="`main_paragraph.main_paragraph_${language.abbreviation}`"
                        :validationErros="errors"
                    />
                </div>
                <!-- <div
                    class="w-full mt-2"
                    v-if="isDataLoaded"
                >
                    <label
                        class="text-gray-700 font-semibold text-sm lg:text-base"
                        >Brief descriptioon</label
                    >
                 
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'brief_description'
                                )
                            "
                            :ref="`brief_description_${language.abbreviation}`"
                            :id="`brief_description_${language.abbreviation}`"
                            :initial-value="form[`brief_description`][`brief_description_${language?.abbreviation}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <error
                        :fieldName="`brief_description.brief_description_${language.abbreviation}`"
                        :validationErros="errors"
                    />
                </div> -->
                </div>
                <div class="w-full mt-2 relative">
                    <label
                        for=""
                        class="block text-base lg:text-lg"
                        >Contact button Title</label
                    >
                    <input
                        type="text"
                        placeholder=""
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'school_contact_apply_button_title', '')"
                        :value="
                            form['school_contact_apply_button_title']
                                ? form['school_contact_apply_button_title']
                                : ''
                        "
                    />
                    <error
                        :fieldName="`school_contact_apply_button_title`"
                        :validationErros="errors"
                    />
                </div>
                  <div class="w-full mt-2 relative">
                    <label
                        for=""
                        class="block text-base lg:text-lg"
                        >Contact button link</label
                    >
                    <input
                        type="text"
                        placeholder=""
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'school_contact_apply_button_link', '')"
                        :value="
                            form['school_contact_apply_button_link']
                                ? form['school_contact_apply_button_link']
                                : ''
                        "
                    />
                    <error
                        :fieldName="`school_contact_apply_button_link`"
                        :validationErros="errors"
                    />
                </div>


                <div class="w-full mt-2 relative">
                    <label
                        for=""
                        class="block text-base lg:text-lg"
                        >Good to go button title</label
                    >
                    <input
                        type="text"
                        placeholder=""
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'school_contact_blue_bar_button_title', '')"
                        :value="
                            form['school_contact_blue_bar_button_title']
                                ? form['school_contact_blue_bar_button_title']
                                : ''
                        "
                    />
                    <error
                        :fieldName="`school_contact_blue_bar_button_title`"
                        :validationErros="errors"
                    />
                </div>

                <div class="w-full mt-2 relative">
                    <label
                        for=""
                        class="block text-base lg:text-lg"
                        >Good to go button link</label
                    >
                    <input
                        type="text"
                        placeholder=""
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'school_contact_blue_bar_button_link', '')"
                        :value="
                            form['school_contact_blue_bar_button_link']
                                ? form['school_contact_blue_bar_button_link']
                                : ''
                        "
                    />
                    <error
                        :fieldName="`school_contact_blue_bar_button_link`"
                        :validationErros="errors"
                    />
                </div>


                <div class="w-full mt-2 relative">
                    <label
                        for=""
                        class="block text-base lg:text-lg"
                        >Apply now's button title</label
                    >
                    <input
                        type="text"
                        placeholder=""
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'school_contact_red_bar_button_title', '')"
                        :value="
                            form['school_contact_red_bar_button_title']
                                ? form['school_contact_red_bar_button_title']
                                : ''
                        "
                    />
                    <error
                        :fieldName="`school_contact_red_bar_button_title`"
                        :validationErros="errors"
                    />
                </div>

                <div class="w-full mt-2 relative">
                    <label
                        for=""
                        class="block text-base lg:text-lg"
                        >Apply now's button link</label
                    >
                    <input
                        type="text"
                        placeholder=""
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'school_contact_red_bar_button_link', '')"
                        :value="
                            form['school_contact_red_bar_button_link']
                                ? form['school_contact_red_bar_button_link']
                                : ''
                        "
                    />
                    <error
                        :fieldName="`school_contact_red_bar_button_link`"
                        :validationErros="errors"
                    />
                </div>
                <div class="w-full mt-2 relative">
                    <label
                        for=""
                        class="block text-base lg:text-lg"
                        >Page top main text</label
                    >
                    <input
                        type="text"
                        placeholder=""
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'top_page_text', '')"
                        :value="
                            form['top_page_text']
                                ? form['top_page_text']
                                : ''
                        "
                    />
                    <error
                        :fieldName="`top_page_text`"
                        :validationErros="errors"
                    />
                </div>
                <!-- <div class="w-full mt-2 relative">
                    <label
                        for=""
                        class="block text-base lg:text-lg"
                        >Facebook</label
                    >
                    <input
                        type="text"
                        placeholder=""
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'contact_settings_facebook', '')"
                        :value="
                            form['contact_settings_facebook']
                                ? form['contact_settings_facebook']
                                : ''
                        "
                    />
                    <error
                        :fieldName="`contact_settings_facebook`"
                        :validationErros="errors"
                    />
                </div>
                <div class="w-full mt-2 relative">
                    <label
                        for=""
                        class="block text-base lg:text-lg"
                        >Instagram</label
                    >
                    <input
                        type="text"
                        placeholder=""
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'contact_settings_instagram', '')"
                        :value="
                            form['contact_settings_instagram']
                                ? form['contact_settings_instagram']
                                : ''
                        "
                    />
                    <error
                        :fieldName="`contact_settings_instagram`"
                        :validationErros="errors"
                    />
                </div>
                <div class="w-full mt-2 relative">
                    <label
                        for=""
                        class="block text-base lg:text-lg"
                        >Linkedin</label
                    >
                    <input
                        type="text"
                        placeholder=""
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'contact_settings_linkedin', '')"
                        :value="
                            form['contact_settings_linkedin']
                                ? form['contact_settings_linkedin']
                                : ''
                        "
                    />
                    <error
                        :fieldName="`contact_settings_linkedin`"
                        :validationErros="errors"
                    />
                </div> -->
              
                <div class="w-full mt-4">
                  <label class="block text-base lg:text-lg">Image</label>
                  <input
                      type="file"
                      class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                      @change="handleImage($event)"
                  />
                  <error
                      :fieldName="'top_photo'"
                      :validationErros="errors"
                  />
                  <!-- <img v-if="form['image']" :src="form?.image ? form.image : ''" style="height: 100px; width: 100px" /> -->
                  <div v-if="form['top_photo']" class="mt-2 relative">
                      <img :src="form.top_photo" style="height: 100px; width: 100px" />
                      <button 
                          @click="removeImage" 
                          class="absolute top-0 right-0 bg-red-500 text-white rounded-full px-2 py-1 text-xs">
                          X
                      </button>
                  </div>
              </div>

                


                <div class="flex justify-center items-center gap-3 mt-4">
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
import { mapState } from "vuex";
import Error from "./Error.vue";
export default {
    components: { Error, editor:Editor },
    props: ["logged_in_customer", "school_id"],
    computed: {
        ...mapState({
            form: (state) => state.school_contact_settings.form,
            school_contact_settings: (state) =>
                state.school_contact_settings.school_contact_settings,
            errors: (state) => state.school_contact_settings.errors,
            isLoading: (state) => state.school_contact_settings.isLoading,
            languages: (state) => state.languages.languages,
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
            this.$store.commit("school_contact_settings/setIsFeatured", {
                checked: val,
                key,
            });
        },
        closeModal() {
            this.$store.commit("school_contact_settings/setShowModal", 0);
        },
        handleInput(e, key, language) {
            this.$store.commit("school_contact_settings/setForData", {
                key,
                language: language ? language : "",
                value: e.target.value,
            });
        },
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.$store.commit("school_contact_settings/setForData", {
                    key: "top_photo",
                    value: res?.data,
                });
                if (this.validationErros.has("top_photo")) {
                    this.validationErros.clear("top_photo");
                }
            });
        },
        removeImage() {
        this.$store.commit("school_contact_settings/setForData", {
            key: "top_photo",
            value: null, // Removes the image
        });
    },
        handleSelectionChange(language, key) {
            this.$store.commit(`school_contact_settings/udpateFormData`, {
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
                .dispatch("school_contact_settings/addUpdateForm")
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$store.commit(
                            "school_contact_settings/setLimit",
                            10
                        );
                        this.$store.commit(
                            "school_contact_settings/setSortBy",
                            "id"
                        );
                        this.$store.commit(
                            "school_contact_settings/setSortType",
                            "desc"
                        );
                        this.$store.dispatch(
                            "school_contact_settings/fetchSchoolContactSettings"
                        );
                    }
                });
        },
        fetchSchoolContactSettings() {
            this.$store
                .dispatch(
                    "school_contact_settings/fetchSchoolContactSettings",
                    {
                        url: `${process.env.MIX_WEB_API_URL}school-contact-settings?is_admin=1&withSchoolContactSettingDetail=1&school_id=${this.$route?.params?.id}`,
                    }
                )
                .then((res) => {
                    this.$store.commit("school_contact_settings/setForData", {
                        key: "customer_id",
                        value: res.data.data?.customer_id,
                    });
                    this.$store.commit("school_contact_settings/setForData", {
                        key: "school_contact_apply_button_title",
                        value: res.data.data?.school_contact_apply_button_title,
                    });
                    this.$store.commit("school_contact_settings/setForData", {
                        key: "school_contact_apply_button_link",
                        value: res.data.data?.school_contact_apply_button_link,
                    });
                    this.$store.commit("school_contact_settings/setForData", {
                        key: "school_contact_red_bar_button_link",
                        value: res.data.data?.school_contact_red_bar_button_link,
                    });
                    this.$store.commit("school_contact_settings/setForData", {
                        key: "school_contact_red_bar_button_title",
                        value: res.data.data?.school_contact_red_bar_button_title,
                    });
                    this.$store.commit("school_contact_settings/setForData", {
                        key: "school_contact_blue_bar_button_link",
                        value: res.data.data?.school_contact_blue_bar_button_link,
                    });
                    this.$store.commit("school_contact_settings/setForData", {
                        key: "school_contact_blue_bar_button_title",
                        value: res.data.data?.school_contact_blue_bar_button_title,
                    });
                    this.$store.commit("school_contact_settings/setForData", {
                        key: "top_page_text",
                        value: res.data.data?.top_page_text,
                    });
                    this.$store.commit("school_contact_settings/setForData", {
                        key: "top_photo",
                        value: res.data.data?.top_photo,
                    });
                    this.$store.commit("school_contact_settings/setForData", {
                        key: "contact_settings_linkedin",
                        value: res.data.data?.contact_settings_linkedin,
                    });
                    this.$store.commit("school_contact_settings/setForData", {
                        key: "contact_settings_instagram",
                        value: res.data.data?.contact_settings_instagram,
                    });
                    this.$store.commit("school_contact_settings/setForData", {
                        key: "contact_settings_facebook",
                        value: res.data.data?.contact_settings_facebook,
                    });
                    let data =
                        res.data.data &&
                        res.data.data.school_contact_setting_detail
                            ? res.data.data.school_contact_setting_detail
                            : [];

                    var moreFields1 = ["main_paragraph","brief_description"];
                    for (var i = 0; i < moreFields1?.length; i++) {
                        let obj = {};
                        data.map((res) => {
                            obj[moreFields1[i] + "_" + res.language_code] =
                                res[moreFields1[i]];
                        });
                        console.clear();
                        this.$store.commit(
                            "school_contact_settings/setForData",
                            {
                                key: moreFields1[i],
                                value: obj,
                            }
                        );
                    }
                    this.isDataLoaded = 1;
                });
        },
    },

    created() {
        console.log('school_id check',this.value);
        this.$store.commit("school_contact_settings/setForData", {
            key: "school_id",
            value: this.$route?.params?.id,
        });
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                if (res.data.status == "Success") {
                    this.$store.commit(
                        "school_contact_settings/setLanguages",
                        res.data.data
                    );
                    setTimeout(() => {
                        let data = res.data.data;
                        var moreFields = ["main_paragraph","brief_description"];
                        for (var i = 0; i < moreFields?.length; i++) {
                            let obj = {};
                            data.map((res) => {
                                obj[moreFields[i] + "_" + res.abbreviation] =
                                    "";
                            });
                            this.$store.commit(
                                "school_contact_settings/setForData",
                                {
                                    key: moreFields[i],
                                    value: obj,
                                }
                            );
                        }

                        if(this.$route.params.id){
                            this.fetchSchoolContactSettings();
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
