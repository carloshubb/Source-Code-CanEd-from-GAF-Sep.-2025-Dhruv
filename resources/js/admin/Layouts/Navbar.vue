<template>
  <header
    class="header-section sticky top-0 z-40 flex justify-between h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8"
  >
    <div class="flex gap-x-4">
      <button
        class="cursor-pointer -m-2.5 p-2.5 text-gray-700 lg:hidden"
        @click.prevent="burgerMenu()"
      >
        <span class="sr-only">Open sidebar</span>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          aria-hidden="true"
          class="h-6 w-6"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
        </svg>
      </button>
      <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true"></div>
      <div class="text-lightpurple font-bold text-lg h-fit">
        <nav class="hidden sm:flex" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <template v-for="(breadcrumb, index) in breadcrumbs">
              <li class="inline-flex items-center" v-if="index == 0">
                <router-link :to="{ name: breadcrumb.routeName }" :disabled="breadcrumb.isCurrentRoute"
                  class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary dark:text-gray-400 dark:hover:text-white">
                  <svg
                    aria-hidden="true"
                    class="w-4 h-4 mr-2"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                    ></path>
                  </svg>
                  {{ breadcrumb.name }}
                </router-link>
              </li>
              <li v-else :aria-current="breadcrumb.isCurrentRoute ? 'page' : ''">
                <div class="flex items-center">
                  <svg
                    aria-hidden="true"
                    class="w-6 h-6 text-gray-400"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                  <router-link
                    :to="{ name: breadcrumb.routeName }"
                    :disabled="breadcrumb.isCurrentRoute"
                    href="#"
                    class="ml-1 text-sm font-medium text-gray-700 hover:text-primary md:ml-2 dark:text-gray-400 dark:hover:text-white"
                  >
                    {{ breadcrumb.name }}</router-link
                  >
                </div>
              </li>
            </template>
          </ol>
        </nav>
      </div>
    </div>

    <div class="flex gap-x-2">
      <div class="rounded-md">
        <div class="flex items-center justify-center">
          <div class="relative inline-block text-left dropdown">
            <a href="#" class="flex items-center">
              <img
                class="h-8 w-8 rounded-full bg-gray-50"
                style="max-width: 35px"
                :src="loggedInUser ? loggedInUser.profile_photo_path : ''"
                alt="profile image"
              />
              <span class="hidden lg:flex lg:items-center"
                ><span
                  class="ml-4 text-sm font-semibold leading-6 text-gray-900"
                  aria-hidden="true"
                  >Proxima Study</span
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                  aria-hidden="true"
                  class="ml-2 h-5 w-5 text-gray-400"
                >
                  <path
                    fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd"
                  ></path></svg></span>
            </a>
            <div
              class="opacity-0 invisible dropdown-menu transition-all duration-300 transform origin-top-right -translate-y-2 scale-95"
            >
              <div
                class="absolute right-0 w-56 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none"
                aria-labelledby="headlessui-menu-button-1"
                id="headlessui-menu-items-117"
                role="menu"
              >
                <div class="px-4 py-3">
                  <p class="text-sm leading-5">Signed in as</p>
                  <p
                    class="text-sm font-medium leading-5 text-gray-900 truncate"
                  >
                    {{ loggedInUser ? loggedInUser.email : "" }}
                  </p>
                </div>
                <div class="py-1">
                  <router-link
                    :to="{ name: 'admin.profile.edit' }"
                    href="javascript:void(0)"
                    tabindex="0"
                    class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                    role="menuitem"
                    :class="
                      $route.name == 'admin.profile.edit'
                        ? 'bg-lightpurple'
                        : ''
                    "
                    >Change password</router-link
                  >
                  <!-- <a href="javascript:void(0)" tabindex="1"
                                        class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                                        role="menuitem">Support</a>
                                    <span role="menuitem" tabindex="-1"
                                        class="flex justify-between w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 cursor-not-allowed opacity-50"
                                        aria-disabled="true">New feature (soon)</span>
                                    <a href="javascript:void(0)" tabindex="2"
                                        class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                                        role="menuitem">License</a> -->
                </div>
                <div class="py-1">
                  <router-link
                    :to="{ name: 'admin.setting.edit' }"
                    href="javascript:void(0)"
                    tabindex="0"
                    class="text-gray-700 flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                    role="menuitem"
                    :class="
                      $route.name == 'admin.profile.edit'
                        ? 'bg-lightpurple'
                        : ''
                    "
                    >General Settings</router-link
                  >
                </div>
                <div class="py-1">
                  <a
                    href="javascript:void(0)"
                    tabindex="3"
                    class="text-red flex justify-between w-full px-4 py-2 text-sm leading-5 text-left"
                    role="menuitem"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    >Sign out</a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>


<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      loggedInUser: (state) => state.auth.loggedInUser,
    }),
  },
  data() {
    return {
      breadcrumbs: [],
    };
  },
  created() {
    this.breadcrumbs = this.$route.meta.breadcrumbs;
    this.$store.dispatch("auth/fetchCurrentUser");
  },
  methods: {
    burgerMenu() {
      this.$store.commit("menu/setIsBurgerMenu");
    },
  },
};
</script>
<style>
.dropdown:focus-within .dropdown-menu {
  opacity: 1;
  transform: translate(0) scale(1);
  visibility: visible;
}
</style>