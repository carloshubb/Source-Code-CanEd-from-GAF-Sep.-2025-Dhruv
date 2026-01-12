<template>
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full p-3 md:p-0">
        <div class="md:mt-4 flex justify-between gap-2 p-2">
            <h2 class="px-2 can-school-h2 text-primary">Create virtual tour</h2>
        </div>
        <!-- <div v-if="logged_in_customer && logged_in_customer_paid" class="md:mt-6 w-full md:w-8/12 md:ml-4"> -->
        <!-- <div v-if="logged_in_customer && logged_in_customer_package != 1" class="w-full md:w-8/12 md:ml-4"> -->
            <div v-if="logged_in_customer && is_package_amount_paid_create > 0" class="w-full md:w-8/12 md:ml-4">

            <div
                class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                <h3 data-v-181db5a2="" class="text-left">Language</h3>
                <p data-v-181db5a2="" class="text-left text-base font-normal text-gray-700">Select the languages under which you want your virtual tour to appear</p>
                <ul class="flex gap-2 flex-wrap my-4">
                    <li class="mr-2 mb-2" v-for="language in languages" :key="language.id">
                        <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                            'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                            (activeTab == null && language.is_default) ||
                                activeTab == language.id
                                ? 'text-white bg-primary active'
                                : '',
                            errors.has(
                                `description.description_${language.id}`
                            )
                                ? 'bg-red-600 text-white hover:text-white'
                                : '',
                        ]">{{ language.name }}</a>
                    </li>
                </ul>
            </div>
            <div class="" v-for="language in languages" :key="language.id" :class="(activeTab == null && language.is_default) ||
                activeTab == language.id
                ? 'block'
                : 'hidden'
                ">
                <div class="relative z-0 w-full mb-2 group mt-4">
                    <label class="block text-base lg:text-lg mb-2">Description / Title of the tour</label>
                    <textarea placeholder="Tell the students what this virtual tour is about; what they are going to see; e.g. “Our downtown campus”" name="description"
                        class="w-full focus:ring-primary focus:ring-1 focus:ring-.5 focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                            " @input="
                                handleMultipleInput(
                                    'description',
                                    $event.target.value,
                                    language
                                )
                                " :value="form['description'] &&
                                    form['description'][`description_${language.id}`]
                                    ? form['description'][
                                    `description_${language.id}`
                                    ]
                                    : ''
                                    "></textarea>
                    <error :fieldName="`description.description_${language.id}`" :validationErros="errors" />
                </div>
            </div>
            <div class="w-full mt-2 relative">
                <label class="block text-base lg:text-lg">Color</label>
                <input type="text" name="color"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'color')" :value="form?.color ? form.color : ''" />
                <error :fieldName="`color`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label class="block text-base lg:text-lg">Virtual tour’s link</label>
                <input type="text" name="link" placeholder="Copy and paste the URL of the virtual tour web page"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'link')" :value="form?.link ? form.link : ''" />
                <error :fieldName="`link`" :validationErros="errors" />
            </div>

            <!-- <div class="w-full mt-2 relative">
                <label class="block text-base lg:text-lg">Deadline Date</label>
                <input type="date"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'date')" 
                    v-model="deadlineDate" />
                <error :fieldName="`date`" :validationErros="errors" />
            </div> -->

            <div class="w-full mt-2 relative">
                <label class="block text-base lg:text-lg">Image - This image appears on the search results page. It can be of your campus, facilities, buildings, special events, … etc.</label>
                <p class="text-base">
                    (Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)
                </p>
                <input type="file" name="image"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @change="handleImage($event)" />
                <error :fieldName="`image`" :validationErros="errors" />
                <error :fieldName="`file`" :validationErros="errors" />
                <div v-if="form['image']" class="w-40 h-40 rounded bg-gray-50 border mt-4">
                    <img :src="form?.image ? form.image : ''" class="w-full h-full object-contain" />
                </div>
            </div>
            <button class="my-4 can-edu-btn-fill" @click="addUpdate">
                Submit
            </button>
        </div>
        <!-- <div v-else class="md:mt-6 w-full md:w-8/12 md:ml-4">
            <div class="can-edu-p mt-2">
                <div class="">
                    This feature is available exclusively to our Sponsors, as well as to our Premium and Featured
                    schools
                </div>
            </div>
        </div> -->
        <!-- The original content that is replaced by the modal -->
        <div v-else class="md:mt-6 w-full md:w-8/12 md:ml-4">
            <div
                class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                <ul class="flex gap-2 flex-wrap my-4">
                    <li class="mr-2 mb-2" v-for="language in languages" :key="language.id">
                        <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                            'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                            (activeTab == null && language.is_default) ||
                                activeTab == language.id
                                ? 'text-white bg-primary active'
                                : '',
                            errors.has(
                                `description.description_${language.id}`
                            )
                                ? 'bg-red-600 text-white hover:text-white'
                                : '',
                        ]">{{ language.name }}</a>
                    </li>
                </ul>
            </div>
            <div class="" v-for="language in languages" :key="language.id" :class="(activeTab == null && language.is_default) ||
                activeTab == language.id
                ? 'block'
                : 'hidden'
                ">
                <div class="relative z-0 w-full mb-2 group mt-4">
                    <label class="block text-base lg:text-lg mb-2">Description / Title of the tour</label>
                    <textarea placeholder="Tell the students what this virtual tour is about; what they are going to see; e.g. “Our downtown campus”"
                        class="w-full focus:ring-primary focus:ring-1 focus:ring-.5 focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                            " @input="
                                handleMultipleInput(
                                    'description',
                                    $event.target.value,
                                    language
                                )
                                " :value="form['description'] &&
                                    form['description'][`description_${language.id}`]
                                    ? form['description'][
                                    `description_${language.id}`
                                    ]
                                    : ''
                                    "></textarea>
                    <error :fieldName="`description.description_${language.id}`" :validationErros="errors" />
                </div>
            </div>
            <div class="w-full mt-2 relative">
                <label class="block text-base lg:text-lg">Color</label>
                <input type="text"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'color')" :value="form?.color ? form.color : ''" />
                <error :fieldName="`color`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative">
                <label class="block text-base lg:text-lg">Virtual tour’s link</label>
                <input type="text" placeholder="Copy and paste the URL of the virtual tour web page"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'link')" :value="form?.link ? form.link : ''" />
                <error :fieldName="`link`" :validationErros="errors" />
            </div>

            <!-- <div class="w-full mt-2 relative">
                <label class="block text-base lg:text-lg">Deadline Date</label>
                <input type="date"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'date')" 
                    v-model="deadlineDate" />
                <error :fieldName="`date`" :validationErros="errors" />
            </div> -->

            <div class="w-full mt-2 relative">
                <label class="block text-base lg:text-lg">Image - This image appears on the search results page. It can be of your campus, facilities, buildings, special events, … etc.</label>
                <p class="text-base">
                    (Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)
                </p>
                <input type="file"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @change="handleImage($event)" />
                <error :fieldName="`image`" :validationErros="errors" />
                <error :fieldName="`file`" :validationErros="errors" />
                <div v-if="form['image']" class="w-40 h-40 rounded bg-gray-50 border mt-4">
                    <img :src="form?.image ? form.image : ''" class="w-full h-full object-contain" />
                </div>
            </div>
            <transition name="slide">
                <div id="defaultModal" tabindex="-1" aria-hidden="true"
                    class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
                    v-if="showModal">
                    <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                        ref="elementToDetectClick">
                        <!-- Modal content -->
                        <div class="">
                            <div class="absolute top-3 right-3 cursor-pointer" @click="toggleModal">
                                <button type="button" class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                    <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                                <p class="text-center can-edu-p mt-2">
                                    This feature is available exclusively to our Sponsors, Premium and Featured members
                                </p>
                                <div class="flex justify-center">
                                    <div
                                        class="text-red-700"
                                    >
                                        <a
                                            :href="`/${lang}/membership-package`"
                                            class=""
                                            >Already a member? Click here to upgrade your membership package</a
                                        >
                                    </div>
                                </div>
                                <div class="flex justify-center">
                                <button type="button" class="can-edu-btn-fill  whitespace-nowrap px-2.5 md:px-5 mt-4"
                                    @click="toggleModal">
                                    Close
                                </button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
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
                            {{
                                popupMsg
                            }} 
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
</template>

