<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">
                            {{ isFormEdit ? "Edit" : "Create a new" }} career
                        </h1>
                        <router-link :to="{ name: 'admin.careers.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <header class="mt-3">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
                            Select language(s) of the carrer
                        </p>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                    <ul class="flex gap-2 flex-wrap my-4">
                        <li class="mr-2 mb-2" v-for="language in languages" :key="language.id">
                            <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                (activeTab == null && language.is_default) ||
                                    activeTab == language.id
                                    ? 'text-white bg-primary active'
                                    : '',
                                validationErros.has(
                                    `level.level_${language.id}`
                                )
                                    ? 'bg-red-600 text-white hover:text-white'
                                    : '',
                            ]">{{ language.name }}</a>
                        </li>
                    </ul>
                </div>

                <div class="grid my-5 md:grid-cols-2 md:gap-6" v-for="language in languages" :key="language.id" :class="(activeTab == null && language.is_default) ||
                    activeTab == language.id
                    ? 'block'
                    : 'hidden'
                    ">
                    <!-- <div class="relative z-0 w-full group">
                    <label for="level" class="block text-base lg:text-lg">Level</label>
                    <input
                        type="text"
                        name="level"
                        id="level"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput($event.target.value, language, 'level')
                        "
                        :value="
                            form['level'] &&
                            form['level'][`level_${language.id}`]
                                ? form['level'][`level_${language.id}`]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has(`level.level_${language.id}`)"
                        v-text="
                            validationErros.get(`level.level_${language.id}`)
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label for="h_structure" class="block text-base lg:text-lg">Herarichal structure</label>
                    <input
                        type="text"
                        name="h_structure"
                        id="h_structure"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput(
                                $event.target.value,
                                language,
                                'h_structure'
                            )
                        "
                        :value="
                            form['h_structure'] &&
                            form['h_structure'][`h_structure_${language.id}`]
                                ? form['h_structure'][
                                      `h_structure_${language.id}`
                                  ]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="
                            validationErros.has(
                                `h_structure.h_structure_${language.id}`
                            )
                        "
                        v-text="
                            validationErros.get(
                                `h_structure.h_structure_${language.id}`
                            )
                        "
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label for="code" class="block text-base lg:text-lg">Code</label>
                    <input
                        type="text"
                        name="code"
                        id="code"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="
                            handleInput($event.target.value, language, 'code')
                        "
                        :value="
                            form['code'] && form['code'][`code_${language.id}`]
                                ? form['code'][`code_${language.id}`]
                                : ''
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has(`code.code_${language.id}`)"
                        v-text="validationErros.get(`code.code_${language.id}`)"
                    ></p>
                </div> -->
                    <div class="relative z-0 w-full group">
                        <label for="class_name" class="block text-base lg:text-lg">Class Name<span class="text-primary">*</span></label>
                        <input type="text" name="class_name" id="class_name"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'class_name'
                                )
                                " :value="form['class_name'] &&
                                    form['class_name'][`class_name_${language.id}`]
                                    ? form['class_name'][
                                    `class_name_${language.id}`
                                    ]
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `class_name.class_name_${language.id}`
                            )
                        " v-text="validationErros.get(
                            `class_name.class_name_${language.id}`
                        )
                            "></p>
                    </div>
                    <div class="relative z-0 w-full group mt-4 md:col-span-2" v-if="isDataLoaded">
                        <label for="class_definition" class="block text-base lg:text-lg">Class Definition<span class="text-primary">*</span></label>
                        <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`class_definition_${language.id}`"
                    ></div> -->
                        <editor @selectionChange="
                            handleSelectionChange(
                                language,
                                'class_definition'
                            )
                            " :ref="`class_definition_${language.id}`" :id="`class_definition_${language.id}`"
                            :initial-value="form[`class_definition`][`class_definition_${language?.id}`]
                                " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `class_definition.class_definition_${language.id}`
                            )
                        " v-text="validationErros.get(
                            `class_definition.class_definition_${language.id}`
                        )
                            "></p>
                    </div>
                </div>



                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full group flex items-center space-x-2">
                        <input type="checkbox" name="hot" id="hot" placeholder=" "
                            @input="handleHotInput($event.target.checked)" :checked="form['hot'] && form['hot']" />
                        <label for="hot" class="text-base text-gray-700">Do you want to set it in hot listing</label>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`hot`)"
                            v-text="validationErros.get(`hot`)"></p>
                    </div>
                </div>
                <ListErrors :validationErrors="validationErros" />

                <button type="submit" class="can-edu-btn-fill mb-2">
                    Submit
                </button>
            </form>
        </div>
    </AppLayout>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
