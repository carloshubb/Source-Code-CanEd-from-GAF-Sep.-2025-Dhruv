<template>
  <div style="overflow: auto" class="sidebar h-screen z-40" :class="isBurgerMenu ? 'open' : ''">
    <div class="text-white mt-2 mr-2 arrow-icon-responsive">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="w-7 h-7 float-right cursor-pointer" @click.prevent="burgerMenu()">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </div>
    <div class="logo-details bg-primary mt-2 md:mt-0">
      <div class="logo_name pointer-events-none py-2">
        <img src="/images/logo.png" class="w-auto h-20" alt="" />
      </div>
    </div>
    <ul class="nav-list" id="accordion-collapse" data-accordion="collapse">
      <li @click="hideBurgerMenu()">
        <router-link :to="{ name: 'admin.dashboard' }"
          class="py-2 hover:border-l-4 border-white flex items-center h-full w-full hover:bg-gradient-to-r from-secondaryRed to-transparent group"
          :class="$route.name == 'admin.dashboard'
            ? 'border-l-4 border-white bg-gradient-to-r from-secondaryRed to-transparent  group'
            : ''
            ">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
          </div>
          <span class="links_name pointer-events-auto opacity-0 text-white text-lg font-FuturaMdCnBT">Dashboard</span>
        </router-link>
      </li>

      <li>
        <button
          class="py-2 px-3 text-white hover:border-l-4 border-white flex items-center h-full text-lg font-FuturaMdCnBT w-full hover:bg-gradient-to-r from-secondaryRed to-transparent group"
          type="button" id="dropdownMenuButton1" @click="toggleMenues('suporting_forms')">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white mr-3">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
            </svg>
          </div>
          <span>Suporting forms</span>

          <span class="ml-2 w-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
              <path fill-rule="evenodd"
                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                clip-rule="evenodd" />
            </svg>
          </span>
        </button>
        <ul class="min-w-64 list-none overflow-hidden rounded-lg border-none p-2 m-2 bg-secondaryRed shadow"
          :class="menuItem == 'suporting_forms' ? '' : 'hidden'">
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.countries.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.countries.index' ||
                $route.name == 'admin.countries.create' ||
                $route.name == 'admin.countries.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Countries Status</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.article_categories.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.article_categories.index' ||
                $route.name == 'admin.article_categories.create' ||
                $route.name == 'admin.article_categories.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Article categories</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.articles.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.articles.index' ||
                $route.name == 'admin.articles.create' ||
                $route.name == 'admin.articles.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Articles</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.suggested-articles.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.suggested-articles.index'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Suggested Articles</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.careers.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.careers.index' ||
                $route.name == 'admin.careers.create' ||
                $route.name == 'admin.careers.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" stroke-width="1.5" stroke="currentColor"
                  class="w-6 h-6 fill-transparent" width="24" height="24" viewBox="0 0 24 24">
                  <path
                    d="M14.172 7.396l1.413-1.39 1.414 1.414-1.414 1.39-1.413-1.414zm2.828 16.604h6v-13h-6v13zm-.559-18.834l1.414 1.414 1.435-1.41-1.415-1.415-1.434 1.411zm.591-3.951l4.771 4.771 1.197-5.986-5.968 1.215zm-8.032 22.785h6v-9h-6v9zm-8 0h6v-6h-6v6zm13.729-14.349l-1.414-1.414-1.45 1.425-3-3.002-7.841 7.797 1.41 1.418 6.427-6.39 2.991 2.993 2.877-2.827z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Careers</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.comunity_services.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.comunity_services.index' ||
                $route.name == 'admin.comunity_services.create' ||
                $route.name == 'admin.comunity_services.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Comunity services</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.degrees.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.degrees.index' ||
                $route.name == 'admin.degrees.create' ||
                $route.name == 'admin.degrees.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Degree levels</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.events.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.events.index' ||
                $route.name == 'admin.events.create' ||
                $route.name == 'admin.events.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Events</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.banners.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.banners.index' ||
                $route.name == 'admin.banners.create' ||
                $route.name == 'admin.banners.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Banners</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.languages.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.languages.index' ||
                $route.name == 'admin.languages.create' ||
                $route.name == 'admin.languages.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                  <path fill-rule="evenodd"
                    d="M9 2.25a.75.75 0 01.75.75v1.506a49.38 49.38 0 015.343.371.75.75 0 11-.186 1.489c-.66-.083-1.323-.151-1.99-.206a18.67 18.67 0 01-2.969 6.323c.317.384.65.753.998 1.107a.75.75 0 11-1.07 1.052A18.902 18.902 0 019 13.687a18.823 18.823 0 01-5.656 4.482.75.75 0 11-.688-1.333 17.323 17.323 0 005.396-4.353A18.72 18.72 0 015.89 8.598a.75.75 0 011.388-.568A17.21 17.21 0 009 11.224a17.17 17.17 0 002.391-5.165 48.038 48.038 0 00-8.298.307.75.75 0 01-.186-1.489 49.159 49.159 0 015.343-.371V3A.75.75 0 019 2.25zM15.75 9a.75.75 0 01.68.433l5.25 11.25a.75.75 0 01-1.36.634l-1.198-2.567h-6.744l-1.198 2.567a.75.75 0 01-1.36-.634l5.25-11.25A.75.75 0 0115.75 9zm-2.672 8.25h5.344l-2.672-5.726-2.672 5.726z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Languages</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.learning_languages.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.learning_languages.index' ||
                $route.name == 'admin.learning_languages.create' ||
                $route.name == 'admin.learning_languages.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                  <path fill-rule="evenodd"
                    d="M9 2.25a.75.75 0 01.75.75v1.506a49.38 49.38 0 015.343.371.75.75 0 11-.186 1.489c-.66-.083-1.323-.151-1.99-.206a18.67 18.67 0 01-2.969 6.323c.317.384.65.753.998 1.107a.75.75 0 11-1.07 1.052A18.902 18.902 0 019 13.687a18.823 18.823 0 01-5.656 4.482.75.75 0 11-.688-1.333 17.323 17.323 0 005.396-4.353A18.72 18.72 0 015.89 8.598a.75.75 0 011.388-.568A17.21 17.21 0 009 11.224a17.17 17.17 0 002.391-5.165 48.038 48.038 0 00-8.298.307.75.75 0 01-.186-1.489 49.159 49.159 0 015.343-.371V3A.75.75 0 019 2.25zM15.75 9a.75.75 0 01.68.433l5.25 11.25a.75.75 0 01-1.36.634l-1.198-2.567h-6.744l-1.198 2.567a.75.75 0 01-1.36-.634l5.25-11.25A.75.75 0 0115.75 9zm-2.672 8.25h5.344l-2.672-5.726-2.672 5.726z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Learning languages</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.menus.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.menus.index' ||
                $route.name == 'admin.menus.create' ||
                $route.name == 'admin.menus.edit'
                ? 'bg-white text-primary'
                : 'text-white '
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Menus</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.messaging_apps.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.messaging_apps.index' ||
                $route.name == 'admin.messaging_apps.create' ||
                $route.name == 'admin.messaging_apps.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Messaging apps</span>
            </router-link>
          </li>

          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.sponsors.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.sponsors.index' ||
                $route.name == 'admin.sponsors.create' ||
                $route.name == 'admin.sponsors.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
