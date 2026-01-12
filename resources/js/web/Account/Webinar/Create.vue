<template>
    <div
        class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full"
    >
        <div class="mt-4 flex justify-between items-center gap-2 p-2">
            <h1 class="px-4 can-school-h1">Create webinar</h1>
        </div>
        <div class="mt-6 w-full md:w-8/12 ml-4">
            <div class="relative">
                <label class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Title</label
                >
                <input
                    type="text"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    placeholder="Please enter title"
                    @input="handleInput($event, 'title')"
                    :value="form?.title ? form.title : ''"
                />
                <error :fieldName="`title`" :validationErros="errors" />
            </div>
            <div class="relative">
                <label class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Description</label
                >
                <textarea
                    type="text"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    cols="10"
                    rows="10"
                    @input="handleInput($event, 'description')"
                    :value="form?.description ? form.description : ''"
                ></textarea>
                <error :fieldName="`description`" :validationErros="errors" />
            </div>
            <div class="relative">
                <label class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Start date time</label
                >
                <input
                    type="datetime-local"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'start_date')"
                    :value="form?.start_date ? form.start_date : ''"
                />
                <error :fieldName="`start_date`" :validationErros="errors" />
            </div>
            <div class="relative">
                <label class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Time Zone</label
                >
                <select
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'timezone')"
                >
                    <option value="">Select</option>
                    <option value="America/Toronto">America/Toronto</option>
                    <option value="America/Winnipeg">America/Winnipeg</option>
                    <option value="America/Regina">America/Regina</option>
                    <option value="America/Swift_Current">
                        America/Swift_Current
                    </option>
                    <option value="America/Edmonton">America/Edmonton</option>
                    <option value="America/Yellowknife">
                        America/Yellowknife
                    </option>
                    <option value="America/Inuvik">America/Inuvik</option>
                    <option value="America/Vancouver">America/Vancouver</option>
                    <option value="America/Dawson">America/Dawson</option>
                    <option value="America/Halifax">America/Halifax</option>
                    <option value="America/Glace_Bay">America/Glace_Bay</option>
                    <option value="America/Moncton">America/Moncton</option>
                </select>
                <error :fieldName="`timezone`" :validationErros="errors" />
            </div>
            <div class="relative">
                <label class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Everyone Can Speak</label
                >
                <select
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'everyone_can_speak')"
                >
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <error
                    :fieldName="`everyone_can_speak`"
                    :validationErros="errors"
                />
            </div>

            <div class="relative">
                <label class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Detailed Registration Page Enabled</label
                >
                <select
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="
                        handleInput(
                            $event,
                            'detailed_registration_page_enabled'
                        )
                    "
                >
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <error
                    :fieldName="`detailed_registration_page_enabled`"
                    :validationErros="errors"
                />
            </div>

            <div class="relative">
                <label class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Light Registration Page Enabled</label
                >
                <select
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="
                        handleInput($event, 'light_registration_page_enabled')
                    "
                >
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <error
                    :fieldName="`light_registration_page_enabled`"
                    :validationErros="errors"
                />
            </div>

            <div class="relative">
                <label class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Recording Enabled</label
                >
                <select
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'recording_enabled')"
                >
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <error
                    :fieldName="`recording_enabled`"
                    :validationErros="errors"
                />
            </div>

            <div class="relative">
                <label class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Chat Enabled</label
                >
                <select
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'chat_enabled')"
                >
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <error :fieldName="`chat_enabled`" :validationErros="errors" />
            </div>

            <div class="relative">
                <label class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Questions Enabled</label
                >
                <select
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'questions_enabled')"
                >
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <error
                    :fieldName="`questions_enabled`"
                    :validationErros="errors"
                />
            </div>

            <div class="relative">
                <label class="text-gray-700 font-semibold text-sm lg:text-base"
                    >Polls Enabled</label
                >
                <select
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'polls_enabled')"
                >
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <error :fieldName="`polls_enabled`" :validationErros="errors" />
            </div>

            <div class="relative">
                <p>
                    Image * (Files must be less than 5MB, allowed file types:
                    png, gif, jpg, jpeg)
                </p>
                <input
                    type="file"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @change="handleImage($event)"
                />
                <error :fieldName="`image`" :validationErros="errors" />
                <img v-if="form['image']" :src="form?.image ? form.image : ''" style="height: 100px; width: 100px"/>
            </div>

            <button
                class="mt-4 mb-2 can-edu-btn-fill"
                :class="loading ? 'bg-opacity-20' : ''"
                @click="addUpdate"
                :disabled="loading"
            >
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
                        <button type="button"
                            class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="defaultModal">
                            <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                        <p class="text-center can-edu-p mt-2">
                            {{
                                popupMsg
                            }} </p>
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
import { mapState } from "vuex";
import Error from "../../Error.vue";
export default {
    components: {
        Error,
    },
    computed: {
        ...mapState({
            form: (state) => state.webinars.form,
            errors: (state) => state.webinars.validationErros,
            loading: (state) => state.webinars.loading,
        }),
    },
    data() {
        return {
            activeTab: "en",
            popupMsg: '',
            redirection:true,
            activeTab: "en",
        };
    },
    methods: {
        togglePopUpModal() {
            this.showPopUpModal = !this.showPopUpModal;
            if (!this.showPopUpModal && this.redirection) {
                window.location.href =
                    "/" + this.lang + "/" + this.slug + "/our-profile/school-ambassador";
            }
        },
        handleClickOutsidePopup(event) {
            // // Check if the click target is not within the element
            if (
                this.$refs.elementToDetectClick &&
                event.target.contains(this.$refs.elementToDetectClick)
            ) {
                // Clicked outside the element, you can perform actions here
                if (this.showPopUpModal == true && this.redirection) {
                    this.showPopUpModal = false;
                    window.location.href =
                        "/" + this.lang + "/" + this.slug + "/our-profile/school-ambassador";
                }
            }
        },
        handleInput(e, key, language) {
            this.$store.commit("webinars/setWebinar", {
                key,
                value: e.target.value,
            });
        },
        addUpdate() {
            var inputDateTime = new Date(this.form["start_date"]);
            var currentDateTime = new Date();

            if (inputDateTime <= currentDateTime) {
                helper.swalErrorMessage(
                    "Selected date should be greater then today"
                );
                return;
            }
            this.$store.dispatch("webinars/addUpdateForm").then((res) => {
                
                if (res.data.status === "Error") {
                    this.showPopUpModal = true;
                    this.redirection = false;
                    this.popupMsg = res.data.message;
                    return;
                }
                // window.location.href = "/" + this.lang + "/ambassador/webinars";
            });
        },
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.$store.commit("webinars/setWebinar", {
                    key: "image",
                    value: res?.data,
                });
            });
        },
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutsidePopup);
    },
    mounted() {
//         console.log('this.logged_in_customer_whole_data',this.logged_in_customer);
//         console.log('User type:', this.user_type);
//   console.log('Logged in customer whole data:', this.logged_in_customer_whole_data);

    document.addEventListener("click", this.handleClickOutsidePopup);
    }
};
</script>
