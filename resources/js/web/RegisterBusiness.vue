<template>
    <div
        class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8"
    >
        <div class="w-full">
            <div class="border-b-4 pb-2 border-primary mb-4">
                <h1 class="can-edu-h1">
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
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
            <div
                class="w-full rounded p-4 mt-2"
            >
                <p
                    class="text-black"
                    v-html="
                        page_settings?.page_detail?.length > 0
                            ? page_settings?.page_detail[0]
                                  ?.description
                            : ''
                    "
                ></p>
            </div>
            <div class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                <h2 class="can-edu-h2 mb-0 text-white normal-case">
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                        ? bussiness_setting?.register_business_detail[0]
                              ?.registration_package_heading_text
                        : "Business categories / Industry sectors"
                    }}
                </h2>
            </div>
            <div class="">
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
            <div class="my-4 relative">
                <label class="text-lg">Auto-renew (Cancel anytime)</label>
                :
                <input type="checkbox" v-model="is_auto_renew" />
                <error
                    fieldName="is_auto_renew"
                    :validationErros="errors"
                />
            </div>
            <!-- <p>If, for whatever reason, you do not feel that we delivered the promised services to your full satisfaction, we will give you a full refund of your subscription fee. You have 30 days to decide</p> -->
            <!-- <ul class="flex flex-wrap mb-4">
                <li
                    class="mr-1 md:mr-2 mb-2"
                    v-for="(language, key) in languages"
                    :key="language.id"
                >
                    <a
                        @click.prevent="changeLanguageTab(language)"
                        href="#"
                        :class="[
                            'inline-block py-1 md:py-2 px-2 md:px-4 text-primary border border-primary rounded  font-FuturaMdCnBT text-lg font-medium hover:text-white hover:bg-primary active:text-white active:bg-primary',
                            (activeTab == null && language.is_default) ||
                            activeTab == language.id
                                ? 'text-white bg-primary active'
                                : '',
                            errors.has(`business_name.` + key)
                                ? 'bg-red-600 text-white hover:text-white'
                                : '',
                        ]"
                        >{{ language.name }}</a
                    >
                </li>
            </ul> -->
            <div class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                <h2 class="can-edu-h2 mb-0 text-white normal-case">
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                        ? bussiness_setting?.register_business_detail[0]
                              ?.business_profile_heading_text
                        : "Business categories / Industry sectors"
                    }}
                </h2>
            </div>
            <div
                class="relative"
                v-for="(language, key) in languages"
                :key="language.id"
                :class="
                    (activeTab == null && language.is_default) ||
                    activeTab == language.id
                        ? 'block'
                        : 'hidden'
                "
            >
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.name_lable
                            : "Business name"
                    }}
                    <span class="text-primary">*</span>
                </label>
                <input
                name="business_name"
                    :key="key"
                    v-modal="business_name"
                    @input="handleNameInput($event.target.value, key)"
                    type="text"
                    :placeholder="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]?.name_placeholder
                                ? bussiness_setting?.register_business_detail[0]?.name_placeholder
                                : ''
                            : 'Business name'
                    "
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                    :value="
                        business_name && business_name[key]
                            ? business_name[key]
                            : ''
                    "
                />
                <error
                    :fieldName="'business_name.' + key"
                    :validationErros="errors"
                />
            </div>
            <div
                class="relative mt-4"
                v-for="(language, key) in languages"
                :key="language.id"
                :class="
                    (activeTab == null && language.is_default) ||
                    activeTab == language.id
                        ? 'block'
                        : 'hidden'
                "
            >
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.description_lable
                            : "Business description"
                    }}
                    <span class="text-primary">*</span>
                </label>
                <textarea
                name="description"
                    :key="key"
                    rows="6"
                    @input="handleDescInput($event.target.value, key)"
                    :placeholder="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]?.description_placeholder
                                ? bussiness_setting?.register_business_detail[0]?.description_placeholder
                                : ''
                            : ''
                    "
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                    :value="
                        description && description[key] ? description[key] : ''
                    "
                ></textarea>
                <error
                    :fieldName="'description.' + key"
                    :validationErros="errors"
                />
            </div>
            <div
                class="relative mt-4"
                v-for="(language, key) in languages"
                :key="language.id"
                :class="
                    (activeTab == null && language.is_default) ||
                    activeTab == language.id
                        ? 'block'
                        : 'hidden'
                "
            >
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.detail_description_lable
                            : "Business description"
                    }}
                    <span class="text-primary">*</span>
                </label>
                <textarea
                    :key="key"
                    name="detail_description"
                    rows="6"
                    @input="handleDetailDescInput($event.target.value, key)"
                    :placeholder="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]?.detail_description_placeholder
                                ? bussiness_setting?.register_business_detail[0]?.detail_description_placeholder
                                : ''
                            : ''
                    "
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                    :value="
                        detail_description && detail_description[key] ? detail_description[key] : ''
                    "
                ></textarea>
                <error
                    :fieldName="'detail_description.' + key"
                    :validationErros="errors"
                />
            </div>
            <div class="relative mt-4">
                <label
                    class="block text-base lg:text-lg"
                    for=""
                    >{{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.keywords_label
                            : ""
                    }}</label
                >
                <textarea
                    rows="6"
                    :placeholder="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.keywords_placeholder
                            : ''
                    "
                    v-model="keywords"
                    name="keywords"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                ></textarea>
                <error :fieldName="'keywords'" :validationErros="errors" />
            </div>
            <div class="relative mt-4">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.contact_lable
                            : "Contact Person"
                    }}

                    <span class="text-primary">*</span>
                </label>
                <textarea
                    rows="2"
                    :placeholder="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]?.contact_placeholder
                                ? bussiness_setting?.register_business_detail[0]?.contact_placeholder
                                : ''
                            : ''
                    "
                    v-model="contact_name"
                    name="contact_name"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                ></textarea>
                <error :fieldName="'contact_name'" :validationErros="errors" />
            </div>
            <div class="relative mt-4">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.email_lable
                            : ""
                    }}
                    <span class="text-primary">*</span>
                </label>
                <input
                    type="email"
                    :placeholder="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]?.email_placeholder
                                ? bussiness_setting?.register_business_detail[0]?.email_placeholder
                                : ''
                            : ''
                    "
                    v-model="email"
                    name="email"
                    @change="validateEmail($event)"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                />
                <error fieldName="email" :validationErros="errors" />
                <small
                    class="text-red-600 text-sm mt-2"
                    v-if="emailValidationErro != ''"
                    v-text="emailValidationErro"
                ></small>
            </div>
            
            <div class="mt-4 relative">
                <label class="block text-base lg:text-lg">
                    {{ 
                        bussiness_setting?.register_business_detail.length > 0
                            ? bussiness_setting?.register_business_detail[0]?.password_label
                            : ''
                     }}
                     <span class="text-primary">*</span>
                </label>
                <input
                    type="password"
                    :placeholder="
                        bussiness_setting?.register_business_detail.length > 0
                            ? bussiness_setting?.register_business_detail[0]?.password_placeholder
                                ? bussiness_setting?.register_business_detail[0]?.password_placeholder
                                : ''
                            : ''
                    "
                    v-model="password"
                    name="password"
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
                        bussiness_setting?.register_business_detail.length > 0
                            ? bussiness_setting?.register_business_detail[0]?.confirm_password_label
                            : ''
                     }}
                     <span class="text-primary">*</span>
                </label>
                <input
                    type="password"
                    :placeholder="
                        bussiness_setting?.register_business_detail.length > 0
                            ? bussiness_setting?.register_business_detail[0]?.confirm_password_placeholder
                                ? bussiness_setting?.register_business_detail[0]?.confirm_password_placeholder
                                : ''
                            : ''
                    "
                    v-model="password_confirmation"
                    name="password_confirmation"
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

            <div class="relative mt-4">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.phone_lable
                            : ""
                    }}
                </label>
                <input
                    type="text"
                    :placeholder="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]?.phone_placeholder
                                ? bussiness_setting?.register_business_detail[0]?.phone_placeholder
                                : ''
                            : ''
                    "
                    v-model="phone"
                    name="phone"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                    @keypress="restrictToNumbers($event, 15)"
                />
                <error :fieldName="'phone'" :validationErros="errors" />
            </div>
            <div class="relative mt-4">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.address_lable
                            : ""
                    }}
                    <span class="text-primary">*</span>
                </label>
                <input
                    type="text"
                    :placeholder="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]?.address_placeholder
                                ? bussiness_setting?.register_business_detail[0]?.address_placeholder
                                : ''
                            : ''
                    "
                    v-model="address"
                    name="address"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                />
                <error :fieldName="'address'" :validationErros="errors" />
            </div>
            <div class="relative mt-8">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.website_url_lable
                            : ""
                    }}
                </label>
                <input
                    type="text"
                    :placeholder="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]?.website_url_placeholder
                                ? bussiness_setting?.register_business_detail[0]?.website_url_placeholder
                                : ''
                            : ''
                    "
                    v-model="website_url"
                    name="website_url"
                    :disabled="package_type == 'free'"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                />
                <error :fieldName="'website_url'" :validationErros="errors" />
            </div>

            <div class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                <h2 class="can-edu-h2 mb-0 text-white normal-case">
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                        ? bussiness_setting?.register_business_detail[0]
                              ?.package_section_title
                        : "Business categories / Industry sectors"
                    }}
                </h2>
            </div>
            
            <p>
                {{
                    bussiness_setting?.register_business_detail?.length > 0
                        ? bussiness_setting?.register_business_detail[0]?.business_category_text
                            ? bussiness_setting?.register_business_detail[0]?.business_category_text
                            : "Select up to three business categories (industry sectors) that you would like your business profile to be featured in. This gives you the flexibility to reach a diverse range of potential clients, select those categories (sectors) that you believe are most relevant to your brand"
                        : "Select up to three business categories (industry sectors) that you would like your business profile to be featured in. This gives you the flexibility to reach a diverse range of potential clients, select those categories (sectors) that you believe are most relevant to your brand"
                }}
            </p>
            <div class="relative mt-4">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.business_category_1_lable
                            : "Business Category 1"
                    }}
                    <span class="text-primary">*</span>
                </label>
                <select
                    name="business_catagory_1"
                    id=""
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                    v-model="business_catagory_1"
                >
                    <option value="">
                        {{
                            bussiness_setting?.register_business_detail
                                ?.length > 0
                                ? bussiness_setting?.register_business_detail[0]
                                      ?.business_category_1_placeholder
                                : ""
                        }}
                    </option>
                    <option
                        v-for="(
                            business_category, i
                        ) in business_categories_array"
                        :value="business_category?.id"
                        :key="i"
                    >
                        {{
                            business_category?.business_category_detail[0]?.name
                        }}
                    </option>
                </select>
                <error
                    :fieldName="'business_catagory_1'"
                    :validationErros="errors"
                />
            </div>
            <div class="relative mt-4">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.business_category_2_lable
                            : "Business Category 2"
                    }}
                </label>
                <select
                    v-model="business_catagory_2"
                    name="business_catagory_2"
                    id=""
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                >
                    <option value="">
                        {{
                            bussiness_setting?.register_business_detail
                                ?.length > 0
                                ? bussiness_setting?.register_business_detail[0]
                                      ?.business_category_2_placeholder
                                : ""
                        }}
                    </option>
                    <option
                        v-for="(
                            business_category, i
                        ) in business_categories_array"
                        :value="business_category?.id"
                        :key="i"
                    >
                        {{
                            business_category?.business_category_detail[0]?.name
                        }}
                    </option>
                </select>
                <error
                    :fieldName="'business_catagory_2'"
                    :validationErros="errors"
                />
            </div>
            <div class="relative mt-4">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.business_category_3_lable
                            : "Business Category 3"
                    }}
                </label>
                <select
                    v-model="business_catagory_3"
                    name="business_catagory_3"
                    id=""
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                >
                    <option value="">
                        {{
                            bussiness_setting?.register_business_detail
                                ?.length > 0
                                ? bussiness_setting?.register_business_detail[0]
                                      ?.business_category_3_placeholder
                                : ""
                        }}
                    </option>
                    <option
                        v-for="(
                            business_category, i
                        ) in business_categories_array"
                        :value="business_category?.id"
                        :key="i"
                    >
                        {{
                            business_category?.business_category_detail[0]?.name
                        }}
                    </option>
                </select>
                <error
                    :fieldName="'business_catagory_3'"
                    :validationErros="errors"
                />
            </div>
           
            <div class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                <h2 class="can-edu-h2 mb-0 text-white normal-case"> 
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                        ? bussiness_setting?.register_business_detail[0]?.media_title
                            ?  bussiness_setting?.register_business_detail[0]?.media_title
                            : "Media (Optional) title"
                        : "Media (Optional) title"
                    }}
                 </h2>
            </div>
            <div
                class="relative mt-4"
                v-for="(language, key) in languages"
                :key="language.id"
                :class="
                    (activeTab == null && language.is_default) ||
                    activeTab == language.id
                        ? 'block'
                        : 'hidden'
                "
            >
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.media_title_label
                            : ""
                    }}
                </label>
                <input
                    :key="key"
                    v-modal="media_section_title"
                    @input="handleMediaTitleInput($event.target.value, key)"
                    type="text"
                    name="media_section_title"
                    :placeholder="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]?.media_title_placeholder
                                ? bussiness_setting?.register_business_detail[0]?.media_title_placeholder
                                : ''
                            : ''
                    "
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                    :value="
                        media_section_title && media_section_title[key]
                            ? media_section_title[key]
                            : ''
                    "
                />
                <error
                    :fieldName="'media_section_title.' + key"
                    :validationErros="errors"
                />
            </div>
            <div
                class="relative mt-4"
                v-for="(language, key) in languages"
                :key="language.id"
                :class="
                    (activeTab == null && language.is_default) ||
                    activeTab == language.id
                        ? 'block'
                        : 'hidden'
                "
            >
                <label
                    for=""
                    class="block text-base lg:text-lg"
                >
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.media_description_label
                            : ""
                    }}
                </label>
                <textarea
                name="media_section_description"
                    :key="key"
                    v-modal="media_section_description"
                    @input="handleMediaDescriptionInput($event.target.value, key)"
                    rows="2"
                    :placeholder="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]?.media_description_placeholder
                                ? bussiness_setting?.register_business_detail[0]?.media_description_placeholder
                                : ''
                            : ''
                    "
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                    :value="
                        media_section_description && media_section_description[key]
                            ? media_section_description[key]
                            : ''
                    "
                ></textarea>
                <error
                    :fieldName="'media_section_description.' + key"
                    :validationErros="errors"
                />
            </div>
            <div class="relative mt-4">
                <label
                    class="block text-base lg:text-lg"
                    for=""
                    >{{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.welcome_video_label
                            : ""
                    }}</label
                >
                <input
                    type="text"
                    name="welcome_video"
                    :placeholder="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.welcome_video_placeholder
                            : ''
                    "
                    v-model="welcome_video"
                    :disabled="package_type == 'free'"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                />
                <error :fieldName="'welcome_video'" :validationErros="errors" />
            </div>
            <div class="relative mt-4">
                <label class="block text-base lg:text-lg" for=""
                    >{{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.file_lable
                            : ""
                    }}
                </label>
                <input
                    type="file"
                    name="image"
                    :placeholder="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.file_placeholder
                            : ''
                    "
                    @change="handleImageArray($event)"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                    multiple
                />
                <error :fieldName="'image'" :validationErros="errors" />
            </div>
            <div class="md:col-span-4">
                    <div class="flex flex-wrap gap-2">
                        <div
                            class="relative h-32 w-32 bg-gray-50 border"
                            v-for="(image, key) in image"
                            :key="key"
                        >
                            <img
                                :src=" image"
                                class="w-full h-full object-contain"
                            />
                            <span
                                @click="removeImage(key)"
                                class="absolute top-0 right-0 flex justify-center items-center cursor-pointer bg-white border border-primary rounded-full text-primary w-5 h-5"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-5 h-5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </span>
                        </div>
                    </div>
            </div>
            <div class="relative mt-4"> <!-- Increased margin-top -->
                <label for="logo" class="block text-base lg:text-lg">
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]?.logo_lable
                            : ""
                    }}
                    <span class="text-primary">*</span>
                </label>
                <!-- :id="`logo`" -->
                <input
                    :key="`logo`"
                    type="file"
                    :name="`logo`"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-4 rounded-r border-r-primary'
                            : 'border-l-4 rounded-l border-l-primary'
                    "
                    placeholder=" "
                    @input="handleImage($event)"
                />
                <error :fieldName="'logo'" :validationErros="errors" />
                    <img
                    v-if="logo"
                    :src="logo ? logo : ''"
                    style="height: 100px; width: 100px"
                />
            </div>
            <div class="px-4 py-1.5 sm:px-6 text-center bg-gradient-to-r from-primary via-red-800 to-secondary rounded-md my-6">
                <h2 class="can-edu-h2 mb-0 text-white normal-case"> 
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.social_media_title
                            : "Social Media (optional)"
                    }}
                </h2>
            </div>
            <div class="relative mt-4">
                <label
                    class="block text-base lg:text-lg"
                    for=""
                    >{{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.facebook_lable
                            : ""
                    }}</label
                >
                <input
                    type="text"
                    :placeholder="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.facebook_placeholder
                            : ''
                    "
                    v-model="facebook_url"
                    name="facebook_url"
                    class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="
                        position == 'rtl'
                            ? 'border-r-[5px] rounded-r border-r-primary'
                            : 'border-l-[5px] rounded-l border-l-primary'
                    "
                />
                <error :fieldName="'facebook_url'" :validationErros="errors" />
                <div class="relative mt-4">
                    <label
                        class="block text-base lg:text-lg"
                        for=""
                        >{{
                            bussiness_setting?.register_business_detail?.length > 0
                                ? bussiness_setting?.register_business_detail[0]
                                      ?.twitter_lable
                                : ""
                        }}</label
                    >
                    <input
                        type="text"
                        :placeholder="
                            bussiness_setting?.register_business_detail
                                ?.length > 0
                                ? bussiness_setting?.register_business_detail[0]
                                      ?.twitter_placeholder
                                : ''
                        "
                        v-model="twitter_url"
                        name="twitter_url"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position == 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                        "
                    />
                    <error
                        :fieldName="'twitter_url'"
                        :validationErros="errors"
                    />
                </div>
                <div class="relative mt-4">
                    <label
                        class="block text-base lg:text-lg"
                        for=""
                        >{{
                            bussiness_setting?.register_business_detail?.length > 0
                                ? bussiness_setting?.register_business_detail[0]
                                      ?.youtube_lable
                                : ""
                        }}</label
                    >
                    <input
                        type="text"
                        :placeholder="
                            bussiness_setting?.register_business_detail
                                ?.length > 0
                                ? bussiness_setting?.register_business_detail[0]
                                      ?.youtube_placeholder
                                : ''
                        "
                        v-model="youtube_url"
                        name="youtube_url"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position == 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                        "
                    />
                    <error
                        :fieldName="'youtube_url'"
                        :validationErros="errors"
                    />
                </div>
                <div class="relative mt-4">
                    <label
                        class="block text-base lg:text-lg"
                        for=""
                        >{{
                            bussiness_setting?.register_business_detail?.length > 0
                                ? bussiness_setting?.register_business_detail[0]
                                      ?.linkedin_lable
                                : ""
                        }}</label
                    >
                    <input
                        type="text"
                        :placeholder="
                            bussiness_setting?.register_business_detail
                                ?.length > 0
                                ? bussiness_setting?.register_business_detail[0]
                                      ?.linkedin_placeholder
                                : ''
                        "
                        v-model="linked_url"
                        name="linked_url"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position == 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                        "
                    />
                    <error
                        :fieldName="'linked_url'"
                        :validationErros="errors"
                    />
                </div>
                <div class="relative mt-4">
                    <label
                        class="block text-base lg:text-lg"
                        for=""
                        >{{
                            bussiness_setting?.register_business_detail?.length > 0
                                ? bussiness_setting?.register_business_detail[0]
                                      ?.linkedin_error
                                : ""
                        }}</label
                    >
                    <input
                        type="text"
                        :placeholder="
                            ''
                        "
                        v-model="other_social_url"
                        name="other_social_url"
                        class="w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        :class="
                            position == 'rtl'
                                ? 'border-r-[5px] rounded-r border-r-primary'
                                : 'border-l-[5px] rounded-l border-l-primary'
                        "
                    />
                    <error
                        :fieldName="'other_social_url'"
                        :validationErros="errors"
                    />
                </div>
            </div>

            <div
                class="w-full rounded p-4 mt-4 border-gray-300 bg-gray-50 border"
            >
                <p
                    class="text-black"
                    v-html="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.privacy_text_1
                            : ''
                    "
                    ref="privacyContent"
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
            <div class="mt-5 mb-2 text-center">
                <button
                    class="can-edu-btn-fill w-56 text-white whitespace-nowrap"
                    @click="recaptcha()"
                >
                    {{
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.proceed_button_text
                            : ""
                    }}
                </button>
            </div>
            <div
                class="w-full rounded mt-4 p-4 border-gray-300 bg-gray-50 border"
            >
                <p
                    class="can-edu-p"
                    v-html="
                        bussiness_setting?.register_business_detail?.length > 0
                            ? bussiness_setting?.register_business_detail[0]
                                  ?.privacy_text_2
                            : ''
                    "
                ></p>
            </div>

            <!-- <not-logged-in-modal
                :is_login_modal_setting="login_modal_setting"
                :is_logged_id="logged_id"
                :login_slug="login_slug"
                :register_slug="register_slug"
                :lang="lang"
            /> -->
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
                        <button type="button" class="text-gray-400 bg-white hover:bg-gray-200 hover:text-black rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
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
// ES6 Modules or TypeScript
import Swal from "sweetalert2";
import axios from "axios";
import NotLoggedInModal from "./modals/NotLoggedInModal.vue";
import ErrorHandling from "./../ErrorHandling";
import { mapState } from "vuex";
import { load } from "recaptcha-v3";
import vueRecaptcha from "vue3-recaptcha2";
import Error from "./Error.vue";
export default {
    components: { NotLoggedInModal, vueRecaptcha, Error },
    computed: {
        ...mapState({
            languages: (state) => state.languages.languages,
            business_categories: (state) =>
                state.business_categories.business_categories,
        }),
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
        "success_message",
        "register_bussiness_setting",
        "is_logged_id",
        "is_login_modal_setting",
        "registeration_package",
        "login_slug",
        "register_slug",
        "logged_in_customer",
        "position",
        "indicate_required_field",
        "lang",
        "business_categories",
        "lang_id",
        "reg_page_settings",
        "page_settings_detail",
    ],
    data() {
        return {
            submitted: false,
            showPopUpModal: false,
            popupMsg:'',
            bussiness_setting: null,
            logged_id: null,
            login_modal_setting: null,
            facebook_url: "",
            welcome_video: "",
            keywords: "",
            twitter_url: "",
            youtube_url: "",
            linked_url: "",
            other_social_url: "",
            image: [],
            contact_name: "",
            email: "",
            phone: "",
            address: "",
            logo: "",
            website_url: "",
            business_catagory_1: "",
            business_catagory_2: "",
            business_catagory_3: "",
            business_name: [],
            media_section_title: [],
            media_section_description: [],
            description: [],
            detail_description: [],
            business_categories_array: [],
            errors: new ErrorHandling(),
            error_message: "",
            activeTab: null,
            showRecaptcha: true,
            isEmailValid: true,
            toggelSubmitButton: false,
            emailValidationErro: "",
            reg_settings: null,
            page_settings: null,
            password: "",
            password_confirmation: "",
            is_auto_renew: true,
            registeration_packages: [],
            package_type: "",
            registration_package_id: "",
            payment_frequency: "annually",
        };
    },
    methods: {
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
        uploadImage(e) {
            var file = new FormData();
        file.append("file", e.target.files[0]);

        axios.post("/api/web/image_again_upload", file)
            .then((res) => {
                console.log('Upload response:', res.data);
                if (res.data.status === "Success") {
                    this.logo = res?.data; 
                    this.$toast.success("Image uploaded successfully!");
                } else {
                    this.$toast.error("Failed to upload image.");
                }
            })
            .catch((error) => {
                console.error('Upload error:', error);
                this.$toast.error("An error occurred while uploading the image.");
            });
    },
        togglePopUpModal() {
            this.showPopUpModal = !this.showPopUpModal;
            if (!this.showPopUpModal) {
                           window.location.href = "/";
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
                    window.location.href = "/";

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
            this.isEmailValid = true; 
            axios
                .post(`${process.env.MIX_WEB_API_URL}validate-business-email`, {
                    email: e.target.value,
                })
                .then((res) => {
                    if (res.data.status === "Success") {
                        this.emailValidationErro = "Email is already in use";
                        this.isEmailValid = false; // Prevent form submission
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
                });
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
        // registerBusines() {
        //     const data = {
        //         customer_id: this.logged_in_customer,
        //         facebook_url: this.facebook_url,
        //         twitter_url: this.twitter_url,
        //         youtube_url: this.youtube_url,
        //         linked_url: this.linked_url,
        //         image: this.image,
        //         contact_name: this.contact_name,
        //         email: this.email,
        //         phone: this.phone,
        //         address: this.address,
        //         website_url: this.website_url,
        //         business_catagory_1: this.business_catagory_1,
        //         business_catagory_2: this.business_catagory_2,
        //         business_catagory_3: this.business_catagory_3,
        //         business_name: this.business_name,
        //         description: this.description,
        //         is_web: 1,
        //     };
        //     let justLanguageId = [];
        //     this.languages.filter((res) => {
        //         justLanguageId.push(res.id);
        //     });
        //     data["language_id"] = justLanguageId;
        //     axios
        //         .post("/api/web/register-business", data)
        //         .then((res) => {
        //             if (res?.data?.status == "Success") {
        //                 helper.swalSuccessMessage(
        //                     "Your Business has been created"
        //                 );
        //                 let rbfields = [
        //                     "facebook_url",
        //                     "twitter_url",
        //                     "youtube_url",
        //                     "linked_url",
        //                     "contact_name",
        //                     "email",
        //                     "phone",
        //                     "address",
        //                     "website_url",
        //                     "business_catagory_1",
        //                     "business_catagory_2",
        //                     "business_catagory_3",
        //                     "rb_business_name",
        //                     "rb_business_index",
        //                     "rb_description",
        //                     "rb_description_index",
        //                 ];
        //                 rbfields?.map((f) => {
        //                     const savedField = localStorage.removeItem(
        //                         "rb_" + f
        //                     );
        //                 });
        //                 window.location.href = "/";
        //             }
        //             console.log(res.data.status);
        //         })
        //         .catch((error) => {
        //             this.error_message = "";
        //             this.errors = new ErrorHandling();
        //             if (error.response.status == 422) {
        //                 if (error.response.data.status == "Error") {
        //                     helper.swalErrorMessage(
        //                         error.response.data.message
        //                     );
        //                 } else {
        //                     this.errors.record(error.response.data.errors);
        //                 }
        //             }
        //         })
        //         .finally(() => (this.$parent.loading = false));
        // },
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
                        this.registerBusines();
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
        registerBusines() {
            if (!this.isEmailValid) {
                this.$toaster.error("Please enter a unique email before proceeding.");
                return; // Stop form submission
            }

            const data = {
                customer_id: this.logged_in_customer,
                facebook_url: this.facebook_url,
                welcome_video: this.welcome_video,
                keywords: this.keywords,
                twitter_url: this.twitter_url,
                youtube_url: this.youtube_url,
                linked_url: this.linked_url,
                other_social_url: this.other_social_url,
                image: this.image,
                contact_name: this.contact_name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
                is_auto_renew: this.is_auto_renew,
                package_type:this.package_type,
                registration_package_id: this.registration_package_id,
                payment_frequency:this.payment_frequency,
                phone: this.phone,
                address: this.address,
                logo: this.logo,
                website_url: this.website_url,
                business_catagory_1: this.business_catagory_1,
                business_catagory_2: this.business_catagory_2,
                business_catagory_3: this.business_catagory_3,
                business_name: this.business_name,
                media_section_title: this.media_section_title,
                media_section_description: this.media_section_description,
                description: this.description,
                detail_description: this.detail_description,
                is_web: 1,
            };

            let justLanguageId = [];
            this.languages.filter((res) => {
                justLanguageId.push(res.id);
            });
            data["language_id"] = justLanguageId;

            axios
                .post("/api/web/register-business", data)
                .then((res) => {
                    if (res?.data?.status == "Success") {
                        // helper.swalSuccessMessage("Your Business has been created");
                        let rbfields = [
                            "facebook_url",
                            "welcome_video",
                            "keywords",
                            "twitter_url",
                            "youtube_url",
                            "linked_url",
                            "other_social_url",
                            "contact_name",
                            "email",
                            "phone",
                            "address",
                            "logo",
                            "website_url",
                            "business_catagory_1",
                            "business_catagory_2",
                            "business_catagory_3",
                            "rb_business_name",
                            "rb_business_index",
                            "rb_media_section_title",
                            "rb_media_section_title_index",
                            "rb_media_section_description",
                            "rb_media_section_description_index",
                            "rb_description",
                            "rb_description_index",
                            "rb_detail_description",
                            "rb_detail_description_index",
                        ];
                        rbfields?.map((f) => {
                            localStorage.removeItem("rb_" + f);
                        });
                        this.showPopUpModal=true;
                        this.popupMsg=res.data.message;
                    }
                })
                .catch((error) => {
                    this.error_message = "";
                    this.errors = new ErrorHandling();
                    if (error.response.status == 422) {
                        if (error.response.data.status == "Error") {
                            helper.swalErrorMessage(error.response.data.message);
                        } else {
                            this.errors.record(error.response.data.errors);
                            this.focusOnFirstErrorInput(error.response.data.errors);
                        }
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

        updatePackageForm(field, value) {
            if (field == "payment_frequency") {
                this[field] = value;
            }
            if (field == "package_type") {
                if (value.package_type == 'free') {
                    this.website_url = "";
                    this.welcome_video = "";
                }
                this.package_type = value.package_type;
                this.registration_package_id = value.id;
            }
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        handleNameInput(val, i) {
            this.business_name[i] = val;
            localStorage.setItem("rb_business_name", val);
            localStorage.setItem("rb_business_index", i);
        },
        handleMediaTitleInput(val, i) {
            this.media_section_title[i] = val;
            localStorage.setItem("rb_media_section_title", val);
            localStorage.setItem("rb_media_section_title_index", i);
        },
        handleMediaDescriptionInput(val, i) {
            this.media_section_description[i] = val;
            localStorage.setItem("rb_media_section_description", val);
            localStorage.setItem("rb_media_section_description_index", i);
        },
        handleDescInput(val, i) {
            this.description[i] = val;
            localStorage.setItem("rb_description", val);
            localStorage.setItem("rb_description_index", i);
        },
        handleDetailDescInput(val, i) {
            this.detail_description[i] = val;
            localStorage.setItem("rb_detail_description", val);
            localStorage.setItem("rb_detail_description_index", i);
        },
        handleImage(e) {
            // console.log(e.target.files[0], key, language, mutationName);
            var file = new FormData();
            file.append("file", e.target.files[0]);
            axios.post("/api/web/image_again_upload", file).then((res) => {
                this.logo = res?.data;
                localStorage.setItem("rb_image", res?.data);
            });
        },
    removeImage(index) {
        this.image.splice(index, 1);
        },
        handleImageArray(e) {
            if (this.image.length + e.target.files.length > 7) {
                this.errors.record({image: ["You can only upload up to 7 images."]});
                return;
            }

            for (var i = 0; i < e.target.files.length; i++) {
                var file = new FormData();
                file.append("file", e.target.files[i]);
                axios.post("/api/web/image_again_upload", file).then((res) => {
                    this.image.push(res?.data);
                    // localStorage.setItem("rb_image", res?.data);
                });
            }
        },
    },
    created() {
        localStorage.removeItem("rb_business_name");
    localStorage.removeItem("rb_business_index");
    localStorage.removeItem("rb_media_section_title");
    localStorage.removeItem("rb_media_section_title_index");
    localStorage.removeItem("rb_media_section_description");
    localStorage.removeItem("rb_media_section_description_index");
    localStorage.removeItem("rb_description");
    localStorage.removeItem("rb_description_index");
    localStorage.removeItem("rb_detail_description");
    localStorage.removeItem("rb_detail_description_index");
        this.$store
            .dispatch("languages/fetchLanguages", {
                url: `${process.env.MIX_WEB_API_URL}languages?getAll=1`,
            })
            .then((res) => {
                let data = res.data.data;
                data.map((res, i) => {
                    this.business_name[i] = "";
                    this.media_section_title[i] = "";
                    this.media_section_description[i] = "";
                    this.description[i] = "";
                    this.detail_description[i] = "";
                    const savedBN = localStorage.getItem("rb_business_name");
                    const savedBNIndex =
                        localStorage.getItem("rb_business_index");

                    if (savedBN && savedBNIndex) {
                        this.business_name[parseInt(savedBNIndex)] = savedBN;
                    }

                    const savedMS = localStorage.getItem("rb_media_section_title");
                    const savedMSIndex =
                        localStorage.getItem("rb_media_section_title_index");

                    if (savedMS && savedMSIndex) {
                        this.media_section_title[parseInt(savedMSIndex)] = savedMS;
                    }

                    const savedMD = localStorage.getItem("rb_media_section_description");
                    const savedMDIndex =
                        localStorage.getItem("rb_media_section_description_index");

                    if (savedMD && savedMDIndex) {
                        this.media_section_description[parseInt(savedMDIndex)] = savedMD;
                    }

                    const savedBD = localStorage.getItem("rb_description");
                    const savedBDIndex = localStorage.getItem(
                        "rb_description_index"
                    );
                    if (savedBD && savedBDIndex) {
                        this.description[parseInt(savedBDIndex)] = savedBD;
                    }

                    const savedBDD = localStorage.getItem("rb_detail_description");
                    const savedBDDIndex = localStorage.getItem(
                        "rb_detail_description_index"
                    );
                    if (savedBDD && savedBDDIndex) {
                        this.detail_description[parseInt(savedBDDIndex)] = savedBDD;
                    }
                });
            });

        this.$store
            .dispatch("business_categories/fetchBusinessCategories", {
                url: `${process.env.MIX_WEB_API_URL}business-categories?limit=100000`,
            })
            .then((res) => {
                var data = res.data.data;
            });
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutsidePopup);
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutsidePopup);
        this.updateLinks();
        this.bussiness_setting = JSON.parse(this.register_bussiness_setting);
        this.logged_id = this.is_logged_id;
        this.login_modal_setting = JSON.parse(this.is_login_modal_setting);
        this.business_categories_array = JSON.parse(this.business_categories);
        this.reg_settings = JSON.parse(this.reg_page_settings);
        this.page_settings = JSON.parse(this.page_settings_detail);
        this.registeration_packages = JSON.parse(this.registeration_package);
        const defaultPackage = this.registeration_packages.find(
            pkg => pkg.is_default
        );
        if (defaultPackage) {
            this.package_type = defaultPackage.package_type;
            this.registration_package_id = defaultPackage.id;
        }
        this.activeTab = this.lang_id;
        let rbfields = [
            "facebook_url",
            "welcome_video",
            "keywords",
            "twitter_url",
            "youtube_url",
            "linked_url",
            "other_social_url",
            "contact_name",
            "email",
            "phone",
            "address",
            "logo",
            "website_url",
            "business_catagory_1",
            "business_catagory_2",
            "business_catagory_3",
            // "image",
        ];
        rbfields?.map((f) => {
            // const savedField = localStorage.getItem("rb_" + f);
            this[f] = "";
            // if (savedField) {
            //     this[f] = savedField;
            // }
        });
        this.business_name = [];
        this.media_section_title = [];
        this.media_section_description = [];
    this.description = [];
    this.detail_description = [];

    localStorage.removeItem("rb_business_name");
    localStorage.removeItem("rb_media_section_title");
    localStorage.removeItem("rb_media_section_description");
    localStorage.removeItem("rb_description");
    localStorage.removeItem("rb_detail_description");

    if (this.business_name && typeof this.business_name === 'object') {
        Object.keys(this.business_name).forEach((key) => {
            this.business_name[key] = "";
        });
    }

    if (this.media_section_title && typeof this.media_section_title === 'object') {
        Object.keys(this.media_section_title).forEach((key) => {
            this.media_section_title[key] = "";
        });
    }

    if (this.media_section_description && typeof this.media_section_description === 'object') {
        Object.keys(this.media_section_description).forEach((key) => {
            this.media_section_description[key] = "";
        });
    }

    if (this.description && typeof this.description === 'object') {
        Object.keys(this.description).forEach((key) => {
            this.description[key] = ""; 
        });
    }

    if (this.detail_description && typeof this.detail_description === 'object') {
        Object.keys(this.detail_description).forEach((key) => {
            this.detail_description[key] = ""; 
        });
    }
    },
    watch: {
        facebook_url(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("rb_facebook_url", newValue);
            }
        },
        welcome_video(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("rb_welcome_video", newValue);
            }
        },
        keywords(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("rb_keywords", newValue);
            }
        },
        twitter_url(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("rb_twitter_url", newValue);
            }
        },
        youtube_url(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("rb_youtube_url", newValue);
            }
        },
        linked_url(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("rb_linked_url", newValue);
            }
        },
        other_social_url(newValue, oldValue) {
            if (newValue && newValue != "") {
                localStorage.setItem("rb_other_social_url", newValue);
            }
        },
        contact_name(newValue, oldValue) {
            this.errors.has("contact_name") ? this.errors.clear("contact_name") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rb_contact_name", newValue);
            }
        },
        email(newValue, oldValue) {
            this.errors.has("email") ? this.errors.clear("email") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rb_email", newValue);
            }
        },
        password(newValue, oldValue) {
            this.errors.has("password") ? this.errors.clear("password") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rt_password", newValue);
            }
        },
        phone(newValue, oldValue) {
            this.errors.has("phone") ? this.errors.clear("phone") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rb_phone", newValue);
            }
        },
        address(newValue, oldValue) {
            this.errors.has("address") ? this.errors.clear("address") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rb_address", newValue);
            }
        },
        logo(newValue, oldValue) {
            this.errors.has("logo") ? this.errors.clear("logo") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rb_logo", newValue);
            }
        },
        website_url(newValue, oldValue) {
            this.errors.has("website_url") ? this.errors.clear("website_url") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rb_website_url", newValue);
            }
        },
        business_catagory_1(newValue, oldValue) {
            this.errors.has("business_catagory_1") ? this.errors.clear("business_catagory_1") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rb_business_catagory_1", newValue);
            }
        },
        business_catagory_2(newValue, oldValue) {
            this.errors.has("business_catagory_2") ? this.errors.clear("business_catagory_2") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rb_business_catagory_2", newValue);
            }
        },
        business_catagory_3(newValue, oldValue) {
            this.errors.has("business_catagory_3") ? this.errors.clear("business_catagory_3") : "";
            if (newValue && newValue != "") {
                localStorage.setItem("rb_business_catagory_3", newValue);
            }
        },
        "business_name": {
    handler(newValue) {
      Object.keys(newValue).forEach((key) => {
        if (this.errors.has(`business_name.${key}`)) {
          this.errors.clear(`business_name.${key}`);
        }
        if (newValue[key] && newValue[key] !== "") {
          localStorage.setItem(`become_sponsor_business_name_${key}`, newValue[key]);
        }
      });
    },
    deep: true, // Ensures Vue detects changes inside the object
  },
        "media_section_title": {
    handler(newValue) {
      Object.keys(newValue).forEach((key) => {
        if (this.errors.has(`media_section_title.${key}`)) {
          this.errors.clear(`media_section_title.${key}`);
        }
        if (newValue[key] && newValue[key] !== "") {
          localStorage.setItem(`become_sponsor_media_section_title_${key}`, newValue[key]);
        }
      });
    },
    deep: true, // Ensures Vue detects changes inside the object
  },
        "media_section_description": {
    handler(newValue) {
      Object.keys(newValue).forEach((key) => {
        if (this.errors.has(`media_section_description.${key}`)) {
          this.errors.clear(`media_section_description.${key}`);
        }
        if (newValue[key] && newValue[key] !== "") {
          localStorage.setItem(`become_sponsor_media_section_description_${key}`, newValue[key]);
        }
      });
    },
    deep: true, // Ensures Vue detects changes inside the object
  },
        "description": {
    handler(newValue) {
      Object.keys(newValue).forEach((key) => {
        if (this.errors.has(`description.${key}`)) {
          this.errors.clear(`description.${key}`);
        }
        if (newValue[key] && newValue[key] !== "") {
          localStorage.setItem(`become_sponsor_description_${key}`, newValue[key]);
        }
      });
    },
    deep: true, // Ensures Vue detects changes inside the object
  },
        "detail_description": {
    handler(newValue) {
      Object.keys(newValue).forEach((key) => {
        if (this.errors.has(`detail_description.${key}`)) {
          this.errors.clear(`detail_description.${key}`);
        }
        if (newValue[key] && newValue[key] !== "") {
          localStorage.setItem(`become_sponsor_detail_description_${key}`, newValue[key]);
        }
      });
    },
    deep: true, // Ensures Vue detects changes inside the object
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