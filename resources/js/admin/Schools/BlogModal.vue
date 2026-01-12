<template>
  <div
    v-if="showModal"
    id="modal"
    class="fixed z-50 inset-0 overflow-y-auto"
    >
        <div class="flex items-center justify-center min-h-screen relative">
            <div
                class="modal-overlay w-full h-full bg-gray-900 opacity-50 absolute"
            ></div>
            <div
                class="modal-container bg-white w-full md:w-3/5 my-4 z-50 mx-auto rounded shadow-lg overflow-y-auto"
            >
                <div class="modal-content py-6 text-left px-6">
          <div class="flex justify-between items-center pb-3">
            <div class="can-admin-h2 mb-0">Add Blog</div>
            <div
              class="modal-close cursor-pointer z-50 border border-primary p-1.5 rounded-full"
              @click="closeModal"
            >
              <svg
                class="fill-current text-primary"
                xmlns="http://www.w3.org/2000/svg"
                width="12"
                height="12"
                viewBox="0 0 18 18"
              >
                <path
                  d="M18 1.1L16.9 0 9 7.9 1.1 0 0 1.1 7.9 9 0 16.9 1.1 18 9 10.1l7.9 7.9 1.1-1.1-7.9-7.9z"
                />
              </svg>
            </div>
          </div>
          <div class="modal-body">
            <div
              class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
            >
              <ul class="flex flex-wrap my-4">
                <li
                  class="mr-2"
                  v-for="language in languages"
                  :key="language.abbreviation"
                >
                  <a
                    @click.prevent="changeLanguageTab(language)"
                    href="#"
                    :class="[
                      'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                      activeTab != null && activeTab == language.abbreviation
                        ? 'text-white bg-primary active'
                        : '',
                      validationErros.has(
                        `title.title_${language.abbreviation}`
                      )
                        ? 'bg-red-600 text-white hover:text-white'
                        : '',
                    ]"
                    >{{ language.abbreviation }}</a
                  >
                </li>
              </ul>
            </div>
            <div
              v-for="language in languages"
              :key="language.abbreviation"
              :class="activeTab == language.abbreviation ? 'block' : 'hidden'"
            >
              <div class="w-full mt-2">
                <label for="title" class="block text-base lg:text-lg">Blog title <span class="text-primary">*</span> </label>
                <input
                  type="text"
                  placeholder=""
                  class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                  @input="handleInput($event, 'title', language)"
                  :value="
                    form['title'] && form['title'][`title_${language.id}`]
                      ? form['title'][`title_${language.id}`]
                      : ''
                  "
                />
                <error
                  :fieldName="`title.title_${language.id}`"
                  :validationErros="validationErros"
                />
              </div>
              <div class="w-full mt-2">
                <label for="category" class="block text-base lg:text-lg">Category name <span class="text-primary">*</span> </label>
                <input
                  type="category_name"
                  placeholder=""
                  class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                  @input="handleInput($event, 'category_name', language)"
                  :value="
                    form['category_name'] &&
                    form['category_name'][`category_name_${language.id}`]
                      ? form['category_name'][`category_name_${language.id}`]
                      : ''
                  "
                />
                <error
                  :fieldName="`category_name.category_name_${language.id}`"
                  :validationErros="validationErros"
                />
              </div>
              <div class="w-full mt-2" v-if="isDataLoaded">
                <label for="summary" class="block text-base lg:text-lg mb-2">Short description <span class="text-primary">*</span> </label>
                <editor
                  @selectionChange="
                    handleSelectionChange(language, 'short_description')
                  "
                  placeholder="Write a brief introduction of the blog. 30 words max."
                  :ref="`short_description_${language.id}`"
                  :id="`short_description_${language.id}`"
                  :initial-value="
                    form[`short_description`][
                      `short_description_${language?.id}`
                    ]
                  "
                  :init="editorConfig"
                  :tinymce-script-src="tinymceScriptSrc"
                />
                <error
                  :fieldName="`short_description.short_description_${language.id}`"
                  :validationErros="validationErros"
                />
              </div>
              <div class="w-full mt-2" v-if="isDataLoaded">
                <label for="description" class="block text-base lg:text-lg mb-2">Detailed description <span class="text-primary">*</span> </label>
                <editor
                  @selectionChange="
                    handleSelectionChange(language, 'detail_description')
                  "
                    placeholder="300 words max."
                  :ref="`detail_description_${language.id}`"
                  :id="`detail_description_${language.id}`"
                  :initial-value="
                    form[`detail_description`][
                      `detail_description_${language?.id}`
                    ]
                  "
                  :init="editorConfig"
                  :tinymce-script-src="tinymceScriptSrc"
                />
                <error
                  :fieldName="`detail_description.detail_description_${language.id}`"
                  :validationErros="validationErros"
                />
              </div>
            </div>
            <div class="relative z-0 w-full mb-6 group mt-2">
              <label for="image" class="block text-base lg:text-lg">Image</label>
              <p class="text-base">
                 (Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)
              </p>
            <input
              :key="`image`"
              type="file"
              :name="`image`"
              :id="`image`"
              class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              placeholder=" "
              @change="handleImageArray($event)"
            />
            <p
              class="mt-2 text-base text-primary"
              v-if="validationErros.has(`image`)"
              v-text="validationErros.get(`image`)"
            ></p>
          </div>
          <div class="md:col-span-4">
                    <div class="flex flex-wrap gap-2">
                        <div
                            class="relative h-32 w-32 bg-gray-50 border"
                            v-for="(image, key) in form?.image"
                            :key="key"
                        >
                            <img
                                :src=" image"
                                class="w-full h-full object-contain"
                            />
                            <span
                                @click="removeImage(key)"
                                class="absolute top-0 right-0 flex justify-center items-center cursor-pointer bg-white border border-primary rounded-full text-primary w-5 h-5"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-5 h-5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

            <div class="flex justify-center items-center gap-3 mt-4">
              <div class="space-x-4">
                <button class="can-edu-btn-fill" @click="closeModal">
                  Close
                </button>
                <button class="can-edu-btn-fill" @click="addUpdate">
                  Add blog
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Editor from "@tinymce/tinymce-vue";
import axios from "axios";
import { mapState } from "vuex";
import Error from "./Error.vue";
export default {
  components: { Error, editor: Editor },
  props: ["logged_in_customer", "school_id"],
  computed: {
    ...mapState({
      form: (state) => state.blogs.form,
      showModal: (state) => state.blogs.showModal,
      isDataLoaded: (state) => state.blogs.isDataLoaded,
      blogs: (state) => state.blogs.blogs,
      pagination: (state) => state.blogs.pagination,
      validationErros: (state) => state.blogs.validationErros,
      searchParam: (state) => state.blogs.searchParam,
      loading: (state) => state.blogs.loading,
      languages: (state) => state.blogs.form.languages,
    }),
  },
  data() {
    return {
      activeTab: "en",
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
    closeModal() {
      this.$store.commit("blogs/setShowModal", 0);
      this.$store.commit("blogs/resetForm");
      this.fetchCustomerLangs();
      // this.$store.commit("blogs/setForData", {
      //     key: "type",
      //     language: "",
      //     value: this.faq_type,
      // });

      this.$store.commit("blogs/setForData", {
        key: "customer_id",
        language: "",
        value: this.logged_in_customer,
      });
      this.$store.commit("blogs/setForData", {
        key: "school_id",
        language: "",
        value: this.school_id,
      });
    },
    handleInput(e, key, language) {
      this.$store.commit("blogs/setForData", {
        key,
        language,
        value: e.target.value,
      });
    },
    handleSelectionChange(language, key) {
      this.$store.commit(`blogs/updateFormData`, {
        value: tinymce.get(`${key}_${language.id}`).getContent(),
        id: language.id,
        key: key,
      });
    },
    changeLanguageTab(language) {
      this.activeTab = language.abbreviation;
    },
    addUpdate() {
      this.$store.dispatch("blogs/addUpdateForm").then((res) => {
        if (res.data.status == "Success") {
          // this.$store.commit("blogs/setForData", {
          //     key: "type",
          //     language: "",
          //     value: this.faq_type,
          // });

          this.$store.commit("blogs/setForData", {
            key: "customer_id",
            language: "",
            value: this.logged_in_customer,
          });
          this.$store.commit("blogs/setForData", {
            key: "school_id",
            language: "",
            value: this.school_id,
          });
          this.$store.dispatch("blogs/fetchBlogs", {
            school_id: this.$route?.params?.id,
          });
          this.closeModal();
        }
      });
    },
    fetchCustomerLangs() {
      axios.get("/api/admin/languages").then((res) => {
        if (res.data.status == "Success") {
          this.$store.commit("blogs/setLanguages", res.data.data);
          res.data.data?.filter((lang) => {
            this.$store.commit("blogs/setForData", {
              key: "title",
              language: lang,
              value: "",
            });
            this.$store.commit("blogs/setForData", {
              key: "short_description",
              language: lang,
              value: "",
            });
            this.$store.commit("blogs/setForData", {
              key: "detail_description",
              language: lang,
              value: "",
            });
            this.$store.commit("blogs/setForData", {
              key: "category_name",
              language: lang,
              value: "",
            });
          });
        }
      });
    },
    removeImage(index) {
            this.$store.commit("blogs/removeImage", index);
        },
        handleImageArray(e) {
            for (var i = 0; i < e.target.files.length; i++) {
                var file = new FormData();
                file.append("file", e.target.files[i]);
                axios.post("/api/web/image_again_upload", file).then((res) => {
                    this.$store.commit("blogs/setImages", res?.data);
                });
            }
        },
  },

  mounted() {
    this.fetchCustomerLangs();
  },
};
</script>
