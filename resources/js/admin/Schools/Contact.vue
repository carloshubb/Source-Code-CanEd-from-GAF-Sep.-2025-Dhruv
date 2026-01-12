<template>
    <AppLayout>
        <header class="py-4 bg-white">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="can-edu-h1">School conatct</h1>
                    <router-link
                        :to="{ name: 'admin.schools.index' }"
                        class="can-edu-btn-fill"
                    >
                        Back
                    </router-link>
                </div>
            </div>
            <div v-if="$route?.params?.id">
                <other-options type="contact" :id="$route?.params?.id" />
            </div>
        </header>
        <div class="p-5 bg-white dark:bg-gray-800">
            <SchoolContactSetting
                :logged_in_customer="logged_in_customer"
                :school_id="school_id"
            >
            </SchoolContactSetting>
            <div class="px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center justify-between py-4 px-4 gap-4 bg-white dark:bg-gray-800"
                >
                    <div class="sm:flex-auto">
                        <h2 class="can-admin-h2">School Contact</h2>
                    </div>
                    <div class="sm:mt-0 sm:ml-16 sm:flex-none">
                        <button
                            @click="toggleModal"
                            class="mt-4 can-edu-btn-fill"
                        >
                            Add new school contact
                        </button>
                    </div>
                </div>
                <div
                    class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center justify-between py-4 px-4 gap-4 bg-white dark:bg-gray-800"
                >
                    <div>
                        show
                        <select
                            @input="updateLimit($event.target.value)"
                            class="w-20 px-2 py-1 rounded border border-gray-400"
                        >
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        school contacts
                    </div>
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                        >
                            <svg
                                class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="table-search-school_contacts"
                            class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-auto md:w-64 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search for SchoolContacts"
                            v-model="quickSearch"
                        />
                    </div>
                </div>
                <div
                    class="-mx-4 my-4 ring-1 ring-gray-300 sm:mx-0 sm:rounded-lg overflow-auto"
                >
                    <table
                        class="min-w-full divide-y divide-gray-300 overflow-auto mt-0"
                    >
                        <thead>
                            <tr class="divide-x divide-gray-200">
                                <th
                                    scope="col"
                                    class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6"
                                >
                                    Department
                                </th>
                                <th
                                    scope="col"
                                    class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6"
                                >
                                    Address
                                </th>
                                <th
                                    scope="col"
                                    class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6"
                                >
                                    Order
                                </th>
                                <th
                                    scope="col"
                                    class="bg-primary backdrop-blur backdrop-filter py-3.5 pl-3 pr-4 sm:pr-6 text-center text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white lg:table-cell"
                                >
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <LoadingTable :loading="loading" columns="2" />
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr
                                class="bg-white divide-x divide-gray-200 hover:bg-gray-50"
                                v-for="school_contact in school_contacts"
                                :key="school_contact.id"
                            >
                                <td
                                    class="relative py-4 pl-4 pr-3 text-base sm:pl-6"
                                >
                                    <div class="font-medium text-gray-900">
                                        {{
                                            school_contact &&
                                            school_contact.department
                                                ? school_contact.department
                                                : ""
                                        }}
                                    </div>
                                </td>

                                <td
                                    class="relative py-4 pl-4 pr-3 text-base sm:pl-6"
                                >
                                    <div class="font-medium text-gray-900">
                                        {{
                                            school_contact &&
                                            school_contact.address
                                                ? school_contact.address
                                                : ""
                                        }}
                                    </div>
                                </td>
                                <td
                                    class="relative py-4 pl-4 pr-3 text-base sm:pl-6"
                                >
                                    <div class="font-medium text-gray-900">
                                        {{
                                            school_contact &&
                                            school_contact.order
                                                ? school_contact.order
                                                : ""
                                        }}
                                    </div>
                                </td>
                                <td
                                    class="relative py-3.5 pl-3 pr-4 text-right space-y-2 text-sm font-medium sm:pr-6 space-x-2 whitespace-nowrap"
                                >
                                    <a
                                        @click.prevent="
                                            editSchoolContact(school_contact)
                                        "
                                        type="button"
                                        data-modal-target="editUserModal"
                                        data-modal-show="editUserModal"
                                        class="inline-flex items-center bg-primary/5 py-1.5 px-4 text-lg font-FuturaMdCnBT text-primary shadow-sm hover:bg-primary hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 cursor-pointer rounded-full"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="-ml-0.5 w-4 h-4 mr-2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"
                                            />
                                        </svg>
                                        <span>Edit</span>
                                    </a>
                                    <a
                                        type="button"
                                        data-modal-target="editUserModal"
                                        data-modal-show="editUserModal"
                                        class="inline-flex items-center bg-primary/5 py-1.5 px-4 text-lg font-FuturaMdCnBT text-primary shadow-sm hover:bg-primary hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 cursor-pointer rounded-full"
                                        @click.prevent="
                                            deleteSchoolContact(school_contact)
                                        "
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="-ml-0.5 w-4 h-4 mr-2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                                            />
                                        </svg>
                                        <span>Delete</span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div
                        class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
                        v-if="pagination"
                    >
                        <div
                            class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
                        >
                            <div>
                                <p
                                    class="text-sm text-gray-700"
                                    v-if="pagination.current_page"
                                >
                                    Page {{ pagination.current_page }} of
                                    {{ pagination.last_page }}
                                </p>
                            </div>
                            <div>
                                <nav
                                    class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                    aria-label="Pagination"
                                    v-if="
                                        pagination.next_page_url ||
                                        pagination.prev_page_url
                                    "
                                >
                                    <a
                                        href="#"
                                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                        v-bind:class="[
                                            {
                                                disabled:
                                                    !pagination.prev_page_url,
                                            },
                                        ]"
                                        @click="
                                            fetchSchoolContacts(
                                                pagination.prev_page_url
                                            )
                                        "
                                    >
                                        <span class="sr-only">Previous</span>
                                        <svg
                                            class="h-5 w-5"
                                            x-description="Heroicon name: solid/chevron-left"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                clip-rule="evenodd"
                                            ></path>
                                        </svg>
                                    </a>

                                    <a
                                        href="#"
                                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                        v-bind:class="[
                                            {
                                                disabled:
                                                    !pagination.next_page_url,
                                            },
                                        ]"
                                        @click.prevent="
                                            fetchSchoolContacts(
                                                pagination.next_page_url
                                            )
                                        "
                                    >
                                        <span class="sr-only">Next</span>
                                        <svg
                                            class="h-5 w-5"
                                            x-description="Heroicon name: solid/chevron-right"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd"
                                            ></path>
                                        </svg>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <SchoolContactModal
                :logged_in_customer="logged_in_customer"
                :school_id="school_id"
            />
        </div>
    </AppLayout>
