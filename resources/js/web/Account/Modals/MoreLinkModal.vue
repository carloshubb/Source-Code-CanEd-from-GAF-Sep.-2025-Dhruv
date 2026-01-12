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
                        <div class="can-school-h2 mb-0">Add link</div>
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
                    <div class="">
                        <div class="flex justify-end">
                            <p class=text-primary>* Indicates required fields</p>
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
                                            // validationErros.has(
                                            //     `question.question_${language.code}`
                                            // )
                                            //     ? 'bg-red-600 text-white hover:text-white'
                                            //     : '',
                                        ]"
                                        >{{ getLanguageName(language.language_code) }}</a
                                    >
                                </li>
                            </ul>
                        </div> -->

                        <div class="flex justify-end items-center gap-3 mt-4">
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
                                <label class="block text-base lg:text-lg">Link name <span class="text-primary">*</span> </label>
                                <input
                                    type="text"
                                    placeholder="3 words max."
                                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="
                                        handleInput($event, 'name', language)
                                    "
                                    :value="
                                        name &&
                                        name[`name_${language.language_code}`]
                                            ? name[
                                                  `name_${language.language_code}`
                                              ]
                                            : ''
                                    "
                                />
                                <error :fieldName=" `name.name_${language.language_code}`" :validationErros="validationErros" />
                            </div>
                        </div>
                        <div class="flex justify-end items-center gap-3 mt-4">
                            <div class="w-full mt-2">
                                <label class="block text-base lg:text-lg">Link URL <span class="text-primary">*</span> </label>
                                <input
                                    type="text"
                                    placeholder=""
                                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    v-model="link"
                                />
                                <error :fieldName="'link'" :validationErros="validationErros" />
                            </div>
                        </div>
                        <div class="flex justify-center items-center gap-3 mt-4">
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
                                    Add link
                                </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import ErrorHandling from "../../../ErrorHandling";
import Error from '../../Error.vue';
export default {
  components: { Error },
    props: [
        "showModal",
        "toggleLinkModal",
        "school_id",
        "logged_in_customer",
        "link_id",
    "languages_with_names"
    ],
    computed: {
        
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
            activeTab: "en",
            languages: [],
            validationErros: new ErrorHandling(),
            name: {},
            link: "",
            isFormEdit: false,
        };
    },
    methods: {
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
            this.toggleLinkModal();
            this.fetchCustomerLangs();
            this.link = "";
            this.$emit('unSetLinksData');
        },
        handleInput(e, key, language) {
            this[key][key + "_" + language.language_code] = e.target.value;
        },
        changeLanguageTab(language) {
            this.activeTab = language.language_code;
        },
        addUpdate() {
            let url =
                this.link_id != ""
                    ? `${process.env.MIX_WEB_API_URL}more_links/` + this.link_id
                    : `${process.env.MIX_WEB_API_URL}more_links`;
            let method = this.link_id != "" ? "put" : "post";
            axios[method](url, {
                link: this.link,
                name: this.name,
                languages: this.languages,
                school_id: this.school_id,
            })
                .then((res) => {
                    if (res.data.status == "Success") {
                        helper.swalSuccessMessage(res.data.message);
                        this.closeModal();
                    }
                })
                .catch((err) => {
                    if (err.response && err.response.status == 422) {
                        this.validationErros.record(err.response.data.errors);
                    }
                });
        },
        fetchCustomerLangs() {
            axios
                .get(
                    "/api/web/customer-languages?customer_id=" +
                        this.logged_in_customer
                )
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.languages = res.data.data;
                        for (var i = 0; i < res.data.data?.length; i++) {
                            this.name[
                                "name_" + res.data.data[i].language_code
                            ] = "";
                        }
                    }
                });
        },
    },

    mounted() {
        this.fetchCustomerLangs();
    },
    watch: {
        link_id: function () {
            if (this.link_id != "") {
                let url =
                    `${process.env.MIX_WEB_API_URL}more_links/` + this.link_id;
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            this.link = res.data.data?.link;
                            let school_more_link_resource =
                                res.data.data?.school_more_link_resource;
                            for (
                                var i = 0;
                                i < school_more_link_resource?.length;
                                i++
                            ) {
                                this.name[
                                    "name_" +
                                        school_more_link_resource[i]
                                            .language_code
                                ] = school_more_link_resource[i].name;
                            }
                        }
                    })
                    .catch((err) => {
                        if (err.response && err.response.status == 422) {
                            this.validationErros.record(
                                err.response.data.errors
                            );
                        }
                    });
            }
        },
    },
};
</script>
