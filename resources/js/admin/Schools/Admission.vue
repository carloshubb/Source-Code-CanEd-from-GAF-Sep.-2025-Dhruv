<template>
  <AppLayout>
    <header class="py-4 bg-white">
      <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
          <h1 class="can-edu-h1">School admission setting</h1>
          <router-link :to="{ name: 'admin.schools.index' }" class="can-edu-btn-fill">
            Back
          </router-link>
        </div>
      </div>
      <div v-if="$route?.params?.id">
        <other-options type="admission" :id="$route?.params?.id" />
      </div>
    </header>
    <div class="p-5 bg-white dark:bg-gray-800">
      <ul class="flex flex-wrap my-4">
        <li class="mr-2 mb-2" v-for="language in languages" :key="language.abbreviation">
          <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
            'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
            activeTab != null && activeTab == language.abbreviation
              ? 'text-white bg-primary active'
              : '',
            validationErros.has(
              `employees_pre_description.employees_pre_description_${language.abbreviation}`
            )
              ? 'bg-red-600 text-white hover:text-white'
              : '',
          ]">{{ language.abbreviation }}</a>
        </li>
      </ul>
      <div v-for="language in languages" :key="language.abbreviation"
        :class="activeTab == language.abbreviation ? 'block' : 'hidden'">
        <div class="w-full mt-2" v-if="isDataLoaded">
          <label class="block text-base lg:text-lg mb-2">Employees pre-description</label>
          <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`employees_pre_description_${language.abbreviation}`"
                    ></div> -->
          <editor @selectionChange="handleSelectionChange(language, 'employees_pre_description')"
            :ref="`employees_pre_description_${language.abbreviation}`"
            :id="`employees_pre_description_${language.abbreviation}`" :initial-value="form[`employees_pre_description`][`employees_pre_description_${language?.abbreviation}`]
              " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
          <error :fieldName="`employees_pre_description.employees_pre_description_${language.abbreviation}`"
            :validationErros="validationErros" />
        </div>
        <div class="w-full mt-2" v-if="isDataLoaded">
          <label class="block text-base lg:text-lg mb-2">Employees post-description</label>
          <!-- <div
                    class="mt-5 ckeditorText"
                    :id="`employees_post_description_${language.abbreviation}`"
                ></div> -->
          <editor @selectionChange="
            handleSelectionChange(language, 'employees_post_description')
            " :ref="`employees_post_description_${language.abbreviation}`"
            :id="`employees_post_description_${language.abbreviation}`" :initial-value="form[`employees_post_description`][
              `employees_post_description_${language?.abbreviation}`
              ]
              " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
          <error :fieldName="`employees_post_description.employees_post_description_${language.abbreviation}`"
            :validationErros="validationErros" />
        </div>
        <div class="w-full mt-2" v-if="isDataLoaded">
          <label class="block text-base lg:text-lg mb-2">Team pre-description</label>
          <!-- <div
                    class="mt-5 ckeditorText"
                    :id="`team_pre_description_${language.abbreviation}`"
                ></div> -->
          <editor @selectionChange="handleSelectionChange(language, 'team_pre_description')"
            :ref="`team_pre_description_${language.abbreviation}`" :id="`team_pre_description_${language.abbreviation}`"
            :initial-value="form[`team_pre_description`][`team_pre_description_${language?.abbreviation}`]
              " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
          <error :fieldName="`team_pre_description.team_pre_description_${language.abbreviation}`"
            :validationErros="validationErros" />
        </div>
        <div class="w-full mt-2" v-if="isDataLoaded">
          <label class="block text-base lg:text-lg mb-2">Team post-description</label>
          <!-- <div
                    class="mt-5 ckeditorText"
                    :id="`team_post_description_${language.abbreviation}`"
                ></div> -->
          <editor @selectionChange="
            handleSelectionChange(language, 'team_post_description')
            " :ref="`team_post_description_${language.abbreviation}`"
            :id="`team_post_description_${language.abbreviation}`" :initial-value="form[`team_post_description`][
              `team_post_description_${language?.abbreviation}`
              ]
              " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
          <error :fieldName="`team_post_description.team_post_description_${language.abbreviation}`"
            :validationErros="validationErros" />
        </div>
        <div class="w-full mt-2" v-if="isDataLoaded">
          <label class="block text-base lg:text-lg mb-2">FAQ pre-description</label>
          <!-- <div
                    class="mt-5 ckeditorText"
                    :id="`faq_pre_description_${language.abbreviation}`"
                ></div> -->
          <editor @selectionChange="
            handleSelectionChange(language, 'faq_pre_description')
            " :ref="`faq_pre_description_${language.abbreviation}`"
            :id="`faq_pre_description_${language.abbreviation}`" :initial-value="form[`faq_pre_description`][
              `faq_pre_description_${language?.abbreviation}`
              ]
              " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
          <error :fieldName="`faq_pre_description.faq_pre_description_${language.abbreviation}`"
            :validationErros="validationErros" />
        </div>
        <div class="w-full mt-2" v-if="isDataLoaded">
          <label class="block text-base lg:text-lg mb-2">FAQ post-description</label>
          <!-- <div
                    class="mt-5 ckeditorText"
                    :id="`faq_post_description_${language.abbreviation}`"
                ></div> -->
          <editor @selectionChange="
            handleSelectionChange(language, 'faq_post_description')
            " :ref="`faq_post_description_${language.abbreviation}`"
            :id="`faq_post_description_${language.abbreviation}`" :initial-value="form[`faq_post_description`][
              `faq_post_description_${language?.abbreviation}`
              ]
              " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
          <error :fieldName="`faq_post_description.faq_post_description_${language.abbreviation}`"
            :validationErros="validationErros" />
        </div>
        <div class="w-full mt-2 relative">
          <label for="" class="block text-base lg:text-lg">Admission button Title</label>
          <input type="text" placeholder=""
            class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="handleInput($event, 'admission_apply_button_title', '')" :value="form['admission_apply_button_title']
                ? form['admission_apply_button_title']
                : ''
              " />
          <error :fieldName="`admission_apply_button_title`" :validationErros="validationErros" />
        </div>
        <div class="w-full mt-2 relative">
          <label for="" class="block text-base lg:text-lg">Admission button link</label>
          <input type="text" placeholder=""
            class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="handleInput($event, 'admission_apply_button_link', '')" :value="form['admission_apply_button_link']
                ? form['admission_apply_button_link']
                : ''
              " />
          <error :fieldName="`admission_apply_button_link`" :validationErros="validationErros" />
        </div>

        <div class="w-full mt-2 relative">
          <label for="" class="block text-base lg:text-lg">Good to go button title</label>
          <input type="text" placeholder=""
            class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="handleInput($event, 'admission_blue_bar_button_title', '')" :value="form['admission_blue_bar_button_title']
                ? form['admission_blue_bar_button_title']
                : ''
              " />
          <error :fieldName="`admission_blue_bar_button_title`" :validationErros="validationErros" />
        </div>
        <div class="w-full mt-2 relative">
          <label for="" class="block text-base lg:text-lg">Good to go button link</label>
          <input type="text" placeholder=""
            class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="handleInput($event, 'admission_blue_bar_button_link', '')" :value="form['admission_blue_bar_button_link']
                ? form['admission_blue_bar_button_link']
                : ''
              " />
          <error :fieldName="`admission_blue_bar_button_link`" :validationErros="validationErros" />
        </div>

        <div class="w-full mt-2 relative">
          <label for="" class="block text-base lg:text-lg">Let’s apply button title</label>
          <input type="text" placeholder=""
            class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="handleInput($event, 'admission_red_bar_button_title', '')" :value="form['admission_red_bar_button_title']
                ? form['admission_red_bar_button_title']
                : ''
              " />
          <error :fieldName="`admission_red_bar_button_title`" :validationErros="validationErros" />
        </div>
        <div class="w-full mt-2 relative">
          <label for="" class="block text-base lg:text-lg">Let’s apply button link</label>
          <input type="text" placeholder=""
            class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="handleInput($event, 'admission_red_bar_button_link', '')" :value="form['admission_red_bar_button_link']
                ? form['admission_red_bar_button_link']
                : ''
              " />
          <error :fieldName="`admission_red_bar_button_link`" :validationErros="validationErros" />
        </div>

      </div>

      <ListErrors :validationErrors="validationErros" />

      <div class="flex justify-center items-center gap-3 mt-4">
          <button class="can-edu-btn-fill" @click="addUpdate">Submit</button>
      </div>
    </div>
  </AppLayout>
