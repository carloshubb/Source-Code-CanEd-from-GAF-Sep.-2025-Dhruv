<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">
                            {{ isFormEdit ? "Edit" : "Create" }} registration
                            package
                        </h1>
                        <router-link
                            :to="{ name: 'admin.registration_packages.index' }"
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
              Select language(s) of the registration package
            </p>
          </div>
        </div>
      </header>
            <form
                class="px-4 md:px-6 lg:px-8"
                @submit.prevent="addUpdateForm()"
            >
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200"
                >
                    <ul class="flex flex-wrap mb-2 overflow-x-auto gap-1 mt-4">
                        <li
                            class="mr-2"
                            v-for="language in languages"
                            :key="language.id"
                        >
                            <a
                                @click.prevent="changeLanguageTab(language)"
                                href="#"
                                :class="[
                                    'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                    (activeTab == null &&
                                        language.is_default) ||
                                    activeTab == language.id
                                        ? 'text-white bg-primary active'
                                        : '',
                                    validationErros.has(
                                        `name.name_${language.id}`
                                    ) ||
                                    validationErros.has(
                                        `short_description.short_description_${language.id}`
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
                    class="grid my-5 grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 md:gap-6"
                    v-for="language in languages"
                    :key="language.id"
                    :class="
                        (activeTab == null && language.is_default) ||
                        activeTab == language.id
                            ? 'block'
                            : 'hidden'
                    "
                >
                    <div class="relative z-0 w-full group">
                        <label class="block text-base lg:text-lg" for="name">Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" "
                            @input="
                                handleNameInput($event.target.value, language)
                            "
                            :value="
                                form['name'] &&
                                form['name'][`name_${language.id}`]
                                    ? form['name'][`name_${language.id}`]
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(`name.name_${language.id}`)
                            "
                            v-text="
                                validationErros.get(`name.name_${language.id}`)
                            "
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-base lg:text-lg" for="short_description">Short description</label>
                        <input
                            type="text"
                            name="short_description"
                            id="short_description"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" "
                            @input="
                                handleShortDescInput(
                                    $event.target.value,
                                    language
                                )
                            "
                            :value="
                                form['short_description'] &&
                                form['short_description'][
                                    `short_description_${language.id}`
                                ]
                                    ? form['short_description'][
                                          `short_description_${language.id}`
                                      ]
                                    : ''
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `short_description.short_description_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `short_description.short_description_${language.id}`
                                )
                            "
                        ></p>
                    </div>
                </div>
                <div
                    v-for="language in languages"
                    :key="language.id"
                    :class="
                        (activeTab == null && language.is_default) ||
                        activeTab == language.id
                            ? 'block'
                            : 'hidden'
                    "
                >
                    <div class="relative z-0 w-full group">
                        <label class="block font-medium text-base lg:text-lg" for="features">Features</label>
                        <template
                            v-for="(features, index) in form['features'][
                                `features_${language.id}`
                            ]"
                            :key="index"
                        >
                            <div
                                class="mt-2 flex justify-between items-center gap-4"
                            >
                                <input
                                    type="text"
                                    name="features"
                                    id="features"
                                    class="border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                    placeholder=" "
                                    @input="
                                        handleFeatureInput(
                                            language.id,
                                            $event.target.value,
                                            index
                                        )
                                    "
                                    :value="features"
                                />
                                <button
                                    class="can-edu-btn-fill"
                                    type="button"
                                    @click="removeFeature(language.id, index)"
                                >
                                    Remove
                                </button>
                            </div>
                        </template>
                        <div class="text-right my-4">
                            <button
                                class="can-edu-btn-fill"
                                type="button"
                                @click="addNewFeature(language.id)"
                            >
                                Add new feature
                            </button>
                        </div>
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="
                                validationErros.has(
                                    `features.features_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `short_description.short_description_${language.id}`
                                )
                            "
                        ></p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 md:gap-6">
                    <div class="relative z-0 w-full group">
                        <div class="flex justify-between items-center">
                            <label class="block text-base lg:text-lg" for="package_type">Package type</label>
                            <fieldset>
                                <legend class="sr-only">Set as most popular</legend>
                                <div class="flex items-center">
                                    <input
                                        id="is_default"
                                        name="is_default"
                                        type="checkbox"
                                        value=""
                                        class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 focus:ring-2"
                                        :checked="is_default"
                                        v-model="is_default"
                                    />
                                    <label
                                        for="is_default"
                                        class="ml-2 text-base font-medium text-gray-900"
                                        >Set as most popular</label
                                    >
                                </div>
                            </fieldset>
                        </div>
                        <select
                            id="package_type"
                            @change="
                                updateForm('package_type', $event.target.value)
                            "
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        >
                            <option value="">Select package type...</option>
                            <option
                                value="free"
                                :selected="form.package_type == 'free'"
                            >
                                Free package
                            </option>
                            <option
                                value="featured"
                                :selected="form.package_type == 'featured'"
                            >
                                Featured package
                            </option>
                            <option
                                value="premium"
                                :selected="form.package_type == 'premium'"
                            >
                                Premium package
                            </option>
                        </select>
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('package_type')"
                            v-text="validationErros.get('package_type')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label class="block text-base lg:text-lg" for="type">Package for</label>
                        <select
                            id="type"
                            @change="updateForm('type', $event.target.value)"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        >
                            <option value="">Select package for...</option>
                            <option
                                value="school"
                                :selected="form.type == 'school'"
                            >
                                School package
                            </option>
                            <option
                                value="business"
                                :selected="form.type == 'business'"
                            >
                                Business package
                            </option>
                            <option
                                value="student"
                                :selected="form.type == 'student'"
                            >
                                Student package
                            </option>
                        </select>
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('type')"
                            v-text="validationErros.get('type')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group" v-if="form.type == 'school'">
                        <label class="block text-base lg:text-lg" for="events">Events allowed</label>
                        <input
                            type="number"
                            name="events"
                            id="events"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" "
                            :value="form.events"
                            @input="updateForm('events', $event.target.value)"
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('events')"
                            v-text="validationErros.get('events')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group" v-if="form.type == 'school'">
                        <label class="block text-base lg:text-lg" for="images">Images allowed</label>
                        <input
                            type="number"
                            name="images"
                            id="images"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" "
                            :value="form.images"
                            @input="updateForm('images', $event.target.value)"
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('images')"
                            v-text="validationErros.get('images')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group" v-if="form.type == 'school'">
                        <label class="block text-base lg:text-lg" for="ambassadors">Ambassadors allowed</label>
                        <input
                            type="number"
                            name="ambassadors"
                            id="ambassadors"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" "
                            :value="form.ambassadors"
                            @input="
                                updateForm('ambassadors', $event.target.value)
                            "
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('ambassadors')"
                            v-text="validationErros.get('ambassadors')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group" v-if="form.type == 'school'">
                        <label class="block text-base lg:text-lg" for="webinars">Webinars allowed</label>
                        <input
                            type="number"
                            name="webinars"
                            id="webinars"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" "
                            :value="form.webinars"
                            @input="updateForm('webinars', $event.target.value)"
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('webinars')"
                            v-text="validationErros.get('webinars')"
                        ></p>
                    </div>
                    <div class="relative z-0 w-full group" v-if="form.type == 'school' || form.type == 'business'">
                        <label class="block text-base lg:text-lg" for="articles">Articles allowed</label>
                        <input
                            type="number"
                            name="articles"
                            id="articles"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" "
                            :value="form.articles"
                            @input="updateForm('articles', $event.target.value)"
                        />
                        <p
                            class="mt-2 text-sm text-red-400"
                            v-if="validationErros.has('articles')"
                            v-text="validationErros.get('articles')"
                        ></p>
                    </div>
                </div>
                <template
                    v-if="
                        form.package_type == 'featured' ||
                        form.package_type == 'premium'
                    "
                >
                    <div class="grid md:grid-cols-2 gap-4 md:gap-6 mt-6">
                        <div class="relative z-0 w-full group">
                            <label class="block text-base lg:text-lg" for="monthly_price">Monthly Price</label>
                            <input
                                type="text"
                                name="monthly_price"
                                id="monthly_price"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                placeholder=" "
                                :value="form.monthly_price"
                                @input="
                                    updateForm(
                                        'monthly_price',
                                        $event.target.value
                                    )
                                "
                            />
                            <p
                                class="mt-2 text-sm text-red-400"
                                v-if="validationErros.has('monthly_price')"
                                v-text="validationErros.get('monthly_price')"
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group">
                            <label class="block text-base lg:text-lg" for="quarterly_price"
                                >Quarterly price per month</label
                            >
                            <input
                                type="text"
                                name="quarterly_price"
                                id="quarterly_price"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                placeholder=" "
                                :value="form.quarterly_price"
                                @input="
                                    updateForm(
                                        'quarterly_price',
                                        $event.target.value
                                    )
                                "
                            />
                            <p
                                class="mt-2 text-sm text-red-400"
                                v-if="validationErros.has('quarterly_price')"
                                v-text="validationErros.get('quarterly_price')"
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group">
                            <label class="block text-base lg:text-lg" for="semi_annually_price"
                                >Semi annually price per month</label
                            >
                            <input
                                type="text"
                                name="semi_annually_price"
                                id="semi_annually_price"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                placeholder=" "
                                :value="form.semi_annually_price"
                                @input="
                                    updateForm(
                                        'semi_annually_price',
                                        $event.target.value
                                    )
                                "
                            />
                            <p
                                class="mt-2 text-sm text-red-400"
                                v-if="
                                    validationErros.has('semi_annually_price')
                                "
                                v-text="
                                    validationErros.get('semi_annually_price')
                                "
                            ></p>
                        </div>
                        <div class="relative z-0 w-full group">
                            <label class="block text-base lg:text-lg" for="annually_price"
                                >Annually price per month</label
                            >
                            <input
                                type="text"
                                name="annually_price"
                                id="annually_price"
                                class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                                placeholder=" "
                                :value="form.annually_price"
                                @input="
                                    updateForm(
                                        'annually_price',
                                        $event.target.value
                                    )
                                "
                            />
                            <p
                                class="mt-2 text-sm text-red-400"
                                v-if="validationErros.has('annually_price')"
                                v-text="validationErros.get('annually_price')"
                            ></p>
                        </div>
                    </div>
                </template>
                <ListErrors :validationErrors="validationErros" />
                <button
                    type="submit"
                    class="can-edu-btn-fill mt-5 mb-2"
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
            loading: (state) => state.registration_packages.loading,
            isFormEdit: (state) => state.registration_packages.isFormEdit,
            form: (state) => state.registration_packages.form,
            validationErros: (state) =>
                state.registration_packages.validationErros,
            languages: (state) => state.languages.languages,
            general_setting: (state) => state.general_setting.general_setting,
        }),
        is_default: {
            get: function () {
                return this.$store.state.registration_packages.form.is_default;
            },
            set: function (val) {
                this.$store.commit("registration_packages/setForm", {
                    is_default: val,
                });
            },
        },
    },
    data() {
        return {
            activeTab: null,
        };
    },
    methods: {
        updateForm(field, value) {
            this.$store.commit("registration_packages/setForm", {
                [field]: value,
            });
            // if (field == "package_validity_months" || field == "package_type") {
            //     let packageSetting = null;
            //     if (packageSetting && packageSetting[0]) {
            //         this.$store.commit("registration_packages/setForm", {
            //             price:
            //                 packageSetting[0]["value"] *
            //                 this.form.package_validity_months,
            //         });
            //     } else {
            //         this.$store.commit("registration_packages/setForm", {
            //             price: 0,
            //         });
            //     }
            // }
        },
        handleNameInput(value, language) {
            this.$store.commit("registration_packages/updateName", {
                name: value,
                id: language.id,
            });
        },
        handleShortDescInput(value, language) {
            this.$store.commit(
                "registration_packages/updateShortDescriptionText",
                {
                    short_description: value,
                    id: language.id,
                }
            );
        },
        addUpdateForm() {
            this.$store
                .dispatch("registration_packages/addUpdateForm")
                .then(() =>
                    this.$router.push({
                        name: "admin.registration_packages.index",
                    })
                );
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchRegistrationPackage() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;
                this.$store.commit("registration_packages/setIsFormEdit", 1);
                this.$store
                    .dispatch(
                        "registration_packages/fetchRegistrationPackage",
                        {
                            id: id,
                            url: `${process.env.MIX_ADMIN_API_URL}registration-packages/${id}?withRegistrationPackageDetail=1&withRegistrationPackageFeature=1`,
                        }
                    )
                    .then((res) => {
                        let data =
                            res.data.data &&
                            res.data.data.registration_package_detail
                                ? res.data.data.registration_package_detail
                                : [];
                        let features =
                            res.data.data &&
                            res.data.data.registration_package_feature
                                ? res.data.data.registration_package_feature
                                : [];
                        let obj = {};
                        data.map((res) => {
                            obj["name_" + res.language_id] = res.name;
                        });
                        this.$store.commit(
                            "registration_packages/setName",
                            obj
                        );
                        obj = {};
                        data.map((res) => {
                            obj["short_description_" + res.language_id] =
                                res.short_description;
                        });
                        this.$store.commit(
                            "registration_packages/setShortDescriptionText",
                            obj
                        );

                        features.map((feature) => {
                            this.addNewFeature(
                                feature.language_id,
                                feature.name
                            );
                        });
                    });
            }
        },
        addNewFeature(languageId, value = null) {
            this.$store.commit("registration_packages/addNewFeature", {
                languageId: languageId,
                value: value || "",
            });
        },
        removeFeature(languageId, index) {
            this.$store.commit("registration_packages/removeFeature", {
                languageId: languageId,
                index: index,
            });
        },
        handleFeatureInput(languageId, value, index) {
            this.$store.commit("registration_packages/handleFeatureInput", {
                languageId: languageId,
                value: value,
                index: index,
            });
        },
    },
    created() {
        this.$store.commit("registration_packages/resetForm");
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
                this.$store.commit("registration_packages/setName", obj);
                obj = {};
                data.map((res) => {
                    obj["short_description_" + res.id] = "";
                });
                this.$store.commit(
                    "registration_packages/setShortDescriptionText",
                    obj
                );
                this.fetchRegistrationPackage();
                // this.$store.dispatch("general_setting/fetchGeneralSetting", {
                //     url: `${process.env.MIX_ADMIN_API_URL}general-setting?onlyPackageSetting=1`,
                // });
            });
    },
};
</script>
