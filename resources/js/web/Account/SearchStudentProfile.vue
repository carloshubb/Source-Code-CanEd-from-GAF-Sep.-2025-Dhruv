<template>
    <div class="modal-content py-6 text-left px-6">
        <div class="flex justify-between items-center pb-3">
            <h1 class="can-edu-h1">Search student profiles</h1>
        </div>
        <div class="modal-body">
            <div class="w-full grid grid-cols-2 gap-4">
                <div class="">
                    <div class="w-full mt-2 relative">
                        <label
                            for=""
                            class="text-gray-700 font-semibold text-sm lg:text-base"
                            >CGPA</label
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
                            >Degree Level</label
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
                </div>
                <div class="">
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
                            >Preferred Location</label
                        >
                        <select
                            id="location"
                            name="location"
                            class="mt-1 border w-full border-l-[5px] focus:ring-none focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                            v-model="preferred_location"
                        >
                            <option value="">Select</option>
                            <option value="Alberta">Alberta</option>
                            <option value="British Columbia">
                                British Columbia
                            </option>
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
                </div>
                <div class="">
                    <div class="w-full mt-2 relative">
                        <label
                            for=""
                            class="text-gray-700 font-semibold text-sm lg:text-base"
                            >Type of Help Needed</label
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
                </div>
                <div>
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
                            <option value="academic">
                                Academic Achievements
                            </option>
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
                </div>
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
                    Save it for new student profiles
                    <input type="checkbox" v-model="save_for_new_students" />
                </div>
                <div>
                    <button class="can-edu-btn-fill" @click="addUpdate">
                        Search profiles
                    </button>
                </div>
                <div>
                    <button class="can-edu-btn-fill" @click="clearFilter">
                        Clear filters
                    </button>
                </div>
            </div>
            <br /><br />
            <div
                class="flex justify-end items-center gap-3 mt-4"
                v-if="results?.length > 1"
            >
                <div>
                    <button
                        class="can-edu-btn-fill"
                        @click="sendEmailToAllStudents"
                    >
                        Send email to all search results
                    </button>
                </div>
            </div>

            <div class="border rounded p-4 w-full grid grid-cols-12 gap-6 mt-4">
                <div
                    class="col-span-12"
                    v-if="results?.length == 0 && searchExecuted"
                >
                    <div>
                        <p>No search results found</p>
                    </div>
                </div>
                <div
                    class="col-span-12"
                    v-for="(customer, i) in results"
                    :key="i"
                >
                    <div class="grid grid-cols-1 p-4">
                        <div class="grid grid-cols-12">
                            <div class="col-span-3 font-extrabold">
                                <p>Name</p>
                            </div>
                            <div
                                class="col-span-1 font-extrabold text-gray-700"
                            >
                                <p>:</p>
                            </div>
                            <div
                                class="col-span-8 font-extrabold text-gray-700"
                            >
                                <p>
                                    {{
                                        customer?.first_name
                                            ? customer?.first_name +
                                              " " +
                                              customer?.last_name
                                            : ""
                                    }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 mt-2">
                            <div class="col-span-3 font-extrabold">
                                <p>Area of Excellence</p>
                            </div>
                            <div
                                class="col-span-1 font-extrabold text-gray-700"
                            >
                                <p>:</p>
                            </div>
                            <div class="col-span-8 text-gray-700">
                                <p>
                                    {{
                                        customer?.area_of_excellence
                                            ? customer?.area_of_excellence
                                            : ""
                                    }}

                                    {{
                                        customer?.area_of_excellence
                                            ? customer?.area_of_excellence_sub
                                            : ""
                                    }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 mt-2">
                            <div
                                class="col-span-4 md:col-span-3 font-extrabold"
                            >
                                <p>Prefered Location</p>
                            </div>
                            <div
                                class="col-span-1 font-extrabold text-gray-700"
                            >
                                <p>:</p>
                            </div>
                            <div class="col-span-7 md:col-span-8 text-gray-700">
                                <p>
                                    {{
                                        customer?.province
                                            ? customer?.province
                                            : ""
                                    }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 mt-2">
                            <div class="col-span-3 font-extrabold">
                                <p>Cgpa</p>
                            </div>
                            <div
                                class="col-span-1 font-extrabold text-gray-700"
                            >
                                <p>:</p>
                            </div>
                            <div class="col-span-8 text-gray-700">
                                <p>
                                    {{
                                        customer?.cgpa ? customer?.province : ""
                                    }}
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 mt-2">
                            <div class="col-span-3 font-extrabold">
                                <p>Degree</p>
                            </div>
                            <div
                                class="col-span-1 font-extrabold text-gray-700"
                            >
                                <p>:</p>
                            </div>
                            <div class="col-span-8 text-gray-700">
                                <p>
                                    {{
                                        customer?.degree?.degree_detail
                                            ?.length > 0
                                            ? customer?.degree?.degree_detail[0]
                                                  ?.name
                                            : ""
                                    }}
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 mt-2">
                            <div class="col-span-3 font-extrabold">
                                <p>Program</p>
                            </div>
                            <div
                                class="col-span-1 font-extrabold text-gray-700"
                            >
                                <p>:</p>
                            </div>
                            <div class="col-span-8 text-gray-700">
                                <p>
                                    {{
                                        customer?.program?.program_detail
                                            ?.length > 0
                                            ? customer?.program
                                                  ?.program_detail[0]?.name
                                            : ""
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mb-3">
                        <button
                            class="can-edu-btn-fill"
                            @click="sendAnEmail(customer?.id)"
                        >
                            Send
                            {{
                                customer?.first_name
                                    ? customer?.first_name +
                                      " " +
                                      customer?.last_name
                                    : ""
                            }}
                            an email
                        </button>
                    </div>
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
    props: ["logged_in_customer"],
    computed: {
        ...mapState({
            degrees: (state) => state.degrees.degrees,
            programs: (state) => state.programs.programs,
        }),
    },
    data() {
        return {
            searchExecuted: false,
            activeTab: "en",
            degree_id: "",
            program_id: "",
            area_of_excellence: "",
            area_of_excellence_sub: "",
            type_of_help: "",
            preferred_location: "",
            cgpa: "",
            results: [],
            save_for_new_students: false,
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
        clearFilter() {
            this.degree_id = "";
            this.program_id = "";
            this.area_of_excellence = "";
            this.area_of_excellence_sub = "";
            this.type_of_help = "";
            this.preferred_location = "";
            this.cgpa = "";
            this.results = [];
            this.save_for_new_students = false;
            this.searchExecuted = false;
        },
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
        sendEmailToAllStudents() {
            this.$swal
                .fire({
                    title: "Are you sure?",
                    text: "This will send email to all search results!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Send it!",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        let emails = this.results?.map((res) => res.email);
                        console.log(emails);
                        axios
                            .post("/api/web/send-email-to-all-students", {
                                emails,
                            })
                            .then((res) => {
                                console.log(res);
                                if (res.data.status == "Success") {
                                    helper.swalSuccessMessage(res.data.message);
                                }
                            })
                            .catch((error) => {
                                if (
                                    error.response &&
                                    error.response.data &&
                                    error.response.data.status == "Error"
                                ) {
                                    helper.swalErrorMessage(
                                        error.response.data.message
                                    );
                                }
                            });
                    }
                });
        },
        sendAnEmail(student_id) {
            axios
                .post("/api/web/send-email-to-student", {
                    student: student_id,
                })
                .then((res) => {
                    console.log(res);
                    if (res.data.status == "Success") {
                        helper.swalSuccessMessage(res.data.message);
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
        },
        addUpdate() {
            this.searchExecuted = false;
            var data = {
                degree_id: this.degree_id,
                program_id: this.program_id,
                area_of_excellence: this.area_of_excellence,
                area_of_excellence_sub: this.area_of_excellence_sub,
                type_of_help: this.type_of_help,
                preferred_location: this.preferred_location,
                cgpa: this.cgpa,
                save_for_new_students: this.save_for_new_students,
            };
             ;
            axios
                .post("/api/web/search-student-profile", data)
                .then((res) => {
                    console.log(res);
                    if (res.data.status == "Success") {
                        this.searchExecuted = true;
                        this.results = res.data.data;
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
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.$store.commit("school_informations/setForData", {
                    key: "image",
                    value: res?.data,
                });
            });
        },
        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
    },

    mounted() {
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
