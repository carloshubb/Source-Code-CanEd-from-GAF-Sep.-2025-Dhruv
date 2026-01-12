<template>
    <div class="modal-content py-6 text-left px-6">
        <div class="flex justify-between items-center pb-3">
            <h2 class="can-school-h2 text-primary mb-0">Admissions</h2>
        </div>
        <div class="modal-body">
            <div
                class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
            >
            <h3 class="text-left">Language</h3>
            <p class="text-left text-base font-normal text-gray-700">Select the languages under which you want your school profile to appear</p>
                <ul class="flex gap-2 flex-wrap my-4">
                    <li
                        class="mr-2 mb-2"
                        v-for="language in languages"
                        :key="language.code"
                    >
                        <a
                            @click.prevent="changeLanguageTab(language)"
                            href="#"
                            :class="[
                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                activeTab != null &&
                                activeTab == language.language_code
                                    ? 'text-white bg-primary active'
                                    : '',
                                validationErros.has(
                                    `employees_pre_description.employees_pre_description_${language.code}`
                                )
                                    ? 'bg-red-600 text-white hover:text-white'
                                    : '',
                            ]"
                            >{{ getLanguageName(language.language_code) }}</a
                        >
                    </li>
                </ul>
            </div>
            <div
                v-for="language in languages"
                :key="language.language_code"
                :class="
                    activeTab == language.language_code ? 'block' : 'hidden'
                "
            >
        <div class="w-full mt-2" v-if="isDataLoaded">
          <label class="block text-base lg:text-lg mb-2"
            >Employee pre-description</label
          >
          <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`employees_pre_description_${language.language_code}`"
                    ></div> -->
          <editor
            @selectionChange="handleSelectionChange(language, 'employees_pre_description')"
            :ref="`employees_pre_description_${language.language_code}`"
            :id="`employees_pre_description_${language.language_code}`"
            :initial-value="
              form[`employees_pre_description`][`employees_pre_description_${language?.language_code}`]
            "
            :init="editorConfig"
            :tinymce-script-src="tinymceScriptSrc"
          />
          <error
            :fieldName="`employees_pre_description.employees_pre_description_${language.language_code}`"
            :validationErros="validationErros"
          />
        </div>
        <div class="w-full mt-2" v-if="isDataLoaded">
          <label class="block text-base lg:text-lg mb-2"
            >Employee post-description</label
          >
          <!-- <div
                    class="mt-5 ckeditorText"
                    :id="`employees_post_description_${language.language_code}`"
                ></div> -->
          <editor
            @selectionChange="
              handleSelectionChange(language, 'employees_post_description')
            "
            :ref="`employees_post_description_${language.language_code}`"
            :id="`employees_post_description_${language.language_code}`"
            :initial-value="
              form[`employees_post_description`][
                `employees_post_description_${language?.language_code}`
              ]
            "
            :init="editorConfig"
            :tinymce-script-src="tinymceScriptSrc"
          />
          <error
            :fieldName="`employees_post_description.employees_post_description_${language.language_code}`"
            :validationErros="validationErros"
          />
        </div>
        <div class="w-full mt-2" v-if="isDataLoaded">
          <label class="block text-base lg:text-lg mb-2"
            >Team pre-description</label
          >
          <!-- <div
                    class="mt-5 ckeditorText"
                    :id="`team_pre_description_${language.language_code}`"
                ></div> -->
          <editor
            @selectionChange="handleSelectionChange(language, 'team_pre_description')"
            :ref="`team_pre_description_${language.language_code}`"
            :id="`team_pre_description_${language.language_code}`"
            :initial-value="
              form[`team_pre_description`][`team_pre_description_${language?.language_code}`]
            "
            :init="editorConfig"
            :tinymce-script-src="tinymceScriptSrc"
          />
          <error
            :fieldName="`team_pre_description.team_pre_description_${language.language_code}`"
            :validationErros="validationErros"
          />
        </div>
        <div class="w-full mt-2" v-if="isDataLoaded">
          <label class="block text-base lg:text-lg mb-2"
            >Team post-description</label
          >
          <!-- <div
                    class="mt-5 ckeditorText"
                    :id="`team_post_description_${language.language_code}`"
                ></div> -->
          <editor
            @selectionChange="
              handleSelectionChange(language, 'team_post_description')
            "
            :ref="`team_post_description_${language.language_code}`"
            :id="`team_post_description_${language.language_code}`"
            :initial-value="
              form[`team_post_description`][
                `team_post_description_${language?.language_code}`
              ]
            "
            :init="editorConfig"
            :tinymce-script-src="tinymceScriptSrc"
          />
          <error
            :fieldName="`team_post_description.team_post_description_${language.language_code}`"
            :validationErros="validationErros"
          />
        </div>
        <div class="w-full mt-2" v-if="isDataLoaded">
          <label class="block text-base lg:text-lg mb-2"
            >FAQ pre-description</label
          >
          <!-- <div
                    class="mt-5 ckeditorText"
                    :id="`faq_pre_description_${language.language_code}`"
                ></div> -->
          <editor
            @selectionChange="
              handleSelectionChange(language, 'faq_pre_description')
            "
            :ref="`faq_pre_description_${language.language_code}`"
            :id="`faq_pre_description_${language.language_code}`"
            :initial-value="
              form[`faq_pre_description`][
                `faq_pre_description_${language?.language_code}`
              ]
            "
            :init="editorConfig"
            :tinymce-script-src="tinymceScriptSrc"
          />
          <error
            :fieldName="`faq_pre_description.faq_pre_description_${language.language_code}`"
            :validationErros="validationErros"
          />
        </div>
        <div class="w-full mt-2" v-if="isDataLoaded">
          <label class="block text-base lg:text-lg mb-2"
            >FAQ post-description</label
          >
          <!-- <div
                    class="mt-5 ckeditorText"
                    :id="`faq_post_description_${language.language_code}`"
                ></div> -->
          <editor
            @selectionChange="
              handleSelectionChange(language, 'faq_post_description')
            "
            :ref="`faq_post_description_${language.language_code}`"
            :id="`faq_post_description_${language.language_code}`"
            :initial-value="
              form[`faq_post_description`][
                `faq_post_description_${language?.language_code}`
              ]
            "
            :init="editorConfig"
            :tinymce-script-src="tinymceScriptSrc"
          />
          <error
            :fieldName="`faq_post_description.faq_post_description_${language.language_code}`"
            :validationErros="validationErros"
          />
        </div>
        <div class="w-full mt-2 relative">
            <label
                for=""
                class="block text-base lg:text-lg"
                >Admission button Title</label
            >
            <input
                type="text"
                name="admission_apply_button_title"
                placeholder=""
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'admission_apply_button_title', '')"
                :value="
                    form['admission_apply_button_title']
                        ? form['admission_apply_button_title']
                        : ''
                "
            />
            <error
                :fieldName="`admission_apply_button_title`"
                :validationErros="validationErros"
            />
        </div>
          <div class="w-full mt-2 relative">
            <label
                for=""
                class="block text-base lg:text-lg"
                >Admission button link</label
            >
            <input
                type="text"
                name="admission_apply_button_link"
                placeholder=""
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'admission_apply_button_link', '')"
                :value="
                    form['admission_apply_button_link']
                        ? form['admission_apply_button_link']
                        : ''
                "
            />
            <error
                :fieldName="`admission_apply_button_link`"
                :validationErros="validationErros"
            />
        </div>

        <div class="w-full mt-2 relative">
            <label
                for=""
                class="block text-base lg:text-lg"
                >Good to go button title</label
            >
            <input
                type="text"
                placeholder=""
                name="admission_blue_bar_button_title"
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'admission_blue_bar_button_title', '')"
                :value="
                    form['admission_blue_bar_button_title']
                        ? form['admission_blue_bar_button_title']
                        : ''
                "
            />
            <error
                :fieldName="`admission_blue_bar_button_title`"
                :validationErros="validationErros"
            />
        </div>
        <div class="w-full mt-2 relative">
            <label
                for=""
                class="block text-base lg:text-lg"
                >Good to go button link</label
            >
            <input
                type="text"
                placeholder=""
                name="admission_blue_bar_button_link"
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'admission_blue_bar_button_link', '')"
                :value="
                    form['admission_blue_bar_button_link']
                        ? form['admission_blue_bar_button_link']
                        : ''
                "
            />
            <error
                :fieldName="`admission_blue_bar_button_link`"
                :validationErros="validationErros"
            />
        </div>


        <div class="w-full mt-2 relative">
            <label
                for=""
                class="block text-base lg:text-lg"
                >Let's apply button title</label
            >
            <input
                type="text"
                placeholder=""
                name="admission_red_bar_button_title"
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'admission_red_bar_button_title', '')"
                :value="
                    form['admission_red_bar_button_title']
                        ? form['admission_red_bar_button_title']
                        : ''
                "
            />
            <error
                :fieldName="`admission_red_bar_button_title`"
                :validationErros="validationErros"
            />
        </div>
        <div class="w-full mt-2 relative">
            <label
                for=""
                class="block text-base lg:text-lg"
                >Let's apply button link</label
            >
            <input
                type="text"
                placeholder=""
                name="admission_red_bar_button_link"
                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                @input="handleInput($event, 'admission_red_bar_button_link', '')"
                :value="
                    form['admission_red_bar_button_link']
                        ? form['admission_red_bar_button_link']
                        : ''
                "
            />
            <error
                :fieldName="`admission_red_bar_button_link`"
                :validationErros="validationErros"
            />
        </div>
        
        
      </div>
            <div class="flex justify-end items-center gap-3 mt-4">
                <div>
                    <button class="can-edu-btn-fill" @click="addUpdate">
                        Submit
                    </button>
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
import Editor from "@tinymce/tinymce-vue";
import axios from "axios";
import { mapState } from "vuex";
import Error from '../Error.vue';
export default {
  components: { Error, editor: Editor },
    props: ["logged_in_customer", "school_id" , "languages_with_names"],
    computed: {
        ...mapState({
            form: (state) => state.admission_setting.form,
            admission_setting: (state) =>
                state.admission_setting.admission_setting,
            validationErros: (state) => state.admission_setting.validationErros,
            isLoading: (state) => state.admission_setting.isLoading,
            languages: (state) => state.admission_setting.form.languages,
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
        closeModal() {
            this.$store.commit("admission_setting/setShowModal", 0);
        },
        // handleInput(e, key, language) {
        //     this.$store.commit("admission_setting/updatePageSetting", {
        //         key,
        //         id: language.language_code,
        //         value: e.target.value,
        //     });
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
                value: tinymce.get(`${key}_${language.language_code}`).getContent(),
                id: language.language_code,
                key:key,
            });
        },
        changeLanguageTab(language) {
            this.activeTab = language.language_code;
        },
        addUpdate() {
            this.$store
                .dispatch("admission_setting/addUpdateForm")
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.showPopUpModal = true;
                        this.popupMsg = res.data.message;
                        this.$store.commit("admission_setting/setLimit", 10);
                        this.$store.commit("admission_setting/setSortBy", "id");
                        this.$store.commit(
                            "admission_setting/setSortType",
                            "desc"
                        );
                        this.$store.dispatch(
                            "admission_setting/fetchSchoolPrograms"
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
        fetchAdmissionSetting() {
            this.$store
                .dispatch("admission_setting/fetchAdmissionSetting", {
                    url: `${process.env.MIX_WEB_API_URL}admission-setting`,
                })
                .then((res) => {
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
                        obj["employees_pre_description_" + res.language_code] =
                            res.employees_pre_description;
                    });
                    this.$store.commit("admission_setting/setPageSetting", {
                        key: "employees_pre_description",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["employees_post_description_" + res.language_code] = res.employees_post_description;
                    });
                    this.$store.commit("admission_setting/setPageSetting", {
                        key: "employees_post_description",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["team_pre_description_" + res.language_code] =
                            res.team_pre_description;
                    });
                    this.$store.commit("admission_setting/setPageSetting", {
                        key: "team_pre_description",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["team_post_description_" + res.language_code] = res.team_post_description;
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
                        obj["faq_post_description_" + res.language_code] = res.faq_post_description;
                    });
                    this.$store.commit("admission_setting/setPageSetting", {
                        key: "faq_post_description",
                        value: obj,
                    });
                    this.isDataLoaded = 1;
                });
                console.log("Languages Computed:", this.$store.state.admission_setting.form.languages);
                console.log("Languages Data:", this.languages);
        },
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutsidePopup);

  },
    mounted() {
        document.addEventListener("click", this.handleClickOutsidePopup);


      
        this.$store.commit("admission_setting/setPageSetting", {
            key: "customer_id",
            value: this.logged_in_customer,
        });
        this.$store.commit("admission_setting/setPageSetting", {
            key: "school_id",
            value: this.school_id,
        });
        axios
            .get(
                "/api/web/customer-languages?customer_id=" +
                    this.logged_in_customer
            )
            .then((res) => {
                if (res.data.status == "Success") {
                    this.$store.commit(
                        "admission_setting/setLanguages",
                        res.data.data
                    );

                    setTimeout(() => {
                        let obj = {};
                        res.data.data.map((res) => {
                            obj["employees_pre_description_" + res.language_code] = "";
                        });
                        this.$store.commit("admission_setting/setPageSetting", {
                            key: "employees_pre_description",
                            value: obj,
                        });

                        obj = {};
                        res.data.data.map((res) => {
                            obj["employees_post_description_" + res.language_code] = "";
                        });
                        this.$store.commit("admission_setting/setPageSetting", {
                            key: "employees_post_description",
                            value: obj,
                        });

                        obj = {};
                        res.data.data.map((res) => {
                            obj["team_pre_description_" + res.language_code] = "";
                        });
                        this.$store.commit("admission_setting/setPageSetting", {
                            key: "team_pre_description",
                            value: obj,
                        });

                        obj = {};
                        res.data.data.map((res) => {
                            obj["team_post_description_" + res.language_code] = "";
                        });
                        this.$store.commit("admission_setting/setPageSetting", {
                            key: "team_post_description",
                            value: obj,
                        });

                        obj = {};
                        res.data.data.map((res) => {
                            obj["faq_pre_description_" + res.language_code] =
                                "";
                        });
                        this.$store.commit("admission_setting/setPageSetting", {
                            key: "faq_pre_description",
                            value: obj,
                        });

                        obj = {};
                        res.data.data.map((res) => {
                            obj["faq_post_description_" + res.language_code] = "";
                        });
                        this.$store.commit("admission_setting/setPageSetting", {
                            key: "faq_post_description",
                            value: obj,
                        });
                        this.fetchAdmissionSetting();
                    }, [1000]);
                }
            });
       
    },
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
