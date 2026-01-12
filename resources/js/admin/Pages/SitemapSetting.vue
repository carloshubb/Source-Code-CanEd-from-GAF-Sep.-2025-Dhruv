<template>
    <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
        <!-- <div
                class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                <ul class="flex gap-2 flex-wrap my-4">
                    <li class="mr-2" v-for="language in languages" :key="language.id">
                        <a @click.prevent="changeLanguageTab(language)" href="#"
                            :class="[
                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                ((activeTab == null && language.is_default) ||
                                    activeTab == language.id ?
                                    'text-white bg-primary active' :
                                    '',
                                    checkValidationError(validationErros, language) ?
                                    'bg-red-600 text-white hover:text-white' :
                                    ''),
                            ]">{{ language . name }}</a>
                    </li>
                </ul>
            </div> -->
        <div
            class="my-5"
            v-for="language in languages"
            :key="language.id"
            :class="
                (selectedLanguage == null && language.is_default) ||
                language.id == selectedLanguage
                    ? 'block'
                    : 'hidden'
            "
        >
            <div
                class="border rounded w-full"
                :class="collapseStates[0] ? 'bg-gray-50' : ''"
            >
                <div
                    class="flex justify-between bg-primary text-white p-4 cursor-pointer"
                    @click.prevent="collapseStates[0] = !collapseStates[0]"
                >
                    <h2 class="text-lg font-medium">Section 1</h2>
                    <svg
                        class="w-5 h-5 fill-current text-gray-500"
                        viewBox="0 0 20 20"
                    >
                        <path d="M6 9l4 4 4-4"></path>
                    </svg>
                </div>
                <div
                    class="p-4 bg-gray-100 border-t"
                    v-show="collapseStates[0]"
                >
                    <div class="grid my-5 md:grid-cols-2 md:gap-6">
                        <div class="relative z-10 w-full mb-6 group">
                            <input
                                type="text"
                                :name="`section_1_title_${selectedLanguage}`"
                                :id="`section_1_title_${selectedLanguage}`"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'section_1_title',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['section_1_title'] &&
                                    form['section_1_title'][
                                        `section_1_title_${selectedLanguage}`
                                    ]
                                        ? form['section_1_title'][
                                              `section_1_title_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                            />
                            <label
                                :for="`section_1_title_${selectedLanguage}`"
                                class="peer-focus:font-medium absolute text-base text-gray-700 font-medium duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                                >Section 1 title</label
                            >
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `section_1_title.section_1_title_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `section_1_title.section_1_title_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                        <div
                            class="relative w-full mb-6 group"
                            v-if="sortedMenus?.length > 0"
                        >
                            <label class="text-gray-700 font-semibold text-sm lg:text-base">Menu items</label>
                            <v-select
                                v-model="menu1"
                                :options="sortedMenus"
                                label="name"
                                multiple
                                taggable
                            >
                            </v-select>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="border rounded w-full"
                :class="collapseStates[1] ? 'bg-gray-50' : ''"
            >
                <div
                    class="flex justify-between bg-primary text-white p-4 cursor-pointer"
                    @click.prevent="collapseStates[1] = !collapseStates[1]"
                >
                    <h2 class="text-lg font-medium">Section 2</h2>
                    <svg
                        class="w-5 h-5 fill-current text-gray-500"
                        viewBox="0 0 20 20"
                    >
                        <path d="M6 9l4 4 4-4"></path>
                    </svg>
                </div>
                <div
                    class="p-4 bg-gray-100 border-t"
                    v-show="collapseStates[1]"
                >
                    <div class="grid my-5 md:grid-cols-2 md:gap-6">
                        <div class="relative z-10 w-full mb-6 group">
                            <input
                                type="text"
                                :name="`section_2_title_${selectedLanguage}`"
                                :id="`section_2_title_${selectedLanguage}`"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'section_2_title',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['section_2_title'] &&
                                    form['section_2_title'][
                                        `section_2_title_${selectedLanguage}`
                                    ]
                                        ? form['section_2_title'][
                                              `section_2_title_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                            />
                            <label
                                :for="`section_2_title_${selectedLanguage}`"
                                class="peer-focus:font-medium absolute text-base text-gray-700 font-medium duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                                >Section 2 title</label
                            >
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `section_2_title.section_2_title_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `section_2_title.section_2_title_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                        <div
                            class="relative w-full mb-6 group"
                            v-if="sortedMenus?.length > 0"
                        >
                            <label class="text-gray-700 font-semibold text-sm lg:text-base">Menu items</label>
                            <v-select
                                v-model="menu2"
                                :options="sortedMenus"
                                label="name"
                                multiple
                                taggable
                            >
                            </v-select>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="border rounded w-full"
                :class="collapseStates[2] ? 'bg-gray-50' : ''"
            >
                <div
                    class="flex justify-between bg-primary text-white p-4 cursor-pointer"
                    @click.prevent="collapseStates[2] = !collapseStates[2]"
                >
                    <h2 class="text-lg font-medium">Section 3</h2>
                    <svg
                        class="w-5 h-5 fill-current text-gray-500"
                        viewBox="0 0 20 20"
                    >
                        <path d="M6 9l4 4 4-4"></path>
                    </svg>
                </div>
                <div
                    class="p-4 bg-gray-100 border-t"
                    v-show="collapseStates[2]"
                >
                    <div class="grid my-5 md:grid-cols-2 md:gap-6">
                        <div class="relative z-10 w-full mb-6 group">
                            <input
                                type="text"
                                :name="`section_3_title_${selectedLanguage}`"
                                :id="`section_3_title_${selectedLanguage}`"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'section_3_title',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['section_3_title'] &&
                                    form['section_3_title'][
                                        `section_3_title_${selectedLanguage}`
                                    ]
                                        ? form['section_3_title'][
                                              `section_3_title_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                            />
                            <label
                                :for="`section_3_title_${selectedLanguage}`"
                                class="peer-focus:font-medium absolute text-base text-gray-700 font-medium duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                                >Section 3 title</label
                            >
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `section_3_title.section_3_title_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `section_3_title.section_3_title_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                        <div
                            class="relative w-full mb-6 group"
                            v-if="sortedMenus?.length > 0"
                        >
                            <label class="text-gray-700 font-semibold text-sm lg:text-base">Menu items</label>
                            <v-select
                                v-model="menu3"
                                :options="sortedMenus"
                                label="name"
                                multiple
                                taggable
                            >
                            </v-select>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="border rounded w-full"
                :class="collapseStates[3] ? 'bg-gray-50' : ''"
            >
                <div
                    class="flex justify-between bg-primary text-white p-4 cursor-pointer"
                    @click.prevent="collapseStates[3] = !collapseStates[3]"
                >
                    <h2 class="text-lg font-medium">Section 4</h2>
                    <svg
                        class="w-5 h-5 fill-current text-gray-500"
                        viewBox="0 0 20 20"
                    >
                        <path d="M6 9l4 4 4-4"></path>
                    </svg>
                </div>
                <div
                    class="p-4 bg-gray-100 border-t"
                    v-show="collapseStates[3]"
                >
                    <div class="grid my-5 md:grid-cols-2 md:gap-6">
                        <div class="relative z-10 w-full mb-6 group">
                            <input
                                type="text"
                                :name="`section_4_title_${selectedLanguage}`"
                                :id="`section_4_title_${selectedLanguage}`"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" "
                                @input="
                                    handleInput(
                                        $event.target.value,
                                        language,
                                        'section_4_title',
                                        'updatePageSetting'
                                    )
                                "
                                :value="
                                    form['section_4_title'] &&
                                    form['section_4_title'][
                                        `section_4_title_${selectedLanguage}`
                                    ]
                                        ? form['section_4_title'][
                                              `section_4_title_${selectedLanguage}`
                                          ]
                                        : ''
                                "
                            />
                            <label
                                :for="`section_4_title_${selectedLanguage}`"
                                class="peer-focus:font-medium absolute text-base text-gray-700 font-medium duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                                >Section 4 title</label
                            >
                            <p
                                class="mt-2 text-base text-primary"
                                v-if="
                                    validationErros.has(
                                        `section_4_title.section_4_title_${selectedLanguage}`
                                    )
                                "
                                v-text="
                                    validationErros.get(
                                        `section_4_title.section_4_title_${selectedLanguage}`
                                    )
                                "
                            ></p>
                        </div>
                        <div
                            class="relative w-full mb-6 group"
                            v-if="sortedMenus?.length > 0"
                        >
                            <label class="text-gray-700 font-semibold text-sm lg:text-base">Menu items</label>
                            <v-select
                                v-model="menu4"
                                :options="sortedMenus"
                                label="name"
                                multiple
                                taggable
                            >
                            </v-select>
                        </div>
                    </div>
                </div>
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
</template>

<script>
import axios from "axios";
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
export default {
    props: ["selectedLanguage"],
    components: {
        vSelect,
        ListErrors
    },
    computed: {
        ...mapState({
            form: (state) => state.sitemap_setting.form,
            validationErros: (state) => state.sitemap_setting.validationErros,
            languages: (state) => state.languages.languages,
            banners: (state) => state.banners.banners,
            menus: (state) => state.menus.menus,
        }),
    },
    data() {
        return {
            activeTab: null,
            collapseStates: [true, false, false, false, false, false, false],
            sortedMenus: [],
            menu1: [],
            menu2: [],
            menu3: [],
            menu4: [],
        };
    },
    methods: {
        handleInput1(value, key) {
            this.$store.commit(`sitemap_setting/setPageSetting`, {
                value: value,
                key,
            });
        },
        handleInput(value, language, key, mutationName) {
            this.$store.commit(`sitemap_setting/${mutationName}`, {
                value: value,
                id: this.selectedLanguage,
                key,
            });
        },
        handleImage(e, key) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios
                .post("/api/admin/media/image_again_upload", file)
                .then((res) => {
                    this.$store.commit(`sitemap_setting/setPageSetting`, {
                        value: res?.data,
                        key,
                    });
                });
        },
        addUpdateForm() {
            this.$store
                .dispatch("sitemap_setting/addUpdateForm", {
                    menu1: this.menu1,
                    menu2: this.menu2,
                    menu3: this.menu3,
                    menu4: this.menu4,
                })
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.$emit("addUpdateFormParent");
                    }
                });
        },
        changeLanguageTab(language) {
            this.activeTab = this.selectedLanguage;
        },
        fetchSitemapSetting() {
            this.$store
                .dispatch("sitemap_setting/fetchSitemapSetting", {
                    url: `${process.env.MIX_ADMIN_API_URL}sitemap-setting`,
                })
                .then((res) => {
                    let data =
                        res.data.data && res.data.data.sitemap_setting_detail
                            ? res.data.data.sitemap_setting_detail
                            : [];
                    let data1 = res.data.data ? res.data.data : {};
                    let menu_1 = [];
                    for (var i = 0; i < data1?.menu_1.length; i++) {
                        menu_1.push({
                            id: data1?.menu_1[i]?.menu?.id,
                            name: data1?.menu_1[i]?.menu?.menu_detail[0]?.name,
                        });
                    }
                    this.menu1 = menu_1;

                    let menu_2 = [];
                    for (var i = 0; i < data1?.menu_2.length; i++) {
                        menu_2.push({
                            id: data1?.menu_2[i]?.menu?.id,
                            name: data1?.menu_2[i]?.menu?.menu_detail[0]?.name,
                        });
                    }
                    this.menu2 = menu_2;

                    let menu_3 = [];
                    for (var i = 0; i < data1?.menu_3.length; i++) {
                        menu_3.push({
                            id: data1?.menu_3[i]?.menu?.id,
                            name: data1?.menu_3[i]?.menu?.menu_detail[0]?.name,
                        });
                    }
                    this.menu3 = menu_3;
                    let menu_4 = [];
                    for (var i = 0; i < data1?.menu_4.length; i++) {
                        menu_4.push({
                            id: data1?.menu_4[i]?.menu?.id,
                            name: data1?.menu_4[i]?.menu?.menu_detail[0]?.name,
                        });
                    }
                    this.menu4 = menu_4;
                    //welcome settings
                    let obj = {};
                    data.map((res) => {
                        obj["section_1_title_" + res.language_id] =
                            res.section_1_title;
                    });
                    this.$store.commit("sitemap_setting/setPageSetting", {
                        key: "section_1_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["section_2_title_" + res.language_id] =
                            res.section_2_title;
                    });

                    this.$store.commit("sitemap_setting/setPageSetting", {
                        key: "section_2_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["section_3_title_" + res.language_id] =
                            res.section_3_title;
                    });

                    this.$store.commit("sitemap_setting/setPageSetting", {
                        key: "section_3_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["section_4_title_" + res.language_id] =
                            res.section_4_title;
                    });

                    this.$store.commit("sitemap_setting/setPageSetting", {
                        key: "section_4_title",
                        value: obj,
                    });

                    obj = {};
                    data.map((res) => {
                        obj["copy_right_text_" + res.language_id] =
                            res.copy_right_text;
                        CKEDITOR.instances[
                            "copy_right_text_" + res.language_id
                        ].setData(res.copy_right_text);
                    });
                    this.$store.commit("sitemap_setting/setPageSetting", {
                        key: "copy_right_text",
                        value: obj,
                    });
                });
            this.$store.dispatch("banners/fetchBanners");
        },
        checkValidationError(validationErros, language) {
            return (
                validationErros.has(
                    `section_1_title.section_1_title_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `section_2_title.section_2_title_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `section_3_title.section_3_title_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `section_4_title.section_4_title_${this.selectedLanguage}`
                ) ||
                validationErros.has(
                    `copy_right_text.copy_right_text_${this.selectedLanguage}`
                )
            );
        },
        createEditorInstance(name, key, lang, mutationName) {
            let ctx = this;
            CKEDITOR.replace(name);
            if (CKEDITOR?.instances[name]) {
                CKEDITOR.instances[name].on("change", function () {
                    let value = CKEDITOR.instances[name].getData();
                    ctx.$store.commit("sitemap_setting/" + mutationName, {
                        value: value,
                        id: lang.id,
                        key: key,
                    });
                });
            }
        },
    },
    created() {
        this.$store.commit("sitemap_setting/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["section_1_title_" + res.id] = "";
                });

                this.$store.commit("sitemap_setting/setPageSetting", {
                    key: "section_1_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["section_2_title_" + res.id] = "";
                });

                this.$store.commit("sitemap_setting/setPageSetting", {
                    key: "section_2_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["section_3_title_" + res.id] = "";
                });

                this.$store.commit("sitemap_setting/setPageSetting", {
                    key: "section_3_title",
                    value: obj,
                });

                obj = {};
                data.map((res) => {
                    obj["section_4_title_" + res.id] = "";
                });

                this.$store.commit("sitemap_setting/setPageSetting", {
                    key: "section_4_title",
                    value: obj,
                });

                this.fetchSitemapSetting();
                this.$store
                    .dispatch("menus/fetchMenus", {
                        url: `${process.env.MIX_ADMIN_API_URL}menus?q=1&limit=2000`,
                    })
                    .then((res) => {
                        for (var i = 0; i < this.menus?.length; i++) {
                            this.sortedMenus.push({
                                id: this.menus[i].id,
                                name: this.menus[i]?.menu_detail[0]?.name,
                            });
                        }
                    });
            });
    },
    watch: {
        selectedLanguage: function (newVal, oldVal) {
        },
    },
};
</script>
