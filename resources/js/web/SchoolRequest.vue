<template>
    <div
        class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8"
    >
        <div class="w-full md:w-8/12">
            <div class="border-b-4 pb-2 border-primary">
                <h1 class="can-edu-h1">
                    {{
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.page_title
                            : ""
                    }}
                </h1>
            </div>
            <div class="flex justify-end mt-4">
                <p class="font-semibold text-red-500">
                    {{ indicate_required_field }}
                </p>
            </div>
            <!-- <ul class="flex gap-2 flex-wrap my-4">
                <li
                    class="mr-1 md:mr-2 mb-2"
                    v-for="(language, key) in languages"
                    :key="language.language_code"
                >
                    <a
                        @click.prevent="changeLanguageTab(language)"
                        href="#"
                        :class="[
                            'inline-block py-1 md:py-2 px-2 md:px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',

                            activeTab == language.language_code
                                ? 'text-white bg-primary active'
                                : '',
                            errors.has(`business_name.` + key)
                                ? 'bg-red-600 text-white hover:text-white'
                                : '',
                        ]"
                        >{{ language.language_code }}</a
                    >
                </li>
            </ul> -->
            <div
                v-for="(language, key) in languages"
                :key="key"
                class="mt-4"
                :class="
                    activeTab == language.language_code ? 'block' : 'hidden'
                "
            >
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.name_label
                            : ""
                    }}
                    <span class="text-primary">*</span>
                </label>
                <input
                name="school_name"
                    :key="key"
                    :value="school_name[key]"
                    @input="handleNameInput($event.target.value, key)"
                    type="text"
                    :placeholder="
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.name_placeholder
                            : ''
                    "
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-4 rounded-r border-r-primary'
                            : 'border-l-4 rounded-l border-l-primary'
                    "
                />
                <error
                    :fieldName="'school_name.' + key"
                    :validationErros="errors"
                />
            </div>
            <div
                v-for="(language, key) in languages"
                :key="key"
                class="mt-4 relative"
                :class="
                    activeTab == language.language_code ? 'block' : 'hidden'
                "
            >
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.description_label
                            : ""
                    }}
                    <span class="text-primary">*</span>
                </label>
                <textarea
                name="description"
                    :key="key"
                    rows="6"
                    @input="handleDescInput($event.target.value, key)"
                    :placeholder="
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.description_placeholder
                            : ''
                    "
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-4 rounded-r border-r-primary'
                            : 'border-l-4 rounded-l border-l-primary'
                    "
                    :value="description[key]"
                ></textarea>
                <error
                    :fieldName="'description.' + key"
                    :validationErros="errors"
                />
            </div>
            <div class="relative mt-4">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.website_label
                            : ""
                    }}
                    <span class="text-primary">*</span>
                </label>
                <input
                name="website_url"
                    type="text"
                    :placeholder="
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.website_placeholder
                            : ''
                    "
                    v-model="website_url"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-4 rounded-r border-r-primary'
                            : 'border-l-4 rounded-l border-l-primary'
                    "
                />
                <error :fieldName="'website_url'" :validationErros="errors" />
            </div>
            <div class="relative mt-4">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.email_label
                            : ""
                    }}
                    <span class="text-primary">*</span>
                </label>
                <input
                name="email"
                    type="email"
                    :placeholder="
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.email_placeholder
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
                <error :fieldName="'email'" :validationErros="errors" />
                <small
                    class="text-red-600 text-sm mt-2"
                    v-if="emailValidationErro != ''"
                    v-text="emailValidationErro"
                ></small>
            </div>
            <div class="relative mt-4">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.phone_label
                            : ""
                    }}
                    <span class="text-primary">*</span>
                </label>
                <input
                name="phone"
                    type="text"
                    :placeholder="
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.phone_placeholder
                            : ''
                    "
                    v-model="phone"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-4 rounded-r border-r-primary'
                            : 'border-l-4 rounded-l border-l-primary'
                    "
                    @keypress="restrictToNumbers($event, 15)"
                />
                <error :fieldName="'phone'" :validationErros="errors" />
            </div>
            <div class="flex flex-col md:flex-row w-full gap-2 mt-4">
                <div class="md:w-3/4 relative">
                    <label
                        for=""
                        class="block text-base lg:text-lg"
                    >
                        {{
                            request_setting?.school_request_setting_detail
                                ?.length > 0
                                ? request_setting
                                      ?.school_request_setting_detail[0]
                                      ?.time_label
                                : ""
                        }}
                        <span class="text-primary">*</span>
                    </label>
                    <input
                    name="time"
                        type="text"
                        :placeholder="
                            request_setting?.school_request_setting_detail
                                ?.length > 0
                                ? request_setting
                                      ?.school_request_setting_detail[0]
                                      ?.time_placeholder
                                : ''
                        "
                        v-model="time"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position == 'rtl'
                                ? 'border-r-4 rounded-r border-r-primary'
                                : 'border-l-4 rounded-l border-l-primary'
                        "
                    />
                    <error :fieldName="'time'" :validationErros="errors" />
                </div>
                <div class="md:w-3/12 relative">
                    <label
                        for=""
                        class="block text-base lg:text-lg"
                    >
                        {{
                            request_setting?.school_request_setting_detail
                                ?.length > 0
                                ? request_setting
                                      ?.school_request_setting_detail[0]
                                      ?.time_zone_label
                                : ""
                        }}
                        <span class="text-primary">*</span>
                    </label>
                    <select
                        name="time_zone"
                        id=""
                        v-model="time_zone"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position == 'rtl'
                                ? 'border-r-4 rounded-r border-r-primary'
                                : 'border-l-4 rounded-l border-l-primary'
                        "
                    >
                        <option value="">
                            {{
                                request_setting?.school_request_setting_detail
                                    ?.length > 0
                                    ? request_setting
                                          ?.school_request_setting_detail[0]
                                          ?.time_zone_placeholder
                                    : ""
                            }}
                        </option>
                        <option
                            v-for="(time_zone, key) in time_zones"
                            :key="key"
                            :value="time_zone"
                        >
                            {{ time_zone }}
                        </option>
                    </select>
                    <error
                        full_width="true"
                        class="tooltip_full"
                        :fieldName="'time_zone'"
                        :validationErros="errors"
                    />
                </div>
            </div>
            <div class="relative mt-4">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.image_upload_label
                            : ""
                    }}
                    <span class="text-primary">*</span>
                </label>
                <input
                    :key="`image`"
                    type="file"
                    :name="`image`"
                    :id="`image`"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-4 rounded-r border-r-primary'
                            : 'border-l-4 rounded-l border-l-primary'
                    "
                    placeholder=" "
                    @input="handleImage($event)"
                />
                <error :fieldName="'image'" :validationErros="errors" />

                <img
                    v-if="image"
                    :src="image ? image : ''"
                    style="height: 100px; width: 100px"
                />
            </div>
            <div class="relative mt-4">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.province_label
                            : ""
                    }}
                    <span class="text-primary">*</span>
                </label>
                <input
                name="province"
                    type="text"
                    :placeholder="
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.province_placeholder
                            : ''
                    "
                    v-model="province"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-4 rounded-r border-r-primary'
                            : 'border-l-4 rounded-l border-l-primary'
                    "
                />
                <error :fieldName="'province'" :validationErros="errors" />
            </div>
            <div class="relative mt-4">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.country_label
                            : ""
                    }}
                    <span class="text-primary">*</span>
                </label>
                <select
                    name="country"
                    id=""
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-4 rounded-r border-r-primary'
                            : 'border-l-4 rounded-l border-l-primary'
                    "
                    v-model="country"
                >
                    <option value="">
                        {{
                            request_setting?.school_request_setting_detail
                                ?.length > 0
                                ? request_setting
                                      ?.school_request_setting_detail[0]
                                      ?.country_placeholder
                                : ""
                        }}
                    </option>
                    <option
                        v-for="(country, key) in countries"
                        :key="key"
                        :value="country.code"
                    >
                        {{ country?.name }}
                    </option>
                </select>
                <error :fieldName="'country'" :validationErros="errors" />
            </div>
            <div class="relative mt-4">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.city_label
                            : ""
                    }}
                    <span class="text-primary">*</span>
                </label>
                <input
                    :key="`city`"
                    type="text"
                    :name="`city`"
                    :id="`city`"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-4 rounded-r border-r-primary'
                            : 'border-l-4 rounded-l border-l-primary'
                    "
                    :placeholder="
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.city_placeholder
                            : ''
                    "
                    v-model="city"
                />
                <error :fieldName="'city'" :validationErros="errors" />
            </div>
            <hr />
            <div class="relative mt-4">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.degree_label
                            : ""
                    }}
                    <span class="text-primary">*</span>
                </label>
                <select
                    name="degree_id"
                    id=""
                    class="w-full focus:ring-primary focus:outline-none my-2 px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-4 rounded-r border-r-primary'
                            : 'border-l-4 rounded-l border-l-primary'
                    "
                    v-model="degree_id"
                >
                    <option value="">select</option>
                    <option
                        v-for="(degree_level, key) in degree_levels"
                        :key="key"
                        :value="degree_level.id"
                    >
                        {{
                            degree_level?.degree_detail.length > 0
                                ? degree_level?.degree_detail[0].name
                                : ""
                        }}
                    </option>
                </select>
                <error :fieldName="'degree_id'" :validationErros="errors" />
            </div>
            <hr />
            <div class="border rounded p-3 mt-4">
                <div class="flex items-center">
                    <img class="h-5" src="/assets/sheildicon.png" alt="" />
                    <p class="font-bold text-gray-500">
                        {{
                            request_setting?.school_request_setting_detail
                                ?.length > 0
                                ? request_setting
                                      ?.school_request_setting_detail[0]
                                      ?.protect_your_account_text
                                : ""
                        }}
                    </p>
                </div>
                <p
                    class="mt-2 text-gray-500 text-base listing-ul"
                    v-html="
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.protect_your_account_description
                            : ''
                    "
                ></p>
            </div>
            <div class="recaptcha">
        <Error
        v-if="submitted"
            fieldName="captcha"
            :validationErros="errors"
            full_width="1"
        />
    </div>
            <br />
            <div class="flex justify-center">
                <button
                    class="can-edu-btn-fill w-56 text-white mx-auto whitespace-nowrap"
                    type="button"
                    @click="recaptcha()"
                >
                    {{
                        request_setting?.school_request_setting_detail?.length >
                        0
                            ? request_setting?.school_request_setting_detail[0]
                                  ?.submit_button_text
                            : ""
                    }}
                </button>
            </div>
            <NotLoggedInModal
                :is_login_modal_setting="login_modal_setting"
                :is_logged_id="logged_id"
                :login_slug="login_slug"
                :register_slug="register_slug"
                :lang="lang"
            />
            <template v-if="register_school_count > 0">
                <AlreadyHaveASchool
                    :lang="lang"
                    :slug="slug"
                    :already_have_school_modal_translations="
                        already_have_school_modal_translations
                    "
                />
            </template>
        </div>
        <br />
    </div>
    <transition name="slide">
        <div id="defaultModal" tabindex="-1" 
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
            v-if="showPopUpModal">
            <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                ref="elementToDetectClick">
                <div class="relative">
                    <div class="absolute top-3 right-3 cursor-pointer" @click="togglePopUpModal">
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                            <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                        <p class="text-center can-edu-p mt-2">
                            {{success_message}}
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
import Swal from "sweetalert2";
import axios from "axios";
import NotLoggedInModal from "./modals/NotLoggedInModal.vue";
import ErrorHandling from "./../ErrorHandling";
import { mapState } from "vuex";
import AlreadyHaveASchool from "./modals/AlreadyHaveASchool.vue";
import vueRecaptcha from "vue3-recaptcha2";
import { load } from "recaptcha-v3";
import Error from "./Error.vue";
export default {
    computed: {
        sitekey() {
            return process.env.MIX_RECAPTCHA_SITE_KEY;
        },
    },
    props: [
        "success_message",
        "register_school_count",
        "school_request_setting",
        "is_logged_id",
        "is_login_modal_setting",
        "login_slug",
        "register_slug",
        "logged_in_customer",
        "registeration_package",
        "degrees",
        "position",
        "indicate_required_field",
        "lang",
        "slug",
        "already_have_school_modal_translations",
    ],
    data() {
        return {
            showPopUpModal: false,
            submitted: false,
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
            request_setting: null,
            login_modal_setting: null,
            logged_id: null,
            school_name: [],
            description: [],
            website_url: "",
            email: "",
            phone: "",
            time: "",
            time_zone: "",
            province: "",
            country: "",
            errors: new ErrorHandling(),
            error_message: "",
            activeTab: "en",
            image: "",
            languages: [],
            city: "",
            degree_id: "1",
            degree_levels: [],
            showRecaptcha: true,
            toggelSubmitButton: false,
            emailValidationErro: "",
        };
    },
    methods: {
        togglePopUpModal() {
            this.showPopUpModal = !this.showPopUpModal;
            if (!this.showPopUpModal) {
                window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile";
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
                    window.location.href = "/" + this.lang + "/" + this.slug + "/our-profile";

                }
            }
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
        validateEmail(e) {
            this.emailValidationErro = "";
            if (
                /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(
                    e.target.value
                )
            ) {
                axios
                    .post(
                        `${process.env.MIX_WEB_API_URL}validate-school-email`,
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
        handleImage(e) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios
                .post("/api/admin/media/image_again_upload", file)
                .then((res) => {
                    this.image = res?.data;
                });
                // this.errors.clear(key);
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
                        this.registerSchool();
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
        registerSchool() {
            let languageToSend = [];
            this.languages?.filter((lang) => {
                languageToSend.push(lang?.language_code);
            });
            const data = {
                customer_id: this.logged_in_customer,
                school_name: this.school_name,
                description: this.description,
                website_url: this.website_url,
                email: this.email,
                linked_url: this.linked_url,
                time: this.time,
                time_zone: this.time_zone,
                country: this.country,
                province: this.province,
                phone: this.phone,
                image: this.image,
                language_id: languageToSend,
                city: this.city,
                degree_id: this.degree_id,
            };

            axios
                .post("/api/web/register-school", data)
                .then((res) => {
                    if (res?.data?.status == "Success") {
                        helper.swalSuccessMessage(
                            "Your School has been created"
                        );
                        let rsfields = [
                            "website_url",
                            "email",
                            "phone",
                            "time",
                            "time_zone",
                            "province",
                            "country",
                            "image",
                            "city",
                            "degree_id",
                            "rs_school_name",
                            "rs_school_index",
                            "rs_description",
                            "rs_description_index",
                        ];
                        rsfields?.map((f) => {
                            const savedField = localStorage.removeItem(
                                "rs_" + f
                            );
                        });
                        this.showPopUpModal=true;

                    }
                })
                .catch((error) => {
                    this.error_message = "";
                    this.errors = new ErrorHandling();
                    if (error.response.status == 422) {
                        if (error.response.data.status == "Error") {
                            helper.swalErrorMessage(
                                error.response.data.message
                            );
                        } else {
                            this.errors.record(error.response.data.errors);
                            this.focusOnFirstErrorInput(error.response.data.errors);
                        }
                    }
                })
                .finally(() => (this.$parent.loading = false));
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
        changeLanguageTab(language) {
            this.activeTab = language.language_code;
        },
        handleNameInput(val, key) {
            this.school_name[key] = val;
            localStorage.setItem("rs_school_name", val);
            localStorage.setItem("rs_school_index", key);
            if (this.errors.has(`school_name.${key}`)) {
        this.errors.delete(`school_name.${key}`);
    }
        },
        handleDescInput(val, key) {
            this.description[key] = val;
            localStorage.setItem("rs_description", val);
            localStorage.setItem("rs_description_index", key);
        },
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.image = res?.data;
                localStorage.setItem("rs_image", res?.data);
            });
            // this.errors.clear(key);
        },
    },
    created() {
        localStorage.removeItem("rs_school_name");
    localStorage.removeItem("rs_school_index");
    localStorage.removeItem("rs_description");
    localStorage.removeItem("rs_description_index");
        axios
            .get(
                "/api/web/customer-languages?customer_id=" +
                    this.logged_in_customer
            )
            .then((res) => {
                if (res.data.status == "Success") {
                    this.languages = res.data.data;
                    res.data.data?.filter((lang, key) => {
                        if (key == 0) {
                            this.activeTab == lang?.language_code;
                        }
                        this.school_name[key] = "";
                        this.description[key] = "";

                        const savedSN = localStorage.getItem("rs_school_name");
                        const savedSNIndex =
                            localStorage.getItem("rs_school_index");
                        if (savedSN && savedSNIndex) {
                            this.school_name[parseInt(savedSNIndex)] = savedSN;
                        }
                        const savedSD = localStorage.getItem("rs_description");
                        const savedSDIndex = localStorage.getItem(
                            "rs_description_index"
                        );
                        if (savedSD && savedSDIndex) {
                            this.description[parseInt(savedSDIndex)] = savedSD;
                        }
                    });
                }
            });
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutsidePopup);
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutsidePopup);

        let rsfields = [
            "website_url",
            "email",
            "phone",
            "time",
            "time_zone",
            "province",
            "country",
            "image",
            "city",
            "degree_id",
            // "description",
            // "school_name",
        ];
        rsfields?.map((f) => {
            this[f] = "";
        });
        this.request_setting = JSON.parse(this.school_request_setting);
        this.logged_id = this.is_logged_id;
        this.login_modal_setting = JSON.parse(this.is_login_modal_setting);
        this.degree_levels = JSON.parse(this.degrees);
        this.activeTab = this.lang;
    },
    components: { vueRecaptcha, NotLoggedInModal, AlreadyHaveASchool, Error },
    watch: {
        website_url(newValue, oldValue) {
            this.errors.has("website_url") ? this.errors.clear("website_url") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rs_website_url", newValue);
            }
        },
        email(newValue, oldValue) {
            this.errors.has("email") ? this.errors.clear("email") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rs_email", newValue);
            }
        },
        phone(newValue, oldValue) {
            this.errors.has("phone") ? this.errors.clear("phone") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rs_phone", newValue);
            }
        },
        time(newValue, oldValue) {
            this.errors.has("time") ? this.errors.clear("time") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rs_time", newValue);
            }
        },
        time_zone(newValue, oldValue) {
            this.errors.has("time_zone") ? this.errors.clear("time_zone") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rs_time_zone", newValue);
            }
        },
        country(newValue, oldValue) {
            this.errors.has("country") ? this.errors.clear("country") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rs_country", newValue);
            }
        },
        city(newValue, oldValue) {
            this.errors.has("city") ? this.errors.clear("city") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rs_city", newValue);
            }
        },
        degree_id(newValue, oldValue) {
            this.errors.has("degree_id") ? this.errors.clear("degree_id") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rs_degree_id", newValue);
            }
        },
        image(newValue, oldValue) {
            this.errors.has("image") ? this.errors.clear("image") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rs_image", newValue);
            }
        },
        province(newValue, oldValue) {
            this.errors.has("province") ? this.errors.clear("province") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rs_province", newValue);
            }
        },
        school_name: {
        handler(newVal) {
            Object.keys(newVal).forEach((key) => {
                if (this.errors.has(`school_name.${key}`)) {
                    this.errors.clear(`school_name.${key}`);
                }
            });
        },
        deep: true,
    },
        description: {
        handler(newVal) {
            Object.keys(newVal).forEach((key) => {
                if (this.errors.has(`description.${key}`)) {
                    this.errors.clear(`description.${key}`);
                }
            });
        },
        deep: true,
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