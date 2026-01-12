<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">
                            {{ isFormEdit ? 'Edit' : 'Create' }} video
                        </h1>
                        <router-link :to="{ name: 'admin.videos.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <header class="mt-3">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
                            Select language(s) of the video
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
                                    `title.title_${language.id}`
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
                    <div class="relative z-0 w-full group md:col-span-2">
                        <label for="name" class="block text-base lg:text-lg">Title<span class="text-primary">*</span></label>
                        <input type="text" name="title" id="title"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleMultipleInput(
                                    'title',
                                    $event.target.value,
                                    language
                                )
                                " :value="form['title'] && form['title'][`title_${language.id}`]
                                    ? form['title'][`title_${language.id}`]
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`title.title_${language.id}`)"
                            v-text="validationErros.get(`title.title_${language.id}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group md:col-span-2" v-if="isDataLoaded">
                        <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`description_${language.id}`"
                    ></div> -->
                        <label for="description" class="block text-base lg:text-lg">Description<span class="text-primary">*</span></label>
                        <editor @selectionChange="
                            handleSelectionChange(
                                language,
                                'description'
                            )
                            " :ref="`description_${language.id}`" :id="`description_${language.id}`" :initial-value="form[`description`][`description_${language?.id}`]
                                " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `description.description_${language.id}`
                            )
                        " v-text="validationErros.get(
                            `description.description_${language.id}`
                        )
                            "></p>
                    </div>
                    <!-- <div class="relative z-0 w-full group">
                        <label for="featured" class="block text-base lg:text-lg">Featured</label>
                        <select
                        name="featured"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'featured')">
                            <option value="">Select</option>
                            <option :selected="form['featured'] == 'yes'" value="yes">
                                Active
                            </option>
                            <option :selected="form['featured'] == 'no'" value="no">
                                Inactive
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`featured`)"
                            v-text="validationErros.get(`featured`)"></p>
                    </div> -->
                    <div class="relative z-0 w-full group">
                        <label for="status" class="block text-base lg:text-lg">Status</label>
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
                    <!-- <div class="relative z-0 w-full group">
                        <label for="show_on_home_page" class="block text-base lg:text-lg">Show on home page</label>
                        <select name="show_on_home_page"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput(
                                    $event.target.value,
                                    'show_on_home_page'
                                )
                                ">
                            <option value="">Select</option>
                            <option :selected="form['show_on_home_page'] == 'yes'" value="yes">
                                Active
                            </option>
                            <option :selected="form['show_on_home_page'] == 'no'" value="no">
                                Inactive
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`show_on_home_page`)"
                            v-text="validationErros.get(`show_on_home_page`)"></p>
                    </div> -->
                    <div class="relative z-0 w-full group">
                        <label for="link" class="block text-base lg:text-lg">Link<span class="text-primary">*</span></label>
                        <input type="text" name="link" id="link"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleInput($event.target.value, 'link')"
                            :value="form['link'] ? form['link'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`link`)"
                            v-text="validationErros.get(`link`)"></p>
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
            isFormEdit: (state) => state.videos.isFormEdit,
            form: (state) => state.videos.form,
            validationErros: (state) => state.videos.validationErros,
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
        handleInput(value, key) {
            this.$store.commit("videos/setState", { key, value });
            if (value.trim()) {
                this.validationErros.clear(key);
            }
        },
        handleSelectionChange(language, key) {
            const content = tinymce.get(`${key}_${language.id}`).getContent();
            this.$store.commit(`videos/updateState`, {
                value: content,
                id: language.id,
                key: key,
            });
            if (content.trim()) {
                this.validationErros.clear(`${key}.${key}_${language.id}`);
            }
        },
        handleMultipleInput(key, value, language) {
            this.$store.commit("videos/updateState", {
                value: value,
                id: language.id,
                key,
            });
            if (value.trim()) {
                this.validationErros.clear(`${key}.${key}_${language.id}`);
            }
        },
        addUpdateForm() {
            this.$store
                .dispatch("videos/addUpdateForm")
                .then(() => this.$router.push({ name: "admin.videos.index" }
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
        fetchVideos() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("videos/setIsFormEdit", 1);
                this.$store
                    .dispatch("videos/fetchVideos", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}videos/${id}?withVideoDetail=1`,
                    })
                    .then((res) => {
                        console.log('res',res)
                        let keys = [
                            "status",
                            "featured",
                            "link",
                            "show_on_home_page",
                        ];
                        this.$store.commit("videos/setState", {
                            key: "id",
                            value: id,
                        });
                        for (var i = 0; i < keys.length; i++) {
                            this.$store.commit("videos/setState", {
                                key: keys[i],
                                value: res.data.data[keys[i]],
                            });
                        }

                        if (res.data.data.image) {
                            this.convertImgUrlToBase64(
                                res.data.data.image.full_path,
                                `image/${res.data.data.image.extension}`
                            );
                        }
                        let data =
                            res.data.data && res.data.data.video_detail
                                ? res.data.data.video_detail
                                : [];
                        let obj = {};
                        data.map((res) => {
                            obj["description_" + res.language_id] =
                                res.description;
                        });
                        this.$store.commit("videos/setState", {
                            key: "description",
                            value: obj,
                        });

                        data.map((res) => {
                            obj["title_" + res.language_id] = res.title;
                        });
                        this.$store.commit("videos/setState", {
                            key: "title",
                            value: obj,
                        });
                        this.isDataLoaded = 1;
                    });
            }
        },
    },
    created() {
        setOptions({ files: [] });
        this.$store.commit("videos/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["description_" + res.id] = "";
                });
                this.$store.commit("videos/setState", {
                    key: "description",
                    value: obj,
                });
                data.map((res) => {
                    obj["title_" + res.id] = "";
                });
                this.$store.commit("videos/setState", {
                    key: "title",
                    value: obj,
                });
                if (this.$route.params.id) {
                    this.fetchVideos();
                }
                else {
                    this.isDataLoaded = 1;
                }
            });
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
