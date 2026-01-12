<template>
    <div
        class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full p-3 md:p-0"
    >
        <div class="md:mt-4 flex justify-between gap-2 p-2">
            <h2 class="text-primary px-2 can-school-h2">
                Edit open house day
            </h2>
        </div>
        <div class="md:mt-6 w-full md:w-8/12 md:ml-4">
            <div
                class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
            >
            <h3 data-v-181db5a2="" class="text-left">Language</h3>
            <p data-v-181db5a2="" class="text-left text-base font-normal text-gray-700">Select the website languages under which you want your Open House to appear</p>
                <ul class="flex gap-2 flex-wrap my-4">
                    <li
                        class="mr-2 mb-2"
                        v-for="language in languages"
                        :key="language.code"
                    >
                        <a
                            @click.prevent="changeLanguageTab(language)"
                            href="#"
                            :class="[
                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                activeTab != null &&
                                activeTab == language.language_code
                                    ? 'text-white bg-primary active'
                                    : '',
                                errors.has(`title.title_${language.code}`)
                                    ? 'bg-red-600 text-white hover:text-white'
                                    : '',
                            ]"
                            >{{ language.language_code }}</a
                        >
                    </li>
                </ul>
            </div>
            <div class="flex justify-end">
                <p class="text-red-500">
                    {{ indicate_required_field }}
                </p>
            </div>
            <div
                class="w-full mt-2 relative"
                v-for="language in languages"
                :key="language.language_code"
                :class="
                    activeTab == language.language_code ? 'block' : 'hidden'
                "
            >
                <label for="" class="block text-base lg:text-lg">Title</label>
                <input
                    type="text" name="title"
                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInputDetail($event, 'title', language)"
                    :value="
                        form['title'] &&
                        form['title'][`title_${language.language_code}`]
                            ? form['title'][`title_${language.language_code}`]
                            : ''
                    "
                />
                <error
                    :fieldName="`title.title_${language.language_code}`"
                    :validationErros="errors"
                />
            </div>
            <div
                class="w-full mt-2 relative"
                v-for="language in languages"
                :key="language.language_code"
                :class="
                    activeTab == language.language_code ? 'block' : 'hidden'
                "
            >
                <label for="" class="block text-base lg:text-lg">Description <span class="text-primary">*</span></label>
                <textarea
                    placeholder="300 words max. Describe your Open House to the students, potential guests and visitors"
                    name="description"
                    id=""
                    cols="5"
                    rows="5"
                    class="border border-l-[5px] w-full border-l-primary border-gray-300 rounded mt-4 p-3 focus:outline-none focus:ring-none"
                    @input="handleInputDetail($event, 'description', language)"
                    >{{
                        form["description"] &&
                        form["description"][
                            `description_${language.language_code}`
                        ]
                            ? form["description"][
                                  `description_${language.language_code}`
                              ]
                            : ""
                    }}</textarea
                >
                <error
                    :fieldName="`description.description_${language.language_code}`"
                    :validationErros="errors"
                />
            </div>
            <div class="relative mt-2">
                <label for="" class="block text-base lg:text-lg">Address <span class="text-primary">*</span></label>
                <input
                    type="text"
                    name="address"
                    placeholder="Street name and number"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'address')"
                    :value="form?.address ? form.address : ''"
                />
                <div class="relative tooltip -bottom-4 group-hover:flex">
                    <p
                        class="relative tooltiptext -top-2 wfull z-10 leading-none transition duration-150 ease-in-out shadow-lg p-2 py-2.5 flex bg-red-100 border border-primary text-primary text-sm lg:text-base w_full md:w_half w-fit rounded"
                    v-if="errors.has('address')"
                    v-text="errors.get('address')"
                ></p>
                </div>
            </div>

            <div class="relative mt-2">
                <label for="" class="block text-base lg:text-lg">City <span class="text-primary">*</span></label>
                <input
                name="city"
                    type="text"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'city')"
                    :value="form?.city ? form.city : ''"
                />
                <error :fieldName="`city`" :validationErros="errors" />
            </div>
            <div class="relative mt-2">
                <label for="" class="block text-base lg:text-lg">Postal code <span class="text-primary">*</span></label>
                <input
                name="postal_code"
                    type="text"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'postal_code')"
                    :value="form?.postal_code ? form.postal_code : ''"
                />
                <error :fieldName="`postal_code`" :validationErros="errors" />
            </div>

            <div class="relative mt-2">
                <label for="" class="block text-base lg:text-lg">Country <span class="text-primary">*</span></label>
                <input
                name="country"
                    type="text"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'country')"
                    :value="form?.country ? form.country : ''"
                />
                <error :fieldName="`country`" :validationErros="errors" />
            </div>
            <div class="relative mt-2">
                <label for="" class="block text-base lg:text-lg">Date <span class="text-primary">*</span></label>
                <input
                    type="date"
                    name="date"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'date')"
                    :value="form?.date ? form.date : ''"
                />
                <error :fieldName="`date`" :validationErros="errors" />
            </div>

            <div class="relative mt-2">
                <label for="" class="block text-base lg:text-lg">Time <span class="text-primary">*</span></label>
                <input
                    type="time"
                    name="time"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'time')"
                    :value="form?.time ? form.time : ''"
                />
                <error :fieldName="`time`" :validationErros="errors" />
            </div>

            <div class="relative mt-2">
                <label for="" class="block text-base lg:text-lg">School email <span class="text-primary">*</span></label>
                <input
                    type="email"
                    name="school_email"
                    placeholder="School email *"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'school_email')"
                    :value="form?.school_email ? form.school_email : ''"
                />
                <error :fieldName="`school_email`" :validationErros="errors" />
            </div>

            <div class="relative mt-2">
                <label for="" class="block text-base lg:text-lg">Phone <span class="text-primary">*</span></label>
                <input
                name="school_phone"
                    type="text"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'school_phone')"
                    :value="form?.school_phone ? form.school_phone : ''"
                />
                <error :fieldName="`school_phone`" :validationErros="errors" />
            </div>

            <div class="relative mt-2">
                <label for="" class="block text-base lg:text-lg">Open House URL</label>
                <input
                name="open_day_url"
                placeholder="If you have a web page about your Open House, or about your school in general, you can add it here"
                    type="text"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'open_day_url')"
                    :value="form?.open_day_url ? form.open_day_url : ''"
                />
                <error :fieldName="`open_day_url`" :validationErros="errors" />
            </div>
          

            <div class="relative mt-2">
                <label class="block text-base lg:text-lg">Image</label>
                <p class="text-base">
                   (Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)
                </p>
                <input
                    type="file"
                    name="image"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @change="handleImage($event)"
                />
                <error :fieldName="`image`" :validationErros="errors" />
                <div v-if="form['image']" class="w-40 h-40 bg-gray-50 border rounded mt-4">
                    <img :src="form?.image ? form.image : ''" class="w-full h-full object-contain"  />
                </div>
            </div>
            <button
                class="my-4 can-edu-btn-fill"
                @click="addUpdate"
            >
                Submit
            </button>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import Error from "../../Error.vue";
