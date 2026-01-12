<template>
    <section class="bg-white">
        <h1 class="can-edu-h1 text-center">
            {{ 
                user_type === "student"
                    ? "Welcome to the Paid Services page"
                    : static_translations?.title ? static_translations?.title : "" }}
        </h1>
        <!--Form-->
        <form>
            <div class="items-center">
                <div>
                    <!-- <div class="py-4 space-y-2">
                        <h2 class="can-edu-h2">
                            {{
                                static_translations?.package_title
                                    ? static_translations?.package_title
                                    : ""
                            }}
                        </h2>
                        <p>
                            {{ this.form.validity_days }}
                            {{
                                static_translations?.subscription_day_text
                                    ? static_translations?.subscription_day_text
                                    : ""
                            }}
                        </p>
                        <p>
                            ${{ this.form.orderAmount }} ({{
                                this.form.free_subscription_days
                            }}
                            {{
                                static_translations?.subscription_day_fee_text
                                    ? static_translations?.subscription_day_fee_text
                                    : ""
                            }})
                        </p>
                    </div> -->
                    <div class="pt-8">
                        <div v-if="user_type === 'student'" class="text-center mt-4 mb-2 flex flex-col justify-center items-center">
                            <p>
                                Please select the service(s) you need. Once you have checked that everything is correct, select "Confirm and pay"
                            </p>
                        </div>
                        <div class="text-center mt-4 mb-2 flex flex-col justify-center items-center">
                            <p>
                                {{
                                    user_type === "student"
                                        ? "Select a frequency. You can stop anytime"
                                        : static_translations?.member_ship_description
                                            ? static_translations?.member_ship_description
                                            : ""
                                }}
                            </p>
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
                                        class="cursor-pointer rounded font-FuturaMdCnBT text-base lg:text-lg px-3 py-2 border border-primary text-center whitespace-nowrap font-medium w-24 md:w-28"
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
                            <Error
                                fieldName="registration_package_id"
                                :validationErros="validationErros"
                            />
                            <div
                                class="isolate mx-auto mt-10 grid max-w-md grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-3"
                            >
                                <div
                                    class="rounded-3xl p-6 xl:p-6 border hover:ring-2 hover:ring-primary bg-white"
                                    :class="
                                        package_type == regPackage?.package_type
                                            ? 'ring-2 ring-primary'
                                            : ''
                                    "
                                    v-for="(
                                        regPackage, i
                                    ) in sortedPackages"
                                    :key="i"
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
                                    <p
                                        class="mt-4 text-sm leading-6 text-black"
                                    >
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
                                                    payment_frequency ==
                                                    'monthly'
                                                "
                                            >
                                                ${{ regPackage?.monthly_price }}
                                            </template>
                                            <template
                                                v-else-if="
                                                    payment_frequency ==
                                                    'quarterly'
                                                "
                                            >
                                                ${{
                                                    regPackage?.quarterly_price
                                                }}
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
                                                    payment_frequency ==
                                                    'annually'
                                                "
                                            >
                                                ${{
                                                    regPackage?.annually_price
                                                }}
                                            </template>
                                        </span>

                                        <span
                                            class="text-sm font-semibold leading-6 text-black"
                                            >/month</span
                                        >
                                    </p>
                                    <!-- <a
                                        href="#"
                                        aria-describedby="tier-startup"
                                        class="can-edu-btn-fill w-full block text-white whitespace-nowrap"
                                        @click.prevent="
                                            updatePackageForm(
                                                'package_type',
                                                regPackage
                                            )
                                        "
                                        >Select plan</a
                                    > -->
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
                        </div>
                    </div>
                </div>

                <div>
                    <div class=" mx-auto">
                        <div class="grid grid-cols-1 lg:grid-cols-2 place-items-center gap-6 xl:gap-12 px-4 py-12 sm:px-10">
                            <!--Debit Card-->
                            <div
                                class="flex justify-between items-center w-full"
                            >
                                <div class="w-full">
                                    <div class="flex items-center">
                                        <input
                                            id="paypal"
                                            name="registration-package"
                                            type="radio"
                                            class="h-4 w-4 border-gray-300 accent-primaryRed"
                                            :class="
                                                position == 'rtl'
                                                    ? 'ml-2'
                                                    : 'ml-0'
                                            "
                                            @click="setPaymentMethod('paypal')"
                                            :checked="
                                                form.payment_method == 'paypal'
                                            "
                                        />
                                        <label
                                            for="paypal"
                                            class="ml-2 block font-medium text-black md:text-lg"
                                            >
                                            <svg viewBox="0 0 157 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-[#635BFF]">
                                                <g clip-path="url(#clip0_6_187)">
                                                    <path d="M6.89999 2C7.29999 0.3 7.79999 0 9.49999 0C11.5 0 13.5 0 15.6 0C18.2 0.1 20.8 0.1 23.4 0.3C24.9 0.4 26.4 0.9 27.8 1.5C31.1 2.9 32.9 6.5 32.3 10.3C31.5 16 27.9 19.1 22.6 20.7C20.1 21.4 17.6 21.6 15 21.7C14.6 21.7 14.3 21.7 13.9 21.7C11.8 21.8 11 22.4 10.4 24.4C9.79999 26.7 9.09999 28.9 8.49999 31.2C8.19999 32.4 7.89999 32.6 6.59999 32.6C4.79999 32.6 2.99999 32.6 1.29999 32.4C0.0999947 32.3 -0.200005 31.9 0.0999947 30.7L6.89999 2ZM15.3 15.6C17 15.6 19.3 14.9 21 14.1C22.3 13.5 23 12.5 23.2 11.1C23.6 8.9 22.9 7.2 21.2 6.6C19.4 5.9 17.4 5.8 15.5 6.2C14.8 6.4 14.3 6.8 14.2 7.5C13.7 9.3 13.2 11.1 12.9 12.9C12.5 15.1 13 15.6 15.3 15.6ZM59.6 40.3C59.2 41 58.8 41.7 58.5 42.4C58.3 43 58.6 43.5 59.2 43.5C60.8 43.5 62.5 43.5 64.1 43.5C65.6 43.5 66.6 42.9 67.4 41.7C68 40.7 68.6 39.6 69.2 38.6C75.2 28.5 81.2 18.3 87.2 8.2C87.4 7.9 87.5 7.7 87.7 7.3C85.7 7.3 83.9 7.4 82 7.3C80 7.2 78.7 8.1 77.7 9.8C75.3 14 72.9 18.1 70.5 22.2C70.3 22.5 70.1 22.8 69.8 23.1C69.7 23.1 69.7 23 69.6 23C69.5 22.7 69.4 22.3 69.4 22C68.7 17.7 68 13.4 67.3 9.1C67.1 8.1 66.3 7.3 65.2 7.3C63.9 7.3 62.5 7.4 61.2 7.3C59.4 7.2 59.1 8.1 59.3 9.5L63 33.2C63.1 33.7 63 34.2 62.7 34.6L59.6 40.3ZM44.9 32.7C45.1 31.7 45.2 31 45.4 30.1C44.9 30.4 44.6 30.6 44.3 30.8C42.1 32 40 33 37.6 33.4C33.8 34 30.2 31.9 29.4 28.4C28.7 25.5 29.8 22.3 32.3 20.5C34.6 18.8 37.3 18.1 40 17.7C42.6 17.3 45.1 17 47.7 16.8C48.5 16.7 48.6 16.4 48.6 15.7C48.4 13.9 47.2 12.9 45 12.7C42.2 12.5 39.4 13.2 36.7 13.9C36.2 14 35.7 14.2 35.1 14.4C35.1 14.1 35 13.9 35 13.7C35.1 12.4 35.1 11.1 35.2 9.9C35.2 9.4 35.3 8.9 35.9 8.7C41 7.6 46.1 7 51.3 8.1C51.6 8.2 52 8.3 52.3 8.4C55.8 9.6 57 11.5 56.3 15.1C55.3 20.1 54.2 25.2 53.1 30.2C53 30.7 52.8 31.2 52.6 31.7C52.2 32.4 51.6 32.9 50.8 32.9C48.9 32.7 47 32.7 44.9 32.7ZM47.4 21C46.4 21.1 45.4 21.1 44.6 21.3C43 21.6 41.5 21.9 40 22.3C38.6 22.7 37.9 23.8 37.6 25.2C37.3 26.8 38 27.9 39.6 28.2C41.8 28.6 43.8 28 45.6 27C45.9 26.8 46.2 26.6 46.3 26.3C46.6 24.5 47 22.8 47.4 21Z" fill="#162E53"></path><path d="M91.7 1.4C92.1 0.3 92.6 0 93.7 0C95.9 0 98.1 0 100.3 0C102.9 0.1 105.5 0.1 108.1 0.3C109.6 0.5 111.1 0.9 112.5 1.5C115.7 2.8 117.5 6.3 117.1 9.9C116.5 15.3 113.1 19.2 107.3 20.6C105 21.2 102.5 21.3 100.1 21.6C99.6 21.7 99.1 21.6 98.5 21.6C96.5 21.7 95.7 22.3 95.1 24.2C94.5 26.4 93.8 28.7 93.2 30.9C92.8 32.2 92.6 32.4 91.2 32.4C89.5 32.4 87.9 32.4 86.2 32.3C84.6 32.2 84.4 31.8 84.7 30.3L91.7 1.4ZM102.3 5.9C101.7 6 100.9 6 100.2 6.2C99.7 6.4 99.2 6.8 99 7.2C98.4 9.3 97.9 11.4 97.5 13.5C97.2 15 97.7 15.4 99.2 15.5C101.4 15.6 103.5 15 105.5 14.1C107.1 13.4 107.8 12.2 108 10.5C108.2 8 107.2 6.6 104.8 6.1C104 6 103.2 6 102.3 5.9ZM119.7 14.1C119.8 13 119.8 11.9 119.9 10.8C120.1 8.3 119.8 8.7 122.3 8.2C126.2 7.4 130.1 7.1 134.1 7.6C135.2 7.7 136.4 8 137.4 8.4C140.5 9.5 141.7 11.5 141.1 14.7C140.1 19.8 138.9 24.9 137.8 30C137.7 30.5 137.5 31.1 137.2 31.5C136.8 32 136.2 32.6 135.7 32.6C133.7 32.7 131.6 32.7 129.5 32.7C129.7 31.8 129.8 31 130 30.2C129.3 30.6 128.7 31 128 31.3C125.9 32.4 123.7 33.5 121.3 33.5C117.8 33.6 115.1 31.9 114.1 29C113.1 26 114.2 22.4 116.9 20.5C119.2 18.8 121.9 18.1 124.6 17.7C127.2 17.3 129.7 17.1 132.3 16.8C132.9 16.7 133.2 16.5 133.1 15.8C133 14 131.7 12.9 129.5 12.7C126.5 12.5 123.6 13.2 120.8 14C120.5 14.1 120.2 14.2 120 14.2C120 14.2 119.9 14.1 119.7 14.1ZM132 21C131.1 21.1 130.2 21.1 129.4 21.2C127.8 21.5 126.2 21.7 124.7 22.2C123.4 22.6 122.5 23.5 122.2 24.9C121.8 26.7 122.5 27.8 124.3 28.1C126.4 28.4 128.4 27.9 130.2 26.8C130.5 26.6 130.8 26.3 130.9 25.9C131.3 24.4 131.6 22.7 132 21ZM156.3 0.1C154.3 0.1 152.5 0.1 150.6 0.1C149 0.1 148.6 0.4 148.2 2L142 30.1C141.6 31.8 141.9 32.2 143.7 32.2C144.9 32.2 146.2 32.3 147.4 32.3C148.9 32.3 149.2 32.1 149.5 30.6L156.3 0.1Z" fill="#1E6196"></path></g><defs><clipPath id="clip0_6_187"><rect width="156.3" height="43.5" fill="white"></rect></clipPath></defs>
                                            </svg>
                                            <!-- {{
                                                static_translations?.paypal_payment_radio_title
                                                    ? static_translations?.paypal_payment_radio_title
                                                    : ""
                                            }} -->
                                            </label
                                        >
                                    </div>
                                    <div class="flex items-center mb-4">
                                        <input
                                            id="stripe"
                                            name="registration-package"
                                            type="radio"
                                            class="border-gray-300 accent-primaryRed"
                                            :class="
                                                position == 'rtl'
                                                    ? 'ml-2'
                                                    : 'ml-0'
                                            "
                                            @click="setPaymentMethod('stripe')"
                                            :checked="
                                                form.payment_method == 'stripe'
                                            "
                                        />
                                        <img class="w-14 ml-2" src="/images/stripe-logo.png" />
                                        <label
                                            for="stripe"
                                            class="ml-2 block font-medium text-black md:text-lg"
                                            >{{
                                                static_translations?.stripe_payment_radio_title
                                                    ? static_translations?.stripe_payment_radio_title
                                                    : ""
                                            }}</label
                                        >
                                    </div>
                                    <div v-if="form.payment_method == 'stripe'">
                                        <div class="flex items-center gap-2 mb-4">
                                         <input
                                            id="stripe"
                                            name="registration-package"
                                            type="radio"
                                            class="border-gray-300 accent-primaryRed"
                                            :class="
                                                position == 'rtl'
                                                    ? 'ml-2'
                                                    : 'ml-0'
                                            "
                                        />
                                        <label
                                            class="block text-lg lg:text-xl text-primary font-FuturaMdCnBT  "
                                            >{{
                                                static_translations?.choose_from_existing_card
                                                    ? static_translations?.choose_from_existing_card
                                                    : ""
                                            }}</label
                                        >
                                        </div>
                                        <!-- class="h-12 pl-7 outline-none px-2 focus:border-blue-900 transition-all w-full border-b" -->
                                        <select
                                            @change="handleCard($event)"
                                            class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary my-2 focus:outline-none px-4 py-2 rounded border-gray-300"
                                            :class="
                                                position == 'rtl'
                                                    ? 'border-r-[5px] rounded-r border-r-primary'
                                                    : 'border-l-[5px] rounded-l border-l-primary'
                                            "
                                        >
                                            <option value="">Select</option>
                                            <option
                                                v-for="(singlCard, i) in cards"
                                                :value="singlCard?.id"
                                                :key="i"
                                            >
                                                ***{{
                                                    singlCard?.card_no?.substr(
                                                        singlCard?.card_no
                                                            ?.length - 4
                                                    )
                                                }}
                                            </option>
                                        </select>
                                    </div>

                                    <div
                                        id="card-element"
                                        class="border border-primary rounded p-2 mt-2 mb-2"
                                        v-if="
                                            form.orderAmount > 0 &&
                                            form.payment_method == 'stripe'
                                        "
                                    >
                                        <div
                                            class="flex justify-center items-center"
                                        >
                                            <div
                                                class="h-auto bg-white p-3 rounded-lg w-full"
                                            >
                                                <div
                                                    class="input_text relative mb-2"
                                                >
                                                    <label
                                                        class="block text-base lg:text-lg"
                                                        :class="
                                                            position == 'rtl'
                                                                ? 'right-0 left-auto'
                                                                : 'left-0 right-auto'
                                                        "
                                                        >{{
                                                            static_translations?.card_holder_name_label
                                                                ? static_translations?.card_holder_name_label
                                                                : ""
                                                        }}</label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="mt-1 w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                                        :class="
                                                            position == 'rtl'
                                                                ? 'border-r-[5px] rounded-r border-r-primary'
                                                                : 'border-l-[5px] rounded-l border-l-primary'
                                                        "
                                                        :placeholder="
                                                            static_translations?.card_holder_name_placeholder
                                                                ? static_translations?.card_holder_name_placeholder
                                                                : ''
                                                        "
                                                        v-model="
                                                            form.card_holder_name
                                                        "
                                                    />
                                                    <error
                                                        :fieldName="'card_holder_name'"
                                                        :validationErros="
                                                            validationErros
                                                        "
                                                    />

                                                </div>
                                                <div
                                                    class="input_text relative mb-2"
                                                >
                                                    <label
                                                        class="block text-base lg:text-lg"
                                                        :class="
                                                            position == 'rtl'
                                                                ? 'right-0 left-auto'
                                                                : 'left-0 right-auto'
                                                        "
                                                        >{{
                                                            static_translations?.card_no_input_label
                                                                ? static_translations?.card_no_input_label
                                                                : ""
                                                        }}</label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="mt-1 w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                                        :class="
                                                            position == 'rtl'
                                                                ? 'border-r-[5px] rounded-r border-r-primary'
                                                                : 'border-l-[5px] rounded-l border-l-primary'
                                                        "
                                                        :placeholder="
                                                            static_translations?.card_no_input_placeholder
                                                                ? static_translations?.card_no_input_placeholder
                                                                : ''
                                                        "
                                                        v-model="form.card_no"
                                                        @keypress="
                                                            restrictToNumbers(
                                                                $event,
                                                                16
                                                            )
                                                        "
                                                    />
                                                    <error
                                                        :fieldName="'card_no'"
                                                        :validationErros="
                                                            validationErros
                                                        "
                                                    />

                                                </div>
                                                    <div
                                                        class="input_text relative mb-2 w-full"
                                                    >
                                                    <label
                                                            class="block text-base lg:text-lg"
                                                            :class="
                                                                position ==
                                                                'rtl'
                                                                    ? 'right-0 left-auto'
                                                                    : 'left-0 right-auto'
                                                            "
                                                            >{{
                                                                static_translations?.expiry_month_input_label
                                                                    ? static_translations?.expiry_month_input_label
                                                                    : ""
                                                            }}</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="mt-1 w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                                            :class="
                                                                position ==
                                                                'rtl'
                                                                    ? 'border-r-[5px] rounded-r border-r-primary'
                                                                    : 'border-l-[5px] rounded-l border-l-primary'
                                                            "
                                                            :placeholder="
                                                                static_translations?.expiry_month_input_placeholder
                                                                    ? static_translations?.expiry_month_input_placeholder
                                                                    : ''
                                                            "
                                                            data-slots="my"
                                                            v-model="
                                                                form.expiry_month
                                                            "
                                                            @keypress="
                                                                restrictToNumbers(
                                                                    $event,
                                                                    2
                                                                )
                                                            "
                                                        />
                                                        <error
                                                            full_width="true"
                                                            class="tooltip_full"
                                                            :fieldName="'expiry_month'"
                                                            :validationErros="
                                                                validationErros
                                                            "
                                                        />

                                                    </div>
                                                    <div
                                                        class="input_text relative w-full"
                                                    >
                                                    <label
                                                            class="block text-base lg:text-lg"
                                                            :class="
                                                                position ==
                                                                'rtl'
                                                                    ? 'right-0 left-auto'
                                                                    : 'left-0 right-auto'
                                                            "
                                                            >{{
                                                                static_translations?.expiry_year_input_label
                                                                    ? static_translations?.expiry_year_input_label
                                                                    : ""
                                                            }}</label
                                                        >
                                                        <input
                                                            type="text"
                                                            :placeholder="
                                                                static_translations?.expiry_year_input_placeholder
                                                                    ? static_translations?.expiry_year_input_placeholder
                                                                    : ''
                                                            "
                                                            class="mt-1 w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                                                            :class="
                                                                position ==
                                                                'rtl'
                                                                    ? 'border-r-[5px] rounded-r border-r-primary'
                                                                    : 'border-l-[5px] rounded-l border-l-primary'
                                                            "
                                                            data-slots="my"
                                                            v-model="
                                                                form.expiry_year
                                                            "
                                                            @keypress="
                                                                restrictToNumbers(
                                                                    $event,
                                                                    4
                                                                )
                                                            "
                                                        />
                                                        <error
                                                            full_width="true"
                                                            class="tooltip_full"
                                                            :fieldName="'expiry_year'"
                                                            :validationErros="
                                                                validationErros
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="input_text relative mb-2 w-full"
                                                    >
                                                    <div class="flex justify-between items-center">
                                                        <div>
                                                          <label class=" block text-base lg:text-lg "
                                                            :class="
                                                                position ==
                                                                'rtl'
                                                                    ? 'right-0 left-auto'
                                                                    : 'left-0 right-auto'
                                                            "
                                                            >{{
                                                                static_translations?.cvc_input_label
                                                                    ? static_translations?.cvc_input_label
                                                                    : ""
                                                            }}
                                                          </label>
                                                        </div>
                                                        <div
                                                          class="relative"
                                                          @mouseleave="showTooltip = false"
                                                        >
                                                          <button
                                                          type="button"
                                                            @mouseenter="showTooltip = true"
                                                            class="focus:outline-none"
                                                          >
                                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
