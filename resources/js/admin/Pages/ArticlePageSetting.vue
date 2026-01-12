<template>
    <header class="mb-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="can-edu-h1">
                    Article page setting
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
            <div class="grid my-5 md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full group">
                    <label
                        :for="`page_title_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Page title</label
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
                                'updatePageSetting'
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

                <!-- search_placeholder -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`search_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Article first name label</label
                    >
                    <input
                        type="text"
                        :name="`search_placeholder_${selectedLanguage}`"
                        :id="`search_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'search_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['search_placeholder'] &&
                            form['search_placeholder'][
                                `search_placeholder_${selectedLanguage}`
                            ]
                                ? form['search_placeholder'][
                                      `search_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `search_placeholder.search_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `search_placeholder.search_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
            </div>
        </div>
        <ListErrors :validationErrors="validationErros" />
        <button
            type="submit"
            class="can-edu-btn-fill "
        >
            Submit
        </button>
    </form>
</template>

<script>
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
    components:{
    ListErrors
},
    props: ["selectedLanguage"],
    computed: {
        ...mapState({
            form: (state) => state.article_page_setting.form,
            validationErros: (state) =>
                state.article_page_setting.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            activeTab: null,
            collapseStates: [true, false, false, false, false, false, false],
        };
    },
    methods: {
        handleInput(value, language, key, mutationName) {
            this.$store.commit(`article_page_setting/${mutationName}`, {
                key: key,
                value: value,
                id: this.selectedLanguage,
            });
            const errorKey = `${key}.${key}_${this.selectedLanguage}`;
            this.validationErros.clear(errorKey);
        },
        addUpdateForm() {
            this.$store
                .dispatch("article_page_setting/addUpdateForm")
                .then((res) => {
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
        fetchArticlePageSetting() {
            this.$store
                .dispatch("article_page_setting/fetchArticlePageSetting", {
                    url: `${process.env.MIX_ADMIN_API_URL}article-page-setting`,
                })
                .then((res) => {
                    let data =
                        res.data.data &&
                        res.data.data.article_page_setting_detail
                            ? res.data.data.article_page_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["page_title_" + res.language_id] = res.page_title;
                    });
                    this.$store.commit("article_page_setting/setPageSetting", {
                        key: "page_title",
                        value: obj,
                    });

                    //first name
                    obj = {};
                    data.map((res) => {
                        obj["search_placeholder_" + res.language_id] =
                            res.search_placeholder;
                    });
                    this.$store.commit("article_page_setting/setPageSetting", {
                        key: "search_placeholder",
                        value: obj,
                    });
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(
                    `page_title.page_title_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `page_description.page_description_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `search_placeholder.search_placeholder_${this.selectedLanguage}`
                )
            );
        },
    },
    created() {
        this.$store.commit("article_page_setting/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["page_title_" + res.id] = "";
                });
                this.$store.commit("article_page_setting/setPageSetting", {
                    key: "page_title",
                    value: obj,
                });

                //first name
                obj = {};
                data.map((res) => {
                    obj["search_placeholder_" + res.id] = "";
                });
                this.$store.commit("article_page_setting/setPageSetting", {
                    key: "search_placeholder",
                    value: obj,
                });

                this.fetchArticlePageSetting();
            });
    },
    watch: {
        selectedLanguage: function (newVal, oldVal) {
        },
    },
};
</script>
