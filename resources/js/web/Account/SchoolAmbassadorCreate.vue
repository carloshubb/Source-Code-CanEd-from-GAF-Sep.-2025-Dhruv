<template>
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="mt-4 mb-2">
                <h2 class="can-school-h2 text-primary">Add a new Ambassador</h2>
            </div>
            <div class="">
                <div class="flex justify-end">
                    <p class=text-primary>* Indicates required fields</p>
                </div>
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                    <ul class="flex gap-2 flex-wrap my-4">
                        <li class="mr-2" v-for="language in languages" :key="language.code">
                            <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
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
                            ]">{{ language.language_code }}</a>
                        </li>
                    </ul>
                </div>
                <div class="w-full mt-2" v-for="language in languages" :key="language.language_code" :class="activeTab == language.language_code
                    ? 'block'
                    : 'hidden'
                    ">
                    <label for="" class="block text-base lg:text-lg">Name <span class="text-primary">*</span> </label>
                    <input type="text" placeholder="" name="name"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'name', language)" :value="form['name'] &&
                            form['name'][`name_${language.language_code}`]
                            ? form['name'][
                            `name_${language.language_code}`
                            ]
                            : ''
                            " />
                    <error :fieldName="`name.name_${language.language_code}`" :validationErros="validationErros" />
                </div>
                <div class="w-full mt-2" v-for="language in languages" :key="language.language_code" :class="activeTab == language.language_code
                    ? 'block'
                    : 'hidden'
                    ">
                    <label for="" class="block text-base lg:text-lg">About me <span class="text-primary">*</span>
                    </label>
                    <textarea name="about_me" id="" cols="5" rows="5"
                        placeholder="Write a brief introduction about yourself. 100 words max"
                        class="border border-l-[5px] w-full border-l-primary border-gray-300 rounded mt-2 p-3 focus:outline-none focus:ring-none"
                        @input="handleInput($event, 'about_me', language)">{{
                            form["about_me"] &&
                                form["about_me"][
                                `about_me_${language.language_code}`
                                ]
                                ? form["about_me"][
                                `about_me_${language.language_code}`
                                ]
                                : ""
                        }}</textarea>
                    <error :fieldName="`about_me.about_me_${language.language_code}`"
                        :validationErros="validationErros" />
                </div>

                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">I am from <span class="text-primary">*</span></label>
                    <input type="text" placeholder="Country of origin" name="region"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'region', '')" :value="form['region'] ? form['region'] : ''" />
                    <error :fieldName="'region'" :validationErros="validationErros" />
                </div>

                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">State/Province <span class="text-primary">*</span></label>
                    <input type="text" placeholder="province" name="province"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'province', '')"
                        :value="form['province'] ? form['province'] : ''" />
                    <error :fieldName="'province'" :validationErros="validationErros" />
                </div>

                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">City <span class="text-primary">*</span></label>
                    <input type="text" placeholder="city" name="city"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'city', '')" :value="form['city'] ? form['city'] : ''" />
                    <error :fieldName="'city'" :validationErros="validationErros" />
                </div>

                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">I study at <span
                            class="text-primary">*</span></label>
                    <select name="degree_level"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @change="handleInput($event, 'degree_level', '')"
                        :value="form['degree_level'] ? form['degree_level'] : ''">
                        <option value="" disabled selected>Select your current degree level</option>
                        <option v-for="degree in degreeLevels" :key="degree.id" :value="degree.name">
                            {{ degree.name }}
                        </option>
                    </select>
                    <error :fieldName="'degree_level'" :validationErros="validationErros" />
                </div>
                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">I can help with 
                    </label>
                    <input type="text" name="fav_module"
                        placeholder="What can you help the future students with: immigration questions, admissions requirements, tuition fees, living expenses, accommodation, work while studying, ... etc."
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'fav_module', '')" :value="form['fav_module'] ? form['fav_module'] : ''
                            " />
                    <error :fieldName="'fav_module'" :validationErros="validationErros" />
                </div>

                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">Hobies and interests in <span
                            class="text-primary">*</span> </label>
                    <input type="text" name="hobies_interests" placeholder=""
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'hobies_interests', '')" :value="form['hobies_interests']
                            ? form['hobies_interests']
                            : ''
                            " />
                    <error :fieldName="'hobies_interests'" :validationErros="validationErros" />
                </div>

                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">I work as
                    </label>
                    <input type="text" placeholder="" name="societies"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'societies', '')"
                        :value="form['societies'] ? form['societies'] : ''" />
                    <error :fieldName="'societies'" :validationErros="validationErros" />
                </div>

                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">Languages <span class="text-primary">*</span>
                    </label>
                    <input type="text" placeholder="" name="langs"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'langs', '')" :value="form['langs'] ? form['langs'] : ''" />
                    <error :fieldName="'langs'" :validationErros="validationErros" />
                </div>
                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">Messaging Apps </label>
                    <v-select label="text" multiple :trackBy="id"  v-model="selectedMessagingApps" :options="sortedMessagingApps" :settings="selectSettings" :reduce="option => option.id" />
                </div>
                <div v-for="appId in selectedMessagingApps" :key="appId" class="w-full mt-4">
                    <label :for="`messaging_app_${appId}`" class="block text-base lg:text-lg">
                        {{ getMessagingAppById(appId).text }} ID
                    </label>
                    <input type="text" :id="`messaging_app_${appId}`"
                        :placeholder="`Enter your ${getMessagingAppById(appId).text} ID`"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleMessagingAppInput($event, appId)"
                        :value="form['messaging_apps'] && form['messaging_apps'][appId] ? form['messaging_apps'][appId] : ''" />
                    <error :fieldName="`messaging_apps.${appId}`" :validationErros="validationErros" />
                </div>
                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">Mobile number
                    </label>
                    <input type="text" placeholder="" name="mobile_number"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'mobile_number', '')" :value="form['mobile_number']
                            ? form['mobile_number']
                            : ''
                            " @keypress="restrictToNumbers($event, 15)" />
                    <error :fieldName="'mobile_number'" :validationErros="validationErros" />
                </div>
