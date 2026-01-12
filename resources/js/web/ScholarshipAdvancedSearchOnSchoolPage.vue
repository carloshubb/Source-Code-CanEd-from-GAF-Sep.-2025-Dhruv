<template>
  <div>
    <form @submit.prevent="searchForm" class="bg-gray-100 p-4 py-6 mt-4">
      <label
        for="keyword-search"
        class="mb-2 text-sm font-medium text-gray-900 sr-only"
        >Search</label
      >
      <div class="relative">
        <div
          class="absolute inset-y-0 start-0 flex items-center pl-3 pointer-events-none"
        >
          <svg
            class="w-6 h-6 text-gray-900"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 20 20"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
            />
          </svg>
        </div>
        <input
          type="search"
          id="keyword-search"
          class="block w-full p-4 pl-14 text-gray-900 placeholder-gray-900 font-medium border border-gray-300 bg-white focus:ring-blue-500 focus:border-blue-500"
          placeholder="Enter keywords"
          v-model="name"
        />
      </div>

      <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class=" w-full">
          <label for="" class="block text-base lg:text-lg">{{
            static_translations?.province_input_label
              ? static_translations?.province_input_label
              : ""
          }}</label>
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
            <option value="British Columbia">British Columbia</option>
            <option value="Manitoba">Manitoba</option>
            <option value="New Brunswick">New Brunswick</option>
            <option value="Newfoundland and Labrador">
              Newfoundland and Labrador
            </option>
            <option value="Nova Scotia">Nova Scotia</option>
            <option value="Ontario">Ontario</option>
            <option value="Prince Edward Island">Prince Edward Island</option>
            <option value="Quebec">Quebec</option>
            <option value="Saskatchewan">Saskatchewan</option>
          </select>
        </div>
        <div class=" w-full">
          <label for="" class="block text-base lg:text-lg">{{
            static_translations?.award_input_label
              ? static_translations?.award_input_label
              : ""
          }}</label>
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
            <option value="Current students">Current students</option>
            <option value="Admission and current students">
              Admission and current students
            </option>
          </select>
        </div>
        <div class=" w-full">
          <label for="" class="block text-base lg:text-lg">{{
            static_translations?.action_input_label
              ? static_translations?.action_input_label
              : ""
          }}</label>
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
            <option value="Application Required">Application Required</option>
            <option value="Application Not Required">
              Application Not Required
            </option>
          </select>
        </div>
        <div class=" w-full">
          <label for="" class="block text-base lg:text-lg">{{
            static_translations?.availability_input_label
              ? static_translations?.availability_input_label
              : ""
          }}</label>
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
            <option value="All students">All students</option>
            <option value="International students">
              International students
            </option>
            <option value="Canadian students">Canadian students</option>
            <option value="Provincial students">Provincial students</option>
          </select>
        </div>
        <div class=" w-full">
          <label for="" class="block text-base lg:text-lg">{{
            static_translations?.level_of_study_input_label
              ? static_translations?.level_of_study_input_label
              : ""
          }}</label>
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
            <option value="Graduate">Graduate</option>
            <option value="Undergraduate">Undergraduate</option>
            <option value="Graduate and Undergraduate">
              Graduate and undergraduate
            </option>
          </select>
        </div>
        <div class=" w-full">
          <label for="" class="block text-base lg:text-lg">{{
            static_translations?.duration_input_label
              ? static_translations?.duration_input_label
              : ""
          }}</label>
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
            <option value="Full time">Full-Time</option>
            <option value="Part time">Part-Time</option>
          </select>
        </div>
      </div>
      <div class="flex justify-center items-center gap-3 mt-4">
        <button type="submit" class="can-edu-btn-fill">
          {{
            static_translations?.submit_button_text
              ? static_translations?.submit_button_text
              : ""
          }}
        </button>
      </div>
    </form>
    <div class="my-10" v-if="scholarships.length > 0">
        <h2 class="can-edu-h2 normal-case mb-2">
            Scholarships results
        </h2>
        <div class="mt-6 space-y-6">
            <div class="bg-gray-100 p-6 grid grid-cols-12 gap-6" v-for="scholarship in scholarships" :key="scholarship.id">
                <div class="col-span-12 md:col-span-4">
                    <div class="bg-gray-50 border h-56 mb-4">
                        <img class="h-full w-full img-fluid object-cover" :src="scholarship?.image"
                            alt="">
                    </div>
                    <a :href="scholarship?.link || '#'" target="_blank" class="canedu_btn w-full">Apply now</a>
                </div>
                <div class="col-span-12 md:col-span-8">
                    <div class="grid grid-cols-12">
                        <div class="col-span-4 md:col-span-2 font-bold">
                            <p class="font-bold font-FuturaMdCnBT text-xl">
                                Name
                            </p>
                        </div>
                        <div class="col-span-1 text-center font-bold">:</div>
                        <div class="col-span-7 md:col-span-9 font-bold text-black">
                            <p class="font-FuturaBdCnBT text-2xl text-gray-900">
                                {{scholarship.school_scholarship_detail?.[0]?.name || ''}}
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 mt-3">
                        <div class="col-span-4 md:col-span-2 font-bold">
                            <p class="font-bold font-FuturaMdCnBT text-xl">
                                School
                            </p>
                        </div>
                        <div class="col-span-1 text-center font-bold">:</div>
                        <div class="col-span-7 md:col-span-9 text-black line-clamp-3 text_justify">
                            <p>{{scholarship?.school?.school_detail?.[0]?.school_name || ''}}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 mt-3">
                        <div class="col-span-4 md:col-span-2 font-bold">
                            <p class="font-bold font-FuturaMdCnBT text-xl">
                                Summary
                            </p>
                        </div>
                        <div class="col-span-1 text-center font-bold">:</div>
                        <div class="col-span-7 md:col-span-9 text-black">
                            <p v-html="scholarship?.school_scholarship_detail?.[0]?.summary"></p>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 mt-3">
                        <div class="col-span-4 md:col-span-2 font-bold">
                            <p class="font-bold font-FuturaMdCnBT text-xl">
                                Province
                            </p>
                        </div>
                        <div class="col-span-1 text-center font-bold">:</div>
                        <div class="col-span-7 md:col-span-9 text-black">
                            {{ scholarship?.province }}
                        </div>
                    </div>
                    <div class="grid grid-cols-12 mt-3">
                        <div class="col-span-4 md:col-span-2 font-bold">
                            <p class="font-bold font-FuturaMdCnBT text-xl">
                                Deadline
                            </p>
                        </div>
                        <div class="col-span-1 text-center font-bold">:</div>
                        <div class="col-span-7 md:col-span-9 text-black">
                            <p>
                                {{ scholarship?.deadline_date }}
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 mt-3">
                        <div class="col-span-4 md:col-span-2 font-bold">
                            <p class="font-bold font-FuturaMdCnBT text-xl">
                                Duration
                            </p>
                        </div>
                        <div class="col-span-1 text-center font-bold">:</div>
                        <div class="col-span-7 md:col-span-9 text-black">
                            <p>{{scholarship?.duration}}</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
  </div>
