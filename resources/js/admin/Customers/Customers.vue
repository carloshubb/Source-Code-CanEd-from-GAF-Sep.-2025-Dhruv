<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <div class="px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center justify-between gap-2 bg-white dark:bg-gray-800">
                    <div class="sm:flex-auto">
                        <h1 class="can-edu-h1">Customers</h1>
                    </div>

                </div>
                <div
                    class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center justify-between py-4 gap-2 bg-white dark:bg-gray-800">
                    <div>
                        show
                        <select @input="updateLimit($event.target.value)"
                            class="w-20 px-2 py-1 rounded border border-gray-400">
                            <option value="10" :selected="limit == '10'">10</option>
                            <option value="25" :selected="limit == '25'">25</option>
                            <option value="50" :selected="limit == '50'">50</option>
                            <option value="100" :selected="limit == '100'">100</option>
                        </select>
                        Customers
                    </div>
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <form autocomplete="off" @submit.prevent>
                            <input type="text" id="table-search-Customers"
                                class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-auto md:w-64 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Search for Customers" v-model="quickSearch" />
                        </form>
                    </div>
                </div>
                <div class="md:-mx-4 mt-4 ring-1 ring-gray-300 sm:mx-0 sm:rounded-lg overflow-auto">
                    <table class="min-w-full divide-y divide-gray-300 overflow-auto">
                        <thead>
                            <tr class="divide-x divide-gray-200">
                                <th scope="col"
                                    class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6">
                                    Name</th>
                                <th scope="col"
                                    class="bg-primary backdrop-blur backdrop-filter px-3 py-3.5 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white table-cell">
                                    Email</th>
                                <th scope="col"
                                    class="bg-primary backdrop-blur backdrop-filter px-3 py-3.5 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white table-cell">
                                    Type</th>
                                <th scope="col"
                                    class="bg-primary backdrop-blur backdrop-filter px-3 py-3.5 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white table-cell">
                                    Status</th>
                                <th scope="col"
                                    class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-3 pr-4 sm:pr-6 text-center text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white lg:table-cell">
                                    Action</th>
                                <th scope="col"
                                    class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-3 pr-4 sm:pr-6 text-center text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white lg:table-cell">
                                    Send email</th>
                            </tr>
                        </thead>
                        <LoadingTable :loading="loading" columns="4" />
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr class="bg-white divide-x divide-gray-200 hover:bg-gray-50" v-for="customer in customers"
                                :key="customer.id">
                                <td class="px-3 py-3.5 text-sm text-gray-500 table-cell">
                                    <span class="text-base">{{ customer.first_name }} {{ customer.last_name }}</span>
                                </td>
                                <td class="px-3 py-3.5 text-sm text-gray-500 table-cell">
                                    <span class="text-base">{{ customer.email }}</span>
                                </td>
                                <td class="px-3 py-3.5 text-sm text-gray-500 table-cell">
                                    <span class="text-base">{{ customer.user_type }}</span>
                                </td>
                                <td class="p-4">
                                    <SwitchGroup as="div" class="flex items-center">
                                        <Switch @click="
                                            deactiveCustomer(
                                                customer,
                                                customer.deactive_account == 0 ? 1 : 0
                                            )
                                            " :class="[
                                                customer.deactive_account == 0
                                                    ? 'bg-primary'
                                                    : 'bg-gray-200',
                                                'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2',
                                            ]">
                                            <span aria-hidden="true" :class="[
                                                customer.deactive_account == 0
                                                    ? 'translate-x-5'
                                                    : 'translate-x-0',
                                                'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                                            ]" />
                                        </Switch>
                                        <SwitchLabel as="span" class="ml-3 text-sm">
                                            <span class="font-medium text-gray-900">{{
                                                customer.deactive_account == 1
                                                    ? "Inactive"
                                                    : "Active"
                                            }}</span>
                                            {{ " " }}
                                        </SwitchLabel>
                                    </SwitchGroup>
                                </td>
                                <td
                                    class="relative py-3.5 pl-3 pr-4 text-center text-sm font-medium sm:pr-6 space-x-2 whitespace-nowrap">
                                    <a :to="{ name: 'admin.customers.edit', params: { id: customer.id } }" type="button"
                                        data-modal-target="editUserModal" data-modal-show="editUserModal"
                                        class="text-red-500 hover:text-red-700 cursor-pointer"
                                        @click.prevent="deleteCustomer(customer)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </a>
                                </td>
                                <!-- <td class="relative py-3.5 pl-3 pr-4 text-center text-sm font-medium sm:pr-6 space-x-2 whitespace-nowrap">
                                    <button v-if="customer.user_type === 'school'" class="can-edu-btn-fill" @click="sendCredentialsEmail(customer.id)">
                                      Send email
                                    </button>
                                  </td> -->
                                  <td v-if="customer.user_type === 'school'" class="relative py-3.5 pl-3 pr-4 text-center text-sm font-medium sm:pr-6 space-x-2 whitespace-nowrap">
                                    <button class="can-edu-btn-fill" @click="sendCredentialsEmail(customer.id)">
                                      Send email
                                    </button>
                                  </td>
                                  
                                  <!-- For business -->
                                  <td v-else-if="customer.user_type === 'business'" class="relative py-3.5 pl-3 pr-4 text-center text-sm font-medium sm:pr-6 space-x-2 whitespace-nowrap">
                                    <button class="can-edu-btn-fill" @click="sendCredentialsBusinessEmail(customer.id)">
                                      Send email
                                    </button>
                                  </td>
                                  
                                  <!-- For others -->
                                  <td v-else class="relative py-3.5 pl-3 pr-4 text-center text-sm font-medium sm:pr-6 space-x-2 whitespace-nowrap">
                                  </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
                    v-if="pagination">
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700" v-if="pagination.current_page">
                                Page {{ pagination.current_page }} of {{ pagination.last_page }}
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                aria-label="Pagination">
                                <a href="#"
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                    :class="{ 'opacity-50 cursor-not-allowed': !pagination.prev_page_url }"
                                    @click.prevent="fetchCustomers(pagination.prev_page_url)">
                                    <span class="sr-only">Previous</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>

                                <template v-for="page in getPageNumbers()" :key="page">
                                    <span v-if="page === '...'"
                                        class="relative inline-flex items-center px-4 py-2 text-gray-500">
                                        {{ page }}
                                    </span>
                                    <a v-else href="#"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium hover:bg-gray-50"
                                        :class="{
                                            'bg-primary text-white': page === pagination.current_page,
                                            'bg-white text-gray-700': page !== pagination.current_page
                                        }" @click.prevent="fetchCustomersByPage(page)">
                                        {{ page }}
                                    </a>
                                </template>

                                <a href="#"
                                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                    :class="{ 'opacity-50 cursor-not-allowed': !pagination.next_page_url }"
                                    @click.prevent="fetchCustomers(pagination.next_page_url)">
                                    <span class="sr-only">Next</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4-4a1 1 0 01-1.414-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <transition name="slide">
            <div
              id="defaultModal"
              tabindex="-1"
              aria-hidden="true"
              class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full"
              v-if="showModal"
              @click="closeModalOnOutsideClick"
              ref="modalBackground"
            >
              <div
                class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                ref="elementToDetectClick"
              >
                <div>
                  <!-- Close Button (Cross SVG) -->
                  <div class="absolute top-3 right-3 cursor-pointer" @click="toggleModal">
                    <button
                      type="button"
                      class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                      data-modal-hide="defaultModal"
                    >
                      <svg
                        aria-hidden="true"
                        class="w-4 h-4 text-primary"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                          clip-rule="evenodd"
                        ></path>
                      </svg>
                    </button>
                  </div>
      
                  <!-- Modal Content -->
                  <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10">
                    <p class="text-center can-edu-p mt-2">
                      {{ modalMessage }} <!-- Display the dynamic message -->
                    </p>
                    <div class="flex justify-center">
                      <button
                        type="button"
                        class="can-edu-btn-fill whitespace-nowrap px-2.5 md:px-5 mt-4"
                        @click="toggleModal"
                      >
                        Close
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </transition>
    </AppLayout>
