<template>
    <div class="md:col-span-9 col-span-12 border border-gray-500 p-4 rounded-md w-full overflow-hidden">
        <div class="mt-4 flex justify-between items-center gap-2 p-2">
          <h2 class="can-school-h2 text-primary">School ambassadors</h2>
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
                  errors.has(`main_paragraph.main_paragraph_${language.code}`)
                    ? 'bg-red-600 text-white hover:text-white'
                    : '',
                ]">{{ getLanguageName(language.language_code) }}</a>
              </li>
            </ul>
          </div>
          <!-- <div v-for="language in languages" :key="language.language_code"
            :class="activeTab == language.language_code ? 'block' : 'hidden'">
            <div class="w-full mt-2" >
              <label class="block text-base lg:text-lg mb-2">Title 1 Paragraph</label>
              <editor @selectionChange="handleSelectionChange(language, 'top_paragraph')"
                :ref="`top_paragraph_${language.language_code}`" :id="`top_paragraph_${language.language_code}`"
                :initial-value="form[`top_paragraph`][
                  `top_paragraph_${language?.language_code}`
                  ]
                  " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
              <error :fieldName="`top_paragraph.top_paragraph_${language.language_code}`" :validationErros="errors" />
            </div>
  
             <div class="w-full mt-2" v-if="isDataLoaded">
              <label class="block text-base lg:text-lg mb-2">Brief description</label>
              <editor @selectionChange="handleSelectionChange(language, 'brief_description')"
                :ref="`brief_description_${language.language_code}`" :id="`brief_description_${language.language_code}`"
                :initial-value="form[`brief_description`][
                  `brief_description_${language?.language_code}`
                  ]
                  " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
              <error :fieldName="`brief_description.brief_description_${language.language_code}`"
                :validationErros="errors" />
            </div> 
          </div> -->
          <!-- <div class="w-full mt-2 relative">
            <label for="" class="block text-base lg:text-lg">Contact button Title</label>
            <input type="text" placeholder=""
              class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'school_contact_apply_button_title', '')" :value="form['school_contact_apply_button_title']
                  ? form['school_contact_apply_button_title']
                  : ''
                " />
            <error :fieldName="`school_contact_apply_button_title`" :validationErros="errors" />
          </div>
          <div class="w-full mt-2 relative">
            <label for="" class="block text-base lg:text-lg">Contact button link</label>
            <input type="text" placeholder=""
              class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'school_contact_apply_button_link', '')" :value="form['school_contact_apply_button_link']
                  ? form['school_contact_apply_button_link']
                  : ''
                " />
            <error :fieldName="`school_contact_apply_button_link`" :validationErros="errors" />
          </div>
  
          <div class="w-full mt-2 relative">
            <label for="" class="block text-base lg:text-lg">Good to go button title</label>
            <input type="text" placeholder=""
              class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'school_contact_blue_bar_button_title', '')" :value="form['school_contact_blue_bar_button_title']
                  ? form['school_contact_blue_bar_button_title']
                  : ''
                " />
            <error :fieldName="`school_contact_blue_bar_button_title`" :validationErros="errors" />
          </div>
          <div class="w-full mt-2 relative">
            <label for="" class="block text-base lg:text-lg">Good to go button link</label>
            <input type="text" placeholder=""
              class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'school_contact_blue_bar_button_link', '')" :value="form['school_contact_blue_bar_button_link']
                  ? form['school_contact_blue_bar_button_link']
                  : ''
                " />
            <error :fieldName="`school_contact_blue_bar_button_link`" :validationErros="errors" />
          </div>
  
  
          <div class="w-full mt-2 relative">
            <label for="" class="block text-base lg:text-lg">Apply now's button title</label>
            <input type="text" placeholder=""
              class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'school_contact_red_bar_button_title', '')" :value="form['school_contact_red_bar_button_title']
                  ? form['school_contact_red_bar_button_title']
                  : ''
                " />
            <error :fieldName="`school_contact_red_bar_button_title`" :validationErros="errors" />
          </div>
          <div class="w-full mt-2 relative">
            <label for="" class="block text-base lg:text-lg">Apply now's button link</label>
            <input type="text" placeholder=""
              class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'school_contact_red_bar_button_link', '')" :value="form['school_contact_red_bar_button_link']
                  ? form['school_contact_red_bar_button_link']
                  : ''
                " />
            <error :fieldName="`school_contact_red_bar_button_link`" :validationErros="errors" />
          </div> -->
        
          <div class="w-full mt-2 relative">
            <label for="" class="block text-base lg:text-lg">Heading text</label>
            <input type="text" placeholder="" name="heading_text"
              class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
              @input="handleInput($event, 'heading_text', '')" :value="form['heading_text']
                  ? form['heading_text']
                  : ''
                " />
            <error :fieldName="`heading_text`" :validationErros="errors" />
          </div>
      
  
          <div class="w-full mt-4">
            <label class="block text-base lg:text-lg">Image</label>
            <input type="file" name="main_photo"
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
              <button class="can-edu-btn-fill" @click="addUpdate">Submit</button>
            </div>
          </div>
        </div>
    </div>
    <transition name="slide">
      <div id="defaultModal" tabindex="-1" aria-hidden="true"
        class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
        v-if="showPopUpModal">
        <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
          ref="elementToDetectClick">
          <div class="relative">
            <div class="absolute top-2 right-2 cursor-pointer" @click="togglePopUpModal">
              <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <path
                  d="M14.348 14.849a1 1 0 0 1-1.415 0L10 11.415l-2.933 2.934a1 1 0 1 1-1.415-1.415l2.934-2.933L5.651 7.068a1 1 0 1 1 1.415-1.415L10 8.585l2.933-2.934a1 1 0 0 1 1.415 1.415l-2.934 2.933 2.934 2.933a1 1 0 0 1 0 1.415z" />
              </svg>
            </div>
            <div class="bg-white py-6 px-10 rounded shadow-lg text-center">
              <p class="text-center can-edu-p mt-2">
                {{
                  popupMsg
                }} </p>
                <div class="flex justify-center">
              <button type="button" class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4"
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
        form: (state) => state.school_ambassador_settings.form,
        school_ambassador_settings: (state) =>
          state.school_ambassador_settings.school_ambassador_settings,
        is_featured_array: (state) =>
          state.school_ambassador_settings.is_featured_array,
        errors: (state) => state.school_ambassador_settings.errors,
        isLoading: (state) => state.school_ambassador_settings.isLoading,
        languages: (state) => state.school_ambassador_settings.languages,
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
        const languages = this.parsedLanguages;
        console.log(languages);
        if (Array.isArray(languages)) {
          const language = languages.find(
            (lang) => lang.language_code === language_code
          );
          return language ? language.language_name : language_code;
        }
        return language_code;
      },
      handleIsFeatured(val, key) {
        this.$store.commit("school_ambassador_settings/setIsFeatured", {
          checked: val,
          key,
        });
      },
      closeModal() {
        this.$store.commit("school_ambassador_settings/setShowModal", 0);
      },
      handleInput(e, key, language) {
        this.$store.commit("school_ambassador_settings/setForData", {
          key,
          language: language ? language : "",
          value: e.target.value,
        });
      },
      handleImage(e) {
        // console.log(e.target.files[0], key, language, mutationName);
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
          value: null, // Removes the image
        });
      },
      handleSelectionChange(language, key) {
        this.$store.commit(`school_ambassador_settings/udpateFormData`, {
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
          .dispatch("school_ambassador_settings/addUpdateForm")
          .then((res) => {
            if (res.data.status == "Success") {
              this.showPopUpModal = true;
              this.popupMsg = res.data.message;
              this.$store.commit("school_ambassador_settings/setLimit", 10);
              this.$store.commit("school_ambassador_settings/setSortBy", "id");
              this.$store.commit("school_ambassador_settings/setSortType", "desc");
              this.$store.dispatch(
                "school_ambassador_settings/fetchSchoolAmbassadorSettings"
              );
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
      fetchSchoolAmbassadorSettings() {
        this.$store
          .dispatch("school_ambassador_settings/fetchSchoolAmbassadorSettings", {
            url: `${process.env.MIX_WEB_API_URL}school-ambassador-settings?withSchoolAmbassadorSettingDetail=1`,
          })
          .then((res) => {
            console.log('contact res', res)
            // this.$store.commit("school_ambassador_settings/setForData", {
            //   key: "school_contact_apply_button_title",
            //   value: res.data.data?.school_contact_apply_button_title,
            // });
            // this.$store.commit("school_ambassador_settings/setForData", {
            //   key: "school_contact_apply_button_link",
            //   value: res.data.data?.school_contact_apply_button_link,
            // });
            // this.$store.commit("school_ambassador_settings/setForData", {
            //   key: "school_contact_red_bar_button_link",
            //   value: res.data.data?.school_contact_red_bar_button_link,
            // });
            // this.$store.commit("school_ambassador_settings/setForData", {
            //   key: "school_contact_red_bar_button_title",
            //   value: res.data.data?.school_contact_red_bar_button_title,
            // });
            // this.$store.commit("school_ambassador_settings/setForData", {
            //   key: "school_contact_blue_bar_button_link",
            //   value: res.data.data?.school_contact_blue_bar_button_link,
            // });
            // this.$store.commit("school_ambassador_settings/setForData", {
            //   key: "school_contact_blue_bar_button_title",
            //   value: res.data.data?.school_contact_blue_bar_button_title,
            // });
            this.$store.commit("school_ambassador_settings/setForData", {
              key: "heading_text",
              value: res.data.data?.heading_text,
            });
            this.$store.commit("school_ambassador_settings/setForData", {
              key: "main_photo",
              value: res.data.data?.main_photo,
            });
            let data =
              res.data.data && res.data.data.school_ambassador_setting_detail
                ? res.data.data.school_ambassador_setting_detail
                : [];
  
            var moreFields1 = ["top_paragraph"];
            for (var i = 0; i < moreFields1?.length; i++) {
              let obj = {};
              data.map((res) => {
                obj[moreFields1[i] + "_" + res.language_code] =
                  res[moreFields1[i]];
              });
              this.$store.commit("school_ambassador_settings/setForData", {
                key: moreFields1[i],
                value: obj,
              });
            }
            this.isDataLoaded = 1;
          });
      },
    },
  
    created() {
      this.$store.commit("school_ambassador_settings/setForData", {
        key: "customer_id",
        value: this.logged_in_customer,
      });
      this.$store.commit("school_ambassador_settings/setForData", {
        key: "school_id",
        value: this.school_id,
      });
      axios
        .get("/api/web/customer-languages?customer_id=" + this.logged_in_customer)
    
        .then((res) => {
          if (res.data.status == "Success") {
            this.$store.commit("school_ambassador_settings/setLanguages", res.data.data);
  
            setTimeout(() => {
              let data = res.data.data;
              let moreFields = ["top_paragraph"];
  
              moreFields.forEach((field) => {
                let obj = {};
                data.forEach((res) => {
                  obj[field + "_" + res.language_code] = "";
  
                  // Ensure this function exists
                  if (typeof this.createEditorInstance === "function") {
                    this.createEditorInstance(
                      field + "_" + res.language_code,
                      field,
                      res,
                      "setForData"
                    );
                  } else {
                    console.error("createEditorInstance is not a function", this);
                  }
                });
  
                this.$store.commit("school_ambassador_settings/setForData", {
                  key: field,
                  value: obj,
                });
              });
  
              this.fetchSchoolAmbassadorSettings();
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