<template>
    <header class="mb-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="can-edu-h1">
                    Proxima request setting
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
                <!-- <div class="relative z-0 w-full group">
                    <label
                        :for="`call_to_action_text_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Call to action button text</label
                    >
                    <input
                        type="text"
                        :name="`call_to_action_text_${selectedLanguage}`"
                        :id="`call_to_action_text_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'call_to_action_text',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['call_to_action_text'] &&
                            form['call_to_action_text'][`call_to_action_text_${selectedLanguage}`]
                                ? form['call_to_action_text'][
                                      `call_to_action_text_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `call_to_action_text.call_to_action_text_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `call_to_action_text.call_to_action_text_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div> -->

                <!-- first name -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`name_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Name label</label
                    >
                    <input
                        type="text"
                        :name="`name_label_${selectedLanguage}`"
                        :id="`name_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'name_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['name_label'] &&
                            form['name_label'][
                                `name_label_${selectedLanguage}`
                            ]
                                ? form['name_label'][
                                      `name_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `name_label.name_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `name_label.name_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`name_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Name placeholder</label
                    >
                    <input
                        type="text"
                        :name="`name_placeholder_${selectedLanguage}`"
                        :id="`name_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'name_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['name_placeholder'] &&
                            form['name_placeholder'][
                                `name_placeholder_${selectedLanguage}`
                            ]
                                ? form['name_placeholder'][
                                      `name_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `name_placeholder.name_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `name_placeholder.name_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`name_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Name error</label
                    >
                    <input
                        type="text"
                        :name="`name_error_${selectedLanguage}`"
                        :id="`name_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'name_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['name_error'] &&
                            form['name_error'][
                                `name_error_${selectedLanguage}`
                            ]
                                ? form['name_error'][
                                      `name_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `name_error.name_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `name_error.name_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- last name -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`phone_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Phone label</label
                    >
                    <input
                        type="text"
                        :name="`phone_label_${selectedLanguage}`"
                        :id="`phone_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'phone_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['phone_label'] &&
                            form['phone_label'][
                                `phone_label_${selectedLanguage}`
                            ]
                                ? form['phone_label'][
                                      `phone_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `phone_label.phone_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `phone_label.phone_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`phone_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Phone placeholder</label
                    >
                    <input
                        type="text"
                        :name="`phone_placeholder_${selectedLanguage}`"
                        :id="`phone_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'phone_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['phone_placeholder'] &&
                            form['phone_placeholder'][
                                `phone_placeholder_${selectedLanguage}`
                            ]
                                ? form['phone_placeholder'][
                                      `phone_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `phone_placeholder.phone_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `phone_placeholder.phone_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`phone_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Phone error</label
                    >
                    <input
                        type="text"
                        :name="`phone_error_${selectedLanguage}`"
                        :id="`phone_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'phone_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['phone_error'] &&
                            form['phone_error'][
                                `phone_error_${selectedLanguage}`
                            ]
                                ? form['phone_error'][
                                      `phone_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `phone_error.phone_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `phone_error.phone_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- email -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`email_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Email label</label
                    >
                    <input
                        type="text"
                        :name="`email_label_${selectedLanguage}`"
                        :id="`email_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['email_label'] &&
                            form['email_label'][
                                `email_label_${selectedLanguage}`
                            ]
                                ? form['email_label'][
                                      `email_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `email_label.email_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `email_label.email_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`email_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Email placeholder</label
                    >
                    <input
                        type="text"
                        :name="`email_placeholder_${selectedLanguage}`"
                        :id="`email_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['email_placeholder'] &&
                            form['email_placeholder'][
                                `email_placeholder_${selectedLanguage}`
                            ]
                                ? form['email_placeholder'][
                                      `email_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `email_placeholder.email_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `email_placeholder.email_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`email_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Email error</label
                    >
                    <input
                        type="text"
                        :name="`email_error_${selectedLanguage}`"
                        :id="`email_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'email_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['email_error'] &&
                            form['email_error'][
                                `email_error_${selectedLanguage}`
                            ]
                                ? form['email_error'][
                                      `email_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `email_error.email_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `email_error.email_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>
                <!-- password -->
                <div class="relative z-0 w-full group">
                    <label
                        :for="`inquiry_label_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Inquiry label</label
                    >
                    <input
                        type="text"
                        :name="`inquiry_label_${selectedLanguage}`"
                        :id="`inquiry_label_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'inquiry_label',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['inquiry_label'] &&
                            form['inquiry_label'][
                                `inquiry_label_${selectedLanguage}`
                            ]
                                ? form['inquiry_label'][
                                      `inquiry_label_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `inquiry_label.inquiry_label_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `inquiry_label.inquiry_label_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`inquiry_placeholder_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Inquiry placeholder</label
                    >
                    <input
                        type="text"
                        :name="`inquiry_placeholder_${selectedLanguage}`"
                        :id="`inquiry_placeholder_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'inquiry_placeholder',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['inquiry_placeholder'] &&
                            form['inquiry_placeholder'][
                                `inquiry_placeholder_${selectedLanguage}`
                            ]
                                ? form['inquiry_placeholder'][
                                      `inquiry_placeholder_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `inquiry_placeholder.inquiry_placeholder_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `inquiry_placeholder.inquiry_placeholder_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <div class="relative z-0 w-full group">
                    <label
                        :for="`inquiry_error_${selectedLanguage}`"
                        class="block text-base lg:text-lg"
                        >Inquiry Error</label
                    >
                    <input
                        type="text"
                        :name="`inquiry_error_${selectedLanguage}`"
                        :id="`inquiry_error_${selectedLanguage}`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'inquiry_error',
                                'updatePageSetting'
                            )
                        "
                        :value="
                            form['inquiry_error'] &&
                            form['inquiry_error'][
                                `inquiry_error_${selectedLanguage}`
                            ]
                                ? form['inquiry_error'][
                                      `inquiry_error_${selectedLanguage}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `inquiry_error.inquiry_error_${selectedLanguage}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `inquiry_error.inquiry_error_${selectedLanguage}`
                            )
                        "
                    ></p>
                </div>

                <!-- confirm password -->
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
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary bg-white"
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
            form: (state) => state.proxima_request_setting.form,
            validationErros: (state) => state.proxima_request_setting.validationErros,
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
            this.$store.commit(`proxima_request_setting/${mutationName}`, {
                key: key,
                value: value,
                id: this.selectedLanguage,
            });
            const errorKey = `${key}.${key}_${this.selectedLanguage}`;
            this.validationErros.clear(errorKey);
        },
        addUpdateForm() {
            this.$store
                .dispatch("proxima_request_setting/addUpdateForm")
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
        fetchRegPageSetting() {
            this.$store
                .dispatch("proxima_request_setting/fetchRegPageSetting", {
                    url: `${process.env.MIX_ADMIN_API_URL}proxima-request-setting`,
                })
                .then((res) => {
                    let data =
                        res.data.data && res.data.data.proxima_request_setting_detail
                            ? res.data.data.proxima_request_setting_detail
                            : [];

                    let obj = {};
                    data.map((res) => {
                        obj["call_to_action_text_" + res.language_id] = res.call_to_action_text;
                    });
                    this.$store.commit("proxima_request_setting/setPageSetting", {
                        key: "call_to_action_text",
                        value: obj,
                    });

                    //first name
                    obj = {};
                    data.map((res) => {
                        obj["name_label_" + res.language_id] =
                            res.name_label;
                    });
                    this.$store.commit("proxima_request_setting/setPageSetting", {
                        key: "name_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["name_placeholder_" + res.language_id] =
                            res.name_placeholder;
                    });
                    this.$store.commit("proxima_request_setting/setPageSetting", {
                        key: "name_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["name_error_" + res.language_id] =
                            res.name_error;
                    });
                    this.$store.commit("proxima_request_setting/setPageSetting", {
                        key: "name_error",
                        value: obj,
                    });

                    //last name
                    obj = {};
                    data.map((res) => {
                        obj["phone_label_" + res.language_id] =
                            res.phone_label;
                    });
                    this.$store.commit("proxima_request_setting/setPageSetting", {
                        key: "phone_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["phone_placeholder_" + res.language_id] =
                            res.phone_placeholder;
                    });
                    this.$store.commit("proxima_request_setting/setPageSetting", {
                        key: "phone_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["phone_error_" + res.language_id] =
                            res.phone_error;
                    });
                    this.$store.commit("proxima_request_setting/setPageSetting", {
                        key: "phone_error",
                        value: obj,
                    });
                    //email
                    obj = {};
                    data.map((res) => {
                        obj["email_label_" + res.language_id] =
                            res.email_label;
                    });
                    this.$store.commit("proxima_request_setting/setPageSetting", {
                        key: "email_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["email_placeholder_" + res.language_id] =
                            res.email_placeholder;
                    });
                    this.$store.commit("proxima_request_setting/setPageSetting", {
                        key: "email_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["email_error_" + res.language_id] =
                            res.email_error;
                    });
                    this.$store.commit("proxima_request_setting/setPageSetting", {
                        key: "email_error",
                        value: obj,
                    });
                    //passowrd
                    obj = {};
                    data.map((res) => {
                        obj["inquiry_label_" + res.language_id] =
                            res.inquiry_label;
                    });
                    this.$store.commit("proxima_request_setting/setPageSetting", {
                        key: "inquiry_label",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["inquiry_placeholder_" + res.language_id] =
                            res.inquiry_placeholder;
                    });
                    this.$store.commit("proxima_request_setting/setPageSetting", {
                        key: "inquiry_placeholder",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["inquiry_error_" + res.language_id] =
                            res.inquiry_error;
                    });
                    this.$store.commit("proxima_request_setting/setPageSetting", {
                        key: "inquiry_error",
                        value: obj,
                    });

                    //confirm passowrd
                    obj = {};
                    data.map((res) => {
                        obj["button_text_" + res.language_id] =
                            res.button_text;
                    });
                    this.$store.commit("proxima_request_setting/setPageSetting", {
                        key: "button_text",
                        value: obj,
                    });

                    
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(
                    `call_to_action_text.call_to_action_text_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `page_description.page_description_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `email_label.email_label_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `email_placeholder.email_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `email_error.email_error_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `inquiry_label.inquiry_label_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `inquiry_placeholder.inquiry_placeholder_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `inquiry_error.inquiry_error_${this.selectedLanguage}`
                )
            );
        },
    },
    created() {
        this.$store.commit("proxima_request_setting/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["call_to_action_text_" + res.id] = "";
                });
                this.$store.commit("proxima_request_setting/setPageSetting", {
                    key: "call_to_action_text",
                    value: obj,
                });

                //first name
                obj = {};
                data.map((res) => {
                    obj["name_label_" + res.id] = "";
                });
                this.$store.commit("proxima_request_setting/setPageSetting", {
                    key: "name_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["name_placeholder_" + res.id] = "";
                });
                this.$store.commit("proxima_request_setting/setPageSetting", {
                    key: "name_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["name_error_" + res.id] = "";
                });
                this.$store.commit("proxima_request_setting/setPageSetting", {
                    key: "name_error",
                    value: obj,
                });

                //last name
                obj = {};
                data.map((res) => {
                    obj["phone_label_" + res.id] = "";
                });
                this.$store.commit("proxima_request_setting/setPageSetting", {
                    key: "phone_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["phone_placeholder_" + res.id] = "";
                });
                this.$store.commit("proxima_request_setting/setPageSetting", {
                    key: "phone_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["phone_error_" + res.id] = "";
                });
                this.$store.commit("proxima_request_setting/setPageSetting", {
                    key: "phone_error",
                    value: obj,
                });
                //email
                obj = {};
                data.map((res) => {
                    obj["email_label_" + res.id] = "";
                });
                this.$store.commit("proxima_request_setting/setPageSetting", {
                    key: "email_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["email_placeholder_" + res.id] = "";
                });
                this.$store.commit("proxima_request_setting/setPageSetting", {
                    key: "email_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["email_error_" + res.id] = "";
                });
                this.$store.commit("proxima_request_setting/setPageSetting", {
                    key: "email_error",
                    value: obj,
                });
                //passowrd
                obj = {};
                data.map((res) => {
                    obj["inquiry_label_" + res.id] = "";
                });
                this.$store.commit("proxima_request_setting/setPageSetting", {
                    key: "inquiry_label",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["inquiry_placeholder_" + res.id] = "";
                });
                this.$store.commit("proxima_request_setting/setPageSetting", {
                    key: "inquiry_placeholder",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["inquiry_error_" + res.id] = "";
                });
                this.$store.commit("proxima_request_setting/setPageSetting", {
                    key: "inquiry_error",
                    value: obj,
                });
                this.fetchRegPageSetting();
            });
    },
    watch: {
        selectedLanguage: function (newVal, oldVal) {
            // watch it
        },
    },
};
</script>
