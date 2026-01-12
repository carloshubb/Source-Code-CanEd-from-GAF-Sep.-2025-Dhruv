<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">{{ isFormEdit ? 'Edit' : 'Create' }} banner</h1>
                        <router-link :to="{ name: 'admin.banners.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <header class="mt-3">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
                            Select language(s) of the banner
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
                                    `name.name_${language.id}`
                                ) ||
                                    validationErros.has(
                                        `banner_description.banner_description_${language.id}`
                                    ) ||
                                    validationErros.has(
                                        `banner_button_text.banner_button_text_${language.id}`
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
                    <div class="relative z-0 w-full group">
                        <label for="title" class="block text-base lg:text-lg">Banner Title<span class="text-primary">*</span></label>
                        <input type="text" name="title" id="title"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleTitleInput($event.target.value, language)" :value="form['title'] &&
                                form['title'][`title_${language.id}`]
                                ? form['title'][`title_${language.id}`]
                                : ''
                                " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`title.title_${language.id}`)"
                            v-text="validationErros.get(`title.title_${language.id}`)
                                "></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="banner_button_text" class="block text-base lg:text-lg">Banner Button Text<span class="text-primary">*</span></label>
                        <input type="text" name="banner_button_text" id="banner_button_text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleBannerButtonTextInput(
                                    $event.target.value,
                                    language
                                )
                                " :value="form['banner_button_text'] &&
                                    form['banner_button_text'][
                                    `banner_button_text_${language.id}`
                                    ]
                                    ? form['banner_button_text'][
                                    `banner_button_text_${language.id}`
                                    ]
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `banner_button_text.banner_button_text_${language.id}`
                            )
                        " v-text="validationErros.get(
                            `banner_button_text.banner_button_text_${language.id}`
                        )
                            "></p>
                    </div>
                    <div class="relative z-0 w-full group md:col-span-2">
                        <label for="banner_description" class="block text-base lg:text-lg">Banner Description<span class="text-primary">*</span></label>
                        <textarea name="banner_description" id="banner_description"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleBannerDescriptionInput(
                                    $event.target.value,
                                    language
                                )
                                "
                            v-text="form?.['banner_description']?.[`banner_description_${language.id}`]"></textarea>
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `banner_description.banner_description_${language.id}`
                            )
                        " v-text="validationErros.get(
                            `banner_description.banner_description_${language.id}`
                        )
                            "></p>
                    </div>

                </div>


                <!-- grid my-5 md:grid-cols-2 md:gap-6 -->
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="banner_type" class="block text-base lg:text-lg">Banner button type<span class="text-primary">*</span></label>
                        <select name="banner_type"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInputChange(
                                    $event.target.value,
                                    'banner_type'
                                )
                                ">
                            <option value="">Select</option>
                            <option :selected="form['banner_type'] == 'banner_1'" value="banner_1">
                                Banner 1
                            </option>
                            <option :selected="form['banner_type'] == 'banner_2'" value="banner_2">
                                Banner 2
                            </option>
                            <option :selected="form['banner_type'] == 'banner_3'" value="banner_3">
                                Banner 3
                            </option>
                        </select>

                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`banner_type`)"
                            v-text="validationErros.get(`banner_type`)"></p>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="banner_button_link" class="block text-base lg:text-lg">Banner Button Link<span class="text-primary">*</span></label>
                        <input type="text" name="banner_button_link" id="banner_button_link"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInputChange(
                                    $event.target.value,
                                    'banner_button_link'
                                )
                                " :value="form?.banner_button_link" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`banner_button_link`)"
                            v-text="validationErros.get(`banner_button_link`)"></p>
                    </div>
                    <div class="relative z-0 w-full mb-4 group">
                        <img v-if="form?.banner_image?.full_path" :src="form?.banner_image?.full_path" />
                        <br />
                        <FilePond name="banner_image" class-name="my-pond" accepted-file-types="image/*"
                            @init="handleFilePondInit" @processfile="handleFilePondFlagIconProcess"
                            @removefile="handleFilePondFlagIconRemoveFile" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('banner_image')"
                            v-text="validationErros.get('banner_image')"></p>
                    </div>
                    <div class="relative z-0 w-full mb-4 group">
                        <img v-if="form?.banner_image_2?.full_path" :src="form?.banner_image_2?.full_path" />
                        <br />
                        <FilePond name="banner_image_2" class-name="my-pond" accepted-file-types="image/*"
                            @init="handleFilePondInit" @processfile="handleFilePondFlagIconProcess2"
                            @removefile="handleFilePondFlagIconRemoveFile2" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('banner_image_2')"
                            v-text="validationErros.get('banner_image_2')"></p>
                    </div>
                </div>
                <ListErrors :validationErrors="validationErros" />

                <button type="submit" class="can-edu-btn-fill mb-2">Submit</button>
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
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            isFormEdit: (state) => state.banners.isFormEdit,
            form: (state) => state.banners.form,
            validationErros: (state) => state.banners.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            activeTab: null,
        };
    },
    methods: {
        handleTitleInput(value, language) {
            this.$store.commit("banners/updateTitle", {
                title: value,
                id: language.id,
            });
            const errorKey = `title.title_${language.id}`;
            if (this.validationErros.has(errorKey)) {
                this.validationErros.clear(errorKey);
            }
        },
        handleBannerDescriptionInput(value, language) {
            this.$store.commit("banners/updateBannerDescription", {
                banner_description: value,
                id: language.id,
            });
            const errorKey = `banner_description.banner_description_${language.id}`;
            if (this.validationErros.has(errorKey)) {
                this.validationErros.clear(errorKey);
            }
        },
        handleBannerButtonTextInput(value, language) {
            this.$store.commit("banners/updateBannerButtonText", {
                banner_button_text: value,
                id: language.id,
            });
            const errorKey = `banner_button_text.banner_button_text_${language.id}`;
            if (this.validationErros.has(errorKey)) {
                this.validationErros.clear(errorKey);
            }
        },
        handleInputChange(value, key) {
            this.$store.commit("banners/setForm", {
                key,
                value,
            });
            if (this.validationErros.has(key)) {
                this.validationErros.clear(key);
            }
        },
        addUpdateForm() {
            this.$store
                .dispatch("banners/addUpdateForm")
                .then(() => this.$router.push({ name: "admin.banners.index" }
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
        fetchBanners() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("banners/setIsFormEdit", 1);
                this.$store
                    .dispatch("banners/fetchBanners", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}banners/${id}?withBannerDetail=1`,
                    })
                    .then((res) => {
                        this.$store.commit("banners/setForm", {
                            key: "id",
                            value: id,
                        });
                        this.$store.commit("banners/setForm", {
                            key: "banner_image",
                            value: res?.data?.data?.banner_image,
                        });
                        this.$store.commit("banners/setForm", {
                            key: "banner_image_2",
                            value: res?.data?.data?.banner_image_2,
                        });
                        this.$store.commit("banners/setForm", {
                            key: "banner_type",
                            value: res?.data?.data?.banner_type,
                        });
                        this.$store.commit("banners/setForm", {
                            key: "banner_button_link",
                            value: res?.data?.data?.banner_button_link,
                        });
                        let data =
                            res.data.data && res.data.data.banner_detail
                                ? res.data.data.banner_detail
                                : [];
                        console.clear();
                        let obj = {};
                        data.map((res) => {
                            obj["banner_description_" + res.language_id] =
                                res.banner_description;
                        });
                        this.$store.commit("banners/setBannerDescription", obj);
                        obj = {};
                        data.map((res) => {
                            obj["banner_button_text_" + res.language_id] =
                                res.banner_button_text;
                        });
                        this.$store.commit("banners/setBannerButtonText", obj);

                        obj = {};
                        data.map((res) => {
                            obj["title_" + res.language_id] = res.title;
                        });
                        this.$store.commit("banners/setTitle", obj);
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
                        formData.append("type", "banner_image");

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
            this.$store.commit("banners/setForm", {
                key: "banner_image",
                value: file.serverId,
            });
            if (this.validationErros.has("banner_image")) {
                this.validationErros.clear("banner_image");
            }
        },
        handleFilePondFlagIconRemoveFile(error, file) {
            this.$store.commit("banners/setForm", {
                key: "banner_image",
                value: null,
            });
            if (this.validationErros.has("banner_image")) {
                this.validationErros.clear("banner_image");
            }
        },
        handleFilePondFlagIconProcess2(error, file) {
            this.$store.commit("banners/setForm", {
                key: "banner_image_2",
                value: file.serverId,
            });
            if (this.validationErros.has("banner_image_2")) {
                this.validationErros.clear("banner_image_2");
            }
        },
        handleFilePondFlagIconRemoveFile2(error, file) {
            this.$store.commit("banners/setForm", {
                key: "banner_image_2",
                value: null,
            });
            if (this.validationErros.has("banner_image_2")) {
                this.validationErros.clear("banner_image_2");
            }
        },
        // convertImgUrlToBase64(url, type) {
        //     var image = new Image();
        //     image.onload = function () {
        //         var canvas = document.createElement("canvas");
        //         canvas.width = image.width;
        //         canvas.height = image.height;

        //         canvas.getContext("2d").drawImage(this, 0, 0);

        //         canvas.toBlob(
        //             function (source) {
        //                 var newImg = document.createElement("img"),
        //                     url = URL.createObjectURL(source);

        //                 newImg.onload = function () {
        //                     URL.revokeObjectURL(url);
        //                 };

        //                 newImg.src = url;
        //             },
        //             type,
        //             1
        //         );
        //         let dataUrl = canvas.toDataURL(type);
        //         let files = [
        //             {
        //                 source: dataUrl,
        //                 options: {
        //                     type: "local",
        //                 },
        //             },
        //         ];
        //         setOptions({ files: files });
        //     };
        //     image.src = url;
        // },
    },
    created() {
        setOptions({ files: [] });
        this.$store.commit("banners/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["banner_description_" + res.id] = "";
                });
                this.$store.commit("banners/setBannerDescription", obj);

                obj = {};
                data.map((res) => {
                    obj["banner_button_text_" + res.id] = "";
                });
                this.$store.commit("banners/setBannerButtonText", obj);

                obj = {};
                data.map((res) => {
                    obj["title_" + res.id] = "";
                });
                this.$store.commit("banners/setTitle", obj);
                this.fetchBanners();
            });
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
