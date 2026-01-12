<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">
                            {{ isFormEdit ? "Edit" : "Create" }} quote
                        </h1>
                        <router-link :to="{ name: 'admin.quotes.index' }" class="can-edu-btn-fill">
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
                                    `quote.quote_${language.id}`
                                )
                                    ? 'bg-red-600 text-white hover:text-white'
                                    : '',
                            ]">{{ language.name }}</a>
                        </li>
                    </ul>
                </div>

                <div class="grid my-5 md:grid-cols-2 md:gap-6 mt-10" v-for="language in languages" :key="language.id"
                    :class="(activeTab == null && language.is_default) ||
                        activeTab == language.id
                        ? 'block'
                        : 'hidden'
                        ">
                    <div class="relative z-0 w-full group md:col-span-2" v-if="isDataLoaded">
                        <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`quote_${language.id}`"
                    ></div> -->
                        <label for="quote" class="block text-base lg:text-lg">Quote<span class="text-primary">*</span></label>
                        <editor @selectionChange="
                            handleSelectionChange(language, 'quote')
                            " :ref="`quote_${language.id}`" :id="`quote_${language.id}`" :initial-value="form[`quote`][`quote_${language?.id}`]
                                " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `quote.quote_${language.id}`
                            )
                        " v-text="validationErros.get(
                            `quote.quote_${language.id}`
                        )
                            "></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="name" class="block text-base lg:text-lg">Your Name<span class="text-primary">*</span></label>
                        <input name="name"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'name')" id="name" :value="form['name']" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`name`)"
                            v-text="validationErros.get(`name`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="location" class="block text-base lg:text-lg">Your Location<span class="text-primary">*</span></label>
                        <input name="location"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'location')
                                " id="location" :value="form['location']" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`location`)"
                            v-text="validationErros.get(`location`)"></p>
                    </div>
                    <!-- <div class="relative z-0 w-full group">
                        <label
                            for="school_id"
                            class="block text-base lg:text-lg"
                            >School</label
                        >
                        <select
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'school_id')
                            "
                        >
                            <option value="">Select</option>
                            <option
                                v-for="(school, key) in schools"
                                :key="key"
                                :selected="form['school_id'] == school?.id"
                                :value="school?.id"
                            >
                                {{
                                    school?.school_detail &&
                                    school?.school_detail?.length > 0
                                        ? school?.school_detail[0]?.school_name
                                        : ""
                                }}
                            </option>
                        </select>
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="validationErros.has(`school_id`)"
                            v-text="validationErros.get(`school_id`)"
                        ></p>
                    </div> -->
                    <div class="relative z-0 w-full group">
                        <label for="status" class="block text-base lg:text-lg">Status<span class="text-primary">*</span></label>
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

                    <div class="relative z-0 w-full group">
                        <label for="image" class="block text-base lg:text-lg">Image</label>
                        <FilePond name="image" class-name="my-pond" accepted-file-types="image/*"
                            @init="handleFilePondInit" @processfile="handleFilePondFlagIconProcess"
                            @removefile="handleFilePondFlagIconRemoveFile" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('image')"
                            v-text="validationErros.get('image')"></p>
                    </div>
                </div>
                <ListErrors :validationErrors="validationErros" />
                <button type="submit"
                    class="can-edu-btn-fill mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
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
            isFormEdit: (state) => state.quotes.isFormEdit,
            form: (state) => state.quotes.form,
            validationErros: (state) => state.quotes.validationErros,
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
            this.$store.commit("quotes/setState", { key, value });
            if (value.trim()) {
                this.validationErros.clear(key);
            }
        },
        handleSelectionChange(language, key) {
            const content = tinymce.get(`${key}_${language.id}`).getContent();
            this.$store.commit(`quotes/updateState`, {
                value: content,
                id: language.id,
                key: key,
            });
            const errorKey = `quote.quote_${language.id}`;
            if (content.trim()) {
                this.validationErros.clear(errorKey);
            }
        },
        handleMultipleInput(key, value, language) {
            this.$store.commit("quotes/updateState", {
                value: value,
                id: language.id,
                key,
            });
        },
        addUpdateForm() {
            this.$store
                .dispatch("quotes/addUpdateForm")
                .then(() => this.$router.push({ name: "admin.quotes.index" }
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
        fetchQuotes() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("quotes/setIsFormEdit", 1);
                this.$store
                    .dispatch("quotes/fetchQuotes", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}quotes/${id}?withQuoteDetail=1`,
                    })
                    .then((res) => {
                        let keys = ["name", "location", "status", "school_id"];
                        this.$store.commit("quotes/setState", {
                            key: "id",
                            value: id,
                        });
                        for (var i = 0; i < keys.length; i++) {
                            this.$store.commit("quotes/setState", {
                                key: keys[i],
                                value: res.data.data[keys[i]],
                            });
                        }
                        if (res.data.data.quote_image) {
                            this.$store.commit("quotes/setState", {
                                key: "image",
                                value: res.data.data.quote_image,
                            });
                            this.convertImgUrlToBase64(
                                res.data.data.quote_image.full_path,
                                `image/${res.data.data.quote_image.extension}`
                            );
                        }
                        let data =
                            res.data.data && res.data.data.quote_detail
                                ? res.data.data.quote_detail
                                : [];
                        let obj = {};
                        data.map((res) => {
                            obj["quote_" + res.language_id] = res.quote;
                        });
                        this.$store.commit("quotes/setState", {
                            key: "quote",
                            value: obj,
                        });
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
                        formData.append("type", "quote_image");

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
            this.selected_image = file.serverId;
            this.$store.commit("quotes/setState", {
                key: "image",
                value: file.serverId,
            });
            if (this.validationErros.has("image")) {
                this.validationErros.clear("image");
            }
        },
        handleFilePondFlagIconRemoveFile(error, file) {
            this.$store.commit("quotes/setState", {
                key: "image",
                value: null,
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
        this.$store.commit("quotes/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["quote_" + res.id] = "";
                });
                this.$store.commit("quotes/setState", {
                    key: "quote",
                    value: obj,
                });
                if (this.$route.params.id) {
                    this.fetchQuotes();
                } else {
                    this.isDataLoaded = 1;
                }
            });
        this.$store.commit("schools/setLimit", 10000);
        this.$store.commit("schools/setSortBy", "id");
        this.$store.commit("schools/setSortType", "desc");
        this.$store.dispatch("schools/fetchSchools");
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
