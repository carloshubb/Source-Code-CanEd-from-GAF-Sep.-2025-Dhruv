<template>
    <transition name="slide">
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
                            <div class="can-admin-h2 mb-0">Add a question to the Frequently Asked Questions (FAQ)</div>
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
                                            @click.prevent="
                                                changeLanguageTab(language)
                                            "
                                            href="#"
                                            :class="[
                                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                                activeTab != null &&
                                                activeTab == language.abbreviation
                                                    ? 'text-white bg-primary active'
                                                    : '',
                                                validationErros.has(
                                                    `question.question_${language.abbreviation}`
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
                                class="w-full mt-2"
                                v-for="language in languages"
                                :key="language.abbreviation"
                                :class="
                                    activeTab == language.abbreviation
                                        ? 'block'
                                        : 'hidden'
                                "
                            >
                            <label for="question" class="block text-base lg:text-lg">Question <span class="text-primary">*</span></label>
                                <input
                                    type="text"
                                    placeholder="Max. 30 words"
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="
                                        handleInput($event, 'question', language)
                                    "
                                    :value="
                                        form['question'] &&
                                        form['question'][
                                            `question_${language.abbreviation}`
                                        ]
                                            ? form['question'][
                                                `question_${language.abbreviation}`
                                            ]
                                            : ''
                                    "
                                />
                                <error
                                    :fieldName="`question.question_${language.abbreviation}`"
                                    :validationErros="validationErros"
                                />
                            </div>
                            <div
                                class="w-full mt-2"
                                v-for="language in languages"
                                :key="language.abbreviation"
                                :class="
                                    activeTab == language.abbreviation
                                        ? 'block'
                                        : 'hidden'
                                "
                            >
                            <label for="answer" class="block text-base lg:text-lg">Answer <span class="text-primary">*</span></label>
                                <textarea
                                    name=""
                                    id=""
                                    cols="5"
                                    rows="5"
                                    placeholder="Max. 300 words"
                                    class="border border-l-[5px] w-full border-l-primary border-gray-300 rounded mt-4 p-3 focus:outline-none focus:ring-none"
                                    @input="handleInput($event, 'answer', language)"
                                    >{{
                                        form["answer"] &&
                                        form["answer"][
                                            `answer_${language.abbreviation}`
                                        ]
                                            ? form["answer"][
                                                `answer_${language.abbreviation}`
                                            ]
                                            : ""
                                    }}</textarea
                                >
                                <error
                                    :fieldName="`answer.answer_${language.abbreviation}`"
                                    :validationErros="validationErros"
                                />
                            </div>

                            <div class="w-full mt-1">
                                <label for="order" class="block text-base lg:text-lg">Order <span class="text-primary">*</span></label>
                                <input
                                    type="text"
                                    placeholder=""
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="handleInput($event, 'order', '')"
                                    :value="form['order'] ? form['order'] : ''"
                                />
                                <error
                                    :fieldName="'order'"
                                    :validationErros="validationErros"
                                />
                            </div>

                            <div class="flex justify-center items-center gap-3 mt-4">
                                <div class="space-x-4">
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
                                        Add FAQ
                                    </button>
                                </div>
                            </div>
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
import Error from "./Error.vue";
export default {
    components: { Error },
    props: ["logged_in_customer", "school_id", "faq_type"],
    computed: {
        ...mapState({
            form: (state) => state.faqs.form,
            showModal: (state) => state.faqs.showModal,
            faqs: (state) => state.faqs.faqs,
            pagination: (state) => state.faqs.pagination,
            validationErros: (state) => state.faqs.validationErros,
            searchParam: (state) => state.faqs.searchParam,
            loading: (state) => state.faqs.loading,
            languages: (state) => state.faqs.form.languages,
        }),
    },
    data() {
        return {
            activeTab: "en",
        };
    },
    methods: {
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
            this.$store.commit("faqs/setForData", {
                key,
                language,
                value: e.target.value,
            });
        },
        changeLanguageTab(language) {
            this.activeTab = language.abbreviation;
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
                        school_id: this.$route?.params?.id,
                    });
                    this.closeModal();
                }
            });
        },
        fetchCustomerLangs() {
            axios.get("/api/admin/languages").then((res) => {
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

    mounted() {
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