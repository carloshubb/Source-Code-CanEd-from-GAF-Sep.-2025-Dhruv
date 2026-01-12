<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header>
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">{{ isFormEdit ? 'Edit' : 'Create' }} story</h1>
                        <router-link :to="{ name: 'admin.stories.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <header class="mt-3">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
                            Select language(s) of the story
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
                                ) ||
                                    validationErros.has(
                                        `story.story_${language.id}`
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
                    <div class="relative z-0 w-full mb-6 group md:col-span-2">
                        <label for="title" class="block text-base lg:text-lg">Title<span class="text-primary">*</span></label>
                        <input type="text" name="title" id="title"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleMultipleInput('title', $event.target.value, language)" :value="form['title'] &&
                                form['title'][`title_${language.id}`]
                                ? form['title'][`title_${language.id}`]
                                : ''
                                " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`title.title_${language.id}`)"
                            v-text="validationErros.get(`title.title_${language.id}`)
                                "></p>
                    </div>
                    <div class="relative z-0 w-full mb-6 group mt-4 md:col-span-2" v-if="isDataLoaded">
                        <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`story_${language.id}`"
                    ></div> -->
                        <label for="story" class="block text-base lg:text-lg">Story<span class="text-primary">*</span></label>
                        <editor @selectionChange="
                            handleSelectionChange(
                                language,
                                'story'
                            )
                            " :ref="`story_${language.id}`" :id="`story_${language.id}`" :initial-value="form[`story`][`story_${language?.id}`]
                                " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`story.story_${language.id}`)"
                            v-text="validationErros.get(`story.story_${language.id}`)
                                "></p>
                    </div>
                </div>

                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="student_name" class="block text-base lg:text-lg">Student Name<span class="text-primary">*</span></label>
                        <input type="text" name="student_name" id="student_name"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleInput('student_name', $event.target.value)" :value="form['student_name'] ? form['student_name'] : ''
                                " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`student_name`)"
                            v-text="validationErros.get(`student_name`)"></p>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="country_of_origin" class="block text-base lg:text-lg">Country of origin</label>
                        <input type="text" name="country_of_origin" id="country_of_origin"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @change="handleInput('country_of_origin', $event.target.value)" :value="form['country_of_origin']
                                ? form['country_of_origin']
                                : ''
                                " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`country_of_origin`)"
                            v-text="validationErros.get(`country_of_origin`)"></p>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="image" class="block text-base lg:text-lg">Image<span class="text-primary">*</span></label>
                        <FilePond name="image" class-name="my-pond" accepted-file-types="image/*"
                            @init="handleFilePondInit" @processfile="handleFilePondFlagIconProcess"
                            @removefile="handleFilePondFlagIconRemoveFile" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('image')"
                            v-text="validationErros.get('image')"></p>
                    </div>
                </div>
                <ListErrors :validationErrors="validationErros" />

                <button type="submit" class="can-edu-btn-fill mb-2">Submit</button>
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
            isFormEdit: (state) => state.stories.isFormEdit,
            form: (state) => state.stories.form,
            validationErros: (state) => state.stories.validationErros,
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
        handleInput(key, value) {
            this.$store.commit("stories/setState", {
                key,
                value,
            });
            if (value.trim()) {
                this.validationErros.clear(key);
            }
        },
        handleSelectionChange(language, key) {
            const content = tinymce.get(`${key}_${language.id}`).getContent();
            this.$store.commit(`stories/updateState`, {
                value: content,
                id: language.id,
                key: key,
            });
            if (content.trim()) {
                this.validationErros.clear(`story.story_${language.id}`);
            }
        },
        handleMultipleInput(key, value, language) {
            this.$store.commit("stories/updateState", {
                value: value,
                id: language.id,
                key,
            });
            if (value.trim()) {
                this.validationErros.clear(`title.title_${language.id}`);
            }
        },
        addUpdateForm() {
            this.$store
                .dispatch("stories/addUpdateForm")
                .then(() => this.$router.push({ name: "admin.stories.index" }
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
        fetchStories() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("stories/setIsFormEdit", 1);
                this.$store
                    .dispatch("stories/fetchStories", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}stories/${id}?withStoryDetail=1`,
                    })
                    .then((res) => {
                        this.$store.commit("stories/setState", {
                            key: "id",
                            value: id,
                        });
                        let keys = ["student_name", "country_of_origin"];
                        for (var i = 0; i < keys.length; i++) {
                            this.$store.commit("stories/setState", {
                                key: keys[i],
                                value: res.data.data[keys[i]],
                            });
                        }
                        if (res.data.data.image) {
                            this.$store.commit("stories/setState", {
                                key: "image",
                                value: res.data.data.image,
                            });
                            this.convertImgUrlToBase64(
                                res.data.data.image.full_path,
                                `image/${res.data.data.image.extension}`
                            );
                        }
                        let data =
                            res.data.data && res.data.data.story_detail
                                ? res.data.data.story_detail
                                : [];
                        let obj = {};
                        data.map((res) => {
                            obj["title_" + res.language_id] = res.title;
                        });
                        this.$store.commit("stories/setState", {
                            key: "title",
                            value: obj,
                        });
                        obj = {};
                        data.map((res) => {
                            obj["story_" + res.language_id] = res.story;
                        });
                        this.$store.commit("stories/setState", {
                            key: "story",
                            value: obj,
                        });
                        this.$store.commit("stories/setName", obj);
                        this.isDataLoaded = 1;
                    });
            }
        },
        handleFilePondInit() {
            setOptions({
                credits: false,
                server: {
                    url: process.env.MIX_ADMIN_API_URL,
                    process: (
                        fieldName,
                        file,
                        metadata,
                        load,
                        error,
                        progress,
                        abort,
                        transfer,
                        options
                    ) => {
                        const formData = new FormData();
                        formData.append("media", file, file.name);
                        formData.append("is_temp_media", 1);
                        formData.append("type", "image");

                        const request = new XMLHttpRequest();
                        request.open(
                            "POST",
                            `${process.env.MIX_ADMIN_API_URL}media/process`
                        );
                        request.setRequestHeader(
                            "X-CSRF-TOKEN",
                            document.head.querySelector(
                                'meta[name="csrf-token"]'
                            ).content
                        );

                        request.upload.onprogress = (e) => {
                            progress(e.lengthComputable, e.loaded, e.total);
                        };
                        request.onload = function () {
                            if (request.status >= 200 && request.status < 300) {
                                load(request.responseText);
                            } else {
                                error("oh no");
                            }
                        };

                        request.send(formData);

                        return {
                            abort: () => {
                                request.abort();
                                abort();
                            },
                        };
                    },
                    revert: (uniqueFileId, load, error) => {
                        const formData = new FormData();
                        formData.append("media", uniqueFileId);

                        const request = new XMLHttpRequest();
                        request.open(
                            "POST",
                            `${process.env.MIX_ADMIN_API_URL}media/revert`
                        );
                        request.setRequestHeader(
                            "X-CSRF-TOKEN",
                            document.head.querySelector(
                                'meta[name="csrf-token"]'
                            ).content
                        );

                        request.send(formData);

                        return {
                            abort: () => {
                                request.abort();
                                abort();
                            },
                        };
                    },
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                },
            });
        },
        handleFilePondFlagIconProcess(error, file) {
            this.$store.commit("stories/setState", {
                key: "image",
                value: file.serverId,
            });
            if (this.validationErros.has("image")) {
                this.validationErros.clear("image");
            }
        },
        handleFilePondFlagIconRemoveFile(error, file) {
            this.$store.commit("stories/setState", {
                key: "image",
                value: file.serverId,
            });
            if (this.validationErros.has("image")) {
                this.validationErros.clear("image");
            }
        },
        convertImgUrlToBase64(url, type) {
            var image = new Image();

            image.onload = function () {
                var canvas = document.createElement("canvas");
                canvas.width = image.width;
                canvas.height = image.height;

                canvas.getContext("2d").drawImage(this, 0, 0);

                canvas.toBlob(
                    function (source) {
                        var newImg = document.createElement("img"),
                            url = URL.createObjectURL(source);

                        newImg.onload = function () {
                            URL.revokeObjectURL(url);
                        };

                        newImg.src = url;
                    },
                    type,
                    1
                );
                let dataUrl = canvas.toDataURL(type);
                let files = [
                    {
                        source: dataUrl,
                        options: {
                            type: "local",
                        },
                    },
                ];
                setOptions({ files: files });
            };
            image.src = url;
        },

    },
    created() {
        setOptions({ files: [] });
        this.$store.commit("stories/resetState");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["story_" + res.id] = "";
                });
                this.$store.commit("stories/setState", {
                    key: "story",
                    value: obj,
                });
                data.map((res) => {
                    obj["title_" + res.id] = "";
                });
                this.$store.commit("stories/setName", obj);
                if (this.$route.params.id) {
                    this.fetchStories();
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
