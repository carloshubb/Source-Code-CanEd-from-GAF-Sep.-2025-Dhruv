<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1"> {{ isFormEdit ? 'Edit' : 'Create' }} school type </h1>
                        <router-link :to="{ name: 'admin.school_types.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <header class="mt-3">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
                            Select language(s) of the school type
                        </p>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                    <ul class="flex gap-2 flex-wrap my-4">
                        <li class="mr-2" v-for="language in languages" :key="language.id">
                            <a @click.prevent="changeLanguageTab(language)" href="#"
                                :class="['inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary', ((activeTab == null && language.is_default) || activeTab == language.id ? 'text-white bg-primary active' : ''), (validationErros.has(`name.name_${language.id}`) ? 'bg-red-600 text-white hover:text-white' : '')]">{{ language.name }}</a>
                        </li>
                    </ul>
                </div>

                <div class="grid my-5 md:grid-cols-2 md:gap-6" v-for="language in languages" :key="language.id"
                    :class="(activeTab == null && language.is_default) || activeTab == language.id ? 'block' : 'hidden'">
                    <div class="relative z-0 w-full group">
                        <label for="name" class="block text-base lg:text-lg">Name<span class="text-primary">*</span></label>
                        <input type="text" name="name" id="name"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleNameInput($event.target.value, language)"
                            :value="form['name'] && form['name'][`name_${language.id}`] ? form['name'][`name_${language.id}`] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`name.name_${language.id}`)"
                            v-text="validationErros.get(`name.name_${language.id}`)"></p>
                    </div>
                </div>
                <ListErrors :validationErrors="validationErros" />
                <button type="submit" class="can-edu-btn-fill mb-2">Submit</button>
            </form>
        </div>

    </AppLayout>
</template>

<script>
import ListErrors from '../components/ListErrors.vue';
import { mapState } from 'vuex'
export default {
    components: {
        ListErrors
    },
    computed: {
        ...mapState({
            isFormEdit: state => state.school_types.isFormEdit,
            form: state => state.school_types.form,
            validationErros: state => state.school_types.validationErros,
            languages: state => state.languages.languages,
        }),
    },
    data() {
        return {
            activeTab: null,
        }
    },
    methods: {
        handleNameInput(value, language) {
            this.$store.commit('school_types/updateName', {
                'name': value.trim(),
                'id': language.id,
            });
            if (value.trim()) {
                this.validationErros.clear(`name.name_${language.id}`);
            }
        },
        addUpdateForm() {
            this.$store.dispatch('school_types/addUpdateForm')
                .then(() => this.$router.push({ name: 'admin.school_types.index' }));
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchSchoolTypes() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;


                this.$store.commit('school_types/setIsFormEdit', 1);
                this.$store.dispatch('school_types/fetchSchoolTypes', {
                    id: id,
                    url: `${process.env.MIX_ADMIN_API_URL}school_types/${id}?withSchoolTypeDetail=1`
                }).then(res => {
                    this.$store.commit('school_types/setForm', { id });
                    let data = res.data.data && res.data.data.school_type_detail ? res.data.data.school_type_detail : [];
                    let obj = {};
                    data.map(res => {
                        obj['name_' + res.language_id] = res.name;
                    });
                    this.$store.commit('school_types/setName', obj);

                });
            }
        }
    },
    created() {
        this.$store.commit('school_types/resetForm');
        this.$store.dispatch('languages/fetchLanguages', {
            url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`
        }).then(res => {
            let data = res.data.data;
            let obj = {};
            data.map(res => {
                obj['name_' + res.id] = '';
            });
            this.$store.commit('school_types/setName', obj);
            this.fetchSchoolTypes();
        });
    }
};
</script>
