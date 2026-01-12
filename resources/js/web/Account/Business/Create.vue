<template>
    <div
        class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full"
    >
        <div class="mt-4 flex justify-between items-center gap-2 p-2">
            <h1 class="px-4 can-school-h1">Create a webinar</h1>
        </div>
        <div class="mt-6 w-full md:w-8/12 ml-4">
            <form class="py-4 px-4 bg-white" @submit.prevent="addUpdateForm()">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
                >
                    <ul class="flex gap-2 flex-wrap my-4">
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
                    v-for="language in languages"
                    :key="language.id"
                    :class="
                        (activeTab == null && language.is_default) ||
                        activeTab == language.id
                            ? 'block'
                            : 'hidden'
                    "
                >
                <div
                    class="grid my-5 md:grid-cols-2 md:gap-6"
                >
                    <div class="relative z-0 w-full mb-6 group">
                        <input
                            type="text"
                            name="name"
                            id="business_name"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" "
                            @input="
                                handleMultipleInput(
                                    'business_name',
                                    $event.target.value,
                                    language
                                )
                            "
                            :value="
                                form['business_name'] &&
                                form['business_name'][
                                    `business_name_${language.id}`
                                ]
                                    ? form['business_name'][
                                          `business_name_${language.id}`
                                      ]
                                    : ''
                            "
                        />
                        <label
                            for="business_name"
                            class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                            >Business Name</label
                        >
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="
                                validationErros.has(
                                    `business_name.business_name_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `business_name.business_name_${language.id}`
                                )
                            "
                        ></p>
                    </div>
                </div>
                <div
                    class="grid my-5 md:grid-cols-2 md:gap-6"
                >
                    <div class="relative z-0 w-full mb-6 group mt-4" v-if="isDataLoaded">
                        <!-- <div
                            class="mt-5 ckeditorText"
                            :id="`description_${language.id}`"
                        ></div> -->
                        <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'description'
                                )
                            "
                            :ref="`description1_${language.id}`"
                            :id="`description1_${language.id}`"
                            :initial-value="form[`description`][`description_${language?.id}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />
                        <label
                            for="title"
                            class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 -top-1 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                            >Description</label
                        >
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="
                                validationErros.has(
                                    `description.description_${language.id}`
                                )
                            "
                            v-text="
                                validationErros.get(
                                    `description.description_${language.id}`
                                )
                            "
                        ></p>
                    </div>
                </div>
                </div>
                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            @input="
                                handleInput($event.target.value, 'contact_name')
                            "
                            :value="
                                form['contact_name'] ? form['contact_name'] : ''
                            "
                        />
                        <label
                            for="contact_name"
                            class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                            >Contact name</label
                        >
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="validationErros.has(`contact_name`)"
                            v-text="validationErros.get(`contact_name`)"
                        ></p>
                    </div>
                </div>
                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            @input="handleInput($event.target.value, 'email')"
                            :value="form['email'] ? form['email'] : ''"
                        />
                        <label
                            for="email"
                            class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                            >Email</label
                        >
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="validationErros.has(`email`)"
                            v-text="validationErros.get(`email`)"
                        ></p>
                    </div>
                </div>

                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            @input="handleInput($event.target.value, 'phone')"
                            :value="form['phone'] ? form['phone'] : ''"
                        />
                        <label
                            for="phone"
                            class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                            >Phone</label
                        >
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="validationErros.has(`phone`)"
                            v-text="validationErros.get(`phone`)"
                        ></p>
                    </div>
                </div>
                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            @input="handleInput($event.target.value, 'address')"
                            :value="form['address'] ? form['address'] : ''"
                        />
                        <label
                            for="address"
                            class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                            >Address</label
                        >
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="validationErros.has(`address`)"
                            v-text="validationErros.get(`address`)"
                        ></p>
                    </div>
                </div>
                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            @input="
                                handleInput($event.target.value, 'website_url')
                            "
                            :value="
                                form['website_url'] ? form['website_url'] : ''
                            "
                        />
                        <label
                            for="website_url"
                            class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                            >Website URL</label
                        >
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="validationErros.has(`website_url`)"
                            v-text="validationErros.get(`website_url`)"
                        ></p>
                    </div>
                </div>
                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <select
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            @input="
                                handleInput(
                                    $event.target.value,
                                    'business_catagory_1'
                                )
                            "
                        >
                            <option value="">Select</option>
                            <option
                                v-for="(
                                    business_category, key
                                ) in business_categories"
                                :selected="
                                    form['business_catagory_1'] ==
                                    business_category.id
                                "
                                :value="business_category.id"
                                :key="key"
                            >
                                {{
                                    business_category?.business_category_detail
                                        .length > 0
                                        ? business_category
                                              ?.business_category_detail[0].name
                                        : ""
                                }}
                            </option>
                        </select>
                        <label
                            for="degree"
                            class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                            >Business category 1</label
                        >
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="validationErros.has(`business_catagory_1`)"
                            v-text="validationErros.get(`business_catagory_1`)"
                        ></p>
                    </div>
                </div>

                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <select
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            @input="
                                handleInput(
                                    $event.target.value,
                                    'business_catagory_2'
                                )
                            "
                        >
                            <option value="">Select</option>
                            <option
                                v-for="(
                                    business_category, key
                                ) in business_categories"
                                :selected="
                                    form['business_catagory_2'] ==
                                    business_category.id
                                "
                                :value="business_category.id"
                                :key="key"
                            >
                                {{
                                    business_category?.business_category_detail
                                        .length > 0
                                        ? business_category
                                              ?.business_category_detail[0].name
                                        : ""
                                }}
                            </option>
                        </select>
                        <label
                            for="degree"
                            class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                            >Business category 2</label
                        >
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="validationErros.has(`business_catagory_2`)"
                            v-text="validationErros.get(`business_catagory_2`)"
                        ></p>
                    </div>
                </div>

                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <select
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            @input="
                                handleInput(
                                    $event.target.value,
                                    'business_catagory_3'
                                )
                            "
                        >
                            <option value="">Select</option>
                            <option
                                v-for="(
                                    business_category, key
                                ) in business_categories"
                                :selected="
                                    form['business_catagory_3'] ==
                                    business_category.id
                                "
                                :value="business_category.id"
                                :key="key"
                            >
                                {{
                                    business_category?.business_category_detail
                                        .length > 0
                                        ? business_category
                                              ?.business_category_detail[0].name
                                        : ""
                                }}
                            </option>
                        </select>
                        <label
                            for="degree"
                            class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                            >Business category 2</label
                        >
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="validationErros.has(`business_catagory_3`)"
                            v-text="validationErros.get(`business_catagory_3`)"
                        ></p>
                    </div>
                </div>
                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            @input="
                                handleInput($event.target.value, 'facebook_url')
                            "
                            :value="
                                form['facebook_url'] ? form['facebook_url'] : ''
                            "
                        />
                        <label
                            for="facebook_url"
                            class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                            >Facebook URL</label
                        >
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="validationErros.has(`facebook_url`)"
                            v-text="validationErros.get(`facebook_url`)"
                        ></p>
                    </div>
                </div>
                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            @input="
                                handleInput($event.target.value, 'twitter_url')
                            "
                            :value="
                                form['twitter_url'] ? form['twitter_url'] : ''
                            "
                        />
                        <label
                            for="twitter_url"
                            class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                            >Twitter URL</label
                        >
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="validationErros.has(`twitter_url`)"
                            v-text="validationErros.get(`twitter_url`)"
                        ></p>
                    </div>
                </div>
                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            @input="
                                handleInput($event.target.value, 'youtube_url')
                            "
                            :value="
                                form['youtube_url'] ? form['youtube_url'] : ''
                            "
                        />
                        <label
                            for="youtube_url"
                            class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                            >Youtube URL</label
                        >
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="validationErros.has(`youtube_url`)"
                            v-text="validationErros.get(`youtube_url`)"
                        ></p>
                    </div>
                </div>
                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            @input="
                                handleInput($event.target.value, 'linked_url')
                            "
                            :value="
                                form['linked_url'] ? form['linked_url'] : ''
                            "
                        />
                        <label
                            for="linked_url"
                            class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                            >Linked URL</label
                        >
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="validationErros.has(`linked_url`)"
                            v-text="validationErros.get(`linked_url`)"
                        ></p>
                    </div>
                </div>
                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input
                            :key="`image`"
                            type="file"
                            :name="`image`"
                            :id="`image`"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" "
                            @input="handleImage($event, 'image')"
                        />
                        <label
                            for="degree"
                            class="peer-focus:font-medium absolute text-base text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-6 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-primary peer-focus:dark:text-blue-500 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6"
                            >Image</label
                        >
                        <p
                            class="mt-2 text-base text-primary"
                            v-if="validationErros.has(`image`)"
                            v-text="validationErros.get(`image`)"
                        ></p>

                        <img
                            v-if="form['image']"
                            :src="'/' +form['image'] ? form['image'] : ''"
                            style="height: 100px; width: 100px"
                        />
                    </div>
                </div>
                <button type="submit" class="can-edu-btn-fill">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            form: (state) => state.business.form,
            validationErros: (state) => state.business.validationErros,
            languages: (state) => state.languages.languages,
            business_categories: (state) =>
                state.business_categories.business_categories
        }),
    },
    components:{
        editor: Editor
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
        handleInput(value, key) {
            this.$store.commit("business/setState", { key, value });
        },
        handleSelectionChange(language, key) {
            this.$store.commit(`business/updateState`, {
                value: tinymce.get(`${key}1_${language.id}`).getContent(),
                id: language.id,
                key:key,
            });
        },
        handleMultipleInput(key, value, language) {
            this.$store.commit("business/updateState", {
                value: value,
                id: language.id,
                key,
            });
        },
        addUpdateForm() {
            this.$store
                .dispatch("business/addUpdateForm")
                .then(() =>
                    this.$router.push({ name: "admin.business.index" })
                );
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchBusiness() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("business/setIsFormEdit", 1);
                this.$store
                    .dispatch("business/fetchBusiness", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}business/${id}?withBusinessDetail=1`,
                    })
                    .then((res) => {
                        let keys = [
                            "facebook_url",
                            "twitter_url",
                            "youtube_url",
                            "linked_url",
                            "image",
                            "contact_name",
                            "email",
                            "phone",
                            "address",
                            "website_url",
                            "business_catagory_1",
                            "business_catagory_2",
                            "business_catagory_3",
                        ];
                        this.$store.commit("business/setState", {
                            key: "id",
                            value: id,
                        });
                        for (var i = 0; i < keys.length; i++) {
                            this.$store.commit("business/setState", {
                                key: keys[i],
                                value: res.data.data[keys[i]],
                            });
                        }
                        let data =
                            res.data.data && res.data.data.business_detail
                                ? res.data.data.business_detail
                                : [];

                        setTimeout(() => {
                            let obj = {};
                            data.map((res) => {
                                obj["business_name_" + res.language_id] =
                                    res.business_name;
                            });
                            this.$store.commit("business/setState", {
                                key: "business_name",
                                value: obj,
                            });

                            data.map((res) => {
                                obj["description_" + res.language_id] =
                                    res.description;
                            });
                            this.$store.commit("business/setState", {
                                key: "description",
                                value: obj,
                            });
                            this.isDataLoaded = 1;
                        }, 1000);
                    });
            }
        },
        handleImage(e, key) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios
                .post("/api/admin/media/image_again_upload", file)
                .then((res) => {
                    this.$store.commit("business/setState", {
                        key,
                        value: res?.data,
                    });
                });
        },
    },
    created() {
        this.$store.commit("business/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["business_name_" + res.id] = "";
                });
                this.$store.commit("business/setState", {
                    key: "business_name",
                    value: obj,
                });
                data.map((res) => {
                    obj["description_" + res.id] = "";
                });
                this.$store.commit("business/setState", {
                    key: "description",
                    value: obj,
                });
                if (this.$route.params.id) {
                    this.fetchBusiness();
                }
                else{
                    this.isDataLoaded = 1;
                }
            });
        this.$store.commit("business_categories/setLimit", 10000);
        this.$store.commit("business_categories/setSortBy", "id");
        this.$store.commit("business_categories/setSortType", "desc");
        this.$store.dispatch("business_categories/fetchBusinessCategories");
    },
};
</script>
