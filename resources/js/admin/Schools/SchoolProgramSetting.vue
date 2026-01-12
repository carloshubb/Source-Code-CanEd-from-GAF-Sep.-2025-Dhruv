<template>
  <div
    class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full"
  >
    <div class="modal-content py-6 text-left px-6">
      <div class="flex justify-between items-center pb-3">
        <h2 class="can-admin-h2">School Program</h2>
      </div>
      <div class="modal-body">
        <div
          class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
        >
          <ul class="flex gap-2 flex-wrap my-4">
            <li class="mr-2" v-for="language in languages" :key="language.code">
              <a
                @click.prevent="changeLanguageTab(language)"
                href="#"
                :class="[
                  'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                  activeTab != null && activeTab == language.abbreviation
                    ? 'text-white bg-primary active'
                    : '',
                  errors.has(`title_1.title_1_${language.code}`)
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
            <label class="text-gray-700 font-semibold text-sm lg:text-base"
              >Title 1</label
            >
            <input
              type="text"
              placeholder="Name"
              class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'title_1', language)"
              :value="
                form['title_1'] &&
                form['title_1'][`title_1_${language.abbreviation}`]
                  ? form['title_1'][`title_1_${language.abbreviation}`]
                  : ''
              "
            />
            <error
              :fieldName="`title_1.title_1_${language.abbreviation}`"
              :validationErros="errors"
            />
          </div>
          <div class="w-full mt-2" v-if="isDataLoaded">
            <label class="text-gray-700 font-semibold text-sm lg:text-base"
              >Title 1 Paragraph</label
            >
            <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`title_1_paragraph_${language.abbreviation}`"
                    ></div> -->
            <editor
              @selectionChange="
                handleSelectionChange(language, 'title_1_paragraph')
              "
              :ref="`title_1_paragraph_${language.abbreviation}`"
              :id="`title_1_paragraph_${language.abbreviation}`"
              :initial-value="
                form[`title_1_paragraph`][
                  `title_1_paragraph_${language?.abbreviation}`
                ]
              "
              :init="editorConfig"
              :tinymce-script-src="tinymceScriptSrc"
            />
            <error
              :fieldName="`title_1_paragraph.title_1_paragraph_${language.abbreviation}`"
              :validationErros="errors"
            />
          </div>
        </div>
        <div class="w-full mt-2 relative">
          <label
            for="school_program_apply_button_title"
            class="text-gray-700 font-semibold text-sm lg:text-base"
            >School programs button title</label
          >
          <input
            id="school_program_apply_button_title"
            type="text"
            placeholder=""
            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="
              handleInput($event, `school_program_apply_button_title`)
            "
            :value="form?.[`school_program_apply_button_title`] || ''"
          />
          <error
            :fieldName="`school_program_apply_button_title`"
            :validationErros="errors"
          />
        </div>
        <div class="w-full mt-2 relative">
          <label
            for="school_program_apply_button_link"
            class="text-gray-700 font-semibold text-sm lg:text-base"
            >School programs button link</label
          >
          <input
            id="school_program_apply_button_link"
            type="text"
            placeholder=""
            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="
              handleInput($event, `school_program_apply_button_link`)
            "
            :value="form?.[`school_program_apply_button_link`] || ''"
          />
          <error
            :fieldName="`school_program_apply_button_link`"
            :validationErros="errors"
          />
        </div>

        <div class="w-full mt-2 relative">
          <label
            for="school_program_blue_bar_button_title"
            class="text-gray-700 font-semibold text-sm lg:text-base"
            >Good to go button title</label
          >
          <input
            id="school_program_blue_bar_button_title"
            type="text"
            placeholder=""
            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="
              handleInput($event, `school_program_blue_bar_button_title`)
            "
            :value="form?.[`school_program_blue_bar_button_title`] || ''"
          />
          <error
            :fieldName="`school_program_blue_bar_button_title`"
            :validationErros="errors"
          />
        </div>

        
        <div class="w-full mt-2 relative">
          <label
            for="school_program_blue_bar_button_link"
            class="text-gray-700 font-semibold text-sm lg:text-base"
            >Good to go button link</label
          >
          <input
            id="school_program_blue_bar_button_link"
            type="text"
            placeholder=""
            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="
              handleInput($event, `school_program_blue_bar_button_link`)
            "
            :value="form?.[`school_program_blue_bar_button_link`] || ''"
          />
          <error
            :fieldName="`school_program_blue_bar_button_link`"
            :validationErros="errors"
          />
        </div>


        <div class="w-full mt-2 relative">
          <label
            for="school_program_red_bar_button_title"
            class="text-gray-700 font-semibold text-sm lg:text-base"
            >Let's apply button title</label
          >
          <input
            id="school_program_red_bar_button_title"
            type="text"
            placeholder=""
            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="
              handleInput($event, `school_program_red_bar_button_title`)
            "
            :value="form?.[`school_program_red_bar_button_title`] || ''"
          />
          <error
            :fieldName="`school_program_red_bar_button_title`"
            :validationErros="errors"
          />
        </div>

        
        <div class="w-full mt-2 relative">
          <label
            for="school_program_red_bar_button_link"
            class="text-gray-700 font-semibold text-sm lg:text-base"
            >Let's apply button link</label
          >
          <input
            id="school_program_red_bar_button_link"
            type="text"
            placeholder=""
            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="
              handleInput($event, `school_program_red_bar_button_link`)
            "
            :value="form?.[`school_program_red_bar_button_link`] || ''"
          />
          <error
            :fieldName="`school_program_red_bar_button_link`"
            :validationErros="errors"
          />
        </div>





        <div class="flex justify-center items-center gap-3 mt-4">
            <button class="can-edu-btn-fill" @click="addUpdate">Submit</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Editor from "@tinymce/tinymce-vue";
