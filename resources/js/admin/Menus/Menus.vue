<template>
  <AppLayout>
    <div class="relative shadow-md rounded-lg bg-white py-4">
      <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="can-edu-h1">Menus</h1>
          </div>
          <div class="mt-4 sm:mt-0 sm:ml-16 flex justify-center">
            <router-link :to="{ name: 'admin.menus.create' }" class="block can-edu-btn-fill w-full">
              Add new menu
            </router-link>
          </div>
        </div>
        <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center justify-between py-4 gap-2 bg-white">
          <div>
            show
            <select class="w-20 px-2 py-1 rounded border border-gray-400" @input="updateLimit($event.target.value)">
              <option value="10" :selected="limit == '10'">10</option>
              <option value="25" :selected="limit == '25'">25</option>
              <option value="50" :selected="limit == '50'">50</option>
              <option value="100" :selected="limit == '100'">100</option>
            </select>
            menus
          </div>
          <label for="table-search" class="sr-only">Search</label>
          <div class="relative w-full md:w-auto">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                  clip-rule="evenodd"></path>
              </svg>
            </div>
            <form autocomplete="off" @submit.prevent>
              <input type="text" id="table-search-menus"
                class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-auto md:w-64 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Search for menus" v-model="quickSearch" />
            </form>
          </div>
        </div>
        <div class="container space-y-8 mx-auto">
          <div class="space-y-2">
            <div class="bg-white shadow-lg hover:shadow-xl rounded-md overflow-x-auto">
              <table class="table overflow-x-auto table-auto w-full leading-normal text-base md:text-base lg:text-lg">
                <thead class="text-white">
                  <tr class="table-row">
                    <th
                      class="sticky top-0 z-0 bg-primary backdrop-blur backdrop-filter py-3.5 pl-3 pr-3 text-left font-FuturaMdCnBT text-white lg:text-xl md:text-lg text-lg font-normal">
                      Name
                    </th>
                    <th
                      class="sticky top-0 z-0 bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 font-FuturaMdCnBT text-white sm:pl-6 lg:text-xl md:text-lg text-lg font-normal">
                      Action
                    </th>
                  </tr>
                </thead>
                <tbody class="flex-1 text-gray-700 sm:flex-none" v-if="menus && menus[0]">
                  <tr v-for="menu in menus" :key="menu.id"
                    class="border-t first:border-t-0 p-3 md:p-3 table-row w-full flex-wrap even:bg-gray-50 odd:bg-white">
                    <td class="p-2 md:p-3 relative">
                      <div class="inline-flex items-center">
                        <div class="text-gray-900 flex mt-1 items-center gap-1">
                          <span>{{ menu.name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                          <div>
                            <!-- <label
                                                        class="text-gray-500 font-FuturaMdCnBT md:hidden text-xl"
                                                        for=""
                                                        >Name</label
                                                    > -->
                            <div class="">
                              <span class="ml-2 bg-red-100 text-primary text-xs font-medium mr-2 px-2.5 py-0.5 rounded"
                                v-if="menu.is_main_menu == '1'">Main menu</span>

                              <span class="ml-2 bg-red-100 text-primary text-xs font-medium mr-2 px-2.5 py-0.5 rounded"
                                v-if="menu.is_top_menu == '1'">Top menu</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="relative">
                        <div class="cursor-pointer flex justify-center md:hidden" @click.prevent="actionModal(menu.id)">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                          </svg>
                        </div>
                        <div v-show="showModal && showModalId == menu.id"
                          class="bg-white rounded shadow p-2 absolute right-4 top-7 items-center gap-2 w-max z-10 border border-gray-100 flex md:hidden">
                          <router-link :to="{
                            name: 'admin.menu-builder.edit',
                            params: { id: menu.id },
                          }"
                            class="inline-flex items-center bg-primary/5 py-1 px-2 text-lg font-FuturaMdCnBT text-primary shadow-sm hover:bg-primary hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 cursor-pointer rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                              stroke="currentColor" class="w-4 h-4 mr-1">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            <span class="text-xs">Menu builder</span>
                          </router-link>
                          <router-link :to="{
                            name: 'admin.menus.edit',
                            params: { id: menu.id },
                          }" class="text-gray-500 hover:text-gray-700 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                              stroke="currentColor" class="w-4 md:w-5 h-4 md:h-5">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                          </router-link>
                          <a href="#" class="text-red-500 hover:text-red-700 cursor-pointer"
                            @click.prevent="deleteMenu(menu)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                              stroke="currentColor" class="w-4 md:w-5 h-4 md:h-5">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                          </a>
                        </div>
                      </div>
                      <div class="p-2 md:p-3 gap-2 justify-center items-center hidden md:flex">
                        <router-link :to="{
                          name: 'admin.menu-builder.edit',
                          params: { id: menu.id },
                        }"
                          class="inline-flex items-center bg-primary/5 py-1.5 px-4 text-base lg:text-lg font-FuturaMdCnBT text-primary shadow-sm hover:bg-primary hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 cursor-pointer rounded-full">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="-ml-0.5 w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                          </svg>
                          <span class="whitespace-nowrap">Menu builder</span>
                        </router-link>
                        <router-link :to="{
                          name: 'admin.menus.edit',
                          params: { id: menu.id },
                        }" class="text-gray-500 hover:text-gray-700 cursor-pointer">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                          </svg>
                        </router-link>
                        <a href="#" class="text-red-500 hover:text-red-700 cursor-pointer"
                          @click.prevent="deleteMenu(menu)">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                              d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                          </svg>
                        </a>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="px-4 py-3 flex items-center justify-between sm:px-6" v-if="pagination">
              <div class="flex justify-between items-center w-full">
                <div>
                  <p class="text-sm text-gray-700" v-if="pagination.current_page">
                    Page
                    {{ pagination.current_page }} of
                    {{ pagination.last_page }}
                  </p>
                </div>
                <div>
                  <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination"
                    v-if="pagination.next_page_url || pagination.prev_page_url">
                    <a href="#"
                      class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                      v-bind:class="[
                        {
                          disabled: !pagination.prev_page_url,
                        },
                      ]" @click="fetchMenus(pagination.prev_page_url)">
                      <span class="sr-only">Previous</span>
                      <svg class="h-5 w-5" x-description="Heroicon name: solid/chevron-left"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                          d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                          clip-rule="evenodd"></path>
                      </svg>
                    </a>

                    <a href="#"
                      class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                      v-bind:class="[
                        {
                          disabled: !pagination.next_page_url,
                        },
                      ]" @click.prevent="fetchMenus(pagination.next_page_url)">
                      <span class="sr-only">Next</span>
                      <svg class="h-5 w-5" x-description="Heroicon name: solid/chevron-right"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                          clip-rule="evenodd"></path>
                      </svg>
                    </a>
                  </nav>
                </div>
              </div>
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
      limit: (state) => state.menus.limit,
      form: (state) => state.menus.form,
      menus: (state) => state.menus.menus,
      pagination: (state) => state.menus.pagination,
      validationErros: (state) => state.menus.validationErros,
      searchParam: (state) => state.menus.searchParam,
      loading: (state) => state.menus.loading,
    }),
  },
  data() {
    return {
      quickSearch: null,
      showModalId: null,
      showModal: false,
    };
  },
  methods: {
    fetchMenus(page_url) {
      if (!page_url) return;
      const url = new URL(page_url);
      const page = url.searchParams.get("page") || 1;

      this.$router.push({ query: { ...this.$route.query, page } });
      this.$store.dispatch("menus/fetchMenus", { url: page_url });
    },
    updateLimit(value) {
      this.$store.commit("menus/setLimit", value);
      this.$store.dispatch("menus/fetchMenus");
    },
    deleteMenu(menu) {
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
              .dispatch("menus/deleteMenu", {
                id: menu.id,
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
            this.$store.dispatch("menus/fetchMenus");
          }
        });
    },
    quickSearchFilter: _.debounce(function () {
      this.$store.commit("menus/setSearchParam", this.quickSearch);
      this.$store.dispatch("menus/fetchMenus");
    }, 500),
    actionModal(id) {
      this.showModalId = id;
      this.showModal = !this.showModal;
    },
  },
  created() {
    this.$store.commit("menus/setSearchParam", "");
    this.$store.commit("menus/setLimit", 100);
    this.$store.commit("menus/setSortBy", "name");
    this.$store.commit("menus/setSortType", "asc");
    this.$store.commit("languages/setSearchParam", "");

    const page = this.$route.query.page || 1;
        const baseUrl = process.env.MIX_ADMIN_API_URL + "menus";
        this.fetchMenus(`${baseUrl}?page=${page}`);
    // this.$store.dispatch("menus/fetchMenus");
  },
  watch: {
    quickSearch: function () {
      this.quickSearchFilter();
    },
  },
};
</script>