</template>
<script>
import _ from "lodash";
import { mapState } from "vuex";
import LoadingTable from "../components/LoadingTable.vue";
import SchoolContactModal from "./SchoolContactModal.vue";
import SchoolContactSetting from "./SchoolContactSetting.vue";
import OtherOptions from './OtherOptions.vue';

export default {
    props: ["logged_in_customer", "school_id"],
    components: {
        LoadingTable,
        SchoolContactModal,
        SchoolContactSetting,
        OtherOptions,
    },
    computed: {
        ...mapState({
            limit: (state) => state.school_contacts.limit,
            form: (state) => state.school_contacts.form,
            school_contacts: (state) => state.school_contacts.school_contacts,
            pagination: (state) => state.school_contacts.pagination,
            validationErros: (state) => state.school_contacts.validationErros,
            searchParam: (state) => state.school_contacts.searchParam,
            loading: (state) => state.school_contacts.loading,
        }),
    },
    data() {
        return {
            quickSearch: null,
        };
    },
    methods: {
        toggleModal() {
            this.$store.commit("school_contacts/setForData", {
                key: "school_id",
                language: "",
                value: this.$route?.params?.id,
            });
            this.$store.commit("school_contacts/setShowModal", 1);
        },
        fetchSchoolContacts(page_url, type) {
            this.$store.dispatch("school_contacts/fetchSchoolContacts", {
                url: page_url,
                type,
            });
        },
        updateLimit(value) {
            this.$store.commit("school_contacts/setLimit", value);
        },
        editSchoolContact(school_contact) {
            this.$store.commit("school_contacts/setForData", {
                key: "school_id",
                language: "",
                value: this.$route?.params?.id,
            });
            this.$store.commit(
                "school_contacts/setSchoolContact",
                school_contact
            );
        },
        deleteSchoolContact(school_contact) {
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
              .dispatch("school_contacts/deleteSchoolContact", {
                id: school_contact.id,
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
            this.$store.dispatch(
              "school_contacts/fetchSchoolContacts",
              { school_id: this.$route.params.id }
          );
          }
        });
    },
        quickSearchFilter: _.debounce(function () {
            this.$store.commit(
                "school_contacts/setSearchParam",
                this.quickSearch
            );
        }, 500),
    },
    created() {
        this.$store.commit("school_contacts/setForData", {
            key: "school_id",
            language: "",
            value: this.$route?.params?.id,
        });
        this.$store.commit("school_contacts/setLimit", 100);
        this.$store.commit("school_contacts/setSortBy", "department");
        this.$store.commit("school_contacts/setSortType", "asc");
        this.$store.dispatch("school_contacts/fetchSchoolContacts", {
            school_id: this.$route?.params?.id,
        });
    },
    watch: {
        quickSearch: function () {
            this.quickSearchFilter();
        },
    },
};
</script>
