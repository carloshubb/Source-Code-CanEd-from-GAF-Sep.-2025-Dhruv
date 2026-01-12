<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">
                            {{ isFormEdit ? "Edit" : "Create" }} article
                            category
                        </h1>
                        <router-link :to="{ name: 'admin.article_categories.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <header class="mt-3">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <p class="block text-base lg:text-lg font-FuturaMdCnBT text-primary">
                            Select language(s) of the article category
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
                                    `name.name_${language.id}`
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
                        <label for="name" class="block text-base lg:text-lg">Name<span class="text-primary">*</span></label>
                        <input type="text" name="name" id="name"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleNameInput($event.target.value, language)
                                " :value="form['name'] &&
                                    form['name'][`name_${language.id}`]
                                    ? form['name'][`name_${language.id}`]
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(`name.name_${language.id}`)
                        " v-text="validationErros.get(`name.name_${language.id}`)
                            "></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="name" class="block text-base lg:text-lg">Parent Category</label>
                        <select
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleCategoryInput($event.target.value)">
                            <option value="">Select</option>
                            <template v-for="(
article_category, key
                                ) in article_categories" :key="key">
                                <option v-if="
                                    !article_category?.parent_id &&
                                    article_category?.id != form?.id
                                " :value="article_category?.id" :selected="form?.parent_id == article_category?.id
                                    ">
                                    {{
                                        article_category
                                            ?.article_category_detail?.length >
                                            0
                                            ? article_category
                                                ?.article_category_detail[0]
                                                ?.name
                                            : ""
                                    }}
                                </option>
                            </template>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('article_category_id')"
                            v-text="validationErros.get('article_category_id')"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="name" class="block text-base lg:text-lg">Type<span class="text-primary">*</span></label>
                        <select name="type"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleTypeInput($event.target.value)">
                            <option value="">Select</option>
                            <option :value="`article`" :selected="form?.type == 'article'
                                ">
                                Article
                            </option>
                            <option :value="`video`" :selected="form?.type == `video`
                                ">
                                Video
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('type')"
                            v-text="validationErros.get('type')"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="article_category_image" class="block text-base lg:text-lg">Image<span class="text-primary">*</span></label>
                        <FilePond name="article_category_image" class-name="my-pond" accepted-file-types="image/*"
                            @init="handleFilePondInit" @processfile="handleFilePondFlagIconProcess"
                            @removefile="handleFilePondFlagIconRemoveFile" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('article_category_image')"
                            v-text="validationErros.get('article_category_image')
                                "></p>
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
            isFormEdit: (state) => state.article_categories.isFormEdit,
            form: (state) => state.article_categories.form,
            validationErros: (state) =>
                state.article_categories.validationErros,
            languages: (state) => state.languages.languages,
            article_categories: (state) =>
                state.article_categories.article_categories,
        }),
    },
    data() {
        return {
            activeTab: null,
        };
    },
    methods: {
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
        handleCategoryInput(value) {
            this.$store.commit("article_categories/setParentCategory", value);
        },
        handleTypeInput(value) {
            this.$store.commit("article_categories/setType", value);
            this.$store.dispatch("article_categories/fetchArticleCategories", {
                url: `${process.env.MIX_ADMIN_API_URL}article_categories?q=1&type=${value}`,
            });
            if (this.validationErros.has("type")) {
                this.validationErros.clear("type");
            }
        },
        handleNameInput(value, language) {
            this.$store.commit("article_categories/updateName", {
                name: value,
                id: language.id,
            });
            if (this.validationErros.has(`name.name_${language.id}`)) {
                this.validationErros.clear(`name.name_${language.id}`);
            }
        },
        addUpdateForm() {
            this.$store.dispatch("article_categories/addUpdateForm")
                .then(() => {
                    this.$router.push({ name: "admin.article_categories.index" });
                })
                .catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.focusOnFirstErrorInput(error.response.data.errors);
                    }
                });
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchArticleCategories() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("article_categories/setIsFormEdit", 1);
                this.$store
                    .dispatch("article_categories/fetchArticleCategory", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}article_categories/${id}?withArticleCategoryDetail=1`,
                    })
                    .then((res) => {
                        this.$store.commit("article_categories/setForm", {
                            id,
                            article_category_image:
                                res.data.data.article_category_image,
                        });

                        if (res.data.data.article_category_image) {
                            this.convertImgUrlToBase64(
                                res.data.data.article_category_image.full_path,
                                `image/${res.data.data.article_category_image.extension}`
                            );
                        }
                        if (res.data?.data?.parent_id) {
                            this.$store.commit(
                                "article_categories/setParentCategory",
                                res.data.data.parent_id
                            );
                        }
                        if (res.data?.data?.type) {
                            this.$store.commit(
                                "article_categories/setType",
                                res.data.data.type
                            );
                            this.$store.dispatch("article_categories/fetchArticleCategories", {
                                url: `${process.env.MIX_ADMIN_API_URL}article_categories?q=1&type=${res.data.data.type}`,
                            });
                        }

                        let data =
                            res.data.data &&
                                res.data.data.article_category_detail
                                ? res.data.data.article_category_detail
                                : [];
                        let obj = {};
                        data.map((res) => {
                            obj["name_" + res.language_id] = res.name;
                        });
                        this.$store.commit("article_categories/setName", obj);
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
                        formData.append("type", "article_category_image");

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
            this.$store.commit("article_categories/setForm", {
                article_category_image: file.serverId,
                id: this.$route.params.id ? this.$route.params.id : "",
            });
            if (this.validationErros.has("article_category_image")) {
                this.validationErros.clear("article_category_image");
            }
        },
        handleFilePondFlagIconRemoveFile(error, file) {
            this.$store.commit("article_categories/setForm", {
                article_category_image: null,
            });
            if (this.validationErros.has("article_category_image")) {
                this.validationErros.clear("article_category_image");
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
                setOptions({
                    files: files,
                });
            };
            image.src = url;
        },
    },
    created() {
        setOptions({
            files: [],
        });
        this.$store.commit("article_categories/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["name_" + res.id] = "";
                });
                this.$store.commit("article_categories/setName", obj);
                this.fetchArticleCategories();
            });

        this.$store.commit("article_categories/setLimit", 20000);
        this.$store.commit("article_categories/setSortBy", "id");
        this.$store.commit("article_categories/setSortType", "desc");
        this.$store.dispatch("article_categories/fetchArticleCategories");
    },
    components: {
        FilePond,
        ListErrors,
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
