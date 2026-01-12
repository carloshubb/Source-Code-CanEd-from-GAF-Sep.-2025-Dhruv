<template>
    <header class="mb-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-primary">
                    Business Directory setting
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
                <!-- first name -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`company_name_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Company name label</label
                    >
                    <input
                        type="text"
                        :name="`company_name_label_${selectedLanguage}`"
                        :id="`company_name_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'company_name_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['company_name_label'] &&
                            form['company_name_label'][
                                `company_name_label_${selectedLanguage}`
                            ]
                                ? form['company_name_label'][
                                      `company_name_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `company_name_label.company_name_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `company_name_label.company_name_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`company_name_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Company name placeholder</label
                    >
                    <input
                        type="text"
                        :name="`company_name_placeholder_${selectedLanguage}`"
                        :id="`company_name_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'company_name_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['company_name_placeholder'] &&
                            form['company_name_placeholder'][
                                `company_name_placeholder_${selectedLanguage}`
                            ]
                                ? form['company_name_placeholder'][
                                      `company_name_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `company_name_placeholder.company_name_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `company_name_placeholder.company_name_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`company_name_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Company name error</label
                    >
                    <input
                        type="text"
                        :name="`company_name_error_${selectedLanguage}`"
                        :id="`company_name_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'company_name_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['company_name_error'] &&
                            form['company_name_error'][
                                `company_name_error_${selectedLanguage}`
                            ]
                                ? form['company_name_error'][
                                      `company_name_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `company_name_error.company_name_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `company_name_error.company_name_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- last name -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`city_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >City label</label
                    >
                    <input
                        type="text"
                        :name="`city_label_${selectedLanguage}`"
                        :id="`city_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'city_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['city_label'] &&
                            form['city_label'][
                                `city_label_${selectedLanguage}`
                            ]
                                ? form['city_label'][
                                      `city_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `city_label.city_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `city_label.city_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`city_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >City placeholder</label
                    >
                    <input
                        type="text"
                        :name="`city_placeholder_${selectedLanguage}`"
                        :id="`city_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'city_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['city_placeholder'] &&
                            form['city_placeholder'][
                                `city_placeholder_${selectedLanguage}`
                            ]
                                ? form['city_placeholder'][
                                      `city_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `city_placeholder.city_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `city_placeholder.city_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`city_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >City error</label
                    >
                    <input
                        type="text"
                        :name="`city_error_${selectedLanguage}`"
                        :id="`city_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'city_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['city_error'] &&
                            form['city_error'][
                                `city_error_${selectedLanguage}`
                            ]
                                ? form['city_error'][
                                      `city_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `city_error.city_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `city_error.city_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- email -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`province_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Province label</label
                    >
                    <input
                        type="text"
                        :name="`province_label_${selectedLanguage}`"
                        :id="`province_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'province_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['province_label'] &&
                            form['province_label'][
                                `province_label_${selectedLanguage}`
                            ]
                                ? form['province_label'][
                                      `province_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `province_label.province_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `province_label.province_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`province_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Province placeholder</label
                    >
                    <input
                        type="text"
                        :name="`province_placeholder_${selectedLanguage}`"
                        :id="`province_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'province_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['province_placeholder'] &&
                            form['province_placeholder'][
                                `province_placeholder_${selectedLanguage}`
                            ]
                                ? form['province_placeholder'][
                                      `province_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `province_placeholder.province_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `province_placeholder.province_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`province_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Province error</label
                    >
                    <input
                        type="text"
                        :name="`province_error_${selectedLanguage}`"
                        :id="`province_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'province_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['province_error'] &&
                            form['province_error'][
                                `province_error_${selectedLanguage}`
                            ]
                                ? form['province_error'][
                                      `province_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `province_error.province_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `province_error.province_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>


                <!-- password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`industry_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Industry label</label
                    >
                    <input
                        type="text"
                        :name="`industry_label_${selectedLanguage}`"
                        :id="`industry_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'industry_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['industry_label'] &&
                            form['industry_label'][
                                `industry_label_${selectedLanguage}`
                            ]
                                ? form['industry_label'][
                                      `industry_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `industry_label.industry_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `industry_label.industry_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`industry_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Industry placeholder</label
                    >
                    <input
                        type="text"
                        :name="`industry_placeholder_${selectedLanguage}`"
                        :id="`industry_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'industry_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['industry_placeholder'] &&
                            form['industry_placeholder'][
                                `industry_placeholder_${selectedLanguage}`
                            ]
                                ? form['industry_placeholder'][
                                      `industry_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `industry_placeholder.industry_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `industry_placeholder.industry_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`industry_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Industry error</label
                    >
                    <input
                        type="text"
                        :name="`industry_error_${selectedLanguage}`"
                        :id="`industry_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'industry_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['industry_error'] &&
                            form['industry_error'][
                                `industry_error_${selectedLanguage}`
                            ]
                                ? form['industry_error'][
                                      `industry_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `industry_error.industry_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `industry_error.industry_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                
                <!-- button_text -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`button_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Button text</label
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
                                'updatePageSetting'
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
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
    components:{
    ListErrors
},
    props: ["selectedLanguage"],
    computed: {
        ...mapState({
            form: (state) => state.bus_directory_setting.form,
            validationErros: (state) => state.bus_directory_setting.validationErros,
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
            this.$store.commit(`bus_directory_setting/${mutationName}`, {
                key: key,
                value: value,
                id: this.selectedLanguage,
            });
            const errorKey = `${key}.${key}_${this.selectedLanguage}`;
            this.validationErros.clear(errorKey);
        },
        addUpdateForm() {
            this.$store
                .dispatch("bus_directory_setting/addUpdateForm")
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
        fetchBusDirectorySetting() {
            this.$store
                .dispatch("bus_directory_setting/fetchBusDirectorySetting", {
                    url: `${process.env.MIX_ADMIN_API_URL}bus-directory-setting`,
                })
                .then((res) => {
                    let data =
                        res.data.data && res.data.data.bus_directory_setting_detail
                            ? res.data.data.bus_directory_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["company_name_label_" + res.language_id] =
                            res.company_name_label;
                    });
                    this.$store.commit("bus_directory_setting/setPageSetting", {
                        key: "company_name_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["company_name_placeholder_" + res.language_id] =
                            res.company_name_placeholder;
                    });
                    this.$store.commit("bus_directory_setting/setPageSetting", {
                        key: "company_name_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["company_name_error_" + res.language_id] =
                            res.company_name_error;
                    });
                    this.$store.commit("bus_directory_setting/setPageSetting", {
                        key: "company_name_error",
                        value: obj,
                    });

                    //last name
                    obj = {};
                    data.map((res) => {
                        obj["city_label_" + res.language_id] =
                            res.city_label;
                    });
                    this.$store.commit("bus_directory_setting/setPageSetting", {
                        key: "city_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["city_placeholder_" + res.language_id] =
                            res.city_placeholder;
                    });
                    this.$store.commit("bus_directory_setting/setPageSetting", {
                        key: "city_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["city_error_" + res.language_id] =
                            res.city_error;
                    });
                    this.$store.commit("bus_directory_setting/setPageSetting", {
                        key: "city_error",
                        value: obj,
                    });
                    //email
                    obj = {};
                    data.map((res) => {
                        obj["province_label_" + res.language_id] =
                            res.province_label;
                    });
                    this.$store.commit("bus_directory_setting/setPageSetting", {
                        key: "province_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["province_placeholder_" + res.language_id] =
                            res.province_placeholder;
                    });
                    this.$store.commit("bus_directory_setting/setPageSetting", {
                        key: "province_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["province_error_" + res.language_id] =
                            res.province_error;
                    });
                    this.$store.commit("bus_directory_setting/setPageSetting", {
                        key: "province_error",
                        value: obj,
                    });
                    //passowrd
                    obj = {};
                    data.map((res) => {
                        obj["industry_label_" + res.language_id] =
                            res.industry_label;
                    });
                    this.$store.commit("bus_directory_setting/setPageSetting", {
                        key: "industry_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["industry_placeholder_" + res.language_id] =
                            res.industry_placeholder;
                    });
                    this.$store.commit("bus_directory_setting/setPageSetting", {
                        key: "industry_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["industry_error_" + res.language_id] =
                            res.industry_error;
                    });
                    this.$store.commit("bus_directory_setting/setPageSetting", {
                        key: "industry_error",
                        value: obj,
                    });

                    
                    obj = {};
                    data.map((res) => {
                        obj["button_text_" + res.language_id] =
                            res.button_text;
                    });
                    this.$store.commit("bus_directory_setting/setPageSetting", {
                        key: "button_text",
                        value: obj,
                    });
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(
                    `company_name.company_name_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `province_label.province_label_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `province_placeholder.province_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `province_error.province_error_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `industry_label.industry_label_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `industry_placeholder.industry_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `industry_error.industry_error_${this.selectedLanguage}`
                )  ||
                validationErros.has(
                    `button_text.button_text_${this.selectedLanguage}`
                )
            );
        },
    },
    created() {
        this.$store.commit("bus_directory_setting/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                //first name
                obj = {};
                data.map((res) => {
                    obj["company_name_label_" + res.id] = "";
                });
                this.$store.commit("bus_directory_setting/setPageSetting", {
                    key: "company_name_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["company_name_placeholder_" + res.id] = "";
                });
                this.$store.commit("bus_directory_setting/setPageSetting", {
                    key: "company_name_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["company_name_error_" + res.id] = "";
                });
                this.$store.commit("bus_directory_setting/setPageSetting", {
                    key: "company_name_error",
                    value: obj,
                });

                //last name
                obj = {};
                data.map((res) => {
                    obj["city_label_" + res.id] = "";
                });
                this.$store.commit("bus_directory_setting/setPageSetting", {
                    key: "city_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["city_placeholder_" + res.id] = "";
                });
                this.$store.commit("bus_directory_setting/setPageSetting", {
                    key: "city_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["city_error_" + res.id] = "";
                });
                this.$store.commit("bus_directory_setting/setPageSetting", {
                    key: "city_error",
                    value: obj,
                });
                //email
                obj = {};
                data.map((res) => {
                    obj["province_label_" + res.id] = "";
                });
                this.$store.commit("bus_directory_setting/setPageSetting", {
                    key: "province_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["province_placeholder_" + res.id] = "";
                });
                this.$store.commit("bus_directory_setting/setPageSetting", {
                    key: "province_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["province_error_" + res.id] = "";
                });
                this.$store.commit("bus_directory_setting/setPageSetting", {
                    key: "province_error",
                    value: obj,
                });
                //passowrd
                obj = {};
                data.map((res) => {
                    obj["industry_label_" + res.id] = "";
                });
                this.$store.commit("bus_directory_setting/setPageSetting", {
                    key: "industry_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["industry_placeholder_" + res.id] = "";
                });
                this.$store.commit("bus_directory_setting/setPageSetting", {
                    key: "industry_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["industry_error_" + res.id] = "";
                });
                this.$store.commit("bus_directory_setting/setPageSetting", {
                    key: "industry_error",
                    value: obj,
                });

                

                obj = {};
                data.map((res) => {
                    obj["button_text_" + res.id] = "";
                });
                this.$store.commit("bus_directory_setting/setPageSetting", {
                    key: "button_text",
                    value: obj,
                });
                this.fetchBusDirectorySetting();
            });
    },
    watch: {
        selectedLanguage: function (newVal, oldVal) {
        },
    },
};
</script>
