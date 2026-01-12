<template>
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full">
        <div class="mt-4 flex justify-between items-center gap-2 p-2">
            <h2 class="px-4 can-school-h2 text-primary">Create video</h2>
        </div>
        <div class="w-full"
            v-if="(logged_in_user_type == 'school' && is_package_amount_paid > 0) || (logged_in_user_type == 'business' && is_package_amount_paid > 0)">
            <form class="py-4 px-4 bg-white" @submit.prevent="addUpdateForm()">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                    <ul class="flex gap-2 flex-wrap my-4">
                        <li class="mr-2 mb-2" v-for="language in languages" :key="language.id">
                            <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                (activeTab == null &&
                                    language.is_default) ||
                                    activeTab == language.id
                                    ? 'text-white bg-primary active'
                                    : '',
                                validationErros.has(
                                    `title.title_${language.id}`
                                )
                                    ? 'bg-red-600 text-white hover:text-white'
                                    : '',
                            ]">{{ language.name }}</a>
                        </li>
                    </ul>
                </div>

                <div class="w-full md:gap-6" v-for="language in languages" :key="language.id" :class="(activeTab == null && language.is_default) ||
                    activeTab == language.id
                    ? 'block'
                    : 'hidden'
                    ">
                    <div class="relative w-full mt-2">
                        <label for="title" class="block text-base lg:text-lg">{{
                            video_create_translation?.create_video_title }}</label>
                        <input type="text" name="title" id="title"
                            class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            placeholder=" " @input="
                                handleTitleInput($event.target.value, language)
                                " :value="form['title'] &&
                                    form['title'][`title_${language.id}`]
                                    ? form['title'][`title_${language.id}`]
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(`title.title_${language.id}`)
                        " v-text="validationErros.get(`title.title_${language.id}`)
                            "></p>
                    </div>
                </div>

                <div class="w-full md:gap-6" v-for="language in languages" :key="language.id" :class="(activeTab == null && language.is_default) ||
                    activeTab == language.id
                    ? 'block'
                    : 'hidden'
                    ">
                    <div class="relative w-full mt-2">
                        <label for="description" class="block text-base lg:text-lg mb-2">{{
                            video_create_translation?.create_video_description }}</label>
                        <div class="mt-5" :id="'description_' + language.id"></div>
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `description.description_${language.id}`
                            )
                        " v-text="validationErros.get(
                            `description.description_${language.id}`
                        )
                            "></p>
                    </div>
                </div>

                <div class="">
                    <div class="relative w-full mt-2">
                        <label for="link" class="block text-base lg:text-lg">{{
                            video_create_translation?.create_video_link }}</label>
                        <input type="text" name="link" id="link"
                            class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            placeholder=" " @input="handleLink($event.target.value)" :value="form['link']
                                ? form['link']
                                : ''
                                " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`link`)"
                            v-text="validationErros.get(`link`)"></p>
                    </div>
                </div>
                <button type="submit" class="can-edu-btn-fill my-4">{{
                    video_create_translation?.create_video_submit_button }}</button>
            </form>
        </div>

        <div class="mt-6 w-full" v-else>
            <form class="py-4 px-4 bg-white" @submit.prevent="addUpdateForm()">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                    <ul class="flex gap-2 flex-wrap my-4">
                        <li class="mr-2 mb-2" v-for="language in languages" :key="language.id">
                            <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                (activeTab == null &&
                                    language.is_default) ||
                                    activeTab == language.id
                                    ? 'text-white bg-primary active'
                                    : '',
                                validationErros.has(
                                    `title.title_${language.id}`
                                )
                                    ? 'bg-red-600 text-white hover:text-white'
                                    : '',
                            ]">{{ language.name }}</a>
                        </li>
                    </ul>
                </div>

                <div class="w-full md:gap-6" v-for="language in languages" :key="language.id" :class="(activeTab == null && language.is_default) ||
                    activeTab == language.id
                    ? 'block'
                    : 'hidden'
                    ">
                    <div class="relative w-full mt-2">
                        <label for="title" class="block text-base lg:text-lg">{{
                            video_create_translation?.create_video_title }}</label>
                        <input type="text" name="title" id="title"
                            class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            placeholder=" " @input="
                                handleTitleInput($event.target.value, language)
                                " :value="form['title'] &&
                                    form['title'][`title_${language.id}`]
                                    ? form['title'][`title_${language.id}`]
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(`title.title_${language.id}`)
                        " v-text="validationErros.get(`title.title_${language.id}`)
                            "></p>
                    </div>
                </div>

                <div class="w-full md:gap-6" v-for="language in languages" :key="language.id" :class="(activeTab == null && language.is_default) ||
                    activeTab == language.id
                    ? 'block'
                    : 'hidden'
                    ">
                    <div class="relative w-full mt-2">
                        <label for="description" class="block text-base lg:text-lg mb-2">{{
                            video_create_translation?.create_video_description }}</label>
                        <div class="mt-5" :id="'description_' + language.id"></div>
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `description.description_${language.id}`
                            )
                        " v-text="validationErros.get(
                            `description.description_${language.id}`
                        )
                            "></p>
                    </div>
                </div>

                <div class="">
                    <div class="relative w-full mt-2">
                        <label for="link" class="block text-base lg:text-lg">{{
                            video_create_translation?.create_video_link }}</label>
                        <input type="text" name="link" id="link"
                            class="border w-full border-l-[5px] focus:ring-none mt-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            placeholder=" " @input="handleLink($event.target.value)" :value="form['link']
                                ? form['link']
                                : ''
                                " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`link`)"
                            v-text="validationErros.get(`link`)"></p>
                    </div>
                </div>
                <button type="submit" class="can-edu-btn-fill my-4">{{
                    video_create_translation?.create_video_submit_button }}</button>
            </form>
            <transition name="slide">
                <div id="defaultModal" tabindex="-1" aria-hidden="true"
                    class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
                    v-if="showModal">
                    <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                        ref="elementToDetectClick">
                        <div class="">
                            <div class="absolute top-3 right-3 cursor-pointer" @click="toggleModal">
                                <button type="button"
                                    class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="defaultModal">
                                    <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                                <p class="text-center can-edu-p mt-2">

                                    This feature is available exclusively to our Premium
                                    and Featured schools.
                                </p>
                                <div class="flex justify-center">
                                    <button type="button"
                                        class="can-edu-btn-fill  whitespace-nowrap px-2.5 md:px-5 mt-4"
                                        @click="toggleModal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
    <transition name="slide">
        <div id="defaultModal" tabindex="-1" aria-hidden="true"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="showPopUpModal">
            <div class="relative w-full rounded-2xl shadow-2xl border-4 bg-white border-primary/30 h-full max-w-lg md:h-auto"
                ref="elementToDetectClick">
                <div class="relative">
                    <div class="absolute top-3 right-3 cursor-pointer" @click="togglePopUpModal">
                        <button type="button"
                            class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="defaultModal">
                            <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                        <p class="text-center can-edu-p mt-2">
                            {{
                                popupMsg
                            }}
                        </p>
                        <div class="flex justify-center">
                            <button type="button" class="can-edu-btn-fill  whitespace-nowrap px-2.5 md:px-5 mt-4"
                                @click="togglePopUpModal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import { mapState } from "vuex";
