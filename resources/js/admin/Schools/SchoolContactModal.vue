<template>
    <transition name="slide">    
        <div
            v-if="showModal"
            id="modal"
            class="fixed z-50 inset-0 overflow-y-auto p-4 mt-5"
        >
            <div class="flex items-center justify-center min-h-screen">
                <div
                    class="modal-container bg-white w-full md:w-3/5 mx-auto rounded shadow-lg overflow-y-auto"
                >
                    <div class="modal-content py-6 text-left px-6">
                        <div class="flex justify-between items-center pb-3">
                            <div class="can-school-h2 mb-0">Add school contact</div>
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
                                <ul class="flex flex-wrap my-4">
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
                                                activeTab == language.abbreviation
                                                    ? 'text-white bg-primary active'
                                                    : '',
                                                errors.has(
                                                    `name.name_${language.abbreviation}`
                                                )
                                                    ? 'bg-red-600 text-white hover:text-white'
                                                    : '',
                                            ]"
                                            >{{ language.abbreviation }}</a
                                        >
                                    </li>
                                </ul>
                            </div>
                            <div
                                class="w-full mt-2"
                                v-for="language in languages"
                                :key="language.abbreviation"
                                :class="
                                    activeTab == language.abbreviation
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
                                            `name_${language.abbreviation}`
                                        ]
                                            ? form['name'][
                                                `name_${language.abbreviation}`
                                            ]
                                            : ''
                                    "
                                />
                                <error
                                    :fieldName="`name.name_${language.abbreviation}`"
                                    :validationErros="errors"
                                />
                            </div>
                            <div
                            class="w-full mt-2"
                            v-for="language in languages"
                            :key="language.abbreviation"
                            :class="activeTab == language.abbreviation ? 'block' : 'hidden'"
                        >
                            <label class="block text-base lg:text-lg">Brief description</label>
                            
                            <textarea
                                placeholder="Brief description *"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'brief_descr', language)"
                                :value="
                                    form['brief_descr'] &&
                                    form['brief_descr'][`brief_descr_${language.abbreviation}`]
                                        ? form['brief_descr'][`brief_descr_${language.abbreviation}`]
                                        : ''
                                "
                                rows="4"
                            ></textarea>
                        
                            <error
                                :fieldName="`brief_descr.brief_descr_${language.abbreviation}`"
                                :validationErros="errors"
                            />
                        </div>
                        

                            <div class="w-full mt-4">
                                <input
                                    type="text"
                                    placeholder="Department *"
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="handleInput($event, 'department', '')"
                                    :value="
                                        form['department'] ? form['department'] : ''
                                    "
                                />
                                <error
                                    :fieldName="`department`"
                                    :validationErros="errors"
                                />
                            </div>

                            <div class="w-full mt-4">
                                <input
                                    type="text"
                                    placeholder="Address *"
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="handleInput($event, 'address', '')"
                                    :value="form['address'] ? form['address'] : ''"
                                />
                                <error
                                    :fieldName="`address`"
                                    :validationErros="errors"
                                />
                            </div>

                            <div class="w-full mt-4">
                                <input
                                    type="text"
                                    placeholder="City , province & postal code *"
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="handleInput($event, 'city', '')"
                                    :value="form['city'] ? form['city'] : ''"
                                />
                                <error
                                    :fieldName="`city`"
                                    :validationErros="errors"
                                />
                            </div>

                            <div class="w-full mt-4">
                                <input
                                    type="text"
                                    placeholder="Country *"
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="handleInput($event, 'country', '')"
                                    :value="form['country'] ? form['country'] : ''"
                                />
                                <error
                                    :fieldName="`country`"
                                    :validationErros="errors"
                                />
                            </div>

                            <div class="w-full mt-4">
                                <input
                                    type="text"
                                    placeholder="Phone *"
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="handleInput($event, 'phone', '')"
                                    :value="form['phone'] ? form['phone'] : ''"
                                />
                                <error
                                    :fieldName="`phone`"
                                    :validationErros="errors"
                                />
                            </div>

                            <div class="w-full mt-4">
                                <input
                                    type="text"
                                    placeholder="Fax"
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="handleInput($event, 'fax', '')"
                                    :value="form['fax'] ? form['fax'] : ''"
                                />
                                <error
                                    :fieldName="`fax`"
                                    :validationErros="errors"
                                />
                            </div>

                            <div class="w-full mt-4">
                                <input
                                    type="text"
                                    placeholder="Direct email *"
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="handleInput($event, 'direct_email', '')"
                                    :value="
                                        form['direct_email']
                                            ? form['direct_email']
                                            : ''
                                    "
                                />
                                <error
                                    :fieldName="`direct_email`"
                                    :validationErros="errors"
                                />
                            </div>
                            <div class="w-full mt-4">
                                <input
                                    type="text"
                                    placeholder="Website Link *"
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="handleInput($event, 'website_link', '')"
                                    :value="
                                        form['website_link']
                                            ? form['website_link']
                                            : ''
                                    "
                                />
                                <error
                                    :fieldName="`website_link`"
                                    :validationErros="errors"
                                />
                            </div>
                            <div class="w-full mt-4">
                                <input
                                    type="text"
                                    placeholder="Facebook Link *"
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="handleInput($event, 'contact_facebook', '')"
                                    :value="
                                        form['contact_facebook']
                                            ? form['contact_facebook']
                                            : ''
                                    "
                                />
                                <error
                                    :fieldName="`contact_facebook`"
                                    :validationErros="errors"
                                />
                            </div>
                            <div class="w-full mt-4">
                                <input
                                    type="text"
                                    placeholder="Instagram Link *"
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="handleInput($event, 'contact_instagram', '')"
                                    :value="
                                        form['contact_instagram']
                                            ? form['contact_instagram']
                                            : ''
                                    "
                                />
                                <error
                                    :fieldName="`contact_instagram`"
                                    :validationErros="errors"
                                />
                            </div>
                            <div class="w-full mt-4">
                                <input
                                    type="text"
                                    placeholder="Linkedin Link *"
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="handleInput($event, 'contact_linkedin', '')"
                                    :value="
                                        form['contact_linkedin']
                                            ? form['contact_linkedin']
                                            : ''
                                    "
                                />
                                <error
                                    :fieldName="`contact_linkedin`"
                                    :validationErros="errors"
                                />
                            </div>

                            <div class="w-full mt-4">
                                <input
                                    type="text"
                                    placeholder="Order *"
                                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @input="handleInput($event, 'order', '')"
                                    :value="form['order'] ? form['order'] : ''"
                                />
                                <error
                                    :fieldName="`order`"
                                    :validationErros="errors"
                                />
                            </div>
                            <div class="w-full mt-4">
                                <label
                                    class="text-gray-700 font-semibold text-sm lg:text-base"
                                >
                                    Image * (Files must be less than 5MB, allowed
                                    file types: png, gif, jpg, jpeg)
                                </label>
                                <input
                                    type="file"
                                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                    @change="handleImage($event)"
                                />
                                <error
                                    :fieldName="`image`"
                                    :validationErros="errors"
                                />
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
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
<script>
import axios from "axios";
import { mapState } from "vuex";
import Error from "./Error.vue";
export default {
    props: ["logged_in_customer", "school_id"],
    components: { Error },
    computed: {
        ...mapState({
            form: (state) => state.school_contacts.form,
            showModal: (state) => state.school_contacts.showModal,
            school_contacts: (state) => state.school_contacts.school_contacts,
            pagination: (state) => state.school_contacts.pagination,
            errors: (state) => state.school_contacts.errors,
            searchParam: (state) => state.school_contacts.searchParam,
            loading: (state) => state.school_contacts.loading,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            activeTab: "en",
        };
    },
    methods: {
        closeModal() {
            this.$store.commit("school_contacts/setShowModal", 0);
            this.$store.commit("school_contacts/resetForm");
            this.fetchCustomerLangs();
            setTimeout(() => {
                this.$store.commit("school_contacts/setForData", {
                    key: "school_id",
                    language: "",
                    value: this.$route?.params?.id,
                });
            }, 500);
        },
        handleImage(e) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.$store.commit("school_contacts/setForData", {
                    key: "image",
                    language: "",
                    value: res?.data,
                });
            });
        },
        handleInput(e, key, language) {
            this.$store.commit("school_contacts/setForData", {
                key,
                language,
                value: e.target.value,
            });
        },
        changeLanguageTab(language) {
            this.activeTab = language.abbreviation;
        },
        addUpdate() {
            this.$store
                .dispatch("school_contacts/addUpdateForm")
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$store.commit("school_contacts/setLimit", 10);
                        this.$store.commit("school_contacts/setSortBy", "id");
                        this.$store.commit(
                            "school_contacts/setSortType",
                            "name"
                        );
                        this.$store.dispatch(
                            "school_contacts/fetchSchoolContacts",
                            {
                                school_id: this.$route?.params?.id,
                            }
                        );
                        this.closeModal();
                    }
                });
        },
        fetchCustomerLangs() {
            this.$store
                .dispatch("languages/fetchLanguages", {
                    url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
                })
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$store.commit(
                            "school_contacts/setLanguages",
                            res.data.data
                        );

                        res.data.data?.filter((lang) => {
                            this.$store.commit("school_contacts/setForData", {
                                key: "name",
                                language: lang,
                                value: "",
                            });
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