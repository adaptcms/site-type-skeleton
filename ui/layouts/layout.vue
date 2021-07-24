<template>
  <div id="app" class="app h-screen">
    <nav class="flex items-center justify-between flex-wrap bg-blue-700 py-2 lg:sticky top-0 z-50">
      <div class="container mx-auto flex flex-wrap">
        <div class="flex items-center flex-shrink-0 text-white ml-4 lg:ml-0 lg:mr-6 h-12">
          <Link :href="$route('home')">
            <img class="flex items-center h-12" src="/img/AdaptCMSLogoPNG_2.png" alt="AdaptCMS" />
          </Link>
        </div>
        <div class="block my-auto ml-auto lg:hidden pr-4">
          <button
            class="flex items-center px-3 py-2 border rounded text-white border-white hover:text-white hover:border-white"
            @click.prevent="showMobileMenu = !showMobileMenu"
          >
            <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>

        <div
          class="w-full block flex-grow flex-wrap lg:flex lg:items-center lg:text-right lg:w-auto ml-4 lg:ml-0"
          :class="{ 'hidden': !showMobileMenu }"
        >
          <ul class="text-base lg:flex-grow">
            <li class="block mt-6 lg:inline-block lg:mt-0 text-teal-200 hover:text-white lg:mr-6">
              <Link
                :href="$route('home')" class="hover:text-indigo-300"
                :class="{ 'font-bold text-indigo-300': routeName === 'home' }"
              >
                Home
              </Link>
            </li>

            <li
              v-for="module in modules"
              :key="`module-${module.slug}`"
              class="block mt-2 lg:mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white lg:mr-6"
            >
              <Link
                :href="$route('modules.custom.index', { module: module.route_key })"
                class="hover:text-indigo-300"
                :class="{ 'font-bold text-indigo-300': routeUrl === $route('modules.custom.index', { module: module.route_key }) }"
              >
                {{ module.plural }}
              </Link>
            </li>

            <li
              v-for="page in customPages"
              :key="`page-${page.slug}`"
              class="block mt-2 lg:mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white lg:mr-6"
            >
              <Link
                :href="$route(`pages.show.${page.slug}`)"
                class="hover:text-indigo-300"
                :class="{ 'font-bold text-indigo-300': routeName === `pages.show.${page.slug}` }"
              >
                {{ page.name }}
              </Link>
            </li>

            <li
              v-if="user"
              class="block mt-2 lg:mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white lg:mr-6"
            >
              <Link :href="$route('logout')" class="hover:text-indigo-300">
                Logout
              </Link>
            </li>
          </ul>

          <div v-if="user">
            <Link
              :href="$route('auth.dashboard')"
              class="inline-block px-4 py-2 font-bold leading-none border rounded-full text-black bg-white border-white hover:border-transparent hover:text-white hover:bg-indigo-400 mt-4 lg:mt-0"
            >
              Dashboard
            </Link>
          </div>

          <div v-else>
            <Link
              :href="$route('login')"
              class="inline-block px-4 py-2 font-bold leading-none border rounded-full text-black bg-white border-white hover:border-transparent hover:text-white hover:bg-indigo-400 mt-4 lg:mt-0"
            >
              Login
            </Link>
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
import { computed } from 'vue'
import { usePage, Link } from '@inertiajs/inertia-vue3'
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
    FlashMessage,
    Link
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
    customPages () {
      return this.pages.filter(page => page.slug !== 'home')
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
  },

  setup () {
    const flashMessage = computed(() => usePage().props.value.flash.message)
    const routeName = computed(() => usePage().props.value.route.name)
    const routeUrl = computed(() => usePage().props.value.route.url)
    const routeParams = computed(() => usePage().props.value.route.params)
    const pages = computed(() => usePage().props.value.pages)
    const user = computed(() => usePage().props.value.auth.user)

    return {
      flashMessage,
      routeName,
      routeUrl,
      routeParams,
      pages,
      user
    }
  }
}
</script>
