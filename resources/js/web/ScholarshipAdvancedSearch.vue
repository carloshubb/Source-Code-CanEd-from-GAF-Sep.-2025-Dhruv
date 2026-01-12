<template>
    <div class="relative flex items-center border border-gray-300 rounded">
        <button class="can-edu-btn-fill" @click="toggleModal">
            {{
                static_translations?.open_modal_text
                    ? static_translations?.open_modal_text
                    : ""
            }}
        </button>
    </div>
    <transition name="slide">
        <div
            id="defaultModal"
            tabindex="-1"
            aria-hidden="true"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="showModal"
        >
            <div
                class="relative w-full rounded-2xl shadow-2xl bg-white overflow-hidden border-4 border-primary/30 h-full max-w-2xl"
                ref="elementToDetectClick"
            >
                <!-- Modal content -->
                <div class="bg-white p-6 rounded-2xl shadow-2xl text-center pt-10 text-left h-full overflow-auto">
                    <!-- Modal header -->
                    <div
                        class="flex items-start justify-between p-4 rounded-t dark:border-gray-600"
                    >
                        <div class="text-left">
                            <h3 class="can-edu-h3 mb-0">
                                {{
                                    static_translations?.modal_title
                                        ? static_translations?.modal_title
                                        : ""
                                }}
                            </h3>
                            <span class="text-sm">You can search for scholarships by one or more of these criteria</span>
                        </div>
                        <div>
                            <button
                                type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="defaultModal"
                                @click="toggleModal"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="w-5 h-5 text-primary"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                                <span class="sr-only">close</span>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <form @submit="searchForm" class="text-left h-full overflow-auto">
                            <div class="w-full mt-4">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                >
                                    {{
                                        static_translations?.Keywords_input_label
                                            ? static_translations?.Keywords_input_label
                                            : ""
                                    }}
                                </label>
                                <input
                                    type="text"
                                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 mt-1"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-4 rounded-r border-r-primary'
                                            : 'border-l-4 rounded-l border-l-primary'
                                    "
                                    name="keywords"
                                    v-model="keywords"
                                />
                            </div>
                            <div class="w-full mt-4">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                >
                                    {{
                                        static_translations?.school_name_input_label
                                            ? static_translations?.school_name_input_label
                                            : ""
                                    }}
                                </label>
                                <input
                                    type="text"
                                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 mt-1"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-4 rounded-r border-r-primary'
                                            : 'border-l-4 rounded-l border-l-primary'
                                    "
                                    name="name"
                                    v-model="name"
                                />
                            </div>
                            <div class="w-full mt-4">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                >
                                    {{
                                        static_translations?.school_input_label
                                            ? static_translations?.school_input_label
                                            : ""
                                    }}</label
                                >
                                <div class="relative">
                                <!-- <Select2
                                    v-model="school"
                                    :options="local_schools"
                                    :settings="{
                                        width: '100%',
                                        multiple: true,
                                    }"
                                    class="border w-full focus:ring-primary focus:outline-none rounded lg:text-lg border-gray-300"
                                /> -->
                                <v-select label="text" track-by="id" v-model="school" :options="local_schools" :reduce="school => school.id" multiple></v-select>
                            </div>
                        </div>
                            <div class="w-full mt-4">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                    >{{
                                        static_translations?.province_input_label
                                            ? static_translations?.province_input_label
                                            : ""
                                    }}</label
                                >
                                <select
                                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 mt-1"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-4 rounded-r border-r-primary'
                                            : 'border-l-4 rounded-l border-l-primary'
                                    "
                                    name="province"
                                    v-model="province"
                                >
                                    <option value="">All</option>
                                    <option value="Alberta">Alberta</option>
                                    <option value="British Columbia">
                                        British Columbia
                                    </option>
                                    <option value="Manitoba">Manitoba</option>
                                    <option value="New Brunswick">
                                        New Brunswick
                                    </option>
                                    <option value="Newfoundland and Labrador">
                                        Newfoundland and Labrador
                                    </option>
                                    <option value="Nova Scotia">
                                        Nova Scotia
                                    </option>
                                    <option value="Ontario">Ontario</option>
                                    <option value="Prince Edward Island">
                                        Prince Edward Island
                                    </option>
                                    <option value="Quebec">Quebec</option>
                                    <option value="Saskatchewan">
                                        Saskatchewan
                                    </option>
                                </select>
                            </div>
                            <div class="w-full mt-4">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                    >{{
                                        static_translations?.award_input_label
                                            ? static_translations?.award_input_label
                                            : ""
                                    }}</label
                                >
                                <select
                                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 mt-1"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-4 rounded-r border-r-primary'
                                            : 'border-l-4 rounded-l border-l-primary'
                                    "
                                    name="awards"
                                    v-model="awards"
                                >
                                    <option value="">All</option>
                                    <option value="Admission">Admission</option>
                                    <option value="Current students">
                                        Current students
                                    </option>
                                </select>
                            </div>
                            <div class="w-full mt-4">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                    >{{
                                        static_translations?.action_input_label
                                            ? static_translations?.action_input_label
                                            : ""
                                    }}</label
                                >
                                <select
                                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 mt-1"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-4 rounded-r border-r-primary'
                                            : 'border-l-4 rounded-l border-l-primary'
                                    "
                                    name="action"
                                    v-model="action"
                                >
                                    <option value="">All</option>
                                    <option value="Application Required">
                                        Application required
                                    </option>
                                    <option value="No application required">
                                        No application required
                                    </option>
                                </select>
                            </div>
                            <div class="w-full mt-4">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                    >{{
                                        static_translations?.availability_input_label
                                            ? static_translations?.availability_input_label
                                            : ""
                                    }}</label
                                >
                                <select
                                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 mt-1"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-4 rounded-r border-r-primary'
                                            : 'border-l-4 rounded-l border-l-primary'
                                    "
                                    name="availability"
                                    v-model="availability"
                                >
                                    <option value="">
                                        All students
                                    </option>
                                    <option value="International students">
                                        International students
                                    </option>
                                    <option value="Canadian students">
                                        Canadian (national) students
                                    </option>
                                    <option value="Provincial students">
                                        Canadian (provincial) students
                                    </option>
                                    <option value="Black students">
                                        Black students
                                    </option>
                                    <option value="Latino students">
                                        Latino students
                                    </option>
                                    <option value="Aborignal people">
                                        Natives / Aborignal People
                                    </option>
                                    <option value="Visible minorities">
                                        Visible minorities
                                    </option>
                                    <option value="Female Students">
                                        Female Students
                                    </option>
                                    </select>
                            </div>
                            <div class="w-full mt-4">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                    >{{
                                        static_translations?.level_of_study_input_label
                                            ? static_translations?.level_of_study_input_label
                                            : ""
                                    }}</label
                                >
                                <select
                                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 mt-1"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-4 rounded-r border-r-primary'
                                            : 'border-l-4 rounded-l border-l-primary'
                                    "
                                    name="study_level"
                                    v-model="study_level"
                                >
                                    <option value="">All</option>
                                    <option value="School">School - primary and high</option>
                                    <option value="Graduate">Graduate</option>
                                    <option value="Undergraduate">
                                        Undergraduate
                                    </option>
                                </select>
                            </div>
                            <div class="w-full mt-4">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                    >{{
                                        static_translations?.duration_input_label
                                            ? static_translations?.duration_input_label
                                            : ""
                                    }}</label
                                >
                                <select
                                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 mt-1"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-4 rounded-r border-r-primary'
                                            : 'border-l-4 rounded-l border-l-primary'
                                    "
                                    name="duration"
                                    v-model="duration"
                                >
                                    <option value="">All</option>
                                    <option value="Full time">Full-time</option>
                                    <option value="Part time">Part-time</option>
                                </select>
                            </div>
                            <div class="w-full mt-4">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                >
                                    {{
                                        static_translations?.amount_input_label
                                            ? static_translations?.amount_input_label
                                            : ""
                                    }}
                                </label>
                                <input
                                    type="text"
                                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 mt-1"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-4 rounded-r border-r-primary'
                                            : 'border-l-4 rounded-l border-l-primary'
                                    "
                                    name="amount"
                                    v-model="amount"
                                />
                            </div>
                            <div class="w-full mt-4">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                >
                                    {{
                                        static_translations?.date_posted_input_label
                                            ? static_translations?.date_posted_input_label
                                            : ""
                                    }}
                                </label>
                                <input
            @click="openDatePicker($event)"

                                    type="date"
                                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 mt-1"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-4 rounded-r border-r-primary'
                                            : 'border-l-4 rounded-l border-l-primary'
                                    "
                                    name="date_posted"
                                    v-model="date_posted"
                                />
                            </div>
                            <div class="w-full mt-4">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                >
                                    {{
                                        static_translations?.expiry_date_input_label
                                            ? static_translations?.expiry_date_input_label
                                            : ""
                                    }}
                                </label>
                                <input
            @click="openDatePicker($event)"

                                    type="date"
                                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 mt-1"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-4 rounded-r border-r-primary'
                                            : 'border-l-4 rounded-l border-l-primary'
                                    "
                                    name="expiry_date"
                                    v-model="expiry_date"
                                />
                            </div>
                            <div class="w-full mt-4">
                                <label
                                    for=""
                                    class="block text-base lg:text-lg"
                                >
                                    {{
                                        static_translations?.application_deadline_input_label
                                            ? static_translations?.application_deadline_input_label
                                            : ""
                                    }}
                                </label>
                                <input
            @click="openDatePicker($event)"

                                    type="date"
                                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300 mt-1"
                                    :class="
                                        position == 'rtl'
                                            ? 'border-r-4 rounded-r border-r-primary'
                                            : 'border-l-4 rounded-l border-l-primary'
                                    "
                                    name="application_deadline"
                                    v-model="application_deadline"
                                />
                            </div>
                            <div
                                class="flex justify-center items-center gap-3 mt-4"
                            >
                                <button type="submit" class="can-edu-btn-fill">
                                    {{
                                        static_translations?.submit_button_text
                                            ? static_translations?.submit_button_text
                                            : ""
                                    }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
<style scoped>
.select2-container{
    max-width: 465px;
}
/* Slide Animation */
.slide-enter-active, .slide-leave-active {
  transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}
.slide-enter-from, .slide-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}
</style>

