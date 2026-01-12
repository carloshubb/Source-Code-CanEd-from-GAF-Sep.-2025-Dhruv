<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">
                            {{ isFormEdit ? 'Edit' : 'Create' }} Activity
                        </h1>
                        <router-link :to="{ name: 'admin.activities.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <header class="mt-3">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <p class="block text-base lg:text-lg font-FuturaMdCnBT text-primary">
                            Select language(s) of the activity
                        </p>
                    </div>
                </div>
            </header>
            
            <div class="ml-5 text-sm font-medium text-center text-gray-500 border-b border-gray-200">
                <ul class="flex gap-2 flex-wrap my-4">
                    <li class="mr-2" v-for="language in languages" :key="language.id">
                        <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                            'inline-block py-2 px-4 text-primary border border-primary rounded font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                            (activeTab == null && language.is_default) || activeTab == language.id 
                                ? 'text-white bg-primary active' 
                                : '',
                            validationErros.has(`name.name_${language.id}`) 
                                ? 'bg-red-600 text-white hover:text-white' 
                                : '',
                        ]">
                            {{ language.name }}
                        </a>
                    </li>
                </ul>
            </div>
            
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="type" class="block text-base lg:text-lg">Activity Type<span class="text-primary">*</span></label>
                        <select 
                            id="type"
                            name="type"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'type')"
                            :disabled="isFormEdit"
                        >
                            <option value="">Select Activity Type</option>
                            <option 
                                v-for="(typeName, typeValue) in activityTypes" 
                                :key="typeValue"
                                :value="typeValue"
                                :selected="form.type === typeValue"
                            >
                                {{ typeName }}
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('type')">
                            {{ validationErros.get('type') }}
                        </p>
                    </div>
                    
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="status" class="block text-base lg:text-lg">Status<span class="text-primary">*</span></label>
                        <select 
                            name="status"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'status')"
                        >
                            <option value="">Select</option>
                            <option :selected="form.status === '1'" value="1">Active</option>
                            <option :selected="form.status === '0'" value="0">Inactive</option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('status')">
                            {{ validationErros.get('status') }}
                        </p>
                    </div>
                </div>
                
              

                <div 
                    class="grid my-5 md:grid-cols-2 md:gap-6" 
                    v-for="language in languages" 
                    :key="language.id" 
                    :class="(activeTab == null && language.is_default) || activeTab == language.id ? 'block' : 'hidden'"
                >
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="name" class="block text-base lg:text-lg">Name<span class="text-primary">*</span></label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " 
                            @input="handleMultipleInput('name', $event.target.value, language)"
                            :value="form.name && form.name[`name_${language.id}`] ? form.name[`name_${language.id}`] : ''"
                        />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`name.name_${language.id}`)">
                            {{ validationErros.get(`name.name_${language.id}`) }}
                        </p>
                    </div>
                </div>
                
                <ListErrors :validationErrors="validationErros" />
                <button type="submit" class="can-edu-btn-fill mb-2">
                    Submit
                </button>
            </form>
        </div>
    </AppLayout>
</template>

<script>
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";

export default {
    components: {
        ListErrors
    },
    computed: {
        ...mapState({
            isFormEdit: (state) => state.activities.isFormEdit,
            form: (state) => state.activities.form,
            validationErros: (state) => state.activities.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            activeTab: null,
            activityTypes: {
                'curricular': 'Curricular Activities',
                'extracurricular': 'Extracurricular Activities',
                'leadership': 'Leadership',
                'media': 'Media',
                'music_performance': 'Music & Performance',
                'social_activism': 'Social Activism',
                'technology': 'Technology',
                'entrepreneurship': 'Entrepreneurship',
                'environmental': 'Environmental & Sustainability',
                'health_wellness': 'Health & Wellness',
                'stem_competitions': 'STEM competitions'
            }
        };
    },
    methods: {
        handleInput(value, key) {
            this.$store.commit("activities/setState", { key, value });
            if (value.trim()) {
                this.validationErros.clear(key);
            }
        },
        handleMultipleInput(key, value, language) {
            this.$store.commit("activities/updateState", {
                value: value,
                id: language.id,
                key,
            });
            if (value.trim()) {
                this.validationErros.clear(`name.name_${language.id}`);
            }
        },
        addUpdateForm() {
            this.$store.dispatch("activities/addUpdateForm")
                .then(() => {
                    this.$router.push({ name: "admin.activities.index" });
                })
                .catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.focusOnFirstErrorInput(error.response.data.errors);
                    }
                });
        },
        focusOnFirstErrorInput(errors) {
            const firstErrorField = Object.keys(errors)[0];
            if (!firstErrorField) return;

            const inputElement = document.querySelector(`[name="${firstErrorField.split('.')[0]}"]`);
            if (inputElement) {
                inputElement.scrollIntoView({ behavior: "smooth", block: "center" });
                setTimeout(() => inputElement.focus(), 300);
            }
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchActivity() {
            if (this.$route.params.id) {
                this.$store.commit("activities/setIsFormEdit", true);
                this.$store.dispatch("activities/fetchActivity", {
                    id: this.$route.params.id,
                });
            }
        }
    },
    created() {
        this.$store.commit("activities/resetForm");
        this.$store.dispatch("activities/fetchActivityTypes");
        
        Promise.all([
            this.$store.dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            }),
        ]).then(() => {
            // Initialize name object for all languages
            let nameObj = {};
            this.languages.forEach(lang => {
                nameObj[`name_${lang.id}`] = "";
            });
            this.$store.commit("activities/setState", { key: "name", value: nameObj });
            
            this.fetchActivity();
        });
    }
};
</script>