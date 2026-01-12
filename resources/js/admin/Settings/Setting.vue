<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-edu-h1 text-primary">Settings</h3>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8"  @submit.prevent="updateSetting()">
                <div class="grid md:grid-cols-2 gap-4 md:gap-6 my-6">
                        <div
                            class="relative z-0 w-full group"
                            v-for="(setting, key) in settings"
                        >
                            <template v-if="setting?.key == 'home_page_banner'">
                                <!-- v-model="setting?.value" -->
                                <label for="name" class="block text-base lg:text-lg">
                                    {{
                                        capitalizeWords(
                                            setting.key.replace(/_/g, " ")
                                        )
                                    }}
                                </label>
                                <input
                                    type="file"
                                    name="name"
                                    id="name"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                    @change="handleImage($event,setting)"
                                />
                                <img :src="setting?.value" style="height:100px;width:100px" />
                            </template>
                            <template v-if="setting?.key == 'network_banner'">
                                <!-- v-model="setting?.value" -->
                                <label for="name" class="block text-base lg:text-lg"
                                    >{{
                                        capitalizeWords(
                                            setting.key.replace(/_/g, " ")
                                        )
                                    }}</label
                                >
                                <input
                                    type="file"
                                    name="name"
                                    id="name"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                    @change="handleImage($event,setting)"
                                />
                                <img :src="setting?.value" style="height:100px;width:100px" />
                            </template>
                            <template v-if="setting?.key == 'main_logo'">
                                <!-- v-model="setting?.value" -->
                                <label for="name" class="block text-base lg:text-lg"
                                    >{{
                                        capitalizeWords(
                                            setting.key.replace(/_/g, " ")
                                        )
                                    }}</label
                                >
                                <input
                                    type="file"
                                    name="name"
                                    id="name"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                    @change="handleImage($event,setting)"
                                />
                                <img :src="setting?.value" style="height:100px;width:100px" />
                            </template>
                            <template v-if="setting?.key == 'static_logo'">
                                <label
                                    for="name"
                                    class="block text-base lg:text-lg"
                                    >{{
                                        capitalizeWords(
                                            setting.key.replace(/_/g, " ")
                                        )
                                    }}</label
                                >
                                <input
                                    type="file"
                                    name="name"
                                    id="name"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                    @change="handleImage($event,setting)"
                                />
                                <!-- v-model="setting?.value" -->
                                <img :src="setting?.value" style="height:100px;width:100px" />
                            </template>
                            <template v-if="setting?.key == 'school_default_tab'">
                                <label
                                    for="name"
                                    class="block text-base lg:text-lg"
                                    >{{
                                        capitalizeWords(
                                            setting.key.replace(/_/g, " ")
                                        )
                                    }}</label
                                >
                                <select
                                    type="file"
                                    name="name"
                                    id="name"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                    v-model="setting.value"
                                >
                                <option value="">Select</option>
                                <option value="1">Quick facts</option>
                                <option value="2">Overview</option>
                                <option value="3">Programs</option>
                                <option value="4">Admissions</option>
                                <option value="5">Financials</option>
                                <option value="6">Scholarships</option>
                                <option value="7">Contacts</option>
                                <option value="8">Ambassadors</option>
                            </select>
                                <!-- v-model="setting?.value" -->
                            </template>
                            <template v-else>
                                <label
                                    for="name"
                                    class="block text-base lg:text-lg"
                                    >{{
                                        capitalizeWords(
                                            setting.key.replace(/_/g, " ")
                                        )
                                    }}</label
                                >
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                    v-model="setting.value"
                                />
                            </template>
                        </div>
                        <div
                            class="relative z-0 w-full group"
                            v-for="reg_package in reg_packages"
                            :key="reg_package.id"
                        >
                            <label
                                :for="`package_${reg_package.id}`"
                                class="block text-base lg:text-lg"
                                >{{
                                    reg_package.registration_package_detail &&
                                    reg_package.registration_package_detail[0]
                                        ? reg_package
                                              .registration_package_detail[0]
                                              .name
                                        : ""
                                }}
                                form submission per day</label
                            >
                            <input
                                type="text"
                                :id="`package_${reg_package.id}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                placeholder=" "
                                @input="
                                    handlePackageSettingInput(
                                        $event.target.value,
                                        reg_package
                                    )
                                "
                                :value="reg_package?.form_submission_count"
                            />
                            <!-- <p
                                class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has(
                                        `form_submission_for_package.form_submission_for_package_${reg_package.id}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `form_submission_for_package.form_submission_for_package_${reg_package.id}`
                                    )
                                "
                            ></p> -->
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 mb-2">
                    <!-- <button
                        :disabled="loader"
                        :class="
                            loader
                                ? 'bg-gray-300 text-lg font-FuturaMdCnBT rounded p-2 px-5 text-white whitespace-nowrap'
                                : 'can-edu-btn-fill'
                        "
                        @click="synchWebinars()"
                    >
                        <svg
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            v-if="loader"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            ></path>
                        </svg>
                        Synch Webinars with zoho
                    </button> -->
                    <button type="submit" class="ml-2 can-edu-btn-fill">
                        <svg
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            v-if="loading"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            ></path>
                        </svg>
                        Save
                    </button>
                    </div>
            </form>
        </div>
    </AppLayout>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({}),
    },
    data() {
        return {
            settings: [],
            reg_packages: [],
            form_submission_for_package: {},
            loading: 0,
            loader: false,
        };
    },
    created() {
        this.loading = 1;

        this.$store
            .dispatch("registration_packages/fetchRegistrationPackages")
            .then((res) => {
                let data = res.data.data;
                this.reg_packages = data;
                let obj = {};
                data.map((res) => {
                    obj["form_submission_for_package_" + res.id] = res?.form_submission_count;
                });
                this.form_submission_for_package = obj;
                axios
                    .get(`${process.env.MIX_ADMIN_API_URL}settings`)
                    .then((res) => {
                        this.settings = res.data.data;
                        this.loading = 0;
                    })
                    .catch((error) => {});
            });
    },
    methods: {
        handleImage(e,setting) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios
                .post("/api/admin/media/image_again_upload", file)
                .then((res) => {
                    setting.value = res?.data;
                });
        },
        handlePackageSettingInput(value, registration_package) {
            this.form_submission_for_package[
                `form_submission_for_package_${registration_package.id}`
            ] = value;
        },
        synchWebinars() {
            this.loader = true;
            let url = `${process.env.MIX_ADMIN_API_URL}synch-all-webinars`;
            axios.get(url).then((res) => {
                if (res.data.status == "Success") {
                    helper.swalSuccessMessage(res.data.message);
                    this.loader = false;
                } else if (res.data.status == "Error") {
                    this.loader = false;
                    helper.swalErrorMessage(res.data.message);
                }
            });
        },
        capitalizeWords(string) {
            return string.replace(/(?:^|\s)\S/g, function (a) {
                return a.toUpperCase();
            });
        },
        updateSetting() {
            let data = {};
            data["setting"] = this.settings;
            data["form_submission_for_package"] =
                this.form_submission_for_package;
            axios
                .post(`${process.env.MIX_ADMIN_API_URL}settings`, data)
                .then((res) => {
                    helper.swalSuccessMessage(res.data.message);
                })
                .catch((error) => {});
        },
    },
};
</script>
