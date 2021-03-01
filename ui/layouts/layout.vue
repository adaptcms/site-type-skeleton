<template>
  <div id="app" class="app h-screen">
    <nav class="flex items-center justify-between flex-wrap bg-blue-700 py-2 lg:sticky top-0 z-50">
      <div class="container mx-auto flex flex-wrap">
        <div class="flex items-center flex-shrink-0 text-white ml-4 lg:ml-0 lg:mr-6 h-12">
          <inertia-link :href="$route('home')">
            <img class="flex items-center h-12" src="/img/AdaptCMSLogoPNG_2.png" alt="AdaptCMS" />
          </inertia-link>
        </div>
        <div class="block my-auto ml-auto lg:hidden pr-4">
          <button
            class="flex items-center px-3 py-2 border rounded text-white border-white hover:text-white hover:border-white"
            @click.prevent="showMobileMenu = !showMobileMenu"
          >
            <i class="fas fa-bars fa-lg" />
          </button>
        </div>

        <div
          class="w-full block flex-grow flex-wrap lg:flex lg:items-center lg:text-right lg:w-auto ml-4 lg:ml-0"
          :class="{ 'hidden': !showMobileMenu }"
        >
          <ul class="text-base lg:flex-grow">
            <li class="block mt-6 lg:inline-block lg:mt-0 text-teal-200 hover:text-white lg:mr-6">
              <inertia-link
                :href="$route('home')" class="hover:text-indigo-300"
                :class="{ 'font-bold text-indigo-300': routeName === 'home' }"
              >
                Home
              </inertia-link>
            </li>

            <li
              v-for="module in modules"
              :key="`module-${module.slug}`"
              class="block mt-2 lg:mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white lg:mr-6"
            >
              <inertia-link
                :href="$route('modules.custom.index', { module: module.route_key })"
                class="hover:text-indigo-300"
                :class="{ 'font-bold text-indigo-300': routeUrl === $route('modules.custom.index', { module: module.route_key }) }"
              >
                {{ module.plural }}
              </inertia-link>
            </li>

            <li
              v-for="page in customPages"
              :key="`page-${page.slug}`"
              class="block mt-2 lg:mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white lg:mr-6"
            >
              <inertia-link
                :href="$route(`pages.show.${page.slug}`)"
                class="hover:text-indigo-300"
                :class="{ 'font-bold text-indigo-300': routeName === `pages.show.${page.slug}` }"
              >
                {{ page.name }}
              </inertia-link>
            </li>

            <li
              v-if="user"
              class="block mt-2 lg:mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white lg:mr-6"
            >
              <inertia-link :href="$route('logout')" class="hover:text-indigo-300">
                Logout
              </inertia-link>
            </li>
          </ul>

          <div v-if="user">
            <inertia-link
              :href="$route('auth.dashboard')"
              class="inline-block px-4 py-2 font-bold leading-none border rounded-full text-black bg-white border-white hover:border-transparent hover:text-white hover:bg-indigo-400 mt-4 lg:mt-0"
            >
              Dashboard
            </inertia-link>
          </div>

          <div v-else>
            <inertia-link
              :href="$route('login')"
              class="inline-block px-4 py-2 font-bold leading-none border rounded-full text-black bg-white border-white hover:border-transparent hover:text-white hover:bg-indigo-400 mt-4 lg:mt-0"
            >
              Login
            </inertia-link>
          </div>
        </div>
      </div>
    </nav>

    <div class="content h-auto py-6 container mx-auto px-4 md:px-0">
      <slot />

      <FlashMessage :message="flashMessage" />
    </div>

    <div class="top-divider w-full"></div>

    <footer class="bg-black pt-8 pb-12 w-full bottom-0">
      <div class="container mx-auto">
        <div class="w-full h-auto text-center pt-5">
          <!-- <p class="mb-5 text-xs text-gray-100">
            <a href="#">Privacy Policy</a> | <a href="#">Terms and Conditions</a>
          </p> -->
          <p class="text-xs text-gray-100">
            &copy; Copyright 2021 <a href="https://www.adaptcms.com" class="font-bold" target="_blank" rel="noopener">AdaptCMS</a>.
            All Rights Reserved.
          </p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import { get } from 'lodash'
import FlashMessage from '@/Adaptcms/Base/ui/components/FlashMessage'
import FlashMessageMixin from '@/Adaptcms/Base/ui/mixins/FlashMessageMixin'

export default {
  props: {
    title: String
  },

  mixins: [
    FlashMessageMixin
  ],

  components: {
    FlashMessage
  },

  watch: {
    routeUrl (newVal, oldVal) {
      if (newVal !== oldVal) {
        if (this.showMobileMenu) {
          this.showMobileMenu = false
        }
      }
    }
  },

  computed: {
    user () {
      return get(this.$page, 'props.auth.user', null)
    },

    pages () {
      return get(this.$page, 'props.pages', null)
    },

    customPages () {
      return this.pages.filter(page => page.slug !== 'home')
    },

    routeName () {
      return get(this.$page, 'props.route.name', null)
    },

    routeUrl () {
      return get(this.$page, 'props.route.url', null)
    }
  },

  data () {
    return {
      errors: {},
      notification: {
        enabled: false,
        type: 'success',
        message: null
      },
      showMobileMenu: false
    }
  },

  methods: {
    //
  }
}
</script>
