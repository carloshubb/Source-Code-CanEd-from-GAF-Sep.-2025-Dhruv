<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">{{ isFormEdit ? 'Edit' : 'Create' }} Ambassador</h1>
                        <router-link :to="{ name: 'admin.ambassadors.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                    <ul class="flex gap-2 flex-wrap my-4">
                        <li class="mr-2" v-for="language in languages" :key="language.code">
                            <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                activeTab == language.abbreviation
                                    ? 'text-white bg-primary active'
                                    : '',
                                validationErros.has(
                                    `name.name_${language.code}`
                                )
                                    ? 'bg-red-600 text-white hover:text-white'
                                    : '',
                            ]">{{ language.name }}</a>
                        </li>
                    </ul>
                </div>
                <div class="w-full mt-2" v-for="language in languages" :key="language.abbreviation"
                    :class="activeTab == language.abbreviation ? 'block' : 'hidden'">
                    <label for="" class="block text-base lg:text-lg">Name <span class="text-primary">*</span> </label>
                    <input type="text" placeholder="" name="name"
                        class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="handleMultipleInput('name', $event.target.value, language)" :value="form['name'] &&
                            form['name'][`name_${language.abbreviation}`]
                            ? form['name'][`name_${language.abbreviation}`]
                            : ''
                            " />
                    <!-- <error :fieldName="`name.name_${language.abbreviation}`" :validationErros="validationErros" /> -->
                    <p class="mt-2 text-base text-primary" v-if="
                    validationErros.has(
                        `name.name_${language.abbreviation}`
                    )
                " v-text="validationErros.get(
                    `name.name_${language.abbreviation}`
                )
                    "></p>
                </div>
                <div class="w-full mt-2" v-for="language in languages" :key="language.abbreviation"
                    :class="activeTab == language.abbreviation ? 'block' : 'hidden'">
                    <label for="" class="block text-base lg:text-lg">About me <span class="text-primary">*</span>
                    </label>
                    <textarea name="about_me" id="" cols="5" rows="5" 
                        placeholder="Write a brief introduction about yourself. 100 words max" :value="form['about_me'] &&
                            form['about_me'][`about_me_${language.abbreviation}`]
                            ? form['about_me'][
                            `about_me_${language.abbreviation}`
                            ]
                            : ''
                            "
                        class="border border-l-[5px] w-full border-l-primary border-gray-300 rounded mt-2 p-3 focus:outline-none focus:ring-none"
                        @input="handleMultipleInput('about_me', $event.target.value, language)"></textarea>
                    <!-- <error :fieldName="`about_me.about_me_${language.abbreviation}`"
                        :validationErros="validationErros" /> -->
                        <p class="mt-2 text-base text-primary" v-if="
                    validationErros.has(
                        `about_me.about_me_${language.abbreviation}`
                    )
                " v-text="validationErros.get(
                    `about_me.about_me_${language.abbreviation}`
                )
                    "></p>

                </div>

                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full group">
                        <label for="region" class="block text-base lg:text-lg">I came from</label>
                        <input type="text" name="region"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'region')"
                            :value="form['region'] ? form['region'] : ''" />

                        <!-- <error :fieldName="'region'" :validationErros="validationErros" /> -->
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`region`)"
                        v-text="validationErros.get(`region`)"></p>
                    </div>
                    <!-- <div class="relative z-0 w-full group">
                        <label for="degree_level" class="block text-base lg:text-lg">Degree level</label>
                        <input type="text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'degree_level')"
                            :value="form['degree_level'] ? form['degree_level'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`degree_level`)"
                            v-text="validationErros.get(`degree_level`)"></p>
                    </div> -->
                    <div class="w-full mt-4">
                        <label for="" class="block text-base lg:text-lg">I study at<span
                                class="text-primary">*</span></label>
                        <select name="degree_level"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @change="handleInput($event.target.value, 'degree_level')"
                            :value="form['degree_level'] ? form['degree_level'] : ''">
                            <option value="" disabled selected>Select your current degree level</option>
                            <option v-for="degree in degreeLevels" :key="degree.id" :value="degree.name">
                                {{ degree.name }}
                            </option>
                        </select>

                        <!-- <error :fieldName="'degree_level'" :validationErros="validationErros" /> -->
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`degree_level`)"
                        v-text="validationErros.get(`degree_level`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="I_study_here" class="block text-base lg:text-lg">I study here<span
                                class="text-primary">*</span></label>
                        <input type="text" name="I_study_here"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'I_study_here')"
                            :value="form['I_study_here'] ? form['I_study_here'] : ''" />

                        <!-- <error :fieldName="'I_study_here'" :validationErros="validationErros" /> -->
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`I_study_here`)"
                        v-text="validationErros.get(`I_study_here`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="fav_module" class="block text-base lg:text-lg">I can help with</label>
                        <input type="text" name="fav_module"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder="What can you help the future students with: immigration questions, admissions requirements, tuition fees, living expenses, accommodation, work while studying, … etc"
                            @input="handleInput($event.target.value, 'fav_module')"
                            :value="form['fav_module'] ? form['fav_module'] : ''" />

                        <error :fieldName="'fav_module'" :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="hobies_interests" class="block text-base lg:text-lg">Hobbies and interests
                            in<span class="text-primary">*</span></label>
                        <input type="text" name="hobies_interests"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'hobies_interests')"
                            :value="form['hobies_interests'] ? form['hobies_interests'] : ''" />

                        <!-- <error :fieldName="'hobies_interests'" :validationErros="validationErros" /> -->
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`hobies_interests`)"
                        v-text="validationErros.get(`hobies_interests`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="societies" class="block text-base lg:text-lg">I work as</label>
                        <input type="text" name="societies"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'societies')"
                            :value="form['societies'] ? form['societies'] : ''" />

                        <error :fieldName="'societies'" :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="langs" class="block text-base lg:text-lg">Languages<span
                                class="text-primary">*</span></label>
                        <input type="text" name="langs"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'langs')
                                " :value="form['langs'] ? form['langs'] : ''
                                    " />

                        <!-- <error :fieldName="'langs'" :validationErros="validationErros" /> -->
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`langs`)"
                        v-text="validationErros.get(`langs`)"></p>
                    </div>
                    <!-- <div class="relative z-0 w-full group">
                        <label for="whats_app_number" class="block text-base lg:text-lg">Whats app number</label>
                        <input type="text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'whats_app_number')
                                " :value="form['whats_app_number'] ? form['whats_app_number'] : ''
                            " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`whats_app_number`)"
                            v-text="validationErros.get(`whats_app_number`)"></p>
                    </div> -->
                    <!-- <div class="relative z-0 w-full group">
                        <label for="skype_id" class="block text-base lg:text-lg">Skype</label>
                        <input type="text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'skype_id')
                                " :value="form['skype_id'] ? form['skype_id'] : ''
                            " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`skype_id`)"
                            v-text="validationErros.get(`skype_id`)"></p>
                    </div> -->
                    <!-- <div class="relative z-0 w-full group">
                        <label for="we_chat_number" class="block text-base lg:text-lg">We chat</label>
                        <input type="text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'we_chat_number')
                                " :value="form['we_chat_number'] ? form['we_chat_number'] : ''
                            " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`we_chat_number`)"
                            v-text="validationErros.get(`we_chat_number`)"></p>
                    </div> -->
                    <!-- <div class="relative z-0 w-full group">
                        <label for="viber_number" class="block text-base lg:text-lg">Viber number</label>
                        <input type="text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'viber_number')
                                " :value="form['viber_number'] ? form['viber_number'] : ''
                            " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`viber_number`)"
                            v-text="validationErros.get(`viber_number`)"></p>
                    </div> -->
                    <!-- <div class="relative z-0 w-full group">
                        <label for="imo_number" class="block text-base lg:text-lg">Imo number</label>
                        <input type="text"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'imo_number')
                                " :value="form['imo_number'] ? form['imo_number'] : ''
                            " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`imo_number`)"
                            v-text="validationErros.get(`imo_number`)"></p>
                    </div> -->

                    <div class="w-full mt-4">
                        <label for="" class="block text-base lg:text-lg">Messaging Apps</label>
                      
                            <v-select label="text"  name="messaging_app" v-model="selectedMessagingApps" :options="messagingApps"
                            :reduce="option => option.id" multiple></v-select>

                    </div>
                    <div v-for="appId in selectedMessagingApps" :key="appId" class="w-full mt-4">
                        <label :for="`messaging_app_${appId}`" class="block text-base lg:text-lg">
                            {{ getMessagingAppById(appId).text }} ID
                        </label>
                        <input type="text" :id="`messaging_app_${appId}`" name="messaging_apps"
                            :placeholder="`Enter your ${getMessagingAppById(appId).text} ID`"
                            class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="handleMessagingAppInput($event.target.value, appId)"
                            :value="form['messaging_apps'] && form['messaging_apps'][appId] ? form['messaging_apps'][appId] : ''" />
                        <error :fieldName="`messaging_apps.${appId}`" :validationErros="validationErros" />
                    </div>


                    <div class="relative z-0 w-full group">
                        <label for="mobile_number" class="block text-base lg:text-lg">Mobile number</label>
                        <input type="text" name="mobile_number"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'mobile_number')" :value="form['mobile_number'] ? form['mobile_number'] : ''
                                    " @keypress="restrictToNumbers($event, 15)" />

                        <error :fieldName="'mobile_number'" :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="email" class="block text-base lg:text-lg">Email <span
                                class="text-primary">*</span></label>
                        <input type="text" name="email"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'email')
                                " :value="form['email'] ? form['email'] : ''
                                    " />

                        <!-- <error :fieldName="'email'" :validationErros="validationErros" /> -->
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`email`)"
                        v-text="validationErros.get(`email`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="password" class="block text-base lg:text-lg">Password<span
                                class="text-primary">*</span></label>
                        <input type="text" name="password"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'password')
                                " :value="form['password'] ? form['password'] : ''
                                    " />

                        <!-- <error :fieldName="'password'" :validationErros="validationErros" /> -->
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`password`)"
                        v-text="validationErros.get(`password`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="category" class="block text-base lg:text-lg">Program / Field of study<span
                                class="text-primary">*</span></label>
                        <input type="text" name="category"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'category')
                                " :value="form['category'] ? form['category'] : ''
                                    " />

                        <!-- <error :fieldName="'category'" :validationErros="validationErros" /> -->
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`category`)"
                        v-text="validationErros.get(`category`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="my_major" class="block text-base lg:text-lg">My major</label>
                        <input type="text" name="my_major"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'my_major')
                                " :value="form['my_major'] ? form['my_major'] : ''
                                    " />

                        <!-- <error :fieldName="'my_major'" :validationErros="validationErros" /> -->
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`my_major`)"
                        v-text="validationErros.get(`my_major`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="my_minor" class="block text-base lg:text-lg">My minor</label>
                        <input type="text" name="my_minor"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'my_minor')
                                " :value="form['my_minor'] ? form['my_minor'] : ''
                                    " />

                        <error :fieldName="'my_minor'" :validationErros="validationErros" />
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="status" class="block text-base lg:text-lg">Status<span class="text-primary">*</span></label>
                        <select name="status"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'status')">
                            <option :selected="form['status'] == 'inactive'" value="inactive">
                                Inactive
                            </option>
                            <option :selected="form['status'] == 'active'" value="active">
                                Active
                            </option>
                        </select>

                        <!-- <error :fieldName="'status'" :validationErros="validationErros" /> -->
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`status`)"
                        v-text="validationErros.get(`status`)"></p>
                    </div>
                    <!-- <div class="relative z-0 w-full group">
                        <label for="title" class="block text-base lg:text-lg">This is my work<span
                                class="text-primary">*</span></label>
                                <input type="file"
                                class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                @change="handleAnotherImage($event)" />
                            <error :fieldName="'title'" :validationErros="validationErros" />
                            <div v-if="form['title']" class="mt-2 relative">
                                <img :src="form.image" style="height: 100px; width: 100px" />
                                <button @click="removeImage"
                                    class="absolute top-0 right-0 bg-red-500 text-white rounded-full px-2 py-1 text-xs">
                                    X
                                </button>
                            </div>
                    </div> -->
                    <div class="w-full mt-4">
                        <label class="block text-base lg:text-lg">Image<span class="text-primary">*</span></label>
                        <p class="text-base">
                            Your photo - Optional. 5MB max. Allowed formats: JPG. JPEG, PNG. You may add an avatar if
                            you want
                        </p>
                        <input type="file"
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @change="handleImage($event)" />
                        <!-- <error :fieldName="'image'" :validationErros="validationErros" /> -->
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`image`)"
                        v-text="validationErros.get(`image`)"></p>
                        <!-- <img v-if="form['image']" :src="form?.image ? form.image : ''" style="height: 100px; width: 100px" /> -->
                        <div v-if="form['image']" class="mt-2 relative">
                            <img :src="form.image" style="height: 100px; width: 100px" />
                            <button @click="removeImage"
                                class="absolute top-0 right-0 bg-primary text-white rounded-full px-2 py-1 text-xs">
                                X
                            </button>
                        </div>
                    </div>

                </div>
                <button type="submit" class="can-edu-btn-fill mb-2">
                    Submit
                </button>
            </form>
        </div>
    </AppLayout>
