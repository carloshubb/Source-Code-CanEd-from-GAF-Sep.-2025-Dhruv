<template>
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full overflow-hidden">
        <div class="mt-4 flex justify-between items-center gap-2 p-2">
            <h2 class="px-4 can-school-h2 text-primary">Edit Article</h2>
        </div>
        <div class="mt-4 w-full">
            <form class="px-4 bg-white" @submit.prevent="addUpdateForm()">
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

                <div class="w-full md:gap-6" v-for="language in languages" :key="language.id" :class="(activeTab == null && language.is_default) ||
                        activeTab == language.id
                        ? 'block'
                        : 'hidden'
                    ">
                    <div class="relative w-full mt-2">
                        <label for="name" class="block text-base lg:text-lg">Article’s title</label>
                        <input type="text" name="name" id="name"
                            class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
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
                </div>

                <div class="w-full md:gap-6" v-for="language in languages" :key="language.id" :class="(activeTab == null && language.is_default) ||
                        activeTab == language.id
                        ? 'block'
                        : 'hidden'
                    ">
                    <div class="relative w-full mt-2" v-if="isDataShortDescriptionLoaded">
                        <label for="short_description" class="block text-base lg:text-lg mb-2">Article resume</label>
                        <editor @selectionChange="
                            handleSelectionChange(language, 'short_description')
                            " class="mt-2" placeholder="Write a short summary of your article; in 50 words or less. This resume will appear next to the title of your article on the search results page and will help you attract visitors" :ref="`short_description_${language.id}`" :id="`short_description_${language.id}`"
                            :initial-value="form[`short_description`][
                                `short_description_${language?.id}`
                            ]
                                " :init="shortDescriptionEditorConfig" :tinymce-script-src="tinymceScriptSrc" />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `short_description.short_description_${language.id}`
                            )
                        " v-text="validationErros.get(
                                `short_description.short_description_${language.id}`
                            )
                                "></p>
                    </div>
                </div>

                <div class="relative z-0 w-full group">
                    <label for="name" class="block text-base lg:text-lg">Category type<span
                            class="text-primary">*</span></label>
                    <select
                    name="type" class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        @input="handleTypeInput($event.target.value)" v-model="type">
                        <option value="" disabled>Select</option>
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
                <div class="">
                    <div class="relative w-full mt-2">
                        <label for="article_category" class="block text-base lg:text-lg">Topic / category</label>
                        <Select2 name="article_category" :class="dropdownClass" v-model="article_category" :options="local_categories"
                            @select="handleCategoryChange" :settings="{ width: '100%' }" />
                        <!-- <select
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        @input="handleCategoryChange($event.target.value)"
                        >
                        <option value="">Select</option>
                        <option
                            v-for="(
                                article_category, key
                            ) in article_categories"
                            :key="key"
                            :value="article_category?.id"
                            :selected="form?.parent_id == article_category?.id"
                        >
                            {{
                                article_category?.article_category_detail
                                    ?.length > 0
                                    ? article_category
                                          ?.article_category_detail[0]?.name
                                    : ""
                            }}
                        </option>
                    </select> -->
                    </div>
                    <p class="mt-2 text-base text-primary" v-if="validationErros.has('article_category_id')"
                        v-text="validationErros.get('article_category_id')"></p>
                </div>
                <div class="" v-if="sub_local_categories?.length > 0">
                    <div class="relative w-full mt-2">
                        <label for="name" class="block text-base lg:text-lg">Sub topic / category</label>
                        <Select2 name="sub_article_category" :class="dropdownClass" v-model="sub_article_category" :options="sub_local_categories"
                            @select="handleSubCategoryChange" :settings="{ width: '100%' }" />
                    </div>
                    <p class="mt-2 text-base text-primary" v-if="validationErros.has('article_category_id')"
                        v-text="validationErros.get('article_category_id')"></p>
                </div>
                <div class="">
                    <div class="relative w-full mt-2">
                        <label for="original_source" class="block text-base lg:text-lg">Original source</label>
                        <input type="text" name="original_source" id="original_source"
                            class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            placeholder=" " @input="handleOS($event.target.value)" :value="form['original_source']
                                    ? form['original_source']
                                    : ''
                                " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`original_source`)"
                            v-text="validationErros.get(`original_source`)"></p>
                    </div>
                </div>

                <div class="relative w-full mt-2">
                        <label for="keyword" class="block text-base lg:text-lg mb-2">Keyword<span
                                class="text-primary">*</span></label>
                                <textarea rows="2" name="keyword" id="keyword" class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary" placeholder="Enter up to 5 keywords or keyphrases, separated by commas. These are extremely useful when users are searching for articles in topics similar to yours. So be specific and target your audience as well as you can If you are unsure of what to include, here is an example: you have a family-run business that produces homemade candles. Your suggested keywords or key phrases may look something like this: candles, homemade, family-run business, traditional, made to order As you can see, the example includes 5 keywords / keyphrases that highlight the main features of the product" @input="handleKeyeword($event.target.value, 'keyword')" :value="form['keyword'] ? form['keyword'] : ''"></textarea>
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `keyword`
                            )
                        " v-text="validationErros.get(
                                `keyword`
                            )
                                "></p>
                </div>

                <div class="w-full md:gap-6" v-for="language in languages" :key="language.id" :class="(activeTab == null && language.is_default) ||
                        activeTab == language.id
                        ? 'block'
                        : 'hidden'
                    ">
                    <div class="relative z-0 w-full mb-6 group mt-4" v-if="isDataDescriptionLoaded">
                        <!-- <textarea type="text" name="description" id="description" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " @input="handleNameInput($event.target.value, language)" :value="form['description'] && form['description'][`description_${language.id}`] ? form['description'][`description_${language.id}`] : ''" ></textarea> -->
                        <label for="name" class="block text-base lg:text-lg mb-2">Article main text / body</label>
                        <editor @selectionChange="
                            handleDescriptionChange(language, 'description')
                            " class="mt-2" :ref="`description_${language.id}`" :id="`description_${language.id}`"
                            :initial-value="form[`description`][
                                `description_${language?.id}`
                            ]
                                " :init="descriptionEditorConfig" :tinymce-script-src="tinymceScriptSrc" />

                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `description.description_${language.id}`
                            )
                        " v-text="validationErros.get(
                                `description.description_${language.id}`
                            )
                                "></p>
                    </div>
                </div>

                <div class="grid md:grid-cols-4 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <FilePond name="article_image" class-name="my-pond" accepted-file-types="image/*"
                            @init="handleFilePondInit" @processfile="handleFilePondFlagIconProcess"
                            @removefile="handleFilePondFlagIconRemoveFile" />
                            
                        <p>(Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)</p>
                    </div>
                    <p class="mt-2 text-base text-primary" v-if="validationErros.has('article_image')"
                        v-text="validationErros.get('article_image')"></p>
                </div>
                <div class="mb-5">
                    <h1 class="block text-base lg:text-lg">Article written by</h1>
                    <div class="">
                        <div class="relative w-full mt-2">
                            <label for="name_title" class="block text-base lg:text-lg">Name title</label>
                            <input type="text" name="name_title" id="name_title"
                                class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                placeholder=" " @input="handleName($event.target.value)" :value="form['name_title']
                                        ? form['name_title']
                                        : ''
                                    " />
                            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`name_title`)"
                                v-text="validationErros.get(`name_title`)"></p>
                        </div>
                    </div>
                    <div class="">
                        <div class="relative w-full mt-2">
                            <label for="organization" class="block text-base lg:text-lg">Organization</label>
                            <input type="text" name="organization" id="organization"
                                class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                placeholder=" " @input="handleOrganization($event.target.value)" :value="form['organization']
                                        ? form['organization']
                                        : ''
                                    " />
                            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`organization`)"
                                v-text="validationErros.get(`organization`)"></p>
                        </div>
                    </div>
                    <div class="">
                        <div class="relative w-full mt-2">
                            <label for="website" class="block text-base lg:text-lg">Website</label>
                            <input type="text" name="website" id="website"
                                class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                placeholder=" " @input="handleWebsite($event.target.value)" :value="form['website']
                                        ? form['website']
                                        : ''
                                    " />
                            <p class="mt-2 text-base text-primary" v-if="validationErros.has(`name_title`)"
                                v-text="validationErros.get(`name_title`)"></p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="can-edu-btn-fill mb-6">Submit</button>
            </form>
        </div>
    </div>
    <transition name="slide">
        <div id="defaultModal" tabindex="-1" aria-hidden="true"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="showPopUpModal">
            <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                ref="elementToDetectClick">
                <div class="relative">
                    <div class="absolute top-3 right-3 cursor-pointer" @click="togglePopUpModal">
                        <button type="button" class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                            <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                        <p class="text-center can-edu-p mt-2">
                            {{
                                popupMsg
                            }} </p>
                            <div class="flex justify-center">
                        <button type="button" class="can-edu-btn-fill  whitespace-nowrap px-2.5 md:px-5 mt-4"
                            @click="togglePopUpModal">
                            Close
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
// Import filepond
import Select2 from "vue3-select2-component";
import Editor from "@tinymce/tinymce-vue";
import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);
import { mapState } from "vuex";
export default {
    props: ['school_id', 'slug', 'logged_in_customer', "article_id"],
    computed: {
        ...mapState({
            form: (state) => state.articles.form,
            validationErros: (state) => state.articles.validationErros,
            languages: (state) => state.languages.languages,
            article_categories: (state) =>
                state.article_categories.article_categories,
        }),
    },
    data() {
        return {
            showPopUpModal: false,
            popupMsg: '',
            activeTab: null,
            article_category: "",
            sub_article_category: "",
            selected_image: "",
            local_categories: [],
            isDataShortDescriptionLoaded: false,
            isDataDescriptionLoaded: false,
            sub_local_categories: [],
            shortDescriptionEditorConfig: {
                height: 250,
                menubar: false,
                elementpath:false,
                plugins:
                    "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code wordcount",
                toolbar:
                    "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen",
                setup: function(editor) {
                        var max = 50;
                        editor.on('keypress', function(event) {
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
                elementpath:false,
                plugins:
                    "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code wordcount",
                toolbar:
                    "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen",
                setup: function(editor) {
                    var max = 2000;
                    editor.on('keypress', function(event) {
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
            dropdownClass:
                "block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer",
        };
    },
    methods: {
        togglePopUpModal() {
            this.showPopUpModal = !this.showPopUpModal;
            if (!this.showPopUpModal) {

                window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/articles";

            }
        },
        handleClickOutsidePopup(event) {
            // // Check if the click target is not within the element
            if (
                this.$refs.elementToDetectClick &&
                event.target.contains(this.$refs.elementToDetectClick)
            ) {
                // Clicked outside the element, you can perform actions here
                if (this.showPopUpModal == true) {
                    this.showPopUpModal = false;
                    window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/articles";

                }
            }
        },
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
        handleName(value) {
            this.$store.commit("articles/setNameTitle", value);
        },
        handleOrganization(value) {
            this.$store.commit("articles/setOrganization", value);
        },
        handleWebsite(value) {
            this.$store.commit("articles/setWebsite", value);
        },
        handleSelectionChange(language, key) {
            // debugger;
            const content = tinymce.get(`${key}_${language.id}`).getContent();
            this.$store.commit(`articles/updateShortDescription`, {
                description: content,
                id: language.id,
            });
            const errorKey = `short_description.short_description_${language.id}`;
            if (content.trim()) {
                this.validationErros.clear(errorKey);
            }
        },
        handleDescriptionChange(language, key) {
            const content = tinymce.get(`${key}_${language.id}`).getContent();
            this.$store.commit(`articles/updateDescription`, {
                description: content,
                id: language.id,
            });
            const errorKey = `description.description_${language.id}`;
            if (content.trim()) {
                this.validationErros.clear(errorKey);
            }
        },
        handleOS(value) {
            this.$store.commit("articles/setOriginalSource", value);
        },
        handleKeyeword(value) {
            this.$store.commit("articles/setKeyword", value);
        },
        handleNameInput(value, language) {
            this.$store.commit("articles/updateName", {
                name: value,
                id: language.id,
            });
        },
        handleSubCategoryChange(data) {
            this.$store.commit("articles/setForm", {
                key: "article_category_id",
                value: data?.id,
            });
        },
        handleCategoryChange(data) {
            this.sub_local_categories = [];
            for (var i = 0; i < this?.article_categories?.length; i++) {
                if (this?.article_categories[i].parent_id == data?.id) {
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
                value: data?.id,
            });
        },
        addUpdateForm() {
            this.$store
            .dispatch("articles/addUpdateForm")
            .then((res) => {
                this.showPopUpModal = true;
                this.popupMsg = res.data.message
            }
            ).catch((error) => {
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
          tinymceEditor.focus();
          tinymceEditor.getBody().scrollIntoView({ behavior: "smooth", block: "center" });
          return;
        } else {
          console.log(`TinyMCE editor instance not found for ${editorId}`);
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
        fetchArticles() {
            if (this.article_id) {
                let id = this.article_id;
                this.$store.commit("articles/setIsFormEdit", 1);
                this.$store
                    .dispatch("articles/fetchArticles", {
                        id: id,
                        url: `${process.env.MIX_WEB_API_URL}articles/${id}?withArticleDetail=1`,
                    })
                    .then((res) => {
                        console.log('web_res', res);
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
                            "articles/setOrganization",
                            res.data.data.organization
                        );
                        this.$store.commit(
                            "articles/setKeyword",
                            res.data.data.keyword
                        );
                        this.$store.commit("articles/setForm", {
                            key: "type",
                            value: res.data.data.type, // Assign the type from the response
                        });
                        this.type = this.form.type
                        console.log("Form Type After API Fetch:", this.form.type);
                        setTimeout(() => {
                            this.sub_local_categories = [];
                            for (
                                var i = 0;
                                i < this.article_categories?.length;
                                i++
                            ) {
                                if (
                                    parseInt(this?.article_categories[i].id) ==
                                    parseInt(res.data.data.article_category_id)
                                ) {
                                    if (
                                        this?.article_categories[i]
                                            ?.parent_id == null
                                    ) {
                                        this.article_category = parseInt(
                                            res.data.data.article_category_id
                                        );
                                    } else {
                                        this.article_category =
                                            this?.article_categories[
                                                i
                                            ]?.parent_id;
                                        this.sub_article_category = parseInt(
                                            res.data.data.article_category_id
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
                                        console.log(
                                            this?.article_categories[i].id,
                                            "sub category"
                                        );
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
                            value: res.data.data.article_category_id,
                        });
                        this.$store.commit("articles/setForm", {
                            key: "id",
                            value: id,
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

                        obj = {};
                        data.map((res) => {
                            obj["short_description_" + res.language_id] =
                                res.short_description;
                        });
                        this.$store.commit("articles/setShortDescription", obj);

                        obj = {};
                        data.map((res) => {
                            obj["description_" + res.language_id] =
                                res.description;
                        });
                        this.$store.commit("articles/setDescription", obj);
                        this.isDataShortDescriptionLoaded = 1;
                        this.isDataDescriptionLoaded = 1;


                    });
            }
        },
        handleFilePondInit() {
            setOptions({
                credits: false,
                server: {
                    url: process.env.MIX_WEB_API_URL,
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
                            `${process.env.MIX_WEB_API_URL}media/process`
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
                            `${process.env.MIX_WEB_API_URL}media/revert`
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
            console.log(file.serverId);
            this.selected_image = file.serverId;
            this.$store.commit("articles/setForm", {
                key: "article_image",
                value: file.serverId,
            });
        },
        handleFilePondFlagIconRemoveFile(error, file) {
            this.$store.commit("articles/setForm", {
                key: "article_image",
                value: null,
            });
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
        this.$store.commit("articles/setForm", {
            key: "customer_id",
            value: this.logged_in_customer,
        });
        this.$store.commit("articles/setForm", {
            key: "school_id",
            value: this.school_id,
        });
        this.$store
            .dispatch("languages/fetchCustomerLanguages", {
                url: `${process.env.MIX_WEB_API_URL}get-customer-languages`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                let sd = {};
                let d = {};
                this.$store.commit("articles/setName", obj);
                this.$store.commit("articles/setShortDescription", sd);
                this.$store.commit("articles/setDescription", d);
                this.fetchArticles();
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
            });
    },
    components: {
        FilePond,
        Select2,
        editor: Editor,
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutsidePopup);
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutsidePopup);

    }
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
/* Slide Animation */
.slide-enter-active, .slide-leave-active {
  transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}
.slide-enter-from, .slide-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}
</style>
