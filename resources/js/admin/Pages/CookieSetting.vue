<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
        <header class="">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="can-edu-h1">
                        Cookies settings
                    </h1>
                </div>
            </div>
        </header>
        <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
            <div
                class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                <ul class="flex gap-2 flex-wrap my-4">
                    <li class="mr-2" v-for="language in languages" :key="language.id">
                        <a @click.prevent="changeLanguageTab(language)" href="#"
                            :class="[
                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                (activeTab == null &&
                                        language.is_default) ||
                                    activeTab == language.id
                                        ? 'text-white bg-primary active'
                                        : '',
                                    checkValidationError(validationErros, language)
                                        ? 'bg-red-600 text-white hover:text-white'
                                        : '',
                            ]">{{ language . name }}</a>
                    </li>
                </ul>
            </div>
            <div class="my-5 mt-10" v-for="language in languages" :key="language.id"
                :class="(activeTab == null && language.is_default) ||
                language.id == activeTab ?
                    'block' :
                    'hidden'">
                        <div class="grid my-5 md:grid-cols-2 md:gap-6">
                            <div class="relative z-10 w-full group md:col-span-2" v-if="isDataLoaded">
                                <label :for="`text_${language.id}`" class="block text-base lg:text-lg">Text</label>
                                <editor
                                    @selectionChange="
                                        handleSelectionChange(
                                            language,
                                            'text'
                                        )
                                    "
                                    :ref="`text_${language.id}`"
                                    :id="`text_${language.id}`"
                                    :initial-value="form[`text`][`text_${language?.id}`]
                                    "
                                    :init="editorConfig"
                                    :tinymce-script-src="tinymceScriptSrc"
                                />
                                <!-- <input type="text" :name="`text_${language.id}`"
                                    :id="`text_${language.id}`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                    placeholder=" "
                                    @input="
                                        handleInput(
                                            $event.target.value,
                                            language,
                                            'text',
                                            'updatePageSetting'
                                        )
                                    "
                                    :value="form['text'] &&
                                        form['text'][
                                            `text_${language.id}`
                                        ] ?
                                        form['text'][
                                            `text_${language.id}`
                                        ] :
                                        ''" /> -->
                                <p class="mt-2 text-base text-primary"
                                    v-if="
                                        validationErros.has(
                                            `text.text_${language.id}`
                                        )
                                    "
                                    v-text="
                                        validationErros.get(
                                            `text.text_${language.id}`
                                        )
                                    ">
                                </p>
                            </div>
                            <!-- <div class="relative z-10 w-full group">
                                <label :for="`text_${language.id}`" class="block text-base lg:text-lg">Learn more Text</label>
                                <input type="text" :name="`learn_more_text_${language.id}`"
                                    :id="`learn_more_text_${language.id}`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                    placeholder=" "
                                    @input="
                                        handleInput(
                                            $event.target.value,
                                            language,
                                            'learn_more_text',
                                            'updatePageSetting'
                                        )
                                    "
                                    :value="form['learn_more_text'] &&
                                        form['learn_more_text'][
                                            `learn_more_text_${language.id}`
                                        ] ?
                                        form['learn_more_text'][
                                            `learn_more_text_${language.id}`
                                        ] :
                                        ''" />
                                <p class="mt-2 text-base text-primary"
                                    v-if="
                                        validationErros.has(
                                            `learn_more_text.learn_more_text_${language.id}`
                                        )
                                    "
                                    v-text="
                                        validationErros.get(
                                            `learn_more_text.learn_more_text_${language.id}`
                                        )
                                    ">
                                </p>
                            </div> -->
                            <!-- <div class="relative z-10 w-full group">
                                <label :for="`text_${language.id}`" class="block text-base lg:text-lg">Learn More Link</label>
                                <input type="text" :name="`learn_more_link_${language.id}`"
                                    :id="`learn_more_link_${language.id}`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                    placeholder=" "
                                    @input="
                                        handleInput(
                                            $event.target.value,
                                            language,
                                            'learn_more_link',
                                            'updatePageSetting'
                                        )
                                    "
                                    :value="form['learn_more_link'] &&
                                        form['learn_more_link'][
                                            `learn_more_link_${language.id}`
                                        ] ?
                                        form['learn_more_link'][
                                            `learn_more_link_${language.id}`
                                        ] :
                                        ''" />
                                <p class="mt-2 text-base text-primary"
                                    v-if="
                                        validationErros.has(
                                            `learn_more_link.learn_more_link_${language.id}`
                                        )
                                    "
                                    v-text="
                                        validationErros.get(
                                            `learn_more_link.learn_more_link_${language.id}`
                                        )
                                    ">
                                </p>
                            </div> -->
                            <div class="relative z-10 w-full group">
                                <label :for="`text_${language.id}`" class="block text-base lg:text-lg">Button Text</label>
                                <input type="text" :name="`button_text_${language.id}`"
                                    :id="`button_text_${language.id}`"
                                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                    placeholder=" "
                                    @input="
                                        handleInput(
                                            $event.target.value,
                                            language,
                                            'button_text',
                                            'updatePageSetting'
                                        )
                                    "
                                    :value="form['button_text'] &&
                                        form['button_text'][
                                            `button_text_${language.id}`
                                        ] ?
                                        form['button_text'][
                                            `button_text_${language.id}`
                                        ] :
                                        ''" />
                                <p class="mt-2 text-base text-primary"
                                    v-if="
                                        validationErros.has(
                                            `button_text.button_text_${language.id}`
                                        )
                                    "
                                    v-text="
                                        validationErros.get(
                                            `button_text.button_text_${language.id}`
                                        )
                                    ">
                                </p>
                            </div>
                        </div>
                </div>
                <ListErrors :validationErrors="validationErros" />
            <button type="submit"
                class="can-edu-btn-fill mb-2">
                Submit
            </button>
        </form>
    </div>
    </AppLayout>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
    import axios from "axios";
    import ListErrors from '../components/ListErrors.vue';
    import {
        mapState
    } from "vuex";
    export default {
        components:{
            editor: Editor,
            ListErrors
        },
        computed: {
            ...mapState({
                form: (state) => state.cookie_setting.form,
                validationErros: (state) => state.cookie_setting.validationErros,
                languages: (state) => state.languages.languages,
            }),
        },
        data() {
            return {
                activeTab: null,
                isDataLoaded: false,
                editorConfig: {
                    height: 250,
                    menubar: false,
                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen code',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | fullscreen',
                },
                tinymceScriptSrc: "/plugins/tinymce/tinymce.min.js",
            };
        },
        methods: {
            handleInput(value, language, key, mutationName) {
                this.$store.commit(`cookie_setting/${mutationName}`, {
                    value: value,
                    id: language.id,
                    key,
                });
            },
            handleSelectionChange(language, key) {
                console.log(tinymce.get(`${key}_${language.id}`).getContent());
                this.$store.commit(`cookie_setting/updatePageSetting`, {
                    value: tinymce.get(`${key}_${language.id}`).getContent(),
                    id: language.id,
                    key,
                });
            },
            addUpdateForm() {
                this.$store
                    .dispatch("cookie_setting/addUpdateForm")
                    .then((res) => {
                    });
            },
            changeLanguageTab(language) {
                this.activeTab = language.id;
            },
            fetchCookieSetting() {
                this.$store
                    .dispatch("cookie_setting/fetchCookieSetting", {
                        url: `${process.env.MIX_ADMIN_API_URL}cookie-setting`,
                    })
                    .then((res) => {
                        let data =
                            res.data.data && res.data.data.cookie_setting_detail ?
                            res.data.data.cookie_setting_detail : [];
                        let data1 = res.data.data ? res.data.data : {};
                        //welcome settings
                        let obj = {};
                        data.map((res) => {
                            obj["text_" + res.language_id] =
                            res.text;
                        });
                        this.$store.commit("cookie_setting/setPageSetting", {
                            key: "text",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["learn_more_text_" + res.language_id] =
                                res.learn_more_text;
                        });

                        this.$store.commit("cookie_setting/setPageSetting", {
                            key: "learn_more_text",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["learn_more_link_" + res.language_id] =
                                res.learn_more_link;
                        });

                        this.$store.commit("cookie_setting/setPageSetting", {
                            key: "learn_more_link",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["button_text_" + res.language_id] =
                                res.button_text;
                        });

                        this.$store.commit("cookie_setting/setPageSetting", {
                            key: "button_text",
                            value: obj,
                        });

                        this.isDataLoaded = 1;
                    });
                this.$store.dispatch("banners/fetchBanners");
            },
            checkValidationError(validationErros, language) {
                return (
                    validationErros.has(
                        `text.text_${language.id}`
                    ) ||
                    validationErros.has(
                        `learn_more_text.learn_more_text_${language.id}`
                    ) ||
                    validationErros.has(
                        `learn_more_link.learn_more_link_${language.id}`
                    ) ||
                    validationErros.has(
                        `button_text.button_text_${language.id}`
                    ) 
                );
            },
            
        },
        created() {
            this.$store.commit("cookie_setting/resetForm");
            this.$store
                .dispatch("languages/fetchLanguages", {
                    url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
                })
                .then((res) => {
                    let data = res.data.data;
                    let obj = {};
                    data.map((res) => {
                        obj["text_" + res.id] = "";
                    });

                    this.$store.commit("cookie_setting/setPageSetting", {
                        key: "text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["learn_more_text_" + res.id] = "";
                    });

                    this.$store.commit("cookie_setting/setPageSetting", {
                        key: "learn_more_text",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["learn_more_link_" + res.id] = "";
                    });

                    this.$store.commit("cookie_setting/setPageSetting", {
                        key: "learn_more_link",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["button_text_" + res.id] = "";
                    });

                    this.$store.commit("cookie_setting/setPageSetting", {
                        key: "button_text",
                        value: obj,
                    });
                    this.fetchCookieSetting();
                });
        },
    };
</script>