<script>
import Swal from 'sweetalert2';
import { mapState } from "vuex";
import Error from "../../Error.vue";
export default {
    components: {
        Error,
    },
    props: ["logged_in_customer", "logged_in_customer_package", "school_id", "lang", "slug","is_package_amount_paid_create"],
    computed: {
        ...mapState({
            form: (state) => state.virtual_tours.form,
            virtual_tours: (state) => state.virtual_tours.virtual_tours,
            pagination: (state) => state.virtual_tours.pagination,
            errors: (state) => state.virtual_tours.validationErros,
            searchParam: (state) => state.virtual_tours.searchParam,
            loading: (state) => state.virtual_tours.loading,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
             deadlineDate:"",
            showModal: false,
            activeTab: null,
              showPopUpModal: false,
            popupMsg: ''
        };
    },
    watch:{
        deadlineDate(newValue) {
      if (newValue) {
        let parts = newValue.split("-");
        if (parts[0].length > 4) {
          parts[0] = parts[0].slice(0, 4); 
        }
        this.deadlineDate = parts.join("-");
      }
    }
    },
    methods: {
        togglePopUpModal() {
            this.showPopUpModal = !this.showPopUpModal;
            if (!this.showPopUpModal) {
                window.location.href =
                "/" + this.lang + "/" + this.slug + "/our-profile/virtual-tour";            }
        },
        handleClickOutsidePopup(event) {
            // // Check if the click target is not within the element
            if (
                this.$refs.elementToDetectClick &&
                event.target.contains(this.$refs.elementToDetectClick)
            ) {
                // Clicked outside the element, you can perform actions here
                if (this.showPopUpModal == true) {
                    this.showPopUpModal = false;
                    window.location.href =
                    "/" + this.lang + "/" + this.slug + "/our-profile/virtual-tour";
                }
            }
        },
        handleClickOutside(event) {
            if (
                this.$refs.elementToDetectClick &&
                !this.$refs.elementToDetectClick.contains(event.target)
            ) {
                if (this.showModal) {
                    this.showModal = false;
                    window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/virtual-tour";
                }
            }
        },
        toggleModal() {
            this.showModal = !this.showModal; // Toggle the modal state

            // Check if modal was just closed (showModal is now false)
            if (!this.showModal) {
                // Perform the redirect when modal is closed
                window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/virtual-tour";
            }
        },
        // checkFeatureAccess() {
        //     if (!this.logged_in_customer || this.logged_in_customer_package == 1) {
        //         this.showAccessAlert();
        //     }
        // },
        // showAccessAlert() {
        //     Swal.fire({
        //         title: 'Feature Unavailable',
        //         text: 'This feature is available exclusively to our Sponsors, as well as to our Premium and Featured schools.',
        //         icon: 'info',
        //         confirmButtonText: 'OK',
        //         confirmButtonColor: '#3085d6',
        //         background: '#f8f9fa',
        //         customClass: {
        //             title: 'text-lg font-bold',
        //             content: 'text-base',
        //         }
        //     });
        // },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        handleInput(e, key) {
            this.$store.commit("virtual_tours/setState", {
                key,
                value: e.target.value,
            });
            if (key === "color" && e.target.value !== "") {
                this.errors.clear("color");
            }

            if (key === "link" && e.target.value !== "") {
                this.errors.clear("link");
            }

            if (key === "date" && e.target.value !== "") {
                this.errors.clear("date");
            }
        },
        handleMultipleInput(key, value, language) {
            this.$store.commit("virtual_tours/updateState", {
                value: value,
                id: language.id,
                key,
            });
            if (key === "description" && value !== "") {
                this.errors.clear(`description.description_${language.id}`);
            }
        },
        addUpdate() {
            this.$store.dispatch("virtual_tours/addUpdateForm").then((res) => {
                this.showPopUpModal = true;
                this.popupMsg = res.data.message;           
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
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.errors.clear("image");
                this.$store.commit("virtual_tours/setState", {
                    key: "image",
                    value: res?.data,
                });
            })
                .catch((error) => {
                    this.$store.commit(
                        "virtual_tours/setValidationErros",
                        error.response.data.errors
                    );
                });
        },
    },
    created() {
        console.log('ooooo', this.logged_in_customer_package);
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_WEB_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["description_" + res.id] = "";
                });
                this.$store.commit("virtual_tours/setState", {
                    key: "description",
                    value: obj,
                });
            });
        this.$store.commit("virtual_tours/setState", {
            key: "customer_id",
            value: this.logged_in_customer,
        });
        this.$store.commit("virtual_tours/setState", {
            key: "school_id",
            value: this.school_id,
        });
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutsidePopup);
        document.removeEventListener("click", this.handleClickOutside);
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutsidePopup);
        document.addEventListener("click", this.handleClickOutside);
        // this.checkFeatureAccess();
        console.log("Logged in customer:", this.logged_in_customer);
        console.log("Logged in customer package:", this.logged_in_customer_package);
        console.log("School ID:", this.school_id);
        console.log("Language:", this.lang);
        this.toggleModal();
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