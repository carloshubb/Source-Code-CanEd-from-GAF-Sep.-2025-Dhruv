<template>
    <div class="md:col-span-9 col-span-12 border border-gray-500 rounded-md w-full">
        <h2 class="px-4 pt-4 can-school-h2 text-primary">Account information</h2>
        <div class="px-4 text-gray-500 text-base">
            Hi {{ user?.first_name || 'Guest' }}
        </div>
        <span class="px-4 text-gray-500 text-base">
            You can edit your personal information from here
        </span>
        <div class="px-4 ">
            <p class="text-red-500">
                {{ indicate_required_field }}
            </p>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-1 p-4 mt-2 border rounded-md shadow">
                <div class="bg-primary text-white w-fit px-2 py-1 mb-2 heading4">About you</div>
                <form action="" method="post" @submit="updateCustomer($event)">
                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-start gap-4 mt-2 w-full">
                        <div class="w-full md:w-1/2 relative">
                            <label for="" class="block text-base lg:text-lg">Your first name <span
                                    class="text-primary">*</span> </label>
                            <input type="text" placeholder="" name="first_name"
                                class="border text-base lg:text-lg text-gray-500 w-full border-l-[5px] bg-transparent focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                                v-model="first_name" />
                            <!-- <div class="z-10 bottom-12 left-1/4 absolute">
                                <p
                                    class="tooltiptext line-clamp-2 w-60 px-3 py-1 bg-primary text-white text-center rounded transition-all delay-300 after:absolute after:top-full after:left-1/2 after:-ml-1 after:border-[6px]"
                                    v-if="errors.has('first_name')"
                                    v-text="errors.get('first_name')"
                                ></p>
                            </div> -->
                            <error  class="whitespace-nowrap" :fieldName="`first_name`" :validationErros="errors" />
                        </div>
                        <div class="w-full md:w-1/2 relative">
                            <label for="" class="block text-base lg:text-lg">Your last name <span
                                    class="text-primary">*</span> </label>
                            <input type="text" placeholder="" name="last_name"
                                class="border text-base lg:text-lg text-gray-500 w-full border-l-[5px] bg-transparent focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                                v-model="last_name" />
                            <error  class="whitespace-nowrap" :fieldName="`last_name`" :validationErros="errors" />
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-start gap-4 mt-2">
                        <div class="w-full md:w-1/2 relative">
                            <label for="" class="block text-base lg:text-lg">Display name / Nickname</label>
                            <input type="text" placeholder="12 words max." name="display_name"
                                class="border text-base lg:text-lg text-gray-500 w-full border-l-[5px] bg-transparent focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                                v-model="display_name" maxlength="12" />
                            <!-- <error
                                :fieldName="`display_name`"
                                :validationErros="errors"
                            /> -->
                        </div>
                        <div class="w-full md:w-1/2 relative">
                            <label for="" class="block text-base lg:text-lg">Email <span class="text-primary">*</span>
                            </label>
                            <input type="text" placeholder="" name="email" 
                                class="border text-base lg:text-lg text-gray-500 w-full border-l-[5px] bg-transparent focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                                v-model="email" />
                            <error class="whitespace-nowrap" :fieldName="`email`" :validationErros="errors" />
                        </div>
                    </div>

                    <div class="mt-2 relative">
                        <label for="" class="block text-base lg:text-lg">Profile photo (5MB max, allowed
                            file types: png, gif, jpg, jpeg)</label>
                        <input type="file" placeholder="" name="image"
                            class="border text-base lg:text-lg text-gray-500 w-full border-l-[5px] bg-transparent focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                            @input="handleImage($event)" />

                        <img v-if="image != '' && image != null" :src="image" style="width: 60px; height: 60px" />
                        <!-- <error class="whitespace-nowrap" :fieldName="`image`" :validationErros="errors" /> -->
                    </div>

                    <!-- <div class="heading4 bg-primary text-white w-fit px-2 py-1 mb-2 mt-4">More about you</div> -->

                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center gap-4 mt-2">
                        <div class="w-full md:w-1/2 relative">
                            <label for="" class="block text-base lg:text-lg">You are registered as a</label>
                            <!-- <select
                                name=""
                                id=""
                                class="border text-base lg:text-lg text-gray-500 w-full border-l-[5px] bg-transparent focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                                v-model="user_type"
                            >
                                <option value="student">Student</option>
                                <option value="business">Business</option>
                                <option value="school">School</option>
                            </select> -->
                            <input name="user_type"
                                class="border text-base lg:text-lg text-gray-500 w-full border-l-[5px] bg-transparent focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                                type="text" disabled :value="user_type" />
                            <!-- <error
                                :fieldName="`user_type`"
                                :validationErros="errors"
                            /> -->
                        </div>

                        <div class="w-full md:w-1/2 relative">
                            <label for="" class="block text-base lg:text-lg">Date of birth </label>
                            <input type="date" placeholder="" name="dob"
                                class="border text-base lg:text-lg text-gray-500 w-full border-l-[5px] bg-transparent focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                                v-model="dob" @input="validateYear" />
                            <error
                                :fieldName="`dob`"
                                :validationErros="errors"
                            />
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center gap-4 mt-2">
                        <div class="w-full md:w-1/2 relative">
                            <label for="" class="block text-base lg:text-lg">Gender
                            </label>
                            <select name="gender" id=""
                                class="border text-base lg:text-lg text-gray-500 w-full border-l-[5px] bg-transparent focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                                v-model="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="prefer_not_to_say">
                                    Prefer not to say
                                </option>
                            </select>
                            <!-- <error
                                :fieldName="`gender`"
                                :validationErros="errors"
                            /> -->
                        </div>

                        <!-- <div class="w-full md:w-1/2 relative">
                            <label
                                for=""
                                class="block text-base lg:text-lg"
                                >Marital status</label
                            >
                            <select
                                name=""
                                id=""
                                class="border text-base lg:text-lg text-gray-500 w-full border-l-[5px] bg-transparent focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                                v-model="martial_status"
                            >
                                <option value="single">single</option>
                                <option value="married">married</option>
                            </select>
                            <error
                                :fieldName="`martial_status`"
                                :validationErros="errors"
                            />
                        </div> -->
                    </div>

                    <div class="bg-primary text-white w-fit px-2 py-1 heading4 my-4">Contact information</div>

                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center gap-4 mt-4">
                        <div class="w-full md:w-1/2 relative">
                            <label for="" class="block text-base lg:text-lg">City</label>
                            <input type="text" placeholder=""
                            name="city"
                                class="border text-base lg:text-lg text-gray-500 w-full border-l-[5px] bg-transparent focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                                v-model="city" />
                            <!-- <error
                                :fieldName="`city`"
                                :validationErros="errors"
                            /> -->
                        </div>
                        <div class="w-full md:w-1/2 relative">
                            <label for="" class="block text-base lg:text-lg">State / Province</label>
                            <input type="text" placeholder=""
                            name="province"
                                class="border text-base lg:text-lg text-gray-500 w-full border-l-[5px] bg-transparent focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                                v-model="province" />
                            <!-- <error
                                :fieldName="`province`"
                                :validationErros="errors"
                            /> -->
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center gap-4 mt-2">
                        <div class="w-full md:w-1/2 relative">
                            <label for="" class="block text-base lg:text-lg">Country</label>
                            <select name="country" id=""
                                class="border text-base lg:text-lg text-gray-500 w-full border-l-[5px] bg-transparent focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                                v-model="country">
                                <option v-for="(country, key) in countries" :key="key" value="country.code">
                                    {{ country?.name }}
                                </option>
                            </select>
                            <!-- <error
                                :fieldName="`country`"
                                :validationErros="errors"
                            /> -->
                        </div>
                        <div class="w-full md:w-1/2 relative">
                            <label for="" class="block text-base lg:text-lg">ZIP Code / Postal Code</label>
                            <input type="text" placeholder=""
                            name="postal_code" class="border text-base lg:text-lg text-gray-500 w-full border-l-[5px] bg-transparent focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                                v-model="postal_code" />
                            <!-- <error
                                :fieldName="`postal_code`"
                                :validationErros="errors"
                            /> -->
                            <!-- <br /> -->
                            <br />
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center gap-4 mt-2">
                        <div v-if="user.user_type=='student'" class="relative z-0 w-full group">
                            <label for="messagingAppDetail_id" class="block text-base lg:text-lg mb-2">
                                Select Messaging App
                            </label>

                            <Select2 v-model="messagingAppDetail_id" :options="messagingApps"
                                :settings="selectSettings" />
                        </div>
                        <div class="w-full md:w-1/2 relative">
                            <label for="" class="block text-base lg:text-lg">Phone number - with country code</label>
                            <input type="text" placeholder="" name="mobile_phone"
                                class="border text-base lg:text-lg text-gray-500 w-full border-l-[5px] bg-transparent focus:ring-primary my-2 focus:outline-none border-l-primary px-4 py-2 rounded border-gray-300"
                                v-model="mobile_phone" @keypress="restrictToNumbers($event, 15)" />
                            <!-- <error
                                :fieldName="`mobile_phone`"
                                :validationErros="errors"
                            /> -->
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <button type="submit" class="can-edu-btn-fill">
                            Update information
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script scoped>
import axios from "axios";
import ErrorHandling from "./../../ErrorHandling";
import vSelect from "vue-select";
import Select2 from "vue3-select2-component";
import Swal from "sweetalert2";
import Error from "../Error.vue";
export default {
    components: { Error, vSelect, Select2 },
    props: {
        user: {
            type: Object,
            default: () => ({}),
        },
        messaging_app: {
            type: Object,
            default: () => ({}),
        },
        indicate_required_field: {
            type: String,
            default: "",
        },

    },
    data() {
        return {
            messagingApps: [],
            messagingAppDetail_id: [],
            selectSettings: {
                width: '100%',
                multiple: true,
                placeholder: 'Select Messaging App',
                maximumSelectionLength: 3,
            },
            errors: new ErrorHandling(),
            error_message: "",
            userData: null,
            city: "",
            country: "",
            messagingApps: [],
            created_at: "",
            display_name: "",
            dob: "",
            email: "",
            first_name: "",
            gender: "",
            home_phone: "",
            id: "",
            image: "",
            last_name: "",
            martial_status: "",
            mobile_phone: "",
            postal_code: "",
            province: "",
            updated_at: "",
            user_type: "",
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
        async fetchMessagingApps() {
            try {
                const response = await axios.get("/api/web/messaging_apps");
                if (response.data && response.data.data) {
                    // Extract only id and name
                    this.messagingApps = response.data.data.map(app => ({
                        id: app.id,
                        text: app.messaging_app_detail && app.messaging_app_detail.length ? app.messaging_app_detail[0].name : "Unknown"
                    }));
                    console.log(this.messagingApps);
                    console.log(this.messagingApps); // Debugging
                } else {
                    console.error("No data found in the response.");
                }
            } catch (error) {
                console.error("Error fetching messaging apps:", error);
            }
        }

        ,
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
        validateYear() {
            let date = this.dob;
            if (date) {
                let parts = date.split('-');
                if (parts[0].length > 4) {
                    parts[0] = parts[0].slice(0, 4);
                    this.dob = parts.join('-');
                }
            }
        },
        handleImage(e) {
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios
                .post("/api/admin/media/image_again_upload", file)
                .then((res) => {
                    this.image = res?.data;
                });
        },
    focusOnFirstErrorInput(errors) {
      console.log('Errors object:', errors);
      const firstErrorField = Object.keys(errors)[0];
      console.log('First error field name:', firstErrorField);

      if (!firstErrorField) {
        console.log('No error field found');
        return;
      }

      const fieldName = firstErrorField.split('.')[0];  
      console.log('Stripped error field name:', fieldName);
      const containerDiv = document.querySelector(`[name="${fieldName}"]`);
      console.log('Found input element:', containerDiv);

      if (containerDiv) {
        containerDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        containerDiv.focus();
      } else {
        console.log(`No input field found for ${fieldName}`);
      }
    },
        updateCustomer(e) {
            e.preventDefault();
            console.log(this.messagingAppDetail_id);
            let dataToSend = {
                city: this.city,
                country: this.country,
                created_at: this.created_at,
                display_name: this.display_name,
                dob: this.dob,
                email: this.email,
                first_name: this.first_name,
                messagingAppDetail_id: this.messagingAppDetail_id,
                gender: this.gender,
                home_phone: this.home_phone,
                id: this.id,
                image: this.image,
                last_name: this.last_name,
                martial_status: this.martial_status,
                mobile_phone: this.mobile_phone,
                postal_code: this.postal_code,
                province: this.province,
                updated_at: this.updated_at,
                user_type: this.user_type,
            };
            console.log("Data to send:", dataToSend);
            axios
                .post(
                    `${process.env.MIX_WEB_API_URL}update-customer`,
                    dataToSend
                )
                .then((res) => {
                    console.log('customerres', res);
                    if (res?.data?.status == "Success") {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Your Profile is updated",
                            showConfirmButton: false,
                            timer: 1000,
                        });
                    }
                })
                .catch((error) => {
                    this.error_message = "";
                    this.errors = new ErrorHandling();
                    if (error.response.status == 422) {
                        this.focusOnFirstErrorInput(error.response.data.errors);
                        if (error.response.data.status == "Error") {
                            this.$toaster.error(error.response.data.message);
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
    },
    watch: {
        messaging_app(newVal) {
            console.log('Updated messaging_app prop:', newVal);
            if (Object.keys(newVal).length > 0) {
                this.messagingAppDetail_id = Object.values(newVal);
            }
        },
    },
    mounted() {
        console.log("this.messaging_app", this.user);


        this.fetchMessagingApps();
        console.log('this.user', this.user.first_name);
        // this.userData = JSON.parse(this.user);
        console.log('this.userData', this.userData);
        const {
            city,
            country,
            created_at,
            display_name,
            dob,
            email,
            first_name,
            gender,
            home_phone,
            id,
            image,
            last_name,
            selectedMessagingAppDetailId,
            martial_status,
            mobile_phone,
            postal_code,
            province,
            updated_at,
            user_type,
        } = this.user;
        this.city = city;
        this.country = country;
        this.display_name = display_name;
        this.dob = dob;
        this.email = email;
        this.first_name = first_name;
        this.gender = gender;
        this.home_phone = home_phone;
        this.id = id;
        this.messagingAppDetail_id = Object.values(this.messaging_app);
        this.image = image;
        this.last_name = last_name;
        this.martial_status = martial_status;
        this.mobile_phone = mobile_phone;
        this.postal_code = postal_code;
        this.province = province;
        this.updated_at = updated_at;
        this.user_type = user_type;
        console.log('this.messagingAppDetail_id', this.messagingAppDetail_id);
    },
};
</script>
