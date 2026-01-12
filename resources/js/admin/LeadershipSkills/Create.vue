<template>
    <AppLayout>
        <header class="py-4 bg-white">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="can-edu-h1">{{isFormEdit ? 'Edit' : 'Create'}} leadership skill</h1>
                    <router-link
                        :to="{ name: 'admin.leadership_skills.index' }"
                        class="can-edu-btn-fill"
                    >
                        Back
                    </router-link>
                </div>
            </div>
        </header>
        <header class="mt-3">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
              Select language(s) of the leadership skill
            </p>
          </div>
        </div>
      </header>
        <form class="py-4 px-4 bg-white" @submit.prevent="addUpdateForm()">
            <div
                class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
            >
                <ul class="flex gap-2 flex-wrap my-4">
                    <li
                        class="mr-2 mb-2"
                        v-for="language in languages"
                        :key="language.id"
                    >
                        <a
                            @click.prevent="changeLanguageTab(language)"
                            href="#"
                            :class="[
                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                (activeTab == null && language.is_default) ||
                                activeTab == language.id
                                    ? 'text-white bg-primary active'
                                    : '',
                                validationErros.has(`name.name_${language.id}`)
                                    ? 'bg-red-600 text-white hover:text-white'
                                    : '',
                            ]"
                            >{{ language.name }}</a
                        >
                    </li>
                </ul>
            </div>

            <div
                class="grid my-5 md:grid-cols-2 md:gap-6"
                v-for="language in languages"
                :key="language.id"
                :class="
                    (activeTab == null && language.is_default) ||
                    activeTab == language.id
                        ? 'block'
                        : 'hidden'
                "
            >
                <div class="relative z-0 w-full mb-6 group">
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        @input="
                            handleMultipleInput(
                                'name',
                                $event.target.value,
                                language
                            )
                        "
                        :value="
                            form['name'] && form['name'][`name_${language.id}`]
                                ? form['name'][`name_${language.id}`]
                                : ''
                        "
                    />
                    <label
                        for="name"
                        class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                        >Name</label
                    >
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has(`name.name_${language.id}`)"
                        v-text="validationErros.get(`name.name_${language.id}`)"
                    ></p>
                </div>
            </div>
            <div class="grid my-5 md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <select
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        @input="handleInput($event.target.value, 'status')"
                    >
                        <option value="">Select</option>
                        <option :selected="form['status'] == '1'" value="1">
                            Active
                        </option>
                        <option :selected="form['status'] == '0'" value="0">
                            Inactive
                        </option>
                    </select>
                    <label
                        for="status"
                        class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                        >Status</label
                    >
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has(`status`)"
                        v-text="validationErros.get(`status`)"
                    ></p>
                </div>
            </div>
            <ListErrors :validationErrors="validationErros" />
            <button
                type="submit"
                class="can-edu-btn-fill"
            >
                Submit
            </button>
        </form>
    </AppLayout>
</template>

<script>
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
    components:{
    ListErrors
},
    computed: {
        ...mapState({
            isFormEdit: (state) => state.leadership_skills.isFormEdit,
            form: (state) => state.leadership_skills.form,
            validationErros: (state) => state.leadership_skills.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            activeTab: null,
        };
    },
    methods: {
        handleInput(value, key) {
            this.$store.commit("leadership_skills/setState", {
                key,
                value,
            });
        },
        handleMultipleInput(key, value, language) {
            this.$store.commit("leadership_skills/updateState", {
                value: value,
                id: language.id,
                key,
            });
        },
        addUpdateForm() {
            this.$store.dispatch("leadership_skills/addUpdateForm").then(() =>
                this.$router.push({
                    name: "admin.leadership_skills.index",
                })
            );
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchLeadershipSkills() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("leadership_skills/setIsFormEdit", 1);
                this.$store
                    .dispatch("leadership_skills/fetchLeadershipSkills", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}leadership_skills/${id}?withSportDetail=1`,
                    })
                    .then((res) => {
                        let keys = ["status"];
                        this.$store.commit("leadership_skills/setState", {
                            key: "id",
                            value: id,
                        });
                        for (var i = 0; i < keys.length; i++) {
                            this.$store.commit("leadership_skills/setState", {
                                key: keys[i],
                                value: res.data.data[keys[i]],
                            });
                        }
                        let data =
                            res.data.data && res.data.data.sport_detail
                                ? res.data.data.sport_detail
                                : [];
                        let obj = {};
                        data.map((res) => {
                            obj["name_" + res.language_id] = res.name;
                        });
                        this.$store.commit("leadership_skills/setState", {
                            key: "name",
                            value: obj,
                        });
                    });
            }
        },
    },
    created() {
        this.$store.commit("leadership_skills/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["name_" + res.id] = "";
                });
                this.$store.commit("leadership_skills/setState", {
                    key: "name",
                    value: obj,
                });
                this.fetchLeadershipSkills();
            });
    },
};
</script>

<style scoped>
/**
 * FilePond Custom Styles
 */
.filepond--drop-label {
    color: #4c4e53;
}

.filepond--label-action {
    text-decoration-color: #babdc0;
}

.filepond--panel-root {
    border-radius: 2em;
    background-color: #edf0f4;
    height: 1em;
}

.filepond--item-panel {
    background-color: #595e68;
}

.filepond--drip-blob {
    background-color: #7f8a9a;
}
</style>
