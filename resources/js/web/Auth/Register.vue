<template>
    <div class="grid grid-cols-12 gap-5 lg:gap-10">
        <div class="col-span-12 lg:col-span-12 w-full">
            <div>
                <div class="border-b-4 pb-2 border-primary">
                    <h1 class="can-edu-h1">
                        {{
                            package_category === "school"
                                ? school_reg_settings?.school_request_setting_detail?.length > 0
                                    ? school_reg_settings?.school_request_setting_detail[0]?.page_title
                                    : ""
                                : reg_settings?.reg_page_setting_detail.length > 0
                                    ? reg_settings?.reg_page_setting_detail[0]?.page_title
                                    : ""
                        }}
                        <!-- ({{ package_category }}) -->
                    </h1>
                    <!-- <p>Contact us for your temporary login credentials</p> -->
                </div>
                <div class=" pt-8" v-if="package_category !== 'student'">
                    <div class="text-center mt-4 mb-2 flex flex-col justify-center items-center">
                        <p>Please select your registration package. Start by choosing a duration</p>
                        <svg width="40" height="40" viewBox="0 0 423 557" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M218.622 394.188C205.437 369.942 189.652 346.998 165.4 327.791C165.763 330.7 166.013 333.291 166.234 335.575C166.362 336.897 166.48 338.115 166.604 339.233C167.098 343.688 167.677 346.328 168.973 348.249C204.057 400.251 226.795 457.628 244.498 517.214C246.733 524.734 249.158 532.171 252.838 538.674C257.861 547.547 263.59 552.388 269.794 553.935C276.002 555.484 283.315 553.892 291.848 548.519L293.041 550.413L291.848 548.519C295.988 545.913 299.802 542.48 303.406 538.833L305.091 540.498L303.406 538.833C336.692 505.157 370.667 471.561 416.292 452.479C396.86 445.344 379.509 446.081 363.303 451.598C345.416 457.686 328.814 469.633 312.323 483.624L308.206 487.117V481.718C308.206 466.752 308.572 452.192 308.93 437.928C309.691 407.663 310.419 378.726 307.546 350.052C295.137 226.192 244.28 121.418 143.472 46.6022C117.563 27.3736 84.5008 16.4676 52.7553 5.99609L52.2958 5.84448L53.0178 3.65552L52.2957 5.84442C41.1379 2.16345 34.2754 1.64648 27.4674 3.67877C21.6912 5.40308 15.8071 8.98517 7.38014 14.6144C113.844 23.9766 174.073 94.7545 222.293 180.262C273.209 270.554 285.806 366.598 263.619 472.218L262.303 478.483L259.025 472.984C251.387 460.169 244.792 446.906 238.362 433.65C237.402 431.67 236.446 429.691 235.49 427.714C230.034 416.425 224.605 405.19 218.622 394.188Z" fill="black" stroke="black" stroke-width="5"></path>
                        </svg>
                    </div>
                    <div class="mx-auto max-w-7xl px-6 lg:px-8">
                        <div class="flex justify-center">
                            <fieldset
                                class="flex flex-wrap items-center justify-center gap-2"
                            >
                                <legend class="sr-only">
                                    Payment frequency
                                </legend>

                                <label
                                    class="cursor-pointer rounded font-FuturaMdCnBT text-base lg:text-lg px-3 py-2 border border-primary text-center whitespace-nowrap font-medium w-24 md:w-28 "
                                    :class="
                                        payment_frequency == 'monthly'
                                            ? 'bg-primary text-white'
                                            : 'bg-white text-primary'
                                    "
                                >
                                    <input
                                        type="radio"
                                        name="frequency"
                                        value="monthly"
                                        class="sr-only"
                                        @click="
                                            updatePackageForm(
                                                'payment_frequency',
                                                'monthly'
                                            )
                                        "
                                    />
                                    <span>Monthly</span>
                                </label>
                                <label
                                    class="cursor-pointer rounded font-FuturaMdCnBT text-base lg:text-lg px-3 py-2 border border-primary text-center whitespace-nowrap font-medium w-24 md:w-28"
                                    :class="
                                        payment_frequency == 'quarterly'
                                            ? 'bg-primary text-white'
                                            : 'bg-white text-primary'
                                    "
                                >
                                    <input
                                        type="radio"
                                        name="frequency"
                                        value="quarterly"
                                        class="sr-only"
                                        @click="
                                            updatePackageForm(
                                                'payment_frequency',
                                                'quarterly'
                                            )
                                        "
                                    />
                                    <span>Quarterly</span>
                                </label>
                                <label
                                    class="cursor-pointer rounded font-FuturaMdCnBT text-base lg:text-lg px-3 py-2 border border-primary text-center whitespace-nowrap font-medium w-24 md:w-28"
                                    :class="
                                        payment_frequency == 'semi_annually'
                                            ? 'bg-primary text-white'
                                            : 'bg-white text-primary'
                                    "
                                >
                                    <input
                                        type="radio"
                                        name="frequency"
                                        value="semi_annually"
                                        class="sr-only"
                                        @click="
                                            updatePackageForm(
                                                'payment_frequency',
                                                'semi_annually'
                                            )
                                        "
                                    />
                                    <span>Semi annually</span>
                                </label>
                                <label
                                    class="cursor-pointer rounded font-FuturaMdCnBT text-base lg:text-lg px-3 py-2 border border-primary text-center whitespace-nowrap font-medium w-24 md:w-28"
                                    :class="
                                        payment_frequency == 'annually'
                                            ? 'bg-primary text-white'
                                            : 'bg-white text-primary'
                                    "
                                >
                                    <input
                                        type="radio"
                                        name="frequency"
                                        value="annually"
                                        class="sr-only"
                                        @click="
                                            updatePackageForm(
                                                'payment_frequency',
                                                'annually'
                                            )
                                        "
                                    />
                                    <span>Annually</span>
                                </label>
                            </fieldset>
                        </div>
                        <div
                        class="isolate mx-auto mt-10 grid max-w-md grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-3"
                        >
                            <div
                                class="rounded-3xl p-6 xl:p-6 border hover:ring-2 hover:ring-primary bg-white cursor-pointer"
                                :class="
                                    package_type == regPackage?.package_type
                                        ? 'ring-2 ring-primary'
                                        : ''
                                "
                                v-for="(
                                    regPackage, i
                                ) in sortedPackages"
                                :key="i"
                                aria-describedby="tier-startup"
                                    @click.prevent="
                                        updatePackageForm(
                                            'package_type',
                                            regPackage
                                        )
                                    "
                            >
                                <div
                                    class="flex items-center justify-center gap-x-4"
                                >
                                    <h3
                                        id="tier-startup"
                                        class="text-center text-3xl font-medium text-primary"
                                    >
                                        {{
                                            regPackage
                                                ?.registration_package_detail?.[0]
                                                ?.name
                                        }}
                                    </h3>
                                    <p
                                        class="rounded-full bg-primary/10 px-2.5 py-1 text-xs font-semibold leading-5 text-primary"
                                        v-if="regPackage?.is_default"
                                    >
                                        Most popular
                                    </p>
                                </div>
                                <p class="mt-4 text-sm leading-6 text-black">
                                    {{
                                        regPackage
                                            ?.registration_package_detail?.[0]
                                            ?.short_description
                                    }}
                                </p>
                                <p class="mt-6 flex justify-center items-baseline gap-x-1">
                                    <span
                                        class="text-4xl font-bold tracking-tight text-black"
                                    >
                                        <template
                                            v-if="
                                                payment_frequency == 'monthly'
                                            "
                                        >
                                            ${{ regPackage?.monthly_price }}
                                        </template>
                                        <template
                                            v-else-if="
                                                payment_frequency == 'quarterly'
                                            "
                                        >
                                            ${{ regPackage?.quarterly_price }}
                                        </template>
                                        <template
                                            v-else-if="
                                                payment_frequency ==
                                                'semi_annually'
                                            "
                                        >
                                            ${{
                                                regPackage?.semi_annually_price
                                            }}
                                        </template>
                                        <template
                                            v-else-if="
                                                payment_frequency == 'annually'
                                            "
                                        >
                                            ${{ regPackage?.annually_price }}
                                        </template>
                                    </span>

                                    <span
                                        class="text-sm font-semibold leading-6 text-black"
                                        >/month</span
                                    >
                                </p>
                                <ul
                                    role="list"
                                    class="mt-8 space-y-3 text-sm leading-6 text-black xl:mt-10 p-0"
                                    v-if="
                                        regPackage?.registration_package_feature
                                    "
                                >
                                    <li
                                        class="flex gap-x-3"
                                        v-for="features in regPackage?.registration_package_feature"
                                        :key="features.id"
                                    >
                                        <svg
                                            class="h-6 w-5 flex-none text-primary"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        {{ features?.name }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <Error
                            fieldName="registration_package_id"
                            :validationErros="errors"
                        />
                    </div>
                </div>
                <div class="my-4 relative" v-if="package_category !== 'student'">
                    <label class="text-lg">Auto-renew (Cancel anytime)</label>
                    :
                    <input type="checkbox" v-model="is_auto_renew" />
                    <error
                        fieldName="is_auto_renew"
                        :validationErros="errors"
                    />
                </div>
                <!-- <p v-if="package_category !== 'student'">If, for whatever reason, you do not feel that we delivered the promised services to your full satisfaction, we will give you a full refund of your subscription fee. You have 30 days to decide</p> -->
                <!-- </div> -->
                <div class="mt-4 relative">
                    <label for="" class="block text-base lg:text-lg">
                        {{ 
                            package_category === "school"
                                ? school_reg_settings?.school_request_setting_detail?.length > 0
                                    ? school_reg_settings?.school_request_setting_detail[0]?.name_label
                                    : ""
                                : reg_settings?.reg_page_setting_detail.length > 0
                                    ? reg_settings?.reg_page_setting_detail[0]?.reg_first_name_label
                                    : ''
                         }}
                         <span class="text-primary">*</span>
                    </label>
                    <input
                        type="text"
                        :placeholder="
                            package_category === 'school'
                                ? school_reg_settings?.school_request_setting_detail?.length > 0
                                    ? school_reg_settings?.school_request_setting_detail[0]?.name_placeholder
                                    : ''
                                : reg_settings?.reg_page_setting_detail.length > 0
                                    ? reg_settings?.reg_page_setting_detail[0]?.reg_first_name_placeholder
                                    : ''
                        "
                        v-model="first_name"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position == 'rtl'
                                ? 'border-r-4 rounded-r border-r-primary'
                                : 'border-l-4 rounded-l border-l-primary'
                        "
                    />
                    <error fieldName="first_name" :validationErros="errors" />
                </div>
                <div class="mt-4 relative">
                    <label for="" class="block text-base lg:text-lg">
                        {{ 
                            package_category === 'school'
                                ? school_reg_settings?.school_request_setting_detail?.length > 0
                                    ? school_reg_settings?.school_request_setting_detail[0]?.description_label
                                    : ''
                                : reg_settings?.reg_page_setting_detail.length > 0
                                    ? reg_settings?.reg_page_setting_detail[0]?.reg_last_name_label
                                    : ''
                         }}
                         <span class="text-primary">*</span>
                    </label>
                    <input
                        type="text"
                        :placeholder="
                            package_category === 'school'
                                ? school_reg_settings?.school_request_setting_detail?.length > 0
                                    ? school_reg_settings?.school_request_setting_detail[0]?.description_placeholder
                                    : ''
                                : reg_settings?.reg_page_setting_detail.length > 0
                                    ? reg_settings?.reg_page_setting_detail[0]?.reg_last_name_placeholder
                                    : ''
                        "
                        v-model="last_name"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position == 'rtl'
                                ? 'border-r-4 rounded-r border-r-primary'
                                : 'border-l-4 rounded-l border-l-primary'
                        "
                    />
                    <error fieldName="last_name" :validationErros="errors" />
                </div>
                <div class="mt-4 relative">
                    <label for="" class="block text-base lg:text-lg">
                        {{ 
                            package_category === 'school'
                                ? school_reg_settings?.school_request_setting_detail?.length > 0
                                    ? school_reg_settings?.school_request_setting_detail[0]?.email_label
                                    : ''
                                : reg_settings?.reg_page_setting_detail.length > 0
                                    ? reg_settings?.reg_page_setting_detail[0]?.reg_email_label
                                    : ''
                         }}
                         <span class="text-primary">*</span>
                    </label>
                    <input
                        type="text"
                        :placeholder="
                            package_category === 'school'
                                ? school_reg_settings?.school_request_setting_detail?.length > 0
                                    ? school_reg_settings?.school_request_setting_detail[0]?.email_placeholder
                                    : ''
                                : reg_settings?.reg_page_setting_detail.length > 0
                                    ? reg_settings?.reg_page_setting_detail[0]?.reg_email_placeholder
                                    : ''
                        "
                        v-model="email"
                        @change="validateEmail($event)"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position == 'rtl'
                                ? 'border-r-4 rounded-r border-r-primary'
                                : 'border-l-4 rounded-l border-l-primary'
                        "
                    />
                    <error fieldName="email" :validationErros="errors" />
                    <small
                        class="text-red-600 text-sm mt-2"
                        v-if="emailValidationErro != ''"
                        v-text="emailValidationErro"
                    ></small>
                </div>
                <!-- <div class="mt-4 relative">
                    <label for="" class="block text-base lg:text-lg">Your phone number</label>
                    <input
                        type="text"
                        placeholder="With area code"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position == 'rtl'
                                ? 'border-r-4 rounded-r border-r-primary'
                                : 'border-l-4 rounded-l border-l-primary'
                        "
                    />
                </div> -->
                <div class="mt-4 relative">
                    <label class="block text-base lg:text-lg">
                        {{ 
                            package_category === 'school'
                                ? school_reg_settings?.school_request_setting_detail?.length > 0
                                    ? school_reg_settings?.school_request_setting_detail[0]?.phone_label
                                    : ''
                                : reg_settings?.reg_page_setting_detail.length > 0
                                    ? reg_settings?.reg_page_setting_detail[0]?.reg_passowrd_label
                                    : ''
                         }}
                         <span class="text-primary">*</span>
                    </label>
                    <input
                        type="password"
                        :placeholder="
                            package_category === 'school'
                                ? school_reg_settings?.school_request_setting_detail?.length > 0
                                    ? school_reg_settings?.school_request_setting_detail[0]?.phone_placeholder
                                    : ''
                                : reg_settings?.reg_page_setting_detail.length > 0
                                    ? reg_settings?.reg_page_setting_detail[0]?.reg_passowrd_placeholder
                                    : ''
                        "
                        v-model="password"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position == 'rtl'
                                ? 'border-r-4 rounded-r border-r-primary'
                                : 'border-l-4 rounded-l border-l-primary'
                        "
                    />

                    <error fieldName="password" :validationErros="errors" />
                </div>
                <div class="mt-4 relative">
                    <label class="block text-base lg:text-lg">
                        {{ 
                            package_category === 'school'
                                ? school_reg_settings?.school_request_setting_detail?.length > 0
                                    ? school_reg_settings?.school_request_setting_detail[0]?.time_label
                                    : ''
                                : reg_settings?.reg_page_setting_detail.length > 0
                                    ? reg_settings?.reg_page_setting_detail[0]?.reg_confirm_passowrd_label
                                    : ''
                         }}
                         <span class="text-primary">*</span>
                    </label>
                    <input
                        type="password"
                        :placeholder="
                            package_category === 'school'
                                ? school_reg_settings?.school_request_setting_detail?.length > 0
                                    ? school_reg_settings?.school_request_setting_detail[0]?.time_placeholder
                                    : ''
                                : reg_settings?.reg_page_setting_detail.length > 0
                                    ? reg_settings?.reg_page_setting_detail[0]?.reg_confirm_passowrd_placeholder
                                    : ''
                        "
                        v-model="password_confirmation"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position == 'rtl'
                                ? 'border-r-4 rounded-r border-r-primary'
                                : 'border-l-4 rounded-l border-l-primary'
                        "
                    />
                    <error
                        fieldName="password_confirmation"
                        :validationErros="errors"
                    />
                </div>
                
                <!-- <div class="mt-4 relative">
                    <label for="" class="block text-base lg:text-lg">Best time to reach you</label>
                    <input
                        type="text"
                        placeholder="Please mention tentative date and time, and give more than one time choice"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position == 'rtl'
                                ? 'border-r-4 rounded-r border-r-primary'
                                : 'border-l-4 rounded-l border-l-primary'
                        "
                    />
                </div>

                <div class="mt-4 relative">
                    <label for="" class="block text-base lg:text-lg">Your location</label>
                    <input
                        type="text"
                        placeholder="City, Province, and Country"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position == 'rtl'
                                ? 'border-r-4 rounded-r border-r-primary'
                                : 'border-l-4 rounded-l border-l-primary'
                        "
                    />
                </div>

                <div class="mt-4 relative">
                    <label for="" class="block text-base lg:text-lg">Would you like to tell us anything before we contact you?</label>
                    <textarea
                        rows="5"
                        placeholder="Would you like to tell us anything before we contact you?"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position == 'rtl'
                                ? 'border-r-4 rounded-r border-r-primary'
                                : 'border-l-4 rounded-l border-l-primary'
                        "
                    ></textarea>
                </div> -->

                <div>
                    
                </div>

                <div class="mt-2">
                    <div
                        class="text-base text-black"
                        v-html="
                            package_category === 'school'
                                ? school_reg_settings?.school_request_setting_detail?.length > 0
                                    ? school_reg_settings?.school_request_setting_detail[0]?.protect_your_account_description
                                    : ''
                                : reg_settings?.reg_page_setting_detail.length > 0
                                    ? reg_settings?.reg_page_setting_detail[0]?.privacy_terms_text
                                    : ''
                        "
                        ref="privacyContent"
                    ></div>
                </div>
                <div class="recaptcha">
                    <Error
                    v-if="submitted"
                        fieldName="captcha"
                        :validationErros="errors"
                        full_width="1"
                    />
                </div>
                <div class="mt-4 text-center">
                    <button
                        class="can-edu-btn-fill w-56 text-white whitespace-nowrap"
                        @click="recaptcha()"
                    >
                        {{
                            package_category === 'school'
                                ? school_reg_settings?.school_request_setting_detail?.length > 0
                                    ? school_reg_settings?.school_request_setting_detail[0]?.submit_button_text
                                    : ''
                                : reg_settings?.reg_page_setting_detail.length > 0
                                    ? reg_settings?.reg_page_setting_detail[0]
                                          ?.reg_button_text
                                    : ""
                        }}
                    </button>
                </div>
                <div class="bg-white rounded-lg shadow-md border p-4 my-6">
                    <p class="text-primary font-medium text-xl mb-2">Protecting your privacy is fundamental to our mission and business</p>
                    <ul class="list-disc list-inside text-base md:text-base lg:text-lg">
                        <li>We never sell your data or information</li>
                        <li>We never send you junk email</li>
                        <li>We don't own the content you add to our website</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <transition name="slide">
        <div id="defaultModal" tabindex="-1" 
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
                            {{popupMsg}}
                        </p>
                        <div class="flex justify-center">
                        <button type="button" class="can-edu-btn-fill  whitespace-nowrap px-2.5 md:px-5 mt-4" @click="togglePopUpModal">
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
import ErrorHandling from "./../../ErrorHandling";
import vueRecaptcha from "vue3-recaptcha2";
import Error from "../Error.vue";
import { load } from "recaptcha-v3";
import Swal from "sweetalert2";
export default {
    components: { vueRecaptcha, Error },
    computed: {
        sitekey() {
            return process.env.MIX_RECAPTCHA_SITE_KEY;
        },
        sortedPackages() {
            return this.registeration_packages.slice().sort((a, b) => {
                const order = ["Free", "Premium", "Feature"];
                const nameA =
                    a?.registration_package_detail?.[0]?.name || "";
                const nameB =
                    b?.registration_package_detail?.[0]?.name || "";

                const indexA = order.indexOf(nameA);
                const indexB = order.indexOf(nameB);

                if (indexA === -1 && indexB === -1) return 0; // Keep other items unchanged
                if (indexA === -1) return 1; // Move unknown items to the end
                if (indexB === -1) return -1;
                return indexA - indexB;
            });
        },
    },
    props: [
        "position",
        "registeration_package",
        "reg_page_settings",
        "school_request_setting",
        "slug",
        "lang",
        "package_category",
    ],
    data() {
        return {
            submitted: false,
            showPopUpModal: false,
            redirect_url:'',
            popupMsg:'',
            first_name: "",
            last_name: "",
            email: "",
            password: "",
            registration_package_id: "",
            package_type: "",
            password_confirmation: "",
            errors: new ErrorHandling(),
            error_message: "",
            reg_settings: null,
            school_reg_settings: null,
            showRecaptcha: true,
            toggelSubmitButton: false,
            registeration_packages: [],
            emailValidationErro: "",
            is_auto_renew: true,
            payment_frequency: "annually",
        };
    },
    methods: {
        togglePopUpModal() {
            this.showPopUpModal = !this.showPopUpModal;
            if (!this.showPopUpModal) {
                           window.location.href = this.redirect_url;
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
                    window.location.href = this.redirect_url;

                }
            }
        },
        recaptchaVerified(response) {
            this.toggelSubmitButton = true;
        },
        recaptchaExpired() {
            this.toggelSubmitButton = false;
            this.$refs.vueRecaptcha.reset();
        },
        recaptchaFailed() {
            this.toggelSubmitButton = false;
        },
        validateEmail(e) {
            this.emailValidationErro = "";
            if (
                /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(
                    e.target.value
                )
            ) {
                axios
                    .post(
                        `${process.env.MIX_WEB_API_URL}validate-customer-email`,
                        {
                            email: e.target.value,
                        }
                    )
                    .then((res) => {
                        if (res.data.status == "Success") {
                            this.emailValidationErro =
                                "email is already in use";
                            return false;
                        }
                    })
                    .catch((error) => {
                        this.error_message = "";
                        this.errors = new ErrorHandling();
                        if (error.response.status == 422) {
                            if (error.response.data.status == "Error") {
                                this.$toaster.error(
                                    error.response.data.message
                                );
                            } else {
                                this.errors.record(error.response.data.errors);
                            }
                        }
                    });
                return true;
            } else {
                // this.emailValidationErro =
                //     "please use this format your@email.com";
            }
            return false;
        },
        setPackage(package_id) {
            this.registration_package_id = package_id;
        },
        async recaptcha() {
            this.submitted = true;
            // this.loading = 1;
            load(process.env.MIX_reCAPTCHA_site_key_new).then((recaptcha) => {
                recaptcha.showBadge()
                recaptcha.execute("submit").then((token) => {
                    axios
                .post(`${process.env.MIX_WEB_API_URL}verifyRecaptcha`, {
                    token: token,
                })
                .then((res) => {
                    setTimeout(() => {
                        recaptcha.hideBadge()
                    }, 3000);
                    if (res.data.status == "Success") {
                        this.register();
                    } else if (res.data.status == "Error") {
                        // this.loading = 0;
                        this.errors.record({
                            captcha: [res.data.message],
                        });
                    }
                });
                });
            });
        },
        register() {
            console.log(this.email, this.password);
            axios
                .post(`${process.env.MIX_WEB_API_URL}signup`, {
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    first_name: this.first_name,
                    last_name: this.last_name,
                    is_auto_renew: this.is_auto_renew,
                    user_type: this.package_category,
                    registration_package_id: this.registration_package_id,
                    package_type:this.package_type,
                    payment_frequency:this.payment_frequency
                })
                .then((res) => {
                    if (res.data.status == "Success") {
                        console.log(res.data.message)
                        this.showPopUpModal=true;
                        this.popupMsg=res.data.message;
                        this.redirect_url = res.data.data.redirect_url;
                        // Swal.fire({
                        //    title: "Success!",
                        //    text: res.data.message,
                        //    icon: "success",
                        //    showConfirmButton: true,
                        //    allowOutsideClick: false,
                        // }).then(() => {
                        //    window.location.href = res.data.data.redirect_url;
                        // });
                    }
                    if (res.data.status == "Error") {
                        helper.swalErrorMessage(res.data.message);
                    }
                })
                .catch((error) => {
                    this.error_message = "";
                    this.errors = new ErrorHandling();
                    if (error.response.status == 422) {
                        if (error.response.data.status == "Error") {
                            this.$toaster.error(error.response.data.message);
                        } else {
                            this.errors.record(error.response.data.errors);
                        }
                    }
                })
                .finally(() => (this.$parent.loading = false));
        },
        updatePackageForm(field, value) {
            if (field == "payment_frequency") {
                this[field] = value;
            }
            if (field == "package_type") {
                this.package_type = value.package_type;
                this.registration_package_id = value.id;
            }
        },
        updateLinks() {
            this.$nextTick(() => {
                const links = this.$refs.privacyContent?.querySelectorAll("a") || [];
                links.forEach(link => {
                    link.setAttribute("target", "_blank");
                    link.setAttribute("rel", "noopener noreferrer");

                    // Prevent default behavior properly
                    link.addEventListener("click", (event) => {
                        event.preventDefault(); // Stop default navigation
                        event.stopImmediatePropagation(); // Stop all event listeners
                        window.open(link.href, "_blank"); // Open in new tab
                    }, true); // Use capture phase to override other event listeners
                });
            });
        },
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutsidePopup);
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutsidePopup);
        console.log('redirect_url',this.redirect_url);
        this.reg_settings = JSON.parse(this.reg_page_settings);
        this.school_reg_settings = JSON.parse(this.school_request_setting);

        this.registeration_packages = JSON.parse(this.registeration_package);
        const defaultPackage = this.registeration_packages.find(
            pkg => pkg.is_default
        );
        if (defaultPackage) {
            this.package_type = defaultPackage.package_type;
            this.registration_package_id = defaultPackage.id;
        }
        this.updateLinks();
    },
    watch: {
        first_name(newValue, oldValue) {
            this.errors.has("first_name") ? this.errors.clear("first_name") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rt_first_name", newValue);
            }
        },
        last_name(newValue, oldValue) {
            this.errors.has("last_name") ? this.errors.clear("last_name") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rt_last_name", newValue);
            }
        },
        email(newValue, oldValue) {
            this.errors.has("email") ? this.errors.clear("email") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rt_email", newValue);
            }
        },
        password(newValue, oldValue) {
            this.errors.has("password") ? this.errors.clear("password") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rt_password", newValue);
            }
        },
   
    },
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