<!-- 
                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">We chat
                    </label>
                    <input type="text" placeholder=""
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'we_chat_number', '')" :value="form['we_chat_number']
                            ? form['we_chat_number']
                            : ''
                            " />
                    <error :fieldName="'we_chat_number'" :validationErros="validationErros" />
                </div> -->

                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">Email <span class="text-primary">*</span> </label>
                    <input type="email" placeholder="" name="email"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'email', '')" :value="form['email'] ? form['email'] : ''" />
                    <error :fieldName="'email'" :validationErros="validationErros" />
                </div>
                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">Program / Field of study <span class="text-primary">*</span>
                    </label>
                    <input type="text" placeholder="" name="category"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'category', '')"
                        :value="form['category'] ? form['category'] : ''" />
                    <error :fieldName="'category'" :validationErros="validationErros" />
                </div>

                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">My major
                    </label>
                    <input type="text" placeholder="" name="my_major"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'my_major', '')"
                        :value="form['my_major'] ? form['my_major'] : ''" />
                    <error :fieldName="'my_major'" :validationErros="validationErros" />
                </div>

                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">My minor
                    </label>
                    <input type="text" placeholder="" name="my_minor"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'my_minor', '')"
                        :value="form['my_minor'] ? form['my_minor'] : ''" />
                    <error :fieldName="'my_minor'" :validationErros="validationErros" />
                </div>

                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">
                        <span v-if="user_type === 'school' || user_type === 'student'">
                          I study here
                        </span>
                        <span v-else-if="user_type === 'business'">
                          I work here
                        </span>
                        <span v-else>
                          I am here
                        </span>
                        <span class="text-primary">*</span>
                      </label>
                    <input type="text" placeholder="" name="I_study_here"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'I_study_here', '')"
                        :value="form['I_study_here'] ? form['I_study_here'] : ''" />
                    <error :fieldName="'I_study_here'" :validationErros="validationErros" />
                </div>

                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">Password <span class="text-primary">*</span></label>
                    <input type="password" placeholder="" name="password"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'password', '')" />
                    <error :fieldName="'password'" :validationErros="validationErros" />
                </div>

                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">Status <span class="text-primary">*</span></label>
                    <select name="status"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'status', '')">
                        <option value="">Select</option>
                        <option :selected="form['status'] == 'active'" value="active">Active</option>
                        <option :selected="form['status'] == 'inactive'" value="inactive">In Active</option>
                    </select>
                    <error :fieldName="'status'" :validationErros="validationErros" />
                </div>
                <div class="w-full mt-4">
                    <label for="" class="block text-base lg:text-lg">
                        <span v-if="user_type === 'school' || user_type === 'student'">
                            This is my school
                        </span>
                        <span v-else-if="user_type === 'business'">
                            This is my work
                        </span>
                        <span v-else>
                            Use my school profile image
                        </span>
                        <span class="text-primary">*</span>
                      </label>
                    <input type="text" placeholder="" name="title"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleInput($event, 'title', '')"
                        :value="form['title'] ? form['title'] : ''" />
                    <error :fieldName="'title'" :validationErros="validationErros" />
                </div>

                <div class="w-full mt-4">
                    <!-- <label for="" class="block text-base lg:text-lg">Use my school profile image </label> -->
                    <label for="" class="block text-base lg:text-lg">
                        <span v-if="user_type === 'school' || user_type === 'student'">
                            Use my school profile image
                        </span>
                        <span v-else-if="user_type === 'business'">
                            Use my business profile image
                        </span>
                        <span v-else>
                            Use my school profile image
                        </span>
                        <span class="text-primary">*</span>
                      </label>
                    <input name="is_checked" type="checkbox" placeholder="" class="" @input="handleInput($event, 'is_checked', '')" />
                    <error :fieldName="'is_checked'" :validationErros="validationErros" />
                </div>
                <div class="w-full mt-4">
                    <label class="block text-base lg:text-lg">Image<span
                        class="text-primary">*</span></label>
                    <p class="text-base">
                        Your photo - Optional. 5MB max. Allowed formats: JPG. JPEG, PNG. You may add an avatar if you want
                    </p>
                    <input type="file" name="image"
                        class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @change="handleImage($event)" />
                    <error :fieldName="'image'" :validationErros="validationErros" />
                    <div v-if="form['image']" class="mt-2 relative">
                        <img :src="form.image" style="height: 100px; width: 100px" />
                        <button @click="removeImage"
                            class="absolute top-0 right-0 bg-red-500 text-white rounded-full px-2 py-1 text-xs">
                            X
                        </button>
                    </div>
                </div>

                <div class="flex justify-center items-center gap-3 mt-4">
                    <button class="mb-6 can-edu-btn-fill" @click="addUpdate">
                        Add Ambassador
                    </button>
                </div>
            </div>
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
    
    
    
    <transition name="slide">
        <div id="defaultModal" tabindex="-1" aria-hidden="true"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="showLockPopUpModal">
            <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                ref="elementToDetectClick">
                <div class="relative">
                    <div class="absolute top-3 right-3 cursor-pointer" @click="toggleLockPopUpModal">
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
                            You've reached your package limit. Upgrade your package to continue creating more</p>
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
import axios from "axios";
import { mapState } from "vuex";
import Error from "../Error.vue";
import Select2 from 'vue3-select2-component';
export default {
    props: ["ambassador_access","lang", "slug", "ambassador_id", "logged_in_customer", "school_id", "logged_in_customer_data", "logged_in_customer_whole_data","user_type"],
    components: { Error, Select2 },
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
        sortedMessagingApps() {
            return this.messagingApps.sort((a, b) => {
                return a.text.localeCompare(b.text); // Sorts alphabetically by the 'text' property
            });
        },
    },
    data() {
        return {
            selectSettings: {
                width: '100%',
                multiple: true, // Enable multi-select
                placeholder: "Select messaging apps", // Placeholder text
                allowClear: true, // Allow clearing selections
            },
            messagingApps: [], // List of messaging apps from API
            selectedMessagingApps: [],
            degreeLevels: [],
            showLockPopUpModal: false,
            showPopUpModal: false,
            popupMsg: '',
            redirection:true,
            activeTab: "en",
        };
    },
    methods: {
        getMessagingAppById(appId) {
            console.log(this.messagingApps);
            console.log(appId);
            const app = this.messagingApps.find(app => app.id == appId);
            console.log("App for ID", appId, ":", app); // Debugging
            return app;
        },
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
                
                if (this.showLockPopUpModal == true && this.redirection) {
                    this.showLockPopUpModal = false;
                    window.location.href =
                        "/" + this.lang + "/" + this.slug + "/our-profile/school-ambassador";
                }
            }
        },
        
        
        toggleLockPopUpModal() {
            this.showLockPopUpModal = !this.showLockPopUpModal;
            if (!this.showLockPopUpModal && this.redirection) {
                window.location.href =
                    "/" + this.lang + "/" + this.slug + "/our-profile/school-ambassador";
            }
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
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.$store.commit("school_ambassadors/setForData", {
                    key: "image",
                    value: res?.data,
                });
                if (this.validationErros.has("image")) {
                    this.validationErros.clear("image");
                }
            });
        },
        removeImage() {
            this.$store.commit("school_ambassadors/setForData", {
                key: "image",
                value: null, // Removes the image
            });
        },
        handleInput(e, key, language) {
            const errorKey = language
                ? `${key}.${key}_${language.language_code}`
                : key;
            this.$store.commit("school_ambassadors/setForData", {
                key,
                language,
                value: e.target.value,
            });
            if (this.validationErros.has(errorKey)) {
                this.validationErros.clear(errorKey);
            }
        },
        changeLanguageTab(language) {
            this.activeTab = language.language_code;
        },
        addUpdate() {
    this.$store
        .dispatch("school_ambassadors/addUpdateForm")
        .then((res) => {
            if (res.data.status === "Success") {
                this.showPopUpModal = true;
                this.popupMsg = res.data.message;
            }
             if (res.data.status === "Error") {
                this.showPopUpModal = true;
                this.redirection = false;
                this.popupMsg = res.data.message;
            }
        })
        .catch((error) => {
            console.log('errorrrrrrrrrrrrrr',error)
                    if (error.response && error.response.data.errors) {
                        this.focusOnFirstErrorInput(error.response.data.errors);
                    }
                  
                });
},
           focusOnFirstErrorInput(errors) {
            console.log('Errors object:', errors);
            const firstErrorField = Object.keys(errors)[0];
            console.log('First error field name:', firstErrorField);

            if (!firstErrorField) {
                console.log('No error field found');
                return;
            }

            const fieldName = firstErrorField.split('.')[0];
            console.log('Stripped error field name:', fieldName);
            const containerDiv = document.querySelector(`[name="${fieldName}"]`);
            console.log('Found input element:', containerDiv);

            if (containerDiv) {
                containerDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                containerDiv.focus();
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
        handleMessagingAppInput(event, appId) {
            const value = event.target.value;
            this.$store.commit("school_ambassadors/setForData", {
                key: "messaging_apps",
                value: {
                    ...this.form['messaging_apps'],
                    [appId]: value
                }
            });
            if (this.validationErros.has(`messaging_apps.${appId}`)) {
                this.validationErros.clear(`messaging_apps.${appId}`);
            }
        }

    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutsidePopup);
    },
    // mounted() {
    //     document.addEventListener("click", this.handleClickOutsidePopup);
    //     this.$store.commit("school_ambassadors/setForData", {
    //         key: "customer_id",
    //         value: this.logged_in_customer,
    //     });
    //     this.$store.commit("school_ambassadors/setForData", {
    //         key: "school_id",
    //         language: "",
    //         value: this.school_id,
    //     });
    //     this.fetchCustomerLangs();

    //     if (this?.ambassador_id && this?.ambassador_id != "") {
    //         this.$store.dispatch("school_ambassadors/fetchSchoolAmbassador", {
    //             id: this.ambassador_id,
    //         });
    //     }
    //     axios.get(`${process.env.MIX_WEB_API_URL}degree-levels?lang=${this.activeTab}`)
    //         .then(response => {
    //             this.degreeLevels = response.data.data; // Assuming the API returns data in `data` key
    //         })
    //         .catch(error => {
    //             console.error("Failed to fetch degree levels:", error);
    //         });
    //     axios.get(`${process.env.MIX_WEB_API_URL}messaging_apps`)
    //         .then(res => {
    //             res.data.data.map((messaging_app) => {
    //                 console.log('roko kocat', res.data.data);
    //                 this.messagingApps.push({
    //                     id: messaging_app.id,
    //                     text: messaging_app?.messaging_app_detail[0].name,
    //                 });
    //             });
    //             // this.messagingApps = response.data.data; // Assuming the API returns data in `data` key
    //         })
    //         .catch(error => {
    //             console.error("Failed to fetch degree levels:", error);
    //         });
    //     console.log(this.messagingApps);
    //     if (this?.ambassador_id && this?.ambassador_id != "") {
    //         this.$store.dispatch("school_ambassadors/fetchSchoolAmbassador", {
    //             id: this.ambassador_id,
    //         }).then(() => {
    //             // Initialize messaging_apps if not already set
    //             if (!this.form['messaging_apps']) {
    //                 this.$store.commit("school_ambassadors/setForData", {
    //                     key: "messaging_apps",
    //                     value: {}
    //                 });
    //             }
    //         });
    //     }
    //     console.log(this.form)
    // },
    mounted() {
//         console.log('this.logged_in_customer_whole_data',this.logged_in_customer);
//         console.log('User type:', this.user_type);
//   console.log('Logged in customer whole data:', this.logged_in_customer_whole_data);

    document.addEventListener("click", this.handleClickOutsidePopup);
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

    if (this?.ambassador_id && this?.ambassador_id != "") {
        this.$store.dispatch("school_ambassadors/fetchSchoolAmbassador", {
            id: this.ambassador_id,
        }).then(response => {
            const messagingAppsData = response.data.data.messaging_app;
            if (messagingAppsData.length) {
                this.selectedMessagingApps = messagingAppsData.map(app => app.messaging_app_id);
                messagingAppsData.forEach(app => {
                    this.$store.commit("school_ambassadors/setForData", {
                        key: "messaging_apps",
                        value: {
                            ...this.form['messaging_apps'],
                            [app.messaging_app_id]: app.username
                        }
                    });
                });
            }
        });
    }
    axios.get(`${process.env.MIX_WEB_API_URL}degree-levels?lang=${this.activeTab}`)
        .then(response => {
            this.degreeLevels = response.data.data;
        })
        .catch(error => {
            console.error("Failed to fetch degree levels:", error);
        });
    axios.get(`${process.env.MIX_WEB_API_URL}all_messaging_apps`)
        .then(res => {
            res.data.data.map((messaging_app) => {
                this.messagingApps.push({
                    id: messaging_app.id,
                    text: messaging_app?.messaging_app_detail[0].name,
                });
            });
        })
        .catch(error => {
            console.error("Failed to fetch messaging apps:", error);
        });
        this.showLockPopUpModal=!JSON.parse(this.ambassador_access)
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