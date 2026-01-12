<template>
  <AppLayout>
    <div class="relative shadow-md rounded-lg bg-white py-4">
      <div class="px-4 sm:px-6 lg:px-8">
        <div
          class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center justify-between gap-2 bg-white dark:bg-gray-800">
          <div class="sm:flex-auto">
            <h1 class="can-edu-h1">Stories</h1>
          </div>
          <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <router-link :to="{ name: 'admin.stories.create' }" class="can-edu-btn-fill">
              Add new story
            </router-link>
          </div>
        </div>
        <div
          class="flex flex-col sm:flex-col md:flex-row lg:flex-row items-center justify-between py-4 gap-2 bg-white dark:bg-gray-800">
          <div>
            show
            <select @input="updateLimit($event.target.value)" class="w-20 px-2 py-1 rounded border border-gray-400">
              <option value="10" :selected="limit == '10'">10</option>
              <option value="25" :selected="limit == '25'">25</option>
              <option value="50" :selected="limit == '50'">50</option>
              <option value="100" :selected="limit == '100'">100</option>
            </select>
            stories
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
              <input type="text" id="table-search-stories"
                class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-auto md:w-64 lg:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search for stories" v-model="quickSearch" />
            </form>
          </div>
        </div>
        <div class="md:-mx-4 mt-4 ring-1 ring-gray-300 sm:mx-0 sm:rounded-lg overflow-auto">
          <table class="min-w-full divide-y divide-gray-300 overflow-auto">
            <thead>
              <tr class="divide-x divide-gray-200">
                <th scope="col"
                  class="sticky top-0 z-10 bg-primary backdrop-blur backdrop-filter py-3.5 pl-4 pr-3 text-left text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white sm:pl-6">
                  Name
                </th>
                <th scope="col"
                  class="sticky top-0 z-10 bg-primary backdrop-blur backdrop-filter py-3.5 pl-3 pr-4 sm:pr-6 text-center text-lg lg:text-xl font-FuturaMdCnBT font-medium text-white lg:table-cell">
                  Action
                </th>
              </tr>
            </thead>
            <LoadingTable :loading="loading" columns="2" />
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr class="bg-white divide-x divide-gray-200 hover:bg-gray-50" v-for="story in stories" :key="story.id">
                <td class="relative py-4 pl-4 pr-3 text-base sm:pl-6 flex items-center space-x-2">
                  <img v-if="story.image" class="w-10 h-10 rounded-full" :src="'/' + story.image.path" alt="image" />
                  <div class="font-medium text-gray-900 text-base">
                    {{
                      story.story_detail && story.story_detail[0]
                        ? story.story_detail[0].title
                        : ""
                    }}
                  </div>
                </td>

                <td
                  class="relative py-3.5 pl-3 pr-4 text-center text-sm font-medium sm:pr-6 space-x-2 whitespace-nowrap">
                  <div class="flex items-center gap-2">
                    <router-link :to="{
                      name: 'admin.stories.edit',
                      params: { id: story?.id },
                    }" type="button" data-modal-target="editUserModal" data-modal-show="editUserModal"
                      class="text-gray-500 hover:text-gray-700 cursor-pointer">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                      </svg>
                    </router-link>
                    <a :to="{
                      name: 'admin.stories.edit',
                      params: { id: story.id },
                    }" type="button" data-modal-target="editUserModal" data-modal-show="editUserModal"
                      class="text-red-500 hover:text-red-700 cursor-pointer" @click.prevent="deletestory(story)">
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
                  @click.prevent="fetchStories(pagination.prev_page_url)">
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
                    }" @click.prevent="fetchStoriesByPage(page)">
                    {{ page }}
                  </a>
                </template>

                <a href="#"
                  class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                  :class="{ 'opacity-50 cursor-not-allowed': !pagination.next_page_url }"
                  @click.prevent="fetchStories(pagination.next_page_url)">
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
      limit: (state) => state.stories.limit,
      form: (state) => state.stories.form,
      stories: (state) => state.stories.stories,
      pagination: (state) => state.stories.pagination,
      validationErros: (state) => state.stories.validationErros,
      searchParam: (state) => state.stories.searchParam,
      loading: (state) => state.stories.loading,
    }),
  },
  data() {
    return {
      quickSearch: null,
    };
  },
  methods: {
    fetchStories(page_url) {
      if (!page_url) return;
      const url = new URL(page_url);
      const page = url.searchParams.get("page") || 1;

      this.$router.push({ query: { ...this.$route.query, page } });
      this.$store.dispatch("stories/fetchStories", { url: page_url });
    },
    fetchStoriesByPage(page) {
      const baseUrl = this.pagination.base_url || this.pagination.first_page_url.split("?")[0];
      const queryParams = `?page=${page}`;
      const fullUrl = `${baseUrl}${queryParams}`;
      this.fetchStories(fullUrl);
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
        for (let i = 1; i <= 10; i++) {
          pages.push(i);
        }

        if (totalPages > 12) {
          pages.push("...");
        }

        pages.push(totalPages - 1);
        pages.push(totalPages);
      }

      return pages;
    },
    updateLimit(value) {
      this.$store.commit("stories/setLimit", value);
      this.$store.dispatch("stories/fetchStories");
    },
    deletestory(record) {
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
              .dispatch("stories/deleteStory", {
                id: record.id,
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
            this.$store.dispatch("stories/fetchStories");
          }
        });
    },
    quickSearchFilter: _.debounce(function () {
      this.$store.commit("stories/setSearchParam", this.quickSearch);
      this.$store.dispatch("stories/fetchStories");
    }, 500),
  },
  created() {
    this.$store.commit("stories/setSearchParam", "");
    this.$store.commit("stories/setLimit", 100);
    this.$store.commit("stories/setSortBy", "story_title");
    this.$store.commit("stories/setSortType", "asc");

    const page = this.$route.query.page || 1;
    const baseUrl = process.env.MIX_ADMIN_API_URL + "stories";
    this.fetchStories(`${baseUrl}?page=${page}`);
    // this.$store.dispatch("stories/fetchStories");
  },
  watch: {
    quickSearch: function () {
      this.quickSearchFilter();
    },
  },
};
</script>