</template>
<script>
import Editor from "@tinymce/tinymce-vue";
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
import Error from "../../web/Error.vue";
import OtherOptions from "./OtherOptions.vue";
export default {
  components: { Error, OtherOptions, editor: Editor, ListErrors },
  props: ["logged_in_customer", "school_id"],
  computed: {
    ...mapState({
      form: (state) => state.admission_setting.form,
      admission_setting: (state) => state.admission_setting.admission_setting,
      validationErros: (state) => state.admission_setting.validationErros,
      isLoading: (state) => state.admission_setting.isLoading,
      languages: (state) => state.admission_setting.form.languages,
    }),
  },
  data() {
    return {
      activeTab: "en",
      isDataLoaded: false,
      editorConfig: {
        height: 250,
        menubar: false,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen',
      },
      tinymceScriptSrc: "/plugins/tinymce/tinymce.min.js",
    };
  },
  methods: {
    closeModal() {
      this.$store.commit("admission_setting/setShowModal", 0);
    },
    // handleInput(e, key, language) {
    //   this.$store.commit("admission_setting/updatePageSetting", {
    //     key,
    //     id: language.abbreviation,
    //     value: e.target.value,
    //   });
    // },
    handleInput(e, key, language) {
      this.$store.commit("admission_setting/setPageSetting", {
        key,
        language: language ? language : "",
        value: e.target.value,
      });
    },
    handleSelectionChange(language, key) {
      this.$store.commit(`admission_setting/updatePageSetting`, {
        value: tinymce.get(`${key}_${language.abbreviation}`).getContent(),
        id: language.abbreviation,
        key: key,
      });
    },
    changeLanguageTab(language) {
      this.activeTab = language.abbreviation;
    },
    addUpdate() {
      this.$store.dispatch("admission_setting/addUpdateForm").then((res) => {
        if (res.data.status == "Success") {
          this.$store.commit("admission_setting/setLimit", 10);
          this.$store.commit("admission_setting/setSortBy", "id");
          this.$store.commit("admission_setting/setSortType", "desc");
          this.$store.dispatch("admission_setting/fetchSchoolPrograms");
        }
      });
    },
    fetchAdmissionSetting() {
      this.$store
        .dispatch("admission_setting/fetchAdmissionSetting", {
          url: `${process.env.MIX_WEB_API_URL}admission-setting?school_id=${this.$route.params.id}&is_admin=1`,
        })
        .then((res) => {
          console.log('admission res', res)
          //     this.$store.commit("admission_setting/setPageSetting", {
          //   key: "admission_apply_button_link",
          //   value: res?.data?.data?.admission_apply_button_link || "",
          // });

          // this.$store.commit("admission_setting/setPageSetting", {
          //   key: "admission_apply_button_title",
          //   value: res?.data?.data?.admission_apply_button_title || "",
          // });
          this.$store.commit("admission_setting/setPageSetting", {
            key: "customer_id",
            value: res?.data?.data?.customer_id,
          });
          this.$store.commit("admission_setting/setPageSetting", {
            key: "admission_apply_button_link",
            value: res?.data?.data?.admission_apply_button_link,
          });
          this.$store.commit("admission_setting/setPageSetting", {
            key: "admission_apply_button_title",
            value: res?.data?.data?.admission_apply_button_title,
          });
          this.$store.commit("admission_setting/setPageSetting", {
            key: "admission_red_bar_button_link",
            value: res?.data?.data?.admission_red_bar_button_link,
          });
          this.$store.commit("admission_setting/setPageSetting", {
            key: "admission_red_bar_button_title",
            value: res?.data?.data?.admission_red_bar_button_title,
          });
          this.$store.commit("admission_setting/setPageSetting", {
            key: "admission_blue_bar_button_link",
            value: res?.data?.data?.admission_blue_bar_button_link,
          });
          this.$store.commit("admission_setting/setPageSetting", {
            key: "admission_blue_bar_button_title",
            value: res?.data?.data?.admission_blue_bar_button_title,
          });
          let data =
            res.data.data && res.data.data.admission_setting_detail
              ? res.data.data.admission_setting_detail
              : [];
          let obj = {};
          data.map((res) => {
            obj["employees_pre_description_" + res.language_code] = res.employees_pre_description;
          });
          this.$store.commit("admission_setting/setPageSetting", {
            key: "employees_pre_description",
            value: obj,
          });


          obj = {};
          data.map((res) => {
            obj["employees_post_description_" + res.language_code] =
              res.employees_post_description;
          });
          this.$store.commit("admission_setting/setPageSetting", {
            key: "employees_post_description",
            value: obj,
          });


          obj = {};
          data.map((res) => {
            obj["team_post_description_" + res.language_code] =
              res.team_post_description;
          });
          this.$store.commit("admission_setting/setPageSetting", {
            key: "team_post_description",
            value: obj,
          });


          obj = {};
          data.map((res) => {
            obj["faq_pre_description_" + res.language_code] =
              res.faq_pre_description;
          });
          this.$store.commit("admission_setting/setPageSetting", {
            key: "faq_pre_description",
            value: obj,
          });


          obj = {};
          data.map((res) => {
            obj["faq_post_description_" + res.language_code] =
              res.faq_post_description;
          });
          this.$store.commit("admission_setting/setPageSetting", {
            key: "faq_post_description",
            value: obj,
          });

          obj = {};
          data.map((res) => {
            obj["team_pre_description_" + res.language_code] = res.team_pre_description;
          });
          this.$store.commit("admission_setting/setPageSetting", {
            key: "team_pre_description",
            value: obj,
          });

          this.isDataLoaded = 1;
        });
    },
  },

  mounted() {
    this.$store.commit("admission_setting/setPageSetting", {
      key: "school_id",
      value: this.$route?.params?.id,
    });
    this.$store
      .dispatch("languages/fetchLanguages", {
        url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
      })
      .then((res) => {
        if (res.data.status == "Success") {
          this.$store.commit("admission_setting/setLanguages", res.data.data);

          setTimeout(() => {
            let obj = {};
            res.data.data.map((res) => {
              obj["employees_pre_description_" + res.abbreviation] = "";
            });
            this.$store.commit("admission_setting/setPageSetting", {
              key: "employees_pre_description",
              value: obj,
            });

            obj = {};
            res.data.data.map((res) => {
              obj["employees_post_description_" + res.abbreviation] = "";
            });
            this.$store.commit("admission_setting/setPageSetting", {
              key: "employees_post_description",
              value: obj,
            });


            obj = {};
            res.data.data.map((res) => {
              obj["team_post_description_" + res.abbreviation] = "";
            });
            this.$store.commit("admission_setting/setPageSetting", {
              key: "team_post_description",
              value: obj,
            });


            obj = {};
            res.data.data.map((res) => {
              obj["faq_pre_description_" + res.abbreviation] = "";
            });
            this.$store.commit("admission_setting/setPageSetting", {
              key: "faq_pre_description",
              value: obj,
            });


            obj = {};
            res.data.data.map((res) => {
              obj["faq_post_description_" + res.abbreviation] = "";
            });
            this.$store.commit("admission_setting/setPageSetting", {
              key: "faq_post_description",
              value: obj,
            });


            obj = {};
            res.data.data.map((res) => {
              obj["team_pre_description_" + res.abbreviation] = "";
            });
            this.$store.commit("admission_setting/setPageSetting", {
              key: "team_pre_description",
              value: obj,
            });
            this.$store.commit("admission_setting/setPageSetting", {
              key: "admission_apply_button_link",
              value: res?.data?.data?.admission_apply_button_link || "",
            });

            this.$store.commit("admission_setting/setPageSetting", {
              key: "admission_apply_button_title",
              value: res?.data?.data?.admission_apply_button_title || "",
            });
            if (this.$route.params.id) {
              this.fetchAdmissionSetting();
            }
            else {
              this.isDataLoaded = 1;
            }
          }, [1000]);
        }
      });
  },
};
</script>
