<template>
    <div
        class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full"
    >
        <div class="mt-4 flex justify-between gap-2 p-2">
            <h1 class="px-4 pt-4 can-school-h1">Update a webinar</h1>
        </div>
        <div class="mt-6 w-full md:w-8/12 ml-4">
            <div
                class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
            >
                <ul class="flex gap-2 flex-wrap my-4">
                    <li
                        class="mr-2 mb-2"
                        v-for="language in languages"
                        :key="language.code"
                    >
                        <a
                            @click.prevent="changeLanguageTab(language)"
                            href="#"
                            :class="[
                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                activeTab != null &&
                                activeTab == language.language_code
                                    ? 'text-white bg-primary active'
                                    : '',
                                errors.has(`agenda.agenda_${language.code}`)
                                    ? 'bg-red-600 text-white hover:text-white'
                                    : '',
                            ]"
                            >{{ language.language_code }}</a
                        >
                    </li>
                </ul>
            </div>
            <div
                class="w-full mt-2 relative"
                v-for="language in languages"
                :key="language.language_code"
                :class="
                    activeTab == language.language_code ? 'block' : 'hidden'
                "
            >
                <input
                    type="text"
                    placeholder="Agenda *"
                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInputDetail($event, 'agenda', language)"
                    :value="
                        form['agenda'] &&
                        form['agenda'][`agenda_${language.language_code}`]
                            ? form['agenda'][`agenda_${language.language_code}`]
                            : ''
                    "
                />
                <div class="z-10 bottom-12 left-1/4 absolute">
                    <p
                        class="tooltiptext line-clamp-2 w-64 px-3 py-1 bg-primary text-white text-center rounded transition-all delay-300 after:absolute after:top-full after:left-1/2 after:-ml-1 after:border-[6px]"
                        v-if="
                            errors.has(
                                `agenda.agenda_${language.language_code}`
                            )
                        "
                        v-text="
                            errors.get(
                                `agenda.agenda_${language.language_code}`
                            )
                        "
                    ></p>
                </div>
            </div>
            <div
                class="w-full mt-2 relative"
                v-for="language in languages"
                :key="language.language_code"
                :class="
                    activeTab == language.language_code ? 'block' : 'hidden'
                "
            >
                <textarea
                    name=""
                    id=""
                    cols="5"
                    rows="5"
                    placeholder="Topic *"
                    class="border border-l-[5px] w-full border-l-primary border-gray-300 rounded mt-4 p-3 focus:outline-none focus:ring-none"
                    @input="handleInputDetail($event, 'topic', language)"
                    >{{
                        form["topic"] &&
                        form["topic"][`topic_${language.language_code}`]
                            ? form["topic"][`topic_${language.language_code}`]
                            : ""
                    }}</textarea
                >
                <div class="z-10 -top-12 left-1/4 absolute">
                    <p
                        class="tooltiptext line-clamp-2 w-64 px-3 py-1 bg-primary text-white text-center rounded transition-all delay-300 after:absolute after:top-full after:left-1/2 after:-ml-1 after:border-[6px]"
                        v-if="
                            errors.has(`topic.topic_${language.language_code}`)
                        "
                        v-text="
                            errors.get(`topic.topic_${language.language_code}`)
                        "
                    ></p>
                </div>
            </div>
            <div class="relative">
                <select
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'duration')"
                >
                    <option value="">Select</option>
                    <option :selected="form?.duration == '15'" value="15">
                        15 minutes
                    </option>
                    <option :selected="form?.duration == '30'" value="30">
                        30 minutes
                    </option>
                    <option :selected="form?.duration == '60'" value="60">
                        60 minutes
                    </option>
                </select>
                <div class="z-10 bottom-12 left-1/4 absolute">
                    <p
                        class="tooltiptext line-clamp-2 w-64 px-3 py-1 bg-primary text-white text-center rounded transition-all delay-300 after:absolute after:top-full after:left-1/2 after:-ml-1 after:border-[6px]"
                        v-if="errors.has('duration')"
                        v-text="errors.get('duration')"
                    ></p>
                </div>
            </div>

            <!-- <div class="relative">
                <input
                    type="text"
                    placeholder="Timezon *"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'timezone')"
                    :value="form?.timezone ? form.timezone : ''"
                />
                <div class="z-10 bottom-12 left-1/4 absolute">
                    <p
                        class="tooltiptext line-clamp-2 w-64 px-3 py-1 bg-primary text-white text-center rounded transition-all delay-300 after:absolute after:top-full after:left-1/2 after:-ml-1 after:border-[6px]"
                        v-if="errors.has('timezone')"
                        v-text="errors.get('timezone')"
                    ></p>
                </div>
            </div> -->
            <div class="relative">
                <lable>Start date time</lable>
                <input
                    type="datetime-local"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'start_date')"
                    :value="form?.start_date ? form.start_date : ''"
                />
                <div class="z-10 bottom-12 left-1/4 absolute">
                    <p
                        class="tooltiptext line-clamp-2 w-64 px-3 py-1 bg-primary text-white text-center rounded transition-all delay-300 after:absolute after:top-full after:left-1/2 after:-ml-1 after:border-[6px]"
                        v-if="errors.has('start_date')"
                        v-text="errors.get('start_date')"
                    ></p>
                </div>
            </div>
            <div class="relative">
                <lable>Type</lable>
                <select
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'type')"
                >
                    <option value="">Select</option>
                    <option :selected="form?.type == 'offline'" value="offline">
                        Offline
                    </option>
                    <option :selected="form?.type == 'online'" value="online">
                        Online
                    </option>
                </select>
                <div class="z-10 bottom-12 left-1/4 absolute">
                    <p
                        class="tooltiptext line-clamp-2 w-64 px-3 py-1 bg-primary text-white text-center rounded transition-all delay-300 after:absolute after:top-full after:left-1/2 after:-ml-1 after:border-[6px]"
                        v-if="errors.has('type')"
                        v-text="errors.get('type')"
                    ></p>
                </div>
            </div>

            <div class="relative" v-if="form?.type == 'offline'">
                <input
                    type="text"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    placeholder="Youtube Video id *"
                    @input="handleInput($event, 'webinar_link')"
                    :value="form?.webinar_link ? form.webinar_link : ''"
                />
                <div class="z-10 bottom-12 left-1/4 absolute">
                    <p
                        class="tooltiptext line-clamp-2 w-64 px-3 py-1 bg-primary text-white text-center rounded transition-all delay-300 after:absolute after:top-full after:left-1/2 after:-ml-1 after:border-[6px]"
                        v-if="errors.has('webinar_link')"
                        v-text="errors.get('webinar_link')"
                    ></p>
                </div>
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
                <div class="z-10 top-4 left-1/4 absolute">
                    <p
                        class="tooltiptext line-clamp-2 w-64 px-3 py-1 bg-primary text-white text-center rounded transition-all delay-300 after:absolute after:top-full after:left-1/2 after:-ml-1 after:border-[6px]"
                        v-if="errors.has('image')"
                        v-text="errors.get('image')"
                    ></p>
                </div>
                <img :src="form?.image ? form.image : ''" />
            </div>
            <!-- <div class="relative" v-if="form?.type == 'online'">
                <label>Particepents (please add comma , seprated emails)</label>
                <input
                    type="text"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    placeholder="particepents *"
                    @input="handleInput($event, 'particepents')"
                    :value="form?.particepents ? form.particepents : ''"
                />
                <div class="z-10 bottom-12 left-1/4 absolute">
                    <p
                        class="tooltiptext line-clamp-2 w-64 px-3 py-1 bg-primary text-white text-center rounded transition-all delay-300 after:absolute after:top-full after:left-1/2 after:-ml-1 after:border-[6px]"
                        v-if="errors.has('particepents')"
                        v-text="errors.get('particepents')"
                    ></p>
                </div>
            </div> -->
            <button
                class="mt-4 can-edu-btn-fill"
                @click="addUpdate"
                v-if="
                    form?.type == 'offline' ||
                    (form?.type == 'online' && local_refresh_token != '')
                "
                :disabled="loading"
                :class="loading ? 'bg-opacity-20' : ''"
            >
                Update
            </button>

            <button
                class="mt-4 can-edu-btn-fill"
                @click="openZohoOAuthPopup"
                v-if="form?.type == 'online' && local_refresh_token == ''"
                :disabled="loading"
                :class="loading ? 'bg-opacity-20' : ''"
            >
                Update
            </button>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    props: [
        "logged_in_customer",
        "school_id",
        "refresh_token",
        "zoho_auth_url",
        "webinar_id",
    ],
    computed: {
        ...mapState({
            form: (state) => state.webinars.form,
            webinars: (state) => state.webinars.webinars,
            pagination: (state) => state.webinars.pagination,
            errors: (state) => state.webinars.validationErros,
            searchParam: (state) => state.webinars.searchParam,
            loading: (state) => state.webinars.loading,
            languages: (state) => state.webinars.form.languages,
        }),
    },
    data() {
        return {
            activeTab: "en",
            local_refresh_token: "",
        };
    },
    methods: {
        openZohoOAuthPopup() {
            // Define the URL of Zoho's authorization page

            let zohoAuthUrl = this.zoho_auth_url.replace(/&amp;/g, "&");
            // Open a new popup window
            var popup = window.open(
                zohoAuthUrl.trim(),
                "ZohoOAuthPopup",
                "width=600,height=400"
            );
            var ctx = this;
            window.addEventListener("message", function (event) {
                // // Check the origin of the message for security (you should adjust this to your specific use case)
                // if (event.origin !== "http://localhost") {
                //     return;
                // }
                // helper.swalSuccessMessage('You have been athorized with zoho now you can create webinar.');
                ctx.local_refresh_token = "some token";
                ctx.addUpdate();
            });
        },
        changeLanguageTab(language) {
            this.activeTab = language.language_code;
        },

        handleInputDetail(e, key, language) {
            this.$store.commit("webinars/setForData", {
                key,
                language,
                value: e.target.value,
            });
        },
        handleInput(e, key) {
            this.$store.commit("webinars/setWebinar", {
                key,
                value: e.target.value,
            });
        },
        addUpdate() {
            this.$store.dispatch("webinars/addUpdateForm").then((res) => {
                window.location.href = "/our-profile/webinar";
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
    created() {
        this.$store.commit("webinars/setWebinar", {
            key: "customer_id",
            value: this.logged_in_customer,
        });
        this.$store.commit("webinars/setWebinar", {
            key: "id",
            value: this.webinar_id,
        });
        this.$store.commit("webinars/setWebinar", {
            key: "school_id",
            value: this.school_id,
        });
        this.local_refresh_token = this.refresh_token;
        this.$store.commit("webinars/setIsFormEdit", 1);
    },
    mounted() {
        axios
            .get(
                "/api/web/customer-languages?customer_id=" +
                    this.logged_in_customer
            )
            .then((res) => {
                if (res.data.status == "Success") {
                    this.$store.commit("webinars/setLanguages", res.data.data);

                    res.data.data?.filter((lang) => {
                        this.$store.commit("webinars/setForData", {
                            key: "agenda",
                            language: lang,
                            value: "",
                        });
                        this.$store.commit("webinars/setForData", {
                            key: "topic",
                            language: lang,
                            value: "",
                        });
                    });
                    this.$store.dispatch("webinars/fetchWebinar", {
                        id: this.webinar_id,
                    });
                }
            });
    },
};
</script>
