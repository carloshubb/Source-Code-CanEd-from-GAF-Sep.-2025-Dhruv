<template>
    <div
        v-if="showModal"
        id="modal"
        class="fixed z-50 inset-0 overflow-y-auto p-4"
    >
        <div class="flex items-center justify-center min-h-screen">
            <div
                class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"
            ></div>
            <div
                class="modal-container bg-white w-full md:w-3/5 mx-auto rounded shadow-lg overflow-y-auto"
            >
                <div class="modal-content py-6 text-left px-6">
                    <div class="flex justify-between items-center pb-3">
                        <div class="can-school-h2 mb-0">Add school scholarship</div>
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
                                            errors.has(
                                                `name.name_${language.code}`
                                            )
                                                ? 'bg-red-600 text-white hover:text-white'
                                                : '',
                                        ]"
                                        >{{ language.language_code }}</a
                                    >
                                </li>
                            </ul>
                        </div>
                        <div
                            v-for="language in languages"
                            :key="language.language_code"
                            :class="
                                activeTab == language.language_code
                                    ? 'block'
                                    : 'hidden'
                            "
                        >
                        <div
                            class="w-full mt-2"
                        >
                            <input
                                type="text"
                                placeholder="Name *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'name', language)"
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
                                :validationErros="errors"
                            />
                        </div>
                        <div
                            class="w-full mt-2"
                            v-if="isDataLoaded"
                        >
                            <label class="text-gray-700 font-semibold text-sm lg:text-base">Summary</label>
                            <!-- <div
                                class="mt-5 ckeditorText"
                                :id="`summary_${language.language_code}`"
                            ></div> -->
                            <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'summary'
                                )
                            "
                            :ref="`summary_${language.language_code}`"
                            :id="`summary_${language.language_code}`"
                            :initial-value="form[`summary`][`summary_${language?.language_code}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                            <error
                                :fieldName="`summary.summary_${language.language_code}`"
                                :validationErros="errors"
                            />
                            
                        </div>
                        <div
                            class="w-full mt-2"
                        >
                            <textarea
                                name=""
                                id=""
                                cols="5"
                                rows="5"
                                placeholder="Criteria *"
                                class="border border-l-[5px] w-full border-l-primary border-gray-300 rounded mt-4 p-3 focus:outline-none focus:ring-none"
                                @input="
                                    handleInput($event, 'criteria', language)
                                "
                                >{{
                                    form["criteria"] &&
                                    form["criteria"][
                                        `criteria_${language.language_code}`
                                    ]
                                        ? form["criteria"][
                                              `criteria_${language.language_code}`
                                          ]
                                        : ""
                                }}</textarea
                            >
                            <error
                                :fieldName="`criteria.criteria_${language.language_code}`"
                                :validationErros="errors"
                            />
                            
                        </div>
                        </div>
                        <div class="w-full mt-4">
                            <select
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'province', '')"
                            >
                                <option
                                    value=""
                                    selected="selected"
                                    disabled="disabled"
                                >
                                    Province *
                                </option>
                                <option
                                    :selected="form['province'] == 'Alberta'"
                                    value="Alberta"
                                >
                                    Alberta
                                </option>
                                <option
                                    :selected="
                                        form['province'] == 'British Columbia'
                                    "
                                    value="British Columbia"
                                >
                                    British Columbia
                                </option>
                                <option
                                    :selected="form['province'] == 'Manitoba'"
                                    value="Manitoba"
                                >
                                    Manitoba
                                </option>
                                <option
                                    :selected="
                                        form['province'] == 'New Brunswick'
                                    "
                                    value="New Brunswick"
                                >
                                    New Brunswick
                                </option>
                                <option
                                    :selected="
                                        form['province'] ==
                                        'Newfoundland and Labrador'
                                    "
                                    value="Newfoundland and Labrador"
                                >
                                    Newfoundland and Labrador
                                </option>
                                <option
                                    :selected="
                                        form['province'] == 'Nova Scotia'
                                    "
                                    value="Nova Scotia"
                                >
                                    Nova Scotia
                                </option>
                                <option
                                    :selected="form['province'] == 'Ontario'"
                                    value="Ontario"
                                >
                                    Ontario
                                </option>
                                <option
                                    :selected="
                                        form['province'] ==
                                        'Prince Edward Island'
                                    "
                                    value="Prince Edward Island"
                                >
                                    Prince Edward Island
                                </option>
                                <option
                                    :selected="form['province'] == 'Quebec'"
                                    value="Quebec"
                                >
                                    Quebec
                                </option>
                                <option
                                    :selected="
                                        form['province'] == 'Saskatchewan'
                                    "
                                    value="Saskatchewan"
                                >
                                    Saskatchewan
                                </option>
                            </select>
                            <error
                                :fieldName="`province`"
                                :validationErros="errors"
                            />
                        </div>

                        <div class="w-full mt-4">
                            <select
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'award', '')"
                            >
                                <option
                                    value=""
                                    selected="selected"
                                    disabled="disabled"
                                    hidden="hidden"
                                >
                                    Awards *
                                </option>
                                <option
                                    :selected="form['award'] == 'Admission'"
                                    value="Admission"
                                >
                                    Admission
                                </option>
                                <option
                                    :selected="
                                        form['award'] == 'Current students'
                                    "
                                    value="Current students"
                                >
                                    Current students
                                </option>
                                <option
                                    :selected="
                                        form['award'] ==
                                        'Admission and current students'
                                    "
                                    value="Admission and current students"
                                >
                                    Admission and current students
                                </option>
                            </select>
                            <error
                                :fieldName="`award`"
                                :validationErros="errors"
                            />
                        </div>

                        <div class="w-full mt-4">
                            <input
                                type="number"
                                placeholder="Scholarship amount *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'amount', '')"
                                :value="form['amount'] ? form['amount'] : ''"
                            />
                            <error
                                :fieldName="`amount`"
                                :validationErros="errors"
                            />
                        </div>

                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="Action *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'action', '')"
                                :value="form['action'] ? form['action'] : ''"
                            />
                            <error
                                :fieldName="`action`"
                                :validationErros="errors"
                            />
                        </div>

                        <div class="w-full mt-4">
                            <label class="text-gray-700 font-semibold text-sm lg:text-base">Date posted</label>
                            <input
                                type="date"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'date_posted', '')"
                                :value="
                                    form['date_posted']
                                        ? form['date_posted']
                                        : ''
                                "
                            />
                            <error
                                :fieldName="`date_posted`"
                                :validationErros="errors"
                            />
                        </div>

                        <div class="w-full mt-4">
                            <label class="text-gray-700 font-semibold text-sm lg:text-base">Expirey Date</label>
                            <input
                                type="date"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'expirey_date', '')"
                                :value="
                                    form['expirey_date']
                                        ? form['expirey_date']
                                        : ''
                                "
                            />
                            <error
                                :fieldName="`expirey_date`"
                                :validationErros="errors"
                            />
                        </div>

                        <div class="w-full mt-4">
                            <label class="text-gray-700 font-semibold text-sm lg:text-base">Deadline</label>
                            <input
                                type="date"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="
                                    handleInput($event, 'deadline_date', '')
                                "
                                :value="
                                    form['deadline_date']
                                        ? form['deadline_date']
                                        : ''
                                "
                            />
                            <error
                                :fieldName="`deadline_date`"
                                :validationErros="errors"
                            />
                        </div>
                        <div class="w-full mt-4">
                            <select
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'availability', '')"
                            >
                                <option
                                    value=""
                                    selected="selected"
                                    disabled="disabled"
                                    hidden="hidden"
                                >
                                    Availability *
                                </option>
                                <option
                                    :selected="
                                        form['availability'] == 'All students'
                                    "
                                    value="All students"
                                >
                                    All students
                                </option>
                                <option
                                    :selected="
                                        form['availability'] == 'International students'
                                    "
                                    value="International students"
                                >
                                    International students
                                </option>
                                <option
                                    :selected="
                                        form['availability'] ==
                                        'Canadian students'
                                    "
                                    value="Canadian students"
                                >
                                    Canadian students
                                </option>
                                <option
                                    :selected="
                                        form['availability'] ==
                                        'Provincial students'
                                    "
                                    value="Provincial students"
                                >
                                    Provincial students
                                </option>
                            </select>
                            <error
                                :fieldName="`availability`"
                                :validationErros="errors"
                            />
                        </div>
                        <div class="w-full mt-4">
                            <select
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'study_level', '')"
                            >
                                <option
                                    value=""
                                    selected="selected"
                                    disabled="disabled"
                                    hidden="hidden"
                                >
                                    Level of study *
                                </option>
                                <option
                                    :selected="
                                        form['study_level'] == 'Graduate'
                                    "
                                    value="Graduate"
                                >
                                    Graduate
                                </option>
                                <option
                                    :selected="
                                        form['study_level'] == 'Undergraduate'
                                    "
                                    value="Undergraduate"
                                >
                                    Undergraduate
                                </option>
                                <option
                                    :selected="
                                        form['study_level'] ==
                                        'Graduate and undergraduate'
                                    "
                                    value="Graduate and Undergraduate"
                                >
                                    Graduate and undergraduate
                                </option>
                            </select>
                            <error
                                :fieldName="`study_level`"
                                :validationErros="errors"
                            />
                        </div>

                        <div class="w-full mt-4">
                            <select
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'duration', '')"
                            >
                                <option
                                    value=""
                                    selected="selected"
                                    disabled="disabled"
                                    hidden="hidden"
                                >
                                    Duration *
                                </option>
                                <option
                                    :selected="form['duration'] == 'Full time'"
                                    value="Full time"
                                >
                                    Full time
                                </option>
                                <option
                                    :selected="form['duration'] == 'Part time'"
                                    value="Part time"
                                >
                                    Part time
                                </option>
                            </select>
                            <error
                                :fieldName="`duration`"
                                :validationErros="errors"
                            />
                        </div>
                        <div class="w-full mt-4">
                            <p class="text-sm lg:text-base text-gray-700">
                                Image * (Files must be less than 5MB, allowed
                                file types: png, gif, jpg, jpeg)
                            </p>
                            <input
                                type="file"
                                class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @change="handleImage($event)"
                            />
                            <error
                                :fieldName="`image`"
                                :validationErros="errors"
                            />
                            <img :src="form?.image ? form.image : ''" />
                        </div>

                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="Link *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'link', '')"
                                :value="form['link'] ? form['link'] : ''"
                            />
                            <error
                                :fieldName="`link`"
                                :validationErros="errors"
                            />
                        </div>

                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="More info Link *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="
                                    handleInput($event, 'more_info_link', '')
                                "
                                :value="
                                    form['more_info_link']
                                        ? form['more_info_link']
                                        : ''
                                "
                            />
                            <error
                                :fieldName="`more_info_link`"
                                :validationErros="errors"
                            />
                        </div>

                        <div class="w-full mt-4">
                            <select
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'featured', '')"
                            >
                                <option
                                    value=""
                                    selected="selected"
                                    disabled="disabled"
                                    hidden="hidden"
                                >
                                    Do you want to show this scholarship in the
                                    scholarship main page? *
                                </option>
                                <option
                                    :selected="form['featured'] == '1'"
                                    value="1"
                                >
                                    Yes
                                </option>
                                <option
                                    :selected="form['featured'] == '0'"
                                    value="0"
                                >
                                    No
                                </option>
                            </select>
                            <error
                                :fieldName="`featured`"
                                :validationErros="errors"
                            />
                        </div>

                        <div class="flex justify-end items-center gap-3 mt-4">
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
import Editor from "@tinymce/tinymce-vue";
import axios from "axios";
import { mapState } from "vuex";
import Error from './Error.vue';
export default {
    props: ["logged_in_customer", "school_id"],
    components: { Error, editor: Editor },
    computed: {
        ...mapState({
            form: (state) => state.school_scholarships.form,
            showModal: (state) => state.school_scholarships.showModal,
            school_scholarships: (state) =>
                state.school_scholarships.school_scholarships,
            pagination: (state) => state.school_scholarships.pagination,
            errors: (state) => state.school_scholarships.errors,
            searchParam: (state) => state.school_scholarships.searchParam,
            loading: (state) => state.school_scholarships.loading,
            languages: (state) => state.school_scholarships.form.languages,
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
        closeModal() {
            this.$store.commit("school_scholarships/resetForm");
            this.$store.commit("school_scholarships/setShowModal", 0);
            this.fetchCustomerLangs();
            this.$store.commit("school_scholarships/setForData", {
                key: "customer_id",
                language: "",
                value: this.logged_in_customer,
            });
            this.$store.commit("school_scholarships/setForData", {
                key: "school_id",
                language: "",
                value: this.school_id,
            });
        },
        handleImage(e) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.$store.commit("school_scholarships/setForData", {
                    key: "image",
                    language: "",
                    value: res?.data,
                });
            });
        },
        handleInput(e, key, language) {
            this.$store.commit("school_scholarships/setForData", {
                key,
                language,
                value: e.target.value,
            });
        },
        handleSelectionChange(language, key) {
            this.$store.commit(`school_scholarships/updateFormData`, {
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
                .dispatch("school_scholarships/addUpdateForm")
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$store.commit("school_scholarships/setLimit", 10);
                        this.$store.commit(
                            "school_scholarships/setSortBy",
                            "id"
                        );
                        this.$store.commit(
                            "school_scholarships/setSortType",
                            "desc"
                        );
                        this.$store.dispatch(
                            "school_scholarships/fetchSchoolScholarships"
                        );
                        this.closeModal();
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
                        this.$store.commit(
                            "school_scholarships/setLanguages",
                            res.data.data
                        );

                        res.data.data?.filter((lang) => {
                            if (this.showModal) {
                                this.isDataLoaded = 1;
                            }

                            
                        });
                    }
                });
        },
    },

    mounted() {
        this.fetchCustomerLangs();
    },
    watch: {
        showModal: function (newVal, oldVal) {
            this.fetchCustomerLangs();
        },
    },
};
</script>