</template>

<script>
import ListErrors from '../components/ListErrors.vue';
// import Error from "../Error.vue";
import { mapState } from "vuex";
import Error from "../../web/Error.vue";
import Select2 from 'vue3-select2-component';
import { toValue } from 'vue';
import vSelect from "vue-select";
import 'vue-select/dist/vue-select.css';
export default {
    components: {
        ListErrors,
        Select2,
        Error,
        vSelect
        // Error
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
            activeTab: "en",
        };
    },
    computed: {
        ...mapState({
            isFormEdit: (state) => state.ambassadors.isFormEdit,
            form: (state) => state.ambassadors.form,
            validationErros: (state) => state.ambassadors.validationErros,
            // languages: (state) => state.languages.languages,
            // languages: (state) => state.ambassadors.form.languages,
            languages: (state) => state.languages.languages,

            schools: (state) => state.schools.schools,
        }),
        sortedMessagingApps() {
            return this.messagingApps.sort((a, b) => {
                return a.text.localeCompare(b.text); // Sorts alphabetically by the 'text' property
            });
        },
    },
    methods: {
        getMessagingAppById(appId) {
            // console.log(this.messagingApps);
            // console.log(appId);
            const app = this.messagingApps.find(app => app.id == appId);
            // console.log("App for ID", appId, ":", app); // Debugging
            return app;
        },
        handleMessagingAppsChange(selectedApps) {
            const previousSelectedApps = this.selectedMessagingApps;

            this.selectedMessagingApps = selectedApps;
console.log(this.selectedMessagingApps);
            // const deselectedApps = previousSelectedApps.filter(appId => !selectedApps.includes(appId));

            deselectedApps.forEach(appId => {
                this.$store.commit('ambassadors/clearMessagingApp', appId);
            });
        },
        changeLanguageTab(language) {
            this.activeTab = language.abbreviation;
        },
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.$store.commit("ambassadors/setForData", {
                    key: "image",
                    value: res?.data,
                });
                if (this.validationErros.has("image")) {
                    this.validationErros.clear("image");
                }
            });
        },
        // handleAnotherImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
        //     var file = new FormData();
        //     file.append("file", e.target.files[0]);
        //     axios.post("/api/web/image_again_upload", file).then((res) => {
        //         this.$store.commit("ambassadors/setForData", {
        //             key: "title",
        //             value: res?.data,
        //         });
        //         if (this.validationErros.has("title")) {
        //             this.validationErros.clear("title");
        //         }
        //     });
        // },
        removeImage() {
            this.$store.commit("ambassadors/setForData", {
                key: "image",
                value: null, // Removes the image
            });
        },
        handleInput(value, key) {

            this.$store.commit("ambassadors/setState", {
                key,
                value,
            });
            if (this.validationErros.has(key) && value !== "") {
                this.validationErros.clear(key);
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
        handleMultipleInput(key, value, language) {
            if (!language?.abbreviation) {
                // console.warn("Language abbreviation is missing!");
                return;
            }
            this.$store.commit("ambassadors/updateState", {
                value: value.trim(),
                id: language.abbreviation,
                key,
            });
            if (value.trim()) {
                this.validationErros.clear(`${key}.${key}_${language.abbreviation}`);
            }
            // console.log(language)
            // console.log(this.$store.state.ambassadors)
        },
        addUpdateForm() {
            // this.$store.commit("ambassadors/setState", {
            //     key: "messaging_apps",
            //     value: {}
            // });
            
            
            this.$store.commit("ambassadors/updateMessageApp", this.selectedMessagingApps);

            this.selectedMessagingApps.map(res => {
                this.handleMessagingAppInput(this.form['messaging_apps'][res] ?? null, res)
            });
            
            this.$store.dispatch("ambassadors/addUpdateForm")
                .then(() => {
                    this.$router.push({ name: "admin.ambassadors.index" });
                })
                .catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.focusOnFirstErrorInput(error.response.data.errors);
                    }
                });
        },

        focusOnFirstErrorInput(errors) {
            // console.log("Errors object:", errors);
            const firstErrorField = Object.keys(errors)[0];
            // console.log("First error field name:", firstErrorField);

            if (!firstErrorField) {
                // console.log("No error field found");
                return;
            }

            const fieldNameParts = firstErrorField.split(".");
            const fieldName = fieldNameParts[0];
            // console.log("Stripped error field name:", fieldName);

            let inputElement = document.querySelector(
                `[name="${fieldName}"], [v-model="${fieldName}"], [data-v-model="${fieldName}"], [data-value="${fieldName}"]`
            );

            if (!inputElement) {
                // console.log(`No standard input field found for ${fieldName}, checking for rich text editor...`);

                const editorId = fieldNameParts[1] || fieldName;
                const tinymceEditor = window.tinymce?.get(editorId);

                if (tinymceEditor) {
                    // console.log(`Focusing on TinyMCE editor: ${editorId}`);
                    tinymceEditor.getBody().scrollIntoView({ behavior: "smooth", block: "center" });

                    setTimeout(() => {
                        tinymceEditor.focus();
                    }, 300);

                    return;
                } else {
                    // console.log(`TinyMCE editor instance not found for ${editorId}`);
                }
            }

            if (inputElement) {
                // console.log("Found input element:", inputElement);
                inputElement.scrollIntoView({ behavior: "smooth", block: "center" });

                setTimeout(() => {
                    inputElement.focus();
                }, 300);

            } else {
                // console.log(`No input field found for ${fieldName}`);
            }
        },
        handleMessagingAppInput(value, appId) {
            this.$store.commit("ambassadors/setState", {
                key: "messaging_apps",
                value: {
                    ...this.form['messaging_apps'],
                    [appId]: value
                }
            });
            if (this.validationErros.has(`messaging_apps.${appId}`)) {
                this.validationErros.clear(`messaging_apps.${appId}`);
            }
        },

        fetchAmbassador() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("ambassadors/setIsFormEdit", true);
                this.$store
                    .dispatch("ambassadors/fetchAmbassador", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}ambassadors/${id}?withSchoolDetail=1&withMessagingApps=1`,
                    })
                    .then((res) => {
                        // console.log('Ambassador Response:', res.data); // Log the response

                        if (res.data.status !== "Success") {
                            // console.error("Error fetching ambassador:", res.data.message);
                            return;
                        }

                        let keys = [
                            "region",
                            "degree_level",
                            "fav_module",
                            "hobies_interests",
                            "societies",
                            "langs",
                            "whats_app_number",
                            "skype_id",
                            "I_study_here",
                            "we_chat_number",
                            "viber_number",
                            "imo_number",
                            "mobile_number",
                            "email",
                            "category",
                            "my_major",
                            "my_minor",
                            "status",
                            "image",
                        ];
                        this.$store.commit("ambassadors/setState", {
                            key: "id",
                            value: id,
                        });
                        for (var i = 0; i < keys.length; i++) {
                            this.$store.commit("ambassadors/setState", {
                                key: keys[i],
                                value: res.data.data[keys[i]],
                            });
                        }

                        // Populate names and about_me fields
                        let data = res.data.data.school_ambassador_detail || [];
                        let nameObj = {};
                        let aboutMeObj = {};
                        data.forEach((item) => {
                            nameObj["name_" + item.language_code] = item.name;
                            aboutMeObj["about_me_" + item.language_code] = item.about_me;
                        });
                        this.$store.commit("ambassadors/setState", {
                            key: "name",
                            value: nameObj,
                        });
                        this.$store.commit("ambassadors/setState", {
                            key: "about_me",
                            value: aboutMeObj,
                        });

                        // Set selected messaging apps based on the fetched data
                        if (res.data.data.messaging_app && res.data.data.messaging_app.length > 0) {
                            // Populate selectedMessagingApps with the IDs of the selected apps
                            this.selectedMessagingApps = res.data.data.messaging_app.map(app => app.messaging_app_id);

                            // Populate form['messaging_app'] with the IDs and usernames
                            const messagingAppData = {};
                            res.data.data.messaging_app.forEach(app => {
                                // console.log(app.username);
                                messagingAppData[app.messaging_app_id] = app.username;
                            });
                            this.$store.commit("ambassadors/setState", {
                                key: "messaging_apps",
                                value: messagingAppData,
                            });
                        } else {
                            // console.warn("No messaging apps found for this ambassador.");
                        }
                    })
                    .catch((error) => {
                        // console.error("Error fetching ambassador:", error);
                    });
            }
        },
    },
    // created() {
    //     this.$store
    //         .dispatch("languages/fetchLanguages", {
    //             url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
    //         })
    //         .then((res) => {
        // console.log('res',res)

    //             let data = res.data.data;
    //             let obj = {};
    //             data.map((res) => {
    //                 obj["name_" + res.abbreviation] = "";
    //             });
    //             this.$store.commit("ambassadors/setState", {
    //                 key: "name",
    //                 value: obj,
    //             });
    //             data.map((res) => {
    //                 obj["about_me_" + res.abbreviation] = "";
    //             });
    //             this.$store.commit("ambassadors/setState", {
    //                 key: "about_me",
    //                 value: obj,
    //             });

    //             if (this.$route.params.id) {
    //                 this.fetchAmbassador();
    //             }

    //         });
    //         axios.get(`${process.env.MIX_ADMIN_API_URL}degree-levels?lang=${this.activeTab}`)
    //         .then(response => {
    //             this.degreeLevels = response.data.data; // Assuming the API returns data in `data` key
    //         })
    //         .catch(error => {
                // console.error("Failed to fetch degree levels:", error);
    //         });
    //         axios.get(`${process.env.MIX_ADMIN_API_URL}messaging_app`)
    //     .then(res => {
    //         res.data.data.map((messaging_app) => {
    //             this.messagingApps.push({
    //                 id: messaging_app.id,
    //                 text: messaging_app?.messaging_app_detail[0].name,
    //             });
    //         });
    //     })
    //     .catch(error => {
            // console.error("Failed to fetch messaging apps:", error);
    //     });
        // console.log('this.form',this.form)
        // console.log('languages', this.languages);
    // },
    created() {
        this.$store.commit("ambassadors/setState", {
            key: "messaging_app",
            value: {},
        });

        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                // console.log('res', res);

                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["name_" + res.abbreviation] = "";
                });
                this.$store.commit("ambassadors/setState", {
                    key: "name",
                    value: obj,
                });
                data.map((res) => {
                    obj["about_me_" + res.abbreviation] = "";
                });
                this.$store.commit("ambassadors/setState", {
                    key: "about_me",
                    value: obj,
                });

                if (this.$route.params.id) {
                    this.fetchAmbassador();
                }
            });

        axios.get(`${process.env.MIX_ADMIN_API_URL}degree-levels?lang=${this.activeTab}`)
            .then(response => {
                this.degreeLevels = response.data.data;
            })
            .catch(error => {
                // console.error("Failed to fetch degree levels:", error);
            });

        axios.get(`${process.env.MIX_ADMIN_API_URL}all_messaging_apps`)
            .then(res => {
                res.data.data.map((messaging_app) => {
                    this.messagingApps.push({
                        id: messaging_app.id,
                        text: messaging_app?.messaging_app_detail[0].name,
                    });
                });
            })
            .catch(error => {
                // console.error("Failed to fetch messaging apps:", error);
            });

        // console.log('this.form', this.form);
        // console.log('languages', this.languages);
    },
};
</script>
