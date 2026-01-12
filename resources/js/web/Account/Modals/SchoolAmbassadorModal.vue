<template>
    <div
        v-if="showModal"
        id="modal"
        class="fixed z-50 inset-0 overflow-y-auto p-4"
    >
        <div class="flex items-center justify-center min-h-screen">
            <div
                class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"
            ></div>
            <div
                class="modal-container bg-white w-full md:w-3/5 mx-auto rounded shadow-lg overflow-y-auto"
            >
                <div class="modal-content py-6 text-left px-6">
                    <div class="flex justify-between items-center pb-3">
                        <div class="can-school-h2 mb-0">Add Ambassador</div>
                        <div
                            class="modal-close cursor-pointer z-50 border border-primary p-1.5 rounded-full"
                            @click="closeModal"
                        >
                            <svg
                                class="fill-current text-primary"
                                xmlns="http://www.w3.org/2000/svg"
                                width="12"
                                height="12"
                                viewBox="0 0 18 18"
                            >
                                <path
                                    d="M18 1.1L16.9 0 9 7.9 1.1 0 0 1.1 7.9 9 0 16.9 1.1 18 9 10.1l7.9 7.9 1.1-1.1-7.9-7.9z"
                                />
                            </svg>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div
                            class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
                        >
                            <ul class="flex gap-2 flex-wrap my-4">
                                <li
                                    class="mr-2"
                                    v-for="language in languages"
                                    :key="language.code"
                                >
                                    <a
                                        @click.prevent="
                                            changeLanguageTab(language)
                                        "
                                        href="#"
                                        :class="[
                                            'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                            activeTab != null &&
                                            activeTab == language.language_code
                                                ? 'text-white bg-primary active'
                                                : '',
                                            validationErros.has(
                                                `name.name_${language.code}`
                                            )
                                                ? 'bg-red-600 text-white hover:text-white'
                                                : '',
                                        ]"
                                        >{{ language.language_code }}</a
                                    >
                                </li>
                            </ul>
                        </div>
                        <div
                            class="w-full mt-2"
                            v-for="language in languages"
                            :key="language.language_code"
                            :class="
                                activeTab == language.language_code
                                    ? 'block'
                                    : 'hidden'
                            "
                        >
                            <input
                                type="text"
                                placeholder="Name *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'name', language)"
                                :value="
                                    form['name'] &&
                                    form['name'][
                                        `name_${language.language_code}`
                                    ]
                                        ? form['name'][
                                              `name_${language.language_code}`
                                          ]
                                        : ''
                                "
                            />
                            <error :fieldName="`name.name_${language.language_code}`" :validationErros="validationErros" />
                            
                        </div>
                        <div
                            class="w-full mt-2"
                            v-for="language in languages"
                            :key="language.language_code"
                            :class="
                                activeTab == language.language_code
                                    ? 'block'
                                    : 'hidden'
                            "
                        >
                            <textarea
                                name=""
                                id=""
                                cols="5"
                                rows="5"
                                placeholder="About me *"
                                class="border border-l-[5px] w-full border-l-primary border-gray-300 rounded mt-4 p-3 focus:outline-none focus:ring-none"
                                @input="
                                    handleInput($event, 'about_me', language)
                                "
                                >{{
                                    form["about_me"] &&
                                    form["about_me"][
                                        `about_me_${language.language_code}`
                                    ]
                                        ? form["about_me"][
                                              `about_me_${language.language_code}`
                                          ]
                                        : ""
                                }}</textarea
                            >
                            <error :fieldName="`about_me.about_me_${language.language_code}`" :validationErros="validationErros" />
                            
                        </div>

                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="Region *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'region', '')"
                                :value="form['region'] ? form['region'] : ''"
                            />
                            <error :fieldName="'region'" :validationErros="validationErros" />
                        </div>

                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="I'm currently in *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'currently_in', '')"
                                :value="
                                    form['currently_in']
                                        ? form['currently_in']
                                        : ''
                                "
                            />
                            <error :fieldName="'currently_in'" :validationErros="validationErros" />
                        </div>

                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="Favorite module *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'fav_module', '')"
                                :value="
                                    form['fav_module'] ? form['fav_module'] : ''
                                "
                            />
                            <error :fieldName="'fav_module'" :validationErros="validationErros" />
                        </div>

                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="Hobies and interests in *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="
                                    handleInput($event, 'hobies_interests', '')
                                "
                                :value="
                                    form['hobies_interests']
                                        ? form['hobies_interests']
                                        : ''
                                "
                            />
                            <error :fieldName="'hobies_interests'" :validationErros="validationErros" />
                        </div>

                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="Scocieties *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'societies', '')"
                                :value="
                                    form['societies'] ? form['societies'] : ''
                                "
                            />
                            <error :fieldName="'societies'" :validationErros="validationErros" />
                        </div>

                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="Languages *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'langs', '')"
                                :value="form['langs'] ? form['langs'] : ''"
                            />
                            <error :fieldName="'langs'" :validationErros="validationErros" />
                        </div>
                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="Whats app number *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'whats_app_number', '')"
                                :value="
                                    form['whats_app_number'] ? form['whats_app_number'] : ''
                                "
                            />
                            <error :fieldName="'whats_app_number'" :validationErros="validationErros" />
                        </div>
                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="Skype *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'skype_id', '')"
                                :value="
                                    form['skype_id'] ? form['skype_id'] : ''
                                "
                            />
                            <error :fieldName="'skype_id'" :validationErros="validationErros" />
                        </div>
                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="We chat *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'we_chat_number', '')"
                                :value="
                                    form['we_chat_number'] ? form['we_chat_number'] : ''
                                "
                            />
                            <error :fieldName="'we_chat_number'" :validationErros="validationErros" />
                        </div>
                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="Viber Number *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'viber_number', '')"
                                :value="
                                    form['viber_number'] ? form['viber_number'] : ''
                                "
                            />
                            <error :fieldName="'viber_number'" :validationErros="validationErros" />
                        </div>
                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="Imo Number *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'imo_number', '')"
                                :value="
                                    form['imo_number'] ? form['imo_number'] : ''
                                "
                            />
                            <error :fieldName="'imo_number'" :validationErros="validationErros" />
                        </div>
                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="Mobile Number *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'mobile_number', '')"
                                :value="
                                    form['mobile_number'] ? form['mobile_number'] : ''
                                "
                            />
                            <error :fieldName="'mobile_number'" :validationErros="validationErros" />
                        </div>
                        <div class="w-full mt-4">
                            <input
                                type="email"
                                placeholder="Email *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'email', '')"
                                :value="form['email'] ? form['email'] : ''"
                            />
                            <error :fieldName="'email'" :validationErros="validationErros" />
                        </div>
                        <div class="w-full mt-4">
                            <input
                                type="text"
                                placeholder="Category *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'category', '')"
                                :value="
                                    form['category'] ? form['category'] : ''
                                "
                            />
                            <error :fieldName="'category'" :validationErros="validationErros" />
                        </div>
                        <div class="w-full mt-4">
                            <input
                                type="password"
                                placeholder="Password"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'password', '')"
                            />
                            <error :fieldName="'password'" :validationErros="validationErros" />
                        </div>

                        <div class="w-full mt-4">
                            <p class="text-sm lg:text-base text-gray-700">
                                Image * (Files must be less than 5MB, allowed
                                file types: png, gif, jpg, jpeg)
                            </p>
                            <input
                                type="file"
                                class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @change="handleImage($event)"
                            />
                            <error :fieldName="'image'" :validationErros="validationErros" />
                            <img :src="form?.image ? form.image : ''" />
                        </div>

                        <div class="flex justify-end items-center gap-3 mt-4">
                            <div class="space-x-4">
                                <button
                                    class="can-edu-btn-fill"
                                    @click="closeModal"
                                >
                                    Close
                                </button>
                                <button
                                    class="can-edu-btn-fill"
                                    @click="addUpdate"
                                >
                                    Add Ambassador
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { mapState } from "vuex";
import Error from "../../Error.vue"
export default {
    props: ["logged_in_customer","school_id"],
    components: { Error },
    computed: {
        ...mapState({
            form: (state) => state.school_ambassadors.form,
            showModal: (state) => state.school_ambassadors.showModal,
            school_ambassadors: (state) =>
                state.school_ambassadors.school_ambassadors,
            pagination: (state) => state.school_ambassadors.pagination,
            validationErros: (state) =>
                state.school_ambassadors.validationErros,
            searchParam: (state) => state.school_ambassadors.searchParam,
            loading: (state) => state.school_ambassadors.loading,
            languages: (state) => state.school_ambassadors.form.languages,
        }),
    },
    data() {
        return {
            activeTab: "en",
        };
    },
    methods: {
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.$store.commit("school_ambassadors/setForData", {
                    key: "image",
                    value: res?.data,
                });
            });
        },
        closeModal() {
            this.$store.commit("school_ambassadors/setShowModal", 0);
            this.$store.commit("school_ambassadors/resetForm");
            this.$store.commit("school_ambassadors/setForData", {
                key: "customer_id",
                value: this.logged_in_customer,
            });
            this.$store.commit("school_ambassadors/setForData", {
                key: "school_id",
                language: "",
                value: this.school_id,
            });
            this.fetchCustomerLangs();
        },
        handleInput(e, key, language) {
            this.$store.commit("school_ambassadors/setForData", {
                key,
                language,
                value: e.target.value,
            });
        },
        changeLanguageTab(language) {
            this.activeTab = language.language_code;
        },
        addUpdate() {
            this.$store
                .dispatch("school_ambassadors/addUpdateForm")
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$store.commit("school_ambassadors/setLimit", 10);
                        this.$store.commit(
                            "school_ambassadors/setSortBy",
                            "id"
                        );
                        this.$store.commit(
                            "school_ambassadors/setSortType",
                            "desc"
                        );
                        this.$store.dispatch(
                            "school_ambassadors/fetchSchoolAmbassadors"
                        );
                        this.closeModal();
                    }
                });
        },
        fetchCustomerLangs() {
            axios
                .get(
                    "/api/web/customer-languages?customer_id=" +
                        this.logged_in_customer
                )
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$store.commit(
                            "school_ambassadors/setLanguages",
                            res.data.data
                        );
                        res.data.data?.filter((lang) => {
                            this.$store.commit(
                                "school_ambassadors/setForData",
                                {
                                    key: "name",
                                    language: lang,
                                    value: "",
                                }
                            );
                            this.$store.commit(
                                "school_ambassadors/setForData",
                                {
                                    key: "about_me",
                                    language: lang,
                                    value: "",
                                }
                            );
                        });
                    }
                });
        },
    },

    mounted() {
        this.fetchCustomerLangs();
    },
};
</script>
