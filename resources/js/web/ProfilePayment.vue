<template>
  <section class="bg-white px-4 py-6 md:p-12 desktop:px-80">
    <h1 class="can-edu-h1 text-center">
      {{ static_translations?.review_page_title ? static_translations?.review_page_title : "" }}
    </h1>
    <p class="lg:text-lg mb-4 mt-8 lg:mb-8 text-center">
      {{
        static_translations?.description ? static_translations?.description : ""
      }}
    </p>
    <!--Form-->
    <form>
      <!-- <div>
                    <div class="py-4 space-y-2">
                        <h2 class="can-edu-h2">
                            {{
                                static_translations?.package_title
                                    ? static_translations?.package_title
                                    : ""
                            }}
                        </h2>
                        <p>
                            {{
                                JSON.parse(user)["free_subscription_days"]
                                    ? JSON.parse(user)["free_subscription_days"]
                                    : 0
                            }}
                            {{
                                static_translations?.subscription_day_text
                                    ? static_translations?.subscription_day_text
                                    : ""
                            }}
                        </p>
                        <p>
                            ${{ this.form.orderAmount }} ({{
                                JSON.parse(user)["free_subscription_days"]
                                    ? JSON.parse(user)["free_subscription_days"]
                                    : 0
                            }}
                            {{
                                static_translations?.subscription_day_fee_text
                                    ? static_translations?.subscription_day_fee_text
                                    : ""
                            }})
                        </p>
                    </div>
                </div> -->

      <div class="grid grid-cols-1 lg:grid-cols-2 place-items-center gap-6 xl:gap-12 px-4 py-12 sm:px-10">
        <!--Debit Card-->
        <div class="w-full">
          <div class="flex items-center">
            <input id="stripe" name="registration-package" type="radio"
              class="h-4 w-4 border-gray-300 accent-primaryRed" :class="position == 'rtl' ? 'ml-2' : 'ml-0'"
              @click="setPaymentMethod('stripe')" :checked="form.payment_method == 'stripe'" />
            <img class="w-14 ml-2" src="/images/stripe-logo.png" />
            <label for="stripe" class="ml-2 block font-medium text-black md:text-lg">{{
              static_translations?.stripe_payment_radio_title
                ? static_translations?.stripe_payment_radio_title
                : ""
            }}</label>
          </div>
          <div class="flex items-center">
            <input id="paypal" name="registration-package" type="radio"
              class="h-4 w-4 border-gray-300 accent-primaryRed" :class="position == 'rtl' ? 'ml-2' : 'ml-0'"
              @click="setPaymentMethod('paypal')" :checked="form.payment_method == 'paypal'" />
            <label for="paypal" class="ml-2 block font-medium text-black md:text-lg">
              <svg viewBox="0 0 157 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-[#635BFF]">
                <g clip-path="url(#clip0_6_187)">
                  <path
                    d="M6.89999 2C7.29999 0.3 7.79999 0 9.49999 0C11.5 0 13.5 0 15.6 0C18.2 0.1 20.8 0.1 23.4 0.3C24.9 0.4 26.4 0.9 27.8 1.5C31.1 2.9 32.9 6.5 32.3 10.3C31.5 16 27.9 19.1 22.6 20.7C20.1 21.4 17.6 21.6 15 21.7C14.6 21.7 14.3 21.7 13.9 21.7C11.8 21.8 11 22.4 10.4 24.4C9.79999 26.7 9.09999 28.9 8.49999 31.2C8.19999 32.4 7.89999 32.6 6.59999 32.6C4.79999 32.6 2.99999 32.6 1.29999 32.4C0.0999947 32.3 -0.200005 31.9 0.0999947 30.7L6.89999 2ZM15.3 15.6C17 15.6 19.3 14.9 21 14.1C22.3 13.5 23 12.5 23.2 11.1C23.6 8.9 22.9 7.2 21.2 6.6C19.4 5.9 17.4 5.8 15.5 6.2C14.8 6.4 14.3 6.8 14.2 7.5C13.7 9.3 13.2 11.1 12.9 12.9C12.5 15.1 13 15.6 15.3 15.6ZM59.6 40.3C59.2 41 58.8 41.7 58.5 42.4C58.3 43 58.6 43.5 59.2 43.5C60.8 43.5 62.5 43.5 64.1 43.5C65.6 43.5 66.6 42.9 67.4 41.7C68 40.7 68.6 39.6 69.2 38.6C75.2 28.5 81.2 18.3 87.2 8.2C87.4 7.9 87.5 7.7 87.7 7.3C85.7 7.3 83.9 7.4 82 7.3C80 7.2 78.7 8.1 77.7 9.8C75.3 14 72.9 18.1 70.5 22.2C70.3 22.5 70.1 22.8 69.8 23.1C69.7 23.1 69.7 23 69.6 23C69.5 22.7 69.4 22.3 69.4 22C68.7 17.7 68 13.4 67.3 9.1C67.1 8.1 66.3 7.3 65.2 7.3C63.9 7.3 62.5 7.4 61.2 7.3C59.4 7.2 59.1 8.1 59.3 9.5L63 33.2C63.1 33.7 63 34.2 62.7 34.6L59.6 40.3ZM44.9 32.7C45.1 31.7 45.2 31 45.4 30.1C44.9 30.4 44.6 30.6 44.3 30.8C42.1 32 40 33 37.6 33.4C33.8 34 30.2 31.9 29.4 28.4C28.7 25.5 29.8 22.3 32.3 20.5C34.6 18.8 37.3 18.1 40 17.7C42.6 17.3 45.1 17 47.7 16.8C48.5 16.7 48.6 16.4 48.6 15.7C48.4 13.9 47.2 12.9 45 12.7C42.2 12.5 39.4 13.2 36.7 13.9C36.2 14 35.7 14.2 35.1 14.4C35.1 14.1 35 13.9 35 13.7C35.1 12.4 35.1 11.1 35.2 9.9C35.2 9.4 35.3 8.9 35.9 8.7C41 7.6 46.1 7 51.3 8.1C51.6 8.2 52 8.3 52.3 8.4C55.8 9.6 57 11.5 56.3 15.1C55.3 20.1 54.2 25.2 53.1 30.2C53 30.7 52.8 31.2 52.6 31.7C52.2 32.4 51.6 32.9 50.8 32.9C48.9 32.7 47 32.7 44.9 32.7ZM47.4 21C46.4 21.1 45.4 21.1 44.6 21.3C43 21.6 41.5 21.9 40 22.3C38.6 22.7 37.9 23.8 37.6 25.2C37.3 26.8 38 27.9 39.6 28.2C41.8 28.6 43.8 28 45.6 27C45.9 26.8 46.2 26.6 46.3 26.3C46.6 24.5 47 22.8 47.4 21Z"
                    fill="#162E53"></path>
                  <path
                    d="M91.7 1.4C92.1 0.3 92.6 0 93.7 0C95.9 0 98.1 0 100.3 0C102.9 0.1 105.5 0.1 108.1 0.3C109.6 0.5 111.1 0.9 112.5 1.5C115.7 2.8 117.5 6.3 117.1 9.9C116.5 15.3 113.1 19.2 107.3 20.6C105 21.2 102.5 21.3 100.1 21.6C99.6 21.7 99.1 21.6 98.5 21.6C96.5 21.7 95.7 22.3 95.1 24.2C94.5 26.4 93.8 28.7 93.2 30.9C92.8 32.2 92.6 32.4 91.2 32.4C89.5 32.4 87.9 32.4 86.2 32.3C84.6 32.2 84.4 31.8 84.7 30.3L91.7 1.4ZM102.3 5.9C101.7 6 100.9 6 100.2 6.2C99.7 6.4 99.2 6.8 99 7.2C98.4 9.3 97.9 11.4 97.5 13.5C97.2 15 97.7 15.4 99.2 15.5C101.4 15.6 103.5 15 105.5 14.1C107.1 13.4 107.8 12.2 108 10.5C108.2 8 107.2 6.6 104.8 6.1C104 6 103.2 6 102.3 5.9ZM119.7 14.1C119.8 13 119.8 11.9 119.9 10.8C120.1 8.3 119.8 8.7 122.3 8.2C126.2 7.4 130.1 7.1 134.1 7.6C135.2 7.7 136.4 8 137.4 8.4C140.5 9.5 141.7 11.5 141.1 14.7C140.1 19.8 138.9 24.9 137.8 30C137.7 30.5 137.5 31.1 137.2 31.5C136.8 32 136.2 32.6 135.7 32.6C133.7 32.7 131.6 32.7 129.5 32.7C129.7 31.8 129.8 31 130 30.2C129.3 30.6 128.7 31 128 31.3C125.9 32.4 123.7 33.5 121.3 33.5C117.8 33.6 115.1 31.9 114.1 29C113.1 26 114.2 22.4 116.9 20.5C119.2 18.8 121.9 18.1 124.6 17.7C127.2 17.3 129.7 17.1 132.3 16.8C132.9 16.7 133.2 16.5 133.1 15.8C133 14 131.7 12.9 129.5 12.7C126.5 12.5 123.6 13.2 120.8 14C120.5 14.1 120.2 14.2 120 14.2C120 14.2 119.9 14.1 119.7 14.1ZM132 21C131.1 21.1 130.2 21.1 129.4 21.2C127.8 21.5 126.2 21.7 124.7 22.2C123.4 22.6 122.5 23.5 122.2 24.9C121.8 26.7 122.5 27.8 124.3 28.1C126.4 28.4 128.4 27.9 130.2 26.8C130.5 26.6 130.8 26.3 130.9 25.9C131.3 24.4 131.6 22.7 132 21ZM156.3 0.1C154.3 0.1 152.5 0.1 150.6 0.1C149 0.1 148.6 0.4 148.2 2L142 30.1C141.6 31.8 141.9 32.2 143.7 32.2C144.9 32.2 146.2 32.3 147.4 32.3C148.9 32.3 149.2 32.1 149.5 30.6L156.3 0.1Z"
                    fill="#1E6196"></path>
                </g>
                <defs>
                  <clipPath id="clip0_6_187">
                    <rect width="156.3" height="43.5" fill="white"></rect>
                  </clipPath>
                </defs>
              </svg>
              <!-- {{
                  static_translations?.paypal_payment_radio_title
                    ? static_translations?.paypal_payment_radio_title
                    : ""
                }} -->
            </label>
          </div>
          <div id="card-element" class="border border-primary rounded p-2 mt-2 mb-2"
            v-if="form.payment_method == 'stripe'">
            <div class="flex justify-center items-center">
              <div class="h-auto bg-white p-3 rounded-lg w-full">
                <div class="input_text relative mb-2">
                  <label class="block text-base lg:text-lg" :class="position == 'rtl'
                      ? 'right-0 left-auto'
                      : 'left-0 right-auto'
                    ">{{
                        static_translations?.card_holder_name_label
                          ? static_translations?.card_holder_name_label
                          : ""
                      }}</label>
                  <input type="text"
                    class="mt-1 w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="position == 'rtl'
                        ? 'border-r-[5px] rounded-r border-r-primary'
                        : 'border-l-[5px] rounded-l border-l-primary'
                      " :placeholder="static_translations?.card_holder_name_placeholder
                          ? static_translations?.card_holder_name_placeholder
                          : ''
                        " v-model="form.card_holder_name" />
                  <error :fieldName="'card_holder_name'" :validationErros="validationErros" />
                </div>
                <div class="input_text mb-2 relative">
                  <label class="block text-base lg:text-lg" :class="position == 'rtl'
                      ? 'right-0 left-auto'
                      : 'left-0 right-auto'
                    ">{{
                        static_translations?.card_no_input_label
                          ? static_translations?.card_no_input_label
                          : ""
                      }}</label>
                  <input type="text"
                    class="mt-1 w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="position == 'rtl'
                        ? 'border-r-[5px] rounded-r border-r-primary'
                        : 'border-l-[5px] rounded-l border-l-primary'
                      " :placeholder="static_translations?.card_no_input_placeholder
                          ? static_translations?.card_no_input_placeholder
                          : ''
                        " v-model="form.card_no" @keypress="restrictToNumbers($event, 16)" />
                  <error :fieldName="'card_no'" :validationErros="validationErros" />
                </div>
                <div class="input_text relative w-full mb-2">
                  <label class="block text-base lg:text-lg" 
                    :class="position == 'rtl' ? 'right-0 left-auto' : 'left-0 right-auto'">
                    {{ static_translations?.expiry_month_input_label || "" }}
                  </label>

                  <select 
                    class="mt-1 w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="position == 'rtl'
                      ? 'border-r-[5px] rounded-r border-r-primary'
                      : 'border-l-[5px] rounded-l border-l-primary'"
                    v-model="form.expiry_month">
                    <option value="" disabled>
                      {{ static_translations?.expiry_month_input_placeholder || "Select Month" }}
                    </option>
                    <option v-for="(month, index) in months" :key="index" :value="month.value">
                      {{ month.label }}
                    </option>
                  </select>

                  <error full_width="true" class="tooltip_full" :fieldName="'expiry_month'" :validationErros="validationErros" />
                </div>
                <div class="input_text relative w-full mb-2">
                  <label class="block text-base lg:text-lg" 
                    :class="position == 'rtl' ? 'right-0 left-auto' : 'left-0 right-auto'">
                    {{ static_translations?.expiry_year_input_label || "" }}
                  </label>

                  <select 
                    class="mt-1 w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="position == 'rtl'
                      ? 'border-r-[5px] rounded-r border-r-primary'
                      : 'border-l-[5px] rounded-l border-l-primary'"
                    v-model="form.expiry_year">
                    <option value="" disabled>
                      {{ static_translations?.expiry_year_input_placeholder || "Select Year" }}
                    </option>
                    <option v-for="year in futureYears" :key="year" :value="year">
                      {{ year }}
                    </option>
                  </select>

                  <error full_width="true" class="tooltip_full" :fieldName="'expiry_year'" :validationErros="validationErros" />
                </div>
                <div class="input_text relative w-full mb-2">
                  <div class="flex justify-between items-center">
                    <div>
                      <label class="block text-base lg:text-lg" :class="position == 'rtl'
                          ? 'right-0 left-auto'
                          : 'left-0 right-auto'
                        ">{{
                              static_translations?.cvc_input_label
                                ? static_translations?.cvc_input_label
                                : ""
                            }}
                      </label>
                    </div>
                    <div class="relative" @mouseleave="showTooltip = false">
                      <button type="button" @mouseenter="showTooltip = true" class="focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
