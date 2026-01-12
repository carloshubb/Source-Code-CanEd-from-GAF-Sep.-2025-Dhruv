<template>
    <header class="mb-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="can-edu-h1">Program setting</h1>
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
                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`page_title_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Page Title</label
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
                                'updateProgramSetting'
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
                </div> -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`button_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Button Text</label
                    >
                    <input
                        type="text"
                        :name="`button_text_${selectedLanguage}`"
                        :id="`button_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'button_text',
                                'updateProgramSetting'
                            )
                        "
                        :value="
                            form['button_text'] &&
                            form['button_text'][
                                `button_text_${selectedLanguage}`
                            ]
                                ? form['button_text'][
                                      `button_text_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `button_text.button_text_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `button_text.button_text_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- <div class="relative z-0 w-full group col-span-2" v-if="isDataLoaded">
                 
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
                            :initial-value="form?.[`description`]?.[`description_${language?.id}`]
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
                </div> -->
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
            form: (state) => state.program_setting.form,
            validationErros: (state) => state.program_setting.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    components:{
        ListErrors,
        editor: Editor
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
            this.$store.commit(`program_setting/${mutationName}`, {
                key: key,
                value: value,
                id: this.selectedLanguage,
            });
            const errorKey = `${key}.${key}_${this.selectedLanguage}`;
            this.validationErros.clear(errorKey);
        },
        handleSelectionChange(language, key) {
            let value = tinymce.get(`${key}1_${language.id}`).getContent();
            this.$store.commit(`program_setting/updateProgramSetting`, {
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
            this.$store
                .dispatch("program_setting/addUpdateForm")
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
        fetchProgramSetting() {
            this.$store
                .dispatch("program_setting/fetchProgramSetting", {
                    url: `${process.env.MIX_ADMIN_API_URL}program-settings`,
                })
                .then((res) => {
                    let data =
                        res.data.data && res.data.data.program_setting_detail
                            ? res.data.data.program_setting_detail
                            : [];
                    let obj = {};
                    data.map((res) => {
                        obj["page_title_" + res.language_id] = res.page_title;
                    });
                    this.$store.commit("program_setting/setProgramSetting", {
                        key: "page_title",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["button_text_" + res.language_id] = res.button_text;
                    });
                    this.$store.commit("program_setting/setProgramSetting", {
                        key: "button_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["description_" + res.language_id] = res.description;
                    });
                    this.$store.commit("program_setting/setProgramSetting", {
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
        this.$store.commit("program_setting/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["page_title_" + res.language_id] = "";
                });
                this.$store.commit("program_setting/setProgramSetting", {
                    key: "page_title",
                    value: "",
                });
                obj = {};
                data.map((res) => {
                    obj["button_text_" + res.language_id] = "";
                });
                this.$store.commit("program_setting/setProgramSetting", {
                    key: "button_text",
                    value: "",
                });

                obj = {};
                data.map((res) => {
                    obj["description_" + res.language_id] = "";
                });
                this.$store.commit("program_setting/setProgramSetting", {
                    key: "description",
                    value: "",
                });
                if(this.$route.params.id){
                    this.fetchProgramSetting();
                }
                else{
                    this.isDataLoaded = 1;
                }
            });
    },
};
</script>
