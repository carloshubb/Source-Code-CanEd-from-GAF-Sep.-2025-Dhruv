<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">{{ isFormEdit ? 'Edit' : 'Create' }} school scholarship</h1>
                        <router-link :to="{ name: 'admin.school_scholarships.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <header class="mt-3">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
                            Select language(s) of the school scholarship
                        </p>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                    <ul class="flex gap-2 flex-wrap my-4">
                        <li class="mr-2 mb-2" v-for="language in languages" :key="language.abbreviation">
                            <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                activeTab == language.abbreviation
                                    ? 'text-white bg-primary active'
                                    : '',
                                validationErros.has(
                                    `name.name_${language.abbreviation}`
                                ) ||
                                    validationErros.has(
                                        `summary.summary_${language.abbreviation}`
                                    ) ||
                                    validationErros.has(
                                        `criteria.criteria_${language.abbreviation}`
                                    )
                                    ? 'bg-red-600 text-white hover:text-white'
                                    : '',
                            ]">{{ language.name }}</a>
                        </li>
                    </ul>
                </div>
                <div class="grid my-5 md:grid-cols-2 md:gap-6" v-for="language in languages"
                    :key="language.abbreviation" :class="activeTab == language.abbreviation ? 'block' : 'hidden'">
                    <div class="relative z-0 w-full group md:col-span-2">
                        <label for="name" class="block text-base lg:text-lg">Scholarship name<span class="text-primary">*</span></label>
                        <input type="text" name="name" id="name"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleMultipleInput(
                                    'name',
                                    $event.target.value,
                                    language
                                )
                                " :value="form['name'] &&
                                    form['name'][`name_${language.abbreviation}`]
                                    ? form['name'][`name_${language.abbreviation}`]
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `name.name_${language.abbreviation}`
                            )
                        " v-text="validationErros.get(
                            `name.name_${language.abbreviation}`
                        )
                            "></p>
                    </div>
                    <div class="relative z-0 w-full group md:col-span-2" v-if="isDataLoaded">
                        <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`summary_${language.abbreviation}`"
                    ></div> -->
                        <label for="summary" class="block text-base lg:text-lg">Description<span class="text-primary">*</span></label>
                        <editor @selectionChange="
                            handleSelectionChange(
                                language,
                                'summary'
                            )
                            " :ref="`summary_${language.abbreviation}`" :id="`summary_${language.abbreviation}`"
                            :initial-value="form[`summary`][`summary_${language?.abbreviation}`]" :init="editorConfig"
                            :tinymce-script-src="tinymceScriptSrc" />

                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `summary.summary_${language.abbreviation}`
                            )
                        " v-text="validationErros.get(
                            `summary.summary_${language.abbreviation}`
                        )
                            "></p>
                    </div>
                    <div class="relative z-0 w-full group md:col-span-2">
                        <label for="title" class="block text-base lg:text-lg">Eligibility criteria<span class="text-primary">*</span></label>
                        <textarea name="criteria" @input="
                            handleMultipleInput(
                                'criteria',
                                $event.target.value,
                                language
                            )
                            "
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary">{{
                                form["criteria"] &&
                                    form["criteria"][
                                    `criteria_${language.abbreviation}`
                                    ]
                                    ? form["criteria"][
                                    `criteria_${language.abbreviation}`
                                    ]
                                    : ""
                            }}</textarea>
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `criteria.criteria_${language.abbreviation}`
                            )
                        " v-text="validationErros.get(
                            `criteria.criteria_${language.abbreviation}`
                        )
                            "></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="school_id" class="block text-base lg:text-lg">School</label>
                        <select name="school_id"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'school_id')">
                            <option value="">select</option>
                            <option v-for="(school, key) in schools" :selected="parseInt(form['school_id']) ==
                                parseInt(school?.id)
                                " :key="key" :value="school?.id">
                                {{
                                    school?.school_detail &&
                                        school?.school_detail?.length > 0
                                        ? school?.school_detail[0].school_name
                                        : ""
                                }}
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`school_id`)"
                            v-text="validationErros.get(`school_id`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="province" class="block text-base lg:text-lg">Province<span class="text-primary">*</span></label>
                        <select name="province"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'province')">
                            <option value="" selected="selected" disabled="disabled">
                                Province *
                            </option>
                            <option :selected="form['province'] == 'Alberta'" value="Alberta">
                                Alberta
                            </option>
                            <option :selected="form['province'] == 'British Columbia'" value="British Columbia">
                                British Columbia
                            </option>
                            <option :selected="form['province'] == 'Manitoba'" value="Manitoba">
                                Manitoba
                            </option>
                            <option :selected="form['province'] == 'New Brunswick'" value="New Brunswick">
                                New Brunswick
                            </option>
                            <option :selected="form['province'] == 'Newfoundland and Labrador'
                                " value="Newfoundland and Labrador">
                                Newfoundland and Labrador
                            </option>
                            <option :selected="form['province'] == 'Nova Scotia'" value="Nova Scotia">
                                Nova Scotia
                            </option>
                            <option :selected="form['province'] == 'Ontario'" value="Ontario">
                                Ontario
                            </option>
                            <option :selected="form['province'] == 'Prince Edward Island'
                                " value="Prince Edward Island">
                                Prince Edward Island
                            </option>
                            <option :selected="form['province'] == 'Quebec'" value="Quebec">
                                Quebec
                            </option>
                            <option :selected="form['province'] == 'Saskatchewan'" value="Saskatchewan">
                                Saskatchewan
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`province`)"
                            v-text="validationErros.get(`province`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="award" class="block text-base lg:text-lg">Awarded to</label>
                        <select name="award"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'award')">
                            <option value="" selected="selected" disabled="disabled" hidden="hidden">
                                Awards *
                            </option>
                            <option :selected="form['award'] == 'Admission'" value="Admission">
                                Admission
                            </option>
                            <option :selected="form['award'] == 'Current students'" value="Current students">
                                Current students
                            </option>
                            <option :selected="form['award'] ? form['award'] ==
                                'Admission and current students' : 'Admission and current students'
                                " value="Admission and current students">
                                All
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`award`)"
                            v-text="validationErros.get(`award`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="amount" class="block text-base lg:text-lg">Amount<span class="text-primary">*</span></label>
                        <input type="text" name="amount"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'amount')"
                            :value="form['amount'] ? form['amount'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`amount`)"
                            v-text="validationErros.get(`amount`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="action" class="block text-base lg:text-lg">Action<span class="text-primary">*</span></label>
                        <select name="action"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'action')">
                            <option value="" selected="selected" disabled="disabled" hidden="hidden">
                                Actions *
                            </option>
                            <option :selected="form['action'] == 'Application required'" value="Application required">
                                Application required
                            </option>
                            <option :selected="form['action'] == 'No application required'"
                                value="No application required">
                                No application required
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`action`)"
                            v-text="validationErros.get(`action`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="date_posted" class="block text-base lg:text-lg">Date posted<span class="text-primary">*</span></label>
                        <input type="date" name="date_posted"
            @click="openDatePicker($event)"

                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'date_posted')"
                            :value="form['date_posted'] ? form['date_posted'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`date_posted`)"
                            v-text="validationErros.get(`date_posted`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="expiry_date" class="block text-base lg:text-lg">Expiry date</label>
                        <input name="expiry_date"
                        type="date"
            @click="openDatePicker($event)"

                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'expiry_date')"
                            :value="form['expiry_date'] ? form['expiry_date'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`expiry_date`)"
                            v-text="validationErros.get(`expiry_date`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="deadline_date" class="block text-base lg:text-lg">Application deadline<span class="text-primary">*</span></label>
                        <input name="deadline_date"
                        type="date"
            @click="openDatePicker($event)"

                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'deadline_date')
                                " :value="form['deadline_date'] ? form['deadline_date'] : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`deadline_date`)"
                            v-text="validationErros.get(`deadline_date`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="availability" class="block text-base lg:text-lg">Available to</label>
                        <select name="availability"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="
                                handleInput($event.target.value, 'availability')
                                ">
                            <option value="" selected="selected" disabled="disabled" hidden="hidden">
                                Availability *
                            </option>
                            <option
                                :selected="form['availability'] ? form['availability'] == 'All students' : 'All students'"
                                value="All students">
                                All students
                            </option>
                            <option :selected="form['availability'] == 'International students'"
                                value="International students">
                                International students
                            </option>
                            <option :selected="form['availability'] == 'Canadian students'
                                " value="Canadian students">
                                Canadian (national) students
                            </option>
                            <option :selected="form['availability'] == 'Provincial students'
                                " value="Provincial students">
                                Canadian (provincial) students
                            </option>
                            <option :selected="form['availability'] == 'Black students'
                                " value="Black students">
                                Black students
                            </option> <option :selected="form['availability'] == 'Latino students'
                                " value="Latino students">
                                Latino students
                            </option> <option :selected="form['availability'] == 'Aborignal people'
                                " value="Aborignal people">
                                Natives / Aborignal People
                            </option> <option :selected="form['availability'] == 'Visible minorities'
                                " value="Visible minorities">
                                Visible minorities
                            </option> <option :selected="form['availability'] == 'Female Students'
                                " value="Female Students">
                                Female Students
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`availability`)"
                            v-text="validationErros.get(`availability`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="study_level" class="block text-base lg:text-lg">Study level</label>
                        <select name="study_level"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'study_level')">
                            <option value="" selected="selected" disabled="disabled" hidden="hidden">
                                Level of study *
                            </option>
                            <option :selected="form['study_level'] == 'School'" value="School">
                                School - primary and high
                            </option>
                            <option :selected="form['study_level'] == 'Graduate'" value="Graduate">
                                Graduate
                            </option>
                            <option :selected="form['study_level'] == 'Undergraduate'" value="Undergraduate">
                                Undergraduate
                            </option>
                            <option :selected="form['study_level'] ? form['study_level'] ==
                                'Graduate and undergraduate' : 'Graduate and undergraduate'
                                " value="Graduate and Undergraduate">
                                All
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`study_level`)"
                            v-text="validationErros.get(`study_level`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="duration" class="block text-base lg:text-lg">Duration</label>
                        <select name="duration"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'duration')">
                            <option value="" selected="selected" disabled="disabled" hidden="hidden">
                                Duration *
                            </option>
                            <option :selected="form['duration'] == 'Full time'" value="Full time">
                                Full-time
                            </option>
                            <option :selected="form['duration'] == 'Part time'" value="Part time">
                                Part-time
                            </option>
                            <option :selected="form['duration'] ? form['duration'] == 'All' : 'All'" value="All">
                                All
                            </option>
                        </select>

                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`duration`)"
                            v-text="validationErros.get(`duration`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="name" class="block text-base lg:text-lg">Apply now<span class="text-primary">*</span></label>
                        <input type="text" name="link" id="link"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleInput($event.target.value, 'link')"
                            :value="form['link'] ? form['link'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`link`)"
                            v-text="validationErros.get(`link`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="name" class="block text-base lg:text-lg">Read on original souce<span class="text-primary">*</span></label>
                        <input type="text" name="more_info_link" id="more_info_link"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput($event.target.value, 'more_info_link')
                                " :value="form['more_info_link'] ? form['more_info_link'] : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`more_info_link`)"
                            v-text="validationErros.get(`more_info_link`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="featured" class="block text-base lg:text-lg">Featured<span class="text-primary">*</span></label>
                        <select name="featured"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'featured')">
                            <option value="" selected="selected" disabled="disabled" hidden="hidden">
                                Do you want to show this scholarship in the
                                scholarship main page? *
                            </option>
                            <option :selected="form['featured'] == '1'" value="1">
                                Yes
                            </option>
                            <option :selected="form['featured'] == '0'" value="0">
                                No
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`featured`)"
                            v-text="validationErros.get(`featured`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="degree" class="block text-base lg:text-lg">Image</label>
                        <input :key="`image`" type="file" :name="`image`" :id="`image`"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleImage($event, 'image')" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`image`)"
                            v-text="validationErros.get(`image`)"></p>

                        <img v-if="form['image']" :src="form['image'] ? form['image'] : ''"
                            style="height: 100px; width: 100px" />
                    </div>
                </div>
                <ListErrors :validationErrors="validationErros" />

                <button type="submit" class="can-edu-btn-fill mb-2">Submit</button>
            </form>
        </div>
    </AppLayout>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            isFormEdit: (state) => state.school_scholarships.isFormEdit,
            form: (state) => state.school_scholarships.form,
            validationErros: (state) =>
                state.school_scholarships.validationErros,
            languages: (state) => state.languages.languages,
            schools: (state) => state.schools.schools,
        }),
    },
    components: {
        editor: Editor,
        ListErrors
    },
    data() {
        return {
            activeTab: "en",
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
        openDatePicker(event) {
        event.target.showPicker(); 
    },
        handleInput(value, key) {
            this.$store.commit("school_scholarships/setState", { key, value });
            if (value.trim()) {
                this.validationErros.clear(key);
            }
        },
        handleSelectionChange(language, key) {
            const editorInstance = tinymce.get(`${key}_${language.abbreviation}`);
            if (editorInstance) {
                this.$store.commit(`school_scholarships/updateState`, {
                    value: editorInstance.getContent(),
                    id: language.abbreviation,
                    key: key,
                });
                if (editorInstance.getContent().trim()) {
                    this.validationErros.clear(`${key}.${key}_${language.abbreviation}`);
                }
            } else {
                console.warn(`TinyMCE editor for ${key}_${language.abbreviation} is not initialized yet.`);
            }
            // this.$store.commit(`school_scholarships/updateState`, {
            //     value: tinymce.get(`${key}_${language.abbreviation}`).getContent(),
            //     id: language.abbreviation,
            //     key:key,
            // });
        },
        handleMultipleInput(key, value, language) {
            if (!language?.abbreviation) {
                console.warn("Language abbreviation is missing!");
                return;
            }
            this.$store.commit("school_scholarships/updateState", {
                value: value.trim(),
                id: language.abbreviation,
                key,
            });
            if (value.trim()) {
                this.validationErros.clear(`${key}.${key}_${language.abbreviation}`);
            }
        },
        addUpdateForm() {
            this.$store.dispatch("school_scholarships/addUpdateForm").then(() =>
                this.$router.push({
                    name: "admin.school_scholarships.index",
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
        changeLanguageTab(language) {
            this.activeTab = language.abbreviation;
        },
        fetchSchools() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("school_scholarships/setIsFormEdit", 1);
                this.$store
                    .dispatch("school_scholarships/fetchSchoolScholarships", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}school_scholarships/${id}?withSchoolDetail=1`,
                    })
                    .then((res) => {
                        console.log('main schol ship res', res);
                        let keys = [
                            "province",
                            "award",
                            "amount",
                            "action",
                            "date_posted",
                            "expiry_date",
                            "deadline_date",
                            "availability",
                            "study_level",
                            "duration",
                            "link",
                            "more_info_link",
                            "featured",
                            "image",
                            "school_id",
                        ];
                        this.$store.commit("school_scholarships/setState", {
                            key: "id",
                            value: id,
                        });
                        for (var i = 0; i < keys.length; i++) {
                            this.$store.commit("school_scholarships/setState", {
                                key: keys[i],
                                value: res.data.data[keys[i]],
                            });
                        }
                        let data =
                            res.data.data &&
                                res.data.data.school_scholarship_detail
                                ? res.data.data.school_scholarship_detail
                                : [];
                        let obj = {};
                        data.map((res) => {
                            obj["name_" + res.language_code] = res.name;
                        });
                        this.$store.commit("school_scholarships/setState", {
                            key: "name",
                            value: obj,
                        });

                        obj = {};
                        data.map((res) => {
                            obj["criteria_" + res.language_code] = res.criteria;
                            console.log("res criteria:", res.criteria);
                        });
                        this.$store.commit("school_scholarships/setState", {
                            key: "criteria",
                            value: obj,
                        });
                        console.log("Loaded criteria data in Vuex store:", this.$store.state.school_scholarships.form['criteria']);
                        obj = {};
                        data.map((res) => {
                            obj["summary_" + res.language_code] =
                                res.summary;
                            console.log("res summary:", res.summary);
                        });
                        this.$store.commit("school_scholarships/setState", {
                            key: "summary",
                            value: obj,
                        });
                        console.log("Loaded summary data in Vuex store:", this.$store.state.school_scholarships.form['summary']);
                        this.isDataLoaded = 1;
                    });
            }
        },
        handleImage(e, key) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios
                .post("/api/admin/media/image_again_upload", file)
                .then((res) => {
                    this.$store.commit("school_scholarships/setState", {
                        key,
                        value: res?.data,
                    });
                });
        },
    },
    created() {
        this.$store.commit("school_scholarships/resetForm");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_ADMIN_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                let obj = {};
                data.map((res) => {
                    obj["name_" + res.abbreviation] = "";
                });
                this.$store.commit("school_scholarships/setState", {
                    key: "name",
                    value: obj,
                });
                data.map((res) => {
                    obj["summary_" + res.abbreviation] = "";
                });
                this.$store.commit("school_scholarships/setState", {
                    key: "summary",
                    value: obj,
                });
                console.log("Loaded summary data in Vuex store:", this.$store.state.school_scholarships.form['summary']);
                data.map((res) => {
                    obj["criteria_" + res.abbreviation] = "";
                });
                this.$store.commit("school_scholarships/setState", {
                    key: "criteria",
                    value: obj,
                });
                if (this.$route.params.id) {
                    this.fetchSchools();
                }
                else {
                    this.isDataLoaded = 1;
                }
            });
        this.$store.commit("schools/setLimit", 100);
        this.$store.commit("schools/setSortBy", "id");
        this.$store.commit("schools/setSortType", "desc");
        this.$store.dispatch("schools/fetchSchools");
    },
};
</script>