export default {
    components: { Error },
    props: ["logged_in_customer","school_id","open_day_id","lang","slug","indicate_required_field"],
    computed: {
        ...mapState({
            form: (state) => state.open_days.form,
            open_days: (state) => state.open_days.open_days,
            pagination: (state) => state.open_days.pagination,
            errors: (state) => state.open_days.validationErros,
            searchParam: (state) => state.open_days.searchParam,
            loading: (state) => state.open_days.loading,
            languages: (state) => state.open_days.form.languages,
        }),
    },
    data() {
        return {
            activeTab: "en",
        };
    },
    methods: {
        changeLanguageTab(language) {
            this.activeTab = language.language_code;
        },

        handleInputDetail(e, key, language) {
            this.$store.commit("open_days/setForData", {
                key,
                language,
                value: e.target.value,
            });
        },
        handleInput(e, key) {
            this.$store.commit("open_days/setOpenDay", {
                key,
                value: e.target.value,
            });
        },
        addUpdate() {
            this.$store.dispatch("open_days/addUpdateForm").then((res) => {
                window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/open-house";
            })
            .catch((error) => {
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
          tinymceEditor.focus();
          tinymceEditor.getBody().scrollIntoView({ behavior: "smooth", block: "center" });
          return;
        } else {
          console.log(`TinyMCE editor instance not found for ${editorId}`);
        }
      }

      if (inputElement) {
        console.log("Found input element:", inputElement);
        inputElement.scrollIntoView({ behavior: "smooth", block: "center" });
        inputElement.focus();
      } else {
        console.log(`No input field found for ${fieldName}`);
      }
    },
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.$store.commit("open_days/setOpenDay", {
                    key: "image",
                    value: res?.data,
                });
            });
        },
    },
    created() {
        this.$store.commit("open_days/setOpenDay", {
            key: "customer_id",
            value: this.logged_in_customer,
        });
        this.$store.commit("open_days/setOpenDay", {
            key: "id",
            value: this.open_day_id,
        });
        this.$store.commit("open_days/setOpenDay", {
            key: "school_id",
            value: this.school_id,
        });

        this.$store.commit("open_days/setIsFormEdit", 1);
    },
    mounted() {
        axios
            .get(
                "/api/web/customer-languages?customer_id=" +
                    this.logged_in_customer
            )
            .then((res) => {
                if (res.data.status == "Success") {
                    this.$store.commit("open_days/setLanguages", res.data.data);

                    res.data.data?.filter((lang) => {
                        this.$store.commit("open_days/setForData", {
                            key: "title",
                            language: lang,
                            value: "",
                        });
                        this.$store.commit("open_days/setForData", {
                            key: "description",
                            language: lang,
                            value: "",
                        });
                    });
                    this.$store.dispatch("open_days/fetchOpenDay", {
                        id: this.open_day_id,
                    });
                }
            });
    },
};
</script>
