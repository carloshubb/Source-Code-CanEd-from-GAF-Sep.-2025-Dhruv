<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">{{ isFormEdit ? 'Edit' : 'Create' }} school</h1>
                        <router-link :to="{ name: 'admin.schools.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
                <div v-if="$route?.params?.id">
                    <other-options type="information" :id="$route?.params?.id" />
                </div>
            </header>
            <header class="mt-3">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <p class="block text-base lg:text-lg  font-FuturaMdCnBT text-primary">
                            Select language(s) of the school
                        </p>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div
                    class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                    <ul class="flex flex-wrap my-4">
                        <li class="mr-2 mb-2" v-for="language in languages" :key="language.abbreviation">
                            <a @click.prevent="changeLanguageTab(language)" href="#" :class="[
                                'inline-block py-2 px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-base lg:text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                                activeTab == language.abbreviation
                                    ? 'text-white bg-primary active'
                                    : '',
                                validationErros.has(
                                    `school_name.school_name_${language.abbreviation}`
                                ) ||
                                    validationErros.has(
                                        `description.description_${language.abbreviation}`
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
                        <label for="school_name" class="block text-base lg:text-lg">School Name<span class="text-primary">*</span></label>
                        <input type="text" name="school_name" id="school_name"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleMultipleInput(
                                    'school_name',
                                    $event.target.value,
                                    language
                                )
                                " :value="form['school_name'] &&
                                form['school_name'][
                                `school_name_${language.abbreviation}`
                                ]
                                ? form['school_name'][
                                `school_name_${language.abbreviation}`
                                ]
                                : ''
                            " />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `school_name.school_name_${language.abbreviation}`
                            )
                        " v-text="validationErros.get(
                            `school_name.school_name_${language.abbreviation}`
                        )
                            "></p>
                    </div>
                    <div class="relative z-0 w-full group md:col-span-2" v-if="isDataLoaded">
                        <!-- <div
                        class="mt-5 ckeditorText"
                        :id="`description_${language.abbreviation}`"
                    ></div> -->
                        <label for="description" class="block text-base lg:text-lg">Description<span class="text-primary">*</span></label>
                        <editor @selectionChange="
                            handleSelectionChange(
                                language,
                                'description'
                            )
                            " :ref="`description_${language.abbreviation}`"
                            :id="`description_${language.abbreviation}`" :initial-value="form[`description`][`description_${language?.abbreviation}`]
                                " :init="editorConfig" :tinymce-script-src="tinymceScriptSrc" />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `description.description_${language.abbreviation}`
                            )
                        " v-text="validationErros.get(
                            `description.description_${language.abbreviation}`
                        )
                            "></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="website_url" class="block text-base lg:text-lg">Website URL<span class="text-primary">*</span></label>
                        <input name="website_url"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'website_url')"
                            :value="form['website_url'] ? form['website_url'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`website_url`)"
                            v-text="validationErros.get(`website_url`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="email" class="block text-base lg:text-lg">Email<span class="text-primary">*</span></label>
                        <input name="email"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'email')"
                            :value="form['email'] ? form['email'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`email`)"
                            v-text="validationErros.get(`email`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="phone" class="block text-base lg:text-lg">Phone<span class="text-primary">*</span></label>
                        <input type="text" name="phone"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder="With area code" @input="handleInput($event.target.value, 'phone')"
                            :value="form['phone'] ? form['phone'] : ''" @keypress="restrictToNumbers($event, 15)" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`phone`)"
                            v-text="validationErros.get(`phone`)"></p>
                    </div>

                    <div class="relative z-0 w-full group">
                        <label for="time" class="block text-base lg:text-lg">Time
                            <!-- <span class="text-primary">*</span> -->
                        </label>
                        <input name="time"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'time')"
                            :value="form['time'] ? form['time'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`time`)"
                            v-text="validationErros.get(`time`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="time_zone" class="block text-base lg:text-lg">Time Zone
                            <!-- <span class="text-primary">*</span> -->
                        </label>
                        <select name="time_zone"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'time_zone')">
                            <option value="">Select</option>
                            <option v-for="(time_zone, key) in time_zones" :selected="form['time_zone'] == time_zone"
                                :value="time_zone" :key="key">
                                {{ time_zone }}
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`time_zone`)"
                            v-text="validationErros.get(`time_zone`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="province" class="block text-base lg:text-lg">Province
                            <!-- <span class="text-primary">*</span> -->
                        </label>
                        <input name="province"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'province')"
                            :value="form['province'] ? form['province'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`province`)"
                            v-text="validationErros.get(`province`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="country" class="block text-base lg:text-lg">Country
                            <!-- <span class="text-primary">*</span> -->
                        </label>
                        <select name="country"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'country')">
                            <option value="">Select</option>
                            <option v-for="(country, key) in countries" :selected="form['country'] == country.code"
                                :value="country.code" :key="key">
                                {{ country?.name }}
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`country`)"
                            v-text="validationErros.get(`country`)"></p>
                    </div>
                    <!-- <div class="relative z-0 w-full group">
                    <label for="country" class="block text-base lg:text-lg">Country no</label>
                    <input
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        @input="handleInput($event.target.value, 'country')"
                        :value="form['country'] ? form['country'] : ''"
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has(`country`)"
                        v-text="validationErros.get(`country`)"
                    ></p>
                </div> -->
                    <div class="relative z-0 w-full group">
                        <label for="city" class="block text-base lg:text-lg">City
                            <!-- <span class="text-primary">*</span> -->
                        </label>
                        <input name="city"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'city')"
                            :value="form['city'] ? form['city'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`city`)"
                            v-text="validationErros.get(`city`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="degree" class="block text-base lg:text-lg">Degree<span class="text-primary">*</span></label>
                        <select name="degree_id"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'degree_id')">
                            <option value="">Select</option>
                            <option v-for="(degree_level, key) in degrees"
                                :selected="form['degree_id'] == degree_level.id" :value="degree_level.id" :key="key">
                                {{
                                    degree_level?.degree_detail.length > 0
                                        ? degree_level?.degree_detail[0].name
                                        : ""
                                }}
                            </option>
                        </select>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`degree_id`)"
                            v-text="validationErros.get(`degree_id`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="youtube_link" class="block text-base lg:text-lg">Youtube video URL</label>
                        <input name="youtube_link"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'youtube_link')"
                            :value="form['youtube_link'] ? form['youtube_link'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`youtube_link`)"
                            v-text="validationErros.get(`youtube_link`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="degree" class="block text-base lg:text-lg">Image<span class="text-primary">*</span></label>
                        <input :key="`image`" type="file" :name="`image`" :id="`image`"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleImage($event, 'image')" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`image`)"
                            v-text="validationErros.get(`image`)"></p>

                        <img v-if="form['image']" :src="form['image'] ? form['image'] : ''"
                            style="height: 100px; width: 100px" />
                    </div>
                    <div v-if="isFormEdit" class="relative z-0 w-full group">
                        <label for="other_button_link" class="block text-base lg:text-lg">Other Button Link</label>
                        <input name="other_button_link"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'other_button_link')"
                            :value="form['other_button_link'] ? form['other_button_link'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`other_button_link`)"
                            v-text="validationErros.get(`other_button_link`)"></p>
                    </div>

                    <div v-if="isFormEdit" class="w-full mt-2 relative">
                        <label for="" class="block text-base lg:text-lg">Quick facts status</label>
                        <select name="quick_facts_status"
                            class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="handleInput($event.target.value, 'quick_facts_status', '')">
                            <option value="">Select</option>
                            <option :selected="form['quick_facts_status'] == 1" value="1">
                                Yes
                            </option>
                            <option :selected="form['quick_facts_status'] == 0" value="0">
                                No
                            </option>
                        </select>
                        <error :fieldName="`quick_facts_status`" :validationErros="errors" />
                    </div>

                    <div v-if="isFormEdit" class="w-full mt-2 relative">
                        <label for="" class="block text-base lg:text-lg">Overview status</label>
                        <select name="overview_status"
                            class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="handleInput($event.target.value, 'overview_status', '')">
                            <option value="">Select</option>
                            <option :selected="form['overview_status'] == 1" value="1">
                                Yes
                            </option>
                            <option :selected="form['overview_status'] == 0" value="0">
                                No
                            </option>
                        </select>
                        <error :fieldName="`overview_status`" :validationErros="errors" />
                    </div>

                    <div v-if="isFormEdit" class="w-full mt-2 relative">
                        <label for="" class="block text-base lg:text-lg">Prgoram status</label>
                        <select name="program_status"
                            class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="handleInput($event.target.value, 'program_status', '')">
                            <option value="">select</option>
                            <option :selected="form['program_status'] == 1" value="1">
                                Yes
                            </option>
                            <option :selected="form['program_status'] == 0" value="0">
                                No
                            </option>
                        </select>
                        <error :fieldName="`program_status`" :validationErros="errors" />
                    </div>

                    <div v-if="isFormEdit" class="w-full mt-2 relative">
                        <label for="" class="block text-base lg:text-lg">Admission status</label>
                        <select name="admission_status"
                            class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="handleInput($event.target.value, 'admission_status', '')">
                            <option value="">select</option>
                            <option :selected="form['admission_status'] == 1" value="1">
                                Yes
                            </option>
                            <option :selected="form['admission_status'] == 0" value="0">
                                No
                            </option>
                        </select>
                        <error :fieldName="`admission_status`" :validationErros="errors" />
                    </div>

                    <div v-if="isFormEdit" class="w-full mt-2 relative">
                        <label for="" class="block text-base lg:text-lg">Financial status</label>
                        <select name="financial_status"
                            class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="handleInput($event.target.value, 'financial_status', '')">
                            <option value="">select</option>
                            <option :selected="form['financial_status'] == 1" value="1">
                                Yes
                            </option>
                            <option :selected="form['financial_status'] == 0" value="0">
                                No
                            </option>
                        </select>
                        <error :fieldName="`financial_status`" :validationErros="errors" />
                    </div>

                    <div v-if="isFormEdit" class="w-full mt-2 relative">
                        <label for="" class="block text-base lg:text-lg">Scholarship status</label>
                        <select name="scholarship_status"
                            class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="handleInput($event.target.value, 'scholarship_status', '')">
                            <option value="">select</option>
                            <option :selected="form['scholarship_status'] == 1" value="1">
                                Yes
                            </option>
                            <option :selected="form['scholarship_status'] == 0" value="0">
                                No
                            </option>
                        </select>
                        <error :fieldName="`scholarship_status`" :validationErros="errors" />
                    </div>

                    <div v-if="isFormEdit" class="w-full mt-2 relative">
                        <label for="" class="block text-base lg:text-lg">Contacts status</label>
                        <select name="contacts_status"
                            class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="handleInput($event.target.value, 'contacts_status', '')">
                            <option value="">select</option>
                            <option :selected="form['contacts_status'] == 1" value="1">
                                Yes
                            </option>
                            <option :selected="form['contacts_status'] == 0" value="0">
                                No
                            </option>
                        </select>
                        <error :fieldName="`contacts_status`" :validationErros="errors" />
                    </div>
                    <div v-if="isFormEdit" class="w-full mt-2 relative">
                        <label for="" class="block text-base lg:text-lg">Ambassador status</label>
                        <select name="ambassador_status"
                            class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @input="handleInput($event.target.value, 'ambassador_status', '')">
                            <option value="">select</option>
                            <option :selected="form['ambassador_status'] == 1" value="1">
                                Yes
                            </option>
                            <option :selected="form['ambassador_status'] == 0" value="0">
                                No
                            </option>
                        </select>
                        <error :fieldName="`ambassador_status`" :validationErros="errors" />
                    </div>
                    <div v-if="isFormEdit" class="relative z-0 w-full group">
                        <label for="facebook" class="block text-base lg:text-lg">Facebook</label>
                        <input name="facebook"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'facebook')"
                            :value="form['facebook'] ? form['facebook'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`facebook`)"
                            v-text="validationErros.get(`facebook`)"></p>
                    </div>
                    <div v-if="isFormEdit" class="relative z-0 w-full group">
                        <label for="linkedin" class="block text-base lg:text-lg">Linkedin</label>
                        <input name="linkedin"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'linkedin')"
                            :value="form['linkedin'] ? form['linkedin'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`linkedin`)"
                            v-text="validationErros.get(`linkedin`)"></p>
                    </div>

                    <div v-if="isFormEdit" class="relative z-0 w-full group">
                        <label for="insta" class="block text-base lg:text-lg">Instagram</label>
                        <input name="insta"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'insta')"
                            :value="form['insta'] ? form['insta'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`insta`)"
                            v-text="validationErros.get(`insta`)"></p>
                    </div>

                    <div v-if="isFormEdit" class="relative z-0 w-full group">
                        <label for="twitter" class="block text-base lg:text-lg">Twitter</label>
                        <input name="twitter"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'twitter')"
                            :value="form['twitter'] ? form['twitter'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`twitter`)"
                            v-text="validationErros.get(`twitter`)"></p>
                    </div>

                    <div v-if="isFormEdit" class="relative z-0 w-full group">
                        <label for="youtube" class="block text-base lg:text-lg">Youtube</label>
                        <input name="youtube"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'youtube')"
                            :value="form['youtube'] ? form['youtube'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`youtube`)"
                            v-text="validationErros.get(`youtube`)"></p>
                    </div>

                    <div v-if="isFormEdit" class="relative z-0 w-full group">
                        <label for="vk" class="block text-base lg:text-lg">VK</label>
                        <input name="vk"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'vk')" :value="form['vk'] ? form['vk'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`vk`)"
                            v-text="validationErros.get(`vk`)"></p>
                    </div>
                    <div v-if="isFormEdit" class="relative z-0 w-full group">
                        <label for="main_button_link" class="block text-base lg:text-lg">Main button link</label>
                        <input name="main_button_link"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            @input="handleInput($event.target.value, 'main_button_link')"
                            :value="form['main_button_link'] ? form['main_button_link'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`main_button_link`)"
                            v-text="validationErros.get(`main_button_link`)"></p>
                    </div>

                    <!-- <div v-if="isFormEdit" class="relative z-0 w-full group">
                    <label for="more_button_title" class="block text-base lg:text-lg">Main button Title</label>
                    <input
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        @input="handleInput($event.target.value, 'more_button_title')"
                        :value="form['main_button_link'] ? form['more_button_title'] : ''"
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has(`more_button_title`)"
                        v-text="validationErros.get(`more_button_title`)"
                    ></p>
                </div> -->
                    <div v-if="isFormEdit" class="relative z-0 w-full group">
                        <label for="more_button_title" class="block text-base lg:text-lg">Main Button Title</label>
                        <input type="text" name="more_button_title" id="more_button_title"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleMultipleInput(
                                    'more_button_title',
                                    $event.target.value,
                                    language
                                )
                                " :value="form['more_button_title'] &&
                                form['more_button_title'][
                                `more_button_title_${language.abbreviation}`
                                ]
                                ? form['more_button_title'][
                                `more_button_title_${language.abbreviation}`
                                ]
                                : ''
                            " />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `more_button_title.more_button_title_${language.abbreviation}`
                            )
                        " v-text="validationErros.get(
                            `more_button_title.more_button_title_${language.abbreviation}`
                        )
                            "></p>
                    </div>
                    <div v-if="isFormEdit" class="relative z-0 w-full group">
                        <label for="more_button_sub_title" class="block text-base lg:text-lg">Main button sub
                            title</label>
                        <input type="text" name="more_button_sub_title" id="more_button_sub_title"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleMultipleInput(
                                    'more_button_sub_title',
                                    $event.target.value,
                                    language
                                )
                                " :value="form['more_button_sub_title'] &&
                                form['more_button_sub_title'][
                                `more_button_sub_title_${language.abbreviation}`
                                ]
                                ? form['more_button_sub_title'][
                                `more_button_sub_title_${language.abbreviation}`
                                ]
                                : ''
                            " />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `more_button_sub_title.more_button_sub_title_${language.abbreviation}`
                            )
                        " v-text="validationErros.get(
                            `more_button_sub_title.more_button_sub_title_${language.abbreviation}`
                        )
                            "></p>
                    </div>
                    <div v-if="isFormEdit" class="relative z-0 w-full group">
                        <label for="other_button_title" class="block text-base lg:text-lg">Other button title</label>
                        <input type="text" name="other_button_title" id="other_button_title"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleMultipleInput(
                                    'other_button_title',
                                    $event.target.value,
                                    language
                                )
                                " :value="form['other_button_title'] &&
                                form['other_button_title'][
                                `other_button_title_${language.abbreviation}`
                                ]
                                ? form['other_button_title'][
                                `other_button_title_${language.abbreviation}`
                                ]
                                : ''
                            " />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `other_button_title.other_button_title_${language.abbreviation}`
                            )
                        " v-text="validationErros.get(
                            `other_button_title.other_button_title_${language.abbreviation}`
                        )
                            "></p>
                    </div>
                    <div v-if="isFormEdit" class="relative mt-2">
                        <label for="" class="block text-base lg:text-lg mt-2">More school images</label>
                        <p class="text-base">
                            (Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)
                        </p>
                        <input type="file" multiple
                            class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            @change="handleImageArray($event)" />
                        <error :fieldName="`image`" :validationErros="errors" />
                        <div class="flex flex-wrap gap-2">
                            <div class="relative h-32 w-32 bg-gray-50 border" v-for="(image, key) in form?.more_images"
                                :key="key">
                                <img :src="image" class="w-full h-full object-cover " />
                                <span @click="removeImage(key)"
                                    class="absolute top-0 right-0 flex justify-center items-center cursor-pointer bg-white border border-primary rounded-full text-primary w-5 h-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>


                </div>
                <ListErrors :validationErrors="validationErros" />
                <div class="flex justify-center items-center gap-3 mt-4">
                <button type="submit" class="can-edu-btn-fill mb-2">Submit</button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
