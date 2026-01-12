<template>
    <div
        v-if="showModal"
        id="modal"
        class="fixed z-50 inset-0 overflow-y-auto p-4"
    >
        <div class="flex items-center justify-center min-h-screen">
            <div
                class="modal-container bg-white w-full md:w-3/5 mx-auto rounded shadow-lg overflow-y-auto"
            >
                <div class="modal-content py-6 text-left px-6">
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
                    <div class="modal-body">
                        <div
                            class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
                        >
                            <ul class="flex gap-2 flex-wrap my-4">
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
                                                `description.description_${language.code}`
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
                            <input
                                placeholder="Description *"
                                class="border border-l-[5px] w-full border-l-primary border-gray-300 rounded mt-4 p-3 focus:outline-none focus:ring-none"
                                @input="handleInput($event, 'name', language)"
                                :value="
                                    form['name'] &&
                                    form['name'][
                                        `name_${language.abbreviation}`
                                    ]
                                        ? form['name'][
                                              `name_${language.abbreviation}`
                                          ]
                                        : ''
                                "
                            />
                            <error
                                :fieldName="`name.name_${language.abbreviation}`"
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
                            <textarea
                                name=""
                                id=""
                                cols="5"
                                rows="5"
                                placeholder="Description *"
                                class="border border-l-[5px] w-full border-l-primary border-gray-300 rounded mt-4 p-3 focus:outline-none focus:ring-none"
                                @input="
                                    handleInput($event, 'description', language)
                                "
                                >{{
                                    form["description"] &&
                                    form["description"][
                                        `description_${language.abbreviation}`
                                    ]
                                        ? form["description"][
                                              `description_${language.abbreviation}`
                                          ]
                                        : ""
                                }}</textarea
                            >
                            <error
                                :fieldName="`description.description_${language.abbreviation}`"
                                :validationErros="validationErros"
                            />
                        </div>

                        <div class="w-full mt-4">
                            <select
                                type="text"
                                placeholder="Degree level *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'degree_id', '')"
                            >
                                <option value="">Select degree level</option>
                                <option
                                    v-for="(degree, key) in degrees"
                                    :key="key"
                                    :value="degree?.id"
                                    :selected="form['degree_id'] == degree?.id"
                                >
                                    {{ degree?.degree_detail[0]?.name }}
                                </option>
                            </select>
                            <error
                                :fieldName="`degree_id`"
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
import axios from "axios";
import { mapState } from "vuex";
import Error from "./Error.vue";
export default {
    components: { Error },
    props: ["logged_in_customer", "school_id"],
    computed: {
        ...mapState({
            form: (state) => state.school_programs.form,
            showModal: (state) => state.school_programs.showModal,
            school_programs: (state) => state.school_programs.school_programs,
            degrees: (state) => state.degrees.degrees,
            programs: (state) => state.programs.programs,
            pagination: (state) => state.school_programs.pagination,
            validationErros: (state) => state.school_programs.validationErros,
            searchParam: (state) => state.school_programs.searchParam,
            loading: (state) => state.school_programs.loading,
            languages: (state) => state.school_programs.form.languages,
        }),
    },
    data() {
        return {
            activeTab: "en",
        };
    },
    methods: {
        closeModal() {
            this.$store.commit("school_programs/setShowModal", 0);
            this.$store.commit("school_programs/resetForm");
            this.fetchCustomerLangs();
            this.$store.commit("school_programs/setForData", {
                key: "school_id",
                language: "",
                value: this.$route.params.id,
            });
        },
        handleInput(e, key, language) {
            this.$store.commit("school_programs/setForData", {
                key,
                language,
                value: e.target.value,
            });
        },
        changeLanguageTab(language) {
            this.activeTab = language.abbreviation;
        },
        addUpdate() {
            this.$store
                .dispatch("school_programs/addUpdateForm")
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$store.commit("school_programs/setLimit", 10);
                        this.$store.commit("school_programs/setSortBy", "id");
                        this.$store.commit(
                            "school_programs/setSortType",
                            "desc"
                        );
                        this.$store.dispatch(
                            "school_programs/fetchSchoolPrograms",
                            {
                                url: `${process.env.MIX_WEB_API_URL}school-programs?withSchoolProgramDetail=1&is_admin=1&school_id=${this.$route.params.id}`,
                            }
                        );
                        this.closeModal();
                    }
                });
        },
        fetchCustomerLangs() {
            this.$store
                .dispatch("languages/fetchLanguages", {
                    url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
                })
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
    },

    mounted() {
        this.fetchCustomerLangs();
    },
};
</script>
