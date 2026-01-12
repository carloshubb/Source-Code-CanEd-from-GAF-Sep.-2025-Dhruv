<template>
    <div
        class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full"
    >
        <div class="mt-4 flex justify-between items-center gap-2 p-2">
            <p class="px-4 can-edu-h1">Edit webinar</p>
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
                    <option :selected="form?.timezone == 'America/Toronto'" value="America/Toronto">America/Toronto</option>
                    <option :selected="form?.timezone == 'America/Winnipeg'" value="America/Winnipeg">America/Winnipeg</option>
                    <option :selected="form?.timezone == 'America/Regina'" value="America/Regina">America/Regina</option>
                    <option :selected="form?.timezone == 'America/Swift_Current'" value="America/Swift_Current">
                        America/Swift_Current
                    </option>
                    <option :selected="form?.timezone == 'America/Edmonton'" value="America/Edmonton">America/Edmonton</option>
                    <option :selected="form?.timezone == 'America/Yellowknife'" value="America/Yellowknife">
                        America/Yellowknife
                    </option>
                    <option :selected="form?.timezone == 'America/Inuvik'" value="America/Inuvik">America/Inuvik</option>
                    <option :selected="form?.timezone == 'America/Vancouver'" value="America/Vancouver">America/Vancouver</option>
                    <option :selected="form?.timezone == 'America/Dawson'" value="America/Dawson">America/Dawson</option>
                    <option :selected="form?.timezone == 'America/Halifax'" value="America/Halifax">America/Halifax</option>
                    <option :selected="form?.timezone == 'America/Glace_Bay'" value="America/Glace_Bay">America/Glace_Bay</option>
                    <option :selected="form?.timezone == 'America/Moncton'" value="America/Moncton">America/Moncton</option>
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
                    <option :selected="form?.everyone_can_speak == 1" value="1">Yes</option>
                    <option :selected="form?.everyone_can_speak == 0" value="0">No</option>
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
                    <option :selected="form?.detailed_registration_page_enabled == 1" value="1">Yes</option>
                    <option :selected="form?.detailed_registration_page_enabled == 0" value="0">No</option>
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
                    <option :selected="form?.light_registration_page_enabled == 1" value="1">Yes</option>
                    <option :selected="form?.light_registration_page_enabled == 0" value="0">No</option>
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
                    <option :selected="form?.recording_enabled == 1" value="1">Yes</option>
                    <option :selected="form?.recording_enabled == 0" value="0">No</option>
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
                    <option :selected="form?.chat_enabled == 1" value="1">Yes</option>
                    <option :selected="form?.chat_enabled == 0" value="0">No</option>
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
                    <option :selected="form?.questions_enabled == 1" value="1">Yes</option>
                    <option :selected="form?.questions_enabled == 0" value="0">No</option>
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
                    <option :selected="form?.polls_enabled == 1" value="1">Yes</option>
                    <option :selected="form?.polls_enabled == 0" value="0">No</option>
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
                <img :src="form?.image ? form.image : ''" />
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
</template>

<script>
import { mapState } from "vuex";
import Error from "../../Error.vue";
export default {
    components: {
        Error,
    },
    props: [
        "webinar_id",
        "ambassador_id",
        "school_id",
        "refresh_token",
        "zoho_auth_url",
        "lang",
    ],
    computed: {
        ...mapState({
            form: (state) => state.webinars.form,
            webinars: (state) => state.webinars.webinars,
            pagination: (state) => state.webinars.pagination,
            errors: (state) => state.webinars.validationErros,
            searchParam: (state) => state.webinars.searchParam,
            loading: (state) => state.webinars.loading,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            activeTab: "en",
            local_refresh_token: "",
        };
    },
    methods: {
        handleInput(e, key, language) {
            this.$store.commit("webinars/setWebinar", {
                key,
                value: e.target.value,
            });
        },
        addUpdate() {
            this.form.description = this.cleanDescription(this.form.description);
            var inputDateTime = new Date(this.form["start_date"]);
            var currentDateTime = new Date();

            if (inputDateTime <= currentDateTime) {
                helper.swalErrorMessage(
                    "Selected date should be greater then today"
                );
                return;
            }
            this.$store.dispatch("webinars/addUpdateForm").then((res) => {
                window.location.href = "/" + this.lang + "/ambassador/webinars";
            });
        },
        cleanDescription(description) {
    // Strip out any HTML tags (you can refine this regex to allow specific tags)
    return description.replace(/<\/?[^>]+(>|$)/g, "").trim();
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
    created() {
        this.$store.commit("webinars/setWebinar", {
            key: "id",
            value: this.webinar_id,
        });
        this.$store.commit("webinars/setIsFormEdit", 1);
        this.$store.dispatch("webinars/fetchWebinar", {
            id: this.webinar_id,
        });
    },
};
</script>
