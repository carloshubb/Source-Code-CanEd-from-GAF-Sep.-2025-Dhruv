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
                <div class="modal-content py-6 text-left px-6 overflow-y-auto">
                    <div class="flex justify-between items-center pb-3">
                        <div class="can-school-h2 mb-0">Add school program</div>
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
                        <template v-if="!chooseFromExisting">
                            <div class="flex justify-center">
                            <button
                                class="inline-block py-2 px-4 text-primary border border-primary rounded font-FuturaMdCnBT text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary"
                                @click="handleChooseFromExisting"
                            >
                                Choose from existing
                            </button>
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
                                                activeTab ==
                                                    language.language_code
                                                    ? 'text-white bg-primary active'
                                                    : '',
                                                validationErros.has(
                                                    `description.description_${language.code}`
                                                )
                                                    ? 'bg-red-600 text-white hover:text-white'
                                                    : '',
                                            ]"
                                            >{{ getLanguageName(language.language_code) }}</a
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
                                <label class="block text-base lg:text-lg">Program name</label>
                                <input
                                    name="name"
                                    id=""
                                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                                    @input="
                                        handleInput($event, 'name', language)
                                    "
                                    :value="
                                        form['name'] &&
                                        form['name'][
                                            `name_${language.language_code}`
                                        ]
                                            ? form['name'][
                                                  `name_${language.language_code}`
                                              ]
                                            : ''
                                    "
                                />
                                <error
                                    :fieldName="`name.name_${language.language_code}`"
                                    :validationErros="validationErros"
                                />
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
                                <label class="block text-base lg:text-lg">Program description</label>
                                <textarea
                                    name="description"
                                    id=""
                                    cols="5"
                                    rows="5"
                                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="
                                        handleInput(
                                            $event,
                                            'description',
                                            language
                                        )
                                    "
                                    >{{
                                        form["description"] &&
                                        form["description"][
                                            `description_${language.language_code}`
                                        ]
                                            ? form["description"][
                                                  `description_${language.language_code}`
                                              ]
                                            : ""
                                    }}</textarea
                                >
                                <error
                                    :fieldName="`description.description_${language.language_code}`"
                                    :validationErros="validationErros"
                                />
                            </div>

                            <!-- <div class="w-full mt-4">
                                <select
                                    type="text"
                                    placeholder="Degree level *"
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="
                                        handleInput($event, 'degree_id', '')
                                    "
                                >
                                    <option value="">
                                        Select degree level
                                    </option>
                                    <option
                                        v-for="(degree, key) in degrees"
                                        :key="key"
                                        :value="degree?.id"
                                        :selected="
                                            form['degree_id'] == degree?.id
                                        "
                                    >
                                        {{ degree?.degree_detail[0]?.name }}
                                    </option>
                                </select>
                                <error
                                    :fieldName="`degree_id`"
                                    :validationErros="validationErros"
                                />
                            </div> -->
                            <div class="relative z-0 w-full group mb-4">
                                <label for="degree_name" class="block text-base lg:text-lg mb-2"
                                    >Degree level</label
                                >
                                <v-select
                                name="degree_id"
                                    v-model="selectedDegrees"
                                    :options="degrees"
                                    :reduce="(degrees) => degrees.id"
                                    label="degree_name"
                                    multiple
                                    taggable
                                    @input="
                                    handleDegreeInput(
                                        $event,
                                        'degree_id',
                                    )
                                "

                                >
                                </v-select>
                                <!-- <p
                                    class="mt-2 text-base text-primary"
                                    v-if="validationErros.has(`degree_id`)"
                                    v-text="validationErros.get(`degree_id`)"
                                ></p> -->
                                <error :fieldName="'degree_id'" :validationErros="validationErros" />
                            </div>
                        </template>
                        <template v-if="chooseFromExisting">
                            <button
                                class="inline-block py-2 px-4 text-primary border border-primary rounded font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary"
                                @click="handleChooseFromExisting"
                            >
                                Create new
                            </button>

                            <div class="w-full my-4">
                                <select
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @change="handleDegree($event)"
                                >
                                    <option value="">Select Degree</option>
                                    <option
                                        v-for="(degree, key) in degrees"
                                        :key="key"
                                        :value="degree?.id"
                                    >
                                        {{
                                            degree?.degree_name
                                        }}
                                    </option>
                                </select>
                            </div>

                            <div class="w-full my-4">
                                <select
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @change="handleProgram($event)"
                                >
                                    <option value="">Select</option>
                                    <option
                                        v-for="(program, key) in programs"
                                        :key="key"
                                        :value="program?.id"
                                    >
                                        {{
                                            program?.program_detail?.length > 0
                                                ? program?.program_detail[0]
                                                      .name
                                                : ""
                                        }}
                                    </option>
                                </select>

                                <error
                                    :fieldName="`program_id`"
                                    :validationErros="validationErros"
                                />
                            </div>
                        </template>
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
                                    Submit
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
import vSelect from "vue-select";
import axios from "axios";
import { mapState } from "vuex";
import Error from "../../Error.vue";
export default {
    components: { Error, vSelect },
    props: ["logged_in_customer", "school_id","languages_with_names"],
    computed: {
        ...mapState({
            form: (state) => state.school_programs.form,
            showModal: (state) => state.school_programs.showModal,
            programs: (state) => state.programs.programs,
            school_programs: (state) => state.school_programs.school_programs,
            degrees: (state) => state.degrees.degrees,
            pagination: (state) => state.school_programs.pagination,
            validationErros: (state) => state.school_programs.validationErros,
            searchParam: (state) => state.school_programs.searchParam,
            loading: (state) => state.school_programs.loading,
            languages: (state) => state.school_programs.form.languages,
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
            activeTab: "en",
            chooseFromExisting: false,
            selectedDegrees: [], // This will hold the actual degree objects
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
        handleChooseFromExisting() {
            this.chooseFromExisting = !this.chooseFromExisting;
            this.$store.commit("school_programs/setForData", {
                key: "already_existed",
                language: "",
                value: this.chooseFromExisting,
            });
        },
        closeModal() {
            this.$store.commit("school_programs/setShowModal", 0);
            this.$store.commit("school_programs/resetForm");
            this.fetchCustomerLangs();
            this.$store.commit("school_programs/setForData", {
                key: "customer_id",
                language: "",
                value: this.logged_in_customer,
            });

            this.$store.commit("school_programs/setForData", {
                key: "school_id",
                language: "",
                value: this.school_id,
            });
        },
        handleInput(e, key, language) {
            const errorKey = language
        ? `${key}.${key}_${language.language_code}`
        : key;
            this.$store.commit("school_programs/setForData", {
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
        handleDegreeInput(value) {
            console.log(value);
            this.$store.commit("school_programs/setDegree", value);
        //     if (this.validationErros.has(degree_id)) {
        //     this.validationErros.clear(degree_id);
        // }
        },
        addUpdate() {
            if(this.chooseFromExisting == false){
                this.handleDegreeInput(this.selectedDegrees);
            }
            this.$store.commit("school_programs/setForData", {
                key: "customer_id",
                language: "",
                value: this.logged_in_customer,
            });
            this.$store.commit("school_programs/setForData", {
                key: "school_id",
                language: "",
                value: this.school_id,
            });
            this.$store
                .dispatch("school_programs/addUpdateForm")
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$store.commit("school_programs/setLimit", 10);
                        this.$store.commit("school_programs/setSortBy", "id");
                        this.$store.commit("school_programs/setDegree", "");
                        this.$store.commit(
                            "school_programs/setSortType",
                            "desc"
                        );
                        this.$store.dispatch(
                            "school_programs/fetchSchoolPrograms"
                        );
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
                        this.$store.commit(
                            "school_programs/setLanguages",
                            res.data.data
                        );

                        res.data.data?.filter((lang) => {
                            this.$store.commit("school_programs/setForData", {
                                key: "description",
                                language: lang,
                                value: "",
                            });
                        });
                        res.data.data?.filter((lang) => {
                            this.$store.commit("school_programs/setForData", {
                                key: "name",
                                language: lang,
                                value: "",
                            });
                        });
                    }
                });
        },
        handleProgram(e) {
            let currentProgram = null;
            this.programs.map((program) => {
                if (program.id == e.target.value) {
                    currentProgram = program;
                }
            });
            console.log(currentProgram);
            this.$store.commit("school_programs/setForData", {
                key: "degree_id",
                language: "",
                value: currentProgram.degree_id,
            });

            this.$store.commit("school_programs/setForData", {
                key: "program_id",
                language: "",
                value: currentProgram.id,
            });
            this.$store.commit("school_programs/setForData", {
                key: "description",
                language: this.languages[0],
                value: currentProgram.program_detail[0]?.description,
            });
            this.$store.commit("school_programs/setForData", {
                key: "name",
                language: this.languages[0],
                value: currentProgram.program_detail[0]?.name,
            });
        },
        handleDegree(e){
            this.$store.dispatch("programs/fetchPrograms", {
            url: `${process.env.MIX_WEB_API_URL}programs?getAll=1&degreeId=`+e.target.value+`&sortBy=name&sortType=asc`,
        });
        }
    },

    mounted() {
        this.fetchCustomerLangs();
    },

    created() {
        this.$store.commit("school_programs/resetForm");
        this.$store.dispatch("degrees/fetchDegrees", {
            url: `${process.env.MIX_WEB_API_URL}degrees?getAll=1&sortBy=degree_name&sortType=asc`,
        });
    },
};
</script>
