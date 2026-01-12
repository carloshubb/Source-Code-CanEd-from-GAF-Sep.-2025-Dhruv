<template>
    <div v-if="showModal" id="modal" class="fixed z-50 inset-0 overflow-y-auto p-4">
        <div class="flex items-center justify-center min-h-screen">
            <div class="modal-overlay w-full h-full bg-gray-900 opacity-50"></div>
            <div class="modal-container bg-white w-full md:w-3/5 mx-auto rounded shadow-lg overflow-y-auto">
                <div class="modal-content py-6 text-left px-6">
                    <div class="flex justify-between items-center pb-3">
                        <div class="can-school-h2 mb-0">Add school contact</div>
                        <div class="modal-close cursor-pointer z-50 border border-primary p-1.5 rounded-full"
                            @click="closeModal">
                            <svg class="fill-current text-primary" xmlns="http://www.w3.org/2000/svg" width="12"
                                height="12" viewBox="0 0 18 18">
                                <path
                                    d="M18 1.1L16.9 0 9 7.9 1.1 0 0 1.1 7.9 9 0 16.9 1.1 18 9 10.1l7.9 7.9 1.1-1.1-7.9-7.9z" />
                            </svg>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div
                            class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                            <ul class="flex gap-2 flex-wrap my-4">
                                <li class="mr-2" v-for="language in languages" :key="language.code">
                                    <a @click.prevent="
                                        changeLanguageTab(language)
                                        " href="#" :class="[
                                            'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                            activeTab != null &&
                                                activeTab == language.language_code
                                                ? 'text-white bg-primary active'
                                                : '',
                                            errors.has(
                                                `name.name_${language.code}`
                                            )
                                                ? 'bg-red-600 text-white hover:text-white'
                                                : '',
                                        ]">{{ getLanguageName(language.language_code) }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="w-full mt-2" v-for="language in languages" :key="language.language_code" :class="activeTab == language.language_code
                            ? 'block'
                            : 'hidden'
                            ">
                            <label class="block text-base lg:text-lg">Name</label>
                            <input type="text" placeholder="Name *" name="name"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'name', language)" :value="form['name'] &&
                                    form['name'][
                                    `name_${language.language_code}`
                                    ]
                                    ? form['name'][
                                    `name_${language.language_code}`
                                    ]
                                    : ''
                                    " />
                            <error :fieldName="`name.name_${language.language_code}`" :validationErros="errors" />

                        </div>
                        <div class="w-full mt-2" v-for="language in languages" :key="language.language_code"
                            :class="activeTab == language.language_code ? 'block' : 'hidden'">

                            <label class="block text-base lg:text-lg">Brief description</label>

                            <textarea placeholder="Brief description *" name="brief_descr"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'brief_descr', language)" :value="form['brief_descr'] &&
                                    form['brief_descr'][`brief_descr_${language.language_code}`]
                                    ? form['brief_descr'][`brief_descr_${language.language_code}`]
                                    : ''" rows="4">
    </textarea>

                            <error :fieldName="`brief_descr.brief_descr_${language.language_code}`"
                                :validationErros="errors" />

                        </div>


                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Department</label>
                            <input type="text" placeholder="Department *" name="department"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'department', '')" :value="form['department'] ? form['department'] : ''
                                    " />
                            <error :fieldName="`department`" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Address</label>
                            <input type="text" placeholder="Address *" name="address"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'address', '')"
                                :value="form['address'] ? form['address'] : ''" />
                            <error :fieldName="`address`" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">City , province & postal code</label>
                            <input type="text" placeholder="City , province & postal code *" name="city"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'city', '')" :value="form['city'] ? form['city'] : ''" />
                            <error :fieldName="`city`" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Country</label>
                            <input type="text" placeholder="Country *" name="country"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'country', '')"
                                :value="form['country'] ? form['country'] : ''" />
                            <error :fieldName="`country`" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Phone</label>
                            <input type="text" placeholder="With area code" name="phone"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'phone', '')" :value="form['phone'] ? form['phone'] : ''"
                                @keypress="restrictToNumbers($event, 15)" />
                            <error :fieldName="`phone`" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Fax</label>
                            <input type="text" placeholder="Fax" name="fax"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'fax', '')" :value="form['fax'] ? form['fax'] : ''" />
                            <error :fieldName="`fax`" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Direct email</label>
                            <input type="text" placeholder="Direct email *" name="direct_email"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'direct_email', '')" :value="form['direct_email']
                                    ? form['direct_email']
                                    : ''
                                    " />
                            <error :fieldName="`direct_email`" :validationErros="errors" />
                        </div>
                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Website Link</label>
                            <input type="text" placeholder="Website Link *" name="website_link"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'website_link', '')" :value="form['website_link']
                                    ? form['website_link']
                                    : ''
                                    " />
                            <error :fieldName="`website_link`" :validationErros="errors" />
                        </div>
                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Facebook</label>
                            <input type="text" placeholder="Facebook Link *" name="contact_facebook"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'contact_facebook', '')" :value="form['contact_facebook']
                                    ? form['contact_facebook']
                                    : ''
                                    " />
                            <error :fieldName="`contact_facebook`" :validationErros="errors" />
                        </div>
                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Instagram</label>
                            <input type="text" placeholder="Instagram Link *" name="contact_instagram"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'contact_instagram', '')" :value="form['contact_instagram']
                                    ? form['contact_instagram']
                                    : ''
                                    " />
                            <error :fieldName="`contact_instagram`" :validationErros="errors" />
                        </div>
                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Linkedin</label>
                            <input type="text" placeholder="Linkedin Link *" name="contact_linkedin"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'contact_linkedin', '')" :value="form['contact_linkedin']
                                    ? form['contact_linkedin']
                                    : ''
                                    " />
                            <error :fieldName="`contact_linkedin`" :validationErros="errors" />
                        </div>

                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Order</label>
                            <input type="text" placeholder="Order *" name="order"
                                class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @input="handleInput($event, 'order', '')" :value="form['order'] ? form['order'] : ''" />
                            <error :fieldName="`order`" :validationErros="errors" />
                        </div>
                        <div class="w-full mt-2">
                            <label class="block text-base lg:text-lg">Image</label>
                            <p class="text-base">
                                (Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)
                            </p>
                            <input type="file" name="image"
                                class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @change="handleImage($event)" />
                            <error :fieldName="`image`" :validationErros="errors" />
                            <img v-if="form['image']" :src="form?.image ? form.image : ''"
                                style="height: 100px; width: 100px" />
                        </div>

                        <div class="flex justify-end items-center gap-3 mt-4">
                            <div class="space-x-4">
                                <button class="can-edu-btn-fill" @click="closeModal">
                                    Close
                                </button>
                                <button class="can-edu-btn-fill" @click="addUpdate">
                                    Submit
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
    props: ["logged_in_customer", "school_id", "languages_with_names"],
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
            languages: (state) => state.school_contacts.form.languages,
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
            activeTab: "en",
        };
    },
    methods: {
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
        closeModal() {
            this.$store.commit("school_contacts/setShowModal", 0);
            this.$store.commit("school_contacts/resetForm");
            this.fetchCustomerLangs();
            setTimeout(() => {
                this.$store.commit("school_contacts/setForData", {
                    key: "customer_id",
                    language: "",
                    value: this.logged_in_customer,
                });

                this.$store.commit("school_contacts/setForData", {
                    key: "school_id",
                    language: "",
                    value: this.school_id,
                });
            }, 500);
        },
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.$store.commit("school_contacts/setForData", {
                    key: "image",
                    language: "",
                    value: res?.data,
                });
                if (this.errors.has("image")) {
                    this.errors.clear("image");
                }
            });
        },
        // handleInput(e, key, language) {
        //     this.$store.commit("school_contacts/setForData", {
        //         key,
        //         language,
        //         value: e.target.value,
        //     });
        //     if (this.errors.has(key)) {
        //     this.errors.clear(key);
        // }
        // },
        handleInput(e, key, language) {
            const errorKey = language
                ? `${key}.${key}_${language.language_code}`
                : key;

            this.$store.commit("school_contacts/setForData", {
                key,
                language,
                value: e.target.value,
            });

            if (this.errors.has(errorKey)) {
                this.errors.clear(errorKey);
            }
        },
        changeLanguageTab(language) {
            this.activeTab = language.language_code;
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
                            "school_contacts/fetchSchoolContacts"
                        );
                        this.closeModal();
                    }
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
        fetchCustomerLangs() {
            axios
                .get(
                    "/api/web/customer-languages?customer_id=" +
                    this.logged_in_customer
                )
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
