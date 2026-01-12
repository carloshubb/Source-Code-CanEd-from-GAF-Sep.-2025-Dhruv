<template>
    <div
        class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full"
    >
        <div class="mt-4 flex justify-between items-center gap-2 p-2">
            <h2 class="px-4 can-school-h2 text-primary">Edit Video</h2>
        </div>
        <div class="mt-6 w-full">
            <form class="py-4 px-4 bg-white" @submit.prevent="addUpdateForm()">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
                >
                    <ul class="flex gap-2 flex-wrap my-4">
                        <li
                            class="mr-2 mb-2"
                            v-for="language in languages"
                            :key="language.id"
                        >
                            <a
                                @click.prevent="changeLanguageTab(language)"
                                href="#"
                                :class="[
                                    'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                    (activeTab == null &&
                                        language.is_default) ||
                                    activeTab == language.id
                                        ? 'text-white bg-primary active'
                                        : '',
                                    validationErros.has(
                                        `title.title_${language.id}`
                                    )
                                        ? 'bg-red-600 text-white hover:text-white'
                                        : '',
                                ]"
                                >{{ language.name }}</a
                            >
                        </li>
                    </ul>
                </div>

                <div
                    class="w-full md:gap-6"
                    v-for="language in languages"
                    :key="language.id"
                    :class="
                        (activeTab == null && language.is_default) ||
                        activeTab == language.id
                            ? 'block'
                            : 'hidden'
                    "
                >
                    <div class="relative w-full mt-2">
                        <label for="title" class="block text-base lg:text-lg">Title</label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            placeholder=" "
                            @input="
                                handleTitleInput($event.target.value, language)
                            "
                            :value="
                                form['title'] &&
                                form['title'][`title_${language.id}`]
                                    ? form['title'][`title_${language.id}`]
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="
                                validationErros.has(`title.title_${language.id}`)
                            "
                            v-text="
                                validationErros.get(`title.title_${language.id}`)
                            "
                        ></p>
                    </div>
                </div>

                <div
                    class="w-full md:gap-6"
                    v-for="language in languages"
                    :key="language.id"
                    :class="
                        (activeTab == null && language.is_default) ||
                        activeTab == language.id
                            ? 'block'
                            : 'hidden'
                    "
                >
                <div class="relative w-full mt-2">
                    <label for="description" class="block text-base lg:text-lg mb-2">Description</label>
                        <div
                            class="mt-5"
                            :id="'description_' + language.id"
                        ></div>
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="
                                validationErros.has(
                                    `description.description_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `description.description_${language.id}`
                                )
                            "
                        ></p>
                    </div>
                </div>

                <div class="">
                    <div class="relative w-full mt-2">
                        <label for="link" class="block text-base lg:text-lg">Link</label>
                        <input
                            type="text"
                            name="link"
                            id="link"
                            class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            placeholder=" "
                            @input="handleLink($event.target.value)"
                            :value="
                                form['link']
                                    ? form['link']
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="validationErros.has(`link`)"
                            v-text="validationErros.get(`link`)"
                        ></p>
                    </div>
                </div>

                <button type="submit" class="can-edu-btn-fill my-4">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    props:['school_id','lang', 'slug','logged_in_customer',"video_id"],
    computed: {
        ...mapState({
            form: (state) => state.videos.form,
            validationErros: (state) => state.videos.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            activeTab: null,
        };
    },
    methods: {
        handleLink(value) {
            this.$store.commit("videos/setLink", value);
        },
        handleTitleInput(value, language) {
            this.$store.commit("videos/updateTitle", {
                title: value,
                id: language.id,
            });
        },
        addUpdateForm() {
            this.$store
                .dispatch("videos/addUpdateForm")
                .then(() => {
                    window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/videos";
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
                const ckeditorInstance = CKEDITOR?.instances[editorId];

                if (ckeditorInstance) {
                    console.log(`Focusing on CKEditor instance: ${editorId}`);
                    ckeditorInstance.focus();

                    const ckeditorContainer = ckeditorInstance.element?.$;
                    if (ckeditorContainer) {
                        console.log("Scrolling CKEditor container into view");
                        ckeditorContainer.scrollIntoView({ behavior: "smooth", block: "center" });
                    }
                    return;
                }

                const tinymceEditor = window.tinymce?.get(editorId);
                if (tinymceEditor) {
                    console.log(`Focusing on TinyMCE editor: ${editorId}`);
                    tinymceEditor.focus();

                    const tinymceContainer = tinymceEditor.getContainer();
                    if (tinymceContainer) {
                        console.log("Scrolling TinyMCE container into view");
                        tinymceContainer.scrollIntoView({ behavior: "smooth", block: "center" });
                    }
                    return;
                } else {
                    console.log(`No rich text editor instance found for ${editorId}`);
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
        fetchVideos() {
            if (this.video_id) {
                let id = this.video_id;
                this.$store.commit("videos/setIsFormEdit", 1);
                this.$store
                    .dispatch("videos/fetchVideos", {
                        id: id,
                        url: `${process.env.MIX_WEB_API_URL}videos/${id}?withVideoDetail=1`,
                    })
                    .then((res) => {
                        this.$store.commit(
                            "videos/setLink",
                            res.data.data.link
                        );

                        let data =
                            res.data.data && res.data.data.video_detail
                                ? res.data.data.video_detail
                                : [];

                        let obj = {};
                        data.map((res) => {
                            obj["title_" + res.language_id] = res.title;
                        });
                        this.$store.commit("videos/setTitle", obj);
                        setTimeout(() => {
                            let sd = {};
                            data.map((res) => {
                                CKEDITOR.instances[
                                    "description_" + res.language_id
                                ].setData(res.description);
                                sd["description_" + res.language_id] =
                                    res.description;
                            });
                            this.$store.commit(
                                "videos/setDescription",
                                sd
                            );
                        }, 1500);
                    });
            }
        },
    },
    created() {
        this.$store.commit("videos/resetForm");
        this.$store.commit("videos/setForm", {
            key: "customer_id",
            value: this.logged_in_customer,
        });
        this.$store.commit("videos/setForm", {
            key: "id",
            value: this.video_id,
        });
        this.$store.commit("videos/setForm", {
            key: "school_id",
            value: this.school_id,
        });
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_WEB_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                let sd = {};
                data.map((res, i) => {
                    CKEDITOR.replace("description_" + res.id);
                    obj["title_" + res.id] = "";
                });
                setTimeout(() => {
                    data.map((res, i) => {
                        sd["description_" + res.id] = "";
                        if (
                            CKEDITOR?.instances["description_" + res.id]
                        ) {
                            let ctx = this;
                            CKEDITOR.instances[
                                "description_" + res.id
                            ].on("change", function () {
                                let value =
                                    CKEDITOR.instances[
                                        "description_" + res.id
                                    ].getData();
                                ctx.$store.commit(
                                    "videos/updateDescription",
                                    {
                                        description: value,
                                        id: data[i].id,
                                    }
                                );
                            });
                        }
                    });
                }, 1000);
                this.$store.commit("videos/setTitle", obj);
                this.$store.commit("videos/setDescription", sd);
                this.fetchVideos();
            });
    },
};
</script>
