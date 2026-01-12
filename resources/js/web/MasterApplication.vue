<template>
  <div class="bg-white mx-auto" :class="container == 1 ? '' : 'container'">
    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
      <div class="border-b-4 pb-2 border-primary w-full">
        <h1 class="can-edu-h1">
          {{
            master_app_setting?.master_application_setting_detail?.length > 0
              ? master_app_setting?.master_application_setting_detail[0]
                ?.page_title
              : ""
          }}

          {{
            hide_master_application_school_name == "1" &&
              school_name_as_per_school_id_from_url != ""
              ? "For " + school_name_as_per_school_id_from_url
              : ""
          }}
        </h1>
      </div>
    </div>
    <div class="mt-6 text-black text-justify">
      <p>
        {{
          master_app_setting?.master_application_setting_detail?.length > 0
            ? master_app_setting?.master_application_setting_detail[0]
              ?.description
            : ""
        }}
      </p>
    </div>

    <div class="mt-10 bg-white px-4 py-6 border shadow rounded-md w-full">
      <div class="flex justify-end">
        <p class="font-semibold text-red-500">
          {{ indicate_required_field }}
        </p>
      </div>
      <div class="mt-4">
        <label class="block text-base lg:text-lg">
          Please check the reason(s) you are filling the Master Application:
        </label>
        <div>
          <label>
            <input type="radio" v-model="for_demetra_or_master_app" value="apply_myself" />
            I want to apply to schools
          </label>
        </div>
        <div class="flex items-center">
          <label>
            <input type="radio" v-model="for_demetra_or_master_app" value="reverse_admissions" />
            I want to participate in the Reverse Admissions process
          </label>
          <svg class="inline w-5 h-5 ml-2 text-gray-500 cursor-pointer hover:text-gray-700" fill="none"
            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" @click="toggleModal">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
            </path>
          </svg>
        </div>
        <div>
          <label>
            <input type="radio" v-model="for_demetra_or_master_app" value="both" />
            Both
          </label>
        </div>
      </div>
      <!-- <div class="mt-4 relative" v-if="!school_id || school_id == '' || school_id == null">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .school_lable
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <Select2 name="school_drop_id" v-model="school_drop_id" :options="local_schools"
          :settings="{ width: '100%', multiple: true }" />
        <error fieldName="school_id" :validationErros="errors" />
      </div> -->
      <error fieldName="for_demetra_or_master_app" :validationErros="errors" />

      <div class="mt-4 relative" v-if="!school_id || school_id == '' || school_id == null">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .school_lable
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <!-- <Select2
        name="school_drop_id"
        v-model="school_drop_id"
        :options="local_schools"
        :settings="{ width: '100%', multiple: true }"
        :disabled="isSchoolFieldDisabled"
        :class="{ 'opacity-50': isSchoolFieldDisabled }"
      /> -->
        <v-select label="text" :options="local_schools" name="school_drop_id" v-model="school_drop_id"
          :items="local_schools" multiple :trackBy="id" :disabled="isSchoolFieldDisabled"
          :class="{ 'opacity-50': isSchoolFieldDisabled }" menu-props="auto" style="width: 100%;"
          :reduce="option => option.id"></v-select>

        <error fieldName="school_id" :validationErros="errors" />
      </div>
      <div class="relative mt-4">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  ?.first_name_label
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <input type="text" v-model="first_name" name="first_name"
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " :placeholder="master_app_setting?.master_application_setting_detail?.length > 0
              ? master_app_setting?.master_application_setting_detail[0]
                ?.first_name_placeholder
              : ''
              " />
        <error fieldName="first_name" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  ?.last_name_label
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <input type="text" v-model="last_name" name="last_name"
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " :placeholder="master_app_setting?.master_application_setting_detail?.length > 0
              ? master_app_setting?.master_application_setting_detail[0]
                ?.last_name_placeholder
              : ''
              " />
        <error fieldName="last_name" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  ?.dob_label
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <input type="date" :placeholder="master_app_setting?.master_application_setting_detail?.length > 0
          ? master_app_setting?.master_application_setting_detail[0]
            ?.dob_placeholder
          : ''
          " v-model="dob" @input="validateYear" name="dob"
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " />
        <error fieldName="dob" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  ?.gender_label
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <select name="gender" id=""
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " v-model="gender">
          <!-- <option value="">
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                    ?.gender_placeholder
                : ""
            }}
          </option> -->
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="prefer_not_to_say">Prefer not to say</option>
        </select>

        <error fieldName="gender" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  ?.email_label
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <input type="email" name="email" @change="validateEmail($event)" v-model="email"
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " :placeholder="master_app_setting?.master_application_setting_detail?.length > 0
              ? master_app_setting?.master_application_setting_detail[0]
                ?.email_placeholder
              : ''
              " />
        <error fieldName="email" :validationErros="errors" />
        <small class="text-red-600 text-sm mt-2" v-if="emailValidationErro != ''" v-text="emailValidationErro"></small>
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .confirm_email_label
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <input type="email" name="confirm_email" @change="validateEmail2($event)" v-model="confirm_email"
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " :placeholder="master_app_setting?.master_application_setting_detail?.length > 0
              ? master_app_setting?.master_application_setting_detail[0]
                ?.confirm_email_placeholder
              : ''
              " />
        <error fieldName="confirm_email" :validationErros="errors" />
        <small class="text-red-600 text-sm mt-2" v-if="confirmEmailValidationErro != ''"
          v-text="confirmEmailValidationErro"></small>
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .phone_label
                : ""
            }}
          </span>
          <!-- <span class="text-primary">*</span> -->
        </label>
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 space-x-0 sm:space-x-2 justify-between w-full">
          <div class="w-full">
            <input type="text" name="phone" :placeholder="master_app_setting?.master_application_setting_detail?.length >
              0
              ? master_app_setting?.master_application_setting_detail[0]
                .phone_placeholder
              : ''
              " v-model="phone"
              class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
              :class="position == 'rtl'
                ? 'border-r-[5px] rounded-r border-r-primary'
                : 'border-l-[5px] rounded-l border-l-primary'
                " @keypress="restrictToNumbers($event, 15)" />
          </div>
        </div>

        <error fieldName="phone" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .can_school_text_label
                : ""
            }}
          </span>
          <!-- <span class="text-primary">*</span> -->
        </label>
        <select name="can_school_text_you" id=""
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " v-model="can_school_text_you">
          <option value="">
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .can_school_text_placeholder
                : ""
            }}
          </option>
          <option value="yes">Yes</option>
          <option value="no">No</option>
        </select>

        <error fieldName="can_school_text_you" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .message_app_label
                : ""
            }}(s)
          </span>
          <!-- <span class="text-primary">*</span> -->
        </label>
        <!-- <Select2 name="messaging_app" v-model="messaging_app" :options="local_messaging_apps" :settings="{ width: '100%', multiple: true }"
          :disabled="isMessagingAppDisabled" /> -->
        <v-select label="text" name="messaging_app" v-model="messaging_app" :options="sortedMessagingApps"
          :reduce="option => option.id" multiple :disabled="isMessagingAppDisabled"></v-select>
        <error fieldName="messaging_app" :validationErros="errors" />
      </div>

      <!-- <div class="mt-4 relative" v-for="(app, key) in messaging_app" :key="key"> -->

      <div class="mt-4 relative" v-for="(appId, key) in messaging_app" :key="appId">
        <label for="" class="block text-base lg:text-lg">
          <span>{{ getMessagingAppName(appId) }} - {{
            master_app_setting?.master_application_setting_detail?.[0]?.message_app_username_label }}</span>
        </label>
        <input type="text"
          :placeholder="master_app_setting?.master_application_setting_detail?.length > 0 ? master_app_setting?.master_application_setting_detail[0].message_app_username_placeholder : ''"
          v-model="messaging_app_username[key]" @keyup="handleMessagingAppUserName($event, key)"
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
          :class="{ 'border-r-[5px] rounded-r border-r-primary': position === 'rtl', 'border-l-[5px] rounded-l border-l-primary': position !== 'rtl' }" />
        <error fieldName="messaging_app_username" :validationErros="errors" />
      </div>





      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .where_want_to_study_lable
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>

        <v-select label="text" name="where_want_to_study" track-by="id" v-model="where_want_to_study"
          :options="local_provinces" :reduce="province => province.id" multiple></v-select>
        <error fieldName="where_want_to_study" :validationErros="errors" />
      </div>



      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .country_citzenship_label
                : ""
            }}
          </span>
        </label>

        <v-select label="text" name="country_of_citizenship" track-by="id" v-model="country_of_citizenship"
          :options="local_countries" :reduce="country => country.id" multiple></v-select>


        <error fieldName="country_of_citizenship" :validationErros="errors" />
      </div>


      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .live_in_country_citzenship_label
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <select name="live_in_your_country_citizenship" id=""
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
          :class="position == 'rtl' ? 'border-r-[5px] rounded-r border-r-primary' : 'border-l-[5px] rounded-l border-l-primary'"
          v-model="live_in_your_country_citizenship">
          <option value="yes">Yes</option>
          <option value="no">No</option>
        </select>

        <error fieldName="live_in_your_country_citizenship" :validationErros="errors" />
      </div>

      <!-- Point 15: Current Residence -->
      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .current_residence_label
                : ""
            }}
          </span>
          <span class="text-primary" v-if="live_in_your_country_citizenship === 'no'">*</span>
        </label>
        <select name="current_residance" id=""
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="{
            'border-r-[5px] rounded-r border-r-primary': position == 'rtl',
            'border-l-[5px] rounded-l border-l-primary': position != 'rtl',
            'bg-gray-200 text-gray-500 cursor-not-allowed': live_in_your_country_citizenship === 'yes'
          }" v-model="current_residance" :disabled="live_in_your_country_citizenship === 'yes'">
          <option v-for="(country, key) in countries" :key="key" :value="country.code">
            {{ country?.name }}
          </option>
        </select>
        <error fieldName="current_residance" :validationErros="errors" />
      </div>

      <!-- Point 16: Country Residence Status -->
      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .country_residence_status_label
                : ""
            }}
          </span>
          <span class="text-primary" v-if="live_in_your_country_citizenship === 'no'">*</span>
        </label>
        <select name="current_residance_status" id=""
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="{
            'border-r-[5px] rounded-r border-r-primary': position == 'rtl',
            'border-l-[5px] rounded-l border-l-primary': position != 'rtl',
            'bg-gray-200 text-gray-500 cursor-not-allowed': live_in_your_country_citizenship === 'yes'
          }" v-model="current_residance_status" :disabled="live_in_your_country_citizenship === 'yes'">
          <option disabled value="">Select Residency Status</option>
          <option v-for="(status, index) in country_status" :key="index" :value="status.country_detail[0]?.name">
            {{ status.country_detail[0]?.name || 'Unnamed Status' }}
          </option>
        </select>

        <error fieldName="current_residance_status" :validationErros="errors" />
      </div>


      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .mailing_address_label
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <textarea name="mailing_address" id="" cols="30" rows="5" v-model="mailing_address" :placeholder="master_app_setting?.master_application_setting_detail?.length > 0
          ? master_app_setting?.master_application_setting_detail[0]
            ?.mailing_address_placeholder
          : ''
          " class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            "></textarea>
        <error fieldName="mailing_address" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .high_school_name_label
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <input type="text" name="high_school_name" v-model="high_school_name"
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " />
        <error fieldName="high_school_name" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .high_school_cgpa_lable
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <input type="text" name="high_school_cgpa" v-model="high_school_cgpa"
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " :placeholder="master_app_setting?.master_application_setting_detail?.length > 0
              ? master_app_setting?.master_application_setting_detail[0]
                ?.high_school_cgpa_placeholder
              : ''
              " />
        <error fieldName="high_school_cgpa" :validationErros="errors" />
      </div>
      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .high_school_country_lable
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <select name="high_school_country" id=""
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " v-model="high_school_country">

          <option v-for="(country, key) in countries" :key="key" :value="country.code">
            {{ country?.name }}
          </option>
        </select>

        <error fieldName="high_school_country" :validationErros="errors" />
      </div>
      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .high_school_city_lable
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <input type="text" name="high_school_city" v-model="high_school_city"
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " />
        <error fieldName="high_school_city" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .when_plan_to_start_label
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <select name="when_plan_to_start" id=""
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " v-model="when_plan_to_start">
          <option value="" selected="selected" disabled="disabled" hidden="hidden">
            Select
          </option>

          <option value="winter_of_this_year">Winter of this year</option>
          <option value="summer_of_this_year">Summer of this year</option>
          <option value="fall_of_this_year">Fall of this year</option>
          <option value="winter_of_next_year">Winter of next year</option>
          <option value="summer_of_next_year">Summer of next year</option>
          <option value="fall_of_next_year">Fall of next year</option>
          <option value="i_am_not_sure">I am not sure</option>
        </select>

        <error fieldName="when_plan_to_start" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .intrested_in_label
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <select name="interested_in" id=""
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " v-model="interested_in">

          <option value="" disabled selected> {{ master_app_setting?.master_application_setting_detail?.length > 0
            ? master_app_setting?.master_application_setting_detail[0]
              .intrested_in_placeholder
            : "" }} </option>
          <option v-for="(degree, i) in degrees" :value="degree?.id" :key="i">
            {{
              degree?.degree_detail?.length > 0
                ? degree?.degree_detail[0]?.name
                : ""
            }}
          </option>
        </select>

        <error fieldName="interested_in" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .would_like_to_study_label
                : ""
            }}
          </span>
        </label>

        <v-select :placeholder="master_app_setting?.master_application_setting_detail?.length > 0
          ? master_app_setting?.master_application_setting_detail[0]
            ?.would_like_to_study_placeholder
          : ''
          " label="text" name="would_like_to_study" track-by="id" v-model="would_like_to_study"
          :options="local_programs" :reduce="program => program.id" multiple></v-select>
        <error fieldName="would_like_to_study" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .student_type_lable
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <select name="student_type" id=""
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " v-model="student_type">
          <option value="" selected="selected" disabled="disabled" hidden="hidden">
            Select
          </option>
          <option value="exchange_student">Exchange student</option>
          <option value="new_freshman">New/ Freshman</option>
          <option value="returning_student">Returning student</option>
          <option value="student_with_disabilities">
            Student with disabilities
          </option>
          <option value="transfer_student">Transfer student</option>
        </select>

        <error fieldName="student_type" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .tuition_funding_source_label
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>

        <v-select :placeholder="master_app_setting?.master_application_setting_detail?.length > 0
          ? master_app_setting?.master_application_setting_detail[0]
            ?.tuition_funding_source_placeholder
          : ''
          " label="text" name="tuition_funding_source" track-by="id" v-model="tuition_funding_source"
          :options="local_tuition_funding_source" :reduce="Fund => Fund.id" multiple></v-select>
        <error fieldName="tuition_funding_source" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <div class="flex ">
          <label for="" class="cursor-pointer block text-base lg:text-lg mr-8">
            <span>
              {{
                master_app_setting?.master_application_setting_detail?.length >
                  0
                  ? master_app_setting?.master_application_setting_detail[0]
                    .test_taken_label
                  : ""
              }}
            </span>
            <span class="text-primary">*</span>
          </label>

          <label class="relative inline-flex items-center cursor-pointer">
            <input @click="toggleTestTakenDropDown()" name="test_taken" type="checkbox" class="sr-only peer"
              :checked="test_taken_dropdown" />
            <div
              class="w-11 h-[25px] bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[1px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary">
            </div>
          </label>
        </div>

        <div class="mt-5 flex flex-col items-center relative" v-if="test_taken_dropdown">
          <div class="shadow bg-white top-100 z-10 w-full lef-0 rounded max-h-select overflow-y-auto svelte-5uyqqj">
            <div class="flex flex-col w-full">
              <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-sky-50">
                <div
                  class="flex flex-col sm:flex-row sm:gap-4 w-full divide-y sm:divide-y-0 bg-gray-100 sm:bg-transparent items-center sm:p-2 sm:pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                  <div class="w-full sm:w-3/5 flex items-center justify-center">
                    <h2 class="text-xl font-semibold text-center text-gray-600">
                      Test name
                    </h2>
                  </div>
                  <div class="w-full sm:w-2/5 items-center justify-center flex">
                    <h2 class="text-xl font-semibold text-center text-gray-600">
                      Score
                    </h2>
                  </div>
                </div>
              </div>
              <div class="cursor-pointer w-full border-gray-100 border-b hover:bg-sky-50" v-for="(opt, i) in sortedTest"
                :key="i">
                <div
                  class="flex flex-col sm:flex-row gap-4 w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                  <div class="w-full sm:w-3/5 flex items-center border rounded p-1.5 h-[37px] check_box_height">
                    <input :id="opt?.id" type="checkbox" @change="handleTestTaken($event, opt)"
                      :checked="isChecked(opt)" class="border-red accent-primary text-primary outline-red-500" />
                    <label :for="opt?.id" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                      {{
                        opt?.test_detail?.length > 0
                          ? opt?.test_detail[0]?.name
                          : ""
                      }}</label>
                  </div>
                  <div class="w-full sm:w-2/5 items-center flex">
                    <input type="number"
                      class="w-full border-l-4 border-l-[#b1040e] p-1.5 border rounded border-gray-300 focus:ring-primary focus:outline-none"
                      :value="scoreValue(opt)" :disabled="isValueDisabled(opt)"
                      @change="setTestTakenScore($event, opt)" />
                  </div>
                </div>
              </div>
              <div
                class="flex flex-col sm:flex-row border-b border-b-gray-100 sm:border-b-transparent gap-4 w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                <div class="w-full sm:w-2/5 flex items-center border rounded p-1.5 h-[37px]">
                  <input id="other_1" type="checkbox" v-model="other_1_checkbox"
                    class="border-red accent-primary text-primary outline-red-500 ring-red-500" />
                  <label for="other_1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Other 1</label>
                </div>
                <div class="w-full sm:w-2/5 items-center flex">
                  <input type="text"
                    class="w-full border-l-4 border-l-[#b1040e] p-1.5 border rounded border-gray-300 focus:ring-primary focus:outline-none"
                    v-model="other_name_1" :disabled="!other_1_checkbox" />
                </div>
                <div class="w-full sm:w-2/5 items-center flex">
                  <input type="text"
                    class="w-full border-l-4 border-l-[#b1040e] p-1.5 border rounded border-gray-300 focus:ring-primary focus:outline-none"
                    v-model="other_score_1" :disabled="!other_1_checkbox" />
                </div>
              </div>
              <div
                class="flex flex-col sm:flex-row border-b border-b-gray-100 sm:border-b-transparent gap-4 w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                <div class="w-full sm:w-2/5 flex items-center border rounded p-1.5 h-[37px]">
                  <input id="other_2" type="checkbox" v-model="other_2_checkbox"
                    class="border-red accent-primary text-primary outline-red-500" />
                  <label for="other_2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Other 2</label>
                </div>
                <div class="w-full sm:w-2/5 items-center flex">
                  <input type="text"
                    class="w-full border-l-4 border-l-[#b1040e] p-1.5 border rounded border-gray-300 focus:ring-primary focus:outline-none"
                    v-model="other_name_2" :disabled="!other_2_checkbox" />
                </div>
                <div class="w-full sm:w-2/5 items-center flex">
                  <input type="text"
                    class="w-full border-l-4 border-l-[#b1040e] p-1.5 border rounded border-gray-300 focus:ring-primary focus:outline-none"
                    v-model="other_score_2" :disabled="!other_2_checkbox" />
                </div>
              </div>
              <div
                class="flex flex-col sm:flex-row border-b border-b-gray-100 sm:border-b-transparent gap-4 w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                <div class="w-full sm:w-2/5 flex items-center border rounded p-1.5 h-[37px]">
                  <input id="other_3" type="checkbox" v-model="other_3_checkbox"
                    class="border-red accent-primary text-primary outline-red-500" />
                  <label for="other_3" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Other 3</label>
                </div>
                <div class="w-full sm:w-2/5 items-center flex">
                  <input type="text"
                    class="w-full border-l-4 border-l-[#b1040e] p-1.5 border rounded border-gray-300 focus:ring-primary focus:outline-none"
                    v-model="other_name_3" :disabled="!other_3_checkbox" />
                </div>
                <div class="w-full sm:w-2/5 items-center flex">
                  <input type="text"
                    class="w-full border-l-4 border-l-[#b1040e] p-1.5 border rounded border-gray-300 focus:ring-primary focus:outline-none"
                    v-model="other_score_3" :disabled="!other_3_checkbox" />
                </div>
              </div>
              <div
                class="flex flex-col sm:flex-row border-b border-b-gray-100 sm:border-b-transparent gap-4 w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                <div class="w-full sm:w-2/5 flex items-center border rounded p-1.5 h-[37px]">
                  <input id="other_4" type="checkbox" v-model="other_4_checkbox"
                    class="border-red accent-primary text-primary outline-red-500" />
                  <label for="other_4" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Other 4</label>
                </div>
                <div class="w-full sm:w-2/5 items-center flex">
                  <input type="text"
                    class="w-full border-l-4 border-l-[#b1040e] p-1.5 border rounded border-gray-300 focus:ring-primary focus:outline-none"
                    v-model="other_name_4" :disabled="!other_4_checkbox" />
                </div>
                <div class="w-full sm:w-2/5 items-center flex">
                  <input type="text"
                    class="w-full border-l-4 border-l-[#b1040e] p-1.5 border rounded border-gray-300 focus:ring-primary focus:outline-none"
                    v-model="other_score_4" :disabled="!other_4_checkbox" />
                </div>
              </div>
              <div
                class="flex flex-col sm:flex-row border-b border-b-gray-100 sm:border-b-transparent gap-4 w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                <div class="w-full sm:w-2/5 flex items-center border rounded p-1.5 h-[37px]">
                  <input id="other_5" type="checkbox" v-model="other_5_checkbox"
                    class="border-red accent-primary text-primary outline-red-500" />
                  <label for="other_5" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Other 5</label>
                </div>
                <div class="w-full sm:w-2/5 items-center flex">
                  <input type="text"
                    class="w-full border-l-4 border-l-[#b1040e] p-1.5 border rounded border-gray-300 focus:ring-primary focus:outline-none"
                    v-model="other_name_5" :disabled="!other_5_checkbox" />
                </div>
                <div class="w-full sm:w-2/5 items-center flex">
                  <input type="text"
                    class="w-full border-l-4 border-l-[#b1040e] p-1.5 border rounded border-gray-300 focus:ring-primary focus:outline-none"
                    v-model="other_score_5" :disabled="!other_5_checkbox" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <error fieldName="test_taken" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .additional_label
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <textarea name="addtional" id="" cols="30" rows="5" v-model="addtional"
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " :placeholder="master_app_setting?.master_application_setting_detail?.length > 0
              ? master_app_setting?.master_application_setting_detail[0]
                ?.additional_placeholder
              : ''
              "></textarea>
        <error fieldName="addtional" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .add_something_lable
                : ""
            }}
          </span>
          <span class="text-primary">*</span>
        </label>
        <textarea name="add_anything" id="" cols="30" rows="5" v-model="add_anything"
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " :placeholder="master_app_setting?.master_application_setting_detail?.length > 0
              ? master_app_setting?.master_application_setting_detail[0]
                ?.add_something_placeholder
              : ''
              "></textarea>
        <error fieldName="add_anything" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .study_permet_lable
                : ""
            }}
          </span>
        </label>
        <select v-model="study_permit_candian" name="study_permit_candian_embassy" id=""
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            ">
          <option value="yes">Yes</option>
          <option selected value="no">No</option>
        </select>

        <error fieldName="study_permit_candian_embassy" :validationErros="errors" />
      </div>
      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .currently_study_label
                : ""
            }}
          </span>
        </label>
        <select name="currently_student_anywhere" id="currently_student_anywhere"
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " v-model="currently_student_anywhere">
          <option value="" disabled>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .currently_study_placeholder
                : ""
            }}
          </option>
          <option value="yes">Yes</option>
          <option value="no">No</option>
        </select>
        <error fieldName="currently_student_anywhere" :validationErros="errors" />
      </div>

      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .currently_live_in_lable
                : ""
            }}
          </span>
        </label>
        <select name="currently_living_in_canada" id=""
          class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            " v-model="currently_living_in_canada">
          <option value="" disabled>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .currently_live_in_placeholder
                : ""
            }}
          </option>
          <option value="yes">Yes</option>
          <option value="no">No</option>
        </select>
        <error fieldName="currently_living_in_canada" :validationErros="errors" />
      </div>
      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .statement_of_purpose_label
                : ""
            }}
          </span>
          <!-- <span class="text-primary">*</span> -->
        </label>

        <textarea name="statement_of_purpose" id="" cols="30" rows="5" v-model="statement_of_purpose" :placeholder="master_app_setting?.master_application_setting_detail?.length > 0
          ? master_app_setting?.master_application_setting_detail[0]
            ?.statement_of_purpose_placeholder
          : ''
          " class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            "></textarea>
        <error fieldName="statement_of_purpose" :validationErros="errors" />
      </div>
      <div class="mt-4 relative">
        <label for="" class="block text-base lg:text-lg">
          <span>
            {{
              master_app_setting?.master_application_setting_detail?.length > 0
                ? master_app_setting?.master_application_setting_detail[0]
                  .letter_of_intent_label
                : ""
            }}
          </span>
          <!-- <span class="text-primary">*</span> -->
        </label>

        <textarea name="letter_of_intent" id="" cols="30" rows="5" v-model="letter_of_intent" :placeholder="master_app_setting?.master_application_setting_detail?.length > 0
          ? master_app_setting?.master_application_setting_detail[0]
            ?.letter_of_intent_placeholder
          : ''
          " class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300" :class="position == 'rtl'
            ? 'border-r-[5px] rounded-r border-r-primary'
            : 'border-l-[5px] rounded-l border-l-primary'
            "></textarea>
        <error fieldName="letter_of_intent" :validationErros="errors" />
      </div>

      <div class="flex items-center mt-4 mb-4">
        <input id="default-checkbox" type="checkbox" value="" v-model="send_me_a_copy" />
        <label for="default-checkbox" class="ml-2 text-black">{{
          master_app_setting?.master_application_setting_detail?.length > 0
            ? master_app_setting?.master_application_setting_detail[0]
              .send_copy_lable
            : ""
        }}
        </label>
      </div>

      <div class="mt-4 text-black text-base text-justify">
        <p v-html="master_app_setting?.master_application_setting_detail?.length > 0
          ? master_app_setting?.master_application_setting_detail[0]
            .privacy_policy
          : ''
          "></p>
      </div>
      <ListErrors :validationErrors="errors" />
      <div class="recaptcha">
        <Error v-if="submitted" fieldName="captcha" :validationErros="errors" full_width="1" />
      </div>
      <div class="mt-6 text-center">
        <button class="can-edu-btn-fill" @click="recaptcha()">
          {{
            master_app_setting?.master_application_setting_detail?.length > 0
              ? master_app_setting?.master_application_setting_detail[0]
                .button_text
              : ""
          }}
        </button>
      </div>
    </div>
  </div>
  <transition name="slide">
    <div id="defaultModal" tabindex="-1"
      class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 md:h-full"
      v-if="showPopUpModal">
      <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
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
          <div class="bg-white py-6 px-10 rounded-2xl shadow-lg text-center 123">
            <div class="mt-6">
              <p class="text-center can-edu-p mt-2">{{ popupMsg ? popupMsg : success_message }}</p>
            </div>
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
  <transition name="slide">
    <div id="defaultModal" tabindex="-1" aria-hidden="true"
      class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
      v-if="showModal" @click.self="toggleModal">
      <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
        ref="elementToDetectClick">
        <div>
          <!-- Close Button -->
          <div class="absolute top-3 right-3 cursor-pointer" @click="toggleModal">
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

          <!-- Modal Body -->
          <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10">
            <p class="text-center can-edu-p mt-2">
              If you are not familiar with the Reverse Admissions,
              <a :href="`/${lang}/demetra`" class="text-primary hover:text-red-800 underline" target="_blank">
                click here
              </a>
            </p>
            <div class="flex justify-center">
              <button type="button" class="can-edu-btn-fill  whitespace-nowrap px-2.5 md:px-5 mt-4"
                @click="toggleModal">
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
import Select2 from "vue3-select2-component";
import vueRecaptcha from "vue3-recaptcha2";
import ErrorHandling from "../ErrorHandling";
import { mapState } from "vuex";
import Error from "./Error.vue";
import { load } from "recaptcha-v3";
import ListErrors from './components/ListErrors.vue';
export default {
  props: [
    "lang",
    "logged_in_customer",
    "success_message",
    "container",
    "master_application_setting",
    "school_id",
    "position",
    "indicate_required_field",
    "hide_master_application_school_name",
    "user_type",
    "login_text",
    "login_url",
    "master_application_modal_translation",
    "register_url",
    "show_form_warning",
    "country_status"
  ],
  components: {
    vueRecaptcha,
    Error,
    Select2,
    ListErrors
  },
  computed: {
    ...mapState({
      schools: (state) => state.schools.schools,
      programs: (state) => state.programs.programs,
      degrees: (state) => state.degrees.degrees,
      tests: (state) => state.tests.tests,
    }),
    sortedTest() {
      if (!Array.isArray(this.tests)) {
        return [];
      }
      return this.tests.slice().sort((a, b) => {
        const nameA = a?.test_detail?.[0]?.name?.toLowerCase() || '';
        const nameB = b?.test_detail?.[0]?.name?.toLowerCase() || '';
        return nameA.localeCompare(nameB);
      });
    },
    sortedMessagingApps() {
      // Sort the array alphabetically by the 'text' property
      return this.local_messaging_apps.slice().sort((a, b) => {
        return a.text.localeCompare(b.text);
      });
    },

    isSchoolFieldDisabled() {
      return this.for_demetra_or_master_app === "reverse_admissions";
    },
    sitekey() {
      return process.env.MIX_RECAPTCHA_SITE_KEY;
    },
    isMessagingAppDisabled() {
      return this.can_school_text_you === "no";
    }
  },
  data() {
    return {
      showModal: false,
      submitted: false,
      popupMsg: '',
      showPopUpModal: false,
      test_taken_dropdown: true,
      errors: new ErrorHandling(),
      school_drop_id: [],
      first_name: "",
      last_name: "",
      email: "",
      confirm_email: "",
      dob: "",
      gender: "",
      phone: "",
      can_school_text_you: "yes",
      messaging_app: [],
      messaging_app_username: [],
      where_want_to_study: [],
      currently_living_in_canada: "no",
      currently_student_anywhere: "",
      static_translations: [],
      country_of_citizenship: [],
      live_in_your_country_citizenship: "yes",
      current_residance: "",
      current_residance_status: "",
      mailing_address: "",
      high_school_name: "",
      letter_of_intent: "",
      statement_of_purpose: "",
      high_school_cgpa: "",
      high_school_city: "",
      high_school_country: "",
      when_plan_to_start: "fall_of_this_year",
      interested_in: "",
      would_like_to_study: [],
      student_type: "new_freshman",
      tuition_funding_source: [],
      test_taken: [],
      addtional: "",
      add_anything: "",
      study_permit_candian: "no",
      send_me_a_copy: false,
      for_demetra_or_master_app: "apply_myself",
      master_app_setting: null,
      countries: [
        { name: "Afghanistan", code: "AF", phoneCode: "+93" },
        { name: "Aland Islands", code: "AX", phoneCode: "+358" },
        { name: "Albania", code: "AL", phoneCode: "+355" },
        { name: "Algeria", code: "DZ", phoneCode: "+213" },
        { name: "American Samoa", code: "AS", phoneCode: "+1" },
        { name: "Andorra", code: "AD", phoneCode: "+376" },
        { name: "Angola", code: "AO", phoneCode: "+244" },
        { name: "Anguilla", code: "AI", phoneCode: "+1" },
        { name: "Antarctica", code: "AQ", phoneCode: "+672" },
        { name: "Antigua and Barbuda", code: "AG", phoneCode: "+1" },
        { name: "Argentina", code: "AR", phoneCode: "+54" },
        { name: "Armenia", code: "AM", phoneCode: "+374" },
        { name: "Aruba", code: "AW", phoneCode: "+297" },
        { name: "Australia", code: "AU", phoneCode: "+61" },
        { name: "Austria", code: "AT", phoneCode: "+43" },
        { name: "Azerbaijan", code: "AZ", phoneCode: "+994" },
        { name: "Bahamas", code: "BS", phoneCode: "+1" },
        { name: "Bahrain", code: "BH", phoneCode: "+973" },
        { name: "Bangladesh", code: "BD", phoneCode: "+880" },
        { name: "Barbados", code: "BB", phoneCode: "+1" },
        { name: "Belarus", code: "BY", phoneCode: "+375" },
        { name: "Belgium", code: "BE", phoneCode: "+32" },
        { name: "Belize", code: "BZ", phoneCode: "+501" },
        { name: "Benin", code: "BJ", phoneCode: "+229" },
        { name: "Bermuda", code: "BM", phoneCode: "+1" },
        { name: "Bhutan", code: "BT", phoneCode: "+975" },
        { name: "Bolivia", code: "BO", phoneCode: "+591" },
        {
          name: "Bonaire, Sint Eustatius and Saba",
          code: "BQ",
          phoneCode: "+599",
        },
        {
          name: "Bosnia and Herzegovina",
          code: "BA",
          phoneCode: "+387",
        },
        { name: "Botswana", code: "BW", phoneCode: "+267" },
        { name: "Bouvet Island", code: "BV", phoneCode: "+47" },
        { name: "Brazil", code: "BR", phoneCode: "+55" },
        {
          name: "British Indian Ocean Territory",
          code: "IO",
          phoneCode: "+246",
        },
        { name: "Brunei Darussalam", code: "BN", phoneCode: "+673" },
        { name: "Bulgaria", code: "BG", phoneCode: "+359" },
        { name: "Burkina Faso", code: "BF", phoneCode: "+226" },
        { name: "Burundi", code: "BI", phoneCode: "+257" },
        { name: "Cambodia", code: "KH", phoneCode: "+855" },
        { name: "Cameroon", code: "CM", phoneCode: "+237" },
        { name: "Canada", code: "CA", phoneCode: "+1" },
        { name: "Cape Verde", code: "CV", phoneCode: "+238" },
        { name: "Cayman Islands", code: "KY", phoneCode: "+1" },
        {
          name: "Central African Republic",
          code: "CF",
          phoneCode: "+236",
        },
        { name: "Chad", code: "TD", phoneCode: "+235" },
        { name: "Chile", code: "CL", phoneCode: "+56" },
        { name: "China", code: "CN", phoneCode: "+86" },
        { name: "Christmas Island", code: "CX", phoneCode: "+61" },
        {
          name: "Cocos (Keeling) Islands",
          code: "CC",
          phoneCode: "+61",
        },
        { name: "Colombia", code: "CO", phoneCode: "+57" },
        { name: "Comoros", code: "KM", phoneCode: "+269" },
        { name: "Congo", code: "CG", phoneCode: "+242" },
        {
          name: "Congo, Democratic Republic of the Congo",
          code: "CD",
          phoneCode: "+243",
        },
        { name: "Cook Islands", code: "CK", phoneCode: "+682" },
        { name: "Costa Rica", code: "CR", phoneCode: "+506" },
        { name: "Cote D'Ivoire", code: "CI", phoneCode: "+225" },
        { name: "Croatia", code: "HR", phoneCode: "+385" },
        { name: "Cuba", code: "CU", phoneCode: "+53" },
        { name: "Curacao", code: "CW", phoneCode: "+599" },
        { name: "Cyprus", code: "CY", phoneCode: "+357" },
        { name: "Czech Republic", code: "CZ", phoneCode: "+420" },
        { name: "Denmark", code: "DK", phoneCode: "+45" },
        { name: "Djibouti", code: "DJ", phoneCode: "+253" },
        { name: "Dominica", code: "DM", phoneCode: "+1" },
        { name: "Dominican Republic", code: "DO", phoneCode: "+1" },
        { name: "Ecuador", code: "EC", phoneCode: "+593" },
        { name: "Egypt", code: "EG", phoneCode: "+20" },
        { name: "El Salvador", code: "SV", phoneCode: "+503" },
        { name: "Equatorial Guinea", code: "GQ", phoneCode: "+240" },
        { name: "Eritrea", code: "ER", phoneCode: "+291" },
        { name: "Estonia", code: "EE", phoneCode: "+372" },
        { name: "Ethiopia", code: "ET", phoneCode: "+251" },
        {
          name: "Falkland Islands (Malvinas)",
          code: "FK",
          phoneCode: "+500",
        },
        { name: "Faroe Islands", code: "FO", phoneCode: "+298" },
        { name: "Fiji", code: "FJ", phoneCode: "+679" },
        { name: "Finland", code: "FI", phoneCode: "+358" },
        { name: "France", code: "FR", phoneCode: "+33" },
        { name: "French Guiana", code: "GF", phoneCode: "+594" },
        { name: "French Polynesia", code: "PF", phoneCode: "+689" },
        {
          name: "French Southern Territories",
          code: "TF",
          phoneCode: "+262",
        },
        { name: "Gabon", code: "GA", phoneCode: "+241" },
        { name: "Gambia", code: "GM", phoneCode: "+220" },
        { name: "Georgia", code: "GE", phoneCode: "+995" },
        { name: "Germany", code: "DE", phoneCode: "+49" },
        { name: "Ghana", code: "GH", phoneCode: "+233" },
        { name: "Gibraltar", code: "GI", phoneCode: "+350" },
        { name: "Greece", code: "GR", phoneCode: "+30" },
        { name: "Greenland", code: "GL", phoneCode: "+299" },
        { name: "Grenada", code: "GD", phoneCode: "+1" },
        { name: "Guadeloupe", code: "GP", phoneCode: "+590" },
        { name: "Guam", code: "GU", phoneCode: "+1" },
        { name: "Guatemala", code: "GT", phoneCode: "+502" },
        { name: "Guernsey", code: "GG", phoneCode: "+44" },
        { name: "Guinea", code: "GN", phoneCode: "+224" },
        { name: "Guinea-Bissau", code: "GW", phoneCode: "+245" },
        { name: "Guyana", code: "GY", phoneCode: "+592" },
        { name: "Haiti", code: "HT", phoneCode: "+509" },
        {
          name: "Heard Island and McDonald Islands",
          code: "HM",
          phoneCode: "+672",
        },
        {
          name: "Holy See (Vatican City State)",
          code: "VA",
          phoneCode: "+379",
        },
        { name: "Honduras", code: "HN", phoneCode: "+504" },
        { name: "Hong Kong", code: "HK", phoneCode: "+852" },
        { name: "Hungary", code: "HU", phoneCode: "+36" },
        { name: "Iceland", code: "IS", phoneCode: "+354" },
        { name: "India", code: "IN", phoneCode: "+91" },
        { name: "Indonesia", code: "ID", phoneCode: "+62" },
        {
          name: "Iran, Islamic Republic of",
          code: "IR",
          phoneCode: "+98",
        },
        { name: "Iraq", code: "IQ", phoneCode: "+964" },
        { name: "Ireland", code: "IE", phoneCode: "+353" },
        { name: "Isle of Man", code: "IM", phoneCode: "+44" },
        { name: "Israel", code: "IL", phoneCode: "+972" },
        { name: "Italy", code: "IT", phoneCode: "+39" },
        { name: "Jamaica", code: "JM", phoneCode: "+1" },
        { name: "Japan", code: "JP", phoneCode: "+81" },
        { name: "Jersey", code: "JE", phoneCode: "+44" },
        { name: "Jordan", code: "JO", phoneCode: "+962" },
        { name: "Kazakhstan", code: "KZ", phoneCode: "+7" },
        { name: "Kenya", code: "KE", phoneCode: "+254" },
        { name: "Kiribati", code: "KI", phoneCode: "+686" },
        {
          name: "Korea, Democratic People's Republic of",
          code: "KP",
          phoneCode: "+850",
        },
        { name: "Korea, Republic of", code: "KR", phoneCode: "+82" },
        { name: "Kosovo", code: "XK", phoneCode: "+383" },
        { name: "Kuwait", code: "KW", phoneCode: "+965" },
        { name: "Kyrgyzstan", code: "KG", phoneCode: "+996" },
        {
          name: "Lao People's Democratic Republic",
          code: "LA",
          phoneCode: "+856",
        },
        { name: "Latvia", code: "LV", phoneCode: "+371" },
        { name: "Lebanon", code: "LB", phoneCode: "+961" },
        { name: "Lesotho", code: "LS", phoneCode: "+266" },
        { name: "Liberia", code: "LR", phoneCode: "+231" },
        {
          name: "Libyan Arab Jamahiriya",
          code: "LY",
          phoneCode: "+218",
        },
        { name: "Liechtenstein", code: "LI", phoneCode: "+423" },
        { name: "Lithuania", code: "LT", phoneCode: "+370" },
        { name: "Luxembourg", code: "LU", phoneCode: "+352" },
        { name: "Macao", code: "MO", phoneCode: "+853" },
        {
          name: "Macedonia, the Former Yugoslav Republic of",
          code: "MK",
          phoneCode: "+389",
        },
        { name: "Madagascar", code: "MG", phoneCode: "+261" },
        { name: "Malawi", code: "MW", phoneCode: "+265" },
        { name: "Malaysia", code: "MY", phoneCode: "+60" },
        { name: "Maldives", code: "MV", phoneCode: "+960" },
        { name: "Mali", code: "ML", phoneCode: "+223" },
        { name: "Malta", code: "MT", phoneCode: "+356" },
        { name: "Marshall Islands", code: "MH", phoneCode: "+692" },
        { name: "Martinique", code: "MQ", phoneCode: "+596" },
        { name: "Mauritania", code: "MR", phoneCode: "+222" },
        { name: "Mauritius", code: "MU", phoneCode: "+230" },
        { name: "Mayotte", code: "YT", phoneCode: "+262" },
        { name: "Mexico", code: "MX", phoneCode: "+52" },
        {
          name: "Micronesia, Federated States of",
          code: "FM",
          phoneCode: "+691",
        },
        { name: "Moldova, Republic of", code: "MD", phoneCode: "+373" },
        { name: "Monaco", code: "MC", phoneCode: "+377" },
        { name: "Mongolia", code: "MN", phoneCode: "+976" },
        { name: "Montenegro", code: "ME", phoneCode: "+382" },
        { name: "Montserrat", code: "MS", phoneCode: "+1" },
        { name: "Morocco", code: "MA", phoneCode: "+212" },
        { name: "Mozambique", code: "MZ", phoneCode: "+258" },
        { name: "Myanmar", code: "MM", phoneCode: "+95" },
        { name: "Namibia", code: "NA", phoneCode: "+264" },
        { name: "Nauru", code: "NR", phoneCode: "+674" },
        { name: "Nepal", code: "NP", phoneCode: "+977" },
        { name: "Netherlands", code: "NL", phoneCode: "+31" },
        { name: "Netherlands Antilles", code: "AN", phoneCode: "+599" },
        { name: "New Caledonia", code: "NC", phoneCode: "+687" },
        { name: "New Zealand", code: "NZ", phoneCode: "+64" },
        { name: "Nicaragua", code: "NI", phoneCode: "+505" },
        { name: "Niger", code: "NE", phoneCode: "+227" },
        { name: "Nigeria", code: "NG", phoneCode: "+234" },
        { name: "Niue", code: "NU", phoneCode: "+683" },
        { name: "Norfolk Island", code: "NF", phoneCode: "+672" },
        {
          name: "Northern Mariana Islands",
          code: "MP",
          phoneCode: "+1",
        },
        { name: "Norway", code: "NO", phoneCode: "+47" },
        { name: "Oman", code: "OM", phoneCode: "+968" },
        { name: "Pakistan", code: "PK", phoneCode: "+92" },
        { name: "Palau", code: "PW", phoneCode: "+680" },
        {
          name: "Palestinian Territory, Occupied",
          code: "PS",
          phoneCode: "+970",
        },
        { name: "Panama", code: "PA", phoneCode: "+507" },
        { name: "Papua New Guinea", code: "PG", phoneCode: "+675" },
        { name: "Paraguay", code: "PY", phoneCode: "+595" },
        { name: "Peru", code: "PE", phoneCode: "+51" },
        { name: "Philippines", code: "PH", phoneCode: "+63" },
        { name: "Pitcairn", code: "PN", phoneCode: "+870" },
        { name: "Poland", code: "PL", phoneCode: "+48" },
        { name: "Portugal", code: "PT", phoneCode: "+351" },
        { name: "Puerto Rico", code: "PR", phoneCode: "+1" },
        { name: "Qatar", code: "QA", phoneCode: "+974" },
        { name: "Reunion", code: "RE", phoneCode: "+262" },
        { name: "Romania", code: "RO", phoneCode: "+40" },
        { name: "Russian Federation", code: "RU", phoneCode: "+7" },
        { name: "Rwanda", code: "RW", phoneCode: "+250" },
        { name: "Saint Barthelemy", code: "BL", phoneCode: "+590" },
        { name: "Saint Helena", code: "SH", phoneCode: "+290" },
        { name: "Saint Kitts and Nevis", code: "KN", phoneCode: "+1" },
        { name: "Saint Lucia", code: "LC", phoneCode: "+1" },
        { name: "Saint Martin", code: "MF", phoneCode: "+590" },
        {
          name: "Saint Pierre and Miquelon",
          code: "PM",
          phoneCode: "+508",
        },
        {
          name: "Saint Vincent and the Grenadines",
          code: "VC",
          phoneCode: "+1",
        },
        { name: "Samoa", code: "WS", phoneCode: "+685" },
        { name: "San Marino", code: "SM", phoneCode: "+378" },
        {
          name: "Sao Tome and Principe",
          code: "ST",
          phoneCode: "+239",
        },
        { name: "Saudi Arabia", code: "SA", phoneCode: "+966" },
        { name: "Senegal", code: "SN", phoneCode: "+221" },
        { name: "Serbia", code: "RS", phoneCode: "+381" },
        {
          name: "Serbia and Montenegro",
          code: "CS",
          phoneCode: "+381",
        },
        { name: "Seychelles", code: "SC", phoneCode: "+248" },
        { name: "Sierra Leone", code: "SL", phoneCode: "+232" },
        { name: "Singapore", code: "SG", phoneCode: "+65" },
        { name: "St Martin", code: "SX", phoneCode: "+590" },
        { name: "Slovakia", code: "SK", phoneCode: "+421" },
        { name: "Slovenia", code: "SI", phoneCode: "+386" },
        { name: "Solomon Islands", code: "SB", phoneCode: "+677" },
        { name: "Somalia", code: "SO", phoneCode: "+252" },
        { name: "South Africa", code: "ZA", phoneCode: "+27" },
        {
          name: "South Georgia and the South Sandwich Islands",
          code: "GS",
          phoneCode: "",
        },
        { name: "South Sudan", code: "SS", phoneCode: "+211" },
        { name: "Spain", code: "ES", phoneCode: "+34" },
        { name: "Sri Lanka", code: "LK", phoneCode: "+94" },
        { name: "Sudan", code: "SD", phoneCode: "+249" },
        { name: "Suriname", code: "SR", phoneCode: "+597" },
        {
          name: "Svalbard and Jan Mayen",
          code: "SJ",
          phoneCode: "+47",
        },
        { name: "Swaziland", code: "SZ", phoneCode: "+268" },
        { name: "Sweden", code: "SE", phoneCode: "+46" },
        { name: "Switzerland", code: "CH", phoneCode: "+41" },
        { name: "Syrian Arab Republic", code: "SY", phoneCode: "+963" },
        {
          name: "Taiwan, Province of China",
          code: "TW",
          phoneCode: "+886",
        },
        { name: "Tajikistan", code: "TJ", phoneCode: "+992" },
        {
          name: "Tanzania, United Republic of",
          code: "TZ",
          phoneCode: "+255",
        },
        { name: "Thailand", code: "TH", phoneCode: "+66" },
        { name: "Timor-Leste", code: "TL", phoneCode: "+670" },
        { name: "Togo", code: "TG", phoneCode: "+228" },
        { name: "Tokelau", code: "TK", phoneCode: "+690" },
        { name: "Tonga", code: "TO", phoneCode: "+676" },
        { name: "Trinidad and Tobago", code: "TT", phoneCode: "+1" },
        { name: "Tunisia", code: "TN", phoneCode: "+216" },
        { name: "Turkey", code: "TR", phoneCode: "+90" },
        { name: "Turkmenistan", code: "TM", phoneCode: "+993" },
        {
          name: "Turks and Caicos Islands",
          code: "TC",
          phoneCode: "+1",
        },
        { name: "Tuvalu", code: "TV", phoneCode: "+688" },
        { name: "Uganda", code: "UG", phoneCode: "+256" },
        { name: "Ukraine", code: "UA", phoneCode: "+380" },
        { name: "United Arab Emirates", code: "AE", phoneCode: "+971" },
        { name: "United Kingdom", code: "GB", phoneCode: "+44" },
        { name: "United States", code: "US", phoneCode: "+1" },
        {
          name: "United States Minor Outlying Islands",
          code: "UM",
          phoneCode: "+1",
        },
        { name: "Uruguay", code: "UY", phoneCode: "+598" },
        { name: "Uzbekistan", code: "UZ", phoneCode: "+998" },
        { name: "Vanuatu", code: "VU", phoneCode: "+678" },
        { name: "Venezuela", code: "VE", phoneCode: "+58" },
        { name: "Viet Nam", code: "VN", phoneCode: "+84" },
        {
          name: "Virgin Islands, British",
          code: "VG",
          phoneCode: "+1",
        },
        { name: "Virgin Islands, U.s.", code: "VI", phoneCode: "+1" },
        { name: "Wallis and Futuna", code: "WF", phoneCode: "+681" },
        { name: "Western Sahara", code: "EH", phoneCode: "+212" },
        { name: "Yemen", code: "YE", phoneCode: "+967" },
        { name: "Zambia", code: "ZM", phoneCode: "+260" },
        { name: "Zimbabwe", code: "ZW", phoneCode: "+263" },
      ],
      provinces: [
        { name: "Alberta" },
        { name: "British Columbia" },
        { name: "Manitoba" },
        { name: "New Brunswick" },
        { name: "Newfoundland and Labrador" },
        { name: "Northwest Territories" },
        { name: "Nova Scotia" },
        { name: "Nunavut" },
        { name: "Prince Edward Island" },
        { name: "Quebec" },
        { name: "Saskatchewan" },
        { name: "Yukon" },
      ],
      tuition_funding_sources: [
        { value: "my_own_funds", name: "My own funds" },
        { value: "parents_family_relatives_friends", name: "Parents, family, relative(s), friend(s)" },
        { value: "sponsored_by_company_or_government", name: "Sponsored by company or government" },
        { value: "sponsored_by_ngo", name: "Sponsored by NGO" },
        { value: "sponsored_by_not_for_profit_organization", name: "Sponsored by not-for-profit organization" },
        { value: "other", name: "Other" },
      ],
      showRecaptcha: true,
      toggelSubmitButton: false,
      emailValidationErro: "",
      confirmEmailValidationErro: "",
      local_schools: [],
      local_messaging_apps: [],
      local_programs: [],
      school_name_as_per_school_id_from_url: "",
      local_countries: [],
      local_provinces: [],
      local_tuition_funding_source: [],
      other_1_checkbox: false,
      other_score_1: "Enter score",
      other_name_1: "Enter test name",
      other_2_checkbox: false,
      other_score_2: "Enter score",
      other_name_2: "Enter test name",
      other_3_checkbox: false,
      other_score_3: "Enter score",
      other_name_3: "Enter test name",
      other_4_checkbox: false,
      other_score_4: "Enter score",
      other_name_4: "Enter test name",
      other_5_checkbox: false,
      other_score_5: "Enter score",
      other_name_5: "Enter test name",
    };
  },
  methods: {
    toggleModal() {
      this.showModal = !this.showModal;
    },
    togglePopUpModal() {
      this.showPopUpModal = !this.showPopUpModal;
      if (!this.showPopUpModal) {
        window.location.reload();

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
          window.location.reload();


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
    toggleTestTakenDropDown() {
      this.test_taken_dropdown = !this.test_taken_dropdown;
    },
    validateEmail(e) {
      this.emailValidationErro = "";
      if (
        /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(e.target.value)
      ) {
        return true;
      } else {
        // this.emailValidationErro = "please use this format your@email.com";
      }
      return false;
    },
    validateEmail2(e) {
      this.confirmEmailValidationErro = "";
      if (
        !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(e.target.value)
      ) {
        this.confirmEmailValidationErro =
          "please use this format your@email.com";
        return false;
      }
      if (this.email.trim() != e.target.value.trim()) {
        this.confirmEmailValidationErro =
          "Email and confirm email must be same";
        return false;
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
                this.saveMasterApplication();
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
    saveMasterApplication() {
      console.log('run');
      console.log("Sending data:", {
        school_id: this.school_drop_id,
      });
      let dataToSend = {
        customer_id: this.logged_in_customer,
        first_name: this.first_name,
        last_name: this.last_name,
        email: this.email,
        confirm_email: this.confirm_email,
        dob: this.dob,
        gender: this.gender,
        phone: this.phone,
        can_school_text_you: this.can_school_text_you,
        messaging_app: this.messaging_app,
        messaging_app_username: this.messaging_app_username,
        where_want_to_study: this.where_want_to_study,
        country_of_citizenship: JSON.stringify(this.country_of_citizenship),
        live_in_your_country_citizenship: this.live_in_your_country_citizenship,
        current_residance: this.current_residance,
        current_residance_status: this.current_residance_status,
        mailing_address: this.mailing_address,
        high_school_name: this.high_school_name,
        currently_living_in_canada: this.currently_living_in_canada,
        currently_student_anywhere: this.currently_student_anywhere,
        letter_of_intent: this.letter_of_intent,
        statement_of_purpose: this.statement_of_purpose,
        high_school_cgpa: this.high_school_cgpa,
        high_school_city: this.high_school_city,
        high_school_country: this.high_school_country,
        when_plan_to_start: this.when_plan_to_start,
        interested_in: this.interested_in,
        would_like_to_study: JSON.stringify(this.would_like_to_study),
        student_type: this.student_type,
        tuition_funding_source: this.tuition_funding_source,
        test_taken: this.test_taken,
        addtional: this.addtional,
        add_anything: this.add_anything,
        study_permit_candian_embassy: this.study_permit_candian,
        send_me_a_copy: this.send_me_a_copy,
        for_demetra_or_master_app: this.for_demetra_or_master_app,
        school_id: (this.school_drop_id && this.school_drop_id.length > 0 && this.school_drop_id[0] !== '')
          ? this.school_drop_id
          : [],
        other_score_1: this.other_1_checkbox ? this.other_score_1 : 0,
        other_name_1: this.other_1_checkbox ? this.other_name_1 : "",
        other_score_2: this.other_2_checkbox ? this.other_score_2 : 0,
        other_name_2: this.other_2_checkbox ? this.other_name_2 : "",
        other_score_3: this.other_3_checkbox ? this.other_score_3 : 0,
        other_name_3: this.other_3_checkbox ? this.other_name_3 : "",
        other_score_4: this.other_4_checkbox ? this.other_score_4 : 0,
        other_name_4: this.other_4_checkbox ? this.other_name_4 : "",
        other_score_5: this.other_5_checkbox ? this.other_score_5 : 0,
        other_name_5: this.other_5_checkbox ? this.other_name_5 : "",
      };
      let url = `${process.env.MIX_WEB_API_URL}master-applications`;

      axios
        .post(url, dataToSend)
        .then((res) => {
          this.showPopUpModal = true;
          this.popupMsg = res.data.message;
          if (res.data.status == "Success") {
            // this.resetForm();
            // helper.swalSuccessMessage(res.data.message);
            let masterFields = [
              "school_drop_id",
              "first_name",
              "last_name",
              "email",
              "confirm_email",
              "gender",
              "dob",
              "phone",
              "can_school_text_you",
              "messaging_app",
              "can_school_text_you",
              "where_want_to_study",
              "country_of_citizenship",
              "live_in_your_country_citizenship",
              "current_residance",
              "current_residance_status",
              "mailing_address",
              "high_school_name",
              "currently_living_in_canada",
              "currently_student_anywhere",
              "letter_of_intent",
              "statement_of_purpose",
              "high_school_cgpa",
              "high_school_city",
              "high_school_country",
              "when_plan_to_start",
              "interested_in",
              "would_like_to_study",
              "student_type",
              "tuition_funding_source",
              "addtional",
              "add_anything",
              "study_permit_candian_embassy",
              "other_1_checkbox",
              "other_2_checkbox",
              "other_3_checkbox",
              "other_4_checkbox",
              "other_5_checkbox",
            ];
            masterFields?.map((f) => {
              const savedField = localStorage.removeItem("master_" + f);
            });
            // window.location.reload();
          } else if (res.error) {
            // helper.swalErrorMessage(res.data.message);
            this.showPopUpModal = true;
            this.popupMsg = res.error;
          } else {
            // helper.swalErrorMessage(res.data.message);
            this.showPopUpModal = true;
            this.popupMsg = res.data.message;
          }
        })
        .catch((error) => {
          console.log(error.response.data.error);
          if (error.response && error.response.status == 400) {
            this.showPopUpModal = true;
            this.popupMsg = error.response.data.error;
          }
          else if (error.response && error.response.status == 422) {
            this.errors.record(error.response.data.errors);
            this.focusOnFirstErrorInput(error.response.data.errors); // Scroll to first error
          } else if (
            error.response &&
            error.response.data &&
            error.response.data.status == "Error"
          ) {
            helper.swalErrorMessage(error.response.data.message);
          }
        })
        .finally();
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
    resetForm() {
      this.first_name = "";
      this.last_name = "";
      this.email = "";
      this.confirm_email = "";
      this.dob = "";
      this.gender = "";
      this.phone = "";
      this.can_school_text_you = "";
      this.messaging_app = "";
      this.messaging_app_username = "";
      this.where_want_to_study = "";
      this.country_of_citizenship = "";
      this.live_in_your_country_citizenship = "";
      this.current_residance = "";
      this.current_residance_status = "";
      this.mailing_address = "";
      this.high_school_name = "";
      this.currently_living_in_canada = "";
      this.currently_student_anywhere = "";
      this.letter_of_intent = "";
      this.statement_of_purpose = "";
      this.high_school_cgpa = "";
      this.high_school_city = "";
      this.high_school_country = "";
      this.when_plan_to_start = "";
      this.interested_in = "";
      this.would_like_to_study = "";
      this.student_type = "";
      this.tuition_funding_source = "";
      this.test_taken = "";
      this.addtional = "";
      this.add_anything = "";
      this.study_permit_candian = "no";
      this.send_me_a_copy = false;
      this.for_demetra_or_master_app = "";
      this.errors = new ErrorHandling();
    },
    isChecked(opt) {
      // Manually loop through test_taken array to check for the matching test ID
      for (let i = 0; i < this.test_taken.length; i++) {
        if (this.test_taken[i].test === opt.id) {
          return true; // Return true if a match is found
        }
      }
      return false; // Return false if no match is found
    },
    handleTestTaken(e, opt) {
      if (e.target.checked) {
        this.test_taken.push({
          test: opt?.id,
          score: 0,
        });
      } else {
        this.test_taken.filter((tst, index) => {
          if (tst?.test == opt?.id) {
            this.test_taken.splice(index, 1);
          }
        });
      }
      this.errors.has("test_taken") ? this.errors.clear("test_taken") : "";
    },
    checkIfExist(opt) {
      this.test_taken.filter((tst, index) => {
        alert(tst?.test == opt);
        if (tst?.test == opt) {
          return false;
        }
      });
      return true;
    },
    setTestTakenScore(e, opt) {
      this.test_taken.filter((tst, index) => {
        if (tst?.test == opt?.id) {
          this.test_taken[index].score = e.target.value;
        }
      });
    },
    isValueDisabled(opt) {
      // Ensure test_taken is an array
      const testTaken = Array.isArray(this.test_taken) ? this.test_taken : [];

      return !testTaken.some((item) => item.test === opt?.id);
    }
    ,
    scoreValue(opt) {
      for (var i = 0; i < this.test_taken?.length; i++) {
        if (this.test_taken[i].test == opt?.id) {
          return this.test_taken[i].score;
        }
      }
    },
    // handleMessagingAppUserName(e, key) {
    //   this.messaging_app_username[key] = e.target.value;
    //   this.errors.has("messaging_app_username")
    //     ? this.errors.clear("messaging_app_username")
    //     : "";
    //   this.errors.has("messaging_app_username." + key)
    //     ? this.errors.clear("messaging_app_username." + key)
    //     : "";
    // },
    getMessagingAppName(appId) {
      const app = this.local_messaging_apps.find((app) => app.id === appId);
      return app ? app.text : '';
    },
    handleMessagingAppUserName(e, key) {
      this.messaging_app_username[key] = e.target.value;
      this.errors.has("messaging_app_username")
        ? this.errors.clear("messaging_app_username")
        : "";
      this.errors.has("messaging_app_username." + key)
        ? this.errors.clear("messaging_app_username." + key)
        : "";
    },
  },
  beforeUnmount() {
    document.removeEventListener("click", this.handleClickOutsidePopup);
  },
  mounted() {
    document.addEventListener("click", this.handleClickOutsidePopup);

    if (this.master_application_modal_translation) {
      this.static_translations = this.master_application_modal_translation;
    }
    console.log("Static Translations:", this.static_translations);
    if (this?.school_id || this?.school_id == "" || this?.school_id == null) {
      this.school_drop_id.push(this?.school_id);
    }
    this.master_app_setting = JSON.parse(this.master_application_setting);
    this.$store.commit("schools/setLimit", 20000);
    this.$store.commit("schools/setSortBy", "id");
    this.$store.commit("schools/setSortType", "desc");
    this.$store.dispatch("schools/fetchSchools").then((res) => {
      console.log(res.data.data, "response");
      this.local_schools = [];
      res.data.data.filter(school => school.deactive_account === 0).map((school) => {
        if (
          this.school_id ||
          this.school_id == "" ||
          this.school_id == null
        ) {
          if (school.id == this.school_id)
            this.school_name_as_per_school_id_from_url =
              school?.school_detail[0].school_name;
        }
        this.local_schools.push({
          id: school.id,
          text: school?.school_detail[0].school_name,
        });
      });
    });

    this.$store.commit("messaging_apps/setLimit", 20000);
    this.$store.commit("messaging_apps/setSortBy", "id");
    this.$store.commit("messaging_apps/setSortType", "desc");
    this.$store.dispatch("messaging_apps/fetchMessagingApps").then((res) => {
      console.log(res.data.data, "local message response");
      this.local_messaging_apps = [];
      this.local_messaging_apps = res.data.data.map((messaging_app) => ({
        id: messaging_app.id,
        text: messaging_app?.messaging_app_detail[0].name,
      }));
      console.log(this.local_messaging_apps, "local_messaging_apps before mapping");
      // res.data.data.map((messaging_app) => {
      //   console.log('roko kocat', res.data.data);
      //   this.local_messaging_apps.push({
      //     id: messaging_app.id,
      //     text: messaging_app?.messaging_app_detail[0].name,
      //   });
      // });
      // console.log('local_messaging_apps after mapping:', this.local_messaging_apps);
    });
    // this.$store.dispatch("messaging_apps/fetchMessagingApps").then((res) => {
    //   console.log(main_res ,'res');
    //   this.local_messaging_apps = res.data.data.map((messaging_app) => ({
    //     id: messaging_app.id,
    //     text: messaging_app?.messaging_app_detail[0].name,
    //   }));
    //   console.log('this.local_messaging_apps',this.local_messaging_apps);
    // });

    this.$store.commit("programs/setLimit", 20000);
    this.$store.commit("programs/setSortBy", "id");
    this.$store.commit("programs/setSortType", "desc");
    this.$store.dispatch("programs/fetchPrograms").then((res) => {
      console.log(res.data.data, "response");
      this.local_programs = [];
      res.data.data.filter(programs => programs.status == 'approved').map((program) => {
        this.local_programs.push({
          id: program.id,
          text: program?.program_detail[0]?.name,
        });
      });
      console.log('console logging... ', this.local_programs)
    });

    this.$store.commit("degrees/setLimit", 20000);
    this.$store.commit("degrees/setSortBy", "name");
    this.$store.commit("degrees/setSortType", "asc");
    this.$store.dispatch("degrees/fetchDegrees");

    this.$store.commit("tests/setLimit", 20000);
    this.$store.commit("tests/setSortBy", "id");
    this.$store.commit("tests/setSortType", "desc");
    this.$store.dispatch("tests/fetchTests");

    this.local_countries = [];
    this.countries.map((country) => {
      this.local_countries.push({
        id: country.code,
        text: country.name,
      });
    });

    // this.local_provinces = [];
    // this.provinces.map((province) => {
    //   this.local_provinces.push({
    //     id: province.name,
    //     text: province.name,
    //   });
    // });

    this.local_provinces = [
      { id: "All", text: "All" }, // Add "All" as the first option
      ...this.provinces.map((province) => ({
        id: province.name,
        text: province.name,
      })),
    ];

    // Ensure "All" is pre-selected after the options are set
    this.$nextTick(() => {
      this.where_want_to_study = [{ id: "All", text: "All" }];
    });

    this.local_tuition_funding_source = [];
    this.tuition_funding_sources.map((tuition_funding_source) => {
      this.local_tuition_funding_source.push({
        id: tuition_funding_source.value,
        text: tuition_funding_source.name,
      });
    });

    let masterFields = [
      "first_name",
      "last_name",
      "email",
      "confirm_email",
      "gender",
      "dob",
      "phone",
      "can_school_text_you",
      "messaging_app",
      "can_school_text_you",
      "where_want_to_study",
      "country_of_citizenship",
      "live_in_your_country_citizenship",
      "current_residance",
      "current_residance_status",
      "mailing_address",
      "high_school_name",
      "currently_living_in_canada",
      "currently_student_anywhere",
      "letter_of_intent",
      "statement_of_purpose",
      "high_school_cgpa",
      "high_school_city",
      "high_school_country",
      "when_plan_to_start",
      "interested_in",
      "would_like_to_study",
      "student_type",
      "tuition_funding_source",
      "addtional",
      "add_anything",
      "study_permit_candian_embassy",
      "other_1_checkbox",
      "other_2_checkbox",
      "other_3_checkbox",
      "other_4_checkbox",
      "other_5_checkbox",
    ];
    // masterFields?.map((f) => {
    //   const savedField = localStorage.getItem("master_" + f);
    //   if (savedField) {
    //     this[f] = savedField;
    //   }
    // });
    masterFields.map((f) => {
      this[f] = ""; // Marked Change: Reset fields to an empty string
    });

    const savedSchoolId = localStorage.getItem("master_school_drop_id");
    if (savedSchoolId) {
      this.school_drop_id = savedSchoolId.split(",");
    }
    // const masterCitized = localStorage.getItem("master_country_of_citizenship");
    // if (masterCitized) {
    //   this.country_of_citizenship = masterCitized.split(",");
    // }
    // const masterProvince = localStorage.getItem("master_where_want_to_study");
    // if (masterProvince) {
    //   this.where_want_to_study = masterProvince.split(",");
    // }
    // const masterProgram = localStorage.getItem("master_would_like_to_study");
    // if (masterProgram) {
    //   this.would_like_to_study = masterProgram.split(",").map(value => parseInt(value, 10));
    // }
    // const masterFund = localStorage.getItem("master_tuition_funding_source");
    // if (masterFund) {
    //   this.tuition_funding_source = masterFund.split(",");
    // }
    this.country_of_citizenship = [];
    this.where_want_to_study = [];
    this.would_like_to_study = [];
    this.tuition_funding_source = [];
  },

  watch: {
    school_drop_id(newValue, oldValue) {
      this.errors.has("school_id") ? this.errors.clear("school_id") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_school_drop_id", newValue);
      }
    },
    first_name(newValue, oldValue) {
      this.errors.has("first_name") ? this.errors.clear("first_name") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_first_name", newValue);
      }
    },
    last_name(newValue, oldValue) {
      this.errors.has("last_name") ? this.errors.clear("last_name") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_last_name", newValue);
      }
    },
    email(newValue, oldValue) {
      this.errors.has("email") ? this.errors.clear("email") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_email", newValue);
      }
    },
    confirm_email(newValue, oldValue) {
      this.errors.has("confirm_email")
        ? this.errors.clear("confirm_email")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_confirm_email", newValue);
      }
    },
    gender(newValue, oldValue) {
      this.errors.has("gender") ? this.errors.clear("gender") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_gender", newValue);
      }
    },
    dob(newValue, oldValue) {
      this.errors.has("dob") ? this.errors.clear("dob") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_dob", newValue);
      }
    },
    phone(newValue, oldValue) {
      this.errors.has("phone") ? this.errors.clear("phone") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_phone", newValue);
      }
    },
    can_school_text_you(newValue, oldValue) {
      this.errors.has("can_school_text_you")
        ? this.errors.clear("can_school_text_you")
        : "";
      if (newValue && newValue != "") {
        if (newValue === "no") {
          this.messaging_app = ""; // Reset the selected options in Select2
        }
        localStorage.setItem("master_can_school_text_you", newValue);
      }
    },
    messaging_app(newValue, oldValue) {
      this.errors.has("messaging_app")
        ? this.errors.clear("messaging_app")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_messaging_app", newValue);
      }
    },
    where_want_to_study(newValue, oldValue) {
      this.errors.has("where_want_to_study")
        ? this.errors.clear("where_want_to_study")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_where_want_to_study", newValue);
      }
    },
    country_of_citizenship(newValue, oldValue) {
      this.errors.has("country_of_citizenship")
        ? this.errors.clear("country_of_citizenship")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_country_of_citizenship", newValue);
      }
    },
    live_in_your_country_citizenship(newValue, oldValue) {
      this.errors.has("live_in_your_country_citizenship")
        ? this.errors.clear("live_in_your_country_citizenship")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem(
          "master_live_in_your_country_citizenship",
          newValue
        );
      }
    },
    current_residance(newValue, oldValue) {
      this.errors.has("current_residance")
        ? this.errors.clear("current_residance")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_current_residance", newValue);
      }
    },

    current_residance_status(newValue, oldValue) {
      this.errors.has("current_residance_status")
        ? this.errors.clear("current_residance_status")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_current_residance_status", newValue);
      }
    },

    mailing_address(newValue, oldValue) {
      this.errors.has("mailing_address")
        ? this.errors.clear("mailing_address")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_mailing_address", newValue);
      }
    },

    high_school_name(newValue, oldValue) {
      this.errors.has("high_school_name")
        ? this.errors.clear("high_school_name")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_high_school_name", newValue);
      }
    },
    currently_living_in_canada(newValue, oldValue) {
      this.errors.has("currently_living_in_canada")
        ? this.errors.clear("currently_living_in_canada")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_currently_living_in_canada", newValue);
      }
    },
    currently_student_anywhere(newValue, oldValue) {
      this.errors.has("currently_student_anywhere")
        ? this.errors.clear("currently_student_anywhere")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_currently_student_anywhere", newValue);
      }
    },
    statement_of_purpose(newValue, oldValue) {
      this.errors.has("statement_of_purpose")
        ? this.errors.clear("statement_of_purpose")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_statement_of_purpose", newValue);
      }
    },
    letter_of_intent(newValue, oldValue) {
      this.errors.has("letter_of_intent")
        ? this.errors.clear("letter_of_intent")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_letter_of_intent", newValue);
      }
    },

    high_school_cgpa(newValue, oldValue) {
      this.errors.has("high_school_cgpa")
        ? this.errors.clear("high_school_cgpa")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_high_school_cgpa", newValue);
      }
    },

    high_school_city(newValue, oldValue) {
      this.errors.has("high_school_city")
        ? this.errors.clear("high_school_city")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_high_school_city", newValue);
      }
    },

    high_school_country(newValue, oldValue) {
      this.errors.has("high_school_country")
        ? this.errors.clear("high_school_country")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_high_school_country", newValue);
      }
    },

    when_plan_to_start(newValue, oldValue) {
      this.errors.has("when_plan_to_start")
        ? this.errors.clear("when_plan_to_start")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_when_plan_to_start", newValue);
      }
    },

    //   interested_in(newValue, oldValue) {
    //     this.errors.has("interested_in")
    //       ? this.errors.clear("interested_in")
    //       : "";
    //     if (newValue && newValue != "") {
    //       localStorage.setItem("master_interested_in", newValue);
    //     }
    //     this.local_programs = [];

    //  this?.programs?.filter(program => program.status == 'approved').map((program) => {
    //       if (newValue == program.degree_id) {
    //         this.local_programs.push({
    //           id: program.id,
    //           text: program?.program_detail[0].name,
    //         });
    //       }
    //     });
    //   },
    interested_in(newValue, oldValue) {
      this.errors.has("interested_in") ? this.errors.clear("interested_in") : "";

      if (newValue && newValue !== "") {
        localStorage.setItem("master_interested_in", newValue);
      }

      this.local_programs = [];

      this?.programs?.filter(program => program.status == 'approved').map((program) => {

        const hasDegree = program.program_degree_level.some(degree => degree.degree_id == newValue);

        if (hasDegree) {
          this.local_programs.push({
            id: program.id,
            text: program?.program_detail[0]?.name,
          });
        }
      });
    },

    would_like_to_study(newValue, oldValue) {
      this.errors.has("would_like_to_study")
        ? this.errors.clear("would_like_to_study")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_would_like_to_study", newValue);
      }
    },

    student_type(newValue, oldValue) {
      this.errors.has("student_type") ? this.errors.clear("student_type") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_student_type", newValue);
      }
    },

    tuition_funding_source(newValue, oldValue) {
      this.errors.has("tuition_funding_source")
        ? this.errors.clear("tuition_funding_source")
        : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_tuition_funding_source", newValue);
      }
    },

    test_taken(newValue, oldValue) {
      this.errors.has("test_taken") ? this.errors.clear("test_taken") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_test_taken", newValue);
      }
    },

    addtional(newValue, oldValue) {
      this.errors.has("addtional") ? this.errors.clear("addtional") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_addtional", newValue);
      }
    },

    add_anything(newValue, oldValue) {
      this.errors.has("add_anything") ? this.errors.clear("add_anything") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_add_anything", newValue);
      }
    },
    study_permit_candian_embassy(newValue, oldValue) {
      this.errors.has("study_permit_candian_embassy")
        ? this.errors.clear("study_permit_candian_embassy")
        : "";
      if (newValue && newValue !== "") {
        localStorage.setItem("master_study_permit_candian_embassy", newValue);
      }
    },

    // study_permit_candian_embassy(newValue, oldValue) {
    //   this.errors.has("study_permit_candian_embassy")
    //     ? this.errors.clear("study_permit_candian_embassy")
    //     : "";
    //   if (newValue && newValue != "") {
    //     localStorage.setItem("master_study_permit_candian_embassy", newValue);
    //   }
    // },
    other_1_checkbox(newValue, oldValue) {
      this.errors.has("test_taken") ? this.errors.clear("test_taken") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_other_1_checkbox", newValue);
        // this.other_name_1 = null;
      } else {
        this.other_name_1 = 'Enter test name';
      }
    },
    other_2_checkbox(newValue, oldValue) {
      this.errors.has("test_taken") ? this.errors.clear("test_taken") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_other_2_checkbox", newValue);
      } else {
        this.other_name_2 = 'Enter test name';
      }
    },
    other_3_checkbox(newValue, oldValue) {
      this.errors.has("test_taken") ? this.errors.clear("test_taken") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_other_3_checkbox", newValue);
      }
    },
    other_4_checkbox(newValue, oldValue) {
      this.errors.has("test_taken") ? this.errors.clear("test_taken") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_other_4_checkbox", newValue);
      }
    },
    other_5_checkbox(newValue, oldValue) {
      this.errors.has("test_taken") ? this.errors.clear("test_taken") : "";
      if (newValue && newValue != "") {
        localStorage.setItem("master_other_5_checkbox", newValue);
      }
    },
  },
  created() {
    // this.mailing_address = fetchedData.mailing_address || "Default Value";
    // Fetch data from the API
    // Fetch data from the API
    axios
      .get(`${process.env.MIX_WEB_API_URL}get-master-applications/${this.logged_in_customer}`)
      .then((res) => {
        console.log('master res', res);
        console.log('this.messaging_app', res.data.data.messaging_app);

        if (res.data && res.data.status === "Success" && res.data.data) {
          const fetchedData = res.data.data;
          console.log('fetchedData', fetchedData);
          console.log('console.logconsole.logconsole.logconsole.log', fetchedData)

          // Populate fields with fetched data
          this.first_name = fetchedData.first_name || "";
          console.log('First name:', this.first_name);
          console.log('Mailing Address:', this.mailing_address);
          this.mailing_address = fetchedData?.mailing_address || "";
          this.last_name = fetchedData.last_name || "";
          this.can_school_text_you = fetchedData.can_school_text_you || "";
          this.confirm_email = fetchedData.confirm_email || "";
          this.dob = fetchedData.dob || "";
          this.gender = fetchedData.gender || "";
          this.phone = fetchedData.phone || "";
          this.email = fetchedData.email || "";
          this.where_want_to_study = fetchedData.where_want_to_study ?
            JSON.parse(fetchedData.where_want_to_study) : [];
          this.country_of_citizenship = fetchedData.country_of_citizenship ?
            JSON.parse(fetchedData.country_of_citizenship) : [];
          this.live_in_your_country_citizenship = fetchedData.live_in_your_country_citizenship || "yes";
          this.current_residance = fetchedData.current_residance || "";
          this.current_residance_status = fetchedData.current_residance_status || "";
          this.high_school_name = fetchedData.high_school_name || "";
          this.high_school_cgpa = fetchedData.high_school_cgpa || "";
          this.high_school_country = fetchedData.high_school_country || "";
          this.high_school_city = fetchedData.high_school_city || "";
          this.when_plan_to_start = fetchedData.when_plan_to_start || "fall_of_this_year";
          this.student_type = fetchedData.student_type || "new_freshman";
          this.tuition_funding_source = fetchedData.tuition_funding_source ?
            JSON.parse(fetchedData.tuition_funding_source) : [];
          this.test_taken = fetchedData.test_taken || [];
          this.addtional = fetchedData.addtional || "";
          this.add_anything = fetchedData.add_anything || "";
          this.study_permit_candian = fetchedData.study_permit_candian_embassy;
          this.send_me_a_copy = fetchedData.send_me_a_copy || false;
          this.for_demetra_or_master_app = fetchedData.for_demetra_or_master_app || "";
          this.letter_of_intent = fetchedData.letter_of_intent || "";
          this.currently_student_anywhere = fetchedData.currently_student_anywhere || "";
          this.currently_living_in_canada = fetchedData.currently_living_in_canada || "";
          this.statement_of_purpose = fetchedData.statement_of_purpose || "";
          this.interested_in = fetchedData?.interested_in.degree_detail[0].id || "";
          this.would_like_to_study = fetchedData.would_like_to_study ?
            JSON.parse(fetchedData.would_like_to_study) : [];

          const messagingAppsData = fetchedData.messaging_app || [];

          console.log("Messaging Apps Data:", messagingAppsData);


          this.messaging_app = messagingAppsData.map(app => app.messaging_app_id);
          this.messaging_app_username = messagingAppsData.map(app => app.user_name);
          console.log('Initialized Messaging Apps:', this.messaging_app);
          console.log('Initialized Messaging App Usernames:', this.messaging_app_username);

          const fetchedTests = fetchedData.tests || [];
          console.log("Fetched Tests:", fetchedTests);

          if (Array.isArray(fetchedTests)) {
            const validTests = fetchedTests.filter(test => test.test_id && test.score !== undefined);
            console.log("Valid Fetched Tests:", validTests);
            if (validTests.length > 0) {
              this.test_taken = validTests.map(test => ({ test: test.test_id, score: test.score }));
              console.log("Initialized test_taken:", this.test_taken);
            } else {
              console.warn("No valid test data found in API response.");
            }
          } else {
            console.error("Error: 'tests' data from API is not an array.");
          }


          // Handle other checkbox data
          const otherCheckBoxes = [1, 2, 3, 4, 5];
          otherCheckBoxes.forEach(index => {
            if (fetchedData[`other_test_${index}_name`] != null) {

              this[`other_name_${index}`] = fetchedData[`other_test_${index}_name`] || '';
              this[`other_score_${index}`] = fetchedData[`other_test_${index}_score`] || 0;

              this[`other_${index}_checkbox`] = true;
              console.log(this[`other_name_${index}`], fetchedData[`other_test_${index}_name`])
            }
          });
        } else {
          console.log("No data found or invalid response format.");
        }
      })
      .catch((error) => {
        console.error('Error fetching data:', error);
      });




    axios
      .get(`${process.env.MIX_WEB_API_URL}get-master-applications-schools/${this.logged_in_customer}`)
      .then((res) => {
        if (res.data && res.data.status === "success") {
          const fetchedData = res.data.data;

          if (Array.isArray(fetchedData)) {
            this.school_drop_id = fetchedData;
          } else {
            this.school_drop_id = [];
          }
        } else {
          console.log("No data found or invalid response format.");
        }
      })
      .catch((error) => {
        console.error('Error fetching data:', error);
      });


    console.log("logged_in_customer:", this.logged_in_customer);
    console.log("local_programs:", this.local_programs);
    console.log("Static Translations:", this.static_translations);
    console.log("moal master  Translations:", this.master_application_modal_translation);
    this.static_translations = JSON.parse(this.master_application_modal_translation);


    // if (this.show_form_warning && this.show_form_warning == 1) {
    //   if (this.user_type && this.user_type == 'student') {
    //     // Handle student case
    //   } else {
    //     if (this.user_type === 'school' || this.user_type === 'business') {
    //       Swal.fire({
    //         position: "center",
    //         allowOutsideClick: true,
    //         text: "Only registered students can submit Master application.",
    //         showConfirmButton: false,
    //         showCancelButton: true,
    //         cancelButtonText: 'Cancel',
    //         customClass: {
    //           cancelButton: 'can-edu-btn-fill'
    //         },
    //         didRender: () => {
    //           const closeButton = document.createElement('div');
    //           closeButton.innerHTML = `
    //         <div style="position: absolute; top: 10px; right: 10px; cursor: pointer;">
    //           <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
    //             <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
    //             </svg>
    //           </button>
    //         </div>
    //       `;
    //           closeButton.addEventListener('click', () => {
    //             window.history.back();
    //           });
    //           Swal.getHtmlContainer().appendChild(closeButton);
    //         },
    //       }).then((result) => {
    //         console.log(result);
    //         if (result.isDismissed || result.isDenied) {
    //           window.history.back();
    //         }
    //       });
    //     }

    //     else {
    //       const loginUrlWithParam = this.login_url + "?url=" + window.location.href;
    //       Swal.fire({
    //         position: "center",
    //         allowOutsideClick: true,
    //         showConfirmButton: false,
    //         showCancelButton: false,
    //         customClass: {
    //           popup: 'swal-custom-popup',
    //           text: 'swal-custom-text'
    //         },
    //         html: `
    //   <div class="swal-container" style="text-align: left;">

    //     <!-- Main Text -->
    //     <p class="swal-message mt-7" style="margin-bottom: 20px;">
    //       ${this.static_translations?.main_text ? this.static_translations?.main_text : ""}
    //     </p>

    //     <!-- Login Section -->
    //     <div class="swal-action" style="display: flex; align-items: center; justify-content: start;gap: 8px; margin-bottom: 10px;">
    //       <button class="can-edu-btn-fill login-btn">
    //         ${this.static_translations?.login_button_text ? this.static_translations?.login_button_text : "Login"}
    //       </button>
    //       <p class="swal-subtext">
    //         ${this.static_translations?.login_button_heading_text ? this.static_translations?.login_button_heading_text : ""}
    //       </p>
    //     </div>

    //     <!-- Register Section -->
    //     <div class="swal-action" style="display: flex; align-items: center; justify-content: start; gap: 8px;">
    //       <button class="can-edu-btn-fill register-btn">
    //         ${this.static_translations?.register_button_text ? this.static_translations?.register_button_text : "Register"}
    //       </button>
    //       <p class="swal-subtext">
    //         ${this.static_translations?.register_button_heading_text ? this.static_translations?.register_button_heading_text : ""}
    //       </p>
    //     </div>

    //     <!-- New Red Button for Closing -->
    //     <div class="swal-action" style="text-align: center; margin-top: 20px;">
    //       <button class="can-edu-btn-fill close-btn" style="background-color: red; color: white; padding: 10px 20px; border-radius: 5px; border: none; cursor: pointer;">
    //         ${this.static_translations?.close_button_text ? this.static_translations?.close_button_text : "Register"}
    //       </button>
    //     </div>

    //   </div>
    // `,
    //         didRender: () => {
    //           document.querySelector('.register-btn').addEventListener('click', () => {
    //             window.location.href = this.register_url;
    //           });

    //           document.querySelector('.login-btn').addEventListener('click', () => {
    //             window.location.href = loginUrlWithParam;
    //           });

    //           const closeButton = document.createElement('div');
    //           closeButton.innerHTML = `
    //     <div style="position: absolute; top: 12px; right: 10px; cursor: pointer;">
    //       <button type="button" class="text-primary bg-transparent hover:bg-gray-200 hover:text-primary rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center" data-modal-hide="defaultModal">
    //         <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
    //         </svg>
    //       </button>
    //     </div>
    //   `;
    //           closeButton.addEventListener('click', () => {
    //             // window.history.back();
    //             console.log(1)
    //             console.log(window.history)
    //             console.log(window.history.back())
    //             if (window.location.href.includes('/admin/')) {
    //               window.location.href = '/'; // Redirect to home page for admin\
    //             console.log(2)

    //             } else {
    //               window.history.back(); // Normal behavior for non-admin
    //             console.log(3)

    //             }
    //           });

    //           Swal.getHtmlContainer().appendChild(closeButton);

    //           document.querySelector('.close-btn').addEventListener('click', () => {
    //             // window.history.back();
    //             if (window.location.href.includes('/admin/')) {
    //               window.location.href = '/'; // Redirect to home page for admin
    //             } else {
    //               window.history.back(); // Normal behavior for non-admin
    //             }
    //           });
    //         },
    //         willClose: () => {
    //           // window.history.back();
    //           if (window.location.href.includes('/admin/')) {
    //             window.location.href = '/'; // Redirect to home page for admin
    //           } else {
    //             window.history.back(); // Normal behavior for non-admin
    //           }
    //         }
    //       });
    //     }




    //   }
    // }

    if (this.show_form_warning && this.show_form_warning == 1) {
      if (this.user_type && this.user_type == 'student') {
        // Handle student case
      } else {
        if (this.user_type === 'school' || this.user_type === 'business') {
          Swal.fire({
            position: "center",
            allowOutsideClick: true,
            text: "Only registered students can submit Master application.",
            showConfirmButton: false,
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            customClass: {
              cancelButton: 'can-edu-btn-fill'
            },
            didRender: () => {
              const closeButton = document.createElement('div');
              closeButton.innerHTML = `
            <div style="position: absolute; top: 10px; right: 10px; cursor: pointer;">
              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
              </button>
            </div>
          `;
              closeButton.addEventListener('click', () => {
                handleBackNavigation();
              });
              Swal.getHtmlContainer().appendChild(closeButton);
            },
          }).then((result) => {
            if (result.isDismissed || result.isDenied) {
              handleBackNavigation();
            }
          });
        } else {
          const loginUrlWithParam = this.login_url + "?url=" + window.location.href;
          Swal.fire({
            position: "center",
            allowOutsideClick: true,
            showConfirmButton: false,
            showCancelButton: false,
            customClass: {
              popup: 'swal-custom-popup',
              text: 'swal-custom-text'
            },
            html: `
          <div class="swal-container" style="text-align: left;">
            <!-- Main Text -->
            <p class="swal-message mt-7" style="margin-bottom: 20px;">
              ${this.static_translations?.main_text ? this.static_translations?.main_text : ""}
            </p>

            <!-- Login Section -->
            <div class="swal-action" style="display: flex; align-items: center; justify-content: start;gap: 8px; margin-bottom: 10px;">
              <button class="can-edu-btn-fill login-btn">
                ${this.static_translations?.login_button_text ? this.static_translations?.login_button_text : "Login"}
              </button>
              <p class="swal-subtext">
                ${this.static_translations?.login_button_heading_text ? this.static_translations?.login_button_heading_text : ""}
              </p>
            </div>

            <!-- Register Section -->
            <div class="swal-action" style="display: flex; align-items: center; justify-content: start; gap: 8px;">
              <button class="can-edu-btn-fill register-btn">
                ${this.static_translations?.register_button_text ? this.static_translations?.register_button_text : "Register"}
              </button>
              <p class="swal-subtext">
                ${this.static_translations?.register_button_heading_text ? this.static_translations?.register_button_heading_text : ""}
              </p>
            </div>

            <!-- New Red Button for Closing -->
            <div class="swal-action" style="text-align: center; margin-top: 20px;">
              <button class="can-edu-btn-fill close-btn" style="background-color: red; color: white; padding: 10px 20px; border-radius: 5px; border: none; cursor: pointer;">
                ${this.static_translations?.close_button_text ? this.static_translations?.close_button_text : "Close"}
              </button>
            </div>
          </div>
        `,
            didRender: () => {
              document.querySelector('.register-btn').addEventListener('click', () => {
                window.location.href = this.register_url;
              });

              document.querySelector('.login-btn').addEventListener('click', () => {
                window.location.href = loginUrlWithParam;
              });

              const closeButton = document.createElement('div');
              closeButton.innerHTML = `
            <div style="position: absolute; top: 12px; right: 10px; cursor: pointer;">
              <button type="button" class="text-primary bg-transparent hover:bg-gray-200 hover:text-primary rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center" data-modal-hide="defaultModal">
                <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
              </button>
            </div>
          `;
              closeButton.addEventListener('click', () => {
                handleBackNavigation();
              });

              Swal.getHtmlContainer().appendChild(closeButton);

              document.querySelector('.close-btn').addEventListener('click', () => {
                handleBackNavigation();
              });
            },
            willClose: () => {
              handleBackNavigation();
            }
          });
        }
      }
    }

    function handleBackNavigation() {
      if (window.location.href.includes('/admin/') || document.referrer.includes('/admin/')) {
        window.location.href = '/'; // Redirect to home page for admin
      } else if (window.history.length > 1) {
        window.history.back(); // Normal behavior for non-admin
      } else {
        window.location.href = '/'; // Fallback if no history
      }
    }



  },
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