</template>
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

<script>
// ES6 Modules or TypeScript
import axios from "axios";
import ErrorHandling from "../ErrorHandling";
import { mapState } from "vuex";
import vueRecaptcha from "vue3-recaptcha2";
import Select2 from "vue3-select2-component";
export default {
  props: ["position", "scholarship_advance_search_translation", "lang", "school_id"],
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
      name: "",
      scholarships: [],
      school: [],
      province: "",
      awards: "",
      action: "",
      availability: "",
      study_level: "",
      duration: "",
      errors: new ErrorHandling(),
      error_message: "",
      activeTab: null,
      showRecaptcha: true,
      toggelSubmitButton: false,
      emailValidationErro: "",
      static_translations: {},
      selected_language: this.lang,
    };
  },
  methods: {
    // searchForm(e) {
    //   e.preventDefault();
    //   const url =
    //     process.env.MIX_APP_URL+"/"+JSON.parse(this.lang)['abberivation']+"/scholarship-advanced-search?json_response=1&school=" +
    //     this.school_id +
    //     "&name=" +
    //     this.name +
    //     "&province=" +
    //     this.province +
    //     "&awards=" +
    //     this.awards +
    //     "&action=" +
    //     this.action +
    //     "&availability=" +
    //     this.availability +
    //     "&study_level=" +
    //     this.study_level +
    //     "&duration=" +
    //     this.duration;
    //     axios.get(url).then((res) => {
    //       console.log('scholarship res'.res);
    //         if(res?.data?.status == 'Success'){
    //             this.scholarships = res.data.data
    //         }
    //   });
    // //   window.location.href = url;
    // },
    
    searchForm(e) {
    e.preventDefault();
    
    const url =
        process.env.MIX_APP_URL + "/" + JSON.parse(this.lang)["abberivation"] +
        "/scholarship-advanced-search?json_response=1" + 
        "&name=" + this.name +
        "&province=" + this.province +
        "&awards=" + this.awards +
        "&action=" + this.action +
        "&availability=" + this.availability +
        "&study_level=" + this.study_level +
        "&duration=" + this.duration +
        "&school=" + this.school_id; // Keep school ID for sorting

    axios.get(url).then((res) => {
        console.log("Scholarship response:", res);
        if (res?.data?.status == "Success") {
            this.scholarships = res.data.data;
        }
    });
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
  },
  created() {
    this.$store.commit("schools/setLimit", 100);
    this.$store.commit("schools/setSortBy", "id");
    this.$store.commit("schools/setSortType", "desc");
    this.static_translations = JSON.parse(
      this.scholarship_advance_search_translation
    );
  },
};
</script>
