<template>
    <div
        class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full p-3 md:p-0"
    >
        <div class="md:mt-4 flex justify-between gap-2 p-2">
            <h2 class="px-2 can-school-h2 text-primary">Edit virtual tour</h2>
        </div>
        <div class="md:mt-6 w-full md:w-8/12 md:ml-4">
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
                                errors.has(
                                    `description.description_${language.id}`
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
                class=""
                v-for="language in languages"
                :key="language.id"
                :class="
                    (activeTab == null && language.is_default) ||
                    activeTab == language.id
                        ? 'block'
                        : 'hidden'
                "
            >
            <div class="relative z-0 w-full mb-2 group mt-4">
                    <label class="block text-base lg:text-lg mb-2">Description</label>
                    <textarea
                    placeholder="Describe the Virtual tour in no more than 20 words"
                    class="w-full focus:ring-primary focus:ring-1 focus:ring-.5 focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    name="description" :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                        @input="
                            handleMultipleInput(
                                'description',
                                $event.target.value,
                                language
                            )
                        "
                        :value="
                            form['description'] &&
                            form['description'][`description_${language.id}`]
                                ? form['description'][
                                      `description_${language.id}`
                                  ]
                                : ''
                        "
                    ></textarea>
                    <error
                        :fieldName="`description.description_${language.id}`"
                        :validationErros="errors"
                    />
                </div>
            </div>
            <div class="relative">
                <label class="block text-base lg:text-lg">Color</label>
                <input
                name="color"
                    type="text"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'color')"
                    :value="form?.color ? form.color : ''"
                />
                <error :fieldName="`color`" :validationErros="errors" />
            </div>
            <div class="relative">
                <label class="block text-base lg:text-lg">Deadline Date</label>
                <input
                name="date"
                    type="date"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'date')"
                     v-model="deadlineDate"
                />
                <error :fieldName="`date`" :validationErros="errors" />
            </div>

            <div class="relative">
                <label class="block text-base lg:text-lg">Link</label>
                <input
                name="link"
                    type="text"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'link')"
                    :value="form?.link ? form.link : ''"
                />
                <error :fieldName="`link`" :validationErros="errors" />
            </div>

            <div class="relative">
                <label class="block text-base lg:text-lg">Image</label>
                <p class="text-base">
                    (Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)
                </p>
                <input
                name="image"
                    type="file"
                    class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @change="handleImage($event)"
                />
                <error :fieldName="`image`" :validationErros="errors" />
                <div v-if="form['image']" class="w-40 h-40 rounded bg-gray-50 border mt-4">
                    <img :src="form?.image ? form.image : ''" class="w-full h-full object-contain" />
                </div>
            </div>
            <button class="mt-4 can-edu-btn-fill" @click="addUpdate">
                Submit
            </button>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import Error from "../../Error.vue";
export default {
    components: {
        Error,
    },
    props: ["logged_in_customer", "virtual_tour_id", "school_id", "lang", "slug"],
    computed: {
        ...mapState({
            form: (state) => state.virtual_tours.form,
            virtual_tours: (state) => state.virtual_tours.virtual_tours,
            pagination: (state) => state.virtual_tours.pagination,
            errors: (state) => state.virtual_tours.validationErros,
            searchParam: (state) => state.virtual_tours.searchParam,
            loading: (state) => state.virtual_tours.loading,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            deadlineDate:"",
            activeTab: null,
        };
    },
    watch:{
        deadlineDate(newValue) {
      if (newValue) {
        let parts = newValue.split("-");
        if (parts[0].length > 4) {
          parts[0] = parts[0].slice(0, 4); 
        }
        this.deadlineDate = parts.join("-");
      }
    }
    },
    methods: {
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        handleInput(e, key) {
            this.$store.commit("virtual_tours/setState", {
                key,
                value: e.target.value,
            });
        },
        handleMultipleInput(key, value, language) {
            this.$store.commit("virtual_tours/updateState", {
                value: value,
                id: language.id,
                key,
            });
        },
        addUpdate() {
            this.$store.dispatch("virtual_tours/addUpdateForm").then((res) => {
                window.location.href =
                    "/" + this.lang + "/" + this.slug + "/our-profile/virtual-tour";
            }).catch((error) => {
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
                this.$store.commit("virtual_tours/setState", {
                    key: "image",
                    value: res?.data,
                });
            });
        },
    },
 
 
    created() {
    this.$store.commit("virtual_tours/setState", {
        key: "customer_id",
        value: this.logged_in_customer,
    });
    this.$store.commit("virtual_tours/setState", {
        key: "school_id",
        value: this.school_id,
    });
    this.$store.commit("virtual_tours/setState", {
        key: "id",
        value: this.virtual_tour_id,
    });

    // Fetch languages first
    this.$store
        .dispatch("languages/fetchLanguages", {
            url: `${process.env.MIX_WEB_API_URL}languages?getAll=1`,
        })
        .then((res) => {
            let data = res.data.data;
            let obj = {};
            data.map((res) => {
                obj["description_" + res.id] = "";
            });
            this.$store.commit("virtual_tours/setState", {
                key: "description",
                value: obj,
            });

            // Then fetch the virtual tour details
            return this.$store.dispatch("virtual_tours/fetchVirtualTour", {
                id: this.virtual_tour_id,
            });
        })
        .then((res) => {
            let keys = ["link", "color", "image", "date", "status", "description"];
            for (var i = 0; i < keys.length; i++) {
                this.$store.commit("virtual_tours/setState", {
                    key: keys[i],
                    value: res.data.data[keys[i]],
                });
                if (res.data.data.date) {
                    this.deadlineDate = res.data.data.date;
                }
            }

            let data =
                res.data.data && res.data.data.virtual_tour_detail
                    ? res.data.data.virtual_tour_detail
                    : [];
            let obj = {};
            data.map((res) => {
                obj["description_" + res.language_id] = res.description;
            });
            this.$store.commit("virtual_tours/setState", {
                key: "description",
                value: obj,
            });
        })
        .catch((err) => {
            console.error("Error fetching data", err);
        });

    this.$store.commit("virtual_tours/setIsFormEdit", 1);
}

};
</script>
