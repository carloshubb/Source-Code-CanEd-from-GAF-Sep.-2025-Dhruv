<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">
                            {{ isFormEdit ? "Edit" : "Create" }} degree level
                        </h1>
                        <router-link :to="{ name: 'admin.degrees.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <header class="mt-3">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
                            Select language(s) of the degree level
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

                <div class="grid my-5 grid-cols-1 md:grid-cols-2 gap-4 md:gap-6" v-for="language in languages"
                    :key="language.id" :class="(activeTab == null && language.is_default) ||
                        activeTab == language.id
                        ? 'block'
                        : 'hidden'
                        ">
                    <div class="relative z-0 w-full group">
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
                    <!-- </div> -->
                    <!-- <div class="grid my-5 md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-6 group">
                            <input
                                type="text"
                                name="url"
                                id="url"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" "
                                @input="handleUrlInput($event.target.value)"
                                :value="form['url'] ? form['url'] : ''"
                            />
                            <label
                                for="url"
                                class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                                >Url</label
                            >
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="validationErros.has(`url`)"
                                v-text="validationErros.get(`url`)"
                            ></p>
                        </div>
                    </div> -->

                    <div class="relative z-0 w-full group">
                        <label for="order" class="block text-base lg:text-lg">Order<span class="text-primary">*</span></label>
                        <input type="number" name="order" id="order"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleOrderInput($event.target.value)"
                            :value="form['order'] ? form['order'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`order`)"
                            v-text="validationErros.get(`order`)"></p>
                    </div>

                    <div class="relative z-0 w-full group md:col-span-2" v-if="isDataLoaded">
                        <label for="name" class="block text-base lg:text-lg">Description<span class="text-primary">*</span></label>
                        <!-- <div class="mt-5" :id="'editor_' + language.id"></div> -->
                        <editor @selectionChange="
                            handleSelectionChange(language, 'description')
                            " :ref="`description_${language.id}`" :id="`description_${language.id}`" :initial-value="form[`description`][
                                `description_${language?.id}`
                            ]
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

                    <div class="relative z-0 w-full group">
                        <label :for="`image`" class="block text-base lg:text-lg">Image</label>
                        <input :key="`image`" type="file" :name="`image`" :id="`image`"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleImage($event, 'image')" ref="fileupload" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`image`)"
                            v-text="validationErros.get(`image`)"></p>
                        <div v-if="form['image']">
                            <img :src="form['image'] ? form['image'] : ''" style="height: 100px; width: 100px" />
                            <button @click="removeImage" class="mt-2 can-edu-btn-fill">
                                Remove image
                            </button>
                        </div>
                    </div>
                </div>
                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label :for="`degree_image`" class="block text-base lg:text-lg">Icon<span class="text-primary">*</span></label>
                        <FilePond name="degree_image" class-name="my-pond" accepted-file-types="image/*"
                            @init="handleFilePondInit" @processfile="handleFilePondFlagIconProcess"
                            @removefile="handleFilePondFlagIconRemoveFile" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('degree_image')"
                            v-text="validationErros.get('degree_image')"></p>
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
            isFormEdit: (state) => state.degrees.isFormEdit,
            form: (state) => state.degrees.form,
            validationErros: (state) => state.degrees.validationErros,
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
                plugins:
                    "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code",
                toolbar:
                    "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen",
            },
            tinymceScriptSrc: "/plugins/tinymce/tinymce.min.js",
        };
    },
    methods: {
        handleOrderInput(value) {
            this.$store.commit("degrees/setOrder", value);
            if (this.validationErros.has("order") && value.trim() !== "") {
                this.validationErros.clear("order");
            }
        },
        handleUrlInput(value) {
            this.$store.commit("degrees/setUrl", value);
            if (this.validationErros.has("order") && value.trim() !== "") {
                this.validationErros.clear("order");
            }
        },
        handleNameInput(value, language) {
            this.$store.commit("degrees/updateName", {
                name: value,
                id: language.id,
            });
            const errorKey = `name.name_${language.id}`;
            if (this.validationErros.has(errorKey) && value.trim() !== "") {
                this.validationErros.clear(errorKey);
            }
        },
        handleDescriptionInput(value, language) {
            this.$store.commit("degrees/updateDescription", {
                description: value,
                id: language.id,
            });
        },
        handleSelectionChange(language, key) {
            const editorContent = tinymce.get(`${key}_${language.id}`)?.getContent() || "";
            this.$store.commit(`degrees/updateDescription`, {
                description: editorContent,
                id: language.id,
            });
            const errorKey = `description.description_${language.id}`;
            if (this.validationErros.has(errorKey) && editorContent.trim() !== "") {
                this.validationErros.clear(errorKey);
            }
        },
        handleImage(e, key) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/admin/media/image_again_upload", file).then((res) => {
                this.$store.commit("degrees/setImage", res?.data);
            });
        },
        removeImage() {
            this.$refs.fileupload.value = null;
            this.$store.commit("degrees/setImage", "");
        },
        addUpdateForm() {
            this.$store
                .dispatch("degrees/addUpdateForm")
                .then(() => this.$router.push({ name: "admin.degrees.index" }    
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
          }, 300); // Allow smooth scrolling before focusing

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
        }, 300); // Add a delay before focusing to allow smooth scrolling

      } else {
        console.log(`No input field found for ${fieldName}`);
      }
    },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchDegrees() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("degrees/setIsFormEdit", 1);
                this.$store
                    .dispatch("degrees/fetchDegrees", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}degrees/${id}?withDegreeDetail=1`,
                    })
                    .then((res) => {
                        this.$store.commit("degrees/setForm", {
                            id,
                            degree_image: res.data.data.degree_image,
                        });

                        this.$store.commit("degrees/setImage", res.data.data.image);

                        this.$store.commit(
                            "degrees/setOrder",
                            res.data.data.order
                        );
                        this.$store.commit("degrees/setUrl", res.data.data.url);
                        if (res.data.data.degree_image) {
                            this.convertImgUrlToBase64(
                                res.data.data.degree_image.full_path,
                                `image/${res.data.data.degree_image.extension}`
                            );
                        }
                        let data =
                            res.data.data && res.data.data.degree_detail
                                ? res.data.data.degree_detail
                                : [];
                        let obj = {};
                        data.map((res) => {
                            obj["name_" + res.language_id] = res.name;
                        });
                        this.$store.commit("degrees/setName", obj);
                        let obj1 = {};
                        data.map((res) => {
                            obj1["description_" + res.language_id] =
                                res.description;
                        });
                        this.$store.commit("degrees/setDescription", obj1);
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
                        formData.append("type", "degree_image");

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
            this.$store.commit("degrees/setForm", {
                degree_image: file.serverId,
                id: this.$route.params.id ? this.$route.params.id : "",
            });
            if (this.validationErros.has("degree_image")) {
                this.validationErros.clear("degree_image");
            }
        },
        handleFilePondFlagIconRemoveFile(error, file) {
            this.$store.commit("degrees/setForm", {
                degree_image: null,
            });
            if (this.validationErros.has("degree_image")) {
                this.validationErros.clear("degree_image");
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
        this.$store.commit("degrees/resetForm");
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
                this.$store.commit("degrees/setName", obj);
                let obj1 = {};
                data.map((res) => {
                    obj1["description_" + res.id] = "";
                });
                this.$store.commit("degrees/setDescription", obj1);
                if (this.$route.params.id) {
                    this.fetchDegrees();
                } else {
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