import OtherOptions from './OtherOptions.vue';
export default {
    components: { OtherOptions, editor: Editor, ListErrors },
    computed: {
        ...mapState({
            isFormEdit: (state) => state.schools.isFormEdit,
            form: (state) => state.schools.form,
            validationErros: (state) => state.schools.validationErros,
            languages: (state) => state.languages.languages,
            degrees: (state) => state.degrees.degrees,
        }),
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
            countries: [
                { name: "Afghanistan", code: "AF" },
                { name: "Aland Islands", code: "AX" },
                { name: "Albania", code: "AL" },
                { name: "Algeria", code: "DZ" },
                { name: "American Samoa", code: "AS" },
                { name: "Andorra", code: "AD" },
                { name: "Angola", code: "AO" },
                { name: "Anguilla", code: "AI" },
                { name: "Antarctica", code: "AQ" },
                { name: "Antigua and Barbuda", code: "AG" },
                { name: "Argentina", code: "AR" },
                { name: "Armenia", code: "AM" },
                { name: "Aruba", code: "AW" },
                { name: "Australia", code: "AU" },
                { name: "Austria", code: "AT" },
                { name: "Azerbaijan", code: "AZ" },
                { name: "Bahamas", code: "BS" },
                { name: "Bahrain", code: "BH" },
                { name: "Bangladesh", code: "BD" },
                { name: "Barbados", code: "BB" },
                { name: "Belarus", code: "BY" },
                { name: "Belgium", code: "BE" },
                { name: "Belize", code: "BZ" },
                { name: "Benin", code: "BJ" },
                { name: "Bermuda", code: "BM" },
                { name: "Bhutan", code: "BT" },
                { name: "Bolivia", code: "BO" },
                { name: "Bonaire, Sint Eustatius and Saba", code: "BQ" },
                { name: "Bosnia and Herzegovina", code: "BA" },
                { name: "Botswana", code: "BW" },
                { name: "Bouvet Island", code: "BV" },
                { name: "Brazil", code: "BR" },
                { name: "British Indian Ocean Territory", code: "IO" },
                { name: "Brunei Darussalam", code: "BN" },
                { name: "Bulgaria", code: "BG" },
                { name: "Burkina Faso", code: "BF" },
                { name: "Burundi", code: "BI" },
                { name: "Cambodia", code: "KH" },
                { name: "Cameroon", code: "CM" },
                { name: "Canada", code: "CA" },
                { name: "Cape Verde", code: "CV" },
                { name: "Cayman Islands", code: "KY" },
                { name: "Central African Republic", code: "CF" },
                { name: "Chad", code: "TD" },
                { name: "Chile", code: "CL" },
                { name: "China", code: "CN" },
                { name: "Christmas Island", code: "CX" },
                { name: "Cocos (Keeling) Islands", code: "CC" },
                { name: "Colombia", code: "CO" },
                { name: "Comoros", code: "KM" },
                { name: "Congo", code: "CG" },
                { name: "Congo, Democratic Republic of the Congo", code: "CD" },
                { name: "Cook Islands", code: "CK" },
                { name: "Costa Rica", code: "CR" },
                { name: "Cote D'Ivoire", code: "CI" },
                { name: "Croatia", code: "HR" },
                { name: "Cuba", code: "CU" },
                { name: "Curacao", code: "CW" },
                { name: "Cyprus", code: "CY" },
                { name: "Czech Republic", code: "CZ" },
                { name: "Denmark", code: "DK" },
                { name: "Djibouti", code: "DJ" },
                { name: "Dominica", code: "DM" },
                { name: "Dominican Republic", code: "DO" },
                { name: "Ecuador", code: "EC" },
                { name: "Egypt", code: "EG" },
                { name: "El Salvador", code: "SV" },
                { name: "Equatorial Guinea", code: "GQ" },
                { name: "Eritrea", code: "ER" },
                { name: "Estonia", code: "EE" },
                { name: "Ethiopia", code: "ET" },
                { name: "Falkland Islands (Malvinas)", code: "FK" },
                { name: "Faroe Islands", code: "FO" },
                { name: "Fiji", code: "FJ" },
                { name: "Finland", code: "FI" },
                { name: "France", code: "FR" },
                { name: "French Guiana", code: "GF" },
                { name: "French Polynesia", code: "PF" },
                { name: "French Southern Territories", code: "TF" },
                { name: "Gabon", code: "GA" },
                { name: "Gambia", code: "GM" },
                { name: "Georgia", code: "GE" },
                { name: "Germany", code: "DE" },
                { name: "Ghana", code: "GH" },
                { name: "Gibraltar", code: "GI" },
                { name: "Greece", code: "GR" },
                { name: "Greenland", code: "GL" },
                { name: "Grenada", code: "GD" },
                { name: "Guadeloupe", code: "GP" },
                { name: "Guam", code: "GU" },
                { name: "Guatemala", code: "GT" },
                { name: "Guernsey", code: "GG" },
                { name: "Guinea", code: "GN" },
                { name: "Guinea-Bissau", code: "GW" },
                { name: "Guyana", code: "GY" },
                { name: "Haiti", code: "HT" },
                { name: "Heard Island and McDonald Islands", code: "HM" },
                { name: "Holy See (Vatican City State)", code: "VA" },
                { name: "Honduras", code: "HN" },
                { name: "Hong Kong", code: "HK" },
                { name: "Hungary", code: "HU" },
                { name: "Iceland", code: "IS" },
                { name: "India", code: "IN" },
                { name: "Indonesia", code: "ID" },
                { name: "Iran, Islamic Republic of", code: "IR" },
                { name: "Iraq", code: "IQ" },
                { name: "Ireland", code: "IE" },
                { name: "Isle of Man", code: "IM" },
                { name: "Israel", code: "IL" },
                { name: "Italy", code: "IT" },
                { name: "Jamaica", code: "JM" },
                { name: "Japan", code: "JP" },
                { name: "Jersey", code: "JE" },
                { name: "Jordan", code: "JO" },
                { name: "Kazakhstan", code: "KZ" },
                { name: "Kenya", code: "KE" },
                { name: "Kiribati", code: "KI" },
                { name: "Korea, Democratic People's Republic of", code: "KP" },
                { name: "Korea, Republic of", code: "KR" },
                { name: "Kosovo", code: "XK" },
                { name: "Kuwait", code: "KW" },
                { name: "Kyrgyzstan", code: "KG" },
                { name: "Lao People's Democratic Republic", code: "LA" },
                { name: "Latvia", code: "LV" },
                { name: "Lebanon", code: "LB" },
                { name: "Lesotho", code: "LS" },
                { name: "Liberia", code: "LR" },
                { name: "Libyan Arab Jamahiriya", code: "LY" },
                { name: "Liechtenstein", code: "LI" },
                { name: "Lithuania", code: "LT" },
                { name: "Luxembourg", code: "LU" },
                { name: "Macao", code: "MO" },
                {
                    name: "Macedonia, the Former Yugoslav Republic of",
                    code: "MK",
                },
                { name: "Madagascar", code: "MG" },
                { name: "Malawi", code: "MW" },
                { name: "Malaysia", code: "MY" },
                { name: "Maldives", code: "MV" },
                { name: "Mali", code: "ML" },
                { name: "Malta", code: "MT" },
                { name: "Marshall Islands", code: "MH" },
                { name: "Martinique", code: "MQ" },
                { name: "Mauritania", code: "MR" },
                { name: "Mauritius", code: "MU" },
                { name: "Mayotte", code: "YT" },
                { name: "Mexico", code: "MX" },
                { name: "Micronesia, Federated States of", code: "FM" },
                { name: "Moldova, Republic of", code: "MD" },
                { name: "Monaco", code: "MC" },
                { name: "Mongolia", code: "MN" },
                { name: "Montenegro", code: "ME" },
                { name: "Montserrat", code: "MS" },
                { name: "Morocco", code: "MA" },
                { name: "Mozambique", code: "MZ" },
                { name: "Myanmar", code: "MM" },
                { name: "Namibia", code: "NA" },
                { name: "Nauru", code: "NR" },
                { name: "Nepal", code: "NP" },
                { name: "Netherlands", code: "NL" },
                { name: "Netherlands Antilles", code: "AN" },
                { name: "New Caledonia", code: "NC" },
                { name: "New Zealand", code: "NZ" },
                { name: "Nicaragua", code: "NI" },
                { name: "Niger", code: "NE" },
                { name: "Nigeria", code: "NG" },
                { name: "Niue", code: "NU" },
                { name: "Norfolk Island", code: "NF" },
                { name: "Northern Mariana Islands", code: "MP" },
                { name: "Norway", code: "NO" },
                { name: "Oman", code: "OM" },
                { name: "Pakistan", code: "PK" },
                { name: "Palau", code: "PW" },
                { name: "Palestinian Territory, Occupied", code: "PS" },
                { name: "Panama", code: "PA" },
                { name: "Papua New Guinea", code: "PG" },
                { name: "Paraguay", code: "PY" },
                { name: "Peru", code: "PE" },
                { name: "Philippines", code: "PH" },
                { name: "Pitcairn", code: "PN" },
                { name: "Poland", code: "PL" },
                { name: "Portugal", code: "PT" },
                { name: "Puerto Rico", code: "PR" },
                { name: "Qatar", code: "QA" },
                { name: "Reunion", code: "RE" },
                { name: "Romania", code: "RO" },
                { name: "Russian Federation", code: "RU" },
                { name: "Rwanda", code: "RW" },
                { name: "Saint Barthelemy", code: "BL" },
                { name: "Saint Helena", code: "SH" },
                { name: "Saint Kitts and Nevis", code: "KN" },
                { name: "Saint Lucia", code: "LC" },
                { name: "Saint Martin", code: "MF" },
                { name: "Saint Pierre and Miquelon", code: "PM" },
                { name: "Saint Vincent and the Grenadines", code: "VC" },
                { name: "Samoa", code: "WS" },
                { name: "San Marino", code: "SM" },
                { name: "Sao Tome and Principe", code: "ST" },
                { name: "Saudi Arabia", code: "SA" },
                { name: "Senegal", code: "SN" },
                { name: "Serbia", code: "RS" },
                { name: "Serbia and Montenegro", code: "CS" },
                { name: "Seychelles", code: "SC" },
                { name: "Sierra Leone", code: "SL" },
                { name: "Singapore", code: "SG" },
                { name: "St Martin", code: "SX" },
                { name: "Slovakia", code: "SK" },
                { name: "Slovenia", code: "SI" },
                { name: "Solomon Islands", code: "SB" },
                { name: "Somalia", code: "SO" },
                { name: "South Africa", code: "ZA" },
                {
                    name: "South Georgia and the South Sandwich Islands",
                    code: "GS",
                },
                { name: "South Sudan", code: "SS" },
                { name: "Spain", code: "ES" },
                { name: "Sri Lanka", code: "LK" },
                { name: "Sudan", code: "SD" },
                { name: "Suriname", code: "SR" },
                { name: "Svalbard and Jan Mayen", code: "SJ" },
                { name: "Swaziland", code: "SZ" },
                { name: "Sweden", code: "SE" },
                { name: "Switzerland", code: "CH" },
                { name: "Syrian Arab Republic", code: "SY" },
                { name: "Taiwan, Province of China", code: "TW" },
                { name: "Tajikistan", code: "TJ" },
                { name: "Tanzania, United Republic of", code: "TZ" },
                { name: "Thailand", code: "TH" },
                { name: "Timor-Leste", code: "TL" },
                { name: "Togo", code: "TG" },
                { name: "Tokelau", code: "TK" },
                { name: "Tonga", code: "TO" },
                { name: "Trinidad and Tobago", code: "TT" },
                { name: "Tunisia", code: "TN" },
                { name: "Turkey", code: "TR" },
                { name: "Turkmenistan", code: "TM" },
                { name: "Turks and Caicos Islands", code: "TC" },
                { name: "Tuvalu", code: "TV" },
                { name: "Uganda", code: "UG" },
                { name: "Ukraine", code: "UA" },
                { name: "United Arab Emirates", code: "AE" },
                { name: "United Kingdom", code: "GB" },
                { name: "United States", code: "US" },
                { name: "United States Minor Outlying Islands", code: "UM" },
                { name: "Uruguay", code: "UY" },
                { name: "Uzbekistan", code: "UZ" },
                { name: "Vanuatu", code: "VU" },
                { name: "Venezuela", code: "VE" },
                { name: "Viet Nam", code: "VN" },
                { name: "Virgin Islands, British", code: "VG" },
                { name: "Virgin Islands, U.s.", code: "VI" },
                { name: "Wallis and Futuna", code: "WF" },
                { name: "Western Sahara", code: "EH" },
                { name: "Yemen", code: "YE" },
                { name: "Zambia", code: "ZM" },
                { name: "Zimbabwe", code: "ZW" },
            ],
            time_zones: [
                "(GMT-10:00) Hawaii",
                "(GMT-09:00) Alaska",
                "(GMT-08:00) Pacific Time (US &amp; Canada)",
                "(GMT-07:00) Arizona",
                "(GMT-07:00) Mountain Time (US &amp; Canada)",
                "(GMT-06:00) Central Time (US &amp; Canada) ",
                "(GMT-05:00) Eastern Time (US &amp; Canada)",
                "(GMT-11:00) International Date Line West",
                "(GMT-11:00) Midway Island",
                "(GMT-11:00) Samoa",
                "(GMT-08:00) Tijuana",
                "(GMT-07:00) Chihuahua",
                "(GMT-07:00) Mazatlan",
                "(GMT-06:00) Central America",
                "(GMT-06:00) Guadalajara",
                "(GMT-06:00) Mexico City",
                "(GMT-06:00) Monterrey",
                "(GMT-06:00) Saskatchewan",
                "(GMT-05:00) Bogota",
                "(GMT-05:00) Lima",
                "(GMT-05:00) Quito",
                "(GMT-04:30) Caracas",
                "(GMT-04:00) Atlantic Time (Canada)",
                "(GMT-04:00) La Paz",
                "(GMT-04:00) Santiago",
                "(GMT-03:30) Newfoundland",
                "(GMT-03:00) Brasilia",
                "(GMT-03:00) Buenos Aires",
                "(GMT-03:00) Georgetown",
                "(GMT-03:00) Greenland",
                "(GMT-02:00) Mid-Atlantic",
                "(GMT-01:00) Azores",
                "(GMT-01:00) Cape Verde Is.",
                "(GMT) Casablanca",
                "(GMT) Dublin",
                "(GMT) Edinburgh",
                "(GMT) Lisbon",
                "(GMT) London",
                "(GMT) Monrovia",
                "(GMT+01:00) Amsterdam",
                "(GMT+01:00) Belgrade",
                "(GMT+01:00) Berlin",
                "(GMT+01:00) Bern",
                "(GMT+01:00) Bratislava",
                "(GMT+01:00) Brussels",
                "(GMT+01:00) Budapest",
                "(GMT+01:00) Copenhagen",
                "(GMT+01:00) Ljubljana",
                "(GMT+01:00) Madrid",
                "(GMT+01:00) Paris",
                "(GMT+01:00) Prague",
                "(GMT+01:00) Rome",
                "(GMT+01:00) Sarajevo",
                "(GMT+01:00) Skopje",
                "(GMT+01:00) Stockholm",
                "(GMT+01:00) Vienna",
                "(GMT+01:00) Warsaw",
                "(GMT+01:00) West",
                "Central Africa",
                "(GMT+01:00) Zagreb",
                "(GMT+02:00) Athens",
                "(GMT+02:00) Bucharest",
                "(GMT+02:00) Cairo",
                "(GMT+02:00) Harare",
                "(GMT+02:00) Helsinki",
                "(GMT+02:00) Istanbul",
                "(GMT+02:00) Jerusalem",
                "(GMT+02:00) Kyiv",
                "(GMT+02:00) Minsk",
                "(GMT+02:00) Pretoria",
                "(GMT+02:00) Riga",
                "(GMT+02:00) Sofia",
                "(GMT+02:00) Tallinn",
                "(GMT+02:00) Vilnius",
                "(GMT+03:00) Baghdad",
                "(GMT+03:00) Kuwait",
                "(GMT+03:00) Moscow",
                "(GMT+03:00) Nairobi",
                "(GMT+03:00) Riyadh",
                "(GMT+03:00) St. Petersburg",
                "(GMT+03:00) Volgograd",
                "(GMT+03:30) Tehran",
                "(GMT+04:00) Abu Dhabi",
                "(GMT+04:00) Baku",
                "(GMT+04:00) Muscat",
                "(GMT+04:00) Tbilisi",
                "(GMT+04:00) Yerevan",
                "(GMT+04:30) Kabul",
                "(GMT+05:00) Ekaterinburg",
                "(GMT+05:00) Islamabad",
                "(GMT+05:00) Karachi",
                "(GMT+05:00) Tashkent",
                "(GMT+05:30) Chennai",
                "(GMT+05:30) Kolkata",
                "(GMT+05:30) Mumbai",
                "(GMT+05:30) New Delhi",
                "(GMT+05:45) Kathmandu",
                "(GMT+06:00) Almaty",
                "(GMT+06:00) Astana",
                "(GMT+06:00) Dhaka",
                "(GMT+06:00) Novosibirsk",
                "(GMT+06:00) Sri Jayawardenepura",
                "(GMT+06:30) Rangoon",
                "(GMT+07:00) Bangkok",
                "(GMT+07:00) Hanoi",
                "(GMT+07:00) Jakarta",
                "(GMT+07:00) Krasnoyarsk",
                "(GMT+08:00) Beijing",
                "(GMT+08:00) Chongqing",
                "(GMT+08:00) Hong Kong",
                "(GMT+08:00) Irkutsk",
                "(GMT+08:00) Kuala Lumpur",
                "(GMT+08:00) Perth",
                "(GMT+08:00) Singapore",
                "(GMT+08:00) Taipei",
                "(GMT+08:00) Ulaan Bataar",
                "(GMT+08:00) Urumqi",
                "(GMT+09:00) Osaka",
                "(GMT+09:00) Sapporo",
                "(GMT+09:00) Seoul",
                "(GMT+09:00) Tokyo",
                "(GMT+09:00) Yakutsk",
                "(GMT+09:30) Adelaide",
                "(GMT+09:30) Darwin",
                "(GMT+10:00) Brisbane",
                "(GMT+10:00) Canberra",
                "(GMT+10:00) Guam",
                "(GMT+10:00) Hobart",
                "(GMT+10:00) Melbourne",
                "(GMT+10:00) Port Moresby",
                "(GMT+10:00) Sydney",
                "(GMT+10:00) Vladivostok",
                "(GMT+11:00) Magadan",
                "(GMT+11:00) New Caledonia",
                "(GMT+11:00) Solomon Is.",
                "(GMT+12:00) Auckland",
                "(GMT+12:00) Fiji",
                "(GMT+12:00) Kamchatka",
                "(GMT+12:00) Marshall Is.",
                "(GMT+12:00) Wellington",
                "(GMT+13:00) Nukualofa",
            ],
        };
    },
    methods: {
        restrictToNumbers(event, allowedLength) {
            const keyCode = event.which ? event.which : event.keyCode;
            const inputChar = String.fromCharCode(keyCode);
            const isValidSpecialChar = /^[\+\-\(\)]$/.test(inputChar);
            const isDigit = /^\d$/.test(inputChar);
            let currentValue = event.target.value + inputChar;
            const digitCount = currentValue.replace(/[^\d]/g, "").length;
            if (!isValidSpecialChar && (!isDigit || digitCount > allowedLength)) {
                event.preventDefault();
            }
        },
        removeImage(index) {
            this.$store.commit("schools/removeImage", index);
        },
        handleImageArray(e) {
            console.log(e.target.files);
            for (var i = 0; i < e.target.files.length; i++) {
                var file = new FormData();
                file.append("file", e.target.files[i]);
                axios.post("/api/admin/media/image_again_upload", file).then((res) => {
                    this.$store.commit(
                        "schools/setImages",
                        res?.data
                    );
                });
            }
        },
        handleInput(value, key) {
            this.$store.commit("schools/setState", { key, value });
            if (value.trim()) {
                this.validationErros.clear(key);
            }
        },
        handleSelectionChange(language, key) {
            const editorInstance = tinymce.get(`${key}_${language.abbreviation}`);
            this.$store.commit(`schools/updateState`, {
                value: editorInstance.getContent().trim(),
                id: language.abbreviation,
                key: key,
            });
            if (editorInstance.getContent().trim()) {
                this.validationErros.clear(`description.description_${language.abbreviation}`);
            }
        },
        handleMultipleInput(key, value, language) {
            this.$store.commit("schools/updateState", {
                value: value.trim(),
                id: language.abbreviation,
                key,
            });
            if (value.trim()) {
                this.validationErros.clear(`${key}.${key}_${language.abbreviation}`);
            }
        },
        addUpdateForm() {
            this.$store
                .dispatch("schools/addUpdateForm")
                .then(() => this.$router.push({ name: "admin.schools.index" }
                )).catch((error) => {
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

                this.$store.commit("schools/setIsFormEdit", 1);
                this.$store
                    .dispatch("schools/fetchSchools", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}schools/${id}?withSchoolDetail=1`,
                    })
                    .then((res) => {
                        console.log('main ', res);
                        let school_more_images_array = res.data.data
                            ?.school_more_images
                            ? res.data.data?.school_more_images
                            : [];

                        for (var i = 0; i < school_more_images_array?.length; i++) {
                            if (school_more_images_array[i]?.image) {
                                this.$store.commit(
                                    "schools/setImages",
                                    school_more_images_array[i]?.image
                                );
                            }
                        }
                        let keys = [
                            "website_url",
                            "email",
                            'other_button_link',
                            "phone",
                            "time",
                            "time_zone",
                            "province",
                            "country",
                            "city",
                            "youtube_link",
                            "degree_id",
                            "image",
                            'quick_facts_status',
                            'overview_status',
                            'ambassador_status',
                            'program_status',
                            'admission_status',
                            'financial_status',
                            'scholarship_status',
                            'contacts_status',
                            'facebook',
                            'linkedin',
                            'insta',
                            'twitter',
                            'youtube',
                            'vk',
                            'main_button_link',
                        ];
                        this.$store.commit("schools/setState", {
                            key: "id",
                            value: id,
                        });
                        for (var i = 0; i < keys.length; i++) {
                            this.$store.commit("schools/setState", {
                                key: keys[i],
                                value: res.data.data[keys[i]],
                            });
                        }
                        let data =
                            res.data.data && res.data.data.school_detail
                                ? res.data.data.school_detail
                                : [];
                        let obj = {};
                        data.map((res) => {
                            obj["school_name_" + res.language_code] =
                                res.school_name;
                        });
                        this.$store.commit("schools/setState", {
                            key: "school_name",
                            value: obj,
                        });
                        data.map((res) => {
                            console.log('more_button_title_', res);
                            obj["more_button_title_" + res.language_code] =
                                res.more_button_title;
                        });
                        this.$store.commit("schools/setState", {
                            key: "more_button_title",
                            value: obj,
                        });
                        data.map((res) => {
                            console.log('other_button_title', res);
                            obj["other_button_title_" + res.language_code] =
                                res.other_button_title;
                        });
                        this.$store.commit("schools/setState", {
                            key: "other_button_title",
                            value: obj,
                        });
                        data.map((res) => {
                            console.log('more_button_sub_title_', res);
                            obj["more_button_sub_title_" + res.language_code] =
                                res.more_button_sub_title;
                        });
                        this.$store.commit("schools/setState", {
                            key: "more_button_sub_title",
                            value: obj,
                        });

                        data.map((res) => {
                            console.log('description_', res);
                            obj["description_" + res.language_code] =
                                res.description;
                        });
                        this.$store.commit("schools/setState", {
                            key: "description",
                            value: obj,
                        });
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
                    this.$store.commit("schools/setState", {
                        key,
                        value: res?.data,
                    });
                    this.validationErros.clear(key);
                });
        },
    },
    created() {
        this.$store.commit("schools/resetForm");
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
                this.$store.commit("schools/setState", {
                    key: "name",
                    value: obj,
                });
                data.map((res) => {
                    obj["description_" + res.abbreviation] = "";
                });
                this.$store.commit("schools/setState", {
                    key: "description",
                    value: obj,
                });
                if (this.$route.params.id) {
                    this.fetchSchools();
                }
                else {
                    this.isDataLoaded = 1;
                }
            });
        this.$store.commit("degrees/setLimit", 2000);
        this.$store.commit("degrees/setSortBy", "id");
        this.$store.commit("degrees/setSortType", "desc");
        this.$store.dispatch("degrees/fetchDegrees");
    },
};
</script>
