<template>
    <AppLayout>
        <header class="py-4 bg-white">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="can-edu-h1">{{isFormEdit ? 'Edit' : 'Create'}} menu</h1>
                    <router-link
                        :to="{ name: 'admin.menus.index' }"
                        class="can-edu-btn-fill"
                    >
                        Back
                    </router-link>
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
                        @input="handleNameInput($event.target.value, language)"
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
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        @input="handleUrlInput($event.target.value)"
                        :value="form['url']"
                    />
                    <label
                        for="name"
                        class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                        >Url</label
                    >
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has(`url`)"
                        v-text="validationErros.get(`url`)"
                    ></p>
                </div>
            </div>

            <div class="grid my-5 md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <input
                        type="number"
                        name="order"
                        id="order"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        @input="handleOrderInput($event.target.value)"
                        :value="form['order']"
                    />
                    <label
                        for="order"
                        class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                        >Order</label
                    >
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has(`order`)"
                        v-text="validationErros.get(`order`)"
                    ></p>
                </div>
            </div>

            <div class="grid my-5 md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <input
                        type="radio"
                        name="name"
                        id="name"
                        placeholder=" "
                        @input="handleShowOnInput($event.target.value)"
                        value="top_menu"
                        :checked="form['show_on'] == 'top_menu'"
                    />
                    Show on top menu <br />
                    <br />
                    <input
                        type="radio"
                        name="name"
                        id="name"
                        placeholder=" "
                        @input="handleShowOnInput($event.target.value)"
                        value="main_menu"
                        :checked="form['show_on'] == 'main_menu'"
                    />
                    Show on main menu

                    <br />
                    <br />
                    <input
                        type="radio"
                        name="name"
                        id="name"
                        placeholder=" "
                        @input="handleShowOnInput($event.target.value)"
                        value="unset"
                        :checked="form['show_on'] == '' || form['show_on'] == 'unset'"
                    />
                    Unset

                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has(`show_on`)"
                        v-text="validationErros.get(`show_on`)"
                    ></p>
                </div>
            </div>
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
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            isFormEdit: (state) => state.menus.isFormEdit,
            form: (state) => state.menus.form,
            validationErros: (state) => state.menus.validationErros,
            languages: (state) => state.languages.languages,
            menus: (state) => state.menus.menus,
        }),
    },
    data() {
        return {
            activeTab: null,
            dropdownClass:
                "block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer",
        };
    },
    methods: {
        handleOrderInput(value) {
            this.$store.commit("menus/setOrder", value);
        },
        handleUrlInput(value) {
            this.$store.commit("menus/setUrl", value);
        },
        handleShowOnInput(value) {
            this.$store.commit("menus/setShowOn", value);
        },
        handleNameInput(value, language) {
            this.$store.commit("menus/updateName", {
                name: value,
                id: language.id,
            });
        },
        addUpdateForm() {
            this.$store.dispatch("menus/addUpdateForm").then(() =>
                this.$router.push({
                    name: "admin.menus.index",
                })
            );
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
            this.$forceUpdate();
        },
        fetchMenu() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;
                this.$store.commit("menus/setIsFormEdit", 1);
                this.$store
                    .dispatch("menus/fetchMenu", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}menus/${id}?withMenuDetail=1`,
                    })
                    .then((res) => {
                        let data =
                            res.data.data && res.data.data.menu_detail
                                ? res.data.data.menu_detail
                                : [];
                        let obj = {};
                        data.map((res) => {
                            obj["name_" + res.language_id] = res.name;
                        });
                        this.$store.commit("menus/setName", obj);
                        this.$store.commit("menus/setUrl", res.data.data?.url);
                        this.$store.commit("menus/setOrder", res.data.data?.order);
                        this.$store.commit(
                            "menus/setShowOn",
                            res.data.data?.show_on
                        );
                    });
            }
        },
        deleteObject(index, item, isChild) {
            for (var i = 0; i < this.nestableItems.length; i++) {
                if (isChild) {
                    this.removeChild(item, this.nestableItems[i]);
                } else {
                    if (item.id == this.nestableItems[i].id) {
                        this.nestableItems.splice(i, 1);
                        // this.updateSetting();
                    }
                }
            }
        },
        removeChild(item, nestedItem) {
            for (var j = 0; j < nestedItem.children.length; j++) {
                if (item.id == nestedItem.children[j].id) {
                    nestedItem.children.splice(j, 1);
                    // this.updateSetting();
                }
                if (nestedItem.children[j]) {
                    this.removeChild(item, nestedItem.children[j]);
                }
            }
        },
        editObject(index, item, isChild) {
            this.menuObject = item;
        },
    },
    created() {
        this.$store.commit("menus/resetForm");
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
                this.$store.commit("menus/setName", obj);
                this.fetchMenu();
            });
        this.$store.dispatch("menus/fetchMenus").then(() => {
            let menuJson = {};
            for (var i = 0; i < this.menus.length; i++) {
                menuJson = {
                    id: Date.now() + "-" + this.menus[i].id,
                    url: this.menus[i].url,
                };
                let menuName = [];
                let menuLengugae = [];
                for (var j = 0; j < this.menus[i].menu_detail.length; j++) {
                    menuName.push(this.menus[i].menu_detail[j].name);
                    menuLengugae.push(this.menus[i].menu_detail[j].language_id);
                }
                menuJson["name"] = menuName;
                menuJson["language_id"] = menuLengugae;
                menuJson["children"] = [];
                // this.nestableItems.push(menuJson);
            }
        });
    },
};
</script>
