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
                        <div class="can-school-h2 mb-0">Add a new scholarship</div>
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
                                            errors.has(
                                                `name.name_${language.code}`
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
                            <label class="block text-base lg:text-lg">Scholarship name <span class="text-primary">*</span></label>
                            <input
                            name="name"
                                type="text"
                                placeholder=""
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
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
                            <label class="block text-base lg:text-lg">Summary <span class="text-primary">*</span></label>
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
                            placeholder="Introduction of the scholarship"
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
                            <label class="block text-base lg:text-lg">Eligibility criteria</label>
                            <textarea
                                name="criteria"
                                id=""
                                cols="5"
                                rows="5"
                                placeholder=""
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
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
                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Province <span class="text-primary">*</span></label>
                            <select name="province"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'province', '')"
                            >
                                <!-- <option
                                    value=""
                                    selected="selected"
                                    disabled="disabled"
                                >
                                    Province *
                                </option> -->
                                <option
                                    :selected="form['province'] == 'All'"
                                    value="All"
                                >
                                    All
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

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Awarded to</label>
                            <select name="award"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
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
                                    form['award'] ? form['award'] ==
                                        'Admission and current students' :'Admission and current students'
                                    "
                                    value="Admission and current students"
                                >
                                    All
                                </option>
                            </select>
                            <error
                                :fieldName="`award`"
                                :validationErros="errors"
                            />
                        </div>

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Scholarship amount <span class="text-primary">*</span></label>
                            <input
                            name="amount"
                                type="text"
                                placeholder=""
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'amount', '')"
                                :value="form['amount'] ? form['amount'] : ''"
                            />
                            <error
                                :fieldName="`amount`"
                                :validationErros="errors"
                            />
                        </div>

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Actions <span class="text-primary">*</span></label>
                            <select
                            name="action" class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'action', '')"
                            >
                                <!-- <option
                                    value=""
                                    selected="selected"
                                    disabled="disabled"
                                    hidden="hidden"
                                >
                                    Actions *
                                </option> -->
                                <option
                                    :selected="form['action'] == 'Application required'"
                                    value="Application required"
                                >
                                    Application required
                                </option>
                                <option
                                    :selected="
                                        form['action'] == 'No application required'
                                    "
                                    value="No application required"
                                >
                                    No application required
                                </option>
                            </select>
                            <error
                                :fieldName="`action`"
                                :validationErros="errors"
                            />
                        </div>

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Date posted</label>
                            <input
                            name="date_posted"
                                type="date"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'date_posted', '')"
                                @click="openDatePicker($event)"
                                @keydown.prevent
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

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Expiry date</label>
                            <input
                            name="expirey_date"
                                type="date"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'expirey_date', '')"
                                @click="openDatePicker($event)"
                                @keydown.prevent
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

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Application deadline</label>
                            <input
                            name="deadline_date"
                                type="date"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="
                                    handleInput($event, 'deadline_date', '')
                                "
                                @click="openDatePicker($event)"
                                @keydown.prevent
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
                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Available to</label>
                            <select
                            name="availability"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
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
                                    form['availability'] ? form['availability'] == 'All students' : 'All students'
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
                                Canadian (national) students
                                </option>
                                <option
                                    :selected="
                                        form['availability'] ==
                                        'Provincial students'
                                    "
                                    value="Provincial students"
                                >
                                Canadian (provincial) students
                                </option>  
                                <option
                                    :selected="
                                        form['availability'] ==
                                        'Black students'
                                    "
                                    value="Black students"
                                >
                                Black students
                                </option>
                                <option
                                    :selected="
                                        form['availability'] ==
                                        'Latino students'
                                    "
                                    value="Latino students"
                                >
                                Latino students
                                </option>
                                <option
                                    :selected="
                                        form['availability'] ==
                                        'Aborignal people'
                                    "
                                    value="Aborignal people"
                                >
                                Natives / Aborignal People
                                </option>
                                <option
                                    :selected="
                                        form['availability'] ==
                                        'Visible minorities'
                                    "
                                    value="Visible minorities"
                                >
                                Visible minorities
                                </option>
                                <option
                                    :selected="
                                        form['availability'] ==
                                        'Female Students'
                                    "
                                    value="Female Students"
                                >
                                Female Students
                                </option>
                            </select>
                            <error
                                :fieldName="`availability`"
                                :validationErros="errors"
                            />
                        </div>
                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Level of study</label>
                            <select
                            name="study_level"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
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
                                        form['study_level'] == 'School'
                                    "
                                    value="School"
                                >
                                School - primary and high
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
                                        form['study_level'] ? form['study_level'] ==
                                        'Graduate and undergraduate' : 'Graduate and undergraduate'
                                    "
                                    value="Graduate and Undergraduate"
                                >
                                    All
                                </option>
                            </select>
                            <error
                                :fieldName="`study_level`"
                                :validationErros="errors"
                            />
                        </div>

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Study type</label>
                            <select
                            name="duration"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
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
                                    Full-time
                                </option>
                                <option
                                    :selected="form['duration'] == 'Part time'"
                                    value="Part time"
                                >
                                    Part-time
                                </option>
                                <option
                                    :selected="form['duration'] ? form['duration'] == 'All' : 'All' "
                                    value="All"
                                >
                                    All
                                </option>
                            </select>
                            <error
                                :fieldName="`duration`"
                                :validationErros="errors"
                            />
                        </div>
                        <div class="w-full mt-3">
                            <label class="block text-base lg:text-lg">Image</label>
                            <p class="text-base">
                               (Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)
                            </p>
                            <input
                            name="image"
                                type="file"
                                class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @change="handleImage($event)"
                            />
                            <error
                                :fieldName="`image`"
                                :validationErros="errors"
                            />
                            <img v-if="form['image']" :src="form?.image ? form.image : ''" style="height: 100px; width: 100px" />
                        </div>

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Application page <span class="text-primary">*</span></label>
                            <input
                            name="link"
                                type="text"
                                placeholder=""
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'link', '')"
                                :value="form['link'] ? form['link'] : ''"
                            />
                            <error
                                :fieldName="`link`"
                                :validationErros="errors"
                            />
                        </div>

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">URL of the original source <span class="text-primary">*</span></label>
                            <input
                            name="more_info_link"
                                type="text"
                                placeholder=""
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
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

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg"> Featured? <span class="text-primary">*</span></label>
                            <select
                            name="featured"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'featured', '')"
                            >
                                <option
                                    value=""
                                    selected="selected"
                                    disabled="disabled"
                                    hidden="hidden"
                                >
                                Do you want to feature this scholarship in the scholarships tab on your school profile?
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
                                    Submit
                                </button>
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
    props: ["logged_in_customer", "school_id","languages_with_names"],
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
        openDatePicker(event) {
        event.target.showPicker(); // Opens the date picker every time the field is clicked
    },
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
            // console.log(e.target.files[0], key, language, mutationName);
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
            const errorKey = language
                ? `${key}.${key}_${language.language_code}`
                : key;
            this.$store.commit("school_scholarships/setForData", {
                key,
                language,
                value: e.target.value,
            });
            if (this.errors.has(errorKey)) {
                this.errors.clear(errorKey);
            }
        },
        handleSelectionChange(language, key) {
            this.$store.commit(`school_scholarships/updateFormData`, {
                value: tinymce.get(`${key}_${language.language_code}`).getContent(),
                id: language.language_code,
                key:key,
            });
            const errorKey = `${key}.${key}_${language.language_code}`;
    if (this.errors.has(errorKey)) {
        this.errors.clear(errorKey);
    }
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
