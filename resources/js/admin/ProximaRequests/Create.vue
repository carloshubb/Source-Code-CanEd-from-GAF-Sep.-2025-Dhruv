<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
        <header class="">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="can-edu-h1">Proxima request</h1>
                    <router-link
                        :to="{ name: 'admin.proxima_requests.index' }"
                        class="can-edu-btn-fill"
                    >
                        Back
                    </router-link>
                </div>
            </div>
        </header>
        <form class="px-4 md:px-6 lg:px-8 mt-4" @submit.prevent="addUpdateForm()">
            <div class="grid md:grid-cols-2 md:gap-6 my-5">
                <div class="relative z-0 w-full group">
                    <label for="name" class="block text-base lg:text-lg">Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        :value="form.name"
                        @input="updateForm('name', $event.target.value)"
                        disabled
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has('name')"
                        v-text="validationErros.get('name')"
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label for="phone" class="block text-base lg:text-lg">Phone</label>
                    <input
                        type="number"
                        name="phone"
                        id="phone"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        :value="form.phone"
                        @input="updateForm('phone', $event.target.value)"
                        disabled
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has('phone')"
                        v-text="validationErros.get('phone')"
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label for="email" class="block text-base lg:text-lg">Email</label>
                    <input
                        type="text"
                        name="email"
                        id="email"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        :value="form.email"
                        @input="updateForm('email', $event.target.value)"
                        disabled
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has('email')"
                        v-text="validationErros.get('email')"
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label class="text-base text-gray-700 font-medium" for="inquiry">Inquiry</label>
                    <p>{{ form.inquiry }}</p>
                </div>
                <div class="relative z-0 w-full group">
                    <label for="quotation_amount" class="block text-base lg:text-lg">Quotation amount</label>
                    <input
                        type="text"
                        name="quotation_amount"
                        id="quotation_amount"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        :value="form.quotation_amount"
                        @input="
                            updateForm('quotation_amount', $event.target.value)
                        "
                    />
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has('quotation_amount')"
                        v-text="validationErros.get('quotation_amount')"
                    ></p>
                </div>
                <div class="relative z-0 w-full group">
                    <label for="native_name" class="block text-base lg:text-lg">Quotation Detail</label>
                    <select
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        @input="updateForm('status', $event.target.value)"
                    >
                        <option
                            :selected="form.status == 'inquiry'"
                            value="inquiry"
                        >
                            Inquiry
                        </option>
                        <option
                            :selected="form.status == 'quotation_inquiry'"
                            value="quotation_inquiry"
                        >
                            Quotation Inquiry
                        </option>
                        <option :selected="form.status == 'paid'" value="paid">
                            Paid
                        </option>
                        <option
                            :selected="form.status == 'closed'"
                            value="closed"
                        >
                            Closed
                        </option>
                    </select>
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has('quotation_detail')"
                        v-text="validationErros.get('quotation_detail')"
                    ></p>
                </div>
                <div class="relative z-0 w-full group col-span-2">
                    <label for="native_name" class="block text-base lg:text-lg">Quotation detail</label>
                    <textarea
                        type="text"
                        name="quotation_detail"
                        id="quotation_detail"
                        class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                        placeholder=" "
                        :value="form.quotation_detail"
                        @input="
                            updateForm('quotation_detail', $event.target.value)
                        "
                        >{{ form.quotation_detail }}</textarea
                    >
                    <p
                        class="mt-2 text-base text-primary"
                        v-if="validationErros.has('quotation_detail')"
                        v-text="validationErros.get('quotation_detail')"
                    ></p>
                </div>
            </div>
            <ListErrors :validationErrors="validationErros" />

            <button type="submit" class="can-edu-btn-fill mb-2">Submit</button>
        </form>
        </div>
    </AppLayout>
</template>

<script>
import ListErrors from '../components/ListErrors.vue';
import { mapState } from "vuex";
export default {
    components:{
    ListErrors
},
    computed: {
        ...mapState({
            form: (state) => state.proxima_requests.form,
            languageCodes: (state) => state.proxima_requests.languageCodes,
            validationErros: (state) => state.proxima_requests.validationErros,
        }),
    },
    methods: {
        updateForm(field, value) {
            this.$store.commit("proxima_requests/setForm", {
                [field]: value,
            });
        },
        addUpdateForm() {
            this.$store
                .dispatch("proxima_requests/addUpdateForm")
                .then(() =>
                    this.$router.push({ name: "admin.proxima_requests.index" })
                );
        },
    },
    created() {
        this.$store.commit("proxima_requests/resetForm");
        if (this.$route.params.id) {
            let id = this.$route.params.id;
            this.$store.commit("proxima_requests/setIsFormEdit", 1);
            this.$store.dispatch("proxima_requests/fetchProximaRequest", {
                id: id,
            });
        }
    },
};
</script>
