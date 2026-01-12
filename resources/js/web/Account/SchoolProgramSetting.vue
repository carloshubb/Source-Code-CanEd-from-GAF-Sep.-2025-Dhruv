<template>
  <div class="md:col-span-8 col-span-12 w-full">
    <div class="modal-content py-6 text-left px-6">
      <div class="flex justify-between items-center pb-3">
        <h2 class="can-school-h2 text-primary">School Program</h2>
      </div>
      <div class="">
        <div class="text-sm font-medium text-center text-gray-500 dark:text-gray-400 dark:border-gray-700">
          <h3 class="text-left">Language</h3>
          <p class="text-left text-base font-normal text-gray-700">Select the languages under which you want your school
            profile to appear</p>
          <ul class="flex gap-2 flex-wrap my-4">
            <li class="mr-2" v-for="language in languages" :key="language.code">
              <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                activeTab != null && activeTab == language.language_code
                  ? 'text-white bg-primary active'
                  : '',
                errors.has(`title_1.title_1_${language.code}`)
                  ? 'bg-red-600 text-white hover:text-white'
                  : '',
              ]">{{ getLanguageName(language.language_code) }}</a>
            </li>
          </ul>
        </div>
        <div v-for="language in languages" :key="language.language_code"
          :class="activeTab == language.language_code ? 'block' : 'hidden'">
          <div class="w-full mt-2">
            <label class="block text-base lg:text-lg">Page title</label>
            <input type="text" placeholder="" name="title_1"
              class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'title_1', language)" :value="form['title_1'] &&
                  form['title_1'][`title_1_${language.language_code}`]
                  ? form['title_1'][`title_1_${language.language_code}`]
                  : ''
                " />
            <error :fieldName="`title_1.title_1_${language.language_code}`" :validationErros="errors" />
          </div>
          <div class="w-full mt-2">
            <label class="block text-base lg:text-lg mb-2">Page text</label>
            <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`title_1_paragraph_${language.language_code}`"
                    ></div> -->
            <editor @selectionChange="
              handleSelectionChange(language, 'title_1_paragraph')
              " placeholder="This is the text on top of the page; above the programs"
              :ref="`title_1_paragraph_${language.language_code}`" :id="`title_1_paragraph_${language.language_code}`"
              :initial-value="form[`title_1_paragraph`][
                `title_1_paragraph_${language?.language_code}`
                ]
                " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
            <error :fieldName="`title_1_paragraph.title_1_paragraph_${language.language_code}`"
              :validationErros="errors" />
          </div>
        </div>
        <div class="w-full mt-2 relative">
          <label for="school_program_apply_button_title" class="text-gray-700 font-semibold text-sm lg:text-base">School
            programs button title</label>
          <input id="school_program_apply_button_title" type="text" placeholder=""
            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="
              handleInput($event, `school_program_apply_button_title`)
              " :value="form?.[`school_program_apply_button_title`] || ''" />
          <error :fieldName="`school_program_apply_button_title`" :validationErros="errors" />
        </div>
        <div class="w-full mt-2 relative">
          <label for="school_program_apply_button_link" class="text-gray-700 font-semibold text-sm lg:text-base">School
            programs button link</label>
          <input id="school_program_apply_button_link" type="text" placeholder=""
            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="
              handleInput($event, `school_program_apply_button_link`)
              " :value="form?.[`school_program_apply_button_link`] || ''" />
          <error :fieldName="`school_program_apply_button_link`" :validationErros="errors" />
        </div>

        <div class="w-full mt-2 relative">
          <label for="school_program_blue_bar_button_title"
            class="text-gray-700 font-semibold text-sm lg:text-base">Good to go button title</label>
          <input id="school_program_blue_bar_button_title" type="text" placeholder=""
            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="
              handleInput($event, `school_program_blue_bar_button_title`)
              " :value="form?.[`school_program_blue_bar_button_title`] || ''" />
          <error :fieldName="`school_program_blue_bar_button_title`" :validationErros="errors" />
        </div>


        <div class="w-full mt-2 relative">
          <label for="school_program_blue_bar_button_link" class="text-gray-700 font-semibold text-sm lg:text-base">Good
            to go button link</label>
          <input id="school_program_blue_bar_button_link" type="text" placeholder=""
            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="
              handleInput($event, `school_program_blue_bar_button_link`)
              " :value="form?.[`school_program_blue_bar_button_link`] || ''" />
          <error :fieldName="`school_program_blue_bar_button_link`" :validationErros="errors" />
        </div>


        <div class="w-full mt-2 relative">
          <label for="school_program_red_bar_button_title"
            class="text-gray-700 font-semibold text-sm lg:text-base">Let's apply button title</label>
          <input id="school_program_red_bar_button_title" type="text" placeholder=""
            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="
              handleInput($event, `school_program_red_bar_button_title`)
              " :value="form?.[`school_program_red_bar_button_title`] || ''" />
          <error :fieldName="`school_program_red_bar_button_title`" :validationErros="errors" />
        </div>


        <div class="w-full mt-2 relative">
          <label for="school_program_red_bar_button_link" class="text-gray-700 font-semibold text-sm lg:text-base">Let's
            apply button link</label>
          <input id="school_program_red_bar_button_link" type="text" placeholder=""
            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
            @input="
              handleInput($event, `school_program_red_bar_button_link`)
              " :value="form?.[`school_program_red_bar_button_link`] || ''" />
          <error :fieldName="`school_program_red_bar_button_link`" :validationErros="errors" />
        </div>
        <div class="flex justify-end items-center gap-3 mt-4">
          <div>
            <button class="can-edu-btn-fill" @click="addUpdate">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <transition name="slide">
    <div id="defaultModal" tabindex="-1" aria-hidden="true"
      class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
      v-if="showPopUpModal">
      <div class="relative w-full rounded-2xl bg-white shadow-2xl border-4 border-primary/30 h-full max-w-lg md:h-auto"
        ref="elementToDetectClick">
        <div class="relative">
          <div class="absolute top-3 right-3 cursor-pointer" @click="togglePopUpModal">
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
          </div>
          <div class="bg-white py-6 px-10 rounded-2xl pt-10 ">
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
import Editor from "@tinymce/tinymce-vue";
import axios from "axios";
import { mapState } from "vuex";
import Error from "../Error.vue";
export default {
  components: { Error, editor: Editor },
  props: ["logged_in_customer", "school_id", "languages_with_names"],
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
    parsedLanguages() {
      if (typeof this.languages_with_names === 'string') {
        try {
          return JSON.parse(this.languages_with_names);
        } catch (error) {
          console.error('Error parsing JSON:', error);
          return []; // Return an empty array as a fallback
        }
      }
      return this.languages_with_names; // Return as is if already an array or object
    }
  },
  data() {
    return {
      showPopUpModal: false,
      popupMsg: '',
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
    togglePopUpModal() {
      this.showPopUpModal = !this.showPopUpModal;
      if (!this.showPopUpModal) {
        // window.location.reload();
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
          // window.location.reload();

        }
      }
    },
    getLanguageName(language_code) {
      const languages = this.parsedLanguages; // Use the computed property
      if (Array.isArray(languages)) {
        const language = languages.find(
          (lang) => lang.language_code === language_code
        );
        return language ? language.language_name : language_code;
      }
      return language_code; // Fallback if parsedLanguages is not an array
    },
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
        value: tinymce.get(`${key}_${language.language_code}`).getContent(),
        id: language.language_code,
        key: key,
      });
    },
    changeLanguageTab(language) {
      this.activeTab = language.language_code;
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
              "school_program_settings/fetchSchoolProgramSettings"
            );
            this.showPopUpModal = true;
            this.popupMsg = res.data.message;
          }
        }).catch((error) => {
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
    fetchSchoolProgramSettings() {
      this.$store
        .dispatch("school_program_settings/fetchSchoolProgramSettings", {
          url: `${process.env.MIX_WEB_API_URL}school-program-settings?withSchoolProgramSettingDetail=1`,
        })
        .then((res) => {
          this.$store.commit("school_program_settings/setForData", {
            key: "school_program_apply_button_title",
            value: res.data.data?.school_program_apply_button_title,
          });
          this.$store.commit("school_program_settings/setForData", {
            key: "school_program_apply_button_link",
            value: res.data.data?.school_program_apply_button_link,
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
      key: "customer_id",
      value: this.logged_in_customer,
    });
    this.$store.commit("school_program_settings/setForData", {
      key: "school_id",
      value: this.school_id,
    });
    axios
      .get("/api/web/customer-languages?customer_id=" + this.logged_in_customer)
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
                obj[moreFields[i] + "_" + res.language_code] = "";
              });
              this.$store.commit("school_program_settings/setForData", {
                key: moreFields[i],
                value: obj,
              });

              obj = {};
              data.map((res) => {
                obj["title_1" + "_" + res.language_code] = "";
              });
              this.$store.commit("school_program_settings/setForData", {
                key: "title_1",
                value: obj,
              });
            }
            this.fetchSchoolProgramSettings();
          }, 1000);
        }
      });
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
/* Slide Animation */
.slide-enter-active, .slide-leave-active {
  transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}
.slide-enter-from, .slide-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}
</style>