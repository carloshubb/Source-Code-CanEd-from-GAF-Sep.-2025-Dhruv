<template>
    <div class="modal-content py-6 text-left px-6">
        <div class="pb-3">
            <h1 class="can-school-h1">Student profile</h1>
            <p>Fill this secure form if you are planning to use any of the Proxima Ride paid services in the future</p>
        </div>
        <div class="modal-body">
            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="text-gray-700 font-semibold text-sm lg:text-base"
                    >First name</label
                >
                <input
                    type="text"
                    placeholder=""
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="first_name"
                />
                <error :fieldName="`first_name`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Last name</label
                >
                <input
                    type="text"
                    placeholder=""
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="last_name"
                />
                <error :fieldName="`last_name`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Email</label
                >
                <input
                    type="email"
                    placeholder=""
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="email"
                    disabled
                />
                <error :fieldName="`email`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Your WhatsApp number</label
                >
                <input
                    type="text"
                    placeholder=""
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="whats_app_number"
                />
                <error :fieldName="`whats_app_number`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Skype ID</label
                >
                <input
                    type="text"
                    placeholder=""
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="skype_id"
                />
                <error :fieldName="`skype_id`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="text-gray-700 font-semibold text-sm lg:text-base"
                    >WeChat number</label
                >
                <input
                    type="text"
                    placeholder=""
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="we_chat_number"
                />
                <error :fieldName="`we_chat_number`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Viber number</label
                >
                <input
                    type="text"
                    placeholder=""
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="viber_number"
                />
                <error :fieldName="`viber_number`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="text-gray-700 font-semibold text-sm lg:text-base"
                    >IMO number</label
                >
                <input
                    type="text"
                    placeholder=""
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="imo_number"
                />
                <error :fieldName="`imo_number`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="text-gray-700 font-semibold text-sm lg:text-base"
                    >High school GPA</label
                >
                <input
                    type="number"
                    placeholder=""
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="cgpa"
                />
                <error :fieldName="`cgpa`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Degree level you are pursuing</label
                >
                <select
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="degree_id"
                >
                    <option value="">Select</option>
                    <option
                        v-for="(degree, key) in degrees"
                        :key="key"
                        :value="degree?.id"
                    >
                        {{
                            degree?.degree_detail?.length > 0
                                ? degree?.degree_detail[0].name
                                : ""
                        }}
                    </option>
                </select>
                <error :fieldName="`degree_id`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Program</label
                >
                <select
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="program_id"
                >
                    <option value="">Select</option>
                    <option
                        v-for="(program, key) in programs"
                        :key="key"
                        :value="program?.id"
                    >
                        {{
                            program?.program_detail?.length > 0
                                ? program?.program_detail[0].name
                                : ""
                        }}
                    </option>
                </select>
                <error :fieldName="`program_id`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Preferred location where you want to study</label
                >
                <select
                    id="location"
                    name="location"
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="preferred_location"
                >
                    <option value="">Select</option>
                    <option value="Alberta">Alberta</option>
                    <option value="British Columbia">British Columbia</option>
                    <option value="Manitoba">Manitoba</option>
                    <option value="New Brunswick">New Brunswick</option>
                    <option value="Newfoundland and Labrador">
                        Newfoundland and Labrador
                    </option>
                    <option value="Nova Scotia">Nova Scotia</option>
                    <option value="Ontario">Ontario</option>
                    <option value="Prince Edward Island">
                        Prince Edward Island
                    </option>
                    <option value="Quebec">Quebec</option>
                    <option value="Saskatchewan">Saskatchewan</option>
                    <option value="Northwest Territories">
                        Northwest Territories
                    </option>
                    <option value="Nunavut">Nunavut</option>
                    <option value="Yukon">Yukon</option>
                </select>
                <error :fieldName="`preferred_location`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Type of help needed</label
                >
                <select
                    id="help-needed"
                    name="help-needed"
                    required
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="type_of_help"
                >
                    <option value="">Select</option>
                    <option value="financial">Financial Aid</option>
                    <option value="academic">Academic Support</option>
                    <option value="language">
                        Language Learning Assistance
                    </option>
                    <option value="career">Career Guidance</option>
                    <option value="other">Other</option>
                </select>
                <error :fieldName="`type_of_help`" :validationErros="errors" />
            </div>
            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Areas of Excellence</label
                >
                <select
                    id="help-needed"
                    name="help-needed"
                    required
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="area_of_excellence"
                >
                    <option value="">Select</option>
                    <option value="academic">Academic Achievements</option>
                    <option value="sports">Sports and Athletics</option>
                    <option value="community">
                        Community Service and Volunteer Work
                    </option>
                    <option value="leadership">
                        Leadership and Organizational Skills
                    </option>
                </select>
                <error :fieldName="`area_of_excellence`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative" v-if="area_of_excellence != ''">
                <label
                    for=""
                    class="text-gray-700 font-semibold text-sm lg:text-base"
                    >{{
                        area_of_excellence
                            ? capitalizeFirstLetter(area_of_excellence)
                            : ""
                    }}</label
                >
                <select
                    id="help-needed"
                    name="help-needed"
                    required
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="area_of_excellence_sub"
                    v-if="area_of_excellence == 'academic'"
                >
                    <option value="">Select</option>
                    <option
                        v-for="(academic, key) in academics"
                        :key="key"
                        :value="academic"
                    >
                        {{ academic }}
                    </option>
                </select>

                <select
                    id="help-needed"
                    name="help-needed"
                    required
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="area_of_excellence_sub"
                    v-if="area_of_excellence == 'sports'"
                >
                    <option value="">Select</option>
                    <option
                        v-for="(sport, key) in sports"
                        :key="key"
                        :value="sport"
                    >
                        {{ sport }}
                    </option>
                </select>

                <select
                    id="help-needed"
                    name="help-needed"
                    required
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="area_of_excellence_sub"
                    v-if="area_of_excellence == 'community'"
                >
                    <option value="">Select</option>
                    <option
                        v-for="(community, key) in communities"
                        :key="key"
                        :value="community"
                    >
                        {{ community }}
                    </option>
                </select>

                <select
                    id="help-needed"
                    name="help-needed"
                    required
                    class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="area_of_excellence_sub"
                    v-if="area_of_excellence == 'leadership'"
                >
                    <option value="">Select</option>
                    <option
                        v-for="(leadership, key) in leaderships"
                        :key="key"
                        :value="leadership"
                    >
                        {{ leadership }}
                    </option>
                </select>
                <error :fieldName="`area_of_excellence_sub`" :validationErros="errors" />
            </div>
            <div class="flex justify-end items-center gap-3 mt-4">
                <div>
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
</template>
<script>
import axios from "axios";
import { mapState } from "vuex";
import ErrorHandling from "../../ErrorHandling";
import Error from '../Error.vue';
export default {
    components: { Error },
    props: ["logged_in_customer", "customer"],
    computed: {
        ...mapState({
            degrees: (state) => state.degrees.degrees,
            programs: (state) => state.programs.programs,
        }),
    },
    data() {
        return {
            activeTab: "en",
            customer_detail: "",
            first_name: "",
            last_name: "",
            email: "",
            degree_id: "",
            program_id: "",
            area_of_excellence: "",
            area_of_excellence_sub: "",
            type_of_help: "",
            preferred_location: "",
            cgpa: "",
            whats_app_number: "",
            skype_id: "",
            we_chat_number: "",
            viber_number: "",
            imo_number: "",
            sports: ["Football", "Basketball", "Swimming", "Tennis"],
            academics: ["Mathematics", "Science", "Literature", "History"],
            communities: ["Volunteer Work", "Fundraising", "Social Services"],
            leaderships: [
                "Team Leadership",
                "Project Management",
                "Public Speaking",
            ],
            errors: new ErrorHandling(),
        };
    },
    methods: {
        closeModal() {
            this.$store.commit("school_informations/setShowModal", 0);
        },
        handleInput(e, key, language) {
            this.$store.commit("school_informations/setForData", {
                key,
                language: language ? language : "",
                value: e.target.value,
            });
        },
        changeLanguageTab(language) {
            this.activeTab = language.language_code;
        },
        addUpdate() {
            var data = {
                first_name: this.first_name,
                last_name: this.last_name,
                email: this.email,
                degree_id: this.degree_id,
                program_id: this.program_id,
                area_of_excellence: this.area_of_excellence,
                area_of_excellence_sub: this.area_of_excellence_sub,
                type_of_help: this.type_of_help,
                preferred_location: this.preferred_location,
                cgpa: this.cgpa,
                whats_app_number: this.whats_app_number,
                skype_id: this.skype_id,
                we_chat_number: this.we_chat_number,
                viber_number: this.viber_number,
                imo_number: this.imo_number,
            };
            axios
                .post("/api/web/update-student-profile", data)
                .then((res) => {
                    this.errors = new ErrorHandling();
                    if (res.data.status == "Success") {
                        helper.swalSuccessMessage(res.data.message);
                        window.location.reload();
                    } else {
                        helper.swalErrorMessage(res.data.message);
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.status == 422) {
                        this.errors.record(error.response.data.errors);
                    } else if (
                        error.response &&
                        error.response.data &&
                        error.response.data.status == "Error"
                    ) {
                        helper.swalErrorMessage(error.response.data.message);
                    }
                });
             ;
        },
        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
    },

    mounted() {
        this.customer_detail = JSON.parse(this.customer);
        console.log(this.customer_detail);
        if (this.customer_detail) {
            this.first_name = this.customer_detail?.first_name;
            this.last_name = this.customer_detail?.last_name;
            this.email = this.customer_detail?.email;
            this.degree_id = this.customer_detail?.degree_id;
            this.program_id = this.customer_detail?.program_id;
            this.area_of_excellence = this.customer_detail?.area_of_excellence;
            this.area_of_excellence_sub =
                this.customer_detail?.area_of_excellence_sub;
            this.type_of_help = this.customer_detail?.type_of_help;
            this.preferred_location = this.customer_detail?.preferred_location;
            this.cgpa = this.customer_detail?.cgpa;

            this.whats_app_number = this.customer_detail?.whats_app_number;
            this.skype_id = this.customer_detail?.skype_id;
            this.we_chat_number = this.customer_detail?.we_chat_number;
            this.viber_number = this.customer_detail?.viber_number;
            this.imo_number = this.customer_detail?.imo_number;
        }
        this.$store.commit("degrees/setLimit", 2000);
        this.$store.commit("degrees/setSortBy", "id");
        this.$store.commit("degrees/setSortType", "desc");
        this.$store.dispatch("degrees/fetchDegrees");

        this.$store.commit("programs/setLimit", 2000);
        this.$store.commit("programs/setSortBy", "id");
        this.$store.commit("programs/setSortType", "desc");
        this.$store.dispatch("programs/fetchPrograms");
    },
};
</script>
