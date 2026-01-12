<template>
    <section class="bg-white px-4 py-6 md:p-12 desktop:px-80">
        <p class="lg:text-lg mb-4 lg:mb-8">
            {{ form?.detail }}
        </p>
        <!--Form-->
        <form>
            <div>
                <div class="w-full mx-auto">
                    <div class="py-4 space-y-2">
                        <h1>Amount to Pay</h1>
                        <p>${{ form?.orderAmount }}</p>
                    </div>
                    <div>
                        <!--Debit Card-->
                        <div
                            class="flex justify-between items-center p-3 border-b"
                        >
                            <div class="w-full">
                                <div class="flex items-center">
                                    <input
                                        id="stripe"
                                        name="registration-package"
                                        type="radio"
                                        class="h-4 w-4 border-gray-300 accent-primaryRed"
                                        :class="
                                            position == 'rtl' ? 'ml-2' : 'ml-0'
                                        "
                                        @click="setPaymentMethod('stripe')"
                                        :checked="
                                            form.payment_method == 'stripe'
                                        "
                                    />
                                    <label
                                        for="stripe"
                                        class="ml-2 block font-medium text-gray-900 md:text-lg"
                                        >{{
                                            static_translations?.stripe_payment_radio_title
                                                ? static_translations?.stripe_payment_radio_title
                                                : ""
                                        }}</label
                                    >
                                </div>
                                <div class="flex items-center">
                                    <input
                                        id="paypal"
                                        name="registration-package"
                                        type="radio"
                                        class="h-4 w-4 border-gray-300 accent-primaryRed"
                                        :class="
                                            position == 'rtl' ? 'ml-2' : 'ml-0'
                                        "
                                        @click="setPaymentMethod('paypal')"
                                        :checked="
                                            form.payment_method == 'paypal'
                                        "
                                    />
                                    <label
                                        for="paypal"
                                        class="ml-2 block font-medium text-gray-900 md:text-lg"
                                        >{{
                                            static_translations?.paypal_payment_radio_title
                                                ? static_translations?.paypal_payment_radio_title
                                                : ""
                                        }}</label
                                    >
                                </div>
                                <div
                                    id="card-element"
                                    class="border border-primary rounded p-2 mt-2 mb-2"
                                    v-if="form.payment_method == 'stripe'"
                                >
                                    <div
                                        class="flex justify-center items-center"
                                    >
                                        <div
                                            class="h-auto bg-white p-3 rounded-lg"
                                        >
                                            <div
                                                class="input_text mt-6 relative"
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

                                                <span
                                                    class="absolute block text-base lg:text-lg -top-6"
                                                    :class="
                                                        position == 'rtl'
                                                            ? 'right-0 left-auto'
                                                            : 'left-0 right-auto'
                                                    "
                                                    >{{
                                                        static_translations?.card_holder_name_label
                                                            ? static_translations?.card_holder_name_label
                                                            : ""
                                                    }}</span
                                                >
                                                <i
                                                    class="absolute left-2 top-4 text-gray-400 fa fa-user"
                                                ></i>
                                            </div>
                                            <div
                                                class="input_text mt-8 relative"
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

                                                <span
                                                    class="absolute block text-base lg:text-lg -top-6"
                                                    :class="
                                                        position == 'rtl'
                                                            ? 'right-0 left-auto'
                                                            : 'left-0 right-auto'
                                                    "
                                                    >{{
                                                        static_translations?.card_no_input_label
                                                            ? static_translations?.card_no_input_label
                                                            : ""
                                                    }}</span
                                                >
                                                <i
                                                    class="absolute left-2 top-[14px] text-gray-400 text-sm fa fa-credit-card"
                                                ></i>
                                            </div>
                                            <div
                                                class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4"
                                            >
                                                <div
                                                    class="input_text relative w-full mb-4 md:mb-0"
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
                                                    <span
                                                        class="absolute block text-base lg:text-lg -top-6"
                                                        :class="
                                                            position == 'rtl'
                                                                ? 'right-0 left-auto'
                                                                : 'left-0 right-auto'
                                                        "
                                                        >{{
                                                            static_translations?.expiry_month_input_label
                                                                ? static_translations?.expiry_month_input_label
                                                                : ""
                                                        }}</span
                                                    >
                                                    <i
                                                        class="absolute left-2 top-4 text-gray-400 fa fa-calendar-o"
                                                    ></i>
                                                </div>
                                                <div
                                                    class="input_text relative w-full mb-4 md:mb-0"
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
                                                            static_translations?.expiry_year_input_placeholder
                                                                ? static_translations?.expiry_year_input_placeholder
                                                                : ''
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

                                                    <span
                                                        class="absolute block text-base lg:text-lg -top-6"
                                                        :class="
                                                            position == 'rtl'
                                                                ? 'right-0 left-auto'
                                                                : 'left-0 right-auto'
                                                        "
                                                        >{{
                                                            static_translations?.expiry_year_input_label
                                                                ? static_translations?.expiry_year_input_label
                                                                : ""
                                                        }}</span
                                                    >
                                                    <i
                                                        class="absolute left-2 top-4 text-gray-400 fa fa-calendar-o"
                                                    ></i>
                                                </div>
                                                <div
                                                    class="input_text relative w-full"
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

                                                    <span
                                                        class="absolute block text-base lg:text-lg -top-6"
                                                        :class="
                                                            position == 'rtl'
                                                                ? 'right-0 left-auto'
                                                                : 'left-0 right-auto'
                                                        "
                                                        >{{
                                                            static_translations?.cvc_input_label
                                                                ? static_translations?.cvc_input_label
                                                                : ""
                                                        }}</span
                                                    >
                                                    <i
                                                        class="absolute left-2 top-4 text-gray-400 fa fa-lock"
                                                    ></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="form.payment_method == 'paypal'">
                                    <div
                                        class="w-full mx-auto p-8 bg-white rounded shadow-md mt-10"
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="mt-4 space-x-5 md:space-x-10 flex justify-center items-center"
            >
                <button
                    class="can-edu-btn-fill w-56 text-white whitespace-nowrap ml-2"
                    type="button"
                    @click="addUpdateForm()"
                >
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
</template>

<script>
import ErrorHandling from "../ErrorHandling";
import Error from "./Error.vue";
export default {
    props: [
        "user",
        "payment_profile_translations",
        "position",
        "payment_to_be_done",
    ],
    data() {
        return {
            loading: false,
            form: {
                card_holder_name: null,
                card_no: null,
                expiry_month: null,
                expiry_year: null,
                cvc: null,
                orderAmount: 0,
                detail: "",
                proxima_id:"",
                payment_method: "stripe",
                paymentType:"proxima",
                static_translations: {},
            },
            validationErros: new ErrorHandling(),
        };
    },
    methods: {
        async addUpdateForm() {
            this.processPayment();
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
    },
    created() {
        this.form.orderAmount = JSON.parse(this.payment_to_be_done)[
            "quotation_amount"
        ];
        this.form.detail = JSON.parse(this.payment_to_be_done)[
            "quotation_detail"
        ];
        this.form.proxima_id = JSON.parse(this.payment_to_be_done)[
            "id"
        ];
        this.static_translations = JSON.parse(
            this.payment_profile_translations
        );
    },
    components: { Error },
};
</script>
