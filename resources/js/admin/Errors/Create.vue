<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center justify-between gap-2 bg-white dark:bg-gray-800">
                    <div class="sm:flex-auto">
                    <h1 class="can-edu-h1">Error messages</h1>
                    </div>
                </div>
                <form class="mt-4" @submit.prevent="addUpdateForm()">
                        <div>
                        <!-- <div class="sm:hidden">
                            <label for="tabs" class="sr-only">Select a tab</label> -->
                            <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                            <!-- <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option selected>My Account</option>

                            <option>Company</option>

                            <option>Team Members</option>

                            <option>Billing</option>
                            </select>
                        </div> -->
                        <div class="inline-flex mb-8">
                            <nav class="isolate flex flex-wrap" aria-label="Tabs">
                            <!-- Current: "text-gray-900", Default: "text-gray-500 hover:text-gray-700" -->
                                <div class="mr-2 mb-2" v-for="languageError in languageErrors" :key="languageError.id">
                                    <a @click.prevent="changeLanguageTab(languageError)" href="#" :class="[((activeTab == null && languageError.is_default == '1') || activeTab == languageError.id ? 'inline-block py-2 px-4 text-white border border-primary rounded  font-FuturaMdCnBT text-lg font-medium bg-primary' : 'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary'), (validationErros.has(`name.name_${languageError.id}`) ? 'bg-red text-white hover:text-white' : '')]">
                                        <span>{{languageError.name}}</span>
                                        <span aria-hidden="true" class="bg-primary h-0.5" v-if="(activeTab == null && languageError.is_default == '1') || activeTab == languageError.id"></span>
                                        <span aria-hidden="true" class="bg-transparent h-0.5" v-else></span>
                                        <span aria-hidden="true" class="bg-red-500 h-0.5" v-if="(validationErros.has(`name.name_${languageError.id}`))"></span>
                                    </a>
                                </div>
                            </nav>
                        </div>
                        </div>


                        <!-- <ul class="flex flex-wrap -mb-px">
                            <li class="mr-2" v-for="languageError in languageErrors" :key="languageError.id">
                                <a @click.prevent="changeLanguageTab(languageError)" href="#" :class="['inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300', ((activeTab == null && languageError.is_default == '1') || activeTab == languageError.id ? 'text-primary border-blue-600 active dark:text-blue-500 dark:border-blue-500' : ''), (validationErros.has(`name.name_${languageError.id}`) ? 'bg-red text-white hover:text-white' : '')]">{{languageError.name}}</a>
                            </li>
                        </ul> -->


                    <div class="grid my-5 md:grid-cols-2 md:gap-6" v-for="languageError in languageErrors" :key="languageError.id" :class="(activeTab == null && languageError.is_default == '1') || activeTab == languageError.id ? 'block' : 'hidden' ">
                        <template v-for="(validation, index) in languageError.validation">
                            <div class="relative z-0 w-full group" v-for="(v, i) in validation" :key="`${i}v`" v-if="typeof validation === 'object'">
                                <label for="name" class="block text-base lg:text-lg">{{i}}</label>
                                <input type="text" name="name" id="name" class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary" placeholder=" " :value="v" @blur="updateError(languageError, i, $event.target.value)" />
                            </div>
                            <div class="relative z-0 w-full group" :key="index" v-else>
                                <label for="name" class="block text-base lg:text-lg">{{index}}</label>
                                <input type="text" name="name" id="name" class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary" placeholder=" " :value="validation" @blur="updateError(languageError, index, $event.target.value)" />
                            </div>
                        </template>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script>
    import { mapState } from 'vuex'
    export default {
        computed:{
            ...mapState({
                validationErros: state => state.errors.validationErros,
                languageErrors: state => state.errors.languageErrors,
            }),
        },
        data(){
            return {
                activeTab: null,
            }
        },
        methods: {
            addUpdateForm(){
                this.$store.dispatch('errors/addUpdateForm')
                .then(() => this.$router.push({name: 'admin.errors.index'}));
            },
            updateError(language, field, value){
                if(value == ''){
                    helper.swalErrorMessage(`The ${field} field is required.`);
                    return;
                }
                else if(!value.includes(':attribute')){
                    helper.swalErrorMessage(`The ${field} must contains :attribute.`);
                    return;
                }
                this.$store.dispatch('errors/addUpdateForm',{
                    'language_id':language.id,
                    'field':field,
                    'value':value,
                });
            },
            changeLanguageTab(language){
                this.activeTab = language.id;
            },
            fetchLanguageErrors(){
                this.$store.dispatch('errors/fetchLanguageErrors');
            }
        },
        created(){
            this.$store.commit('errors/setEmptyError');
            this.$store.commit('errors/setError');
            this.fetchLanguageErrors();
        }
    };
</script>