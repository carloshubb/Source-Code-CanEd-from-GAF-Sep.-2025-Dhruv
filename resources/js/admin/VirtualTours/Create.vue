<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
        <header class="">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="can-edu-h1">{{isFormEdit ? 'Edit' : 'Create'}} virtual tour</h1>
                    <router-link
                        :to="{ name: 'admin.virtual_tours.index' }"
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
              Select language(s) of the virtual tour
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
                                (activeTab == null && language.is_default) ||
                                activeTab == language.id
                                    ? 'text-white bg-primary active'
                                    : '',
                                validationErros.has(
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
            <div class="relative z-0 w-full group mt-4 md:col-span-2">
                    <label for="description" class="block text-base lg:text-lg">Description / Title of the tour<span class="text-primary">*</span></label>
                    <textarea
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        name="description" @input="
                            handleMultipleInput(
                                'description',
                                $event.target.value,
                                language
                            )
                        "
                        :value="
                            form['description'] &&
                            form['description'][
                                `description_${language.id}`
                            ]
                                ? form['description'][
                                      `description_${language.id}`
                                  ]
                                : ''
                        "
                    ></textarea>
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
                <div class="relative z-0 w-full group">
                    <label for="color" class="block text-base lg:text-lg">Color<span class="text-primary">*</span></label>
                    <input
                        type="text"
                        name="color"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        @input="handleInput($event.target.value, 'color')"
                        :value="form['color'] ? form['color'] : ''"
                        
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has(`color`)"
                        v-text="validationErros.get(`color`)"
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label for="link" class="block text-base lg:text-lg">Virtual tour’s link<span class="text-primary">*</span></label>
                    <input
                        type="text"
                        name="link"
                        placeholder="Copy and paste the URL of the virtual tour web page"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        @input="handleInput($event.target.value, 'link')"
                        :value="form['link'] ? form['link'] : ''"
                        
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has(`link`)"
                        v-text="validationErros.get(`link`)"
                    ></p>
                </div>
                <!-- <div class="relative z-0 w-full group">
                    <label for="date" class="block text-base lg:text-lg">Deadline date</label>
                    <input
                        type="date"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        @input="handleInput($event.target.value, 'date')"
                        v-model="deadlineDate"
                        
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has(`date`)"
                        v-text="validationErros.get(`date`)"
                    ></p>
                </div> -->
                <div class="relative z-0 w-full group">
                    <label for="status" class="block text-base lg:text-lg">Status<span class="text-primary">*</span></label>
                    <select name="status"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        @input="handleInput($event.target.value, 'status')"
                    >
                        <option
                            :selected="form['status'] == 'pending'"
                            value="pending"
                        >
                            Pending
                        </option>
                        <option
                            :selected="form['status'] == 'approved'"
                            value="approved"
                        >
                            Approved
                        </option>
                    </select>
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has(`status`)"
                        v-text="validationErros.get(`status`)"
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label for="image" class="block text-base lg:text-lg">Image - This image appears on the search results page. It can be of your campus, facilities, buildings, special events, … etc.</label>
                    <p class="text-base">
                        (Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)<span class="text-primary">*</span>
                    </p>
                    <input
                        :key="`image`"
                        type="file"
                        :name="`image`"
                        :id="`image`"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        @input="handleImage($event, 'image')"
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has(`image`)"
                        v-text="validationErros.get(`image`)"
                    ></p>
                    <img
                        v-if="form['image']"
                        :src="form['image'] ? form['image'] : ''"
                        style="height: 100px; width: 100px"
                    />
                </div>

                <!-- <div class="relative z-0 w-full group">
                    <label for="image" class="block text-base lg:text-lg">Image</label>
                    <p class="text-base">(Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)</p>
                    <input
                        type="file"
                        name="image"
                        id="image"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        @change="handleImage"
                    />
       
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="imageError"
                        v-text="imageError"
                    ></p>
                    <img
                        v-if="form.image"
                        :src="form.image"
                        style="height: 100px; width: 100px"
                    />
                </div> -->
                
            </div>
            <ListErrors :validationErrors="validationErros" />
            <button type="submit" class="can-edu-btn-fill mb-2">Submit</button>
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
            isFormEdit: (state) => state.virtual_tours.isFormEdit,
            form: (state) => state.virtual_tours.form,
            validationErros: (state) => state.virtual_tours.validationErros,
            languages: (state) => state.languages.languages,
            schools: (state) => state.schools.schools,
        }),
    },
    data() {
        return {
            deadlineDate: "",
            activeTab: null,
            imageError: "",
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
        handleInput(value, key) {
            this.$store.commit("virtual_tours/setState", {
                key,
                value,
            });
            if (value.trim()) {
                this.validationErros.clear(key);
            }
        },
        handleMultipleInput(key, value, language) {
            this.$store.commit("virtual_tours/updateState", {
                value: value,
                id: language.id,
                key,
            });
            if (value.trim()) {
                this.validationErros.clear(`${key}.${key}_${language.id}`);
            }
        },
        addUpdateForm() {
            this.$store.dispatch("virtual_tours/addUpdateForm").then(() =>
                this.$router.push({
                    name: "admin.virtual_tours.index",
                })
            ).catch((error) => {
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
                    tinymceEditor.getBody().scrollIntoView({ behavior: "smooth", block: "center" });

                    setTimeout(() => {
                        tinymceEditor.focus();
                    }, 300);

                    return;
                } else {
                    console.log(`TinyMCE editor instance not found for ${editorId}`);
                }
            }

            if (inputElement) {
                console.log("Found input element:", inputElement);
                inputElement.scrollIntoView({ behavior: "smooth", block: "center" });

                setTimeout(() => {
                    inputElement.focus();
                }, 300);

            } else {
                console.log(`No input field found for ${fieldName}`);
            }
        },
        fetchVirtualTour() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("virtual_tours/setIsFormEdit", 1);
                this.$store
                    .dispatch("virtual_tours/fetchVirtualTour", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}virtual_tours/${id}?withSchoolDetail=1`,
                    })
                    .then((res) => {
                        let keys = [
                            "link",
                            "date",
                            "color",
                            "image",
                            "status",
                        ];
                        this.$store.commit("virtual_tours/setState", {
                            key: "id",
                            value: id,
                        });
                        if (res.data.data.date) {
              this.deadlineDate = res.data.data.date; 
            }
                        for (var i = 0; i < keys.length; i++) {
                            this.$store.commit("virtual_tours/setState", {
                                key: keys[i],
                                value: res.data.data[keys[i]],
                            });
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
                    });
            }
        },
        handleImage(e, key) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios
                .post("/api/admin/media/image_again_upload", file)
                .then((res) => {
                    this.$store.commit("virtual_tours/setState", {
                        key,
                        value: res?.data,
                    });
                    this.validationErros.clear(key);
                });
        },
        
    //     handleImage(e) {
    //     const file = e.target.files[0];
    //     const allowedFormats = ["image/jpeg", "image/jpg", "image/png"];
    //     const maxSize = 5 * 1024 * 1024; // 5 MB

    //     // Reset the error
    //     this.imageError = "";

    //     // Validate file size
    //     if (file.size > maxSize) {
    //         this.imageError = "File size exceeds 5MB. Please upload a JPEG, JPG, PNG within the allowed size.";
    //         return;
    //     }

    //     // Validate file format
    //     if (!allowedFormats.includes(file.type)) {
    //         this.imageError = "Uploaded file is not a valid image. Only JPEG, JPG, PNG files are allowed.";
    //         return;
    //     }

    //     // If validation passes, upload the image
    //     const formData = new FormData();
    //     formData.append("file", file);

    //     axios
    //         .post("/api/admin/media/image_again_upload", formData)
    //         .then((res) => {
    //             this.imageError = ""; // Clear any previous error
    //             this.$store.commit("virtual_tours/setState", {
    //                 key: "image",
    //                 value: res.data,
    //             });
    //         })
    //         .catch((err) => {
    //             this.imageError = "An error occurred while uploading the image.";
    //             console.error(err);
    //         });
    // },
    },
    created() {
        this.$store.commit("virtual_tours/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
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
                this.fetchVirtualTour();
            });
    },
};
</script>
