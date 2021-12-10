<template>
  <div class="bg-cool-gray-100">
    <portal-target name="dropdown" slim />
    <div class="md:flex md:flex-col">
      <div class="md:h-screen md:flex md:flex-col" @click="hideDropdownMenus">
        <div class="md:flex md:flex-shrink-0">
          <div class="bg-cool-gray-300 md:flex-shrink-0 md:w-64 px-6 py-4 flex items-center justify-between md:justify-center">
            <inertia-link class="mt-1" href="/">
              <logo class="fill-black" width="120" height="28" />
            </inertia-link>
            <dropdown class="md:hidden" placement="bottom-end" :auto-close="false">
              <svg class="fill-black w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
              <div slot="dropdown" class="block bg-white shadow-xl rounded flex-shrink-0 w-64 p-4 overflow-y-auto transition-250 z-30">
                <main-menu :url="url()" />
              </div>
            </dropdown>
          </div>
          <div class="bg-cool-gray-300 w-full p-4 md:py-0 md:px-12 text-sm md:text-md flex justify-between items-center">
            <dropdown class="mt-1 ml-auto" placement="bottom-end">
              <div class="flex items-center cursor-pointer select-none group">
                <div class="text-gray-700 group-hover:text-indigo-600 focus:text-indigo-600 mr-1 whitespace-no-wrap">
                  <span>{{ $page.props.auth.user.first_name }}</span>
                  <span class="hidden md:inline">{{ $page.props.auth.user.last_name }}</span>
                </div>
                <icon class="w-5 h-5 group-hover:fill-indigo-600 fill-gray-700 focus:fill-indigo-600" name="cheveron-down" />
              </div>
              <div slot="dropdown" class="mt-2 py-2 shadow-xl bg-white rounded text-sm">
                <inertia-link v-if="$page.props.auth.user.owner" class="block px-6 py-2 hover:bg-indigo-500 hover:text-white" :href="route('users.edit', $page.props.auth.user.id)">My Profile</inertia-link>
                <inertia-link v-if="$page.props.auth.user.owner" class="block px-6 py-2 hover:bg-indigo-500 hover:text-white" :href="route('users')">Manage Users</inertia-link>
                <button class="block px-6 py-2 hover:bg-indigo-500 hover:text-white w-full text-left rounded-none" @click="logout">Logout</button>
              </div>
            </dropdown>
          </div>
        </div>
        <div class="md:flex md:flex-grow md:overflow-hidden ">
          <main-menu :url="url()" class="hidden md:block bg-white flex-shrink-0 w-64 p-3 overflow-y-auto transition-250 shadow-lg" />
          <div class="md:flex-1 px-4 py-8 md:p-12 md:overflow-y-auto" scroll-region>
            <flash-messages />
            <transition name="page" mode="out-in">
              <slot />
            </transition>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Dropdown from '@/Shared/Dropdown'
import FlashMessages from '@/Shared/FlashMessages'
import Icon from '@/Shared/Icon'
import Logo from '@/Shared/Logo'
import MainMenu from '@/Shared/MainMenu'

export default {
  components: {
    Dropdown,
    FlashMessages,
    Icon,
    Logo,
    MainMenu,
  },
  data() {
    return {
      showUserMenu: false,
      accounts: null,
    }
  },
  methods: {
    logout(){
      this.$inertia.post(this.route('logout'))
    },
    url() {
      return location.pathname.substr(1)
    },
    hideDropdownMenus() {
      this.showUserMenu = !this.showUserMenu
    },
    toggleSideMenu() {
      console.log('irvan')
      this.isSideMenuOpen = !this.isSideMenuOpen
    },

  },
}
</script>
