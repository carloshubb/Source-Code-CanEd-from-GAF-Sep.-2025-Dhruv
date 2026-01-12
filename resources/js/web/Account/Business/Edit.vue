<template>
    <div
        class="md:col-span-8 col-span-12 border border-gray-500 rounded-md w-full"
    >
        <div class="mt-4 flex justify-between items-center gap-2 p-2">
            <h1 class="px-4 can-school-h1">Edit Business</h1>
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
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="business_name">Business Name</label>
                        <input
                            type="text"
                            name="name"
                            id="business_name"
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
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
                        <Error
                            :fieldName="`business_name.business_name_${language.id}`"
                            :validationErros="validationErros"
                        />
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
                    <div class="relative z-0 w-full mb-6 group mt-4" v-if="isDataLoaded">
                        <label for="title">Description</label>
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

                        <Error
                            :fieldName="`description.description_${language.id}`"
                            :validationErros="validationErros"
                        />
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
                    <div class="relative z-0 w-full mb-6 group mt-4" v-if="isDataLoaded">
                        <label for="title">Detailed Description</label>
                        <!-- <div
                            class="mt-5 ckeditorText"
                            :id="`description_${language.id}`"
                        ></div> -->
                        <editor
                            @selectionChange="
                                handleSelectionChange(
                                    language,
                                    'detail_description'
                                )
                            "
                            :ref="`detail_description_${language.id}`"
                            :id="`detail_description_${language.id}`"
                            :initial-value="form[`detail_description`][`detail_description_${language?.id}`]
                            "
                            :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc"
                        />

                        <Error
                            :fieldName="`detail_description.detail_description_${language.id}`"
                            :validationErros="validationErros"
                        />
                    </div>
                </div>
                <div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="contact_name">Keywords</label>
                        <input
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="
                                handleInput($event.target.value, 'keywords')
                            "
                            :value="
                                form['keywords'] ? form['keywords'] : ''
                            "
                        />

                        <Error
                            :fieldName="`keywords`"
                            :validationErros="validationErros"
                        />
                    </div>
                </div>
                <div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="contact_name">Contact name</label>
                        <input
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="
                                handleInput($event.target.value, 'contact_name')
                            "
                            :value="
                                form['contact_name'] ? form['contact_name'] : ''
                            "
                        />

                        <Error
                            :fieldName="`contact_name`"
                            :validationErros="validationErros"
                        />
                    </div>
                </div>
                <div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="email">Email</label>
                        <input
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="handleInput($event.target.value, 'email')"
                            :value="form['email'] ? form['email'] : ''"
                        />

                        <Error
                            :fieldName="`email`"
                            :validationErros="validationErros"
                        />
                    </div>
                </div>

                <div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="phone">Phone</label>
                        <input
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="handleInput($event.target.value, 'phone')"
                            :value="form['phone'] ? form['phone'] : ''"
                        />

                        <Error
                            :fieldName="`phone`"
                            :validationErros="validationErros"
                        />
                    </div>
                </div>
                <div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="address">Address</label>
                        <input
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="handleInput($event.target.value, 'address')"
                            :value="form['address'] ? form['address'] : ''"
                        />

                        <Error
                            :fieldName="`address`"
                            :validationErros="validationErros"
                        />
                    </div>
                </div>
                <div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="website_url">Website URL</label>
                        <input
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="
                                handleInput($event.target.value, 'website_url')
                            "
                            :value="
                                form['website_url'] ? form['website_url'] : ''
                            "
                        />

                        <Error
                            :fieldName="`website_url`"
                            :validationErros="validationErros"
                        />
                    </div>
                </div>
                <div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="degree">Business category 1</label>
                        <select
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
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
                        <Error
                            :fieldName="`business_catagory_1`"
                            :validationErros="validationErros"
                        />
                    </div>
                </div>

                <div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="degree">Business category 2</label>
                        <select
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
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

                        <Error
                            :fieldName="`business_catagory_2`"
                            :validationErros="validationErros"
                        />
                    </div>
                </div>

                <div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="degree">Business category 2</label>
                        <select
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
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

                        <Error
                            :fieldName="`business_catagory_3`"
                            :validationErros="validationErros"
                        />
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
                <div class="relative z-0 w-full mb-6 group mt-4" v-if="isDataLoaded">
                    <label for="title">Media section title</label>
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`description_${language.id}`"
                    ></div> -->
                    <editor
                        @selectionChange="
                            handleSelectionChange(
                                language,
                                'media_section_title'
                            )
                        "
                        :ref="`media_section_title_${language.id}`"
                        :id="`media_section_title_${language.id}`"
                        :initial-value="form[`media_section_title`][`media_section_title_${language?.id}`]
                        "
                        :init="editorConfig"
                        :tinymce-script-src="tinymceScriptSrc"
                    />

                    <Error
                        :fieldName="`media_section_title.media_section_title_${language.id}`"
                        :validationErros="validationErros"
                    />
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
                <div class="relative z-0 w-full mb-6 group mt-4" v-if="isDataLoaded">
                    <label for="title">Media section description</label>
                    <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`description_${language.id}`"
                    ></div> -->
                    <editor
                        @selectionChange="
                            handleSelectionChange(
                                language,
                                'media_section_description'
                            )
                        "
                        :ref="`media_section_description_${language.id}`"
                        :id="`media_section_description_${language.id}`"
                        :initial-value="form[`media_section_description`][`media_section_description_${language?.id}`]
                        "
                        :init="editorConfig"
                        :tinymce-script-src="tinymceScriptSrc"
                    />

                    <Error
                        :fieldName="`media_section_description.media_section_description_${language.id}`"
                        :validationErros="validationErros"
                    />
                </div>
            </div>
            <div class="w-full mt-4">
                <label class="block text-base lg:text-lg">Logo <span class="text-primary">*</span></label>
                <p class="text-base">
                    Logo(Files must be less than 5MB. Allowed file types: JPG. JPEG, PNG.)
                </p>
                <input type="file"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @change="handleLogo($event,'logo')" />
                    <p class="mt-2 text-base text-primary" v-if="validationErros.has(`logo`)"
                    v-text="validationErros.get(`logo`)"></p>
                <div v-if="form['logo']" class="mt-2 relative">
                    <img :src="form.logo" style="height: 100px; width: 100px" />
                    <button @click="removeImageLogo"
                        class="absolute top-0 right-0 bg-primary text-white rounded-full px-2 py-1 text-xs">
                        X
                    </button>
                </div>
            </div>
            <div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="contact_name">Welcome video</label>
                    <input
                        class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                        @input="
                            handleInput($event.target.value, 'welcome_video')
                        "
                        :value="
                            form['welcome_video'] ? form['welcome_video'] : ''
                        "
                    />

                    <Error
                        :fieldName="`welcome_video`"
                        :validationErros="validationErros"
                    />
                </div>
            </div>
                <div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="facebook_url">Facebook URL</label>
                        <input
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="
                                handleInput($event.target.value, 'facebook_url')
                            "
                            :value="
                                form['facebook_url'] ? form['facebook_url'] : ''
                            "
                        />

                        <Error
                            :fieldName="`facebook_url`"
                            :validationErros="validationErros"
                        />
                    </div>
                </div>
                <div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="twitter_url">Twitter URL</label>
                        <input
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="
                                handleInput($event.target.value, 'twitter_url')
                            "
                            :value="
                                form['twitter_url'] ? form['twitter_url'] : ''
                            "
                        />

                        <Error
                            :fieldName="`twitter_url`"
                            :validationErros="validationErros"
                        />
                    </div>
                </div>
                <div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="youtube_url">Youtube URL</label>
                        <input
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="
                                handleInput($event.target.value, 'youtube_url')
                            "
                            :value="
                                form['youtube_url'] ? form['youtube_url'] : ''
                            "
                        />

                        <Error
                            :fieldName="`youtube_url`"
                            :validationErros="validationErros"
                        />
                    </div>
                </div>
                <div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="linked_url">Linked URL</label>
                        <input
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="
                                handleInput($event.target.value, 'linked_url')
                            "
                            :value="
                                form['linked_url'] ? form['linked_url'] : ''
                            "
                        />

                        <Error
                            :fieldName="`linked_url`"
                            :validationErros="validationErros"
                        />
                    </div>
                </div>
                <div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="contact_name">Other social url</label>
                        <input
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="
                                handleInput($event.target.value, 'other_social_url')
                            "
                            :value="
                                form['other_social_url'] ? form['other_social_url'] : ''
                            "
                        />
    
                        <Error
                            :fieldName="`other_social_url`"
                            :validationErros="validationErros"
                        />
                    </div>
                </div>
                <div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="degree">Image</label>
                        <input
                            :key="`image`"
                            type="file"
                            :name="`image`"
                            :id="`image`"
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            placeholder=" "
                            @input="handleImageArray($event)"
                            multiple
                        />

                        <Error
                            :fieldName="`image`"
                            :validationErros="validationErros"
                        />

                    </div>
                    <div class="md:col-span-4">
                    <div class="flex flex-wrap gap-2">
                        <div
                            class="relative h-32 w-32 bg-gray-50 border"
                            v-for="(image, key) in form?.image"
                            :key="key"
                        >
                            <img
                                :src="image"
                                class="w-full h-full object-contain"
                            />
                            <span
                                @click="removeImage(key)"
                                class="absolute top-0 right-0 flex justify-center items-center cursor-pointer bg-white border border-primary rounded-full text-primary w-5 h-5"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-5 h-5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </span>
                        </div>
                    </div>
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
import Error from "../../Error.vue";
export default {
    props: ["business_id", "lang"],
    computed: {
        ...mapState({
            form: (state) => state.business.form,
            validationErros: (state) => state.business.validationErros,
            languages: (state) => state.languages.languages,
            business_categories: (state) =>
                state.business_categories.business_categories,
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
        handleLogo(event, key) {
    const fileInput = event.target;
    if (!fileInput.files.length) return;

    let file = new FormData();
    file.append("file", fileInput.files[0]);

    axios.post("/api/web/image_again_upload", file)
        .then((res) => {
            this.$store.commit("business/setState", {
                key: key,
                value: res?.data,
            });

            if (this.validationErros.has(key)) {
                this.validationErros.clear(key);
            }
        })
        .catch((error) => {
            console.error("Image upload failed:", error);
        });
},
removeImageLogo() {
            this.$store.commit("business/setState", {
                key: "logo",
                value: null, 
            });
        },
        addUpdateForm() {
            this.$store
                .dispatch("business/addUpdateForm")
                .then(
                    () =>
                        (window.location.href =
                            "/" + this.lang + "/our-profile/business")
                );
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchBusiness() {
            if (this.business_id) {
                let id = this.business_id;
                console.log(id);
                this.$store.commit("business/setIsFormEdit", 1);
                this.$store
                    .dispatch("business/fetchBusiness", {
                        id: id,
                        url: `${process.env.MIX_WEB_API_URL}business/${id}?withBusinessDetail=1`,
                    })
                    .then((res) => {
                        let keys = [
                            "facebook_url",
                            "twitter_url",
                            "youtube_url",
                            "linked_url",
                            // "image",
                            "contact_name",
                            "logo",
                            "welcome_video",
                            "other_social_url",
                            "email",
                            "keywords",
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
                            data.map((res) => {
                                obj["detail_description_" + res.language_id] =
                                    res.detail_description;
                            });
                            this.$store.commit("business/setState", {
                                key: "detail_description",
                                value: obj,
                            });
                            data.map((res) => {
                                obj["media_section_description_" + res.language_id] =
                                    res.media_section_description;
                            });
                            this.$store.commit("business/setState", {
                                key: "media_section_description",
                                value: obj,
                            });
                            data.map((res) => {
                                obj["media_section_title_" + res.language_id] =
                                    res.media_section_title;
                            });
                            this.$store.commit("business/setState", {
                                key: "media_section_title",
                                value: obj,
                            });
                            this.isDataLoaded = 1;
                        }, 1000);

                        if (res.data.data.images) {
                            for (
                                var i = 0;
                                i < res.data.data.images?.length;
                                i++
                            ) {
                                this.$store.commit(
                                    "business/setImages",
                                    res.data.data.images[i]
                                );
                            }
                        }
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
        
    removeImage(index) {
            this.$store.commit("business/removeImage", index);
        },
        handleImageArray(e) {
            for (var i = 0; i < e.target.files.length; i++) {
                var file = new FormData();
                file.append("file", e.target.files[i]);
                axios.post("/api/web/image_again_upload", file).then((res) => {
                    this.$store.commit("business/setImages", res?.data);
                });
            }
        },
    },
    created() {
        this.$store.commit("business/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_WEB_API_URL}languages?getAll=1`,
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
                data.map((res) => {
                    obj["detail_description_" + res.id] = "";
                });
                this.$store.commit("business/setState", {
                    key: "detail_description",
                    value: obj,
                });
                data.map((res) => {
                    obj["media_section_title_" + res.id] = "";
                });
                this.$store.commit("business/setState", {
                    key: "media_section_title",
                    value: obj,
                });
                data.map((res) => {
                    obj["media_section_description_" + res.id] = "";
                });
                this.$store.commit("business/setState", {
                    key: "media_section_description",
                    value: obj,
                });
                if (this.business_id) {
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
    components: { Error,editor: Editor },
};
</script>
