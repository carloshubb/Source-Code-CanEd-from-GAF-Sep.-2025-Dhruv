<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">
                            {{ isFormEdit ? 'Edit' : 'Create' }} curricular activity
                        </h1>
                        <router-link :to="{ name: 'admin.curricular_activities.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <header class="mt-3">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
                            Select language(s) of the curricular activity
                        </p>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                    <ul class="flex gap-2 flex-wrap my-4">
                        <li class="mr-2" v-for="language in languages" :key="language.id">
                            <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                (activeTab == null && language.is_default) ||
                                    activeTab == language.id ?
                                    'text-white bg-primary active' :
                                    '',
                                validationErros.has(`name.name_${language.id}`) ?
                                    'bg-red-600 text-white hover:text-white' :
                                    '',
                            ]">{{ language.name }}</a>
                        </li>
                    </ul>
                </div>

                <div class="grid my-5 md:grid-cols-2 md:gap-6" v-for="language in languages" :key="language.id" :class="(activeTab == null && language.is_default) ||
                    activeTab == language.id ?
                    'block' :
                    'hidden'">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="name" class="block text-base lg:text-lg">Name<span class="text-primary">*</span></label>
                        <input type="text" name="name" id="name"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleMultipleInput(
                                    'name',
                                    $event.target.value,
                                    language
                                )
                                " :value="form['name'] &&
                            form['name'][`name_${language.id}`] ?
                            form['name'][`name_${language.id}`] :
                            ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`name.name_${language.id}`)"
                            v-text="validationErros.get(`name.name_${language.id}`)
                                ">
                        </p>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="status" class="block text-base lg:text-lg">Status<span class="text-primary">*</span></label>
                        <select name="status"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'status')">
                            <option value="">Select</option>
                            <option :selected="form['status'] == '1'" value="1">
                                Active
                            </option>
                            <option :selected="form['status'] == '0'" value="0">
                                Inactive
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`status`)"
                            v-text="validationErros.get(`status`)"></p>
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
import {
    mapState
} from "vuex";
export default {
    components: {
        ListErrors
    },
    computed: {
        ...mapState({
            isFormEdit: (state) => state.curricular_activities.isFormEdit,
            form: (state) => state.curricular_activities.form,
            validationErros: (state) => state.curricular_activities.validationErros,
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
            this.$store.commit("curricular_activities/setState", {
                key,
                value
            });
            if (value.trim()) {
                this.validationErros.clear(key);
            }
        },
        handleMultipleInput(key, value, language) {
            this.$store.commit("curricular_activities/updateState", {
                value: value,
                id: language.id,
                key,
            });
            if (value.trim()) {
                this.validationErros.clear(`name.name_${language.id}`);
            }
        },
        addUpdateForm() {
            this.$store
                .dispatch("curricular_activities/addUpdateForm")
                .then(() => this.$router.push({
                    name: "admin.curricular_activities.index"
                }
            )).catch((error) => {
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
                    tinymceEditor.getBody().scrollIntoView({ behavior: "smooth", block: "center" });

                    setTimeout(() => {
                        tinymceEditor.focus();
                    }, 300);

                    return;
                } else {
                    console.log(`TinyMCE editor instance not found for ${editorId}`);
                }
            }

            if (inputElement) {
                console.log("Found input element:", inputElement);
                inputElement.scrollIntoView({ behavior: "smooth", block: "center" });

                setTimeout(() => {
                    inputElement.focus();
                }, 300);

            } else {
                console.log(`No input field found for ${fieldName}`);
            }
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchCurricularActivities() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;
                console.log('this.id',id)
                
                this.$store.commit("curricular_activities/setIsFormEdit", 1);
                console.log('this.idedit',id)
                this.$store
                    .dispatch("curricular_activities/fetchCurricularActivities", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}curricular_activities/${id}?withCurricularActivityDetail=1`,
                    })
                    .then((res) => {
                        console.log('mainres,res',res)
                        let keys = ['status'];
                        this.$store.commit("curricular_activities/setState", {
                            key: "id",
                            value: id,
                        });
                        for (var i = 0; i < keys.length; i++) {
                            this.$store.commit("curricular_activities/setState", {
                                key: keys[i],
                                value: res.data.data[keys[i]],
                            });
                        }
                        let data =
                            res.data.data && res.data.data.curricular_activity_detail ?
                                res.data.data.curricular_activity_detail : [];
                        let obj = {};
                        data.map((res) => {
                            obj["name_" + res.language_id] = res.name;
                        });
                        this.$store.commit("curricular_activities/setState", {
                            key: "name",
                            value: obj,
                        });
                    });
            }
        }
    },
    created() {
        this.$store.commit("curricular_activities/resetForm");
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
                this.$store.commit("curricular_activities/setState", {
                    key: "name",
                    value: obj,
                });
                this.fetchCurricularActivities();
            });
    }
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
