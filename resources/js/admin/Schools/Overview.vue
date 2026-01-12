<template>
  <AppLayout>
    <header class="py-4 bg-white">
      <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
          <h1 class="can-edu-h1">School overview</h1>
          <router-link
            :to="{ name: 'admin.schools.index' }"
            class="can-edu-btn-fill"
          >
            Back
          </router-link>
        </div>
      </div>
      <div v-if="$route?.params?.id">
        <other-options type="overview" :id="$route?.params?.id" />
      </div>
    </header>
    <div class="p-5 bg-white dark:bg-gray-800">
      <!-- <OverviewPrograms :school_overview_id="form['id']" v-if="form['id']" /> -->
      <div class="modal-content py-6 text-left px-6">
        <div class="modal-body">
          <div
            class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
          >
            <ul class="flex flex-wrap my-4">
              <li
                class="mr-2"
                v-for="language in languages"
                :key="language.code"
              >
                <a
                  @click.prevent="changeLanguageTab(language)"
                  href="#"
                  :class="[
                    'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                    activeTab != null && activeTab == language.abbreviation
                      ? 'text-white bg-primary active'
                      : '',
                    errors.has(`blog_pre_description.blog_pre_description_${language.code}`)
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
            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Blog pre-description</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`blog_pre_description_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'blog_pre_description')
                "
                :ref="`blog_pre_description_${language.abbreviation}`"
                :id="`blog_pre_description_${language.abbreviation}`"
                :initial-value="
                  form[`blog_pre_description`][
                    `blog_pre_description_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`blog_pre_description.blog_pre_description_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Blog post-description</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`blog_post_description_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'blog_post_description')
                "
                :ref="`blog_post_description_${language.abbreviation}`"
                :id="`blog_post_description_${language.abbreviation}`"
                :initial-value="
                  form[`blog_post_description`][
                    `blog_post_description_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`blog_post_description.blog_post_description_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Programs pre-description</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`programs_pre_description_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'programs_pre_description')
                "
                :ref="`programs_pre_description_${language.abbreviation}`"
                :id="`programs_pre_description_${language.abbreviation}`"
                :initial-value="
                  form[`programs_pre_description`][
                    `programs_pre_description_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`programs_pre_description.programs_pre_description_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative" v-if="isDataLoaded">
              <label class="text-gray-700 font-semibold text-sm lg:text-base"
                >Programs post-description</label
              >
              <!-- <div
              class="mt-5 ckeditorText"
              :id="`programs_post_description_${language.abbreviation}`"
            ></div> -->
              <editor
                @selectionChange="
                  handleSelectionChange(language, 'programs_post_description')
                "
                :ref="`programs_post_description_${language.abbreviation}`"
                :id="`programs_post_description_${language.abbreviation}`"
                :initial-value="
                  form[`programs_post_description`][
                    `programs_post_description_${language?.abbreviation}`
                  ]
                "
                :init="editorConfig"
                :tinymce-script-src="tinymceScriptSrc"
              />
              <error
                :fieldName="`programs_post_description.programs_post_description_${language.abbreviation}`"
                :validationErros="errors"
              />
            </div>
          </div>

          <div class="w-full mt-2 relative">
            <div class="flex items-center gap-2">
            <input
              id="display_blog"
              type="checkbox"
              placeholder=""
              @input="
                handleCheckboxInput($event.target.checked, `display_blog`)
              "
              :checked="
                form?.[`display_blog`] && form?.[`display_blog`] == true
                  ? true
                  : false
              "
            />
            <label
              for="display_blog"
              class="text-gray-700 font-semibold text-sm lg:text-base"
              >Display blog posts</label
            >
          </div>
            <error :fieldName="`display_blog`" :validationErros="errors" />
          </div>
          <template v-if="form?.[`display_blog`] == true">
            <div class="w-full mt-2 relative">
              <label
                for="number_of_blog_posts"
                class="text-gray-700 font-semibold text-sm lg:text-base"
                >Number of blog posts</label
              >
              <input
                id="number_of_blog_posts"
                type="number"
                placeholder=""
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="
                  handleInput($event, `number_of_blog_posts`)
                "
                :value="form?.[`number_of_blog_posts`] || ''"
              />
              <error
                :fieldName="`number_of_blog_posts`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative">
              <label
                for="blog_posts_order"
                class="text-gray-700 font-semibold text-sm lg:text-base"
                >Blog posts order</label
              >
              <select
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                @input="handleInput($event, 'blog_posts_order')"
              >
                <option value="">Select</option>
                <option
                  :selected="form['blog_posts_order'] == 'random'"
                  value="random"
                >
                  Random
                </option>
                <option
                  :selected="form['blog_posts_order'] == 'latest'"
                  value="latest"
                >
                  Latest
                </option>
              </select>
              <error
                :fieldName="`blog_posts_order`"
                :validationErros="errors"
              />
            </div>
          </template>
          <div class="w-full mt-2 relative">
              <label
                for="video_url"
                class="text-gray-700 font-semibold text-sm lg:text-base"
                >Youtube URL</label
              >
              <input
                id="video_url"
                type="text"
                placeholder=""
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="
                  handleInput($event, `video_url`)
                "
                :value="form?.[`video_url`] || ''"
              />
              <error
                :fieldName="`video_url`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative">
              <label
                for="school_overviews_apply_button_title"
                class="text-gray-700 font-semibold text-sm lg:text-base"
                >School overviews button title</label
              >
              <input
                id="school_overviews_apply_button_title"
                type="text"
                placeholder=""
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="
                  handleInput($event, `school_overviews_apply_button_title`)
                "
                :value="form?.[`school_overviews_apply_button_title`] || ''"
              />
              <error
                :fieldName="`school_overviews_apply_button_title`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative">
              <label
                for="school_overviews_apply_button_link"
                class="text-gray-700 font-semibold text-sm lg:text-base"
                >School overviews button link</label
              >
              <input
                id="school_overviews_apply_button_link"
                type="text"
                placeholder=""
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="
                  handleInput($event, `school_overviews_apply_button_link`)
                "
                :value="form?.[`school_overviews_apply_button_link`] || ''"
              />
              <error
                :fieldName="`school_overviews_apply_button_link`"
                :validationErros="errors"
              />
            </div>

            <div class="w-full mt-2 relative">
              <label
                for="school_overviews_blue_bar_button_title"
                class="text-gray-700 font-semibold text-sm lg:text-base"
                >Good to go button title</label
              >
              <input
                id="school_overviews_blue_bar_button_title"
                type="text"
                placeholder=""
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="
                  handleInput($event, `school_overviews_blue_bar_button_title`)
                "
                :value="form?.[`school_overviews_blue_bar_button_title`] || ''"
              />
              <error
                :fieldName="`school_overviews_blue_bar_button_title`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative">
              <label
                for="school_overviews_blue_bar_button_link"
                class="text-gray-700 font-semibold text-sm lg:text-base"
                >Good to go button link</label
              >
              <input
                id="school_overviews_blue_bar_button_link"
                type="text"
                placeholder=""
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="
                  handleInput($event, `school_overviews_blue_bar_button_link`)
                "
                :value="form?.[`school_overviews_blue_bar_button_link`] || ''"
              />
              <error
                :fieldName="`school_overviews_blue_bar_button_link`"
                :validationErros="errors"
              />
            </div>


            <div class="w-full mt-2 relative">
              <label
                for="school_overviews_red_bar_button_title"
                class="text-gray-700 font-semibold text-sm lg:text-base"
                >Let's apply button title</label
              >
              <input
                id="school_overviews_red_bar_button_title"
                type="text"
                placeholder=""
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="
                  handleInput($event, `school_overviews_red_bar_button_title`)
                "
                :value="form?.[`school_overviews_red_bar_button_title`] || ''"
              />
              <error
                :fieldName="`school_overviews_red_bar_button_title`"
                :validationErros="errors"
              />
            </div>
            <div class="w-full mt-2 relative">
              <label
                for="school_overviews_red_bar_button_link"
                class="text-gray-700 font-semibold text-sm lg:text-base"
                >Let's apply button link</label
              >
              <input
                id="school_overviews_red_bar_button_link"
                type="text"
                placeholder=""
                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="
                  handleInput($event, `school_overviews_red_bar_button_link`)
                "
                :value="form?.[`school_overviews_red_bar_button_link`] || ''"
              />
              <error
                :fieldName="`school_overviews_red_bar_button_link`"
                :validationErros="errors"
              />
            </div>



          <div class="flex justify-center items-center gap-3 mt-4">
            <div>
              <button class="can-edu-btn-fill" @click="addUpdate">
                Submit
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
<script>
import Editor from "@tinymce/tinymce-vue";
import axios from "axios";
import { mapState } from "vuex";
// import OverviewPrograms from "./OverviewPrograms.vue";
import Error from "./Error.vue";
import OtherOptions from "./OtherOptions.vue";
export default {
  components: {
    Error,
    OtherOptions,
    editor: Editor,
  },
  props: ["logged_in_customer", "school_id"],
  computed: {
    ...mapState({
      form: (state) => state.school_overviews.form,
      school_overviews: (state) => state.school_overviews.school_overviews,
      is_featured_array: (state) => state.school_overviews.is_featured_array,
      errors: (state) => state.school_overviews.errors,
      isLoading: (state) => state.school_overviews.isLoading,
      languages: (state) => state.languages.languages,
    }),
  },
  data() {
    return {
      activeTab: "en",
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
    handleIsFeatured(val, key) {
      this.$store.commit("school_overviews/setIsFeatured", {
        checked: val,
        key,
      });
    },
    closeModal() {
      this.$store.commit("school_overviews/setShowModal", 0);
    },
    handleInput(e, key, language) {
      this.$store.commit("school_overviews/setForData", {
        key,
        language: language ? language : "",
        value: e.target.value,
      });
    },
    handleSelectionChange(language, key) {
      this.$store.commit(`school_overviews/updateFormData`, {
        value: tinymce.get(`${key}_${language.abbreviation}`).getContent(),
        id: language.abbreviation,
        key: key,
      });
    },
    handleCheckboxInput(value, key) {
      this.$store.commit("school_overviews/setForData", {
        key,
        value: value,
      });
    },
    changeLanguageTab(language) {
      this.activeTab = language.abbreviation;
    },
    addUpdate() {
      this.$store.dispatch("school_overviews/addUpdateForm").then((res) => {
        if (res.data.status == "Success") {
          this.$store.commit("school_overviews/setLimit", 10);
          this.$store.commit("school_overviews/setSortBy", "id");
          this.$store.commit("school_overviews/setSortType", "desc");
          this.$store.dispatch("school_overviews/fetchSchoolOverviews", {
            url: `${process.env.MIX_WEB_API_URL}school-overviews?withSchoolOverviewDetail=1&is_admin=1&school_id=${this.$route.params.id}`,
          });
        }
      });
    },
    fetchSchoolOverviews() {
      this.$store
        .dispatch("school_overviews/fetchSchoolOverviews", {
          url: `${process.env.MIX_WEB_API_URL}school-overviews?withSchoolOverviewDetail=1&is_admin=1&school_id=${this.$route.params.id}`,
        })
        .then((res) => {
          let school_keys = [
            "id",
            "customer_id",
            "display_blog",
            "school_overviews_apply_button_title",
            "school_overviews_apply_button_link",
            "school_overviews_blue_bar_button_title",
            "school_overviews_blue_bar_button_link",
            "school_overviews_red_bar_button_title",
            "school_overviews_red_bar_button_link",
            "number_of_blog_posts",
            "video_url",
            "blog_posts_order",
          ];
          let data = res.data.data ? res.data.data : [];
          for (var i = 0; i < school_keys?.length; i++) {
            this.$store.commit("school_overviews/setForData", {
              key: school_keys[i],
              value: data[school_keys[i]] ? data[school_keys[i]] : "",
            });
          }

          data =
            res.data.data && res.data.data.school_overview_detail
              ? res.data.data.school_overview_detail
              : [];

          var moreFields1 = ["blog_pre_description", "blog_post_description", "programs_pre_description", "programs_post_description"];
          for (var i = 0; i < moreFields1?.length; i++) {
            let obj = {};
            data.map((res) => {
              obj[moreFields1[i] + "_" + res.language_code] =
                res[moreFields1[i]];
            });
            this.$store.commit("school_overviews/setForData", {
              key: moreFields1[i],
              value: obj,
            });
            this.isDataLoaded = 1;
          }
        });
    },
    handleImage(e, key) {
      var file = new FormData();
      file.append("file", e.target.files[0]);
      axios.post("/api/web/image_again_upload", file).then((res) => {
        this.$store.commit("school_overviews/setForData", {
          key: key,
          value: res?.data,
          language: "",
        });
      });
    },
  },

  created() {
    this.$store.commit("school_overviews/setForData", {
      key: "school_id",
      value: this.$route.params.id,
    });
    this.$store
      .dispatch("languages/fetchLanguages", {
        url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
      })
      .then((res) => {
        if (res.data.status == "Success") {
          this.$store.commit("school_overviews/setLanguages", res.data.data);

          setTimeout(() => {
            let data = res.data.data;
            var moreFields = ["blog_pre_description", "blog_post_description", "programs_pre_description", "programs_post_description"];
            for (var i = 0; i < moreFields?.length; i++) {
              let obj = {};
              data.map((res) => {
                obj[moreFields[i] + "_" + res.abbreviation] = "";
              });
              this.$store.commit("school_overviews/setForData", {
                key: moreFields[i],
                value: obj,
              });
            }
            if (this.$route.params.id) {
              this.fetchSchoolOverviews();
            } else {
              this.isDataLoaded = 1;
            }
          }, 1000);
        }
      });
  },
};
</script>
