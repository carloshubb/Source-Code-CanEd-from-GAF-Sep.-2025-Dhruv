<template>
    <div class="modal-content py-6 text-left px-6">
        <div class="flex justify-between items-center pb-3">
            <h2 class="can-school-h2 text-primary">School information</h2>
        </div>
        <div class="modal-body">
            <div
                class="text-sm font-medium text-center text-gray-500 dark:text-gray-400 dark:border-gray-700"
            >
            <h3 class="text-left">Language</h3>
            <p class="text-left text-base font-normal text-gray-700">Select the languages under which you want your school profile to appear</p>
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
                                errors.has(
                                    `school_name.school_name_${language.code}`
                                )
                                    ? 'bg-red-600 text-white hover:text-white'
                                    : '',
                            ]"
                            >{{ getLanguageName(language.language_code) }}</a
                        >
                    </li>
                </ul>
            </div>
            <div
                class="w-full mt-2 relative"
                v-for="language in languages"
                :key="language.language_code"
                :class="
                    activeTab == language.language_code ? 'block' : 'hidden'
                "
            >
                <label class="block text-base lg:text-lg">School name</label>
                <input
                    type="text"
                    name="school_name"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'school_name', language)"
                    :value="
                        form['school_name'] &&
                        form['school_name'][
                            `school_name_${language.language_code}`
                        ]
                            ? form['school_name'][
                                  `school_name_${language.language_code}`
                              ]
                            : ''
                    "
                />
                <error
                    :fieldName="`school_name.school_name_${language.language_code}`"
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
                <label class="block text-base lg:text-lg">Description</label>
                <textarea
                name="description"
                    type="text"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'description', language)"
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

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Website URL</label
                >
                <input
                name="website_url"
                    type="text"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'website_url', '')"
                    :value="form['website_url'] ? form['website_url'] : ''"
                />
                <error
                    :fieldName="`website_url`"
                    :validationErros="errors"
                />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Email</label
                >
                <input
                    type="email"
                    name="email"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'email', '')"
                    :value="form['email'] ? form['email'] : ''"
                />
                <error
                    :fieldName="`email`"
                    :validationErros="errors"
                />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Phone</label
                >
                <input
                name="phone"
                    type="text"
                    placeholder="With area code"
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'phone', '')"
                    :value="form['phone'] ? form['phone'] : ''"
                    @keypress="restrictToNumbers($event, 15)"
                />
                <error
                    :fieldName="`phone`"
                    :validationErros="errors"
                />
            </div>

            <!-- <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Time</label
                >
                <input
                    type="text"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'time', '')"
                    :value="form['time'] ? form['time'] : ''"
                />
                <error
                    :fieldName="`time`"
                    :validationErros="errors"
                />
            </div> -->

            <!-- <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Time Zone</label
                >
                <input
                    type="text"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'time_zone', '')"
                    :value="form['time_zone'] ? form['time_zone'] : ''"
                />
                <error
                    :fieldName="`time_zone`"
                    :validationErros="errors"
                />
            </div> -->


            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Time Zone</label
                >
                <select
                @input="handleInput($event, 'time_zone', '')"
                name="time_zone"
                id=""
                :value="form['time_zone'] ? form['time_zone'] : ''"
                class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                :class="
                    position == 'rtl'
                        ? 'border-r-4 rounded-r border-r-primary'
                        : 'border-l-4 rounded-l border-l-primary'
                "
            >
                <option
                    v-for="(time_zone, key) in time_zones"
                    :key="key"
                    :value="time_zone"
                >
                    {{ time_zone }}
                </option>
            </select>
                <error
                    :fieldName="`time_zone`"
                    :validationErros="errors"
                />
            </div>

            <!-- <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Province</label
                >
                <input
                    type="text"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'province', '')"
                    :value="form['province'] ? form['province'] : ''"
                />
                <error
                    :fieldName="`province`"
                    :validationErros="errors"
                />
            </div> -->


            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Province</label
                >
               <select
                @input="handleInput($event, 'province', '')"
                name="province"
                id=""
                :value="form['province'] ? form['province'] : ''"
                class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                :class="
                    position == 'rtl'
                        ? 'border-r-4 rounded-r border-r-primary'
                        : 'border-l-4 rounded-l border-l-primary'
                "
            >
                <option
                    v-for="(province, key) in provinces"
                    :key="key"
                    :value="province"
                >
                    {{ province }}
                </option>
            </select>
                <error
                    :fieldName="`province`"
                    :validationErros="errors"
                />
            </div>


            
            <!-- <div class="relative z-0 w-full group">
                <label for="degree" class="block text-base lg:text-lg">Degree</label>
                <select
                    class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                    @input="handleInput($event.target.value, 'degree_id')"
                >
                    <option value="">Select</option>
                    <option
                        v-for="(degree_level, key) in degrees"
                        :selected="form['degree_id'] == degree_level.id"
                        :value="degree_level.id"
                        :key="key"
                    >
                        {{
                            degree_level?.degree_detail.length > 0
                                ? degree_level?.degree_detail[0].name
                                : ""
                        }}
                    </option>
                </select>
                <error
                :fieldName="`degree_id`"
                :validationErros="errors"
            />
            </div> -->
            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Welcome video URL</label
                >
                <input
                    type="text"
                    name="youtube_link"
                    placeholder="Valid format must begin with: https://www.youtube.com/"
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'youtube_link', '')"
                    :value="form['youtube_link'] ? form['youtube_link'] : ''"
                />
                <error
                    :fieldName="`youtube_link`"
                    :validationErros="errors"
                />
            </div>
            <div class="relative mt-2">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Featured image - Main profile image</label
                >
                <p class="text-base">
                       (Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)
                </p>
                <input
                    type="file"
                    name="image"
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @change="handleImage($event)"
                />
                <error
                    :fieldName="`image`"
                    :validationErros="errors"
                />
                <img v-if="form['image']" :src=" form?.image ? form.image : ''" class="w-40 h-40 bg-gray-50" />
            </div>
            <div class="relative mt-2">
                <label
                    for=""
                    class="block text-base lg:text-lg mt-2"
                    >Add more images / photos</label
                >
                <p class="text-base">
                       (Max. size: 5MB. Allowed formats: JPEG, JPG, PNG)
                </p>
                <input
                    type="file"
                    multiple
                    class="border w-full border-l-[5px] focus:ring-none my-2 focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @change="handleImageArray($event)"
                />
                <error
                    :fieldName="`image`"
                    :validationErros="errors"
                />
                <div class="flex flex-wrap gap-2">
                    <div
                        class="relative h-32 w-32 bg-gray-50 border"
                        v-for="(image, key) in form?.more_images"
                        :key="key"
                    >
                        <img :src="image" class="w-full h-full object-cover " />
                        <span
                            @click="removeImage(key)"
                            class="absolute top-0 right-0 flex justify-center items-center cursor-pointer bg-white border border-primary rounded-full text-primary w-5 h-5"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            </span
                        >
                    </div>
                </div>
            </div>
            <!-- <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Country</label
                >
                <input
                    type="text"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'country', '')"
                    :value="form['country'] ? form['country'] : ''"
                />
                <error
                    :fieldName="`country`"
                    :validationErros="errors"
                />
            </div> -->
            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Country</label
                >
                <select
                @input="handleInput($event, 'country', '')"
                name="country"
                id=""
                class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                :class="
                    position == 'rtl'
                        ? 'border-r-4 rounded-r border-r-primary'
                        : 'border-l-4 rounded-l border-l-primary'
                "
                 :value="form['country'] ? form['country'] : ''"
            >
            <option value="CA" selected>Canada</option>
                <option
                    v-for="(country, key) in countries"
                    :key="key"
                    :value="country.code"
                >
                    {{ country?.name }}
                </option>
            </select>
                <error
                    :fieldName="`country`"
                    :validationErros="errors"
                />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Facebook URL</label
                >
                <input
                    type="text"
                    name="facebook"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'facebook', '')"
                    :value="form['facebook'] ? form['facebook'] : ''"
                />
                <error
                    :fieldName="`facebook`"
                    :validationErros="errors"
                />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >LinkedIn URL</label
                >
                <input
                    type="text"
                    placeholder=""
                    name="linkedin"
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'linkedin', '')"
                    :value="form['linkedin'] ? form['linkedin'] : ''"
                />
                <error
                    :fieldName="`linkedin`"
                    :validationErros="errors"
                />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Instagram URL</label
                >
                <input
                    type="text"
                    name="insta"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'insta', '')"
                    :value="form['insta'] ? form['insta'] : ''"
                />
                <error
                    :fieldName="`insta`"
                    :validationErros="errors"
                />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Twitter URL</label
                >
                <input
                    type="text"
                    name="twitter"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'twitter', '')"
                    :value="form['twitter'] ? form['twitter'] : ''"
                />
                <error
                    :fieldName="`twitter`"
                    :validationErros="errors"
                />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >YouTube URL</label
                >
                <input
                    type="text"
                    placeholder=""
                    name="youtube"
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'youtube', '')"
                    :value="form['youtube'] ? form['youtube'] : ''"
                />
                <error
                    :fieldName="`youtube`"
                    :validationErros="errors"
                />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >VK URL</label
                >
                <input
                    type="text"
                    name="vk"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'vk', '')"
                    :value="form['vk'] ? form['vk'] : ''"
                />
                <error
                    :fieldName="`vk`"
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
                <label class="block text-base lg:text-lg">Main button title</label>
                <input
                    type="text"
                    name="more_button_title"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'more_button_title', language)"
                    :value="
                        form['more_button_title'] &&
                        form['more_button_title'][
                            `more_button_title_${language.language_code}`
                        ]
                            ? form['more_button_title'][
                                  `more_button_title_${language.language_code}`
                              ]
                            : ''
                    "
                />
                <error
                    :fieldName="`more_button_title.more_button_title_${language.language_code}`"
                    :validationErros="errors"
                />
                
            </div>
            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Main button link</label
                >
                <input
                    type="text"
                    name="main_button_link"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'main_button_link', '')"
                    :value="
                        form['main_button_link'] ? form['main_button_link'] : ''
                    "
                />
                <error
                    :fieldName="`main_button_link`"
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
                <label class="block text-base lg:text-lg">Main button sub title</label>
                <input
                    type="text"
                    name="more_button_sub_title"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="
                        handleInput($event, 'more_button_sub_title', language)
                    "
                    :value="
                        form['more_button_sub_title'] &&
                        form['more_button_sub_title'][
                            `more_button_sub_title_${language.language_code}`
                        ]
                            ? form['more_button_sub_title'][
                                  `more_button_sub_title_${language.language_code}`
                              ]
                            : ''
                    "
                />
                <error
                    :fieldName="`more_button_sub_title.more_button_sub_title_${language.language_code}`"
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
                <label class="block text-base lg:text-lg">Other button title</label>
                <input
                    type="text"
                    placeholder=""
                    name="other_button_title"
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'other_button_title', language)"
                    :value="
                        form['other_button_title'] &&
                        form['other_button_title'][
                            `other_button_title_${language.language_code}`
                        ]
                            ? form['other_button_title'][
                                  `other_button_title_${language.language_code}`
                              ]
                            : ''
                    "
                />
                <error
                    :fieldName="`other_button_title.other_button_title_${language.language_code}`"
                    :validationErros="errors"
                />
            </div>
            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Other button link</label
                >
                <input
                    type="text"
                    name="other_button_link"
                    placeholder=""
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'other_button_link', '')"
                    :value="
                        form['other_button_link']
                            ? form['other_button_link']
                            : ''
                    "
                />
                <error
                    :fieldName="`other_button_link`"
                    :validationErros="errors"
                />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Quick Facts tab status</label
                >
                <select
                name="quick_facts_status"
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'quick_facts_status', '')"
                >
                    <option value="">Select</option>
                    <option
                        :selected="form['quick_facts_status'] == 1"
                        value="1"
                    >
                        Yes
                    </option>
                    <option
                        :selected="form['quick_facts_status'] == 0"
                        value="0"
                    >
                        No
                    </option>
                </select>
                <error
                    :fieldName="`quick_facts_status`"
                    :validationErros="errors"
                />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Overview tab status</label
                >
                <select
                name="overview_status"  class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'overview_status', '')"
                >
                    <option value="">Select</option>
                    <option :selected="form['overview_status'] == 1" value="1">
                        Yes
                    </option>
                    <option :selected="form['overview_status'] == 0" value="0">
                        No
                    </option>
                </select>
                <error
                    :fieldName="`overview_status`"
                    :validationErros="errors"
                />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Programs tab status</label
                >
                <select
                name="program_status"    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'program_status', '')"
                >
                    <option value="">select</option>
                    <option :selected="form['program_status'] == 1" value="1">
                        Yes
                    </option>
                    <option :selected="form['program_status'] == 0" value="0">
                        No
                    </option>
                </select>
                <error
                    :fieldName="`program_status`"
                    :validationErros="errors"
                />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Admissions tab status</label
                >
                <select
                name="admission_status"  class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'admission_status', '')"
                >
                    <option value="">select</option>
                    <option :selected="form['admission_status'] == 1" value="1">
                        Yes
                    </option>
                    <option :selected="form['admission_status'] == 0" value="0">
                        No
                    </option>
                </select>
                <error
                    :fieldName="`admission_status`"
                    :validationErros="errors"
                />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Financials tab status</label
                >
                <select
                name="financial_status"  class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'financial_status', '')"
                >
                    <option value="">select</option>
                    <option :selected="form['financial_status'] == 1" value="1">
                        Yes
                    </option>
                    <option :selected="form['financial_status'] == 0" value="0">
                        No
                    </option>
                </select>
                <error
                    :fieldName="`financial_status`"
                    :validationErros="errors"
                />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Scholarships tab status</label
                >
                <select
                name="scholarship_status"  class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'scholarship_status', '')"
                >
                    <option value="">select</option>
                    <option
                        :selected="form['scholarship_status'] == 1"
                        value="1"
                    >
                        Yes
                    </option>
                    <option
                        :selected="form['scholarship_status'] == 0"
                        value="0"
                    >
                        No
                    </option>
                </select>
                <error
                    :fieldName="`scholarship_status`"
                    :validationErros="errors"
                />
            </div>

            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Contacts tab status</label
                >
                <select
                name="contacts_status"  class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'contacts_status', '')"
                >
                    <option value="">select</option>
                    <option :selected="form['contacts_status'] == 1" value="1">
                        Yes
                    </option>
                    <option :selected="form['contacts_status'] == 0" value="0">
                        No
                    </option>
                </select>
                <error
                    :fieldName="`contacts_status`"
                    :validationErros="errors"
                />
            </div>
            <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Ambassadors tab status</label
                >
                <select
                name="ambassador_status" class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                    @input="handleInput($event, 'ambassador_status', '')"
                >
                    <option value="">select</option>
                    <option
                        :selected="form['ambassador_status'] == 1"
                        value="1"
                    >
                        Yes
                    </option>
                    <option
                        :selected="form['ambassador_status'] == 0"
                        value="0"
                    >
                        No
                    </option>
                </select>
                <error
                    :fieldName="`ambassador_status`"
                    :validationErros="errors"
                />
            </div>
            <div>
                <h2 class="mt-2 can-school-h2 text-primary">Extra links</h2>
                <table
                    class="mt-2 w-full"
                    v-if="form['school_more_links']?.length > 0"
                >
                    <tr
                        v-for="(school_more_link, i) in form[
                            'school_more_links'
                        ]"
                        :key="i"
                    >
                        <td>
                            <p>{{ school_more_link?.link }}</p>
                        </td>
                        <td>
                            <button
                                @click="deleteMoreLink(school_more_link?.id)"
                                class="mt-4 can-edu-btn-fill"
                            >
                                Delete
                            </button>
                            |
                            <button
                                @click="editMoreLink(school_more_link?.id)"
                                class="mt-4 can-edu-btn-fill"
                            >
                                Edit
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
            <MoreLinkModal
                :link_id="link_id"
                :school_id="form['id']"
                :showModal="showModal"
                :logged_in_customer="logged_in_customer"
                :toggleLinkModal="toggleLinkModal"
                :languages_with_names="languages_with_names"
                @unSetLinksData="unSetLinksData"
            />
            <Button
                class="mt-4 can-edu-btn-fill"
                @click="toggleLinkModal"
                >Add more links</Button
            >
            <div class="flex justify-center items-center gap-3 mt-4">
                <div>
                    <button
                        class="can-edu-btn-fill"
                        @click="addUpdate"
                    >
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <transition name="slide">
    <div id="defaultModal" tabindex="-1" aria-hidden="true"
      class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
      v-if="showPopUpModal">
      <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
        ref="elementToDetectClick">
        <div class="relative">
          <div class="absolute top-3 right-3 cursor-pointer" @click="togglePopUpModal">
            <button type="button" class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
          </div>
          <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
            <p class="text-center can-edu-p mt-2">
              {{
                popupMsg
              }} </p>
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
import axios from "axios";
import { mapState } from "vuex";
import MoreLinkModal from "./Modals/MoreLinkModal.vue";
import Error from '../Error.vue';
export default {
    props: ["logged_in_customer","languages_with_names"],
    computed: {
        ...mapState({
            // degrees: (state) => state.degrees.degrees,
            form: (state) => state.school_informations.form,
            school_informations: (state) =>
                state.school_informations.school_informations,
            errors: (state) => state.school_informations.errors,
            isLoading: (state) => state.school_informations.isLoading,
            languages: (state) => state.school_informations.form.languages,
        }),
        parsedLanguages() {
        if (typeof this.languages_with_names === 'string') {
            try {
                return JSON.parse(this.languages_with_names);
            } catch (error) {
                console.error('Error parsing JSON:', error);
                return []; // Return an empty array as a fallback
            }
        }
        return this.languages_with_names; // Return as is if already an array or object
    }
    },
    data() {
        return {
            showPopUpModal: false,
            popupMsg: '',
            time_zone: "",
            province: "",
            activeTab: "en",
            showModal: false,
            link_id: "",
            time_zones: [
                // "(GMT-10:00) Hawaii",
                "Newfoundland Standard Time - NST",
                "Atlantic Standard Time - AST",
                "Eastern Standard Time - EST",
                "Central Standard Time - CST",
                "Mountain Standard Time - MST",
                "Pacific Standard Time - PST",

            ],

            provinces: [
                // "(GMT-10:00) Hawaii",
                "Alberta",
                "British Columbia",
                "Manitoba",
                "New Brunswick",
                "Newfoundland and Labrador",
                "Nova Scotia",
                "Ontario",
                "Prince Edward Island",
                "Quebec",
                "Saskatchewan",

            ],
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
        };
    },
    methods: {
        togglePopUpModal() {
      this.showPopUpModal = !this.showPopUpModal;
      if (!this.showPopUpModal) {
        // window.location.reload();

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
          // window.location.reload();


        }
      }
    },
        getLanguageName(language_code) {
        const languages = this.parsedLanguages; // Use the computed property
        if (Array.isArray(languages)) {
            const language = languages.find(
                (lang) => lang.language_code === language_code
            );
            return language ? language.language_name : language_code;
        }
        return language_code; // Fallback if parsedLanguages is not an array
    },
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
        toggleLinkModal() {
            this.showModal = !this.showModal;
        },
        closeModal() {
            this.$store.commit("school_informations/setShowModal", 0);
        },
        handleInput(e, key, language) {
            const value = e.target.value;
            this.$store.commit("school_informations/setForData", {
                key,
                language: language ? language : "",
                value: value,
            });
            if (value.trim() !== "") {
        const fieldKey = language
            ? `${key}.${key}_${language.language_code}`
            : key;
        this.errors.clear(fieldKey);
    }       
        },
        changeLanguageTab(language) {
            this.activeTab = language.language_code;
        },
        addUpdate() {
            this.$store
                .dispatch("school_informations/addUpdateForm")
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.showPopUpModal = true;
                        this.popupMsg = res.data.message;
                        this.$store.commit("school_informations/setLimit", 10);
                        this.$store.commit(
                            "school_informations/setSortBy",
                            "id"
                        );
                        this.$store.commit(
                            "school_informations/setSortType",
                            "desc"
                        );
                        this.$store.dispatch(
                            "school_informations/fetchSchoolInformation"
                        );
                    }
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
        createEditorInstance(name, key, lang, mutationName) {
            let ctx = this;
            CKEDITOR.replace(name);
            if (CKEDITOR?.instances[name]) {
                CKEDITOR.instances[name].on("change", function () {
                    let value = CKEDITOR.instances[name].getData();
                    ctx.$store.commit("school_informations/" + mutationName, {
                        value: value,
                        id: lang.language_code,
                        key: key,
                    });
                });
            }
        },
        fetchSchoolInformation() {
            this.$store
                .dispatch("school_informations/fetchSchoolInformation", {
                    url: `${process.env.MIX_WEB_API_URL}school-informations?withSchoolDetail=1`,
                })
                .then((res) => {
                    let school_more_images_array = res.data.data
                        ?.school_more_images
                        ? res.data.data?.school_more_images
                        : [];

                    for (var i = 0; i < school_more_images_array?.length; i++) {
                        if (school_more_images_array[i]?.image) {
                            this.$store.commit(
                                "school_informations/setImages",
                                school_more_images_array[i]?.image
                            );
                        }
                    }
                    let school_more_links_array = res.data.data
                        ?.school_more_links
                        ? res.data.data?.school_more_links
                        : [];
                    for (var i = 0; i < school_more_links_array?.length; i++) {
                        if (school_more_links_array[i]) {
                            this.$store.commit(
                                "school_informations/setMoreLinks",
                                school_more_links_array[i]
                            );
                        }
                    }

                    let school_keys = [
                        "website_url",
                        "email",
                        "phone",
                        "time",
                        "time_zone",
                        "province",
                        "youtube_link",
                        "image",
                        "country",
                        "facebook",
                        // "degree_id",
                        "linkedin",
                        "insta",
                        "twitter",
                        "youtube",
                        "vk",
                        "main_button_link",
                        "other_button_link",
                        "quick_facts_status",
                        "overview_status",
                        "program_status",
                        "admission_status",
                        "financial_status",
                        "scholarship_status",
                        "contacts_status",
                        "ambassador_status",
                    ];
                    let status_keys = [
                        "quick_facts_status",
                        "overview_status",
                        "program_status",
                        "admission_status",
                        "financial_status",
                        "scholarship_status",
                        "contacts_status",
                        "ambassador_status",
                    ];
                    let data = res.data.data ? res.data.data : [];
                    for (var i = 0; i < school_keys?.length; i++) {
                        if (status_keys.indexOf(school_keys[i]) == -1) {
                            this.$store.commit(
                                "school_informations/setForData",
                                {
                                    key: school_keys[i],
                                    value: data[school_keys[i]]
                                        ? data[school_keys[i]]
                                        : "",
                                }
                            );
                        } else {
                            this.$store.commit(
                                "school_informations/setForData",
                                {
                                    key: school_keys[i],
                                    value:
                                        data[school_keys[i]] &&
                                        data[school_keys[i]] != ""
                                            ? data[school_keys[i]]
                                            : 0,
                                }
                            );
                        }
                    }
                    data =
                        res.data.data && res.data.data.school_detail
                            ? res.data.data.school_detail
                            : [];
                    let obj = {};
                    data.map((res) => {
                        obj["school_name_" + res.language_code] =
                            res.school_name;
                    });
                    this.$store.commit("school_informations/setForData", {
                        key: "school_name",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["description_" + res.language_code] =
                            res.description;
                    });
                    this.$store.commit("school_informations/setForData", {
                        key: "description",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["more_button_title_" + res.language_code] =
                            res.more_button_title;
                    });
                    this.$store.commit("school_informations/setForData", {
                        key: "more_button_title",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["more_button_sub_title_" + res.language_code] =
                            res.more_button_sub_title;
                    });
                    this.$store.commit("school_informations/setForData", {
                        key: "more_button_sub_title",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["other_button_title_" + res.language_code] =
                            res.other_button_title;
                    });
                    this.$store.commit("school_informations/setForData", {
                        key: "other_button_title",
                        value: obj,
                    });
                });
        },
        removeImage(index) {
            this.$store.commit("school_informations/removeImage", index);
        },
        handleImageArray(e) {
            console.log(e.target.files);
            for (var i = 0; i < e.target.files.length; i++) {
                var file = new FormData();
                file.append("file", e.target.files[i]);
                axios.post("/api/web/image_again_upload", file).then((res) => {
                    this.$store.commit(
                        "school_informations/setImages",
                        res?.data
                    );
                });
            }
        },
        handleImage(e) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.$store.commit("school_informations/setForData", {
                    key: "image",
                    value: res?.data,
                });
            });
        },
        deleteMoreLink(school_more_link) {
            this.$swal
                .fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        let url =
                            `${process.env.MIX_WEB_API_URL}more_links/` +
                            school_more_link;
                        axios.delete(url).then((res) => {
                            if (res.data.status == "Success") {
                                helper.swalSuccessMessage(res.data.message);
                                this.unSetLinksData();
                            }
                        });
                    }
                });
        },
        editMoreLink(school_more_link) {
            this.showModal = true;
            this.link_id = school_more_link;
        },
        unSetLinksData() {
            this.link_id = "";
            this.$store.commit("school_informations/unSetMoreLinks");
            this.fetchSchoolInformation();
        },
    },
    beforeUnmount() {
    document.removeEventListener("click", this.handleClickOutsidePopup);

  },
  mounted() {
    document.addEventListener("click", this.handleClickOutsidePopup);


        axios
            .get(
                "/api/web/customer-languages?customer_id=" +
                    this.logged_in_customer
            )
            .then((res) => {
                if (res.data.status == "Success") {
                    this.$store.commit(
                        "school_informations/setLanguages",
                        res.data.data
                    );
                    this.$store.commit("school_informations/setForData", {
                        key: "customer_id",
                        value: this.logged_in_customer,
                    });
                    let data = res.data.data;
                    let obj = {};
                    data.map((res) => {
                        obj["school_name_" + res.language_code] = "";
                    });
                    this.$store.commit("school_informations/setForData", {
                        key: "school_name",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["description_" + res.language_code] = "";
                    });
                    this.$store.commit("school_informations/setForData", {
                        key: "description",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["more_button_title_" + res.language_code] = "";
                    });
                    this.$store.commit("school_informations/setForData", {
                        key: "more_button_title",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["more_button_sub_title_" + res.language_code] = "";
                    });
                    this.$store.commit("school_informations/setForData", {
                        key: "more_button_sub_title",
                        value: obj,
                    });
                    obj = {};
                    data.map((res) => {
                        obj["other_button_title_" + res.language_code] = "";
                    });
                    this.$store.commit("school_informations/setForData", {
                        key: "other_button_title",
                        value: obj,
                    });
                    this.fetchSchoolInformation();
                }
            });

    },
    // created(){
    //     this.$store.commit("degrees/setLimit", 2000);
    //     this.$store.commit("degrees/setSortBy", "id");
    //     this.$store.commit("degrees/setSortType", "desc");
    //     this.$store.dispatch("degrees/fetchDegrees");
    // },
    components: { MoreLinkModal, Error },
};
</script>

<style scoped>
/* Slide Animation */
.slide-enter-active, .slide-leave-active {
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
  }
  .slide-enter-from, .slide-leave-to {
    transform: translateY(-20px);
    opacity: 0;
  }
</style>