</template>
<script>
import _ from "lodash";
import { mapState } from "vuex";
import LoadingTable from "../components/LoadingTable.vue";
import { Switch, SwitchGroup, SwitchLabel } from "@headlessui/vue";

export default {
    components: {
        LoadingTable, Switch, SwitchGroup, SwitchLabel,
    },
    computed: {
        sortedCustomers() {
            return this.customers.sort((a, b) => a.user_type.localeCompare(b.user_type));
        },
        ...mapState({
            limit: (state) => state.customers.limit,
            form: (state) => state.customers.form,
            customers: (state) => state.customers.customers,
            pagination: (state) => state.customers.pagination,
            validationErros: (state) => state.customers.validationErros,
            searchParam: (state) => state.customers.searchParam,
            loading: (state) => state.customers.loading,
        }),
    },
    data() {
        return {
            quickSearch: null,
            showModal: false, // Controls the visibility of the modal
            modalMessage: "",
        };
    },
    methods: {
        async sendCredentialsEmail(customerId) {
      try {
        const apiUrl =
          process.env.MIX_ADMIN_API_URL + "send-credentials-email/" + customerId;
        const response = await axios.post(apiUrl);

        if (response?.data?.status === "Success") {
          this.modalMessage = response?.data?.message || "Credentials email sent successfully.";
          this.showModal = true; // Show the modal on success
        } else {
          this.modalMessage = response?.data?.message || "Failed to send email.";
          this.showModal = true; // Show the modal on failure
        }
      } catch (error) {
        console.error("Error sending email:", error);
        this.modalMessage = "Failed to send email.";
        this.showModal = true; // Show the modal on error
      }
    },
        async sendCredentialsBusinessEmail(customerId) {
      try {
        const apiUrl =
          process.env.MIX_ADMIN_API_URL + "send-business-credentials-email/" + customerId;
        const response = await axios.post(apiUrl);

        if (response?.data?.status === "Success") {
          this.modalMessage = response?.data?.message || "Credentials email sent successfully.";
          this.showModal = true; // Show the modal on success
        } else {
          this.modalMessage = response?.data?.message || "Failed to send email.";
          this.showModal = true; // Show the modal on failure
        }
      } catch (error) {
        console.error("Error sending email:", error);
        this.modalMessage = "Failed to send email.";
        this.showModal = true; // Show the modal on error
      }
    },
      toggleModal() {
      this.showModal = !this.showModal; // Toggle modal visibility
    },
    closeModalOnOutsideClick(event) {
      // Close modal if clicking outside the modal content
      if (event.target === this.$refs.modalBackground) {
        this.showModal = false;
      }
    },
        fetchCustomers(page_url) {
            if (!page_url) return;
      const url = new URL(page_url);
      const page = url.searchParams.get("page") || 1;

      this.$router.push({ query: { ...this.$route.query, page } });
            this.$store.dispatch("customers/fetchCustomers", { url: page_url });
        },
        fetchCustomersByPage(page) {
            const baseUrl = this.pagination.base_url || this.pagination.first_page_url.split("?")[0];
            const queryParams = `?page=${page}`;
            const fullUrl = `${baseUrl}${queryParams}`;
            this.fetchCustomers(fullUrl);
        },
        getPageNumbers() {
            const pages = [];
            const totalPages = this.pagination.last_page || 1;
            const currentPage = this.pagination.current_page || 1;

            if (totalPages <= 12) {
                for (let i = 1; i <= totalPages; i++) {
                    pages.push(i);
                }
            } else {
                pages.push(1, 2);

                if (currentPage >= 10) {
                    pages.push("...");
                    pages.push(currentPage - 1, currentPage, currentPage + 1);
                    pages.push("...");
                }
                else if (currentPage > 10 && currentPage < totalPages - 3) {
                    pages.push("...");
                    pages.push(currentPage - 1, currentPage, currentPage + 1);
                    pages.push("...");
                } else if (currentPage <= 10) {
                    for (let i = 3; i <= 10; i++) {
                        pages.push(i);
                    }
                    pages.push("...");
                }

                pages.push(totalPages - 1, totalPages);
            }

            return pages;
        },
        updateLimit(value) {
            this.$store.commit("customers/setLimit", value);
            this.$store.dispatch("customers/fetchCustomers");
        },
        deleteCustomer(customer) {
            this.$swal
                .fire({
                    title: "Enter Password",
                    input: "password",
                    inputAttributes: {
                        autocapitalize: "off",
                        required: true,
                    },
                    showCancelButton: true,
                    confirmButtonText: "Submit",
                    showLoaderOnConfirm: true,
                    preConfirm: (password) => {
                        return this.$store
                            .dispatch("customers/deleteCustomer", {
                                id: customer.id,
                                password: password,
                            })
                            .then((res) => {
                                if (res.data.status !== "Success") {
                                    this.$swal.showValidationMessage(
                                        `Request failed: ${res.data.message}`
                                    );
                                }
                                return res;
                            })
                            .catch((error) => {
                                // Show validation message on error
                                if (error.response && error.response.status === 403) {
                                    this.$swal.showValidationMessage(
                                        "Incorrect password. Please try again."
                                    );
                                } else {
                                    this.$swal.showValidationMessage(
                                        `Request failed: ${error.message}`
                                    );
                                }
                            });
                    },
                    allowOutsideClick: () => !this.$swal.isLoading(),
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        helper.swalSuccessMessage(result?.value?.data?.message || "");
                        this.$store.dispatch("customers/fetchCustomers");
                    }
                });
        },
        deactiveCustomer(business, type) {
            this.$swal
                .fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, continue!",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        this.$store.dispatch("customers/deactiveCustomer", {
                            id: business.id,
                            type: type,
                        })
                            .then((res) => {
                                if (res.data.status == 'Success') {
                                    this.$store.dispatch("customers/fetchCustomers");
                                }
                            });
                    }
                });
        },
        quickSearchFilter: _.debounce(function () {
            this.$store.commit("customers/setSearchParam", this.quickSearch);
            this.$store.dispatch("customers/fetchCustomers");
        }, 500),
    },
    created() {
        this.$store.commit("customers/setSearchParam", "");
        this.$store.commit("customers/setLimit", 100);
        this.$store.commit("customers/setSortBy", "first_name");
        this.$store.commit("customers/setSortType", "asc");
        const page = this.$route.query.page || 1;
    const baseUrl = process.env.MIX_ADMIN_API_URL + "customers";
    this.fetchCustomers(`${baseUrl}?page=${page}`);
        // this.$store.dispatch("customers/fetchCustomers");
    },
    watch: {
        quickSearch: function () {
            this.quickSearchFilter();
        },
    },
};
</script>
<style scoped>
.slide-enter-active,
.slide-leave-active {
  transition: opacity 0.3s, transform 0.3s;
}

.slide-enter-from,
.slide-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}
</style>