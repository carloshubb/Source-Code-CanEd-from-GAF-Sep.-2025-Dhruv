<template>
    <div
        v-if="showModal"
        id="modal"
        class="fixed z-50 inset-0 overflow-y-auto p-4"
    >
        <div class="flex items-center justify-center min-h-screen">
            <div
                class="modal-overlay w-full h-full bg-gray-900 opacity-50"
            ></div>
            <div
                class="modal-container bg-white w-full md:w-3/5 mx-auto rounded shadow-lg overflow-y-auto"
            >
                <div class="modal-content py-6 text-left px-6">
                    <div class="flex justify-between items-center pb-3">
                        <div class="can-school-h2 mb-0">Add a question to the Frequently Asked Questions (FAQ)</div>
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
                        <div class="flex justify-end">
                            <p class="text-primary">(* Indicates required fields) </p>
                        </div>
                        <!-- <div
                            class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
                        >
                            <ul class="flex gap-2 flex-wrap my-4">
                                <li
                                    class="mr-2"
                                    v-for="language in languages"
                                    :key="language.code"
                                >
                                    <a
                                        @click.prevent="
                                            changeLanguageTab(language)
                                        "
                                        href="#"
                                        :class="[
                                            'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                            activeTab != null &&
                                            activeTab == language.language_code
                                                ? 'text-white bg-primary active'
                                                : '',
                                            validationErros.has(
                                                `question.question_${language.code}`
                                            )
                                                ? 'bg-red-600 text-white hover:text-white'
                                                : '',
                                        ]"
                                        >{{ language.language_code }}</a
                                    >
                                </li>
                            </ul>
                        </div> -->
                        <div
                            class="w-full mt-2"
                            v-for="language in languages"
                            :key="language.language_code"
                            :class="
                                activeTab == language.language_code
                                    ? 'block'
                                    : 'hidden'
                            "
                        >
                            <label for="question" class="block text-base lg:text-lg">Question <span class="text-primary">*</span></label>
                            <input
                                type="text"
                                name="question"
                                placeholder="Max. 30 words"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="
                                    handleInput($event, 'question', language)
                                "
                                :value="
                                    form['question'] &&
                                    form['question'][
                                        `question_${language.language_code}`
                                    ]
                                        ? form['question'][
                                              `question_${language.language_code}`
                                          ]
                                        : ''
                                "
                            />
                            <error :fieldName="`question.question_${language.language_code}`" :validationErros="validationErros"  />
                           
                        </div>
                        <div
                            class="w-full mt-2"
                            v-for="language in languages"
                            :key="language.language_code"
                            :class="
                                activeTab == language.language_code
                                    ? 'block'
                                    : 'hidden'
                            "
                        >
                            <label for="answer" class="block text-base lg:text-lg">Answer <span class="text-primary">*</span></label>
                            <textarea
                                name="answer"
                                id=""
                                cols="5"
                                rows="5"
                                placeholder="Max. 300 words"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'answer', language)"
                                >{{
                                    form["answer"] &&
                                    form["answer"][
                                        `answer_${language.language_code}`
                                    ]
                                        ? form["answer"][
                                              `answer_${language.language_code}`
                                          ]
                                        : ""
                                }}</textarea
                            >
                            <error :fieldName="`answer.answer_${language.language_code}`" :validationErros="validationErros"  />
                        </div>

                        <div class="w-full mt-1">
                            <label for="order" class="block text-base lg:text-lg">Order <span class="text-primary">*</span></label>
                            <input
                                type="number"
                                name="order"
                                placeholder=""
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'order', '')"
                                :value="form['order'] ? form['order'] : ''"
                            />
                            <error :fieldName="'order'" :validationErros="validationErros"  />
                        </div>

                        <div class="flex justify-center items-center gap-4 mt-4">
                            <button
                                class="can-edu-btn-fill"
                                @click="closeModal"
                            >
                                Close
                            </button>
                            <button
                                class="can-edu-btn-fill"
                                @click="addUpdate"
                            >
                                Add to FAQ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <transition name="slide">
        <div id="defaultModal" tabindex="-1" aria-hidden="true"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="showPopUpModal">
            <div class="relative w-full rounded-2xl shadow-2xl border-4 bg-white border-primary/30 h-full max-w-lg md:h-auto"
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
import axios from "axios";
import { mapState } from "vuex";
import Error from '../../Error.vue';
export default {
  components: { Error },
    props: ["logged_in_customer","school_id","faq_type"],
    computed: {
        ...mapState({
            form: (state) => state.faqs.form,
            showModal: (state) => state.faqs.showModal,
            faqs: (state) => state.faqs.faqs,
            errors: (state) => state.school_employees.errors,
            pagination: (state) => state.faqs.pagination,
            validationErros: (state) => state.faqs.validationErros,
            searchParam: (state) => state.faqs.searchParam,
            loading: (state) => state.faqs.loading,
            languages: (state) => state.faqs.form.languages,
        }),
    },
    data() {
        return {
            showPopUpModal: false,
            popupMsg: '',
            activeTab: "en",
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
        closeModal() {
            this.$store.commit("faqs/setShowModal", 0);
            this.$store.commit("faqs/resetForm");
            this.fetchCustomerLangs();
            this.$store.commit("faqs/setForData", {
                key: "type",
                language: "",
                value: this.faq_type,
            });

            this.$store.commit("faqs/setForData", {
                key: "customer_id",
                language: "",
                value: this.logged_in_customer,
            });
            this.$store.commit("faqs/setForData", {
                key: "school_id",
                language: "",
                value: this.school_id,
            });
        },
        handleInput(e, key, language) {
            const errorKey = language
        ? `${key}.${key}_${language.language_code}`
        : key;
            this.$store.commit("faqs/setForData", {
                key,
                language,
                value: e.target.value,
            });
         
    if (this.validationErros.has(errorKey)) {
        this.validationErros.clear(errorKey);
    }
        },
        changeLanguageTab(language) {
            this.activeTab = language.language_code;
        },
        addUpdate() {
            this.$store.dispatch("faqs/addUpdateForm").then((res) => {
                if (res.data.status == "Success") {
                    this.$store.commit("faqs/setForData", {
                        key: "type",
                        language: "",
                        value: this.faq_type,
                    });

                    this.$store.commit("faqs/setForData", {
                        key: "customer_id",
                        language: "",
                        value: this.logged_in_customer,
                    });
                    this.$store.commit("faqs/setForData", {
                        key: "school_id",
                        language: "",
                        value: this.school_id,
                    });
                    this.$store.dispatch("faqs/fetchFaqs", {
                        type: this.faq_type,
                    });
                    this.showPopUpModal = true;
                this.popupMsg = res.data.message;
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
        fetchCustomerLangs() {
            axios
                .get(
                    "/api/web/customer-languages?customer_id=" +
                        this.logged_in_customer
                )
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$store.commit("faqs/setLanguages", res.data.data);
                        res.data.data?.filter((lang) => {
                            this.$store.commit("faqs/setForData", {
                                key: "question",
                                language: lang,
                                value: "",
                            });
                            this.$store.commit("faqs/setForData", {
                                key: "answer",
                                language: lang,
                                value: "",
                            });
                        });
                    }
                });
        },
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutsidePopup);

  },
    mounted() {
        document.addEventListener("click", this.handleClickOutsidePopup);

        this.fetchCustomerLangs();
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