</svg> -->
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-cash-coin w-6 h-6" viewBox="0 0 16 16">
                  <path fill-rule="evenodd"
                    d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z" />
                  <path
                    d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z" />
                  <path
                    d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z" />
                  <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Our sponsors</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.teams.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.teams.index' ||
                $route.name == 'admin.teams.create' ||
                $route.name == 'admin.teams.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Our teams</span>
            </router-link>
          </li>

          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.pages.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.pages.index' ||
                $route.name == 'admin.pages.create' ||
                $route.name == 'admin.pages.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Pages</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.programs.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.programs.index' ||
                $route.name == 'admin.programs.create' ||
                $route.name == 'admin.programs.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-calendar4-range h-6 w-6" viewBox="0 0 16 16">
                  <path
                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z" />
                  <path
                    d="M9 7.5a.5.5 0 0 1 .5-.5H15v2H9.5a.5.5 0 0 1-.5-.5v-1zm-2 3v1a.5.5 0 0 1-.5.5H1v-2h5.5a.5.5 0 0 1 .5.5z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Programs</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.programs.bulk.import' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.programs.bulk.import'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m-6 3.75l3 3m0 0l3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Programs bulk
                upload</span>
            </router-link>
          </li>

          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.quotes.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.quotes.index' ||
                $route.name == 'admin.quotes.create' ||
                $route.name == 'admin.quotes.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-chat-square-quote w-6 h-6" viewBox="0 0 16 16">
                  <path
                    d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                  <path
                    d="M7.066 4.76A1.665 1.665 0 0 0 4 5.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 1 0 .6.58c1.486-1.54 1.293-3.214.682-4.112zm4 0A1.665 1.665 0 0 0 8 5.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 1 0 .6.58c1.486-1.54 1.293-3.214.682-4.112z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Quotes</span>
            </router-link>
          </li>
          <!-- <li @click="hideBurgerMenu()">
            <router-link
              :to="{ name: 'admin.curricular_activities.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group"
              :class="
                $route.name == 'admin.curricular_activities.index' ||
                $route.name == 'admin.curricular_activities.create' ||
                $route.name == 'admin.curricular_activities.edit'
                  ? 'bg-white text-primary'
                  : 'text-white'
              "
            >
              <div class="sidebar-links-icon flex justify-center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="ionicon w-6 h-6"
                  viewBox="0 0 512 512"
                >
                  <ellipse
                    cx="256"
                    cy="256"
                    rx="267.57"
                    ry="173.44"
                    transform="rotate(-45 256 256.002)"
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="32"
                  />
                  <path
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="32"
                    d="M334.04 177.96L177.96 334.04M278.3 278.3l-44.6-44.6M322.89 233.7l-44.59-44.59M456.68 211.4L300.6 55.32M211.4 456.68L55.32 300.6M233.7 322.89l-44.59-44.59"
                  />
                </svg>
              </div>
              <span
                class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT"
                >Curricular activities</span
              >
            </router-link>
          </li> -->
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.activities.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.activities.index' ||
                $route.name == 'admin.activities.create' ||
                $route.name == 'admin.activities.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon w-6 h-6" viewBox="0 0 512 512">
                  <ellipse cx="256" cy="256" rx="267.57" ry="173.44" transform="rotate(-45 256 256.002)" fill="none"
                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                  <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M334.04 177.96L177.96 334.04M278.3 278.3l-44.6-44.6M322.89 233.7l-44.59-44.59M456.68 211.4L300.6 55.32M211.4 456.68L55.32 300.6M233.7 322.89l-44.59-44.59" />
                </svg>
                <!-- <svg width="24" height="24" class="w-6 h-6 stroke-white" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M14.183 6.5l3.489 3.487-.707.707-1.038-1.037-1.037 1.037 1.037 1.037-.707.707-1.037-1.037-1.037 1.037 1.037 1.037-.707.707-1.038-1.037-1.037 1.037 1.037 1.036-.707.707-1.037-1.036-1.038 1.037 1.037 1.035-.707.707-3.49-3.486.708-.707 1.037 1.037 1.038-1.037-1.038-1.037.708-.707 1.038 1.037 1.036-1.037-1.037-1.037.707-.707 1.038 1.037 1.037-1.037-1.037-1.036.707-.707 1.038 1.036 1.037-1.036-1.037-1.037.707-.707zm7.642 2.465c-1.708-2.706-4.126-5.139-6.72-6.763 1.977-.354 4.538-.329 5.868 1 .771.769 1.323 2.847.852 5.763m-10.052 12.115c-3.704-1.778-7.218-5.278-8.782-8.744 1.636-4.152 4.943-7.628 9.333-9.344 3.474 1.56 6.986 5.08 8.764 8.788-1.587 4.387-4.903 7.699-9.315 9.3m-8.578-.113c-1.079-1.079-1.457-3.322-1.002-5.869 1.623 2.592 4.058 5.009 6.763 6.718-2.384.384-4.76.15-5.761-.849m19.193-19.179c-1.152-1.153-3.018-1.788-5.251-1.788-4.063 0-8.611 2.021-11.867 5.274-3.518 3.516-5.27 8.082-5.27 11.849 0 2.219.618 4.097 1.78 5.258 1.044 1.044 2.865 1.619 5.128 1.619 3.327 0 8.224-1.341 11.991-5.106 3.327-3.324 5.1-7.936 5.1-11.97 0-2.226-.564-4.091-1.611-5.136"/></svg> -->
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Activities</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.sports.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.sports.index' ||
                $route.name == 'admin.sports.create' ||
                $route.name == 'admin.sports.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon w-6 h-6" viewBox="0 0 512 512">
                  <ellipse cx="256" cy="256" rx="267.57" ry="173.44" transform="rotate(-45 256 256.002)" fill="none"
                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                  <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32"
                    d="M334.04 177.96L177.96 334.04M278.3 278.3l-44.6-44.6M322.89 233.7l-44.59-44.59M456.68 211.4L300.6 55.32M211.4 456.68L55.32 300.6M233.7 322.89l-44.59-44.59" />
                </svg>
                <!-- <svg width="24" height="24" class="w-6 h-6 stroke-white" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M14.183 6.5l3.489 3.487-.707.707-1.038-1.037-1.037 1.037 1.037 1.037-.707.707-1.037-1.037-1.037 1.037 1.037 1.037-.707.707-1.038-1.037-1.037 1.037 1.037 1.036-.707.707-1.037-1.036-1.038 1.037 1.037 1.035-.707.707-3.49-3.486.708-.707 1.037 1.037 1.038-1.037-1.038-1.037.708-.707 1.038 1.037 1.036-1.037-1.037-1.037.707-.707 1.038 1.037 1.037-1.037-1.037-1.036.707-.707 1.038 1.036 1.037-1.036-1.037-1.037.707-.707zm7.642 2.465c-1.708-2.706-4.126-5.139-6.72-6.763 1.977-.354 4.538-.329 5.868 1 .771.769 1.323 2.847.852 5.763m-10.052 12.115c-3.704-1.778-7.218-5.278-8.782-8.744 1.636-4.152 4.943-7.628 9.333-9.344 3.474 1.56 6.986 5.08 8.764 8.788-1.587 4.387-4.903 7.699-9.315 9.3m-8.578-.113c-1.079-1.079-1.457-3.322-1.002-5.869 1.623 2.592 4.058 5.009 6.763 6.718-2.384.384-4.76.15-5.761-.849m19.193-19.179c-1.152-1.153-3.018-1.788-5.251-1.788-4.063 0-8.611 2.021-11.867 5.274-3.518 3.516-5.27 8.082-5.27 11.849 0 2.219.618 4.097 1.78 5.258 1.044 1.044 2.865 1.619 5.128 1.619 3.327 0 8.224-1.341 11.991-5.106 3.327-3.324 5.1-7.936 5.1-11.97 0-2.226-.564-4.091-1.611-5.136"/></svg> -->
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Sports</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.stories.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.stories.index' ||
                $route.name == 'admin.stories.create' ||
                $route.name == 'admin.stories.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Stories</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.tests.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.tests.index' ||
                $route.name == 'admin.tests.create' ||
                $route.name == 'admin.tests.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Tests taken</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.videos.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.videos.index' ||
                $route.name == 'admin.videos.create' ||
                $route.name == 'admin.videos.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-file-play w-6 h-6" viewBox="0 0 16 16">
                  <path
                    d="M6 10.117V5.883a.5.5 0 0 1 .757-.429l3.528 2.117a.5.5 0 0 1 0 .858l-3.528 2.117a.5.5 0 0 1-.757-.43z" />
                  <path
                    d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Videos</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.networks.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.networks.index' ||
                $route.name == 'admin.networks.create' ||
                $route.name == 'admin.networks.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.107 1.107 0 00-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 01-1.652.928l-.679-.906a1.125 1.125 0 00-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 00-8.862 12.872M12.75 3.031a9 9 0 016.69 14.036m0 0l-.177-.529A2.25 2.25 0 0017.128 15H16.5l-.324-.324a1.453 1.453 0 00-2.328.377l-.036.073a1.586 1.586 0 01-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 01-5.276 3.67m0 0a9 9 0 01-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">World wide
                networks</span>
            </router-link>
          </li>
        </ul>
      </li>
      <li>
        <button
          class="py-2 px-3 text-white hover:border-l-4 border-white flex items-center h-full w-full text-lg font-FuturaMdCnBT hover:bg-gradient-to-r from-secondaryRed to-transparent group"
          type="button" id="dropdownMenuButton1" @click="toggleMenues('school')">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white mr-3">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
            </svg>
          </div>
          School
          <span class="ml-2 w-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
              <path fill-rule="evenodd"
                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                clip-rule="evenodd" />
            </svg>
          </span>
        </button>
        <ul class="min-w-64 list-none overflow-hidden rounded-lg border-none p-2 m-2 bg-secondaryRed shadow"
          :class="menuItem == 'school' ? '' : 'hidden'">
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.ambassadors.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.ambassadors.index' ||
                $route.name == 'admin.ambassadors.create' ||
                $route.name == 'admin.ambassadors.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">
                Ambassadors
              </span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.school-programs.bulk.import' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.school-programs.bulk.import'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <!-- <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6 text-white"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z"
                                    />
                                </svg> -->
                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6 fill-transparent" viewBox="0 0 24 22.43">
                  <polyline class="cls-1" points="8.41 18.67 1.62 16.37 1.62 1.49 10.34 4.56 19.46 1.49 19.46 11.16" />
                  <line class="cls-1" x1="10.37" y1="11.06" x2="10.37" y2="4.72" />
                  <line class="cls-1" x1="13.18" y1="7.05" x2="16.65" y2="5.88" />
                  <line class="cls-1" x1="13.18" y1="9.58" x2="16.65" y2="8.41" />
                  <line class="cls-1" x1="7.65" y1="7.05" x2="4.18" y2="5.88" />
                  <line class="cls-1" x1="7.65" y1="9.58" x2="4.18" y2="8.41" />
                  <line class="cls-1" x1="4.18" y1="11.06" x2="6.45" y2="11.79" />
                  <polygon class="cls-1" points="7.21 14.25 14.92 12 22.34 14.25 14.92 16.72 7.21 14.25" />
                  <path class="cls-1" d="m10.37,15.39l.17,5.34,2.44.32c1.43.19,2.87.15,4.29-.1l1.91-.34v-3" />
                  <line class="cls-1" x1="22.34" y1="14.25" x2="22.34" y2="17.07" />
                  <polyline class="cls-1" points="21.92 17.95 22.33 17.22 22.62 17.95" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Bulk import school
                programs</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.schools.bulk.import' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.schools.bulk.import'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Bulk import
                schools</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.master-applications.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.master-applications.index' ||
                $route.name == 'admin.master-applications.create' ||
                $route.name == 'admin.master-applications.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Master
                applications</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.open_days.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.open_days.index' ||
                $route.name == 'admin.open_days.create' ||
                $route.name == 'admin.open_days.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">
                Open house days
              </span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.scholarship.bulk.import' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.scholarship.bulk.import'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Scholarships bulk
                import</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.school_scholarships.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.school_scholarships.index' ||
                $route.name == 'admin.school_scholarships.create' ||
                $route.name == 'admin.school_scholarships.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">School
                scholarships</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.school_types.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.school_types.index' ||
                $route.name == 'admin.school_types.create' ||
                $route.name == 'admin.school_types.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">School types</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.school.types.bulk.import' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.school.types.bulk.import'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">School types bulk
                import</span>
            </router-link>
          </li>

          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.schools.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.schools.index' ||
                $route.name == 'admin.schools.create' ||
                $route.name == 'admin.schools.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Schools</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.virtual_tours.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.virtual_tours.index' ||
                $route.name == 'admin.virtual_tours.create' ||
                $route.name == 'admin.virtual_tours.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Virtual tours</span>
            </router-link>
          </li>
        </ul>
      </li>
      <li>
        <button
          class="py-2 px-3 text-white hover:border-l-4 border-white flex items-center h-full text-lg font-FuturaMdCnBT w-full hover:bg-gradient-to-r from-secondaryRed to-transparent group"
          type="button" id="dropdownMenuButton1" @click="toggleMenues('business')">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white mr-3">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
            </svg>
          </div>
          Business
          <span class="ml-2 w-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
              <path fill-rule="evenodd"
                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                clip-rule="evenodd" />
            </svg>
          </span>
        </button>
        <ul class="min-w-64 list-none overflow-hidden rounded-lg border-none p-2 m-2 bg-secondaryRed shadow"
          :class="menuItem == 'business' ? '' : 'hidden'">
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.business.bulk.import' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.business.bulk.import'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Bulk import
                business</span>
            </router-link>
          </li>

          <!-- <li @click="hideBurgerMenu()">
            <router-link
              :to="{
                name: 'admin.business-categories.bulk.import',
              }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group"
              :class="
                $route.name == 'admin.business-categories.bulk.import'
                  ? 'bg-white text-primary'
                  : 'text-white'
              "
            >
              <div class="sidebar-links-icon flex justify-center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-6 h-6"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z"
                  />
                </svg>
              </div>
              <span
                class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT"
                >Bulk import business categories</span
              >
            </router-link>
          </li> -->
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.business-directories.bulk.import',
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.business-directories.bulk.import'
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Bulk import business
                directories</span>
            </router-link>
          </li>

          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.business.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.business.index'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Business</span>
            </router-link>
          </li>

          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.business_categories.index',
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.business_categories.index' ||
              $route.name == 'admin.business_categories.create' ||
              $route.name == 'admin.business_categories.edit'
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Business
                categories</span>
            </router-link>
          </li>

          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.business_directories.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.business_directories.index' ||
                $route.name == 'admin.business_directories.create' ||
                $route.name == 'admin.business_directories.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Business directory</span>
            </router-link>
          </li>
        </ul>
      </li>
      <li>
        <button
          class="py-2 px-3 text-white hover:border-l-4 border-white flex items-center h-full text-lg font-FuturaMdCnBT w-full hover:bg-gradient-to-r from-secondaryRed to-transparent group"
          type="button" id="dropdownMenuButton1" @click="toggleMenues('settings')">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white mr-3">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
          </div>
          Settings
          <span class="ml-2 w-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
              <path fill-rule="evenodd"
                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                clip-rule="evenodd" />
            </svg>
          </span>
        </button>
        <ul class="min-w-64 list-none overflow-hidden rounded-lg border-none p-2 m-2 bg-secondaryRed shadow"
          :class="menuItem == 'settings' ? '' : 'hidden'">
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'advance_search' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('advance_search') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Advance search
                setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'already_have_school_modal' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('already_have_school_modal') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Already have school modal
                setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'ambassadors' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('ambassadors') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Ambassador setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'ambassador_popup' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('ambassador_popup') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Ambassador popup</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'article_page_setting' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('article_page_setting') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Article page
                setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'become_sponsor_page' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('become_sponsor_page') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Become sponsor page
                setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'business_directory_search' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('business_directory_search') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Business directory search
                page setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'businesses' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('businesses') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Business static
                translations</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'career_page' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('career_page') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Career page static
                translations</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'contact_business' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('contact_business') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Contact business
                setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'contact_school' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('contact_school') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Contact school
                setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.cookie.settings' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.cookie.settings'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Cookies setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'career_create_page' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('career_create_page') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Career create page
                setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.errors.edit' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.errors.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Error handling</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'events' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('events') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Event / Event detail page
                setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'event_create_page' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('event_create_page') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Event create page
                setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'event_popup' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('event_popup') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Event popup</span>
            </router-link>
          </li>


          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.footer.settings' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.footer.settings'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Footer setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'forget_password' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('forget_password') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Forget / Reset password
                page setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'general' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('/general') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">General setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'master_application_pop_up_page' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('master_application_pop_up_page') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Master application pop
                messages text</span>
            </router-link>
          </li>

          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'open_houses' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('open_houses') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Open house setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'open_house_day_popup' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('open_house_day_popup') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Open house popup</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'popup_error_messages' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('popup_error_messages') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">PopUp Validation
                Messages</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'post_article_modal' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('post_article_modal') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Post article modal</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'proximatch' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('proximatch') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Proximatch setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'payment_profile' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('payment_profile') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Profile payment & upgrade
                plan setting</span>
            </router-link>
          </li>

          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'program' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('program') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Program modal
                setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'videoCreate' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('videoCreate') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Create Videos
                setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'quote' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('quote') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Quote setting</span>
            </router-link>
          </li>
          <!-- for career -->


          <!-- for resgistration modal field  -->
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'register_modal_fields_page' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('register_modal_fields_page') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Registration modal fields
                setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{ name: 'admin.registration_packages.index' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.name == 'admin.registration_packages.index' ||
                $route.name == 'admin.registration_packages.create' ||
                $route.name == 'admin.registration_packages.edit'
                ? 'bg-white text-primary'
                : 'text-white'
                ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Registration
                packages</span>
            </router-link>
          </li>

          <!-- for stories modal field  -->
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'story_create_page' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('story_create_page') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Stories create page
                setting</span>
            </router-link>
          </li>






          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'school_search_buttons' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('school_search_buttons') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">School Search Buttons
                Page</span>
            </router-link>
          </li>







          <li @click="hideBurgerMenu()">
            <!-- <router-link
              :to="{ name: 'admin.web-general-setting.edit' }"
              class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group"
              :class="
                $route.name == 'admin.web-general-setting.edit'
                  ? 'bg-white text-primary'
                  : 'text-white'
              "
            >
              <div class="sidebar-links-icon flex justify-center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-6 h-6"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"
                  />
                </svg>
              </div>
              <span
                class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT"
                >LoogedIn modal setting</span
              >
            </router-link> -->
          </li>





          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'scholarship_modal' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('scholarship_modal') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Scholarship advance
                search modal setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'scholarships' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('scholarships') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Scholarship
                setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'scholarship_popup' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('scholarship_popup') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Scholarship popup</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'toaster_messages' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('toaster_messages') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Toaster messages</span>
            </router-link>
          </li>

          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'virtual_tours' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('virtual_tours') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Virtual tour
                setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'virtual_tour_popup' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('virtual_tour_popup') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Virtual tour popup</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'webinar_page' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('webinar_page') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Webinar page
                setting</span>
            </router-link>
          </li>
          <li @click="hideBurgerMenu()">
            <router-link :to="{
              name: 'admin.static-translation.create',
              params: { type: 'network' },
            }" class="hover:bg-white p-1 rounded flex items-center h-full w-full hover:text-primary group" :class="$route.path.indexOf('network') > -1
              ? 'bg-white text-primary'
              : 'text-white'
              ">
              <div class="sidebar-links-icon flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                </svg>
              </div>
              <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">World wide network
                setting</span>
            </router-link>
          </li>
        </ul>
      </li>

      <li @click="hideBurgerMenu()">
        <router-link :to="{ name: 'admin.proxima_requests.index' }"
          class="py-2 hover:border-l-4 border-white flex items-center text-white h-full w-full hover:bg-gradient-to-r from-secondaryRed to-transparent group"
          :class="$route.name == 'admin.proxima_requests.index' ||
            $route.name == 'admin.proxima_requests.create' ||
            $route.name == 'admin.proxima_requests.edit'
            ? 'border-l-4 border-white bg-gradient-to-r from-secondaryRed to-transparent  group'
            : ''
            ">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
            </svg>
          </div>
          <span class="links_name pointer-events-auto opacity-0 text-lg font-FuturaMdCnBT">Proxi Match request</span>
        </router-link>
      </li>

      <li @click="hideBurgerMenu()">
        <router-link :to="{ name: 'admin.customers.index' }"
          class="py-2 hover:border-l-4 border-white flex items-center h-full w-full hover:bg-gradient-to-r from-secondaryRed to-transparent group"
          :class="$route.name == 'admin.customers.index'
            ? 'border-l-4 border-white bg-gradient-to-r from-secondaryRed to-transparent  group'
            : ''
            ">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
            </svg>
          </div>
          <span class="links_name pointer-events-auto opacity-0 text-white text-lg font-FuturaMdCnBT">Web users</span>
        </router-link>
      </li>

      <li @click="hideBurgerMenu()">
        <router-link :to="{ name: 'admin.contacts.index' }"
          class="py-2 hover:border-l-4 border-white flex items-center h-full w-full hover:bg-gradient-to-r from-secondaryRed to-transparent group"
          :class="$route.name == 'admin.contacts.index'
            ? 'border-l-4 border-white bg-gradient-to-r from-secondaryRed to-transparent  group'
            : ''
            ">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
            </svg>
          </div>
          <span class="links_name pointer-events-auto opacity-0 text-white text-lg font-FuturaMdCnBT">Contacts and
            suggestions</span>
        </router-link>
      </li>
      <li @click="hideBurgerMenu()">
        <a href="/sitemap"
          class="py-2 hover:border-l-4 border-white flex items-center h-full w-full hover:bg-gradient-to-r from-secondaryRed to-transparent group"
          :class="$route.name == 'admin.contacts.index'
            ? 'border-l-4 border-white bg-gradient-to-r from-secondaryRed to-transparent  group'
            : ''
            ">
          <div class="sidebar-links-icon flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6 text-white">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
            </svg>
          </div>
          <span class="links_name pointer-events-auto opacity-0 text-white text-lg font-FuturaMdCnBT">Generate
            sitemap</span>
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: mapState({
    isBurgerMenu: (state) => state.menu.isBurgerMenu,
  }),
  data() {
    return {
      menuItem: "",
    };
  },
  methods: {
    burgerMenu() {
      this.$store.commit("menu/setIsBurgerMenu");
    },
    hideBurgerMenu() {
      if (
        navigator.userAgent.match(/Android/i) ||
        navigator.userAgent.match(/webOS/i) ||
        navigator.userAgent.match(/iPhone/i) ||
        navigator.userAgent.match(/iPad/i) ||
        navigator.userAgent.match(/iPod/i) ||
        navigator.userAgent.match(/BlackBerry/i) ||
        navigator.userAgent.match(/Windows Phone/i)
      ) {
        this.burgerMenu();
      }
    },
    toggleMenues(menuItem) {
      if (this.menuItem == menuItem) {
        this.menuItem = "";
      } else {
        this.menuItem = menuItem;
      }
    },
  },
};
</script>
