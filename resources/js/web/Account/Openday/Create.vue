<template>
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full p-3 md:p-0">
        <div class="md:mt-4 flex justify-between items-center gap-2 px-4 p-2">
            <h2 class="can-school-h2 text-primary">Add your Open House day</h2>
        </div>
        <div class="md:mt-6 w-full md:w-8/12 md:ml-4">
            <div
                class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                <h3 data-v-181db5a2="" class="text-left">Language</h3>
                <p data-v-181db5a2="" class="text-left text-base font-normal text-gray-700">Select the website languages under which you want your Open House to appear</p>
                <ul class="flex gap-2 flex-wrap my-4">
                    <li class="mr-2 mb-2" v-for="language in languages" :key="language.code">
                        <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                            'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                            activeTab != null &&
                                activeTab == language.language_code
                                ? 'text-white bg-primary active'
                                : '',
                            errors.has(`title.title_${language.code}`)
                                ? 'bg-red-600 text-white hover:text-white'
                                : '',
                        ]">{{ getLanguageName(language.language_code) }}</a>
                    </li>
                </ul>
            </div>
            <div class="flex justify-end">
                <p class="text-red-500">
                    {{ indicate_required_field }}
                </p>
            </div>
            <div class="w-full mt-2 relative" v-for="language in languages" :key="language.language_code" :class="activeTab == language.language_code ? 'block' : 'hidden'
                ">
                <label for="" class="block text-base lg:text-lg">Title <span class="text-primary">*</span></label>
                
                <input type="text" name="title"
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInputDetail($event, 'title', language)" :value="form['title'] &&
                        form['title'][`title_${language.language_code}`]
                        ? form['title'][`title_${language.language_code}`]
                        : ''
                        " />
                <error :fieldName="`title.title_${language.language_code}`" :validationErros="errors" />
            </div>
            <div class="w-full mt-2 relative" v-for="language in languages" :key="language.language_code" :class="activeTab == language.language_code ? 'block' : 'hidden'
                ">
                <label for="" class="block text-base lg:text-lg mb-2">Description <span class="text-primary">*</span></label>
                <textarea name="description" id="" cols="5" rows="5"
                placeholder="300 words max. Describe your Open House to the students, potential guests and visitors"
                    class="border border-l-[5px] w-full border-l-primary border-gray-300 rounded mt-2 p-3 focus:outline-none focus:ring-none"
                    @input="handleInputDetail($event, 'description', language)">{{
                        form["description"] &&
                            form["description"][
                            `description_${language.language_code}`
                            ]
                            ? form["description"][
                            `description_${language.language_code}`
                            ]
                            : ""
                    }}</textarea>
                <error :fieldName="`description.description_${language.language_code}`" :validationErros="errors" />
            </div>
            <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg">Address <span class="text-primary">*</span></label>
                <input type="text" name="address"
                placeholder="Street name and number"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'address')" :value="form?.address ? form.address : ''" />
                <error :fieldName="`address`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg">City <span class="text-primary">*</span></label>
                
                <input type="text" name="city"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'city')" :value="form?.city ? form.city : ''" />
                <error :fieldName="`city`" :validationErros="errors" />
            </div>
            <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg">ZIP Code / Postal Code <span class="text-primary">*</span></label>
                
                <input type="text" name="postal_code"
                placeholder=""
                    class="border w-full border-l-[5px] focus:ring-none focus:outline-none mt-2 border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'postal_code')" :value="form?.postal_code ? form.postal_code : ''" />
                <error :fieldName="`postal_code`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg">Country <span class="text-primary">*</span></label>
                
                <input type="text" name="country"
                    class="border w-full border-l-[5px] focus:ring-none focus:outline-none mt-2 border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'country')" :value="form?.country ? form.country : ''" />
                <error :fieldName="`country`" :validationErros="errors" />
            </div>
            <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg">Date <span class="text-primary">*</span></label>
               
                <input type="date" name="date"
                @click="openDatePicker($event)"
            @keydown.prevent
                    class="border w-full border-l-[5px] focus:ring-none focus:outline-none mt-2 border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'date')" :value="form?.date ? form.date : ''" />
                <error :fieldName="`date`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg">Time <span class="text-primary">*</span></label>
                
                <input type="time" name="time"
                @click="openDatePicker($event)"
                @keydown.prevent
                    class="border w-full border-l-[5px] focus:ring-none focus:outline-none mt-2 border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'time')" :value="form?.time ? form.time : ''" />
                <error :fieldName="`time`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg">School email <span class="text-primary">*</span></label>
                
                <input type="email" name="school_email"
                    class="border w-full border-l-[5px] focus:ring-none focus:outline-none mt-2 border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'school_email')" :value="form?.school_email ? form.school_email : ''" />
                <error :fieldName="`school_email`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg">Phone <span class="text-primary">*</span></label>
                
                <input type="text " name="school_phone" placeholder="With area code"
                    class="border w-full border-l-[5px] focus:ring-none focus:outline-none mt-2 border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'school_phone')" :value="form?.school_phone ? form.school_phone : ''"
                    @keypress="restrictToNumbers($event, 15)" />
                <error :fieldName="`school_phone`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg">Open House URL</label>
                <input type="text" name="open_day_url"
                placeholder="If you have a web page about your Open House, or about your school in general, you can add it here"
                    class="border w-full border-l-[5px] focus:ring-none focus:outline-none mt-2 border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'open_day_url')" :value="form?.open_day_url ? form.open_day_url : ''" />
                <error :fieldName="`open_day_url`" :validationErros="errors" />
            </div>
          

            <div class="w-full mt-2 relative">
                <label class="block text-base lg:text-lg">Image <span class="text-primary">*</span></label>
                
                <p class="text-base">
                    (Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)
                </p>
                <input type="file" name="image"
                    class="border w-full border-l-[5px] focus:ring-none focus:outline-none mt-2 border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @change="handleImage($event)" />
                <error :fieldName="`image`" :validationErros="errors" />
                <div v-if="form['image']" class="w-40 h-40 bg-gray-50 border rounded mt-4">
                    <img :src="form?.image ? form.image : ''" class="w-full h-full object-contain" />
                </div>
            </div>
            <button class="my-4 can-edu-btn-fill" @click="addUpdate">
                Submit
            </button>
        </div>
    </div>
    <transition name="slide">
        <div id="defaultModal" tabindex="-1" aria-hidden="true"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="showPopUpModal">
            <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                ref="elementToDetectClick">
                <div class="relative">
                    <div class="absolute top-3 right-3 cursor-pointer" @click="togglePopUpModal">
                        <button type="button" class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                            <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                        <p class="text-center can-edu-p mt-2">
                            {{success_message}} 
                        </p>
                        <div class="flex justify-center">
                        <button type="button" class="can-edu-btn-fill  whitespace-nowrap px-2.5 md:px-5 mt-4"
                            @click="togglePopUpModal">
                            Close
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    
    
    <transition name="slide">
        <div id="defaultLockModal" tabindex="-1"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="showLockPopUpModal || (customer_data.user_type === 'school' && customer_data.package_price <= 0)">
            <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                ref="elementToDetectClick">
                <div class="relative">
                    <div class="absolute top-3 right-3 cursor-pointer" @click="toggleLockPopUpModal">
                        <button type="button" class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                            <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                        <p class="text-center can-edu-p mt-4">
                            Only Featured and Premium schools can register their Open House days. 
                            Click <a :href="school_request_template" class="text-primary font-semibold underline">here</a> to register your Open House day.
                        </p>
                        <div class="flex justify-center">
                        <button type="button" class="can-edu-btn-fill  whitespace-nowrap px-2.5 md:px-5 mt-4"
                            @click="toggleLockPopUpModal">
                            Close
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import { mapState } from "vuex";
import Error from "../../Error.vue";
export default {
    components: { Error },
    props: ["school_request_template","logged_in_customer_data","logged_in_customer", "school_id", "slug", "lang", "languages_with_names","success_message","indicate_required_field"],
    computed: {
        ...mapState({
            form: (state) => state.open_days.form,
            open_days: (state) => state.open_days.open_days,
            pagination: (state) => state.open_days.pagination,
            errors: (state) => state.open_days.validationErros,
            searchParam: (state) => state.open_days.searchParam,
            loading: (state) => state.open_days.loading,
            languages: (state) => state.open_days.form.languages,
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
            customer_data:[],
            activeTab: "en",
            showPopUpModal: false,
            showLockPopUpModal: false,

        };
    },
    methods: {
        openDatePicker(event) {
        event.target.showPicker(); 
    },
        toggleLockPopUpModal() {
            this.showLockPopUpModal = !this.showLockPopUpModal;
            if (!this.showLockPopUpModal) {
                window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/open-house";
            }
        },
       
        
        togglePopUpModal() {
            this.showPopUpModal = !this.showPopUpModal;
            if (!this.showPopUpModal) {
                window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/open-house";
            }
        },
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
        restrictToNumbers(event, allowedLength) {
            const keyCode = event.which ? event.which : event.keyCode;
            const inputChar = String.fromCharCode(keyCode);
            const isValidSpecialChar = /^[\+\-\(\)]$/.test(inputChar);
            const isDigit = /^\d$/.test(inputChar);
            let currentValue = event.target.value + inputChar;
            const digitCount = currentValue.replace(/[^\d]/g, "").length;
            if (!isValidSpecialChar && (!isDigit || digitCount > allowedLength)) {
                event.preventDefault();
            }
        },
        changeLanguageTab(language) {
            this.activeTab = language.language_code;
        },

        handleInputDetail(e, key, language) {
            this.$store.commit("open_days/setForData", {
                key,
                language,
                value: e.target.value,
            });
            const fieldKey = `${key}.${key}_${language.language_code}`;

            if (this.errors.has(fieldKey)) {
                this.errors.clear(fieldKey);
            }
        },
        handleInput(e, key, language) {

            this.$store.commit("open_days/setOpenDay", {
                key,
                language,
                value: e.target.value,
            });
            if (this.errors.has(key)) {
                this.errors.clear(key);
            }
        },
        addUpdate() {
            this.$store.dispatch("open_days/addUpdateForm").then((res) => {
                this.showPopUpModal = true;
            })
            .catch((error) => {
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
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.$store.commit("open_days/setOpenDay", {
                    key: "image",
                    value: res?.data,
                });
                if (this.errors.has("image")) {
                    this.errors.clear("image");
                }
            });
        },
        handleClickOutside(event) {
            // // Check if the click target is not within the element
            if (
                this.$refs.elementToDetectClick &&
                event.target.contains(this.$refs.elementToDetectClick)
            ) {
                // Clicked outside the element, you can perform actions here
                if (this.showPopUpModal == true) {
                    this.showPopUpModal = false;
                window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/open-house";

                }
                if (this.showLockPopUpModal == true) {
                    this.showLockPopUpModal = false;
                window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/open-house";

                }
            }
        }
    },
    created() {
        this.customer_data=JSON.parse(this.logged_in_customer_data)
    console.log('this.logged_in_customerthis.logged_in_customerthis.logged_in_customerthis.logged_in_customer',this.school_request_template)
        this.$store.commit("open_days/setOpenDay", {
            key: "customer_id",
            value: this.logged_in_customer,
        });

        this.$store.commit("open_days/setOpenDay", {
            key: "school_id",
            value: this.school_id,
        });
    },
    mounted() {
        axios
            .get(
                "/api/web/customer-languages?customer_id=" +
                this.logged_in_customer
            )
            .then((res) => {
                if (res.data.status == "Success") {
                    this.$store.commit("open_days/setLanguages", res.data.data);

                    res.data.data?.filter((lang) => {
                        this.$store.commit("open_days/setForData", {
                            key: "title",
                            language: lang,
                            value: "",
                        });
                        this.$store.commit("open_days/setForData", {
                            key: "description",
                            language: lang,
                            value: "",
                        });
                    });
                }
            });

        document.addEventListener("click", this.handleClickOutside);
    },
    beforeUnmount() {
        // Remove the click event listener when the component is unmounted
        document.removeEventListener("click", this.handleClickOutside);
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
