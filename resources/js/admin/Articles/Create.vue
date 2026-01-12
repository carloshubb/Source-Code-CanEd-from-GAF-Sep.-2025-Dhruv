<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">{{ isFormEdit ? 'Edit' : 'Create' }} article</h1>
                        <router-link :to="{ name: 'admin.articles.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <header class="mt-3">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <p class="block text-base lg:text-lg font-FuturaMdCnBT text-primary">
                            Select language(s) of the article
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
                                validationErros.has(`name.name_${language.id}`)
                                    ? 'bg-red-600 text-white hover:text-white'
                                    : '',
                            ]">{{ language.name }}</a>
                        </li>
                    </ul>
                </div>
                <div class="flex justify-end mt-5">
                    <p class="font-semibold text-red-500">
                        * Indicates required fields
                    </p>
                </div>
                <div class="grid mt-5 md:grid-cols-2 md:gap-6" v-for="language in languages" :key="language.id" :class="(activeTab == null && language.is_default) ||
                    activeTab == language.id
                    ? 'block'
                    : 'hidden'
                    ">
                    <div class="relative z-0 w-full group md:col-span-2">
                        <label for="name" class="block text-base lg:text-lg">Article’s title<span
                                class="text-primary">*</span></label>
                        <input type="text" name="name" id="name"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleNameInput($event.target.value, language)" :value="form['name'] && form['name'][`name_${language.id}`]
                                ? form['name'][`name_${language.id}`]
                                : ''
                                " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`name.name_${language.id}`)"
                            v-text="validationErros.get(`name.name_${language.id}`)"></p>
                    </div>
                    <div class="relative z-0 w-full group md:col-span-2" v-if="isDataLoaded">
                        <!-- <div
                        class="mt-5"
                        :id="'short_description_' + language.id"
                    ></div> -->
                        <label for="short_description" class="block text-base lg:text-lg">Article resume<span
                                class="text-primary">*</span></label>
                        <editor @selectionChange="
                            handleSelectionChange(
                                language,
                                'short_description'
                            )
                            " :ref="`short_description_${language.id}`" :id="`short_description_${language.id}`"
                            :initial-value="form[`short_description`][`short_description_${language?.id}`]
                                " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc"
                            placeholder="Write a short summary of your article; in 50 words or less. This resume will appear next to the title of your article on the search results page and will help you attract visitors" />

                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `short_description.short_description_${language.id}`
                            )
                        " v-text="validationErros.get(
                            `short_description.short_description_${language.id}`
                        )
                            "></p>
                    </div>
                    <div class="relative z-0 w-full group mt-4 md:col-span-2" v-if="isDataLoaded">
                        <label for="name" class="block text-base lg:text-lg">Description<span
                                class="text-primary">*</span></label>
                        <!-- <div class="mt-5" :id="'editor_' + language.id"></div> -->
                        <editor @selectionChange="
                            handleSelectionChange(
                                language,
                                'description'
                            )
                            " :ref="`description_${language.id}`" :id="`description_${language.id}`" :initial-value="form[`description`][`description_${language?.id}`]
                                " :init="descriptionEditorConfig" :tinymce-script-src="tinymceScriptSrc"
                            placeholder="Write your article here. Max. 2,000 words" />

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
                        <label for="name" class="block text-base lg:text-lg">Category type<span
                                class="text-primary">*</span></label>
                        <select
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleTypeInput($event.target.value)" v-model="type">
                            <option value="">Select</option>
                            <option :value="`article`" :selected="form?.type === 'article'
                                ">
                                Article
                            </option>
                            <option :value="`video`" :selected="form?.type === `video`
                                ">
                                Video
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('type')"
                            v-text="validationErros.get('type')"></p>
                    </div> -->
                    <div class="relative z-0 w-full group">
                        <label for="name" class="block text-base lg:text-lg">Category type<span class="text-primary">*</span></label>
                        <select
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @change="handleTypeInput($event.target.value)" 
                            v-model="type">
                            <option value="">Select</option>
                            <option value="article">Article</option>
                            <option value="video">Video</option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('type')" v-text="validationErros.get('type')"></p>
                    </div>
                    <div v-if="form?.type" class="relative z-10 w-full group">
                        <label for="article_category" class="block text-base lg:text-lg">Topic / category<span
                                class="text-primary">*</span></label>
                        <!-- <Select2 :class="dropdownClass" v-model="article_category" :options="local_categories"
                            @select="handleCategoryChange" :settings="{ width: '100%' }" /> -->
                            <v-select
                            :class="dropdownClass"
                            v-model="article_category"
                            :options="local_categories"
                            @update:modelValue="handleCategoryChange"
                            label="text"
                            :reduce="option => option.id"
                        ></v-select>
                    
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('article_category_id')"
                            v-text="validationErros.get('article_category_id')"></p>
                    </div>
                    <div class="relative z-10 w-full group" v-if="sub_local_categories?.length > 0">
                        <label for="sub_article_category" class="block text-base lg:text-lg">Sub topic / category<span
                                class="text-primary">*</span></label>
                        <!-- <Select2 :class="dropdownClass" v-model="sub_article_category" :options="sub_local_categories"
                            @select="handleSubCategoryChange" :settings="{ width: '100%' }" /> -->
                            <v-select
                            :class="dropdownClass"
                            v-model="sub_article_category"
                            :options="sub_local_categories"
                            @update:modelValue="handleSubCategoryChange"
                            label="text"
                            :reduce="option => option.id"
                        ></v-select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('article_category_id')"
                            v-text="validationErros.get('article_category_id')"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="original_source" class="block text-base lg:text-lg">Original source</label>
                        <input type="text" name="original_source" id="original_source"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-2 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleOS($event.target.value)" :value="form['original_source']
                                ? form['original_source']
                                : ''
                                " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`original_source`)"
                            v-text="validationErros.get(`original_source`)"></p>
                    </div>

                    <div class="relative z-0 w-full mt-2">
                        <label for="keyword" class="block text-base lg:text-lg mb-2">Keyword<span
                                class="text-primary">*</span></label>
                        <textarea rows="2" name="keyword" id="keyword"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder="Enter up to 5 keywords or keyphrases, separated by commas. These are extremely useful when users are searching for articles in topics similar to yours. So be specific and target your audience as well as you can If you are unsure of what to include, here is an example: you have a family-run business that produces homemade candles. Your suggested keywords or key phrases may look something like this: candles, homemade, family-run business, traditional, made to order As you can see, the example includes 5 keywords / keyphrases that highlight the main features of the product"
                            @input="handleKeyeword($event.target.value, 'keyword')"
                            :value="form['keyword'] ? form['keyword'] : ''"></textarea>
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `keyword`
                            )
                        " v-text="validationErros.get(
                            `keyword`
                        )
                            "></p>
                    </div>

                    <div class="relative z-0 w-full mb-6 group">
                        <label for="article_image" class="block text-base lg:text-lg">Article main image
                            <span class="text-primary">*</span></label>
                        <FilePond name="article_image" class-name="my-pond" accepted-file-types="image/*"
                            @init="handleFilePondInit" @processfile="handleFilePondFlagIconProcess"
                            @removefile="handleFilePondFlagIconRemoveFile" />
                        <p>(Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)</p>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('article_image')"
                            v-text="validationErros.get('article_image')"></p>
                    </div>
                </div>
                <div class="mb-5">
                    <h1 class="block text-base lg:text-lg">Article written by</h1>
                    <div class="relative z-0 w-full group">
                        <label for="name_title" class="block text-base lg:text-lg">Name and title</label>
                        <input type="text" name="name_title" id="name_title"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-2 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleName($event.target.value)" :value="form['name_title']
                                ? form['name_title']
                                : ''
                                " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`name_title`)"
                            v-text="validationErros.get(`name_title`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="organization" class="block text-base lg:text-lg">Organization</label>
                        <input type="text" name="organization" id="organization"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-2 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleOrganization($event.target.value)" :value="form['organization']
                                ? form['organization']
                                : ''
                                " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`organization`)"
                            v-text="validationErros.get(`organization`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="website" class="block text-base lg:text-lg">Website</label>
                        <input type="text" name="website" id="website"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-2 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleWebsite($event.target.value)" :value="form['website']
                                ? form['website']
                                : ''
                                " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`website`)"
                            v-text="validationErros.get(`website`)"></p>
                    </div>
                </div>

                <ListErrors :validationErrors="validationErros" />

                <!-- <div class="grid md:grid-cols-2 md:gap-6"> -->
                <div class="flex justify-center">
                    <button type="submit" class="can-edu-btn-fill mb-2">Submit</button>
                </div>
                <!-- </div> -->
            </form>
        </div>
    </AppLayout>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
