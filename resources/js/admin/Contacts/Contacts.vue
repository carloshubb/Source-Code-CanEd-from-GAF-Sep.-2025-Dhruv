<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <div class="px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center justify-between gap-2 bg-white dark:bg-gray-800">
                    <div class="sm:flex-auto">
                        <h1 class="can-edu-h1">Contacts and suggestions</h1>
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
                        Contacts
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
                            <input type="text" id="table-search-Contacts"
                                class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-auto md:w-64 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Search for Contacts" v-model="quickSearch" />
                        </form>
                    </div>
                </div>
                <div class="md:-mx-4 mt-4 ring-1 ring-gray-300 sm:mx-0 sm:rounded-lg overflow-auto">
                    <table class="min-w-full divide-y divide-gray-300 overflow-auto">
                        <thead>
                            <tr class="divide-x divide-gray-200">
                                <th scope="col"
                                    class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6">
                                    Name
                                </th>
                                <th scope="col"
                                    class="bg-primary backdrop-blur backdrop-filter px-3 py-3.5 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white table-cell">
                                    Email
                                </th>
                                <th scope="col"
                                    class="bg-primary backdrop-blur backdrop-filter px-3 py-3.5 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white table-cell">
                                    Message
                                </th>

                                <th scope="col"
                                    class="bg-primary backdrop-blur backdrop-filter px-3 py-3.5 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white table-cell">
                                    Type
                                </th>
                            </tr>
                        </thead>
                        <LoadingTable :loading="loading" columns="4" />
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr class="bg-white divide-x divide-gray-200 hover:bg-gray-50" v-for="contact in contacts"
                                :key="contact.id">
                                <td class="px-3 py-3.5 text-sm text-gray-500 lg:table-cell">
                                    <span class="text-base">
                                        {{ contact.name }}
                                    </span>
                                </td>
                                <td class="px-3 py-3.5 text-sm text-gray-500 lg:table-cell">
                                    <span class="text-base">
                                        {{ contact.email }}
                                    </span>
                                </td>
                                <td class="px-3 py-3.5 text-sm text-gray-500 lg:table-cell">
                                    <span class="text-base">
                                        {{ contact.message }}
                                    </span>
                                </td>
                                <td class="px-3 py-3.5 text-sm text-gray-500 lg:table-cell">
                                    <span class="text-base">
                                        {{ contact.type }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="px-4 py-3 flex items-center justify-between border-gray-200 sm:px-6" v-if="pagination">
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700" v-if="pagination.current_page">
                                Page {{ pagination.current_page }} of
                                {{ pagination.last_page }}
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                aria-label="Pagination" v-if="
                                    pagination.next_page_url ||
                                    pagination.prev_page_url
                                ">
                                <a href="#"
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                    v-bind:class="[
                                        {
                                            disabled:
                                                !pagination.prev_page_url,
                                        },
                                    ]" @click="
                                            fetchContacts(
                                                pagination.prev_page_url
                                            )
                                            ">
                                    <span class="sr-only">Previous</span>
                                    <svg class="h-5 w-5" x-description="Heroicon name: solid/chevron-left"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>

                                <a href="#"
                                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                    v-bind:class="[
                                        {
                                            disabled:
                                                !pagination.next_page_url,
                                        },
                                    ]" @click.prevent="
                                            fetchContacts(
                                                pagination.next_page_url
                                            )
                                            ">
                                    <span class="sr-only">Next</span>
                                    <svg class="h-5 w-5" x-description="Heroicon name: solid/chevron-right"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div> -->
                <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6" v-if="pagination">
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                      <div>
                        <p class="text-sm text-gray-700" v-if="pagination.current_page">
                          Page {{ pagination.current_page }} of {{ pagination.last_page }}
                        </p>
                      </div>
                      <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                          <a href="#"
                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                            :class="{ 'opacity-50 cursor-not-allowed': !pagination.prev_page_url }"
                            @click.prevent="fetchContacts(pagination.prev_page_url)">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                            </svg>
                          </a>
          
                          <template v-for="page in getPageNumbers()" :key="page">
                            <span v-if="page === '...'" class="relative inline-flex items-center px-4 py-2 text-gray-500">
                              {{ page }}
                            </span>
                            <a v-else href="#"
                              class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium hover:bg-gray-50"
                              :class="{
                                'bg-primary text-white': page === pagination.current_page,
                                'bg-white text-gray-700': page !== pagination.current_page
                              }" @click.prevent="fetchContactsByPage(page)">
                              {{ page }}
                            </a>
                          </template>
          
                          <a href="#"
                            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                            :class="{ 'opacity-50 cursor-not-allowed': !pagination.next_page_url }"
                            @click.prevent="fetchContacts(pagination.next_page_url)">
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
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
    </AppLayout>
</template>
<script>
import _ from "lodash";
import { mapState } from "vuex";
import LoadingTable from "../components/LoadingTable.vue";
export default {
    components: {
        LoadingTable,
    },
    computed: {
        ...mapState({
            limit: (state) => state.contacts.limit,
            form: (state) => state.contacts.form,
            contacts: (state) => state.contacts.contacts,
            pagination: (state) => state.contacts.pagination,
            validationErros: (state) => state.contacts.validationErros,
            searchParam: (state) => state.contacts.searchParam,
            loading: (state) => state.contacts.loading,
        }),
    },
    data() {
        return {
            quickSearch: null,
        };
    },
    methods: {
        fetchContacts(page_url) {
            if (!page_url) return;
      const url = new URL(page_url);
      const page = url.searchParams.get("page") || 1;
      this.$router.push({ query: { ...this.$route.query, page } });
            this.$store.dispatch("contacts/fetchContacts", {
                url: page_url,
            });
        },
        fetchContactsByPage(page) {
      const baseUrl = this.pagination.base_url || this.pagination.first_page_url.split("?")[0];
      const queryParams = `?page=${page}`;
      const fullUrl = `${baseUrl}${queryParams}`;
      this.fetchContacts(fullUrl);
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
            this.$store.commit("contacts/setLimit", value);
            this.$store.dispatch("contacts/fetchContacts");
        },
        deleteContact(contact) {
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
                            .dispatch("contacts/deleteContact", {
                                id: contact.id,
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
                        this.$store.dispatch("contacts/fetchContacts");
                    }
                });
        },
        deactiveContact(business, type) {
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
                        this.$store
                            .dispatch("contacts/deactiveContact", {
                                id: business.id,
                                type: type,
                            })
                            .then((res) => {
                                if (res.data.status == "Success") {
                                    this.$store.dispatch(
                                        "contacts/fetchContacts"
                                    );
                                }
                            });
                    }
                });
        },
        quickSearchFilter: _.debounce(function () {
            this.$store.commit("contacts/setSearchParam", this.quickSearch);
            this.$store.dispatch("contacts/fetchContacts");
        }, 500),
    },
    created() {
        this.$store.commit("contacts/setSearchParam", "");
        this.$store.commit("contacts/setLimit", 100);
        this.$store.commit("contacts/setSortBy", "name");
        this.$store.commit("contacts/setSortType", "asc");

        const page = this.$route.query.page || 1;
            const baseUrl = process.env.MIX_ADMIN_API_URL + "contacts";
            this.fetchContacts(`${baseUrl}?page=${page}`);
        // this.$store.dispatch("contacts/fetchContacts");
    },
    watch: {
        quickSearch: function () {
            this.quickSearchFilter();
        },
    },
};
</script>
