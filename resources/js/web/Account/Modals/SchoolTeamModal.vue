<template>
    <div
      v-if="showModal"
      id="modal"
      class="fixed z-50 inset-0 overflow-y-auto p-4"
    >
      <div class="flex items-center justify-center min-h-screen">
        <div class="modal-overlay w-full h-full bg-gray-900 opacity-50"></div>
        <div
          class="modal-container bg-white w-full md:w-3/5 mx-auto rounded shadow-lg overflow-y-auto"
        >
          <div class="modal-content py-6 text-left px-6">
            <div class="flex justify-between items-center pb-3">
              <div class="can-school-h2 mb-0">Add team member</div>
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
                <div class="w-full mt-2">
                  <label for="name" class="block text-base lg:text-lg">Name</label>
                  <input
                    type="text"
                    name="name"
                    placeholder=""
                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'name', null)"
                    :value="
                      form['name']
                    "
                  />
                  <error
                    fieldName="name"
                    :validationErros="validationErros"
                  />
                </div>
                <div class="w-full mt-2">
                  <label for="designation" class="block text-base lg:text-lg">Designation / Title</label>
                  <input
                    type="text"
                    name="designation"
                    placeholder=""
                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'designation', null)"
                    :value="
                      form['designation']
                    "
                  />
                  <error
                    fieldName="designation"
                    :validationErros="validationErros"
                  />
                </div>
                <div class="relative w-full mt-2" v-if="isDataLoaded">
                  <label for="summary" class="block text-base lg:text-lg mb-2">Introduction</label>
                  <editor
                    @selectionChange="
                      handleSelectionChange('summary')
                    "
                    placeholder="Write a short bio about the team member. 300 words max."
                    ref="summary"
                    id="summary"
                    class="mt-2"
                    :initial-value="
                      form[`summary`]
                    "
                    :init="editorConfig"
                    :tinymce-script-src="tinymceScriptSrc"
                  />
                  <error
                    fieldName="summary"
                    :validationErros="validationErros"
                  />
                </div>
                <div class="w-full mt-2">
                  <label for="phone" class="block text-base lg:text-lg">Phone</label>
                  <input
                  name="phone"
                    type="text"
                    placeholder="with area code, and extension"
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'phone', null)"
                    :value="
                      form['phone']
                    "
                    @keypress="restrictToNumbers($event, 15)"
                  />
                  <error
                    fieldName="phone"
                    :validationErros="validationErros"
                  />
                </div>
                <div class="w-full mt-2">
                  <label for="email" class="block text-base lg:text-lg">Email</label>
                  <input
                    type="text"
                    name="email"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'email', null)"
                    :value="
                      form['email']
                    "
                  />
                  <error
                    fieldName="email"
                    :validationErros="validationErros"
                  />
                </div>
              <div class="w-full mt-2 mb-6">
                <label class="block text-base lg:text-lg">Image</label>
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
                                  :src="image"
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
                    Add news
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
  import Error from '../../Error.vue';
  export default {
    components: { Error, editor: Editor },
    props: ["logged_in_customer", "school_id"],
    computed: {
      ...mapState({
        form: (state) => state.school_teams.form,
        showModal: (state) => state.school_teams.showModal,
        isDataLoaded: (state) => state.school_teams.isDataLoaded,
        school_teams: (state) => state.school_teams.school_teams,
        pagination: (state) => state.school_teams.pagination,
        validationErros: (state) => state.school_teams.validationErros,
        searchParam: (state) => state.school_teams.searchParam,
        loading: (state) => state.school_teams.loading,
        languages: (state) => state.school_teams.form.languages,
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
      restrictToNumbers(event, allowedLength) {
    const keyCode = event.which ? event.which : event.keyCode;
    const inputChar = String.fromCharCode(keyCode);
    const isValidSpecialChar = /^[\+\-\(\)]$/.test(inputChar);
    const isDigit = /^\d$/.test(inputChar);
    let currentValue = event.target.value + inputChar;
    const digitCount = currentValue.replace(/[^\d]/g, "").length;
    if (!isValidSpecialChar && (!isDigit || digitCount > allowedLength)) {
      event.preventDefault();
    }
  },
  // restrictToNumbers(event, allowedLength) {
  //   const keyCode = event.which ? event.which : event.keyCode;
  //   const inputChar = String.fromCharCode(keyCode);
  //   const isValidSpecialChar = /^[\+\-\(\)\s]$/.test(inputChar);
  //   const isDigit = /^\d$/.test(inputChar);
    
  //   let currentValue = event.target.value.replace(/\D/g, ""); // Remove all non-digit characters

  //   if (!isValidSpecialChar && (!isDigit || currentValue.length >= allowedLength)) {
  //     event.preventDefault();
  //     return;
  //   }

  //   // Allow input, then format it
  //   this.$nextTick(() => {
  //     event.target.value = this.formatPhoneNumber(event.target.value);
  //   });
  // },

  formatPhoneNumber(value) {
    let digits = value.replace(/\D/g, ""); // Remove non-digit characters

    if (digits.length > 15) {
      digits = digits.substring(0, 15); // Limit to 15 digits
    }

    let formatted = "";
    if (digits.length > 0) {
      formatted = `(${digits.substring(0, 3)}`;
    }
    if (digits.length > 3) {
      formatted += `) ${digits.substring(3, 6)}`;
    }
    if (digits.length > 6) {
      formatted += `-${digits.substring(6, 10)}`;
    }
    if (digits.length > 10) {
      formatted += ` ${digits.substring(10, 15)}`; // Append remaining 5 digits after a space
    }

    return formatted;
  },
      closeModal() {
        this.$store.commit("school_teams/setShowModal", 0);
        this.$store.commit("school_teams/resetForm");
        // this.$store.commit("school_teams/setForData", {
        //     key: "type",
        //     language: "",
        //     value: this.faq_type,
        // });
  
        this.$store.commit("school_teams/setForData", {
          key: "customer_id",
          language: "",
          value: this.logged_in_customer,
        });
        this.$store.commit("school_teams/setForData", {
          key: "school_id",
          language: "",
          value: this.school_id,
        });
      },
      handleInput(e, key, language) {
        this.$store.commit("school_teams/setForData", {
          key,
          language,
          value: e.target.value,
        });
        if (this.validationErros.has(key)) {
            this.validationErros.clear(key);
        }
      },
      handleSelectionChange(key) {
        this.$store.commit(`school_teams/setForData`, {
          value: tinymce.get(key).getContent(),
          language: "",
          key: key,
        });
        if (this.validationErros.has(key)) {
        this.validationErros.clear(key);
    }
      },
      changeLanguageTab(language) {
        this.activeTab = language.abbreviation;
      },
      addUpdate() {
        this.$store.dispatch("school_teams/addUpdateForm").then((res) => {
          if (res.data.status == "Success") {
            // this.$store.commit("school_teams/setForData", {
            //     key: "type",
            //     language: "",
            //     value: this.faq_type,
            // });
  
            this.$store.commit("school_teams/setForData", {
              key: "customer_id",
              language: "",
              value: this.logged_in_customer,
            });
            this.$store.commit("school_teams/setForData", {
              key: "school_id",
              language: "",
              value: this.school_id,
            });
            this.$store.dispatch("school_teams/fetchSchoolTeams", {
              school_id: this.school_id,
            });
            this.closeModal();
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
      removeImage(index) {
              this.$store.commit("school_teams/removeImage", index);
          },
          handleImageArray(e) {
              for (var i = 0; i < e.target.files.length; i++) {
                  var file = new FormData();
                  file.append("file", e.target.files[i]);
                  axios.post("/api/web/image_again_upload", file).then((res) => {
                      this.$store.commit("school_teams/setImages", res?.data);
                  });
              }
          },
    },
  
    mounted() {
    },
  };
  </script>
  