<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h3 class="can-edu-h1 text-primary">
                            {{
                                static_translation
                                    ? static_translation.display_text
                                    : "Edit setting"
                            }}
                        </h3>
                    </div>
                </div>
            </header>
            <header class="mt-3">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
              Select language(s) of the {{ static_translation?.display_text ||"setting"}}
            </p>
          </div>
        </div>
      </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200"
                >
                    <ul class="flex flex-wrap mb-2 overflow-x-auto gap-1 py-3">
                        <li
                            class="mr-2"
                            v-for="language in languages"
                            :key="language.id"
                        >
                            <a
                                @click.prevent="
                                    selectedLanguageId = language.id
                                "
                                href="#"
                                :class="[
                                    'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                    (selectedLanguageId == null &&
                                        language.is_default) ||
                                    selectedLanguageId == language.id
                                        ? 'text-white bg-primary active'
                                        : '',
                                    validationErros.has(
                                        `${setting?.key}.${setting?.key}_${language.id}`
                                    )
                                        ? 'bg-red-600 text-white hover:text-white'
                                        : '',
                                ]"
                                >{{ language.name }}</a
                            >
                        </li>
                    </ul>
                </div>
                <div
                    class="my-5"
                    v-for="language in languages"
                    :key="language.id"
                    :class="
                        (selectedLanguageId == null && language.is_default) ||
                        language.id == selectedLanguageId
                            ? 'block'
                            : 'hidden'
                    "
                >
                    <div
                        v-if="
                            static_translation &&
                            static_translation.static_translation_detail
                        "
                        class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"
                    >
                        <div
                            class="relative z-0 w-full group"
                            v-for="setting in staticTranslationByLang(language)"
                            :key="setting.id"
                        >
                            <label class="block text-base lg:text-lg" :for="`${setting.key}_${language.id}`">{{
                                setting.display_text
                            }}</label>
                            <input
                                type="text"
                                :name="`${setting.key}_${language.id}`"
                                :id="`${setting.key}_${language.id}`"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        setting.key,
                                        'updateForm'
                                    )
                                "
                                :value="
                                    form[setting.key] &&
                                    form[setting.key][
                                        `${setting.key}_${language.id}`
                                    ]
                                        ? form[setting.key][
                                              `${setting.key}_${language.id}`
                                          ]
                                        : ''
                                "
                            />
                            <p
                                class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has(
                                        `${setting.key}.${setting.key}_${selectedLanguageId}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `${setting.key}.${setting.key}_${selectedLanguageId}`
                                    )
                                "
                            ></p>
                        </div>
                    </div>
                </div>
                <ListErrors :validationErrors="validationErros" />
                <button
                    type="submit"
                    class="can-edu-btn-fill mb-2"
                    :disabled="loading"
                >
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
    components:{
    ListErrors
},
    computed: {
        ...mapState({
            loading: (state) => state.static_translation.loading,
            form: (state) => state.static_translation.form,
            static_translation: (state) =>
                state.static_translation.static_translation,
            validationErros: (state) =>
                state.static_translation.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            selectedLanguageId: null,
        };
    },
    methods: {
        handleInput(value, language, key, mutationName) {
            this.$store.commit(`static_translation/${mutationName}`, {
                value: value,
                id: language.id,
                key,
            });
        },
        addUpdateForm() {
            this.$store.dispatch("static_translation/addUpdateForm");
        },
        staticTranslationByLang(language) {
            let trans = this.static_translation.static_translation_detail;
            if (
                trans.filter((res) => res.language_id == language.id).length > 0
            ) {
                return trans.filter((res) => res.language_id == language.id);
            } else {
                return trans.filter(
                    (res) => res.language_id == this.selectedLanguageId
                );
            }
        },
        fetchSettings(parameter) {
            this.$store.commit("static_translation/resetForm");
            this.$store.commit("static_translation/setForm", {
                key: "type",
                value: parameter,
            });
            this.$store
                .dispatch("languages/fetchLanguages", {
                    url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
                })
                .then((res) => {
                    let languages = res.data.data;
                    languages.map((res, i) => {
                        if (res.is_default == "1") {
                            this.selectedLanguageId = res.id;
                        }
                    });
                    this.$store
                        .dispatch("static_translation/fetchStaticTranslation", {
                            url: `${process.env.MIX_ADMIN_API_URL}static-translation?findByType=${parameter}&withStaticTranslationDetail=1&createStaticTranslationDetail=1`,
                        })
                        .then((response) => {
                            let data =
                                response.data.data &&
                                response.data.data.static_translation_detail
                                    ? response.data.data
                                          .static_translation_detail
                                    : [];
                            data.map((res) => {
                                let obj = {};
                                obj[`${res.key}_${res.language_id}`] =
                                    res.value;
                                this.$store.commit(
                                    "static_translation/updateForm",
                                    {
                                        key: res.key,
                                        value: res.value,
                                        id: res.language_id,
                                    }
                                );
                            });
                        });
                });
        },
    },
    created() {
        this.fetchSettings(this.$route.params.type);
    },
    watch: {
        $route(to, from) {
            const type = to.params.type;
            this.fetchSettings(type);
        },
    },
};
</script>