</svg>

                      </button>
                      <div v-if="showTooltip"
                        class="absolute h-60 w-96 rounded-md bg-white right-0 shadow p-2 z-[1000]">
                        <img class="object-cover w-full h-full" src="/assets/images/img (1).png" alt="scooore" />
                      </div>
                    </div>
                  </div>
                  <input type="text"
                    class="mt-1 w-full focus:ring-primary focus:outline-none px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    :class="position == 'rtl'
                        ? 'border-r-[5px] rounded-r border-r-primary'
                        : 'border-l-[5px] rounded-l border-l-primary'
                      " :placeholder="static_translations?.cvc_input_placeholder
                            ? static_translations?.cvc_input_placeholder
                            : ''
                          " v-model="form.cvc" @keypress="restrictToNumbers($event, 4)" />
                  <error full_width="true" class="tooltip_full" :fieldName="'cvc'" :validationErros="validationErros" />
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
        <div class="mt-6 rounded-lg border bg-white h-fit w-full p-4 md:p-6 shadow-md md:mt-0">
          <div class="mb-2 flex justify-between">
            <p class="text-black">Package</p>
            <p class="text-black">{{ packageType }}</p>
          </div>
          <div class="mb-2 flex justify-between">
            <p class="text-black">Payment frequency</p>
            <p class="text-black">{{ paymentFrequency }}</p>
          </div>
          <div class="mb-2 flex justify-between">
            <p class="text-black">Price per month</p>
            <p class="text-black">${{ monthlyPrice.toFixed(2) }}</p>
          </div>
          <hr class="my-4" />
          <div class="flex justify-between">
            <p class="text-lg font-bold">Total</p>
            <div class="">
              <p class="mb-1 text-lg font-bold">${{ packagePrice }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-6 flex justify-center items-center">
        <button class="can-edu-btn-fill w-48 text-white whitespace-nowrap ml-2" type="button" @click="addUpdateForm()">
          {{
            static_translations?.confirm_button_text
              ? static_translations?.confirm_button_text
              : ""
          }}
        </button>
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
import ErrorHandling from "../ErrorHandling";
import Error from "./Error.vue";
import Swal from "sweetalert2";
export default {
  props: ["user", "payment_profile_translations", "position"],
  data() {
    return {
      showPopUpModal: false,
      popupMsg:'',
      redirect_url:'',
      packagePrice: null,
      monthlyPrice: null,
      packageType: null,
      paymentFrequency: null,
      showTooltip: false,
      loading: false,
      form: {
        card_holder_name: null,
        card_no: null,
        expiry_month: '',
        expiry_year: '',
        cvc: null,
        orderAmount: 0,
        payment_method: "stripe",
        static_translations: {},
      },
      futureYears: [],
      months: [
        { value: "01", label: "January" },
        { value: "02", label: "February" },
        { value: "03", label: "March" },
        { value: "04", label: "April" },
        { value: "05", label: "May" },
        { value: "06", label: "June" },
        { value: "07", label: "July" },
        { value: "08", label: "August" },
        { value: "09", label: "September" },
        { value: "10", label: "October" },
        { value: "11", label: "November" },
        { value: "12", label: "December" }
      ],
      validationErros: new ErrorHandling(),
    };
  },
  beforeUnmount() {
      document.removeEventListener("click", this.handleClickOutsidePopup);
  },
  mounted() {
    document.addEventListener("click", this.handleClickOutsidePopup);
    this.populateYears();
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
    populateYears() {
      const currentYear = new Date().getFullYear();
      this.futureYears = Array.from({ length: 10 }, (_, i) => currentYear + i);
    },
    async addUpdateForm() {
      this.processPayment();
      // if (this.form.payment_method === "stripe") {
      //     this.processPayment();
      // }
    },
    processPayment() {
      this.loading = true;
      axios
        .post(
          `${process.env.MIX_APP_URL}/process-registration-payment`,
          this.form
        )
        .then((response) => {
          if (response.data.status == "Success") {
            console.log(
              response.data.data.type,
              response.data.data.redirect_url
            );
            if (response?.data?.data?.type == "paypal") {
              window.location.href = response?.data?.data?.redirect_url;
            } else {
              this.showPopUpModal=true;
              this.popupMsg=response.data.message;
              if (response.data.data.type == 'school') {
                this.redirect_url = response.data.data.redirect_url;
              } else {
                this.redirect_url = "/";
              }
              // Swal.fire({
              //   title: "Success!",
              //   text: response.data.message,
              //   icon: "success",
              //   showConfirmButton: true,
              //   allowOutsideClick: false,
              // }).then(() => {
              //   if (response.data.data.type == 'school') {
              //     window.location.href = response.data.data.redirect_url;
              //   } else {
              //     window.location.href = "/";
              //   }
              // });
            }
          } else {
            Swal.fire({
              title: "Error!",
              text: response.data.message,
              icon: "error",
              showConfirmButton: true,
              allowOutsideClick: false,
            });
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
            Swal.fire({
              title: "Error!",
              text: error.response.data.message,
              icon: "error",
              showConfirmButton: true,
              allowOutsideClick: false,
            });
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
  },
  created() {
    let user = JSON.parse(this.user);
    this.packagePrice = user.package_price;
    this.paymentFrequency = user.payment_frequency;
    this.packageType = user?.registration_package?.package_type ?? "N/A";

    let registerPackage = user?.registration_package;
    console.log(user, registerPackage);
    this.form.orderAmount = user.package_price;
    this.static_translations = JSON.parse(this.payment_profile_translations);
    this.monthlyPrice = 0;

    if (registerPackage) {
      if (user.payment_frequency === "monthly") {
        this.monthlyPrice = registerPackage.monthly_price;
      } else if (user.payment_frequency === "quarterly") {
        this.monthlyPrice = registerPackage.quarterly_price;
      } else if (user.payment_frequency === "semi_annually") {
        this.monthlyPrice = registerPackage.semi_annually_price;
      } else if (user.payment_frequency === "annually") {
        this.monthlyPrice = registerPackage.annually_price;
      }
    }
  },
  components: { Error },
};
</script>