// Import filepond
import Select2 from "vue3-select2-component";
import vSelect from "vue-select";
import 'vue-select/dist/vue-select.css';
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
            isFormEdit: (state) => state.articles.isFormEdit,
            form: (state) => state.articles.form,
            validationErros: (state) => state.articles.validationErros,
            languages: (state) => state.languages.languages,
            article_categories: (state) =>
                state.article_categories.article_categories,
        }),
    },
    watch: {
    'form.type': {
        handler(newVal) {
            if (newVal) {
                this.type = newVal;
            }
        },
        immediate: true
    }
},
    data() {
        return {
            type:'',
            activeTab: null,
            article_category: "",
            sub_article_category: "",
            selected_image: "",
            local_categories: [],
            sub_local_categories: [],
            dropdownClass:
                "block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent  appearance-none dark:text-white focus:outline-none focus:ring-0 peer",
            isDataLoaded: false,
            editorConfig: {
                height: 250,
                menubar: false,
                elementpath: false,
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen',
                setup: function (editor) {
                    var max = 50;
                    editor.on('keypress', function (event) {
                        var numChars = tinymce.activeEditor.plugins.wordcount.body.getWordCount();
                        if (numChars >= max) {
                            //alert("Maximum " + max + " characters allowed.");
                            event.preventDefault();
                            return false;
                        }
                    });
                }
            },
            descriptionEditorConfig: {
                height: 250,
                menubar: false,
                elementpath: false,
                plugins:
                    "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code wordcount",
                toolbar:
                    "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen",
                setup: function (editor) {
                    var max = 2000;
                    editor.on('keypress', function (event) {
                        var numChars = tinymce.activeEditor.plugins.wordcount.body.getWordCount();
                        if (numChars >= max) {
                            //alert("Maximum " + max + " characters allowed.");
                            event.preventDefault();
                            return false;
                        }
                    });
                }
            },
            tinymceScriptSrc: "/plugins/tinymce/tinymce.min.js",
        };
    },
    methods: {
        handleTypeInput(value) {
            this.$store.commit("articles/setType", value);
            this.$store
                .dispatch("article_categories/fetchArticleCategories", {
                    url: `${process.env.MIX_ADMIN_API_URL}article_categories?q=1&type=${value}`,
                })
                .then((res) => {
                    if (res?.data?.data?.length > 0) {
                        this.local_categories = [];
                        for (var i = 0; i < res?.data?.data?.length; i++) {
                            if (res?.data?.data[i].parent_id == null) {
                                this.local_categories.push({
                                    id: parseInt(res?.data?.data[i].id),
                                    text:
                                        res?.data?.data[i]
                                            ?.article_category_detail
                                            ?.length > 0
                                            ? res?.data?.data[i]
                                                ?.article_category_detail[0]
                                                ?.name
                                            : "abc",
                                });
                            }
                        }
                    }
                });
        },
        handleOS(value) {
            this.$store.commit("articles/setOriginalSource", value);
        },
        handleName(value) {
            this.$store.commit("articles/setNameTitle", value);
        },
        handleKeyeword(value) {
            this.$store.commit("articles/setKeyword", value);
        },
        handleOrganization(value) {
            this.$store.commit("articles/setOrganization", value);
        },
        handleWebsite(value) {
            this.$store.commit("articles/setWebsite", value);
        },
        // handleSelectionChange(language, key) {
        //     if (key === 'description') {
        //         this.$store.commit(`articles/updateDescription`, {
        //             description: tinymce.get(`${key}_${language.id}`).getContent(),
        //             id: language.id,
        //         });
        //     }
        //     else if (key === 'short_description') {
        //         this.$store.commit(`articles/updateShortDescription`, {
        //             short_description: tinymce.get(`${key}_${language.id}`).getContent(),
        //             id: language.id,
        //         });
        //         const fieldName = `short_description.short_description_${language.id}`;
        // if (this.validationErros.has(fieldName)) {
        //     this.validationErros.clear(fieldName);
        // }
        //     }
        // },
        handleSelectionChange(language, key) {
            const content = tinymce.get(`${key}_${language.id}`).getContent().trim();

            if (key === 'description') {
                this.$store.commit(`articles/updateDescription`, {
                    description: content,
                    id: language.id,
                });

                const fieldName = `description.description_${language.id}`;
                if (this.validationErros.has(fieldName) && content.length > 0) {
                    this.validationErros.clear(fieldName);
                }
            } else if (key === 'short_description') {
                this.$store.commit(`articles/updateShortDescription`, {
                    short_description: content,
                    id: language.id,
                });

                const fieldName = `short_description.short_description_${language.id}`;
                if (this.validationErros.has(fieldName) && content.length > 0) {
                    this.validationErros.clear(fieldName);
                }
            }
        },

        handleNameInput(value, language) {
            this.$store.commit("articles/updateName", {
                name: value,
                id: language.id,
            });
            const fieldName = `name.name_${language.id}`;
            if (this.validationErros.has(fieldName)) {
                this.validationErros.clear(fieldName);
            }
        },
        handleSubCategoryChange(data) {
            this.$store.commit("articles/setForm", {
                key: "article_category_id",
                value: data
            });
        },
        handleCategoryChange(data) {
            this.sub_local_categories = [];
            for (var i = 0; i < this?.article_categories?.length; i++) {
                if (this?.article_categories[i].parent_id == data) {
                    this.sub_local_categories.push({
                        id: parseInt(this?.article_categories[i].id),
                        text:
                            this?.article_categories[i]?.article_category_detail
                                ?.length > 0
                                ? this?.article_categories[i]
                                    ?.article_category_detail[0]?.name
                                : "abc",
                    });
                }
            }
            this.$store.commit("articles/setForm", {
                key: "article_category_id",
                value: data
            });
            if (this.validationErros.has("article_category_id")) {
                this.validationErros.clear("article_category_id");
            }
        },
        addUpdateForm() {
            this.$store
                .dispatch("articles/addUpdateForm")
                .then(() => {
                    this.$router.push({ name: "admin.articles.index" });
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
        fetchArticles() {
            console.log(this.$route.params.id)
            if (this.$route.params.id) {
                let id = this.$route.params.id;
                this.$store.commit("articles/setIsFormEdit", 1);
                this.$store
                    .dispatch("articles/fetchArticles", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}articles/${id}?withArticleDetail=1`,
                    })
                    .then((res) => {
                        console.log('article category res', res);
                        this.$store.commit("articles/setForm", {
                            key: "type",
                            value: res.data.data.type, // Assign the type from the response
                        });
                        this.$nextTick(() => {
                    this.type = res.data.data.type;
                    console.log("Type set to:", this.type);
                });
                
                        // this.type = this.form.type
                        console.log("Form Type After API Fetch:", this.form.type);
                        this.$store.commit(
                            "articles/setOriginalSource",
                            res.data.data.original_source
                        );
                        this.$store.commit(
                            "articles/setNameTitle",
                            res.data.data.name_title
                        );
                        this.$store.commit(
                            "articles/setOrganization",
                            res.data.data.organization
                        );
                        this.$store.commit(
                            "articles/setWebsite",
                            res.data.data.website
                        );
                        this.$store.commit(
                            "articles/setKeyword",
                            res.data.data.keyword
                        );

                        setTimeout(() => {
                            this.sub_local_categories = [];
                            // for (
                            //     var i = 0;
                            //     i < this.article_categories?.length;
                            //     i++
                            // ) {
                            //     if (
                            //         parseInt(this?.article_categories[i].id) ==
                            //         parseInt(res.data.data.article_category_id)
                            //     ) {
                            //         if (
                            //             this?.article_categories[i]
                            //                 ?.parent_id == null
                            //         ) {
                            //             this.article_category = parseInt(
                            //                 res.data.data.article_category_id
                            //             );
                            //             console.log('article category', res.data.data.article_category_id);

                            //         } else {
                            //             this.article_category =
                            //                 this?.article_categories[
                            //                     i
                            //                 ]?.parent_id;
                            //             this.sub_article_category = parseInt(
                            //                 res.data.data.article_category_id
                            //             );
                            //             console.log('subarticle category', res.data.data.article_category_id);
                            //         }
                            //     }
                            // }
                            for (let i = 0; i < this.article_categories?.length; i++) {
                        if (parseInt(this.article_categories[i].id) === parseInt(res.data.data.article_category_id)) {
                            if (this.article_categories[i]?.parent_id == null) {
                                // Set the article_category to the matching object
                                this.article_category = this.local_categories.find(
                                    cat => cat.id === parseInt(res.data.data.article_category_id)
                                );
                            } else {
                                // Set the article_category to the parent category
                                this.article_category = this.local_categories.find(
                                    cat => cat.id === parseInt(this.article_categories[i]?.parent_id)
                                );
                                // Set the sub_article_category to the matching subcategory
                                this.sub_article_category = this.sub_local_categories.find(
                                    cat => cat.id === parseInt(res.data.data.article_category_id)
                                );
                            }
                        }
                    }

                            setTimeout(() => {
                                for (
                                    var i = 0;
                                    i < this.article_categories?.length;
                                    i++
                                ) {
                                    if (
                                        this?.article_categories[i].parent_id !=
                                        null &&
                                        parseInt(
                                            this?.article_categories[i]
                                                .parent_id
                                        ) == parseInt(this.article_category)
                                    ) {
                                        this.sub_local_categories.push({
                                            id: this?.article_categories[i].id,
                                            text:
                                                this?.article_categories[i]
                                                    ?.article_category_detail
                                                    ?.length > 0
                                                    ? this?.article_categories[
                                                        i
                                                    ]
                                                        ?.article_category_detail[0]
                                                        ?.name
                                                    : "abc",
                                        });
                                    }
                                }
                            }, 500);
                        }, 1000);

                        this.selected_image = res.data.data.article_image;
                        this.$store.commit("articles/setForm", {
                            key: "article_category_id",
                            value: res.data.data.article_category_id
                        });
                        this.$store.commit("articles/setForm", {
                            key: "type",
                            value: res.data.data.type, // Assign the type from the response
                        });
                        console.log("Form Type After API Fetch:", this.form.type);
                        this.$store.commit("articles/setForm", {
                            key: "id",
                            value: id
                        });
                        this.$store.commit("articles/setForm", {
                            key: "article_image",
                            value: res.data.data.article_image,
                        });

                        if (res.data.data.article_image) {
                            this.convertImgUrlToBase64(
                                res.data.data.article_image.full_path,
                                `image/${res.data.data.article_image.extension}`
                            );
                        }
                        let data =
                            res.data.data && res.data.data.article_detail
                                ? res.data.data.article_detail
                                : [];

                        let obj = {};
                        data.map((res) => {
                            obj["name_" + res.language_id] = res.name;
                        });
                        this.$store.commit("articles/setName", obj);
                        let d = {};
                        data.map((res, key) => {
                            d["description_" + res.language_id] =
                                res.description;
                        });
                        this.$store.commit("articles/setDescription", d);
                        let sd = {};
                        data.map((res) => {
                            sd["short_description_" + res.language_id] =
                                res.short_description;
                        });
                        this.$store.commit(
                            "articles/setShortDescription",
                            sd
                        );
                        let sp = {};
                        data.map((res) => {
                            sd["type_" + res.language_id] =
                                res.type;
                        });
                        this.$store.commit(
                            "articles/setType",
                            sp
                        );
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
                        formData.append("type", "article_image");

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
            this.$store.commit("articles/setForm", {
                key: 'article_image',
                value: file.serverId
            });
            if (this.validationErros.has("article_image")) {
                this.validationErros.clear("article_image");
            }
        },
        handleFilePondFlagIconRemoveFile(error, file) {
            this.$store.commit("articles/setForm", {
                key: 'article_image',
                value: null
            });
            if (this.validationErros.has("article_image")) {
                this.validationErros.clear("article_image");
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
        this.$store.commit("articles/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                let sd = {};
                let d = {};
                data.map((res, i) => {
                    obj["name_" + res.id] = "";
                    d["description_" + res.id] = "";
                    sd["short_description_" + res.id] = "";
                });
                this.$store.commit("articles/setName", obj);
                this.$store.commit("articles/setShortDescription", sd);
                this.$store.commit("articles/setDescription", d);
                this.$store.commit("article_categories/setLimit", 20000);
                this.$store.commit("article_categories/setSortBy", "id");
                this.$store.commit("article_categories/setSortType", "desc");
                this.$store
                    .dispatch("article_categories/fetchArticleCategories")
                    .then((res) => {
                        if (res?.data?.data?.length > 0) {
                            this.local_categories = [];
                            for (var i = 0; i < res?.data?.data?.length; i++) {
                                if (res?.data?.data[i].parent_id == null) {
                                    this.local_categories.push({
                                        id: parseInt(res?.data?.data[i].id),
                                        text:
                                            res?.data?.data[i]
                                                ?.article_category_detail
                                                ?.length > 0
                                                ? res?.data?.data[i]
                                                    ?.article_category_detail[0]
                                                    ?.name
                                                : "abc",
                                    });
                                }
                            }
                        }
                    });
                if (this.$route.params.id) {
                    this.fetchArticles();
                }
                else {
                    this.isDataLoaded = 1;
                }
            });
    },
    components: {
        FilePond,
        editor: Editor,
        Select2,
        vSelect ,
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
