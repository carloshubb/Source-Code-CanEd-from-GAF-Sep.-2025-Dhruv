<template>
    <AppLayout>
      <header class="py-4 bg-white">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <h1 class="can-edu-h1">School ambassador</h1>
            <router-link
              :to="{ name: 'admin.schools.index' }"
              class="can-edu-btn-fill"
            >
              Back
            </router-link>
          </div>
        </div>
        <div v-if="$route?.params?.id">
          <other-options type="ambassador" :id="$route?.params?.id" />
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
      
   
              <!-- <div class="w-full mt-2 relative">
                <label
                  for="school_ambassador_settings_apply_button_title"
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
              </div> -->
  

              <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg">Page top main text</label>
                <input type="text" placeholder=""
                  class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                  @input="handleInput($event, 'heading_text', '')" :value="form['heading_text']
                      ? form['heading_text']
                      : ''
                    " />
                <error :fieldName="`heading_text`" :validationErros="errors" />
              </div>

              <div class="w-full mt-4">
                <label class="block text-base lg:text-lg">Image</label>
                <input type="file"
                  class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                  @change="handleImage($event)" />
                <error :fieldName="'main_photo'" :validationErros="errors" />
                <!-- <img v-if="form['image']" :src="form?.image ? form.image : ''" style="height: 100px; width: 100px" /> -->
                <div v-if="form['main_photo']" class="mt-2 relative">
                  <img :src="form.main_photo" style="height: 100px; width: 100px" />
                  <button @click="removeImage"
                    class="absolute top-0 right-0 bg-red-500 text-white rounded-full px-2 py-1 text-xs">
                    X
                  </button>
                </div>
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
        form: (state) => state.school_ambassador_settings.form,
        school_ambassador_settings: (state) => state.school_ambassador_settings.school_ambassador_settings,
        is_featured_array: (state) => state.school_ambassador_settings.is_featured_array,
        errors: (state) => state.school_ambassador_settings.errors,
        isLoading: (state) => state.school_ambassador_settings.isLoading,
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
      handleImage(e) {
        var file = new FormData();
        file.append("file", e.target.files[0]);
        axios.post("/api/web/image_again_upload", file).then((res) => {
          this.$store.commit("school_ambassador_settings/setForData", {
            key: "main_photo",
            value: res?.data,
          });
          if (this.errors.has("main_photo")) {
            this.errors.clear("main_photo");
          }
        });
      },
      removeImage() {
        this.$store.commit("school_ambassador_settings/setForData", {
          key: "main_photo",
          value: null, 
        });
      },
      handleInput(e, key, language) {
        this.$store.commit("school_ambassador_settings/setForData", {
          key,
          language: language ? language : "",
          value: e.target.value,
        });
      },
    //   handleSelectionChange(language, key) {
    //     this.$store.commit(`school_ambassador_settings/updateFormData`, {
    //       value: tinymce.get(`${key}_${language.abbreviation}`).getContent(),
    //       id: language.abbreviation,
    //       key: key,
    //     });
    //   },
   
      changeLanguageTab(language) {
        this.activeTab = language.abbreviation;
      },
      addUpdate() {
        this.$store.dispatch("school_ambassador_settings/addUpdateForm").then((res) => {
          if (res.data.status == "Success") {
            this.$store.commit("school_ambassador_settings/setLimit", 10);
            this.$store.commit("school_ambassador_settings/setSortBy", "id");
            this.$store.commit("school_ambassador_settings/setSortType", "desc");
            this.$store.dispatch("school_ambassador_settings/fetchSchoolAmbassadorSettings", {
              url: `${process.env.MIX_WEB_API_URL}school-ambassador-settings?withSchoolAmbassadorSettingDetail=1&is_admin=1&school_id=${this.$route.params.id}`,
            });
            // this.$store.dispatch("school_ambassador_settings/fetchSchoolAmbassadorSettings", {
            //   url: `${process.env.MIX_WEB_API_URL}school-ambassador-settings?withSchoolAmbassadorSettingDetail=1&type=1&is_admin=1&school_id=${this.$route.params.id}`,
            // });
            // this.$store.dispatch(
            //     "school_ambassador_settings/fetchSchoolAmbassadorSettings"
            //   );
          }
        });
      },
      fetchSchoolAmbassadorSettings() {
        this.$store
          .dispatch("school_ambassador_settings/fetchSchoolAmbassadorSettings", {
            url: `${process.env.MIX_WEB_API_URL}school-ambassador-settings?is_admin=1&withwithSchoolAmbassadorSettingDetail=1&school_id=${this.$route?.params?.id}`,
          })
          .then((res) => {
            console.log('res polo', res);
            this.$store.commit("school_ambassador_settings/setForData", {
              key: "customer_id",
              value: res.data.data?.customer_id,
            });
            this.$store.commit("school_ambassador_settings/setForData", {
              key: "heading_text",
              value: res.data.data?.heading_text,
            });
            this.$store.commit("school_ambassador_settings/setForData", {
              key: "main_photo",
              value: res.data.data?.main_photo,
            });
            this.isDataLoaded = 1;
  
         
          });
      },
    
    },
  
    created() {
        console.log("Logged in customer:", this.logged_in_customer);
        
        this.$store.commit("school_ambassador_settings/setForData", {
            key: "school_id",
            value: this.$route.params.id,
        });
        console.log('school_id check',this.school_id);
      this.$store
        .dispatch("languages/fetchLanguages", {
          url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
        })
        .then((res) => {
          if (res.data.status == "Success") {
            this.$store.commit("school_ambassador_settings/setLanguages", res.data.data);
  
            setTimeout(() => {
              let data = res.data.data;
              var moreFields = ["blog_pre_description", "blog_post_description", "programs_pre_description", "programs_post_description"];
              for (var i = 0; i < moreFields?.length; i++) {
                let obj = {};
                data.map((res) => {
                  obj[moreFields[i] + "_" + res.abbreviation] = "";
                });
                this.$store.commit("school_ambassador_settings/setForData", {
                  key: moreFields[i],
                  value: obj,
                });
              }
                // this.fetchSchoolAmbassadorSettings();

              if (this.$route.params.id) {
                this.fetchSchoolAmbassadorSettings();
              } else {
                this.isDataLoaded = 1;
              }
            }, 1000);
          }
        });
    },
  };
  </script>
  