export default {
    props: {
        school_id: String,
        slug: String,
        lang: String,
        logged_in_customer: String,
        logged_in_user_type: String,
        is_package_amount_paid: String,
        video_create_translation: {
            type: Object, // or Array, depending on your data
            required: true
        }
    },
    computed: {
        ...mapState({
            form: (state) => state.videos.form,
            validationErros: (state) => state.videos.validationErros,
            languages: (state) => state.languages.languages,
        }),
    },
    data() {
        return {
            showPopUpModal: false,
            popupMsg: '',
            activeTab: null,
            showModal: false,
        };
    },
    methods: {
        togglePopUpModal() {
            this.showPopUpModal = !this.showPopUpModal;
            if (!this.showPopUpModal) {
                window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/videos";
            }
        },
        handleClickOutsidePopup(event) {
            // // Check if the click target is not within the element
            if (
                this.$refs.elementToDetectClick &&
                event.target.contains(this.$refs.elementToDetectClick)
            ) {
                // Clicked outside the element, you can perform actions here
                if (this.showPopUpModal == true) {
                    this.showPopUpModal = false;
                    window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/videos";

                }
            }
        },
        handleClickOutside(event) {
            if (
                this.$refs.elementToDetectClick &&
                !this.$refs.elementToDetectClick.contains(event.target)
            ) {
                if (this.showModal) {
                    this.showModal = false;
                    window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/videos";
                }
            }
        },
        toggleModal() {
            this.showModal = !this.showModal;
            if (!this.showModal) {
                window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile/videos";
            }
        },
        handleLink(value) {
            this.$store.commit("videos/setLink", value);
            if (this.validationErros.has("link")) {
                this.validationErros.clear("link");
            }

        },
        handleTitleInput(value, language) {
            this.$store.commit("videos/updateTitle", {
                title: value,
                id: language.id,
            });
            if (this.validationErros.has(`title.title_${language.id}`)) {
                this.validationErros.clear(`title.title_${language.id}`);
            }
        },
        addUpdateForm() {
            this.$store.dispatch("videos/addUpdateForm").then((res) => {
                this.showPopUpModal = true;
                this.popupMsg = res.data.message;
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
                const ckeditorInstance = CKEDITOR?.instances[editorId];

                if (ckeditorInstance) {
                    console.log(`Focusing on CKEditor instance: ${editorId}`);
                    ckeditorInstance.focus();

                    const ckeditorContainer = ckeditorInstance.element?.$;
                    if (ckeditorContainer) {
                        console.log("Scrolling CKEditor container into view");
                        ckeditorContainer.scrollIntoView({ behavior: "smooth", block: "center" });
                    }
                    return;
                }

                const tinymceEditor = window.tinymce?.get(editorId);
                if (tinymceEditor) {
                    console.log(`Focusing on TinyMCE editor: ${editorId}`);
                    tinymceEditor.focus();

                    const tinymceContainer = tinymceEditor.getContainer();
                    if (tinymceContainer) {
                        console.log("Scrolling TinyMCE container into view");
                        tinymceContainer.scrollIntoView({ behavior: "smooth", block: "center" });
                    }
                    return;
                } else {
                    console.log(`No rich text editor instance found for ${editorId}`);
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
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
    },
    created() {
        this.$store.commit("videos/resetForm");
        this.$store.commit("videos/setForm", {
            key: "customer_id",
            value: this.logged_in_customer,
        });
        this.$store.commit("videos/setForm", {
            key: "school_id",
            value: this.school_id,
        });
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_WEB_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                let sd = {};
                let d = {};
                data.map((res, i) => {
                    CKEDITOR.replace("description_" + res.id);
                    obj["title_" + res.id] = "";
                });
                setTimeout(() => {
                    data.map((res, i) => {
                        sd["description_" + res.id] = "";
                        if (
                            CKEDITOR?.instances["description_" + res.id]
                        ) {
                            let ctx = this;
                            CKEDITOR.instances[
                                "description_" + res.id
                            ].on("change", function () {
                                let value =
                                    CKEDITOR.instances[
                                        "description_" + res.id
                                    ].getData();
                                ctx.$store.commit(
                                    "videos/updateDescription",
                                    {
                                        description: value,
                                        id: data[i].id,
                                    }
                                );
                                if (value.trim() !== "") {
                                    ctx.validationErros.clear(`description.description_${res.id}`);
                                }
                            });
                        }
                    });
                }, 1000);
                this.$store.commit("videos/setTitle", obj);
                this.$store.commit("videos/setDescription", sd);
            });
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutside);
        document.removeEventListener("click", this.handleClickOutsidePopup);

    },

    mounted() {
        console.log('Translations:', this.video_create_translation);
        document.addEventListener("click", this.handleClickOutside);
        document.addEventListener("click", this.handleClickOutsidePopup);

        this.toggleModal();
        console.log('this.is_package_amount_paid_create', this.is_package_amount_paid);
        console.log('this.logged_in_user_type_create', this.logged_in_user_type);
    }
};
</script>
<style scoped>
/* Slide Animation */
.slide-enter-active,
.slide-leave-active {
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}

.slide-enter-from,
.slide-leave-to {
    transform: translateY(-20px);
    opacity: 0;
}
</style>