<script>
import 'vue-select/dist/vue-select.css';
// ES6 Modules or TypeScript
import Swal from "sweetalert2";
import axios from "axios";
import ErrorHandling from "../ErrorHandling";
import { mapState } from "vuex";
import vueRecaptcha from "vue3-recaptcha2";
import Select2 from "vue3-select2-component";
export default {
    props: ["position", "scholarship_advance_search_translation", "lang"],
    components: {
        vueRecaptcha,
        Select2,
    },
    computed: {
        ...mapState({
            schools: (state) => state.schools.schools,
        }),
    },
    data() {
        return {
            showModal: false,
            keywords: "",
            name: "",
            school: [],
            province: "",
            awards: "",
            action: "",
            availability: "",
            study_level: "",
            duration: "",
            amount: "",
            date_posted: "",
            expiry_date: "",
            application_deadline: "",
            errors: new ErrorHandling(),
            error_message: "",
            activeTab: null,
            showRecaptcha: true,
            toggelSubmitButton: false,
            emailValidationErro: "",
            static_translations: {},
            local_schools: [],
            selected_language: this.lang,
        };
    },
    methods: {
        openDatePicker(event) {
        event.target.showPicker(); 
    },
        searchForm(e) {
            e.preventDefault();
            const url =
                "./scholarship-advanced-search?school=" +
                this.school +
                "&keywords=" +
                this.keywords +
                "&name=" +
                this.name +
                "&province=" +
                this.province +
                "&awards=" +
                this.awards +
                "&action=" +
                this.action +
                "&availability=" +
                this.availability +
                "&study_level=" +
                this.study_level +
                "&duration=" +
                this.duration +
                "&amount=" +
                this.amount +
                "&date_posted=" +
                this.date_posted +
                "&expiry_date=" +
                this.expiry_date +
                "&application_deadline=" +
                this.application_deadline;
            window.location.href = url;
        },
        toggleModal() {
            this.showModal = !this.showModal;
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("media", e.target.files[0]);
            file.append("is_temp_media", true);
            file.append("type", "event_image");
            axios.post("/api/web/media/process", file).then((res) => {
                this.image = JSON.stringify(res?.data);
            });
        },
        handleInput(val, i, key) {
            this[key][key + "_" + i] = val;
        },
        recaptchaVerified(response) {
            this.toggelSubmitButton = true;
        },
        recaptchaExpired() {
            this.toggelSubmitButton = false;
            this.$refs.vueRecaptcha.reset();
        },
        recaptchaFailed() {
            this.toggelSubmitButton = false;
        },
        handleClickOutside(event) {
            // // Check if the click target is not within the element
            if (
                this.$refs.elementToDetectClick &&
                event.target.contains(this.$refs.elementToDetectClick)
            ) {
                // Clicked outside the element, you can perform actions here
                if (this.showModal == true) {
                    this.showModal = false;
                }
            }
        },
    },
    created() {
        this.$store.commit("schools/setLimit", 100);
        this.$store.commit("schools/setSortBy", "id");
        this.$store.commit("schools/setSortType", "desc");
        this.$store.dispatch("schools/fetchSchools").then((res) => {
            if (res?.data?.data?.length > 0) {
                this.local_schools = [];
                for (var i = 0; i < res?.data?.data?.length; i++) {
                    this.local_schools.push({
                        id: parseInt(res?.data?.data[i].id),
                        text:
                            res?.data?.data[i]?.school_detail?.length > 0
                                ? res?.data?.data[i]?.school_detail[0]
                                      ?.school_name
                                : "abc",
                    });
                }
                this.local_schools.sort(function (a, b) {
                    if (a.text < b.text) {
                        return -1;
                    }
                    if (a.text > b.text) {
                        return 1;
                    }
                    return 0;
                });
            }
        });
        this.static_translations = JSON.parse(
            this.scholarship_advance_search_translation
        );
    },
    mounted() {
        // Add a click event listener to the document
        document.addEventListener("click", this.handleClickOutside);
    },
    beforeUnmount() {
        // Remove the click event listener when the component is unmounted
        document.removeEventListener("click", this.handleClickOutside);
    },
};
</script>