</svg>

                                                          </button>
                                                          <div
                                                            v-if="showTooltip"
                                                            class="absolute h-60 w-96 rounded-md bg-white right-0 shadow p-2 z-[1000]"
                                                          >
                                                            <img
                                                              class="object-cover w-full h-full"
                                                              src="/assets/images/img (1).png"
                                                              alt="asdasd"
                                                            />
                                                          </div>
                                                        </div>
                                                    </div>
                                                        <!-- class="h-12 pl-7 outline-none px-2 focus:border-blue-900 transition-all w-full border-b" -->
                                                        <input
                                                            type="text"
                                                            class="mt-1 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded text-base lg:text-lg border-gray-300"
                                                            :class="
                                                                position ==
                                                                'rtl'
                                                                    ? 'border-r-[5px] rounded-r border-r-primary'
                                                                    : 'border-l-[5px] rounded-l border-l-primary'
                                                            "
                                                            :placeholder="
                                                                static_translations?.cvc_input_placeholder
                                                                    ? static_translations?.cvc_input_placeholder
                                                                    : ''
                                                            "
                                                            v-model="form.cvc"
                                                            @keypress="
                                                                restrictToNumbers(
                                                                    $event,
                                                                    4
                                                                )
                                                            "
                                                        />
                                                        <error
                                                            full_width="true"
                                                            class="tooltip_full"
                                                            :fieldName="'cvc'"
                                                            :validationErros="
                                                                validationErros
                                                            "
                                                        />

                            
                                                    </div>
                                                    <!-- <h3 class="can-edu-h3">Address</h3>
                                                    <div
                                                        class="input_text mb-2 relative w-full"
                                                    >
                                                        <label class=" block text-base lg:text-lg "
                                                            :class="
                                                                position ==
                                                                'rtl'
                                                                    ? 'right-0 left-auto'
                                                                    : 'left-0 right-auto'
                                                            "
                                                            >Street name and number</label>
                                                        <input type="text"
                                                            class="mt-1 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded text-base lg:text-lg border-gray-300"
                                                            :class="
                                                                position ==
                                                                'rtl'
                                                                    ? 'border-r-[5px] rounded-r border-r-primary'
                                                                    : 'border-l-[5px] rounded-l border-l-primary'
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="input_text mb-2 relative w-full"
                                                    >
                                                        <label class=" block text-base lg:text-lg "
                                                            :class="
                                                                position ==
                                                                'rtl'
                                                                    ? 'right-0 left-auto'
                                                                    : 'left-0 right-auto'
                                                            "
                                                            >City </label>
                                                            <select
                                                                class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary my-2 focus:outline-none px-4 py-2 rounded border-gray-300"
                                                                :class="
                                                                    position == 'rtl'
                                                                        ? 'border-r-[5px] rounded-r border-r-primary'
                                                                        : 'border-l-[5px] rounded-l border-l-primary'
                                                                "
                                                            >
                                                                <option value="">Select City</option>
                                                            </select>
                                                    </div>
                                                    <div
                                                        class="input_text mb-2 relative w-full"
                                                    >
                                                        <label class=" block text-base lg:text-lg "
                                                            :class="
                                                                position ==
                                                                'rtl'
                                                                    ? 'right-0 left-auto'
                                                                    : 'left-0 right-auto'
                                                            "
                                                            >Province  </label>
                                                            <select
                                                                class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary my-2 focus:outline-none px-4 py-2 rounded border-gray-300"
                                                                :class="
                                                                    position == 'rtl'
                                                                        ? 'border-r-[5px] rounded-r border-r-primary'
                                                                        : 'border-l-[5px] rounded-l border-l-primary'
                                                                "
                                                            >
                                                                <option value="">Select Province </option>
                                                            </select>
                                                    </div>
                                                    <div
                                                        class="input_text mb-2 relative w-full"
                                                    >
                                                        <label class=" block text-base lg:text-lg "
                                                            :class="
                                                                position ==
                                                                'rtl'
                                                                    ? 'right-0 left-auto'
                                                                    : 'left-0 right-auto'
                                                            "
                                                            >Postal Code</label>
                                                        <input type="text"
                                                            class="mt-1 border w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded text-base lg:text-lg border-gray-300"
                                                            :class="
                                                                position ==
                                                                'rtl'
                                                                    ? 'border-r-[5px] rounded-r border-r-primary'
                                                                    : 'border-l-[5px] rounded-l border-l-primary'
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="input_text mb-2 relative w-full"
                                                    >
                                                        <label class=" block text-base lg:text-lg "
                                                            :class="
                                                                position ==
                                                                'rtl'
                                                                    ? 'right-0 left-auto'
                                                                    : 'left-0 right-auto'
                                                            "
                                                            >Country </label>
                                                            <select
                                                                class="border text-base lg:text-lg text-gray-500 w-full bg-transparent focus:ring-primary my-2 focus:outline-none px-4 py-2 rounded border-gray-300"
                                                                :class="
                                                                    position == 'rtl'
                                                                        ? 'border-r-[5px] rounded-r border-r-primary'
                                                                        : 'border-l-[5px] rounded-l border-l-primary'
                                                                "
                                                            >
                                                                <option value="">Select Country</option>
                                                                <option value="" selected>Canada</option>
                                                            </select>
                                                    </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div v-if="form.payment_method == 'paypal'">
                                        <div
                                            class="max-w-md mx-auto p-8 bg-white rounded shadow-md mt-10"
                                        >
                                            <h3 class="text-primary mb-4">
                                                {{
                                                    static_translations?.paypal_description_title
                                                        ? static_translations?.paypal_description_title
                                                        : ""
                                                }}
                                            </h3>

                                            {{
                                                static_translations?.paypal_description
                                                    ? static_translations?.paypal_description
                                                    : ""
                                            }}
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <div class="mt-6 rounded-lg border bg-white h-full w-full p-4 md:p-6 shadow-md md:mt-0">
                                <div class="mb-2 flex justify-between">
                                    <p class="text-black">Package</p>
                                    <p class="text-black">{{ package_type }}</p>
                                </div>
                                <div class="mb-2 flex justify-between">
                                    <p class="text-black">Payment frequency</p>
                                    <p class="text-black">{{ formatPaymentFrequency(payment_frequency) }}</p>
                                </div>
                                <div class="mb-2 flex justify-between">
                                    <p class="text-black">Price per month</p>
                                    <p class="text-black">${{ getPerMonthPrice() }}</p>
                                </div>
                                <hr class="my-4">
                                <div class="flex justify-between">
                                    <p class="text-lg font-bold">Total</p>
                                    <div class="">
                                        <p class="mb-1 text-lg font-bold">
                                            ${{ form.orderAmount || 0 }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-center gap-2 mt-4">
                    <button
                        class="can-edu-btn-fill w-auto md:w-56 text-white whitespace-nowrap md:ml-auto"
                        @click="cancleAutoRenew"
                        type="button"
                        v-if="
                            form['is_auto_renew'] &&
                            (form['subscription_status'] == null ||
                                form['subscription_status'] == 'ok')
                        "
                    >
                        {{
                            static_translations?.cancel_auto_renew_text
                                ? static_translations?.cancel_auto_renew_text
                                : ""
                        }}
                    </button>
                    <button
                        type="button"
                        class="can-edu-btn-fill w-auto md:w-56 text-white whitespace-nowrap ml-2"
                        @click="resumeAutoRenew"
                        v-if="
                            form['is_auto_renew'] == 1 &&
                            form['subscription_status'] == 'cancel'
                        "
                    >
                        {{
                            static_translations?.resume_auto_renew_button_text
                                ? static_translations?.resume_auto_renew_button_text
                                : ""
                        }}
                    </button>
                    <button
                        class="can-edu-btn-fill w-auto md:w-56 text-white whitespace-nowrap ml-2"
                        type="button"
                        :disabled="loading"
                        @click="addUpdateForm()"
                    >
                        {{
                            static_translations?.confirm_button_text
                                ? static_translations?.confirm_button_text
                                : ""
                        }}
                    </button>
                </div>
            </div>
        </form>
        <div v-if="loading">
            <div id="form_preloader">
                <div id="form_status">
                    <div class="form_spinner">
                        <div class="form-double-bounce1"></div>
                        <div class="form-double-bounce2"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import ErrorHandling from "../ErrorHandling";
import Error from "./Error.vue";
export default {
    components: { Error },
    computed: {
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
        "user",
        "registeration_package",
        "card",
        "payment_profile_translations",
        "position",
        "user_type",
    ],
    data() {
        return {
            showTooltip: false,
            loading: false,
            form: {
                card_holder_name: null,
                card_no: null,
                expiry_month: null,
                expiry_year: null,
                cvc: null,
                orderAmount: 0,
                is_auto_renew: "",
                reg_package: "",
                subscription_status: "",
                customer_payment_method_id: "add_new_card",
                payment_method: "stripe",
                validity_days: 0,
                free_subscription_days: 0,
                static_translations: {},
                package_category: "",
            },
            registeration_packages: [],
            cards: [],
            package_type: "",
            payment_frequency: "annually",
            validationErros: new ErrorHandling(),
        };
    },
    methods: {
        formatPaymentFrequency(value) {
            const mapping = {
                monthly: "Monthly",
                quarterly: "Quarterly",
                semi_annually: "Semi Annually",
                annually: "Annually"
            };
            return mapping[value] || "N/A";
        },
        async addUpdateForm() {
            this.processPayment();
        },
        cancleAutoRenew() {
            axios
                .post(`${process.env.MIX_APP_URL}/cancel-subscription`, {})
                .then((response) => {
                    if (response.data.status == "Success") {
                        console.log(response.data);
                        if (response?.data?.data?.type == "paypal") {
                            window.location.href =
                                response?.data?.data?.redirect_url;
                        } else {
                            helper.swalSuccessMessage(response.data.message);
                            window.location.href = "/";
                        }
                    } else {
                        helper.swalErrorMessage(response.data.message);
                    }
                    this.loading = false;
                })
                .catch((error) => {
                    this.loading = 0;
                    this.validationErros = new ErrorHandling();
                    if (error.response && error.response.status == 422) {
                        this.validationErros.record(error.response.data.errors);
                    } else if (
                        error.response &&
                        error.response.data &&
                        error.response.data.status == "Error"
                    ) {
                        helper.swalErrorMessage(error.response.data.message);
                    }
                });
        },
        resumeAutoRenew() {
            axios
                .post(`${process.env.MIX_APP_URL}/resume-subscription`, {})
                .then((response) => {
                    if (response.data.status == "Success") {
                        if (response?.data?.data?.type == "paypal") {
                            window.location.href =
                                response?.data?.data?.redirect_url;
                        } else {
                            helper.swalSuccessMessage(response.data.message);
                            window.location.href = "/";
                        }
                    } else {
                        helper.swalErrorMessage(response.data.message);
                    }
                    this.loading = false;
                })
                .catch((error) => {
                    this.loading = 0;
                    this.validationErros = new ErrorHandling();
                    if (error.response && error.response.status == 422) {
                        this.validationErros.record(error.response.data.errors);
                    } else if (
                        error.response &&
                        error.response.data &&
                        error.response.data.status == "Error"
                    ) {
                        helper.swalErrorMessage(error.response.data.message);
                    }
                });
        },
        setAutoRenew(e) {
            alert(e.target.checked);
            this.form.is_auto_renew = e.target.checked ? 1 : 0;
        },
        processPayment() {
            this.loading = true;
            axios
                .post(`${process.env.MIX_APP_URL}/process-update-plan`, {
                    registration_package_id: this.form.reg_package,
                    customer_payment_method_id:
                        this.form.customer_payment_method_id,
                    card_holder_name: this.form.card_holder_name,
                    card_no: this.form.card_no,
                    expiry_month: this.form.expiry_month,
                    expiry_year: this.form.expiry_year,
                    cvc: this.form.cvc,
                    payment_method: this.form.payment_method,
                    package_type: this.package_type,
                    payment_frequency: this.payment_frequency,
                })
                .then((response) => {
                    if (response.data.status == "Success") {
                        if (response?.data?.data?.type == "paypal") {
                            window.location.href =
                                response?.data?.data?.redirect_url;
                        } else {
                            helper.swalSuccessMessage(response.data.message);
                            window.location.href = "/";
                        }
                    } else {
                        helper.swalErrorMessage(response.data.message);
                    }
                    this.loading = false;
                })
                .catch((error) => {
                    this.loading = 0;
                    this.validationErros = new ErrorHandling();
                    if (error.response && error.response.status == 422) {
                        this.validationErros.record(error.response.data.errors);
                    } else if (
                        error.response &&
                        error.response.data &&
                        error.response.data.status == "Error"
                    ) {
                        helper.swalErrorMessage(error.response.data.message);
                    }
                });
        },
        async setPaymentMethod(value) {
            this.form.payment_method = value;
        },
        restrictToNumbers(event, allowedLength) {
            const keyCode = event.which ? event.which : event.keyCode;
            const valid = keyCode >= 48 && keyCode <= 57; // Check if the key code is between 0 and 9
            const maxLengthReached = event.target.value.length >= allowedLength;

            if (!valid || maxLengthReached) {
                event.preventDefault();
            }
            return true;
        },
        handleCard(e) {
            const { value } = e.target;
            if (value == "") {
                this.form.card_holder_name = "";
                this.form.card_no = "";
                this.form.expiry_month = "";
                this.form.expiry_year = "";
                this.form.cvc = "";
                this.form.customer_payment_method_id = "add_new_card";
            } else {
                this.cards.filter((singleCard) => {
                    if (singleCard?.id == value) {
                        console.log(singleCard);
                        this.form.card_holder_name =
                            singleCard?.card_holder_name;
                        this.form.card_no = singleCard?.card_no;
                        this.form.expiry_month = singleCard?.exp_month;
                        this.form.expiry_year = singleCard?.exp_year;
                        this.form.cvc = singleCard?.cvc;
                        this.form.customer_payment_method_id = singleCard?.id;
                    }
                });
            }
        },
        updatePackageForm(field, value) {
            if (field == "payment_frequency") {
                this[field] = value;
                this.package_type = "";
                this.form.reg_package = '';
                this.form.orderAmount = 0;
            }
            if (field == "package_type") {
                this.package_type = value.package_type;
                this.form.reg_package = value.id;
                this.regPackage = value;
                this.form.orderAmount =
                    this.payment_frequency == "monthly"
                        ? value?.monthly_price
                        : this.payment_frequency == "quarterly"
                        ? 3 * value?.quarterly_price
                        : this.payment_frequency == "semi_annually"
                        ? 6 * value?.semi_annually_price
                        : this.payment_frequency == "annually"
                        ? 12 * value?.annually_price
                        : "";
                console.log(value);
                console.log(this.payment_frequency, this.form.orderAmount);
            }
        },
        getPerMonthPrice() {
        if (!this.regPackage) return 0;
        
        if (this.payment_frequency == "monthly") {
            return this.regPackage.monthly_price || 0;
        } else if (this.payment_frequency == "quarterly") {
            return this.regPackage.quarterly_price || 0;
        } else if (this.payment_frequency == "semi_annually") {
            return this.regPackage.semi_annually_price || 0;
        } else if (this.payment_frequency == "annually") {
            return this.regPackage.annually_price || 0;
        }
        
        return 0;
    }
    },
    created() {
        this.registeration_packages = JSON.parse(this.registeration_package);
        this.cards = JSON.parse(this.card);

        this.form.is_auto_renew = JSON.parse(this.user)["is_auto_renew"];
        this.form.reg_package = JSON.parse(this.user)[
            "registration_package_id"
        ];
        this.form.subscription_status = JSON.parse(this.user)[
            "subscription_status"
        ];

        this.form.validity_days = JSON.parse(this.user)["registration_package"][
            "package_validity_days"
        ];
        this.form.package_category = JSON.parse(this.user)[
            "registration_package"
        ]["package_category"];

        this.form.free_subscription_days = JSON.parse(this.user)[
            "registration_package"
        ]["free_subscription_days"];
        this.payment_frequency = JSON.parse(this.user)["payment_frequency"];
        this.package_type = JSON.parse(this.user)["registration_package"][
            "package_type"
        ];
        this.form.payment_method = JSON.parse(this.user)["payment_method"];
        let regPackage = JSON.parse(this.user)["registration_package"];
        this.form.orderAmount =
            this.payment_frequency == "monthly"
                ? regPackage?.monthly_price
                : this.payment_frequency == "quarterly"
                ? 3 * regPackage?.quarterly_price
                : this.payment_frequency == "semi_annually"
                ? 6 * regPackage?.semi_annually_price
                : this.payment_frequency == "annually"
                ? 12 * regPackage?.annually_price
                : "";
        console.log(this.form.orderAmount);
        this.static_translations = JSON.parse(
            this.payment_profile_translations
        );
    },
};
</script>
