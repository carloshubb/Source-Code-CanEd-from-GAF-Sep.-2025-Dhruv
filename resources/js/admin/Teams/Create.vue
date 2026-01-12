<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">
                            {{ isFormEdit ? "Edit" : "Create a new" }} team member
                        </h1>
                        <router-link :to="{ name: 'admin.teams.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <header class="mt-3">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
                            Select language(s) of the team member
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
                    <div class="relative z-0 w-full group">
                        <label for="name" class="block text-base lg:text-lg">Name<span class="text-primary">*</span></label>
                        <input type="text" name="name" id="name"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleMultipleInput(
                                    'name',
                                    $event.target.value,
                                    language
                                )
                                " :value="form['name'] && form['name'][`name_${language.id}`]
                                    ? form['name'][`name_${language.id}`]
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`name.name_${language.id}`)"
                            v-text="validationErros.get(`name.name_${language.id}`)"></p>
                    </div>



                    <div class="relative z-0 w-full group">
                        <label for="title" class="block text-base lg:text-lg">Mini Bio<span class="text-primary">*</span></label>
                        <textarea type="text" name="title" id="title"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder="Max 30 Words" @input="
                                handleMultipleInput(
                                    'title',
                                    $event.target.value,
                                    language
                                )
                                " :value="form['title'] &&
                                    form['title'][`title_${language.id}`]
                                    ? form['title'][`title_${language.id}`]
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`title.title_${language.id}`)"
                            v-text="validationErros.get(`title.title_${language.id}`)
                                "></p>
                    </div>



                    <div class="relative z-0 w-full group">
                        <label for="status" class="block text-base lg:text-lg">Status<span class="text-primary">*</span></label>
                        <select
                        name="status"
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
                        <label for="image" class="block text-base lg:text-lg">Image<span class="text-primary">*</span></label>
                        <FilePond name="image" class-name="my-pond" accepted-file-types="image/*"
                            @init="handleFilePondInit" @processfile="handleFilePondFlagIconProcess"
                            @removefile="handleFilePondFlagIconRemoveFile" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('image')"
                            v-text="validationErros.get('image')"></p>
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

import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            isFormEdit: (state) => state.teams.isFormEdit,
            form: (state) => state.teams.form,
            validationErros: (state) => state.teams.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            activeTab: null,
        };
    },
    methods: {
        handleInput(value, key) {
            this.$store.commit("teams/setState", { key, value });
            if (value.trim()) {
                this.validationErros.clear(key);
            }
        },
        handleMultipleInput(key, value, language) {
            this.$store.commit("teams/updateState", {
                value: value,
                id: language.id,
                key,
            });
            const errorKey = `${key}.${key}_${language.id}`;
            if (value.trim()) {
                this.validationErros.clear(errorKey);
            }
        },
        addUpdateForm() {
            this.$store
                .dispatch("teams/addUpdateForm")
                .then(() => this.$router.push({ name: "admin.teams.index" }
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
        fetchTeams() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("teams/setIsFormEdit", 1);
                this.$store
                    .dispatch("teams/fetchTeams", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}teams/${id}?withTeamDetail=1`,
                    })
                    .then((res) => {
                        console.log('team res', res);
                        let keys = ["image", "status"];
                        this.$store.commit("teams/setState", {
                            key: "id",
                            value: id,
                        });
                        for (var i = 0; i < keys.length; i++) {
                            this.$store.commit("teams/setState", {
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
                        // if (res.data.data.image) {
                        //     this.convertImgUrlToBase64(
                        //         res.data.data.image.full_path,
                        //         `image/${res.data.data.image.extension}`
                        //     ).then((base64String) => {
                        //         // Wrap base64 string in a JSON object and stringify it
                        //         const imagePayload = JSON.stringify({ path: base64String });

                        //         // Commit the properly formatted JSON string to Vuex state
                        //         this.$store.commit("teams/setState", {
                        //             key: "image",
                        //             value: imagePayload,
                        //         });

                        //         console.log("Image Payload (to be sent):", imagePayload);
                        //     }).catch((error) => {
                        //         console.error("Error converting image to Base64:", error);
                        //     });
                        // } else {
                        //     console.error("Image data is missing in the response.");
                        // }

                        let data =
                            res.data.data && res.data.data.team_detail
                                ? res.data.data.team_detail
                                : [];
                        let obj = {};
                        data.map((res) => {
                            obj["title_" + res.language_id] = res.title;
                        });
                        this.$store.commit("teams/setState", {
                            key: "title",
                            value: obj,
                        });

                        data.map((res) => {
                            obj["name_" + res.language_id] = res.name;
                        });
                        this.$store.commit("teams/setState", {
                            key: "name",
                            value: obj,
                        });
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
                                console.log('responsetxt', request.responseText);
                            } else {
                                error("oh no");
                            }
                        };
                        // request.onload = function () {
                        //     if (request.status >= 200 && request.status < 300) {
                        //         try {
                        //             const jsonResponse = JSON.parse(request.responseText);
                        //             console.log('Upload response:', jsonResponse);
                        //             if (jsonResponse && jsonResponse.success) {
                        //                 load(jsonResponse); // pass response to load method
                        //             } else {
                        //                 error("Image upload failed.");
                        //             }
                        //         } catch (e) {
                        //             // If the response is not JSON, log the raw response
                        //             console.error("Response is not JSON:", request.responseText);
                        //             error("Failed to parse response as JSON.");
                        //         }
                        //     } else {
                        //         console.error('Request failed with status:', request.status);
                        //         error("Error uploading image.");
                        //     }
                        // };


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
            this.$store.commit("teams/setForm", {
                image: file.serverId,
                id: this.$route.params.id ? this.$route.params.id : "",
            });
            if (this.validationErros.has("image")) {
                this.validationErros.clear("image");
            }
        },
        handleFilePondFlagIconRemoveFile(error, file) {
            this.$store.commit("teams/setForm", {
                image: null,
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
        this.$store.commit("teams/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["title_" + res.id] = "";
                });
                this.$store.commit("teams/setState", {
                    key: "title",
                    value: obj,
                });
                data.map((res) => {
                    obj["name_" + res.id] = "";
                });
                this.$store.commit("teams/setState", {
                    key: "name",
                    value: obj,
                });
                this.fetchTeams();
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
