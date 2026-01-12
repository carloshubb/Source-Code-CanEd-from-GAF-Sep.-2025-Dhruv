<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
        <header class="">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="can-edu-h1">
                        Is logged in modal setting
                    </h1>
                </div>
            </div>
        </header>
        <header class="mt-3">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between">
            <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
              Select language(s) of the modal setting
            </p>
          </div>
        </div>
      </header>
        <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
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
                                ((activeTab == null && language.is_default) ||
                                activeTab == language.id
                                    ? 'text-white bg-primary active'
                                    : '',
                                checkValidationError(validationErros, language)
                                    ? 'bg-red-600 text-white hover:text-white'
                                    : ''),
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
                    (activeTab == null && language.is_default) ||
                    activeTab == language.id
                        ? 'block'
                        : 'hidden'
                "
            >
                <div class="grid my-5 md:grid-cols-2 md:gap-6 mt-8">
                    <div class="relative z-0 w-full group">
                        <label :for="`modal_title_${language.id}`" class="block text-base lg:text-lg">Modal title</label>
                        <input
                            type="text"
                            :name="`modal_title_${language.id}`"
                            :id="`modal_title_${language.id}`"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'modal_title',
                                    'updatePageSetting'
                                )
                            "
                            :value="
                                form['modal_title'] &&
                                form['modal_title'][
                                    `modal_title_${language.id}`
                                ]
                                    ? form['modal_title'][
                                          `modal_title_${language.id}`
                                      ]
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="
                                validationErros.has(
                                    `modal_title.modal_title_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `modal_title.modal_title_${language.id}`
                                )
                            "
                        ></p>
                    </div>

                    <div class="relative z-0 w-full group">
                        <label :for="`login_button_text_${language.id}`" class="block text-base lg:text-lg">Login button text</label>
                        <input
                            type="text"
                            :name="`login_button_text_${language.id}`"
                            :id="`login_button_text_${language.id}`"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'login_button_text',
                                    'updatePageSetting'
                                )
                            "
                            :value="
                                form['login_button_text'] &&
                                form['login_button_text'][
                                    `login_button_text_${language.id}`
                                ]
                                    ? form['login_button_text'][
                                          `login_button_text_${language.id}`
                                      ]
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="
                                validationErros.has(
                                    `login_button_text.login_button_text_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `login_button_text.login_button_text_${language.id}`
                                )
                            "
                        ></p>
                    </div>

                    <div class="relative z-0 w-full mb-6 group">
                        <label :for="`register_button_text_${language.id}`" class="block text-base lg:text-lg">register button text</label>
                        <input
                            type="text"
                            :name="`register_button_text_${language.id}`"
                            :id="`register_button_text_${language.id}`"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'register_button_text',
                                    'updatePageSetting'
                                )
                            "
                            :value="
                                form['register_button_text'] &&
                                form['register_button_text'][
                                    `register_button_text_${language.id}`
                                ]
                                    ? form['register_button_text'][
                                          `register_button_text_${language.id}`
                                      ]
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="
                                validationErros.has(
                                    `register_button_text.register_button_text_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `register_button_text.register_button_text_${language.id}`
                                )
                            "
                        ></p>
                    </div>

                    <div class="relative z-0 w-full group">
                        <label :for="`back_button_text_${language.id}`" class="block text-base lg:text-lg">Back button text</label>
                        <input
                            type="text"
                            :name="`back_button_text_${language.id}`"
                            :id="`back_button_text_${language.id}`"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" "
                            @input="
                                handleInput(
                                    $event.target.value,
                                    language,
                                    'back_button_text',
                                    'updatePageSetting'
                                )
                            "
                            :value="
                                form['back_button_text'] &&
                                form['back_button_text'][
                                    `back_button_text_${language.id}`
                                ]
                                    ? form['back_button_text'][
                                          `back_button_text_${language.id}`
                                      ]
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="
                                validationErros.has(
                                    `back_button_text.back_button_text_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `back_button_text.back_button_text_${language.id}`
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
    props: ["language.id"],
    computed: {
        ...mapState({
            form: (state) => state.is_login_modal_setting.form,
            validationErros: (state) =>
                state.is_login_modal_setting.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            activeTab: null,
            collapseStates: [true, false, false, false, false, false, false],
        };
    },
    methods: {
        handleInput(value, language, key, mutationName) {
            this.$store.commit(`is_login_modal_setting/${mutationName}`, {
                key: key,
                value: value,
                id: language.id,
            });
        },
        addUpdateForm() {
            this.$store
                .dispatch("is_login_modal_setting/addUpdateForm")
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$emit("addUpdateFormParent");
                    }
                });
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchIsLoginModalSetting() {
            this.$store
                .dispatch("is_login_modal_setting/fetchIsLoginModalSetting", {
                    url: `${process.env.MIX_ADMIN_API_URL}is-login-modal-setting`,
                })
                .then((res) => {
                    let data =
                        res.data.data &&
                        res.data.data.is_login_modal_setting_detail
                            ? res.data.data.is_login_modal_setting_detail
                            : [];

                    var obj = {};
                    data.map((res) => {
                        obj["modal_title_" + res.language_id] = res.modal_title;
                    });
                    this.$store.commit(
                        "is_login_modal_setting/setPageSetting",
                        {
                            key: "modal_title",
                            value: obj,
                        }
                    );

                    var obj = {};
                    data.map((res) => {
                        obj["login_button_text_" + res.language_id] =
                            res.login_button_text;
                    });
                    this.$store.commit(
                        "is_login_modal_setting/setPageSetting",
                        {
                            key: "login_button_text",
                            value: obj,
                        }
                    );

                    var obj = {};
                    data.map((res) => {
                        obj["register_button_text_" + res.language_id] =
                            res.register_button_text;
                    });
                    this.$store.commit(
                        "is_login_modal_setting/setPageSetting",
                        {
                            key: "register_button_text",
                            value: obj,
                        }
                    );

                    var obj = {};
                    data.map((res) => {
                        obj["back_button_text_" + res.language_id] =
                            res.back_button_text;
                    });
                    this.$store.commit(
                        "is_login_modal_setting/setPageSetting",
                        {
                            key: "back_button_text",
                            value: obj,
                        }
                    );
                });
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(`modal_title.modal_title_${language.id}`) ||
                validationErros.has(
                    `login_button_text.login_button_text_${language.id}`
                ) ||
                validationErros.has(
                    `register_button_text.register_button_text_${language.id}`
                ) ||
                validationErros.has(
                    `back_button_text.back_button_text_${language.id}`
                )
            );
        },
    },
    created() {
        this.$store.commit("is_login_modal_setting/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["modal_title_" + res.id] = "";
                });
                this.$store.commit("is_login_modal_setting/setPageSetting", {
                    key: "modal_title",
                    value: obj,
                });
                obj = {};
                data.map((res) => {
                    obj["login_button_text_" + res.id] = "";
                });
                this.$store.commit("is_login_modal_setting/setPageSetting", {
                    key: "login_button_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["register_button_text_" + res.id] = "";
                });
                this.$store.commit("is_login_modal_setting/setPageSetting", {
                    key: "register_button_text",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["back_button_text_" + res.id] = "";
                });
                this.$store.commit("is_login_modal_setting/setPageSetting", {
                    key: "back_button_text",
                    value: obj,
                });
                this.fetchIsLoginModalSetting();
            });
    },
};
</script>