// Import filepond
import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            isFormEdit: (state) => state.careers.isFormEdit,
            form: (state) => state.careers.form,
            validationErros: (state) => state.careers.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            activeTab: null,
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
        handleInput(value, language, key) {
            this.$store.commit("careers/setCareer", {
                value,
                id: language.id,
                key,
            });
            const trimmedValue = value.trim();
            const fieldName = `${key}.${key}_${language.id}`;

            if (this.validationErros.has(fieldName) && trimmedValue.length > 0) {
                this.validationErros.clear(fieldName);
            }
        },
        handleSelectionChange(language, key) {
            const content = tinymce.get(`${key}_${language.id}`).getContent().trim();
            this.$store.commit(`careers/setCareer`, {
                value: content,
                id: language.id,
                key: key,
            });
            const fieldName = `${key}.${key}_${language.id}`;
            if (this.validationErros.has(fieldName) && content.length > 0) {
                this.validationErros.clear(fieldName);
            }
        },
        handleHotInput(checked) {
            this.$store.commit("careers/setHot", checked);
        },
        addUpdateForm() {
            this.$store
                .dispatch("careers/addUpdateForm")
                .then(() => {
                    this.$router.push({ name: "admin.careers.index" });
                })
                .catch((error) => {
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

        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchCareers() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("careers/setIsFormEdit", 1);
                this.$store
                    .dispatch("careers/fetchCareer", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}careers/${id}?withCareerDetail=1`,
                    })
                    .then((res) => {
                        this.$store.commit("careers/setForm", { id });
                        this.$store.commit(
                            "careers/setHot",
                            res.data.data?.hot
                        );

                        let data =
                            res.data.data && res.data.data.career_detail
                                ? res.data.data.career_detail
                                : [];
                        let obj = {};
                        data.map((res) => {
                            obj["level_" + res.language_id] = res.level;
                        });
                        this.$store.commit("careers/setState", {
                            key: "level",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["h_structure_" + res.language_id] =
                                res.h_structure;
                        });
                        this.$store.commit("careers/setState", {
                            key: "h_structure",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["code_" + res.language_id] = res.code;
                        });
                        this.$store.commit("careers/setState", {
                            key: "code",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["class_name_" + res.language_id] =
                                res.class_name;
                        });
                        this.$store.commit("careers/setState", {
                            key: "class_name",
                            value: obj,
                        });
                        obj = {};
                        data.map((res) => {
                            obj["class_definition_" + res.language_id] =
                                res.class_definition;
                        });
                        this.$store.commit("careers/setState", {
                            key: "class_definition",
                            value: obj,
                        });
                        this.isDataLoaded = 1;
                    });
            }
        },
    },
    created() {
        setOptions({ files: [] });
        this.$store.commit("careers/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["class_definition_" + res.id] = "";

                });
                this.$store.commit("careers/setState", {
                    key: "class_definition",
                    value: obj,
                });
                if (this.$route.params.id) {
                    this.fetchCareers();
                }
                else {
                    this.isDataLoaded = 1;
                }
            });
    },
    components: {
        FilePond,
        ListErrors,
        editor: Editor
    },
};
</script>

<style scoped>
/**
 * FilePond Custom Styles
 */
.filepond--drop-label {
    color: #4c4e53;
}

.filepond--label-action {
    text-decoration-color: #babdc0;
}

.filepond--panel-root {
    border-radius: 2em;
    background-color: #edf0f4;
    height: 1em;
}

.filepond--item-panel {
    background-color: #595e68;
}

.filepond--drip-blob {
    background-color: #7f8a9a;
}
</style>
