    <template>
        <AppLayout>
            <div class="relative shadow-md rounded-lg bg-white py-4">
                <header class="">
                    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between">
                            <h1 class="can-edu-h1">
                                {{ isFormEdit ? "Edit" : "Create" }} Country
                            </h1>
                            <router-link :to="{ name: 'admin.countries.index' }" class="can-edu-btn-fill">
                                Back
                            </router-link>
                        </div>
                    </div>
                </header>
                <header class="mt-3">
                    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between">
                            <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
                                Select language(s) of the quotes
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
                                    (activeTab == null &&
                                        language.is_default) ||
                                        activeTab == language.id
                                        ? 'text-white bg-primary active'
                                        : '',
                                    validationErros.has(
                                        `country.country_${language.id}`
                                    )
                                        ? 'bg-red-600 text-white hover:text-white'
                                        : '',
                                ]">{{ language.name }}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="grid my-5 md:grid-cols-2 md:gap-6" v-for="language in languages" :key="language.id"
                        :class="(activeTab == null && language.is_default) ||
                            activeTab == language.id
                            ? 'block'
                            : 'hidden'
                            ">
                        <div class="relative z-0 w-full group md:col-span-2">
                            <label for="name" class="block text-base lg:text-lg">Country status name</label>
                            <input type="text" name="name" id="name"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                placeholder=" " @input="handleCountryNameInput($event.target.value, language)" :value="form.country_name && form.country_name[`country_${language.id}`]
                                    ? form.country_name[`country_${language.id}`]
                                    : ''" />
                            <p class="mt-2 text-base text-primary"
                                v-if="validationErros.has(`country_name.country_${language.id}`)"
                                v-text="validationErros.get(`country_name.country_${language.id}`)">
                            </p>
                        </div>


                        <!-- </div>

                <div class="grid my-5 md:grid-cols-2 md:gap-6"> -->
                        <div class="relative z-0 w-full group md:col-span-2">
                            <label for="status" class="block text-base lg:text-lg">Status<span
                                    class="text-primary">*</span></label>
                            <select name="status"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                @input="handleInput($event.target.value, 'status')">
                                <option value="">Select</option>
                                <option :selected="form['status'] == 'yes'" value="yes">
                                    Active
                                </option>
                                <option :selected="form['status'] == 'no'" value="no">
                                    Inactive
                                </option>
                            </select>
                            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`status`)"
                                v-text="validationErros.get(`status`)"></p>
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
import ListErrors from "../components/ListErrors.vue";
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            isFormEdit: (state) => state.countries.isFormEdit,
            form: (state) => state.countries.form,
            validationErros: (state) => state.countries.validationErros,
            languages: (state) => state.languages.languages,
            schools: (state) => state.schools.schools,
        }),
    },
    data() {
        return {
            activeTab: null,
            isDataLoaded: false,
            editorConfig: {
                height: 250,
                menubar: false,
                plugins:
                    "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code",
                toolbar:
                    "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen",
                placeholder: "Your quote should be no more than 50 words"
            },
            tinymceScriptSrc: "/plugins/tinymce/tinymce.min.js",
        };
    },
    methods: {
        handleInput(value, key) {
            this.$store.commit("countries/setState", { key, value });
            if (value.trim()) {
                this.validationErros.clear(key);
            }
        },
        handleSelectionChange(language, key) {
            const content = tinymce.get(`${key}_${language.id}`).getContent();
            this.$store.commit(`countries/updateState`, {
                value: content,
                id: language.id,
                key: key,
            });
            const errorKey = `country.country_${language.id}`;
            if (content.trim()) {
                this.validationErros.clear(errorKey);
            }
        },

        handleCountryNameInput(value, language) {
            this.$store.commit("countries/updateCountryName", {
                name: value,
                id: language.id,
            });

            const errorKey = `country_name.country_${language.id}`;
            if (value.trim()) {
                this.validationErros.clear(errorKey);
            }
        },

        addUpdateForm() {
            this.$store
                .dispatch("countries/addUpdateForm")
                .then(() => this.$router.push({ name: "admin.countries.index" }
                )).catch((error) => {
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
                console.log(`No input field found for ${fieldName}`);
            }
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchCountry() {
            if (this.$route.params.id) {
                const id = this.$route.params.id;

                this.$store.commit("countries/setIsFormEdit", true);
                this.$store
                    .dispatch("countries/fetchCountry", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}countries/${id}?withCountryDetail=1`,
                    })
                    .then((res) => {
                        let data = res.data.data;
                        console.log("Country detail from API:", data.country);
                        let keys = ["id", "name", "status"];
                        for (let i = 0; i < keys.length; i++) {
                            this.$store.commit("countries/setState", {
                                key: keys[i],
                                value: data[keys[i]],
                            });
                        }

                        let countryObj = {};
                        if (data.country_detail) {
                            data.country_detail.forEach((item) => {
                                countryObj[`country_${item.language_id}`] = item.name;
                            });
                        }

                        this.$store.commit("countries/setState", {
                            key: "country_name",
                            value: countryObj,
                        });

                        this.isDataLoaded = 1;
                    });
            }
        },
    },
    created() {
        setOptions({ files: [] });
        this.$store.commit("countries/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["country_" + res.id] = "";
                });
                this.$store.commit("countries/setState", {
                    key: "country",
                    value: obj,
                });
                if (this.$route.params.id) {
                    this.fetchCountry();
                } else {
                    this.isDataLoaded = 1;
                }
            });
        // this.$store.commit("countries/setLimit", 10000);
        // this.$store.commit("countries/setSortBy", "id");
        // this.$store.commit("schools/setSortType", "desc");
        // this.$store.dispatch("schools/fetchSchools");
    },
    components: {
        FilePond,
        ListErrors,
        editor: Editor,
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
