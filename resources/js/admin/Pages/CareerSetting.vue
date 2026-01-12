<template>
    <header class="mb-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="can-edu-h1">
                    How these careers come about setting
                </h1>
            </div>
        </div>
    </header>
    <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
        <div
            class="my-5"
            v-for="language in languages"
            :key="language.id"
            :class="
                (selectedLanguage == null && language.is_default) ||
                language.id == selectedLanguage
                    ? 'block'
                    : 'hidden'
            "
        >
            <!-- <div class="grid my-5 md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <input
                        type="text"
                        :name="`title_${selectedLanguage}`"
                        :id="`title_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'title',
                                'updateCareerSetting'
                            )
                        "
                        :value="
                            form['title'] &&
                            form['title'][`title_${selectedLanguage}`]
                                ? form['title'][`title_${selectedLanguage}`]
                                : ''
                        "
                    />
                    <label
                        :for="`title_${selectedLanguage}`"
                        class="peer-focus:font-medium absolute text-base text-gray-700 font-medium duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                        >title</label
                    >
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `title.title_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `title.title_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
            </div> -->
            <div class="grid my-5 md:grid-cols-2 gap-4 md:gap-6">
                <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                    <label
                        :for="`page_title_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >page title</label
                    >
                    <input
                        type="text"
                        :name="`page_title_${selectedLanguage}`"
                        :id="`page_title_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'page_title',
                                'updateCareerSetting'
                            )
                        "
                        :value="
                            form['page_title'] &&
                            form['page_title'][`page_title_${selectedLanguage}`]
                                ? form['page_title'][
                                      `page_title_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `page_title.page_title_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `page_title.page_title_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                    <label
                        :for="`article_title_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >article title</label
                    >
                    <input
                        type="text"
                        :name="`article_title_${selectedLanguage}`"
                        :id="`article_title_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'article_title',
                                'updateCareerSetting'
                            )
                        "
                        :value="
                            form['article_title'] &&
                            form['article_title'][
                                `article_title_${selectedLanguage}`
                            ]
                                ? form['article_title'][
                                      `article_title_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `article_title.article_title_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `article_title.article_title_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                    <label
                        :for="`tab_1_title_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >tab 1 title</label
                    >
                    <input
                        type="text"
                        :name="`tab_1_title_${selectedLanguage}`"
                        :id="`tab_1_title_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'tab_1_title',
                                'updateCareerSetting'
                            )
                        "
                        :value="
                            form['tab_1_title'] &&
                            form['tab_1_title'][
                                `tab_1_title_${selectedLanguage}`
                            ]
                                ? form['tab_1_title'][
                                      `tab_1_title_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `tab_1_title.tab_1_title_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `tab_1_title.tab_1_title_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                    <label
                        :for="`tab_2_title_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >tab 2 title</label
                    >
                    <input
                        type="text"
                        :name="`tab_2_title_${selectedLanguage}`"
                        :id="`tab_2_title_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'tab_2_title',
                                'updateCareerSetting'
                            )
                        "
                        :value="
                            form['tab_2_title'] &&
                            form['tab_2_title'][
                                `tab_2_title_${selectedLanguage}`
                            ]
                                ? form['tab_2_title'][
                                      `tab_2_title_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `tab_2_title.tab_2_title_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `tab_2_title.tab_2_title_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                    <label
                        :for="`tab_3_title_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >tab 3 title</label
                    >
                    <input
                        type="text"
                        :name="`tab_3_title_${selectedLanguage}`"
                        :id="`tab_3_title_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'tab_3_title',
                                'updateCareerSetting'
                            )
                        "
                        :value="
                            form['tab_3_title'] &&
                            form['tab_3_title'][
                                `tab_3_title_${selectedLanguage}`
                            ]
                                ? form['tab_3_title'][
                                      `tab_3_title_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `tab_3_title.tab_3_title_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `tab_3_title.tab_3_title_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group col-span-2 md:col-span-1">
                    <label
                        :for="`search_input_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >search input placeholder</label
                    >
                    <input
                        type="text"
                        :name="`search_input_placeholder_${selectedLanguage}`"
                        :id="`search_input_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'search_input_placeholder',
                                'updateCareerSetting'
                            )
                        "
                        :value="
                            form['search_input_placeholder'] &&
                            form['search_input_placeholder'][
                                `search_input_placeholder_${selectedLanguage}`
                            ]
                                ? form['search_input_placeholder'][
                                      `search_input_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `search_input_placeholder.search_input_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `search_input_placeholder.search_input_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group col-span-2" v-if="isDataLoaded">
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`description_${language.id}`"
                    ></div> -->
                    <label
                        :for="`description_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Description</label
                    >
                    <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'description'
                                )
                            "
                            :ref="`description1_${language.id}`"
                            :id="`description1_${language.id}`"
                            :initial-value="form[`description`][`description_${language?.id}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `description.description_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `description.description_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
            </div>
            
        </div>
        <ListErrors :validationErrors="validationErros" />
        <button
            type="submit"
            class="can-edu-btn-fill"
        >
            Submit
        </button>
    </form>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
    props: ["selectedLanguage"],
    computed: {
        ...mapState({
            form: (state) => state.career_setting.form,
            validationErros: (state) => state.career_setting.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    components:{
        ListErrors,
        editor: Editor,
    },
    data() {
        return {
            activeTab: null,
            collapseStates: [true, false, false, false, false, false, false],
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
        handleInput(value, language, key, mutationName) {
            this.$store.commit(`career_setting/${mutationName}`, {
                key: key,
                value: value,
                id: this.selectedLanguage,
            });
            const errorKey = `${key}.${key}_${this.selectedLanguage}`;
            this.validationErros.clear(errorKey);
        },
        handleSelectionChange(language, key) {
            let value = tinymce.get(`${key}1_${language.id}`).getContent();
            this.$store.commit(`career_setting/updateCareerSetting`, {
                value: value,
                id: language.id,
                key:key,
            });
            if (value.trim() !== '') {
        this.validationErros.clear(`description.description_${language.id}`);
        this.validationErros.clear(`description.description_${this.selectedLanguage}`);
    }
        },
        addUpdateForm() {
            this.$store.dispatch("career_setting/addUpdateForm").then((res) => {
                if (res.data.status == "Success") {
                    this.$emit("addUpdateFormParent");
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
            const languageSpecificFieldName = `${fieldName}_${this.selectedLanguage}`;
            console.log("Stripped error field name:", fieldName);
            console.log("Language-specific field name:", languageSpecificFieldName);

            let inputElement = document.querySelector(
                `[name="${languageSpecificFieldName}"], [v-model="${fieldName}"], [data-v-model="${fieldName}"], [data-value="${fieldName}"]`
            );

            if (!inputElement) {
                console.log(`No standard input field found for ${languageSpecificFieldName}, checking for rich text editor...`);

                const editorId = fieldNameParts[1] || fieldName;
                const tinymceEditor = window.tinymce?.get(editorId);

                if (tinymceEditor) {
                    console.log(`Focusing on TinyMCE editor: ${editorId}`);
                    tinymceEditor.getBody().scrollIntoView({ behavior: "smooth", block: "center" });

                    setTimeout(() => {
                        tinymceEditor.focus();
                    }, 300);

                    return;
                } else {
                    console.log(`TinyMCE editor instance not found for ${editorId}`);
                }
            }

            if (inputElement) {
                console.log("Found input element:", inputElement);
                inputElement.scrollIntoView({ behavior: "smooth", block: "center" });

                setTimeout(() => {
                    inputElement.focus();
                }, 300);

            } else {
                console.log(`No input field found for ${languageSpecificFieldName}`);
            }
        },
        changeLanguageTab(language) {
            this.activeTab = this.selectedLanguage;
        },
        fetchCareerSetting() {
            this.$store
                .dispatch("career_setting/fetchCareerSetting", {
                    url: `${process.env.MIX_ADMIN_API_URL}career-settings`,
                })
                .then((res) => {
                    let data =
                        res.data.data && res.data.data.career_setting_detail
                            ? res.data.data.career_setting_detail
                            : [];
                    var obj = {};
                    data.map((res) => {
                        obj["title_" + res.language_id] = res.title;
                    });
                    this.$store.commit("career_setting/setCareerSetting", {
                        key: "title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["page_title_" + res.language_id] = res.page_title;
                    });
                    this.$store.commit("career_setting/setCareerSetting", {
                        key: "page_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["article_title_" + res.language_id] = res.article_title;
                    });
                    this.$store.commit("career_setting/setCareerSetting", {
                        key: "article_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["tab_1_title_" + res.language_id] = res.tab_1_title;
                    });
                    this.$store.commit("career_setting/setCareerSetting", {
                        key: "tab_1_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["tab_2_title_" + res.language_id] = res.tab_2_title;
                    });
                    this.$store.commit("career_setting/setCareerSetting", {
                        key: "tab_2_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["tab_3_title_" + res.language_id] = res.tab_3_title;
                    });
                    this.$store.commit("career_setting/setCareerSetting", {
                        key: "tab_3_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["search_input_placeholder_" + res.language_id] =
                            res.search_input_placeholder;
                    });
                    this.$store.commit("career_setting/setCareerSetting", {
                        key: "search_input_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["description_" + res.language_id] = res.description;
                    });
                    this.$store.commit("career_setting/setCareerSetting", {
                        key: "description",
                        value: obj,
                    });
                    this.isDataLoaded = 1;
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(`title.title_${this.selectedLanguage}`) ||
                validationErros.has(
                    `description.description_${this.selectedLanguage}`
                )
            );
        },
    },
    created() {
        this.$store.commit("career_setting/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["title_" + res.id] = "How these careers come about";
                });
                this.$store.commit("career_setting/setCareerSetting", {
                    key: "title",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["page_title_" + res.id] = "";
                });
                this.$store.commit("career_setting/setCareerSetting", {
                    key: "page_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["article_title_" + res.id] = "";
                });
                this.$store.commit("career_setting/setCareerSetting", {
                    key: "article_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["tab_1_title_" + res.id] = "";
                });
                this.$store.commit("career_setting/setCareerSetting", {
                    key: "tab_1_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["tab_2_title_" + res.id] = "";
                });
                this.$store.commit("career_setting/setCareerSetting", {
                    key: "tab_2_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["tab_3_title_" + res.id] = "";
                });
                this.$store.commit("career_setting/setCareerSetting", {
                    key: "tab_3_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["search_input_placeholder_" + res.id] = "";
                });
                this.$store.commit("career_setting/setCareerSetting", {
                    key: "search_input_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["description_" + res.id] = "";
                });
                this.$store.commit("career_setting/setCareerSetting", {
                    key: "description",
                    value: obj,
                });
                if(this.$route.params.id){
                    this.fetchCareerSetting();
                }
                else{
                    this.isDataLoaded = 1;
                }
            });
    },
};
</script>