import { mapState } from "vuex";
import Error from "./Error.vue";
export default {
  components: { Error, editor: Editor },
  props: ["logged_in_customer", "school_id"],
  computed: {
    ...mapState({
      form: (state) => state.school_program_settings.form,
      school_program_settings: (state) =>
        state.school_program_settings.school_program_settings,
      is_featured_array: (state) =>
        state.school_program_settings.is_featured_array,
      errors: (state) => state.school_program_settings.errors,
      isLoading: (state) => state.school_program_settings.isLoading,
      languages: (state) => state.school_program_settings.languages,
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
    handleIsFeatured(val, key) {
      this.$store.commit("school_program_settings/setIsFeatured", {
        checked: val,
        key,
      });
    },
    closeModal() {
      this.$store.commit("school_program_settings/setShowModal", 0);
    },
    handleInput(e, key, language) {
      this.$store.commit("school_program_settings/setForData", {
        key,
        language: language ? language : "",
        value: e.target.value,
      });
    },
    handleSelectionChange(language, key) {
      this.$store.commit(`school_program_settings/updateFormData`, {
        value: tinymce.get(`${key}_${language.abbreviation}`).getContent(),
        id: language.abbreviation,
        key: key,
      });
    },
    changeLanguageTab(language) {
      this.activeTab = language.abbreviation;
    },
    addUpdate() {
      this.$store
        .dispatch("school_program_settings/addUpdateForm")
        .then((res) => {
          if (res.data.status == "Success") {
            this.$store.commit("school_program_settings/setLimit", 10);
            this.$store.commit("school_program_settings/setSortBy", "id");
            this.$store.commit("school_program_settings/setSortType", "desc");
            this.$store.dispatch(
              "school_program_settings/fetchSchoolProgramSettings",
              {
                url: `${process.env.MIX_WEB_API_URL}school-program-settings?withSchoolProgramSettingDetail=1&is_admin=1&school_id=${this.$route.params.id}`,
              }
            );
          }
        });
    },
    fetchSchoolProgramSettings() {
      this.$store
        .dispatch("school_program_settings/fetchSchoolProgramSettings", {
          url: `${process.env.MIX_WEB_API_URL}school-program-settings?withSchoolProgramSettingDetail=1&is_admin=1&school_id=${this.$route.params.id}`,
        })
        .then((res) => {
          this.$store.commit("school_program_settings/setForData", {
            key: "customer_id",
            value: res.data.data?.customer_id,
          });
          this.$store.commit("school_program_settings/setForData", {
            key: "school_program_apply_button_link",
            value: res.data.data?.school_program_apply_button_link,
          });
          this.$store.commit("school_program_settings/setForData", {
            key: "school_program_apply_button_title",
            value: res.data.data?.school_program_apply_button_title,
          });
          this.$store.commit("school_program_settings/setForData", {
            key: "school_program_red_bar_button_link",
            value: res.data.data?.school_program_red_bar_button_link,
          });
          this.$store.commit("school_program_settings/setForData", {
            key: "school_program_red_bar_button_title",
            value: res.data.data?.school_program_red_bar_button_title,
          });
          this.$store.commit("school_program_settings/setForData", {
            key: "school_program_blue_bar_button_title",
            value: res.data.data?.school_program_blue_bar_button_title,
          });
          this.$store.commit("school_program_settings/setForData", {
            key: "school_program_blue_bar_button_link",
            value: res.data.data?.school_program_blue_bar_button_link,
          });
          let data =
            res.data.data && res.data.data.school_program_setting_detail
              ? res.data.data.school_program_setting_detail
              : [];

          var moreFields1 = ["title_1_paragraph"];
          for (var i = 0; i < moreFields1?.length; i++) {
            let obj = {};
            data.map((res) => {
              obj[moreFields1[i] + "_" + res.language_code] =
                res[moreFields1[i]];
            });
            this.$store.commit("school_program_settings/setForData", {
              key: moreFields1[i],
              value: obj,
            });
            obj = {};
            data.map((res) => {
              obj["title_1" + "_" + res.language_code] = res?.title_1;
            });
            this.$store.commit("school_program_settings/setForData", {
              key: "title_1",
              value: obj,
            });
          }
          this.isDataLoaded = 1;
        });
    },
  },

  created() {
    this.$store.commit("school_program_settings/setForData", {
      key: "school_id",
      value: this.$route.params.id,
    });
    this.$store
      .dispatch("languages/fetchLanguages", {
        url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
      })
      .then((res) => {
        if (res.data.status == "Success") {
          this.$store.commit(
            "school_program_settings/setLanguages",
            res.data.data
          );

          setTimeout(() => {
            let data = res.data.data;
            var moreFields = ["title_1_paragraph"];
            for (var i = 0; i < moreFields?.length; i++) {
              let obj = {};
              data.map((res) => {
                obj[moreFields[i] + "_" + res.abbreviation] = "";
              });
              this.$store.commit("school_program_settings/setForData", {
                key: moreFields[i],
                value: obj,
              });

              obj = {};
              data.map((res) => {
                obj["title_1" + "_" + res.abbreviation] = "";
              });
              this.$store.commit("school_program_settings/setForData", {
                key: "title_1",
                value: obj,
              });
            }
            if (this.$route.params.id) {
              this.fetchSchoolProgramSettings();
            } else {
              this.isDataLoaded = 1;
            }
          }, 1000);
        }
      });
  },
};
</script>
